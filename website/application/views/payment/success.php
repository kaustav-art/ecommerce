<?php
$dispatch_note = !empty($store_settings['shipping_dispatch_note']) 
    ? $store_settings['shipping_dispatch_note'] 
    : 'Dispatched within 24-48 hours with courier tracking.';
$is_cod = (!empty($order['payment_method']) && (strtolower($order['payment_method']) === 'cod' || strpos(strtolower($order['payment_method']), 'cash') !== false));
$is_paid = (!empty($order['payment_status']) && strtolower($order['payment_status']) === 'paid');

// Clean and deduplicate recipient name, address lines, and phone number
$raw_address = trim($order['shipping_address'] ?? '');
$lines = array_filter(array_map('trim', preg_split('/[\r\n]+/', $raw_address)));

$clean_lines = [];
$recipient_name = !empty($order['customer_name']) ? trim($order['customer_name']) : '';
$recipient_phone = !empty($order['customer_phone']) ? trim($order['customer_phone']) : '';
$addr_type = !empty($order['address_type']) ? strtoupper($order['address_type']) : '';

foreach ($lines as $line) {
    if (preg_match('/\((WORK|HOME)\)/i', $line, $m)) {
        if (empty($addr_type)) {
            $addr_type = strtoupper($m[1]);
        }
        $line = trim(preg_replace('/\((WORK|HOME)\)/i', '', $line));
    }

    // Skip if line matches recipient name or begins with it
    if (!empty($recipient_name) && (strcasecmp($line, $recipient_name) === 0 || stripos($line, $recipient_name) === 0)) {
        continue;
    }

    // Skip if line contains phone/mobile number
    if (preg_match('/^(phone|mobile):\s*(.*)$/i', $line, $pm)) {
        if (empty($recipient_phone) && !empty($pm[2])) {
            $recipient_phone = trim($pm[2]);
        }
        continue;
    }

    if (!empty($line)) {
        $clean_lines[] = $line;
    }
}

$display_address = !empty($clean_lines) ? implode(', ', $clean_lines) : '';
?>

<style>
/* Simple & Clean Modern Order Success Page */
.order-success-section {
    background-color: #f8fafc;
    min-height: calc(100vh - 120px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 16px;
}
.order-success-card {
    max-width: 580px;
    width: 100%;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    padding: 36px 32px;
    text-align: center;
}
.success-icon-wrap {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    background: #ecfdf5;
    color: #10b981;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    margin-bottom: 16px;
}
.order-success-title {
    font-size: 22px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 6px;
}
.order-success-subtitle {
    font-size: 13px;
    color: #64748b;
    margin-bottom: 16px;
    line-height: 1.5;
}
.order-id-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 13px;
    color: #475569;
    margin-bottom: 24px;
}
.btn-copy-id {
    background: none;
    border: none;
    padding: 0;
    color: #94a3b8;
    cursor: pointer;
    font-size: 13px;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    transition: color 0.2s ease;
}
.btn-copy-id:hover {
    color: #1e293b;
}

/* Dynamic Delivery Notice */
.delivery-notice-strip {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 12px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    text-align: left;
    margin-bottom: 22px;
}
.delivery-icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #ffffff;
    border: 1px solid #86efac;
    color: #16a34a;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.delivery-notice-content {
    flex: 1;
    min-width: 0;
}
.delivery-notice-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: #16a34a;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}
.delivery-notice-text {
    font-size: 13px;
    font-weight: 600;
    color: #1e293b;
    line-height: 1.35;
}

/* Order Summary Box */
.order-summary-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 24px;
    text-align: left;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 10px 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
}
.summary-row:first-child {
    padding-top: 0;
}
.summary-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.summary-label {
    color: #64748b;
    font-weight: 500;
    flex-shrink: 0;
    margin-right: 12px;
}
.summary-value {
    color: #0f172a;
    font-weight: 600;
    text-align: right;
    word-break: break-word;
}

/* Actions */
.action-buttons-wrap {
    display: flex;
    gap: 12px;
}
.btn-action-primary {
    background-color: #2874f0;
    color: #ffffff !important;
    border: 1px solid #2874f0;
    font-weight: 600;
    padding: 11px 20px;
    border-radius: 8px;
    text-decoration: none;
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 14px;
    transition: background-color 0.2s ease;
}
.btn-action-primary:hover {
    background-color: #1a62d6;
    border-color: #1a62d6;
}
.btn-action-secondary {
    background-color: #ffffff;
    color: #334155 !important;
    border: 1px solid #cbd5e1;
    font-weight: 600;
    padding: 11px 20px;
    border-radius: 8px;
    text-decoration: none;
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 14px;
    transition: all 0.2s ease;
}
.btn-action-secondary:hover {
    background-color: #f8fafc;
    border-color: #94a3b8;
    color: #0f172a !important;
}

/* Help Footer */
.order-help-footer {
    margin-top: 20px;
    font-size: 12px;
    color: #94a3b8;
}
.order-help-footer a {
    color: #2874f0;
    text-decoration: none;
    font-weight: 500;
}
.order-help-footer a:hover {
    text-decoration: underline;
}

/* Mobile Responsiveness */
@media (max-width: 576px) {
    .order-success-section {
        padding: 16px 12px;
    }
    .order-success-card {
        padding: 24px 18px;
        border-radius: 12px;
    }
    .order-success-title {
        font-size: 19px;
    }
    .order-success-subtitle {
        font-size: 12px;
    }
    .summary-row {
        flex-direction: column;
        gap: 3px;
    }
    .summary-value {
        text-align: left;
    }
    .action-buttons-wrap {
        flex-direction: column;
        gap: 10px;
    }
    .btn-action-primary,
    .btn-action-secondary {
        width: 100%;
        padding: 12px 16px;
    }
}
</style>

