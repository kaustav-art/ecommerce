<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold m-0"><span class="text-muted fw-light">Settings /</span> Store & System Configuration</h4>
  </div>

  <div class="row">
    <div class="col-md-3 mb-4">
      <div class="list-group shadow-sm">
        <a href="#tab-general" data-bs-toggle="list" class="list-group-item list-group-item-action <?= ($active_tab === 'general') ? 'active' : ''; ?>">
          <i class="fa-solid fa-sliders me-2"></i> General Settings
        </a>
        <a href="#tab-shipping" data-bs-toggle="list" class="list-group-item list-group-item-action <?= ($active_tab === 'shipping') ? 'active' : ''; ?>">
          <i class="fa-solid fa-truck-fast me-2"></i> Shipping Settings
        </a>
        <a href="#tab-tax" data-bs-toggle="list" class="list-group-item list-group-item-action <?= ($active_tab === 'tax') ? 'active' : ''; ?>">
          <i class="fa-solid fa-receipt me-2"></i> Tax Settings
        </a>
        <a href="#tab-email" data-bs-toggle="list" class="list-group-item list-group-item-action <?= ($active_tab === 'email') ? 'active' : ''; ?>">
          <i class="fa-solid fa-envelope me-2"></i> Email (SMTP) Settings
        </a>
        <a href="#tab-sms" data-bs-toggle="list" class="list-group-item list-group-item-action <?= ($active_tab === 'sms') ? 'active' : ''; ?>">
          <i class="fa-solid fa-comment-sms me-2"></i> SMS Settings
        </a>
        <a href="#tab-seo" data-bs-toggle="list" class="list-group-item list-group-item-action <?= ($active_tab === 'seo') ? 'active' : ''; ?>">
          <i class="fa-solid fa-globe me-2"></i> SEO & Meta Settings
        </a>
        <a href="<?= site_url('settings/payment'); ?>" class="list-group-item list-group-item-action">
          <i class="fa-solid fa-credit-card me-2"></i> Payment Gateways &raquo;
        </a>
      </div>
    </div>

    <div class="col-md-9">
      <div class="tab-content p-0 shadow-none">
        <!-- Tab 1: General Settings -->
        <div class="tab-pane fade <?= ($active_tab === 'general') ? 'show active' : ''; ?>" id="tab-general">
          <div class="card">
            <div class="card-header border-bottom">
              <h5 class="card-title mb-0">General Store Information</h5>
            </div>
            <div class="card-body pt-4">
              <form action="<?= site_url('settings'); ?>" method="POST">
                <input type="hidden" name="setting_group" value="general">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Store Brand Name</label>
                    <input type="text" class="form-control" name="site_name" value="<?= html_escape($settings['site_name'] ?? ''); ?>" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Support Email</label>
                    <input type="email" class="form-control" name="admin_email" value="<?= html_escape($settings['admin_email'] ?? ($settings['site_email'] ?? '')); ?>" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Support Phone</label>
                    <input type="text" class="form-control" name="support_phone" value="<?= html_escape($settings['support_phone'] ?? ($settings['site_phone'] ?? '')); ?>">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label class="form-label">Currency Code</label>
                    <input type="text" class="form-control" name="currency" value="<?= html_escape($settings['currency'] ?? 'USD'); ?>">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label class="form-label">Currency Symbol</label>
                    <input type="text" class="form-control" name="currency_symbol" value="<?= html_escape($settings['currency_symbol'] ?? '$'); ?>">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Timezone</label>
                    <input type="text" class="form-control" name="timezone" value="<?= html_escape($settings['timezone'] ?? 'America/New_York'); ?>">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Physical Store / HQ Address</label>
                    <textarea class="form-control" name="store_address" rows="2"><?= html_escape($settings['store_address'] ?? ($settings['site_address'] ?? '')); ?></textarea>
                  </div>
                </div>

                <button type="submit" class="btn btn-primary">Save General Settings</button>
              </form>
            </div>
          </div>
        </div>

        <!-- Tab 2: Shipping Settings -->
        <div class="tab-pane fade <?= ($active_tab === 'shipping') ? 'show active' : ''; ?>" id="tab-shipping">
          <div class="card">
            <div class="card-header border-bottom">
              <h5 class="card-title mb-0">Shipping Rates & Rules</h5>
            </div>
            <div class="card-body pt-4">
              <form action="<?= site_url('settings'); ?>" method="POST">
                <input type="hidden" name="setting_group" value="shipping">
                
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Standard Flat Rate ($)</label>
                    <input type="number" step="0.01" class="form-control" name="shipping_flat_rate" value="<?= html_escape($settings['shipping_flat_rate'] ?? '15.00'); ?>" required>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Express Priority Rate ($)</label>
                    <input type="number" step="0.01" class="form-control" name="shipping_express_rate" value="<?= html_escape($settings['shipping_express_rate'] ?? '25.00'); ?>" required>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="form-label">Free Shipping Minimum ($)</label>
                    <input type="number" step="0.01" class="form-control" name="shipping_free_threshold" value="<?= html_escape($settings['shipping_free_threshold'] ?? '150.00'); ?>" required>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Estimated Delivery Dispatch Note</label>
                  <input type="text" class="form-control" name="shipping_dispatch_note" value="<?= html_escape($settings['shipping_dispatch_note'] ?? 'Dispatched within 24-48 hours with courier tracking.'); ?>">
                </div>

                <button type="submit" class="btn btn-primary">Save Shipping Settings</button>
              </form>
            </div>
          </div>
        </div>

        <!-- Tab 3: Tax Settings -->
        <div class="tab-pane fade <?= ($active_tab === 'tax') ? 'show active' : ''; ?>" id="tab-tax">
          <div class="card">
            <div class="card-header border-bottom">
              <h5 class="card-title mb-0">Tax Calculation Rules</h5>
            </div>
            <div class="card-body pt-4">
              <form action="<?= site_url('settings'); ?>" method="POST">
                <input type="hidden" name="setting_group" value="tax">
                
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Enable Tax Calculation</label>
                    <select class="form-select" name="tax_enabled">
                      <option value="1" <?= (($settings['tax_enabled'] ?? '1') == '1') ? 'selected' : ''; ?>>Enabled</option>
                      <option value="0" <?= (($settings['tax_enabled'] ?? '') == '0') ? 'selected' : ''; ?>>Disabled</option>
                    </select>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Default Tax Rate (%)</label>
                    <input type="number" step="0.01" class="form-control" name="tax_rate" value="<?= html_escape($settings['tax_rate'] ?? '8.5'); ?>" required>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Tax Price Display Mode</label>
                  <select class="form-select" name="tax_inclusive">
                    <option value="0" <?= (($settings['tax_inclusive'] ?? '0') == '0') ? 'selected' : ''; ?>>Prices are Exclusive of Tax (Tax added at checkout)</option>
                    <option value="1" <?= (($settings['tax_inclusive'] ?? '') == '1') ? 'selected' : ''; ?>>Prices are Inclusive of Tax</option>
                  </select>
                </div>

                <button type="submit" class="btn btn-primary">Save Tax Settings</button>
              </form>
            </div>
          </div>
        </div>

        <!-- Tab 4: Email / SMTP Settings -->
        <div class="tab-pane fade <?= ($active_tab === 'email') ? 'show active' : ''; ?>" id="tab-email">
          <div class="card">
            <div class="card-header border-bottom">
              <h5 class="card-title mb-0">Outgoing Mail (SMTP) Configuration</h5>
            </div>
            <div class="card-body pt-4">
              <form action="<?= site_url('settings'); ?>" method="POST">
                <input type="hidden" name="setting_group" value="email">
                
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">SMTP Host</label>
                    <input type="text" class="form-control" name="smtp_host" value="<?= html_escape($settings['smtp_host'] ?? 'smtp.mailtrap.io'); ?>">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label class="form-label">SMTP Port</label>
                    <input type="number" class="form-control" name="smtp_port" value="<?= html_escape($settings['smtp_port'] ?? '587'); ?>">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label class="form-label">Encryption</label>
                    <select class="form-select" name="smtp_crypto">
                      <option value="tls" <?= (($settings['smtp_crypto'] ?? 'tls') === 'tls') ? 'selected' : ''; ?>>TLS</option>
                      <option value="ssl" <?= (($settings['smtp_crypto'] ?? '') === 'ssl') ? 'selected' : ''; ?>>SSL</option>
                      <option value="" <?= (empty($settings['smtp_crypto'])) ? 'selected' : ''; ?>>None</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">SMTP Username</label>
                    <input type="text" class="form-control" name="smtp_user" value="<?= html_escape($settings['smtp_user'] ?? ''); ?>">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">SMTP Password</label>
                    <input type="password" class="form-control" name="smtp_pass" value="<?= html_escape($settings['smtp_pass'] ?? ''); ?>">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Sender Email Address</label>
                    <input type="email" class="form-control" name="from_email" value="<?= html_escape($settings['from_email'] ?? 'orders@modave.com'); ?>">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Sender Name</label>
                    <input type="text" class="form-control" name="from_name" value="<?= html_escape($settings['from_name'] ?? 'Modave Online Store'); ?>">
                  </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Email Settings</button>
              </form>
            </div>
          </div>
        </div>

        <!-- Tab 5: SMS Settings -->
        <div class="tab-pane fade <?= ($active_tab === 'sms') ? 'show active' : ''; ?>" id="tab-sms">
          <div class="card">
            <div class="card-header border-bottom">
              <h5 class="card-title mb-0">SMS Notification Gateway</h5>
            </div>
            <div class="card-body pt-4">
              <form action="<?= site_url('settings'); ?>" method="POST">
                <input type="hidden" name="setting_group" value="sms">
                
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">SMS Gateway</label>
                    <select class="form-select" name="sms_gateway">
                      <option value="twilio" <?= (($settings['sms_gateway'] ?? 'twilio') === 'twilio') ? 'selected' : ''; ?>>Twilio</option>
                      <option value="msg91" <?= (($settings['sms_gateway'] ?? '') === 'msg91') ? 'selected' : ''; ?>>MSG91</option>
                      <option value="nexmo" <?= (($settings['sms_gateway'] ?? '') === 'nexmo') ? 'selected' : ''; ?>>Vonage / Nexmo</option>
                    </select>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Sender Number / ID</label>
                    <input type="text" class="form-control" name="sms_sender_number" value="<?= html_escape($settings['sms_sender_number'] ?? '+18005550199'); ?>">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Account SID / API Key</label>
                    <input type="text" class="form-control" name="sms_account_sid" value="<?= html_escape($settings['sms_account_sid'] ?? ''); ?>">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Auth Token / Secret</label>
                    <input type="password" class="form-control" name="sms_auth_token" value="<?= html_escape($settings['sms_auth_token'] ?? ''); ?>">
                  </div>
                </div>

                <button type="submit" class="btn btn-primary">Save SMS Settings</button>
              </form>
            </div>
          </div>
        </div>

        <!-- Tab 6: SEO Settings -->
        <div class="tab-pane fade <?= ($active_tab === 'seo') ? 'show active' : ''; ?>" id="tab-seo">
          <div class="card">
            <div class="card-header border-bottom">
              <h5 class="card-title mb-0">Search Engine Optimization (SEO) & Analytics</h5>
            </div>
            <div class="card-body pt-4">
              <form action="<?= site_url('settings'); ?>" method="POST">
                <input type="hidden" name="setting_group" value="seo">
                
                <div class="mb-3">
                  <label class="form-label">Default Meta Title</label>
                  <input type="text" class="form-control" name="meta_title" value="<?= html_escape($settings['meta_title'] ?? 'Modave - Multipurpose Modern eCommerce Platform'); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">Default Meta Description</label>
                  <textarea class="form-control" name="meta_description" rows="3"><?= html_escape($settings['meta_description'] ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                  <label class="form-label">Meta Keywords</label>
                  <input type="text" class="form-control" name="meta_keywords" value="<?= html_escape($settings['meta_keywords'] ?? 'fashion, electronics, grocery, online shopping'); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">Google Analytics / Tag Manager Measurement ID</label>
                  <input type="text" class="form-control" name="google_analytics_id" value="<?= html_escape($settings['google_analytics_id'] ?? 'G-XXXXXXXXXX'); ?>">
                </div>

                <button type="submit" class="btn btn-primary">Save SEO Settings</button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
