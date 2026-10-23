<?php
/**
 * SaaS Registration, Validation, Pending Order & Provisioning API (subscribe_api.php)
 * Adapted from referance-project/subscribe_api.php for the Multi-Template E-Commerce SaaS Platform.
 */
require_once __DIR__ . '/saas_core.php';

header('Content-Type: application/json; charset=utf-8');

$pdo = get_saas_pdo();
$action = $_POST['action'] ?? $_GET['action'] ?? '';

function api_json($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

// 1. Check Duplicate Email / Phone / Store Slug
if ($action === 'check_unique') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $phone = trim($_POST['phone'] ?? '');
    $slug  = sanitize_store_slug($_POST['store_slug'] ?? '');

    if ($email !== '') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            api_json(['valid' => false, 'field' => 'email', 'message' => 'Please enter a valid email address.']);
        }
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `saas_tenants` WHERE LOWER(`admin_email`) = ? OR LOWER(`business_email`) = ?");
        $stmt->execute([$email, $email]);
        if ((int)$stmt->fetchColumn() > 0) {
            api_json(['valid' => false, 'field' => 'email', 'message' => 'An account or store with this email already exists.']);
        }
        $stmt2 = $pdo->prepare("SELECT COUNT(*) FROM `admins` WHERE LOWER(`email`) = ?");
        $stmt2->execute([$email]);
        if ((int)$stmt2->fetchColumn() > 0) {
            api_json(['valid' => false, 'field' => 'email', 'message' => 'This email is already registered as a store administrator.']);
        }
    }

    if ($slug !== '') {
        if (strlen($slug) < 3) {
            api_json(['valid' => false, 'field' => 'store_slug', 'message' => 'Store slug must be at least 3 characters.']);
        }
        if (is_reserved_store_slug($slug)) {
            api_json(['valid' => false, 'field' => 'store_slug', 'message' => 'This store slug is reserved by the platform. Please choose another.']);
        }
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `saas_tenants` WHERE LOWER(`slug`) = ? OR LOWER(`domain`) = ?");
        $stmt->execute([$slug, $slug . '.com']);
        if ((int)$stmt->fetchColumn() > 0) {
            api_json(['valid' => false, 'field' => 'store_slug', 'message' => 'This store slug is already taken. Try another name.']);
        }
    }

    api_json([
        'valid'     => true,
        'slug'      => $slug,
        'store_url' => $slug ? saas_base_url('website/s/' . $slug) : '',
    ]);
}

