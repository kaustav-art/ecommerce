    <div class="position-relative">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6 mx-4">
          <div class="card p-7">
            <!-- Logo -->
            <div class="app-brand justify-content-center mt-5">
              <a href="<?= site_url('auth/login'); ?>" class="app-brand-link gap-3">
                <span class="app-brand-text demo text-heading fw-semibold fs-3">Modave Admin</span>
              </a>
            </div>
            <!-- /Logo -->

            <div class="card-body mt-1">
              <h4 class="mb-1">Welcome to Admin Panel! 👋</h4>
              <p class="mb-5 text-muted">Role-Based Multipurpose eCommerce Admin</p>

              <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger py-2 small" role="alert">
                  <?= $this->session->flashdata('error'); ?>
                </div>
              <?php endif; ?>
              <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success py-2 small" role="alert">
                  <?= $this->session->flashdata('success'); ?>
                </div>
              <?php endif; ?>

              <form id="formAuthentication" class="mb-5" action="<?= site_url('auth/login'); ?>" method="POST">
                <div class="form-floating form-floating-outline mb-5">
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    value="admin@ecommerce.com"
                    required
                    autofocus />
                  <label for="email">Email Address</label>
                </div>
                <div class="mb-5">
                  <div class="form-password-toggle">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input
                          type="password"
                          id="password"
                          class="form-control"
                          name="password"
                          value="admin123"
                          placeholder="············"
                          required />
                        <label for="password">Password</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="mb-5 d-flex justify-content-between mt-5">
                  <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="remember-me" checked />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                  </div>
                </div>
                <div class="mb-5">
                  <button class="btn btn-primary d-grid w-100" type="submit">Sign In</button>
                </div>
              </form>

              <div class="alert alert-light border small">
                <div class="fw-bold mb-1"><i class="fa-solid fa-circle-info me-1"></i> Preloaded Demo Credentials:</div>
                <div><strong>Super Admin:</strong> <code>admin@ecommerce.com</code> / <code>admin123</code></div>
                <div><strong>Store Manager:</strong> <code>manager@ecommerce.com</code> / <code>manager123</code></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