<section class="order-success-section">
    <div class="order-success-card">
        
        <!-- Checkmark Icon -->
        <div class="success-icon-wrap">
            <i class="fa-solid fa-check"></i>
        </div>

        <!-- Heading & Email -->
        <h1 class="order-success-title">Order Placed Successfully!</h1>
        <p class="order-success-subtitle">
            Thank you for your order. A confirmation has been sent to <br class="d-none d-sm-inline">
            <strong class="text-dark"><?= html_escape($order['customer_email']); ?></strong>
        </p>

        <!-- Order ID Pill -->
        <div class="order-id-pill">
            <span>Order ID: <strong class="text-dark font-monospace">#<?= html_escape($order['order_number']); ?></strong></span>
            <button type="button" class="btn-copy-id" id="btn-copy-order-id" title="Copy Order ID" onclick="copyOrderId('<?= html_escape($order['order_number']); ?>')">
                <i class="fa-regular fa-copy"></i>
            </button>
        </div>

        <!-- Dynamic Delivery Notice Banner -->
        <div class="delivery-notice-strip">
            <div class="delivery-icon-circle">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div class="delivery-notice-content">
                <div class="delivery-notice-label">
                    <i class="fa-solid fa-clock-rotate-left me-1"></i> Delivery & Dispatch Notice
                </div>
                <div class="delivery-notice-text">
                    <?= html_escape($dispatch_note); ?>
                </div>
            </div>

        </div>

        <!-- Clean Summary Box -->
        <div class="order-summary-box">
            <div class="summary-row">
                <span class="summary-label">Delivery Address:</span>
                <span class="summary-value">
                    <span class="fw-bold text-dark"><?= html_escape($recipient_name); ?></span>
                    <?php if (!empty($addr_type)): ?>
                        <span class="badge bg-light text-secondary border ms-1" style="font-size: 10px; font-weight: 600;"><?= $addr_type; ?></span>
                    <?php endif; ?>
                    <?php if (!empty($display_address)): ?>
                        <span class="text-muted fw-normal small d-block mt-0.5"><?= html_escape($display_address); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($recipient_phone)): ?>
                        <span class="text-muted fw-normal small d-block mt-0.5">• Phone: <?= html_escape($recipient_phone); ?></span>
                    <?php endif; ?>
                </span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Payment Method:</span>
                <span class="summary-value">
                    <span class="badge bg-light text-dark border px-2 py-1 text-uppercase me-1" style="font-size: 11px;">
                        <?= strtoupper($order['payment_method']); ?>
                    </span>
                    <?php if ($is_paid): ?>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 text-uppercase" style="font-size: 11px;">
                            Paid
                        </span>
                    <?php else: ?>
                        <span class="badge bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-25 px-2 py-1 text-uppercase" style="font-size: 11px;">
                            Pay on Delivery
                        </span>
                    <?php endif; ?>
                </span>
            </div>
            <?php if (!empty($order['payment_transaction_id'])): ?>
                <div class="summary-row">
                    <span class="summary-label">Transaction ID:</span>
                    <span class="summary-value font-monospace small text-muted">
                        <?= html_escape(strlen($order['payment_transaction_id']) > 20 ? substr($order['payment_transaction_id'], 0, 20) . '...' : $order['payment_transaction_id']); ?>
                    </span>
                </div>
            <?php endif; ?>
            <div class="summary-row" style="align-items: center;">
                <span class="summary-label fw-bold text-dark"><?= $is_cod ? 'Total to Pay:' : 'Total Paid:'; ?></span>
                <span class="summary-value text-primary fs-5 fw-bold">
                    <?= $currency_symbol . number_format($order['total_amount'], 2); ?>
                </span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons-wrap">
            <a href="<?= site_url('order/track?order_number=' . $order['order_number'] . '&email=' . urlencode($order['customer_email'])); ?>" class="btn-action-primary">
                <i class="fa-solid fa-truck-fast"></i> Track Order
            </a>
            <a href="<?= site_url('shop'); ?>" class="btn-action-secondary">
                <i class="fa-solid fa-bag-shopping"></i> Continue Shopping
            </a>
        </div>

        <!-- Footer / Support Link -->
        <div class="order-help-footer">
            <span><i class="fa-solid fa-shield-halved text-success me-1"></i> 100% Safe & Secure Transaction</span>
            <span class="mx-2">•</span>
            <span>Need help? <a href="<?= site_url('contact'); ?>">Contact Support</a></span>
        </div>

    </div>
</section>

<script>
function copyOrderId(orderId) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(orderId).then(onCopied);
    } else {
        var textArea = document.createElement('textarea');
        textArea.value = orderId;
        textArea.style.position = 'fixed';
        textArea.style.opacity = '0';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            onCopied();
        } catch (err) {}
        document.body.removeChild(textArea);
    }
}
function onCopied() {
    var btn = document.getElementById('btn-copy-order-id');
    if (btn) {
        btn.innerHTML = '<i class="fa-solid fa-check text-success"></i>';
        setTimeout(function() {
            btn.innerHTML = '<i class="fa-regular fa-copy"></i>';
        }, 2000);
    }
}
</script>
