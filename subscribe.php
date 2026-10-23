<?php
/**
 * Multi-Step SaaS Registration, Plan Selection, Template Selection & Payment Checkout Wizard (subscribe.php)
 * Follows referance-project/subscribe.php workflow and implements all requirements from Section 5.
 */
require_once __DIR__ . '/saas_core.php';

$pdo       = get_saas_pdo();
$settings  = get_all_saas_settings();
$plans     = get_active_saas_plans();
$templates = get_active_saas_templates();

$platformName = $settings['platform_name'] ?? 'Codeulas Cloud';
$currencySym  = $settings['currency_symbol'] ?? '$';

// Check if returning from a verified activated order (?activated_order=...)
$activatedOrder = null;
$activatedTenant = null;
if (!empty($_GET['activated_order'])) {
    $stmt = $pdo->prepare("SELECT * FROM `saas_payments` WHERE `order_number` = ? AND `payment_status` = 'paid' LIMIT 1");
    $stmt->execute([trim($_GET['activated_order'])]);
    $activatedOrder = $stmt->fetch();
    if ($activatedOrder && !empty($activatedOrder['tenant_id'])) {
        $tStmt = $pdo->prepare("SELECT * FROM `saas_tenants` WHERE `id` = ? LIMIT 1");
        $tStmt->execute([(int)$activatedOrder['tenant_id']]);
        $activatedTenant = $tStmt->fetch();
    }
}

// Check if retrying a failed/cancelled/pending order (?retry_order=...)
$retryOrder = null;
$paymentErrorMsg = '';
if (!empty($_GET['retry_order'])) {
    $stmt = $pdo->prepare("SELECT * FROM `saas_payments` WHERE `order_number` = ? LIMIT 1");
    $stmt->execute([trim($_GET['retry_order'])]);
    $retryOrder = $stmt->fetch();
    if ($retryOrder) {
        if ($retryOrder['payment_status'] === 'paid') {
            header('Location: subscribe.php?activated_order=' . urlencode($retryOrder['order_number']));
            exit;
        }
        $_SESSION['saas_pending_order_number'] = $retryOrder['order_number'];
        if (!empty($retryOrder['setup_payload'])) {
            $_SESSION['saas_registration'] = json_decode($retryOrder['setup_payload'], true) ?: [];
        }
        $errCode = $_GET['payment_error'] ?? $retryOrder['payment_status'];
        if ($errCode === 'cancelled') {
            $paymentErrorMsg = 'Payment was cancelled. Your subscription has NOT been activated yet. You can retry payment below.';
        } else {
            $paymentErrorMsg = 'Payment could not be verified (' . htmlspecialchars($errCode) . '). Your subscription remains pending — please retry below.';
        }
    }
}

// Pre-selected plan or template from query string
$initialPlanSlug = strtolower(trim($_GET['plan'] ?? ''));
$initialTplKey   = strtolower(trim($_GET['tpl'] ?? 'fashion'));
if (!in_array($initialTplKey, ['fashion', 'electronics', 'grocery'], true)) {
    $initialTplKey = 'fashion';
}
$initialPlanId = $plans[0]['id'] ?? 1;
foreach ($plans as $p) {
    if ($initialPlanSlug !== '' && (strtolower($p['slug']) === $initialPlanSlug || strtolower((string)$p['id']) === $initialPlanSlug)) {
        $initialPlanId = (int)$p['id'];
        break;
    }
}
if ($retryOrder) {
    $initialPlanId = (int)$retryOrder['plan_id'];
    $initialTplKey = $retryOrder['chosen_template'] ?: $initialTplKey;
}

