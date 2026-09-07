<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold m-0"><span class="text-muted fw-light">Settings /</span> Payment Gateways</h4>
      <small class="text-muted">Configure API keys, secrets, and modes for Stripe, Razorpay, and PayU</small>
    </div>
  </div>

  <div class="row">
    <!-- Stripe Configuration -->
    <?php
      $stripe = null;
      $razorpay = null;
      $payu = null;
      foreach ($gateways as $g) {
        if ($g['gateway_code'] === 'stripe') $stripe = $g;
        elseif ($g['gateway_code'] === 'razorpay') $razorpay = $g;
        elseif ($g['gateway_code'] === 'payu') $payu = $g;
      }
    ?>

    <!-- 1. Stripe Card -->
    <div class="col-12 col-lg-4 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">
            <i class="fa-solid fa-shield-halved text-primary me-1"></i> Stripe
          </h5>
          <span class="badge bg-label-<?= ($stripe && $stripe['is_active']) ? 'success' : 'secondary'; ?>">
            <?= ($stripe && $stripe['is_active']) ? 'Active' : 'Disabled'; ?>
          </span>
        </div>
        <div class="card-body">
          <form action="<?= site_url('settings/payment'); ?>" method="POST">
            <input type="hidden" name="gateway" value="stripe" />

            <div class="form-check form-switch mb-3">
              <input class="form-check-input" type="checkbox" id="stripe_active" name="stripe_active" value="1" <?= ($stripe && $stripe['is_active']) ? 'checked' : ''; ?> />
              <label class="form-check-label" for="stripe_active">Enable Stripe</label>
            </div>

            <div class="mb-3">
              <label class="form-label">Environment</label>
              <select name="stripe_env" class="form-select">
                <option value="test" <?= ($stripe && $stripe['environment'] === 'test') ? 'selected' : ''; ?>>Test / Sandbox</option>
                <option value="live" <?= ($stripe && $stripe['environment'] === 'live') ? 'selected' : ''; ?>>Production / Live</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label" for="stripe_publishable_key">Publishable Key</label>
              <input
                type="text"
                class="form-control font-monospace small"
                id="stripe_publishable_key"
                name="stripe_publishable_key"
                value="<?= html_escape($stripe['credentials_decoded']['publishable_key'] ?? ''); ?>"
                placeholder="pk_test_..." />
            </div>

            <div class="mb-3">
              <label class="form-label" for="stripe_secret_key">Secret Key</label>
              <input
                type="password"
                class="form-control font-monospace small"
                id="stripe_secret_key"
                name="stripe_secret_key"
                value="<?= html_escape($stripe['credentials_decoded']['secret_key'] ?? ''); ?>"
                placeholder="sk_test_..." />
            </div>

            <div class="mb-3">
              <label class="form-label" for="stripe_webhook_secret">Webhook Secret (Optional)</label>
              <input
                type="password"
                class="form-control font-monospace small"
                id="stripe_webhook_secret"
                name="stripe_webhook_secret"
                value="<?= html_escape($stripe['credentials_decoded']['webhook_secret'] ?? ''); ?>"
                placeholder="whsec_..." />
            </div>

            <button type="submit" class="btn btn-primary w-100">Save Stripe</button>
          </form>
        </div>
      </div>
    </div>

    <!-- 2. Razorpay Card -->
    <div class="col-12 col-lg-4 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">
            <i class="fa-solid fa-credit-card text-info me-1"></i> Razorpay
          </h5>
          <span class="badge bg-label-<?= ($razorpay && $razorpay['is_active']) ? 'success' : 'secondary'; ?>">
            <?= ($razorpay && $razorpay['is_active']) ? 'Active' : 'Disabled'; ?>
          </span>
        </div>
        <div class="card-body">
          <form action="<?= site_url('settings/payment'); ?>" method="POST">
            <input type="hidden" name="gateway" value="razorpay" />

            <div class="form-check form-switch mb-3">
              <input class="form-check-input" type="checkbox" id="razorpay_active" name="razorpay_active" value="1" <?= ($razorpay && $razorpay['is_active']) ? 'checked' : ''; ?> />
              <label class="form-check-label" for="razorpay_active">Enable Razorpay</label>
            </div>

            <div class="mb-3">
              <label class="form-label">Environment</label>
              <select name="razorpay_env" class="form-select">
                <option value="test" <?= ($razorpay && $razorpay['environment'] === 'test') ? 'selected' : ''; ?>>Test / Sandbox</option>
                <option value="live" <?= ($razorpay && $razorpay['environment'] === 'live') ? 'selected' : ''; ?>>Production / Live</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label" for="razorpay_key_id">Key ID</label>
              <input
                type="text"
                class="form-control font-monospace small"
                id="razorpay_key_id"
                name="razorpay_key_id"
                value="<?= html_escape($razorpay['credentials_decoded']['key_id'] ?? ''); ?>"
                placeholder="rzp_test_..." />
            </div>

            <div class="mb-3">
              <label class="form-label" for="razorpay_key_secret">Key Secret</label>
              <input
                type="password"
                class="form-control font-monospace small"
                id="razorpay_key_secret"
                name="razorpay_key_secret"
                value="<?= html_escape($razorpay['credentials_decoded']['key_secret'] ?? ''); ?>"
                placeholder="Key Secret..." />
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-4">Save Razorpay</button>
          </form>
        </div>
      </div>
    </div>

    <!-- 3. PayU Card -->
    <div class="col-12 col-lg-4 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="card-title mb-0">
            <i class="fa-solid fa-money-bill-transfer text-warning me-1"></i> PayU Gateway
          </h5>
          <span class="badge bg-label-<?= ($payu && $payu['is_active']) ? 'success' : 'secondary'; ?>">
            <?= ($payu && $payu['is_active']) ? 'Active' : 'Disabled'; ?>
          </span>
        </div>
        <div class="card-body">
          <form action="<?= site_url('settings/payment'); ?>" method="POST">
            <input type="hidden" name="gateway" value="payu" />

            <div class="form-check form-switch mb-3">
              <input class="form-check-input" type="checkbox" id="payu_active" name="payu_active" value="1" <?= ($payu && $payu['is_active']) ? 'checked' : ''; ?> />
              <label class="form-check-label" for="payu_active">Enable PayU</label>
            </div>

            <div class="mb-3">
              <label class="form-label">Environment</label>
              <select name="payu_env" class="form-select">
                <option value="test" <?= ($payu && $payu['environment'] === 'test') ? 'selected' : ''; ?>>Test (test.payu.in)</option>
                <option value="live" <?= ($payu && $payu['environment'] === 'live') ? 'selected' : ''; ?>>Production (secure.payu.in)</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label" for="payu_merchant_key">Merchant Key</label>
              <input
                type="text"
                class="form-control font-monospace small"
                id="payu_merchant_key"
                name="payu_merchant_key"
                value="<?= html_escape($payu['credentials_decoded']['merchant_key'] ?? ''); ?>"
                placeholder="e.g. gtKFFx28" />
            </div>

            <div class="mb-3">
              <label class="form-label" for="payu_merchant_salt">Merchant Salt</label>
              <input
                type="password"
                class="form-control font-monospace small"
                id="payu_merchant_salt"
                name="payu_merchant_salt"
                value="<?= html_escape($payu['credentials_decoded']['merchant_salt'] ?? ''); ?>"
                placeholder="e.g. eCwWELxi" />
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-4">Save PayU</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