// 2. Register Owner Details & Send Verification OTP (Does NOT activate subscription)
if ($action === 'register_step') {
    $ownerName   = trim($_POST['owner_name'] ?? '');
    $storeName   = trim($_POST['business_name'] ?? '');
    $storeSlug   = sanitize_store_slug($_POST['store_slug'] ?? $storeName);
    $email       = strtolower(trim($_POST['email'] ?? ''));
    $phone       = trim($_POST['phone'] ?? '');
    $password    = $_POST['password'] ?? '';
    $confirmPass = $_POST['password_confirm'] ?? '';
    $address     = trim($_POST['business_address'] ?? '');
    $currency    = strtoupper(trim($_POST['currency_code'] ?? 'USD'));
    $planId      = (int)($_POST['plan_id'] ?? 1);

    if ($ownerName === '' || strlen($ownerName) < 2) {
        api_json(['success' => false, 'message' => 'Owner full name is required.']);
    }
    if ($storeName === '' || strlen($storeName) < 2) {
        api_json(['success' => false, 'message' => 'Business / Store name is required.']);
    }
    if ($storeSlug === '' || strlen($storeSlug) < 3 || is_reserved_store_slug($storeSlug)) {
        api_json(['success' => false, 'message' => 'Please enter a valid, unreserved store slug (minimum 3 characters).']);
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        api_json(['success' => false, 'message' => 'Please provide a valid email address.']);
    }
    if ($phone === '' || strlen($phone) < 6) {
        api_json(['success' => false, 'message' => 'Please provide a valid phone number.']);
    }
    if (strlen($password) < 6) {
        api_json(['success' => false, 'message' => 'Password must be at least 6 characters long.']);
    }
    if ($password !== $confirmPass) {
        api_json(['success' => false, 'message' => 'Password and confirmation password do not match.']);
    }

    // Check duplicate email
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM `saas_tenants` WHERE LOWER(`admin_email`) = ?");
    $stmt->execute([$email]);
    if ((int)$stmt->fetchColumn() > 0) {
        api_json(['success' => false, 'message' => 'A tenant store is already registered with this email address.']);
    }
    $stmt2 = $pdo->prepare("SELECT COUNT(*) FROM `admins` WHERE LOWER(`email`) = ?");
    $stmt2->execute([$email]);
    if ((int)$stmt2->fetchColumn() > 0) {
        api_json(['success' => false, 'message' => 'An administrator account with this email already exists.']);
    }

    // Check duplicate slug
    $stmt3 = $pdo->prepare("SELECT COUNT(*) FROM `saas_tenants` WHERE LOWER(`slug`) = ?");
    $stmt3->execute([$storeSlug]);
    if ((int)$stmt3->fetchColumn() > 0) {
        api_json(['success' => false, 'message' => 'Store slug "' . $storeSlug . '" is already taken. Please choose another.']);
    }

    $plan = get_saas_plan_by_id_or_slug($planId);
    if (!$plan || empty($plan['is_active'])) {
        api_json(['success' => false, 'message' => 'Selected pricing plan is invalid or inactive.']);
    }

    $otpCode = (string)rand(100000, 999999);
    $currencySym = ($currency === 'INR') ? '₹' : (($currency === 'EUR') ? '€' : '$');

    $_SESSION['saas_registration'] = [
        'plan_id'          => (int)$plan['id'],
        'owner_name'       => $ownerName,
        'business_name'    => $storeName,
        'tagline'          => trim($_POST['tagline'] ?? ('Official Online Store of ' . $storeName)),
        'store_slug'       => $storeSlug,
        'domain'           => $storeSlug . '.com',
        'owner_email'      => $email,
        'owner_phone'      => $phone,
        'password_hash'    => password_hash($password, PASSWORD_BCRYPT),
        'business_address' => $address ?: '123 Commerce Street',
        'currency_code'    => $currency,
        'currency_symbol'  => $currencySym,
        'template'         => strtolower(trim($_POST['template'] ?? 'fashion')),
        'otp_code'         => $otpCode,
        'otp_verified'     => true, // Verified on submit or via OTP input
        'created_at'       => time(),
    ];

    api_json([
        'success'   => true,
        'message'   => 'Registration details validated and saved. Please select your store template.',
        'store_slug'=> $storeSlug,
        'store_url' => saas_base_url('website/s/' . $storeSlug),
        'demo_otp'  => $otpCode,
    ]);
}

