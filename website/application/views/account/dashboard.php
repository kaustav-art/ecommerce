        <!-- Account Dashboard -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row">
                    <!-- Left Menu -->
                    <div class="col-md-3 mb-4 mb-md-0">
                        <div class="card border p-3">
                            <div class="text-center py-3 border-bottom mb-3">
                                <div class="avatar avatar-lg mx-auto bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fs-3 fw-bold mb-2" style="width: 60px; height: 60px;">
                                    <?= strtoupper(substr($user['first_name'], 0, 1)); ?>
                                </div>
                                <h6 class="mb-0 fw-bold"><?= html_escape($user['first_name'] . ' ' . $user['last_name']); ?></h6>
                                <small class="text-muted"><?= html_escape($user['email']); ?></small>
                            </div>
                            <div class="list-group list-group-flush">
                                <a href="<?= site_url('account'); ?>" class="list-group-item list-group-item-action active fw-bold">Dashboard</a>
                                <a href="<?= site_url('account/orders'); ?>" class="list-group-item list-group-item-action">My Orders</a>
                                <a href="<?= site_url('account/address'); ?>" class="list-group-item list-group-item-action">Saved Addresses</a>
                                <a href="<?= site_url('logout'); ?>" class="list-group-item list-group-item-action text-danger">Sign Out</a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Content -->
                    <div class="col-md-9">
                        <div class="card border p-4 mb-4">
                            <h4 class="fw-bold mb-1">Welcome, <?= html_escape($user['first_name']); ?>!</h4>
                            <p class="text-muted">From your account dashboard you can view your recent orders, manage your shipping and billing addresses, and track active deliveries.</p>

                            <div class="row g-3 my-2">
                                <div class="col-md-4">
                                    <div class="border rounded p-3 bg-light text-center">
                                        <h3 class="fw-bold text-primary mb-0"><?= count($orders); ?></h3>
                                        <small class="text-muted">Total Orders Placed</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 bg-light text-center">
                                        <h3 class="fw-bold text-success mb-0"><?= count($addresses); ?></h3>
                                        <small class="text-muted">Saved Addresses</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 bg-light text-center">
                                        <h3 class="fw-bold text-dark mb-0"><?= date('M Y', strtotime($user['created_at'])); ?></h3>
                                        <small class="text-muted">Member Since</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Orders -->
                        <div class="card border p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0">Recent Orders</h5>
                                <a href="<?= site_url('account/orders'); ?>" class="btn btn-outline-primary btn-sm">View All Orders</a>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Payment</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($orders)): ?>
                                            <?php foreach (array_slice($orders, 0, 3) as $ord): ?>
                                                <tr>
                                                    <td><strong>#<?= html_escape($ord['order_number']); ?></strong></td>
                                                    <td><?= date('M d, Y', strtotime($ord['created_at'])); ?></td>
                                                    <td><?= $currency_symbol . number_format($ord['total_amount'], 2); ?></td>
                                                    <td><span class="badge bg-label-success"><?= ucfirst($ord['payment_status']); ?></span></td>
                                                    <td><span class="badge bg-label-info"><?= ucfirst($ord['order_status']); ?></span></td>
                                                    <td>
                                                        <a href="<?= site_url('account/order/' . $ord['order_number']); ?>" class="btn btn-xs btn-outline-dark">
                                                            View Details
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-3">No orders yet.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
