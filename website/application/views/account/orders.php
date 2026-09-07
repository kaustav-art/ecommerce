        <!-- page-title -->
        <div class="page-title" style="background-image: url('<?= base_url('assets/images/section/page-title.jpg'); ?>');">
            <div class="container-full">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="heading">My Orders</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li><a class="link" href="<?= site_url('home'); ?>">Homepage</a></li>
                            <li><i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 11px;"></i></li>
                            <li><a class="link" href="<?= site_url('account/profile'); ?>">My Account</a></li>
                            <li><i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 11px;"></i></li>
                            <li>Orders</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page-title -->

        <!-- my-account -->
        <section class="flat-spacing">
            <div class="container">
                <div class="my-account-wrap">
                    <?php $this->load->view('account/sidebar'); ?>

                    <div class="my-account-content">
                        <div class="my-account-orders">
                            <h5 class="fw-bold mb-4">Order History</h5>

                            <?php if (!empty($orders)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Order #</th>
                                                <th>Date</th>
                                                <th>Total</th>
                                                <th>Payment</th>
                                                <th>Status</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orders as $ord): ?>
                                                <tr>
                                                    <td><strong>#<?= html_escape($ord['order_number']); ?></strong></td>
                                                    <td><?= date('M d, Y', strtotime($ord['created_at'])); ?></td>
                                                    <td><strong><?= $currency_symbol . number_format($ord['total_amount'], 2); ?></strong></td>
                                                    <td>
                                                        <span class="badge bg-<?= ($ord['payment_status'] === 'paid') ? 'success' : 'warning'; ?>">
                                                            <?= ucfirst($ord['payment_status']); ?> (<?= strtoupper($ord['payment_method']); ?>)
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-label-info text-primary border border-primary">
                                                            <?= ucfirst($ord['order_status']); ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="<?= site_url('account/order/' . $ord['order_number']); ?>" class="btn btn-sm btn-outline-primary">
                                                                Details
                                                            </a>
                                                            <a href="<?= site_url('account/invoice/' . $ord['order_number']); ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="View & Print Invoice">
                                                                <i class="fa-solid fa-print"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fa-solid fa-box-archive fs-1 text-muted"></i>
                                    </div>
                                    <h5 class="fw-bold">No orders placed yet</h5>
                                    <p class="text-muted">You haven't placed any orders yet. Discover our collection and start shopping today.</p>
                                    <a href="<?= site_url('shop'); ?>" class="btn btn-primary btn-sm">Explore Shop</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /my-account -->