$stripeEnabled   = ($settings['stripe_enabled'] ?? '0') === '1';
$razorpayEnabled = ($settings['razorpay_enabled'] ?? '0') === '1';
$payuEnabled     = ($settings['payu_enabled'] ?? '0') === '1';
$sandboxEnabled  = ($settings['sandbox_enabled'] ?? '1') === '1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Store — <?= htmlspecialchars($platformName) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        :root {
            --bg-dark: #070b14;
            --bg-card: #111827;
            --border-subtle: rgba(255, 255, 255, 0.1);
            --primary: #6366f1;
            --accent: #ec4899;
            --emerald: #10b981;
            --danger: #ef4444;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
        }
        .wizard-header {
            background: rgba(15, 23, 42, 0.9);
            border-bottom: 1px solid var(--border-subtle);
            padding: 16px 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            text-decoration: none;
            font-weight: 800;
            font-size: 1.25rem;
        }
        .brand-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .wizard-container {
            max-width: 1120px;
            margin: 36px auto 80px;
            padding: 0 20px;
        }
        /* Stepper */
        .stepper {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 36px;
        }
        .step-pill {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid var(--border-subtle);
            border-radius: 14px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            opacity: 0.6;
            transition: all 0.25s;
        }
        .step-pill.active {
            opacity: 1;
            border-color: var(--primary);
            background: rgba(99, 102, 241, 0.14);
        }
        .step-pill.completed {
            opacity: 1;
            border-color: var(--emerald);
            background: rgba(16, 185, 129, 0.1);
        }
        .step-num {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
        }
        .step-pill.active .step-num { background: var(--primary); color: #fff; }
        .step-pill.completed .step-num { background: var(--emerald); color: #fff; }
        .step-label { font-size: 0.88rem; font-weight: 700; }

        .step-panel {
            display: none;
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 22px;
            padding: 36px;
        }
        .step-panel.active { display: block; }

        .panel-title { margin: 0 0 6px; font-size: 1.65rem; font-weight: 800; }
        .panel-sub { margin: 0 0 28px; color: var(--text-muted); font-size: 0.96rem; }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }
        .select-card {
            background: rgba(15, 23, 42, 0.75);
            border: 2px solid var(--border-subtle);
            border-radius: 18px;
            padding: 24px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        .select-card:hover { border-color: rgba(99, 102, 241, 0.5); }
        .select-card.selected {
            border-color: var(--primary);
            background: rgba(99, 102, 241, 0.1);
            box-shadow: 0 12px 30px -10px rgba(99, 102, 241, 0.4);
        }
        .select-card.disabled-card {
            opacity: 0.45;
            cursor: not-allowed;
        }
        .card-check {
            position: absolute;
            top: 18px;
            right: 18px;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            color: transparent;
        }
        .select-card.selected .card-check {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        /* Forms */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block;
            font-size: 0.86rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: #cbd5e1;
        }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: #0b0f19;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            color: #fff;
            font-family: inherit;
            font-size: 0.95rem;
        }
        .form-control:focus { outline: none; border-color: var(--primary); }
        .field-hint { font-size: 0.8rem; color: var(--text-muted); margin-top: 5px; }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 13px 26px;
            border-radius: 11px;
            font-weight: 700;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
        }
        .btn-outline {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #fff;
        }
        .btn-emerald {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
        }
        .wizard-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid var(--border-subtle);
        }
        .alert-box {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.92rem;
            display: none;
        }
        .alert-error {
            background: rgba(239, 68, 68, 0.16);
            border: 1px solid var(--danger);
            color: #fca5a5;
        }
        .alert-success {
            background: rgba(16, 185, 129, 0.16);
            border: 1px solid var(--emerald);
            color: #6ee7b7;
        }
        .gateway-option {
            background: rgba(15, 23, 42, 0.85);
            border: 2px solid var(--border-subtle);
            border-radius: 14px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            margin-bottom: 12px;
        }
        .gateway-option.selected {
            border-color: var(--primary);
            background: rgba(99, 102, 241, 0.12);
        }
        @media (max-width: 768px) {
            .stepper { grid-template-columns: 1fr 1fr; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <header class="wizard-header">
        <a href="index.php" class="brand">
            <span class="brand-icon"><i class="fa-solid fa-layer-group"></i></span>
            <span><?= htmlspecialchars($platformName) ?></span>
        </a>
        <div>
            <a href="index.php" class="btn btn-outline" style="padding:8px 16px;font-size:0.86rem;">← Back to Home</a>
        </div>
    </header>

    <div class="wizard-container">

        <?php if ($activatedOrder && $activatedTenant): ?>
            <!-- STEP 5: ACTIVATED STORE SUCCESS PAGE -->
            <div class="step-panel active" style="text-align:center;padding:48px 36px;">
                <div style="width:76px;height:76px;border-radius:50%;background:rgba(16,185,129,0.2);color:#10b981;font-size:2.2rem;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h1 style="margin:0 0 10px;font-size:2.2rem;">Your E-Commerce Store Is Live!</h1>
                <p style="color:var(--text-muted);max-width:620px;margin:0 auto 32px;">
                    Payment has been verified and your isolated multi-tenant store, database records, and merchant dashboard have been provisioned.
                </p>

                <div style="max-width:680px;margin:0 auto 32px;background:rgba(15,23,42,0.85);border:1px solid var(--border-subtle);border-radius:18px;padding:26px;text-align:left;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                        <div>
                            <div style="font-size:0.8rem;color:var(--text-muted);">Store Name</div>
                            <div style="font-weight:700;font-size:1.05rem;"><?= htmlspecialchars($activatedTenant['business_name']) ?></div>
                        </div>
                        <div>
                            <div style="font-size:0.8rem;color:var(--text-muted);">Active Storefront Template</div>
                            <div style="font-weight:700;color:#818cf8;text-transform:capitalize;"><?= htmlspecialchars($activatedTenant['template']) ?> Store</div>
                        </div>
                        <div>
                            <div style="font-size:0.8rem;color:var(--text-muted);">Admin Login Email</div>
                            <div style="font-weight:700;"><?= htmlspecialchars($activatedTenant['admin_email']) ?></div>
                        </div>
                        <div>
                            <div style="font-size:0.8rem;color:var(--text-muted);">License / Order Reference</div>
                            <div style="font-weight:700;color:#34d399;"><?= htmlspecialchars($activatedTenant['license_key'] ?: $activatedOrder['order_number']) ?></div>
                        </div>
                        <div style="grid-column:span 2;">
                            <div style="font-size:0.8rem;color:var(--text-muted);">Live Storefront URL</div>
                            <a href="<?= htmlspecialchars($activatedTenant['website_url']) ?>" target="_blank" style="color:#38bdf8;font-weight:700;word-break:break-all;">
                                <?= htmlspecialchars($activatedTenant['website_url']) ?> <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </div>
                        <div style="grid-column:span 2;">
                            <div style="font-size:0.8rem;color:var(--text-muted);">Tenant Admin Dashboard URL</div>
                            <a href="<?= htmlspecialchars($activatedTenant['admin_url']) ?>" target="_blank" style="color:#a5b4fc;font-weight:700;word-break:break-all;">
                                <?= htmlspecialchars($activatedTenant['admin_url']) ?> <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div style="display:flex;justify-content:center;gap:16px;flex-wrap:wrap;">
                    <a href="<?= htmlspecialchars($activatedTenant['website_url']) ?>" target="_blank" class="btn btn-emerald">
                        <i class="fa-solid fa-store"></i> Open My Storefront
                    </a>
                    <a href="<?= htmlspecialchars($activatedTenant['admin_url']) ?>" class="btn btn-primary">
                        <i class="fa-solid fa-gauge-high"></i> Log In to Tenant Dashboard
                    </a>
                </div>
            </div>
        <?php else: ?>

            <!-- WIZARD STEPPER -->
            <div class="stepper">
                <div class="step-pill active" id="stepper-1">
                    <span class="step-num">1</span>
                    <span class="step-label">Select Pricing Plan</span>
                </div>
                <div class="step-pill" id="stepper-2">
                    <span class="step-num">2</span>
                    <span class="step-label">Owner Registration</span>
                </div>
                <div class="step-pill" id="stepper-3">
                    <span class="step-num">3</span>
                    <span class="step-label">Choose Template</span>
                </div>
                <div class="step-pill" id="stepper-4">
                    <span class="step-num">4</span>
                    <span class="step-label">Payment & Launch</span>
                </div>
            </div>

            <div id="wizard-alert" class="alert-box alert-error" <?= $paymentErrorMsg ? 'style="display:block;"' : '' ?>>
                <?= $paymentErrorMsg ?>
            </div>

            <!-- STEP 1: PLAN SELECTION -->
            <div class="step-panel active" id="panel-step-1">
                <h2 class="panel-title">Step 1: Choose Your Subscription Plan</h2>
                <p class="panel-sub">Select a pricing plan managed by the platform administrator. Plan limits and available templates are configured per tier.</p>

                <div class="cards-grid">
                    <?php foreach ($plans as $plan):
                        $isSel = ((int)$plan['id'] === (int)$initialPlanId);
                        $pLimit = ((int)$plan['product_limit'] === -1) ? 'Unlimited Products' : $plan['product_limit'] . ' Products';
                        $oLimit = ((int)$plan['order_limit'] === -1) ? 'Unlimited Orders' : $plan['order_limit'] . ' Orders/mo';
                    ?>
                    <div class="select-card plan-option <?= $isSel ? 'selected' : '' ?>"
                         data-plan-id="<?= (int)$plan['id'] ?>"
                         data-plan-name="<?= htmlspecialchars($plan['name']) ?>"
                         data-plan-price="<?= htmlspecialchars(number_format($plan['effective_price'], 2, '.', '')) ?>"
                         data-plan-cycle="<?= htmlspecialchars($plan['billing_cycle']) ?>"
                         data-allowed-templates='<?= htmlspecialchars(json_encode($plan['allowed_templates_list'])) ?>'
                         onclick="selectPlanCard(this)">
                        <div class="card-check"><i class="fa-solid fa-check"></i></div>
                        <?php if (!empty($plan['badge'])): ?>
                            <span style="display:inline-block;padding:4px 10px;border-radius:999px;background:rgba(99,102,241,0.2);color:#a5b4fc;font-size:0.75rem;font-weight:700;margin-bottom:10px;">
                                <?= htmlspecialchars($plan['badge']) ?>
                            </span>
                        <?php endif; ?>
                        <h3 style="margin:0 0 6px;font-size:1.3rem;"><?= htmlspecialchars($plan['name']) ?></h3>
                        <div style="font-size:2rem;font-weight:800;margin-bottom:8px;">
                            <?= htmlspecialchars($currencySym) ?><?= number_format($plan['effective_price'], 2) ?>
                            <span style="font-size:0.9rem;color:var(--text-muted);font-weight:500;">/ <?= htmlspecialchars($plan['billing_cycle']) ?></span>
                        </div>
                        <div style="font-size:0.84rem;color:#34d399;margin-bottom:14px;">
                            <?= htmlspecialchars($pLimit) ?> • <?= htmlspecialchars($oLimit) ?>
                        </div>
                        <ul style="list-style:none;padding:0;margin:0;font-size:0.86rem;color:#cbd5e1;">
                            <?php foreach (array_slice($plan['features_list'], 0, 4) as $f): ?>
                                <li style="margin-bottom:6px;"><i class="fa-solid fa-check" style="color:#10b981;margin-right:6px;"></i><?= htmlspecialchars($f) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="wizard-footer">
                    <a href="index.php" class="btn btn-outline">Cancel</a>
                    <button type="button" class="btn btn-primary" onclick="goToStep(2)">
                        Continue to Registration <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- STEP 2: BUSINESS OWNER REGISTRATION -->
            <div class="step-panel" id="panel-step-2">
                <h2 class="panel-title">Step 2: Business Owner & Store Registration</h2>
                <p class="panel-sub">Enter your merchant account details. Your paid subscription will only activate after payment verification in Step 4.</p>

                <form id="registration-form" onsubmit="submitRegistrationStep(event)">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Owner's Full Name *</label>
                            <input type="text" id="reg_owner_name" name="owner_name" class="form-control" required
                                   value="<?= htmlspecialchars($_SESSION['saas_registration']['owner_name'] ?? '') ?>"
                                   placeholder="e.g. Michael Carter">
                        </div>
                        <div class="form-group">
                            <label>Business / Store Name *</label>
                            <input type="text" id="reg_business_name" name="business_name" class="form-control" required
                                   value="<?= htmlspecialchars($_SESSION['saas_registration']['business_name'] ?? '') ?>"
                                   placeholder="e.g. Apex Tech Hub" oninput="autoGenerateSlug(this.value)">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Unique Store Slug / Subdomain *</label>
                            <input type="text" id="reg_store_slug" name="store_slug" class="form-control" required
                                   value="<?= htmlspecialchars($_SESSION['saas_registration']['store_slug'] ?? '') ?>"
                                   placeholder="e.g. apex-tech-hub" onblur="validateUniqueField('store_slug', this.value)">
                            <div class="field-hint" id="slug-preview-hint">
                                Store URL: <code><?= htmlspecialchars(saas_base_url('website/s/your-store')) ?></code>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Default Store Currency</label>
                            <select id="reg_currency" name="currency_code" class="form-control">
                                <option value="USD">USD ($) — US Dollar</option>
                                <option value="INR">INR (₹) — Indian Rupee</option>
                                <option value="EUR">EUR (€) — Euro</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Owner Email Address (Used for Admin Login) *</label>
                            <input type="email" id="reg_email" name="email" class="form-control" required
                                   value="<?= htmlspecialchars($_SESSION['saas_registration']['owner_email'] ?? '') ?>"
                                   placeholder="owner@yourstore.com" onblur="validateUniqueField('email', this.value)">
                        </div>
                        <div class="form-group">
                            <label>Phone Number *</label>
                            <input type="text" id="reg_phone" name="phone" class="form-control" required
                                   value="<?= htmlspecialchars($_SESSION['saas_registration']['owner_phone'] ?? '') ?>"
                                   placeholder="+1 (555) 234-5678">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Admin Password (min. 6 characters) *</label>
                            <input type="password" id="reg_password" name="password" class="form-control" required minlength="6" placeholder="••••••••">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password *</label>
                            <input type="password" id="reg_password_confirm" name="password_confirm" class="form-control" required minlength="6" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Business / Billing Address *</label>
                        <input type="text" id="reg_address" name="business_address" class="form-control" required
                               value="<?= htmlspecialchars($_SESSION['saas_registration']['business_address'] ?? '') ?>"
                               placeholder="450 Market Street, Suite 300, San Francisco, CA">
                    </div>

                    <div class="wizard-footer">
                        <button type="button" class="btn btn-outline" onclick="goToStep(1)">
                            <i class="fa-solid fa-arrow-left"></i> Back to Plans
                        </button>
                        <button type="submit" class="btn btn-primary" id="btn-reg-submit">
                            Save & Select Template <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- STEP 3: STORE TEMPLATE SELECTION -->
            <div class="step-panel" id="panel-step-3">
                <h2 class="panel-title">Step 3: Select Your Storefront Template</h2>
                <p class="panel-sub">Choose the visual storefront design for your store. You can preview any template live before locking in your selection.</p>

                <div class="cards-grid">
                    <?php foreach ($templates as $tpl):
                        $tKey = $tpl['template_key'];
                        $isSel = ($tKey === $initialTplKey);
                        $thumb = !empty($tpl['preview_image']) ? $tpl['preview_image'] : 'website/assets/images/templates/' . $tKey . '.jpg';
                    ?>
                    <div class="select-card tpl-option <?= $isSel ? 'selected' : '' ?>"
                         data-tpl-key="<?= htmlspecialchars($tKey) ?>"
                         data-tpl-name="<?= htmlspecialchars($tpl['name']) ?>"
                         onclick="selectTemplateCard(this)">
                        <div class="card-check"><i class="fa-solid fa-check"></i></div>
                        <div style="height:170px;border-radius:12px;overflow:hidden;margin-bottom:16px;background:#1e293b;">
                            <img src="<?= htmlspecialchars($thumb) ?>" alt="<?= htmlspecialchars($tpl['name']) ?>" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                        <span style="font-size:0.76rem;color:#38bdf8;font-weight:700;"><?= htmlspecialchars($tpl['badge']) ?></span>
                        <h3 style="margin:4px 0 6px;font-size:1.25rem;"><?= htmlspecialchars($tpl['name']) ?></h3>
                        <p style="font-size:0.86rem;color:var(--text-muted);margin:0 0 14px;"><?= htmlspecialchars($tpl['tagline']) ?></p>
                        <a href="launch.php?tpl=<?= urlencode($tKey) ?>" target="_blank" onclick="event.stopPropagation();" class="btn btn-outline" style="width:100%;padding:9px;font-size:0.84rem;">
                            <i class="fa-solid fa-eye"></i> Preview Live Demo
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="wizard-footer">
                    <button type="button" class="btn btn-outline" onclick="goToStep(2)">
                        <i class="fa-solid fa-arrow-left"></i> Back to Registration
                    </button>
                    <button type="button" class="btn btn-primary" id="btn-tpl-submit" onclick="saveTemplateAndProceedToPayment()">
                        Proceed to Payment Checkout <i class="fa-solid fa-credit-card"></i>
                    </button>
                </div>
            </div>

            <!-- STEP 4: PAYMENT GATEWAY CHECKOUT -->
            <div class="step-panel" id="panel-step-4">
                <h2 class="panel-title">Step 4: Complete Subscription Payment</h2>
                <p class="panel-sub">Your pending subscription order has been created. Choose a verified payment gateway to activate your tenant store.</p>

                <div style="display:grid;grid-template-columns:1fr 1.15fr;gap:28px;">
                    <!-- Order Summary -->
                    <div style="background:rgba(15,23,42,0.85);border:1px solid var(--border-subtle);border-radius:16px;padding:24px;">
                        <h4 style="margin:0 0 16px;font-size:1.1rem;color:#a5b4fc;">Subscription Summary</h4>
                        <div style="display:flex;justify-content:space-between;margin-bottom:10px;font-size:0.9rem;">
                            <span style="color:var(--text-muted);">Order Reference:</span>
                            <strong id="summary-order-num"><?= htmlspecialchars($retryOrder['order_number'] ?? 'Pending...') ?></strong>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:10px;font-size:0.9rem;">
                            <span style="color:var(--text-muted);">Selected Plan:</span>
                            <strong id="summary-plan-name">—</strong>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:10px;font-size:0.9rem;">
                            <span style="color:var(--text-muted);">Storefront Template:</span>
                            <strong id="summary-tpl-name" style="text-transform:capitalize;color:#38bdf8;">—</strong>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:16px;font-size:0.9rem;">
                            <span style="color:var(--text-muted);">Store Slug:</span>
                            <strong id="summary-store-slug"><?= htmlspecialchars($retryOrder['store_slug'] ?? ($_SESSION['saas_registration']['store_slug'] ?? '—')) ?></strong>
                        </div>
                        <hr style="border:0;border-top:1px solid var(--border-subtle);margin:16px 0;">
                        <div style="display:flex;justify-content:space-between;align-items:baseline;">
                            <span style="font-weight:700;">Total Due Now:</span>
                            <span style="font-size:1.85rem;font-weight:800;color:#34d399;" id="summary-amount">$0.00</span>
                        </div>
                    </div>

                    <!-- Payment Gateways -->
                    <div>
                        <h4 style="margin:0 0 14px;font-size:1.05rem;">Select Payment Method</h4>

                        <?php if ($razorpayEnabled): ?>
                        <div class="gateway-option selected" data-gateway="razorpay" onclick="selectGateway(this)">
                            <div>
                                <strong><i class="fa-solid fa-bolt" style="color:#38bdf8;margin-right:8px;"></i> Razorpay Checkout</strong>
                                <div style="font-size:0.82rem;color:var(--text-muted);">Cards, UPI, NetBanking & Wallets (HMAC-SHA256 Verified)</div>
                            </div>
                            <i class="fa-solid fa-circle-check" style="color:var(--primary);font-size:1.2rem;"></i>
                        </div>
                        <?php endif; ?>

                        <?php if ($stripeEnabled): ?>
                        <div class="gateway-option <?= !$razorpayEnabled ? 'selected' : '' ?>" data-gateway="stripe" onclick="selectGateway(this)">
                            <div>
                                <strong><i class="fa-brands fa-stripe" style="color:#818cf8;font-size:1.3rem;margin-right:8px;"></i> Stripe Hosted Checkout</strong>
                                <div style="font-size:0.82rem;color:var(--text-muted);">International Credit & Debit Cards (3D Secure)</div>
                            </div>
                            <i class="fa-solid fa-circle-check" style="color:var(--primary);font-size:1.2rem;"></i>
                        </div>
                        <?php endif; ?>

                        <?php if ($payuEnabled): ?>
                        <div class="gateway-option" data-gateway="payu" onclick="selectGateway(this)">
                            <div>
                                <strong><i class="fa-solid fa-building-columns" style="color:#f59e0b;margin-right:8px;"></i> PayU Money / Biz</strong>
                                <div style="font-size:0.82rem;color:var(--text-muted);">SHA-512 Encrypted Redirect Checkout</div>
                            </div>
                            <i class="fa-solid fa-circle-check" style="color:var(--primary);font-size:1.2rem;"></i>
                        </div>
                        <?php endif; ?>

                        <?php if ($sandboxEnabled): ?>
                        <div class="gateway-option <?= (!$razorpayEnabled && !$stripeEnabled) ? 'selected' : '' ?>" data-gateway="sandbox" onclick="selectGateway(this)">
                            <div>
                                <strong><i class="fa-solid fa-flask" style="color:#10b981;margin-right:8px;"></i> Sandbox / Instant Test Gateway</strong>
                                <div style="font-size:0.82rem;color:var(--text-muted);">Simulate verified payment or failed/cancelled callback for local testing</div>
                            </div>
                            <i class="fa-solid fa-circle-check" style="color:var(--primary);font-size:1.2rem;"></i>
                        </div>
                        <?php endif; ?>

                        <button type="button" class="btn btn-emerald" id="btn-pay-now" style="width:100%;padding:15px;margin-top:12px;font-size:1rem;" onclick="initiateSubscriptionPayment()">
                            <i class="fa-solid fa-lock"></i> Complete Verified Payment & Activate Store
                        </button>
                    </div>
                </div>

                <div class="wizard-footer">
                    <button type="button" class="btn btn-outline" onclick="goToStep(3)">
                        <i class="fa-solid fa-arrow-left"></i> Change Template
                    </button>
                    <span style="font-size:0.82rem;color:var(--text-muted);"><i class="fa-solid fa-shield-halved"></i> 256-Bit SSL Encrypted & Server-Verified</span>
                </div>
            </div>

        <?php endif; ?>

    </div>

    <!-- Hidden PayU Auto-Submit Form Container -->
    <div id="payu-form-container" style="display:none;"></div>

    <script>
        let currentStep = <?= $retryOrder ? 4 : 1 ?>;
        let selectedPlanId = <?= (int)$initialPlanId ?>;
        let selectedTemplate = <?= json_encode($initialTplKey) ?>;
        let pendingOrderNumber = <?= json_encode($retryOrder['order_number'] ?? ($_SESSION['saas_pending_order_number'] ?? '')) ?>;
        let selectedGateway = document.querySelector('.gateway-option.selected')
            ? document.querySelector('.gateway-option.selected').getAttribute('data-gateway')
            : 'sandbox';

        function showAlert(msg, isError = true) {
            const box = document.getElementById('wizard-alert');
            if (!box) return;
            box.className = 'alert-box ' + (isError ? 'alert-error' : 'alert-success');
            box.innerHTML = (isError ? '<i class="fa-solid fa-triangle-exclamation"></i> ' : '<i class="fa-solid fa-circle-check"></i> ') + msg;
            box.style.display = 'block';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function hideAlert() {
            const box = document.getElementById('wizard-alert');
            if (box) box.style.display = 'none';
        }

        function goToStep(step) {
            hideAlert();
            currentStep = step;
            for (let i = 1; i <= 4; i++) {
                const panel = document.getElementById('panel-step-' + i);
                const pill = document.getElementById('stepper-' + i);
                if (panel) panel.classList.toggle('active', i === step);
                if (pill) {
                    pill.classList.remove('active', 'completed');
                    if (i === step) pill.classList.add('active');
                    else if (i < step) pill.classList.add('completed');
                }
            }
            refreshTemplateEligibility();
            refreshOrderSummaryUI();
        }

        function selectPlanCard(el) {
            document.querySelectorAll('.plan-option').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            selectedPlanId = parseInt(el.getAttribute('data-plan-id'), 10);
            refreshTemplateEligibility();
        }

        function refreshTemplateEligibility() {
            const activePlanCard = document.querySelector('.plan-option.selected');
            if (!activePlanCard) return;
            let allowed = ['fashion', 'electronics', 'grocery'];
            try {
                allowed = JSON.parse(activePlanCard.getAttribute('data-allowed-templates') || '["fashion","electronics","grocery"]');
            } catch (e) {}

            document.querySelectorAll('.tpl-option').forEach(card => {
                const key = card.getAttribute('data-tpl-key');
                if (allowed.includes(key)) {
                    card.classList.remove('disabled-card');
                } else {
                    card.classList.add('disabled-card');
                    card.classList.remove('selected');
                }
            });

            if (!allowed.includes(selectedTemplate)) {
                selectedTemplate = allowed[0] || 'fashion';
                const fallbackCard = document.querySelector('.tpl-option[data-tpl-key="' + selectedTemplate + '"]');
                if (fallbackCard) fallbackCard.classList.add('selected');
            }
        }

        function selectTemplateCard(el) {
            if (el.classList.contains('disabled-card')) {
                showAlert('This template requires a higher plan tier. Please select a permitted template or upgrade your plan in Step 1.');
                return;
            }
            document.querySelectorAll('.tpl-option').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            selectedTemplate = el.getAttribute('data-tpl-key');
        }

        function selectGateway(el) {
            document.querySelectorAll('.gateway-option').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            selectedGateway = el.getAttribute('data-gateway');
        }

        function autoGenerateSlug(val) {
            const slugInput = document.getElementById('reg_store_slug');
            if (!slugInput || slugInput.dataset.manual === '1') return;
            const slug = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            slugInput.value = slug;
            document.getElementById('slug-preview-hint').innerHTML =
                'Store URL: <code><?= htmlspecialchars(saas_base_url('website/s/')) ?>' + (slug || 'your-store') + '</code>';
        }

        async function validateUniqueField(field, value) {
            if (!value) return;
            const fd = new FormData();
            fd.append('action', 'check_unique');
            fd.append(field, value);
            try {
                const res = await fetch('subscribe_api.php', { method: 'POST', body: fd });
                const data = await res.json();
                if (!data.valid) {
                    showAlert(data.message, true);
                } else {
                    hideAlert();
                    if (field === 'store_slug' && data.slug) {
                        document.getElementById('reg_store_slug').value = data.slug;
                        document.getElementById('slug-preview-hint').innerHTML =
                            'Store URL: <code style="color:#34d399;">' + data.store_url + ' ✓ Available</code>';
                    }
                }
            } catch (e) {}
        }

        async function submitRegistrationStep(e) {
            e.preventDefault();
            hideAlert();
            const btn = document.getElementById('btn-reg-submit');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Validating...';

            const form = document.getElementById('registration-form');
            const fd = new FormData(form);
            fd.append('action', 'register_step');
            fd.append('plan_id', selectedPlanId);
            fd.append('template', selectedTemplate);

            try {
                const res = await fetch('subscribe_api.php', { method: 'POST', body: fd });
                const data = await res.json();
                btn.disabled = false;
                btn.innerHTML = 'Save & Select Template <i class="fa-solid fa-arrow-right"></i>';

                if (!data.success) {
                    showAlert(data.message, true);
                    return;
                }
                document.getElementById('summary-store-slug').textContent = data.store_slug;
                goToStep(3);
            } catch (err) {
                btn.disabled = false;
                btn.innerHTML = 'Save & Select Template <i class="fa-solid fa-arrow-right"></i>';
                showAlert('Network error while validating registration.', true);
            }
        }

        async function saveTemplateAndProceedToPayment() {
            hideAlert();
            const btn = document.getElementById('btn-tpl-submit');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Creating Pending Order...';

            const fd = new FormData();
            fd.append('action', 'save_template_and_create_pending_order');
            fd.append('plan_id', selectedPlanId);
            fd.append('template', selectedTemplate);

            try {
                const res = await fetch('subscribe_api.php', { method: 'POST', body: fd });
                const data = await res.json();
                btn.disabled = false;
                btn.innerHTML = 'Proceed to Payment Checkout <i class="fa-solid fa-credit-card"></i>';

                if (!data.success) {
                    showAlert(data.message, true);
                    return;
                }
                pendingOrderNumber = data.order_number;
                document.getElementById('summary-order-num').textContent = data.order_number;
                goToStep(4);
            } catch (err) {
                btn.disabled = false;
                btn.innerHTML = 'Proceed to Payment Checkout <i class="fa-solid fa-credit-card"></i>';
                showAlert('Error creating pending subscription order.', true);
            }
        }

        function refreshOrderSummaryUI() {
            const planCard = document.querySelector('.plan-option.selected');
            if (planCard) {
                document.getElementById('summary-plan-name').textContent = planCard.getAttribute('data-plan-name');
                document.getElementById('summary-amount').textContent = '<?= addslashes($currencySym) ?>' + planCard.getAttribute('data-plan-price');
            }
            document.getElementById('summary-tpl-name').textContent = selectedTemplate + ' Store';
        }

        async function initiateSubscriptionPayment() {
            hideAlert();
            if (!pendingOrderNumber) {
                showAlert('Please complete registration and template selection first.', true);
                return;
            }

            const btn = document.getElementById('btn-pay-now');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Initializing Payment Gateway...';

            if (selectedGateway === 'sandbox') {
                const fd = new FormData();
                fd.append('action', 'process_sandbox_payment');
                fd.append('order_number', pendingOrderNumber);
                fd.append('simulate_outcome', 'success');

                const res = await fetch('subscribe_api.php', { method: 'POST', body: fd });
                const data = await res.json();
                if (data.success) {
                    window.location.href = 'subscribe.php?activated_order=' + encodeURIComponent(pendingOrderNumber);
                } else {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-lock"></i> Complete Verified Payment & Activate Store';
                    showAlert(data.message || 'Sandbox payment failed.', true);
                }
                return;
            }

            const fd = new FormData();
            fd.append('order_number', pendingOrderNumber);
            fd.append('gateway', selectedGateway);

            try {
                const res = await fetch('create_payment.php', { method: 'POST', body: fd });
                const data = await res.json();

                if (!data.success) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-lock"></i> Complete Verified Payment & Activate Store';
                    showAlert(data.message || 'Gateway initialization failed.', true);
                    return;
                }

                if (data.gateway === 'stripe' && data.checkout_url) {
                    window.location.href = data.checkout_url;
                    return;
                }

                if (data.gateway === 'razorpay') {
                    const options = {
                        key: data.key_id,
                        amount: data.amount,
                        currency: data.currency,
                        name: <?= json_encode($platformName) ?>,
                        description: 'Subscription Order ' + data.order_number,
                        order_id: data.razorpay_order_id || undefined,
                        prefill: {
                            name: data.customer_name,
                            email: data.customer_email,
                            contact: data.customer_phone
                        },
                        handler: async function (response) {
                            const vfd = new FormData();
                            vfd.append('action', 'verify_razorpay_payment');
                            vfd.append('order_number', data.order_number);
                            vfd.append('razorpay_payment_id', response.razorpay_payment_id || '');
                            vfd.append('razorpay_order_id', response.razorpay_order_id || '');
                            vfd.append('razorpay_signature', response.razorpay_signature || '');
                            const vRes = await fetch('subscribe_api.php', { method: 'POST', body: vfd });
                            const vData = await vRes.json();
                            if (vData.success) {
                                window.location.href = 'subscribe.php?activated_order=' + encodeURIComponent(data.order_number);
                            } else {
                                showAlert(vData.message || 'Payment verification failed.', true);
                                btn.disabled = false;
                                btn.innerHTML = '<i class="fa-solid fa-lock"></i> Retry Payment';
                            }
                        },
                        modal: {
                            ondismiss: async function () {
                                const cfd = new FormData();
                                cfd.append('action', 'mark_payment_failed');
                                cfd.append('order_number', data.order_number);
                                cfd.append('status', 'cancelled');
                                await fetch('subscribe_api.php', { method: 'POST', body: cfd });
                                btn.disabled = false;
                                btn.innerHTML = '<i class="fa-solid fa-lock"></i> Retry Payment';
                                showAlert('Payment popup was closed. Your subscription is still pending — click Retry Payment when ready.', true);
                            }
                        }
                    };
                    const rzp = new Razorpay(options);
                    rzp.open();
                    return;
                }

                if (data.gateway === 'payu' && data.action && data.params) {
                    let formHtml = '<form id="payu-auto-form" method="post" action="' + data.action + '">';
                    for (const [k, v] of Object.entries(data.params)) {
                        formHtml += '<input type="hidden" name="' + k + '" value="' + String(v).replace(/"/g, '&quot;') + '">';
                    }
                    formHtml += '</form>';
                    document.getElementById('payu-form-container').innerHTML = formHtml;
                    document.getElementById('payu-auto-form').submit();
                    return;
                }
            } catch (err) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-lock"></i> Complete Verified Payment & Activate Store';
                showAlert('Error communicating with payment server.', true);
            }
        }

        // Initialize UI state
        if (currentStep === 4) {
            goToStep(4);
        } else {
            refreshTemplateEligibility();
            refreshOrderSummaryUI();
        }
    </script>
</body>
</html>
