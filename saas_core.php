<?php
/**
 * SaaS Core Engine & Multi-Tenant Provisioning Service
 * Shared across Landing Website, Registration Wizard, Payment Callbacks, Webhooks, and Superadmin.
 */

if (session_status() === PHP_SESSION_NONE && !defined('BASEPATH')) {
    session_start();
}

function get_saas_pdo() {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=localhost;dbname=ecommerce_main;charset=utf8mb4';
        $pdo = new PDO($dsn, 'root', '', [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

function get_saas_mysqli() {
    static $mysqli = null;
    if ($mysqli === null) {
        mysqli_report(MYSQLI_REPORT_OFF);
        $mysqli = new mysqli('localhost', 'root', '', 'ecommerce_main');
        $mysqli->set_charset('utf8mb4');
    }
    return $mysqli;
}

function saas_base_url($path = '') {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $base = $protocol . $host . '/ecommerce/';
    return $base . ltrim($path, '/');
}

function get_all_saas_settings() {
    $pdo = get_saas_pdo();
    $stmt = $pdo->query("SELECT `key_name`, `key_value` FROM `saas_settings`");
    $settings = [];
    while ($row = $stmt->fetch()) {
        $settings[$row['key_name']] = $row['key_value'];
    }
    return $settings;
}

function get_saas_setting($key, $default = '') {
    static $cache = null;
    if ($cache === null) {
        $cache = get_all_saas_settings();
    }
    return isset($cache[$key]) && $cache[$key] !== '' ? $cache[$key] : $default;
}

function set_saas_setting($key, $value) {
    $pdo = get_saas_pdo();
    $stmt = $pdo->prepare("INSERT INTO `saas_settings` (`key_name`, `key_value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `key_value` = VALUES(`key_value`)");
    return $stmt->execute([$key, (string)$value]);
}

function get_active_saas_templates() {
    $pdo = get_saas_pdo();
    $stmt = $pdo->query("SELECT * FROM `saas_templates` WHERE `is_active` = 1 ORDER BY `sort_order` ASC, `id` ASC");
    $rows = $stmt->fetchAll();
    foreach ($rows as &$r) {
        $r['features_list'] = !empty($r['features']) ? (json_decode($r['features'], true) ?: []) : [];
    }
    return $rows;
}

function get_all_saas_templates() {
    $pdo = get_saas_pdo();
    $stmt = $pdo->query("SELECT * FROM `saas_templates` ORDER BY `sort_order` ASC, `id` ASC");
    $rows = $stmt->fetchAll();
    foreach ($rows as &$r) {
        $r['features_list'] = !empty($r['features']) ? (json_decode($r['features'], true) ?: []) : [];
    }
    return $rows;
}

function get_active_saas_plans() {
    $pdo = get_saas_pdo();
    $stmt = $pdo->query("SELECT * FROM `saas_plans` WHERE `is_active` = 1 ORDER BY `sort_order` ASC, `id` ASC");
    $rows = $stmt->fetchAll();
    foreach ($rows as &$r) {
        $r['features_list'] = !empty($r['features']) ? (json_decode($r['features'], true) ?: []) : [];
        $r['allowed_templates_list'] = !empty($r['allowed_templates']) ? (json_decode($r['allowed_templates'], true) ?: ['fashion', 'electronics', 'grocery']) : ['fashion', 'electronics', 'grocery'];
        $r['effective_price'] = (!empty($r['discounted_price']) && (float)$r['discounted_price'] > 0 && (float)$r['discounted_price'] < (float)$r['price'])
            ? (float)$r['discounted_price']
            : (float)$r['price'];
    }
    return $rows;
}

function get_saas_plan_by_id_or_slug($identifier) {
    $pdo = get_saas_pdo();
    if (is_numeric($identifier)) {
        $stmt = $pdo->prepare("SELECT * FROM `saas_plans` WHERE `id` = ? LIMIT 1");
        $stmt->execute([(int)$identifier]);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM `saas_plans` WHERE `slug` = ? OR `code` = ? LIMIT 1");
        $stmt->execute([$identifier, $identifier]);
    }
    $row = $stmt->fetch();
    if ($row) {
        $row['features_list'] = !empty($row['features']) ? (json_decode($row['features'], true) ?: []) : [];
        $row['allowed_templates_list'] = !empty($row['allowed_templates']) ? (json_decode($row['allowed_templates'], true) ?: ['fashion', 'electronics', 'grocery']) : ['fashion', 'electronics', 'grocery'];
        $row['effective_price'] = (!empty($row['discounted_price']) && (float)$row['discounted_price'] > 0 && (float)$row['discounted_price'] < (float)$row['price'])
            ? (float)$row['discounted_price']
            : (float)$row['price'];
    }
    return $row;
}

function sanitize_store_slug($input) {
    $slug = strtolower(trim($input));
    $slug = preg_replace('/^https?:\/\//', '', $slug);
    $slug = preg_replace('/^www\./', '', $slug);
    $slug = preg_replace('/\.[a-z]{2,6}$/', '', $slug);
    $slug = preg_replace('/[^a-z0-9\-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return trim($slug, '-');
}

function is_reserved_store_slug($slug) {
    $reserved = [
        'admin', 'admin-template', 'website', 'superadmin', 'templates', 'database',
        'referance-project', 'assets', 'uploads', 'system', 'application', 'vendor',
        'install', 'api', 'login', 'register', 'subscribe', 'checkout', 'cart', 'shop',
        'product', 'order', 'account', 'payment', 'page', 'home', 's', 'store', 'demo'
    ];
    return in_array(strtolower($slug), $reserved, true);
}

function saas_db() {
    return get_saas_pdo();
}

function saas_get_plan($identifier) {
    return get_saas_plan_by_id_or_slug($identifier);
}

function saas_unique_slug($input) {
    $base = sanitize_store_slug($input);
    if ($base === '' || is_reserved_store_slug($base)) {
        $base = 'store-' . rand(1000, 9999);
    }
    $pdo = get_saas_pdo();
    $slug = $base;
    $i = 1;
    while (true) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `saas_tenants` WHERE `slug` = ?");
        $stmt->execute([$slug]);
        if ((int)$stmt->fetchColumn() === 0) {
            return $slug;
        }
        $i++;
        $slug = $base . '-' . $i;
    }
}

/**
 * Provision or Finalize a Tenant Store Idempotently after Verified Payment
 */
function provision_saas_tenant($paymentOrderOrId, $transactionId = '', $gatewayResponse = []) {
    $pdo = get_saas_pdo();
    $db  = get_saas_mysqli();

    // Fetch payment record by numeric ID or order_number string
    if (is_numeric($paymentOrderOrId)) {
        $stmt = $pdo->prepare("SELECT * FROM `saas_payments` WHERE `id` = ? LIMIT 1");
        $stmt->execute([(int)$paymentOrderOrId]);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM `saas_payments` WHERE `order_number` = ? LIMIT 1");
        $stmt->execute([(string)$paymentOrderOrId]);
    }
    $payment = $stmt->fetch();

    if (!$payment) {
        return ['success' => false, 'message' => 'Payment order record not found.'];
    }
    $paymentOrderNumber = $payment['order_number'];

    // Idempotency check: if already paid and tenant_id exists, return existing tenant immediately!
    if ($payment['payment_status'] === 'paid' && !empty($payment['tenant_id'])) {
        $tStmt = $pdo->prepare("SELECT * FROM `saas_tenants` WHERE `id` = ? LIMIT 1");
        $tStmt->execute([(int)$payment['tenant_id']]);
        $existingTenant = $tStmt->fetch();
        if ($existingTenant) {
            return [
                'success'        => true,
                'already_active' => true,
                'already_done'   => true,
                'slug'           => $existingTenant['slug'],
                'tenant'         => $existingTenant,
                'payment'        => $payment,
                'store_url'      => $existingTenant['website_url'],
                'admin_url'      => $existingTenant['admin_url'],
            ];
        }
    }

    $setup = !empty($payment['setup_payload']) ? (json_decode($payment['setup_payload'], true) ?: []) : [];
    $plan  = get_saas_plan_by_id_or_slug($payment['plan_id']);
    if (!$plan) {
        $plan = get_saas_plan_by_id_or_slug(1);
    }

    $chosenTemplate = strtolower($payment['chosen_template'] ?: ($setup['template'] ?? 'fashion'));
    if (!in_array($chosenTemplate, ['fashion', 'electronics', 'grocery'], true)) {
        $chosenTemplate = 'fashion';
    }

    // Enforce plan template eligibility
    if (!in_array($chosenTemplate, $plan['allowed_templates_list'], true)) {
        $chosenTemplate = $plan['allowed_templates_list'][0] ?? 'fashion';
    }

    $storeSlug    = sanitize_store_slug($payment['store_slug'] ?: ($setup['store_slug'] ?? $payment['business_name']));
    if (empty($storeSlug) || is_reserved_store_slug($storeSlug)) {
        $storeSlug = 'store-' . strtolower(substr(md5($paymentOrderNumber), 0, 6));
    }
    $domain       = $setup['domain'] ?? ($storeSlug . '.com');
    $businessName = $payment['business_name'] ?: ($setup['business_name'] ?? 'My Store');
    $tagline      = $setup['tagline'] ?? ('Official Online Store of ' . $businessName);
    $ownerName    = $payment['customer_name'] ?: ($setup['owner_name'] ?? 'Store Owner');
    $ownerEmail   = strtolower(trim($payment['customer_email'] ?: ($setup['owner_email'] ?? '')));
    $ownerPhone   = $payment['customer_phone'] ?: ($setup['owner_phone'] ?? '');
    $passwordHash = $setup['password_hash'] ?? password_hash('admin123', PASSWORD_BCRYPT);
    $address      = $setup['business_address'] ?? '123 Business Avenue';
    $currencyCode = $setup['currency_code'] ?? ($payment['currency'] ?: 'USD');
    $currencySym  = $setup['currency_symbol'] ?? ($currencyCode === 'INR' ? '₹' : '$');
    $logoPath     = $setup['logo'] ?? '';
    $faviconPath  = $setup['favicon'] ?? '';

    if (empty($transactionId)) {
        $transactionId = $payment['transaction_id'] ?: ('TXN_' . strtoupper(substr(md5($paymentOrderNumber . time()), 0, 10)));
    }

    try {
        $pdo->beginTransaction();

        // Check if slug/domain already exists in saas_tenants (e.g. renewal or pre-created pending tenant)
        $chkStmt = $pdo->prepare("SELECT * FROM `saas_tenants` WHERE `slug` = ? OR `domain` = ? LIMIT 1");
        $chkStmt->execute([$storeSlug, $domain]);
        $existingTenant = $chkStmt->fetch();

        $durationDays = max(1, (int)($plan['duration_days'] ?? 30));
        $trialDays    = max(0, (int)($plan['trial_days'] ?? 0));
        $startDate    = date('Y-m-d H:i:s');
        $endDate      = date('Y-m-d H:i:s', strtotime("+{$durationDays} days"));
        $trialEndsAt  = $trialDays > 0 ? date('Y-m-d H:i:s', strtotime("+{$trialDays} days")) : null;
        $licenseKey   = 'LIC-' . strtoupper(substr($chosenTemplate, 0, 3)) . '-' . date('Y') . '-' . strtoupper(substr(md5($paymentOrderNumber), 0, 6));

        $websiteUrl   = saas_base_url('website/s/' . $storeSlug);
        $adminUrl     = saas_base_url('admin/auth/login');
        $folderPath   = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'website';

        if ($existingTenant && (int)$existingTenant['id'] > 3 && $existingTenant['admin_email'] !== $ownerEmail) {
            // Avoid slug collision with another user's tenant
            $storeSlug  = $storeSlug . '-' . rand(100, 999);
            $domain     = $storeSlug . '.com';
            $websiteUrl = saas_base_url('website/s/' . $storeSlug);
            $existingTenant = null;
        }

        if ($existingTenant) {
            $tenantId   = (int)$existingTenant['id'];
            $tenantCode = $existingTenant['tenant_code'] ?: ('TNT-' . date('Y') . '-' . str_pad($tenantId, 4, '0', STR_PAD_LEFT));
            $updTenant  = $pdo->prepare("UPDATE `saas_tenants` SET
                `plan_id` = ?, `business_name` = ?, `tagline` = ?, `template` = ?,
                `payment_status` = 'paid', `amount_paid` = ?, `payment_method` = ?, `transaction_id` = ?,
                `subscription_status` = 'active', `subscription_expires_at` = ?, `license_key` = ?,
                `website_url` = ?, `admin_url` = ?, `status` = 'active', `updated_at` = NOW()
                WHERE `id` = ?");
            $updTenant->execute([
                (int)$plan['id'], $businessName, $tagline, $chosenTemplate,
                (float)$payment['amount'], $payment['gateway'], $transactionId,
                $endDate, $licenseKey, $websiteUrl, $adminUrl, $tenantId
            ]);
        } else {
            $tenantCode = 'TNT-' . date('Y') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 5));
            $insTenant  = $pdo->prepare("INSERT INTO `saas_tenants`
                (`tenant_code`, `plan_id`, `license_key`, `business_name`, `tagline`, `slug`, `domain`, `folder_path`, `database_name`, `template`,
                 `admin_name`, `admin_email`, `admin_phone`, `business_email`, `business_phone`, `business_address`,
                 `currency_code`, `currency_symbol`, `logo`, `favicon`, `website_url`, `admin_url`,
                 `payment_status`, `amount_paid`, `payment_method`, `transaction_id`, `subscription_status`, `subscription_expires_at`, `status`, `installed_at`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'ecommerce_main', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'paid', ?, ?, ?, 'active', ?, 'active', NOW())");
            $insTenant->execute([
                $tenantCode, (int)$plan['id'], $licenseKey, $businessName, $tagline, $storeSlug, $domain, $folderPath, $chosenTemplate,
                $ownerName, $ownerEmail, $ownerPhone, $ownerEmail, $ownerPhone, $address,
                $currencyCode, $currencySym, $logoPath, $faviconPath, $websiteUrl, $adminUrl,
                (float)$payment['amount'], $payment['gateway'], $transactionId, $endDate
            ]);
            $tenantId = (int)$pdo->lastInsertId();
        }

        // Create or Update Subscription Record
        $subNumber = 'SUB-' . date('Ymd') . '-' . str_pad($tenantId, 4, '0', STR_PAD_LEFT) . '-' . strtoupper(substr(md5($paymentOrderNumber), 0, 4));
        if (!empty($payment['subscription_id'])) {
            $subId = (int)$payment['subscription_id'];
            $updSub = $pdo->prepare("UPDATE `saas_subscriptions` SET
                `tenant_id` = ?, `plan_id` = ?, `template_key` = ?, `status` = 'active',
                `start_date` = ?, `end_date` = ?, `trial_ends_at` = ?, `license_key` = ?, `updated_at` = NOW()
                WHERE `id` = ?");
            $updSub->execute([$tenantId, (int)$plan['id'], $chosenTemplate, $startDate, $endDate, $trialEndsAt, $licenseKey, $subId]);
        } else {
            $insSub = $pdo->prepare("INSERT INTO `saas_subscriptions`
                (`subscription_number`, `tenant_id`, `plan_id`, `template_key`, `billing_cycle`, `amount`, `currency`, `status`, `start_date`, `end_date`, `trial_ends_at`, `license_key`)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'active', ?, ?, ?, ?)");
            $insSub->execute([
                $subNumber, $tenantId, (int)$plan['id'], $chosenTemplate,
                $plan['billing_cycle'] ?? 'monthly', (float)$payment['amount'], $payment['currency'] ?: 'USD',
                $startDate, $endDate, $trialEndsAt, $licenseKey
            ]);
            $subId = (int)$pdo->lastInsertId();
        }

        // Link subscription_id back to saas_tenants
        $pdo->prepare("UPDATE `saas_tenants` SET `subscription_id` = ? WHERE `id` = ?")->execute([$subId, $tenantId]);

        // Update Payment Record
        $updPay = $pdo->prepare("UPDATE `saas_payments` SET
            `subscription_id` = ?, `tenant_id` = ?, `transaction_id` = ?,
            `payment_status` = 'paid', `gateway_response` = ?, `paid_at` = NOW(), `updated_at` = NOW()
            WHERE `id` = ?");
        $updPay->execute([$subId, $tenantId, $transactionId, json_encode($gatewayResponse), (int)$payment['id']]);

        // Save Tenant Template Configuration
        $tplCfgStmt = $pdo->prepare("INSERT INTO `saas_tenant_templates` (`tenant_id`, `template_key`, `custom_settings`)
            VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `template_key` = VALUES(`template_key`)");
        $tplCfgStmt->execute([$tenantId, $chosenTemplate, json_encode(['site_name' => $businessName, 'tagline' => $tagline])]);

        // Create Tenant Role & Owner Admin Account
        $pdo->prepare("INSERT INTO `roles` (`tenant_id`, `name`, `slug`, `description`, `is_system`)
            VALUES (?, 'Store Owner', 'super-admin', 'Full unrestricted control of tenant store', 1)
            ON DUPLICATE KEY UPDATE `name` = VALUES(`name`)")->execute([$tenantId]);
        $rStmt = $pdo->prepare("SELECT `id` FROM `roles` WHERE `tenant_id` = ? AND `slug` = 'super-admin' LIMIT 1");
        $rStmt->execute([$tenantId]);
        $roleId = (int)$rStmt->fetchColumn();

        $admStmt = $pdo->prepare("INSERT INTO `admins` (`tenant_id`, `role_id`, `name`, `email`, `password`, `phone`, `avatar`, `status`)
            VALUES (?, ?, ?, ?, ?, ?, 'default-avatar.png', 'active')
            ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `role_id` = VALUES(`role_id`), `status` = 'active'");
        $admStmt->execute([$tenantId, $roleId, $ownerName, $ownerEmail, $passwordHash, $ownerPhone]);

        $admIdStmt = $pdo->prepare("SELECT `id` FROM `admins` WHERE `tenant_id` = ? AND `email` = ? LIMIT 1");
        $admIdStmt->execute([$tenantId, $ownerEmail]);
        $ownerAdminId = (int)$admIdStmt->fetchColumn();
        $pdo->prepare("UPDATE `saas_tenants` SET `owner_admin_id` = ? WHERE `id` = ?")->execute([$ownerAdminId, $tenantId]);

        // Seed Tenant Store Settings
        $tenantSettings = [
            ['site_name', $businessName, 'general'],
            ['site_email', $ownerEmail, 'general'],
            ['admin_email', $ownerEmail, 'general'],
            ['site_phone', $ownerPhone ?: '+1 (800) 555-0199', 'general'],
            ['support_phone', $ownerPhone ?: '+1 (800) 555-0199', 'general'],
            ['site_address', $address, 'general'],
            ['store_address', $address, 'general'],
            ['currency_code', $currencyCode, 'general'],
            ['currency', $currencyCode, 'general'],
            ['currency_symbol', $currencySym, 'general'],
            ['shipping_flat_rate', '10.00', 'shipping'],
            ['free_shipping_min', '99.00', 'shipping'],
            ['shipping_free_threshold', '99.00', 'shipping'],
            ['shipping_charges', '[{"name":"Standard Courier","value":10}]', 'shipping'],
            ['tax_rate_percent', '10', 'tax'],
            ['tax_rate', '10', 'tax'],
            ['tax_enabled', '1', 'tax'],
            ['tax_inclusive', '1', 'tax'],
            ['enable_stripe', '1', 'payment'],
            ['enable_razorpay', '1', 'payment'],
            ['enable_payu', '1', 'payment'],
            ['enable_cod', '1', 'payment'],
            ['active_online_gateway', 'razorpay', 'payment'],
        ];
        if (!empty($logoPath)) {
            $tenantSettings[] = ['site_logo', $logoPath, 'general'];
        }
        if (!empty($faviconPath)) {
            $tenantSettings[] = ['site_favicon', $faviconPath, 'general'];
        }
        $stStmt = $pdo->prepare("INSERT INTO `settings` (`tenant_id`, `setting_key`, `setting_value`, `setting_group`)
            VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`)");
        foreach ($tenantSettings as $st) {
            $stStmt->execute([$tenantId, $st[0], $st[1], $st[2]]);
        }

        // Seed Tenant Payment Gateways (from Tenant 1 defaults)
        $gwRows = $pdo->query("SELECT `gateway_code`, `gateway_name`, `is_active`, `environment`, `credentials` FROM `payment_gateways` WHERE `tenant_id` = 1")->fetchAll();
        $gwStmt = $pdo->prepare("INSERT INTO `payment_gateways` (`tenant_id`, `gateway_code`, `gateway_name`, `is_active`, `environment`, `credentials`)
            VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `gateway_name` = VALUES(`gateway_name`)");
        foreach ($gwRows as $gw) {
            $gwStmt->execute([$tenantId, $gw['gateway_code'], $gw['gateway_name'], $gw['is_active'], $gw['environment'], $gw['credentials']]);
        }

        // Seed Starter Catalog for New Tenant if they have 0 products
        $prodCountStmt = $pdo->prepare("SELECT COUNT(*) FROM `products` WHERE `tenant_id` = ?");
        $prodCountStmt->execute([$tenantId]);
        if ((int)$prodCountStmt->fetchColumn() === 0) {
            // Source tenant ID based on chosen template: 1 = fashion, 2 = grocery, 3 = electronics
            $sourceTenantId = 1;
            if ($chosenTemplate === 'grocery') $sourceTenantId = 2;
            elseif ($chosenTemplate === 'electronics') $sourceTenantId = 3;

            // Clone root categories from source tenant
            $srcCats = $pdo->prepare("SELECT * FROM `categories` WHERE `tenant_id` = ? AND `parent_id` = 0 ORDER BY `sort_order` ASC LIMIT 8");
            $srcCats->execute([$sourceTenantId]);
            $catIdMap = [];
            $insCat = $pdo->prepare("INSERT INTO `categories` (`tenant_id`, `parent_id`, `name`, `slug`, `description`, `image`, `is_featured`, `sort_order`, `status`)
                VALUES (?, 0, ?, ?, ?, ?, ?, ?, 'active')");
            foreach ($srcCats->fetchAll() as $sc) {
                $insCat->execute([$tenantId, $sc['name'], $sc['slug'], $sc['description'], $sc['image'], $sc['is_featured'], $sc['sort_order']]);
                $catIdMap[$sc['id']] = (int)$pdo->lastInsertId();
            }

            // Clone banners from source tenant
            $srcBanners = $pdo->prepare("SELECT * FROM `banners` WHERE `tenant_id` = ? ORDER BY `sort_order` ASC LIMIT 4");
            $srcBanners->execute([$sourceTenantId]);
            $insBanner = $pdo->prepare("INSERT INTO `banners` (`tenant_id`, `title`, `subtitle`, `button_text`, `button_link`, `image`, `sort_order`, `status`)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'active')");
            foreach ($srcBanners->fetchAll() as $sb) {
                $insBanner->execute([$tenantId, $sb['title'], $sb['subtitle'], $sb['button_text'], $sb['button_link'], $sb['image'], $sb['sort_order']]);
            }

            // Clone up to 12 starter products from source tenant
            $srcProds = $pdo->prepare("SELECT * FROM `products` WHERE `tenant_id` = ? AND `status` = 'published' ORDER BY `id` ASC LIMIT 12");
            $srcProds->execute([$sourceTenantId]);
            $insProd = $pdo->prepare("INSERT INTO `products`
                (`tenant_id`, `category_id`, `brand_id`, `product_type`, `title`, `slug`, `sku`, `unit_label`, `warranty_info`, `price`, `sale_price`, `tax_rate`, `stock_quantity`, `low_stock_threshold`, `max_purchase_quantity`, `stock_status`, `short_description`, `description`, `highlights`, `main_image`, `gallery_images`, `is_featured`, `is_trending`, `is_new`, `is_cod_allowed`, `rating`, `reviews_count`, `status`)
                VALUES (?, ?, 0, 'simple', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'in_stock', ?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?, 'published')");
            foreach ($srcProds->fetchAll() as $sp) {
                $mappedCatId = $catIdMap[$sp['category_id']] ?? ( reset($catIdMap) ?: 1 );
                $newSku = $sp['sku'] . '-T' . $tenantId;
                $insProd->execute([
                    $tenantId, $mappedCatId, $sp['title'], $sp['slug'], $newSku,
                    $sp['unit_label'], $sp['warranty_info'], $sp['price'], $sp['sale_price'],
                    $sp['tax_rate'], max(20, (int)$sp['stock_quantity']), $sp['low_stock_threshold'], $sp['max_purchase_quantity'],
                    $sp['short_description'], $sp['description'], $sp['highlights'], $sp['main_image'], $sp['gallery_images'],
                    $sp['is_featured'], $sp['is_trending'], $sp['is_new'], $sp['rating'], $sp['reviews_count']
                ]);
            }
        }

        $pdo->commit();

        $tStmt = $pdo->prepare("SELECT * FROM `saas_tenants` WHERE `id` = ? LIMIT 1");
        $tStmt->execute([$tenantId]);
        $finalTenant = $tStmt->fetch();

        return [
            'success'        => true,
            'already_active' => false,
            'tenant'         => $finalTenant,
            'subscription_id'=> $subId,
            'license_key'    => $licenseKey,
            'store_url'      => $websiteUrl,
            'admin_url'      => $adminUrl,
        ];
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        return ['success' => false, 'message' => 'Provisioning failed: ' . $e->getMessage()];
    }
}