// 3. Save Selected Template & Create Pending Subscription + Payment Record Before Payment Initiation
if ($action === 'save_template_and_create_pending_order') {
    if (empty($_SESSION['saas_registration'])) {
        api_json(['success' => false, 'message' => 'Registration session expired. Please complete Step 2 first.']);
    }

    $reg = $_SESSION['saas_registration'];
    $planId = (int)($_POST['plan_id'] ?? $reg['plan_id']);
    $plan = get_saas_plan_by_id_or_slug($planId);
    if (!$plan || empty($plan['is_active'])) {
        api_json(['success' => false, 'message' => 'Selected plan is unavailable.']);
    }

    $chosenTemplate = strtolower(trim($_POST['template'] ?? $reg['template'] ?? 'fashion'));
    if (!in_array($chosenTemplate, ['fashion', 'electronics', 'grocery'], true)) {
        api_json(['success' => false, 'message' => 'Invalid storefront template selected.']);
    }
    if (!in_array($chosenTemplate, $plan['allowed_templates_list'], true)) {
        api_json(['success' => false, 'message' => 'The "' . ucfirst($chosenTemplate) . '" template is not permitted on the ' . $plan['name'] . '. Please upgrade your plan or choose a permitted template.']);
    }

    $_SESSION['saas_registration']['plan_id']  = (int)$plan['id'];
    $_SESSION['saas_registration']['template'] = $chosenTemplate;
    $reg = $_SESSION['saas_registration'];

    $amount   = (float)$plan['effective_price'];
    $currency = $plan['currency'] ?: 'USD';

    // Check if we already created a pending payment record in this session
    $existingOrderNum = $_SESSION['saas_pending_order_number'] ?? '';
    if ($existingOrderNum !== '') {
        $chk = $pdo->prepare("SELECT * FROM `saas_payments` WHERE `order_number` = ? AND `payment_status` IN ('pending', 'failed', 'cancelled') LIMIT 1");
        $chk->execute([$existingOrderNum]);
        $existingOrder = $chk->fetch();
        if ($existingOrder) {
            $upd = $pdo->prepare("UPDATE `saas_payments` SET `plan_id` = ?, `chosen_template` = ?, `amount` = ?, `currency` = ?, `setup_payload` = ?, `payment_status` = 'pending', `updated_at` = NOW() WHERE `id` = ?");
            $upd->execute([(int)$plan['id'], $chosenTemplate, $amount, $currency, json_encode($reg), (int)$existingOrder['id']]);
            if (!empty($existingOrder['subscription_id'])) {
                $pdo->prepare("UPDATE `saas_subscriptions` SET `plan_id` = ?, `template_key` = ?, `amount` = ?, `currency` = ?, `status` = 'pending' WHERE `id` = ?")
                    ->execute([(int)$plan['id'], $chosenTemplate, $amount, $currency, (int)$existingOrder['subscription_id']]);
            }
            api_json([
                'success'      => true,
                'order_number' => $existingOrderNum,
                'amount'       => $amount,
                'currency'     => $currency,
                'plan_name'    => $plan['name'],
                'template'     => $chosenTemplate,
            ]);
        }
    }

    // Create Pending Subscription & Pending Payment Record
    $orderNumber = 'SAAS-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 6));
    $subNumber   = 'SUB-' . date('Ymd') . '-' . strtoupper(substr(md5($orderNumber), 0, 6));
    $idempKey    = 'IDEMP_' . md5($orderNumber . '_' . $reg['owner_email']);

    $insSub = $pdo->prepare("INSERT INTO `saas_subscriptions`
        (`subscription_number`, `tenant_id`, `plan_id`, `template_key`, `billing_cycle`, `amount`, `currency`, `status`)
        VALUES (?, 0, ?, ?, ?, ?, ?, 'pending')");
    $insSub->execute([$subNumber, (int)$plan['id'], $chosenTemplate, $plan['billing_cycle'], $amount, $currency]);
    $subId = (int)$pdo->lastInsertId();

    $insPay = $pdo->prepare("INSERT INTO `saas_payments`
        (`order_number`, `subscription_id`, `tenant_id`, `plan_id`, `customer_name`, `customer_email`, `customer_phone`, `business_name`, `store_slug`, `chosen_template`, `gateway`, `idempotency_key`, `amount`, `currency`, `payment_status`, `setup_payload`)
        VALUES (?, ?, NULL, ?, ?, ?, ?, ?, ?, ?, 'pending', ?, ?, ?, 'pending', ?)");
    $insPay->execute([
        $orderNumber, $subId, (int)$plan['id'],
        $reg['owner_name'], $reg['owner_email'], $reg['owner_phone'],
        $reg['business_name'], $reg['store_slug'], $chosenTemplate,
        $idempKey, $amount, $currency, json_encode($reg)
    ]);

    $_SESSION['saas_pending_order_number'] = $orderNumber;

    api_json([
        'success'         => true,
        'order_number'    => $orderNumber,
        'subscription_id' => $subId,
        'amount'          => $amount,
        'currency'        => $currency,
        'plan_name'       => $plan['name'],
        'template'        => $chosenTemplate,
    ]);
}

// 4. Verify Razorpay Signature on Server & Provision Tenant
if ($action === 'verify_razorpay_payment') {
    $orderNumber       = trim($_POST['order_number'] ?? '');
    $razorpayPaymentId = trim($_POST['razorpay_payment_id'] ?? '');
    $razorpayOrderId   = trim($_POST['razorpay_order_id'] ?? '');
    $razorpaySignature = trim($_POST['razorpay_signature'] ?? '');

    if ($orderNumber === '' || $razorpayPaymentId === '') {
        api_json(['success' => false, 'message' => 'Missing payment verification details.']);
    }

    $keySecret = get_saas_setting('razorpay_key_secret', '');
    if ($razorpayOrderId !== '' && $keySecret !== '') {
        $expectedSig = hash_hmac('sha256', $razorpayOrderId . '|' . $razorpayPaymentId, $keySecret);
        if (!hash_equals($expectedSig, $razorpaySignature)) {
            $pdo->prepare("UPDATE `saas_payments` SET `payment_status` = 'failed', `gateway` = 'razorpay', `updated_at` = NOW() WHERE `order_number` = ?")
                ->execute([$orderNumber]);
            api_json(['success' => false, 'message' => 'Razorpay cryptographic signature verification failed.']);
        }
    }

    $pdo->prepare("UPDATE `saas_payments` SET `gateway` = 'razorpay', `gateway_session_id` = ? WHERE `order_number` = ?")
        ->execute([$razorpayOrderId, $orderNumber]);

    $result = provision_saas_tenant($orderNumber, $razorpayPaymentId, [
        'gateway'             => 'razorpay',
        'razorpay_payment_id' => $razorpayPaymentId,
        'razorpay_order_id'   => $razorpayOrderId,
        'verified_at'         => date('c')
    ]);

    if ($result['success']) {
        unset($_SESSION['saas_pending_order_number']);
    }
    api_json($result);
}

// 5. Process Sandbox / Verified Test Payment (only if sandbox_enabled == '1' in Superadmin settings)
if ($action === 'process_sandbox_payment') {
    $orderNumber = trim($_POST['order_number'] ?? '');
    $simOutcome  = trim($_POST['simulate_outcome'] ?? 'success'); // success | failed | cancelled

    if ($orderNumber === '') {
        api_json(['success' => false, 'message' => 'Order number is required.']);
    }

    if (get_saas_setting('sandbox_enabled', '1') !== '1') {
        api_json(['success' => false, 'message' => 'Sandbox mode is disabled by the platform administrator.']);
    }

    if ($simOutcome === 'failed' || $simOutcome === 'cancelled') {
        $status = ($simOutcome === 'cancelled') ? 'cancelled' : 'failed';
        $pdo->prepare("UPDATE `saas_payments` SET `gateway` = 'sandbox', `payment_status` = ?, `updated_at` = NOW() WHERE `order_number` = ? AND `payment_status` != 'paid'")
            ->execute([$status, $orderNumber]);
        api_json([
            'success'      => false,
            'payment_status'=> $status,
            'order_number' => $orderNumber,
            'retry_url'    => saas_base_url('subscribe.php?retry_order=' . urlencode($orderNumber)),
            'message'      => 'Payment was ' . $status . '. Your subscription has NOT been activated. You may retry payment anytime.'
        ]);
    }

    $txId = 'SANDBOX_TXN_' . strtoupper(substr(md5($orderNumber . microtime(true)), 0, 10));
    $pdo->prepare("UPDATE `saas_payments` SET `gateway` = 'sandbox' WHERE `order_number` = ?")->execute([$orderNumber]);

    $result = provision_saas_tenant($orderNumber, $txId, [
        'gateway'     => 'sandbox',
        'verified_at' => date('c'),
    ]);

    if ($result['success']) {
        unset($_SESSION['saas_pending_order_number']);
    }
    api_json($result);
}

// 6. Mark Payment Failed / Cancelled (e.g. user dismissed modal)
if ($action === 'mark_payment_failed') {
    $orderNumber = trim($_POST['order_number'] ?? '');
    $status      = in_array($_POST['status'] ?? '', ['failed', 'cancelled'], true) ? $_POST['status'] : 'failed';
    if ($orderNumber !== '') {
        $pdo->prepare("UPDATE `saas_payments` SET `payment_status` = ?, `updated_at` = NOW() WHERE `order_number` = ? AND `payment_status` = 'pending'")
            ->execute([$status, $orderNumber]);
    }
    api_json(['success' => true, 'status' => $status]);
}

api_json(['success' => false, 'message' => 'Unknown API action.'], 400);
