<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row gy-4">
    <!-- Welcome Card -->
    <div class="col-md-12 col-lg-4">
      <div class="card h-100">
        <div class="card-body">
          <h4 class="card-title mb-1">Hello, <?= html_escape($current_admin['name']); ?>! 👋</h4>
          <p class="pb-0 text-muted">Role: <span class="badge bg-primary"><?= html_escape($current_admin['role_name']); ?></span></p>
          <h4 class="text-primary mb-1 mt-3"><?= $currency_symbol . number_format($metrics['total_sales'], 2); ?></h4>
          <p class="mb-2 text-muted">Total Paid Revenue</p>
          <a href="<?= site_url('orders'); ?>" class="btn btn-sm btn-primary">View All Orders</a>
        </div>
      </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="col-md-12 col-lg-8">
      <div class="row gy-4">
        <!-- Total Orders -->
        <div class="col-sm-6 col-md-3">
          <div class="card card-border-shadow-primary h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
                <div class="avatar me-3">
                  <span class="avatar-initial rounded bg-label-primary"><i class="fa-solid fa-cart-shopping"></i></span>
                </div>
                <h4 class="mb-0"><?= $metrics['total_orders']; ?></h4>
              </div>
              <p class="mb-0 text-muted">Total Orders</p>
            </div>
          </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-sm-6 col-md-3">
          <div class="card card-border-shadow-warning h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
                <div class="avatar me-3">
                  <span class="avatar-initial rounded bg-label-warning"><i class="fa-solid fa-clock"></i></span>
                </div>
                <h4 class="mb-0"><?= $metrics['pending_orders']; ?></h4>
              </div>
              <p class="mb-0 text-muted">Pending Orders</p>
            </div>
          </div>
        </div>

        <!-- Total Customers -->
        <div class="col-sm-6 col-md-3">
          <div class="card card-border-shadow-success h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
                <div class="avatar me-3">
                  <span class="avatar-initial rounded bg-label-success"><i class="fa-solid fa-user"></i></span>
                </div>
                <h4 class="mb-0"><?= $total_customers; ?></h4>
              </div>
              <p class="mb-0 text-muted">Total Customers</p>
            </div>
          </div>
        </div>

        <!-- Total Products -->
        <div class="col-sm-6 col-md-3">
          <div class="card card-border-shadow-info h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
                <div class="avatar me-3">
                  <span class="avatar-initial rounded bg-label-info"><i class="fa-solid fa-box-archive"></i></span>
                </div>
                <h4 class="mb-0"><?= $total_products; ?></h4>
              </div>
              <p class="mb-0 text-muted">Live Products</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="col-12 col-xl-8">
      <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0">Recent Orders</h5>
          <a href="<?= site_url('orders'); ?>" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($recent_orders)): ?>
                <?php foreach ($recent_orders as $ord): ?>
                  <tr>
                    <td><strong>#<?= html_escape($ord['order_number']); ?></strong></td>
                    <td><?= html_escape($ord['customer_name']); ?></td>
                    <td><?= $currency_symbol . number_format($ord['total_amount'], 2); ?></td>
                    <td>
                      <span class="badge bg-label-<?= ($ord['payment_status'] === 'paid') ? 'success' : 'warning'; ?>">
                        <?= strtoupper($ord['payment_method']); ?> (<?= ucfirst($ord['payment_status']); ?>)
                      </span>
                    </td>
                    <td>
                      <?php
                        $badge_class = 'secondary';
                        if ($ord['order_status'] === 'delivered') $badge_class = 'success';
                        elseif ($ord['order_status'] === 'shipped') $badge_class = 'info';
                        elseif ($ord['order_status'] === 'processing') $badge_class = 'primary';
                        elseif ($ord['order_status'] === 'pending') $badge_class = 'warning';
                      ?>
                      <span class="badge bg-<?= $badge_class; ?>"><?= ucfirst($ord['order_status']); ?></span>
                    </td>
                    <td>
                      <a href="<?= site_url('orders/view/' . $ord['id']); ?>" class="btn btn-xs btn-outline-secondary">
                        <i class="fa-solid fa-eye me-1"></i> View
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">No recent orders found.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Recent Customers & Quick Links -->
    <div class="col-12 col-xl-4">
      <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0">Recent Customers</h5>
          <a href="<?= site_url('customers'); ?>" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="card-body">
          <ul class="list-unstyled mb-0">
            <?php if (!empty($recent_customers)): ?>
              <?php foreach ($recent_customers as $cust): ?>
                <li class="d-flex align-items-center mb-3">
                  <div class="avatar me-3">
                    <span class="avatar-initial rounded-circle bg-label-primary">
                      <?= strtoupper(substr($cust['first_name'], 0, 1)); ?>
                    </span>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0"><?= html_escape($cust['first_name'] . ' ' . $cust['last_name']); ?></h6>
                      <small class="text-muted"><?= html_escape($cust['email']); ?></small>
                    </div>
                    <span class="badge bg-label-<?= ($cust['status'] === 'active') ? 'success' : 'danger'; ?>">
                      <?= ucfirst($cust['status']); ?>
                    </span>
                  </div>
                </li>
              <?php endforeach; ?>
            <?php else: ?>
              <li class="text-center text-muted py-2">No customers registered yet.</li>
            <?php endif; ?>
          </ul>
        </div>
      </div>

      <!-- System Status / Gateways Card -->
      <div class="card">
        <div class="card-header">
          <h5 class="card-title m-0">Payment Gateways Status</h5>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span><i class="fa-solid fa-shield-halved me-2 text-primary"></i> Stripe</span>
            <span class="badge bg-label-success">Enabled (Test)</span>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span><i class="fa-solid fa-credit-card me-2 text-info"></i> Razorpay</span>
            <span class="badge bg-label-success">Enabled (Test)</span>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span><i class="fa-solid fa-money-bill-transfer me-2 text-warning"></i> PayU</span>
            <span class="badge bg-label-success">Enabled (Test)</span>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <span><i class="fa-solid fa-money-bill-wave me-2 text-success"></i> Cash on Delivery</span>
            <span class="badge bg-label-success">Enabled</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
