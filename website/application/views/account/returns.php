        <!-- page-title -->
        <div class="page-title" style="background-image: url('<?= base_url('assets/images/section/page-title.jpg'); ?>');">
            <div class="container-full">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="heading">Return & Refund Requests</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li><a class="link" href="<?= site_url('home'); ?>">Homepage</a></li>
                            <li><i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 11px;"></i></li>
                            <li><a class="link" href="<?= site_url('account/profile'); ?>">My Account</a></li>
                            <li><i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 11px;"></i></li>
                            <li>Returns & Refunds</li>
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
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">My Returns & Refund Requests</h5>
                            <a href="<?= site_url('account/orders'); ?>" class="btn btn-outline-primary btn-sm">
                                <i class="fa-solid fa-box-archive me-1"></i> View Orders
                            </a>
                        </div>

                        <?php if (!empty($returns)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Request #</th>
                                            <th>Order #</th>
                                            <th>Type</th>
                                            <th>Reason</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($returns as $ret): ?>
                                            <tr>
                                                <td><strong>#RET-<?= str_pad($ret['id'], 4, '0', STR_PAD_LEFT); ?></strong></td>
                                                <td>
                                                    <a href="<?= site_url('account/order/' . $ret['order_number']); ?>" class="fw-bold text-dark text-decoration-none">
                                                        #<?= html_escape($ret['order_number']); ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark border text-uppercase">
                                                        <?= html_escape($ret['type']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 200px;" title="<?= html_escape($ret['reason']); ?>">
                                                        <?= html_escape($ret['reason']); ?>
                                                    </div>
                                                    <?php if (!empty($ret['admin_notes'])): ?>
                                                        <div class="small text-info mt-1"><i class="fa-solid fa-comment-dots me-1"></i> <strong>Admin:</strong> <?= html_escape($ret['admin_notes']); ?></div>
                                                    <?php endif; ?>
                                                </td>
                                                <td><strong><?= $currency_symbol . number_format($ret['amount'], 2); ?></strong></td>
                                                <td>
                                                    <?php
                                                        $badge_class = 'secondary';
                                                        if ($ret['status'] === 'approved') $badge_class = 'info';
                                                        elseif ($ret['status'] === 'refunded' || $ret['status'] === 'completed') $badge_class = 'success';
                                                        elseif ($ret['status'] === 'rejected') $badge_class = 'danger';
                                                        elseif ($ret['status'] === 'pending') $badge_class = 'warning';
                                                    ?>
                                                    <span class="badge bg-<?= $badge_class; ?> text-uppercase">
                                                        <?= html_escape($ret['status']); ?>
                                                    </span>
                                                </td>
                                                <td class="small text-muted"><?= date('M d, Y', strtotime($ret['created_at'])); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5 card border">
                                <div class="mb-3">
                                    <i class="fa-solid fa-rotate-left fs-1 text-muted"></i>
                                </div>
                                <h5 class="fw-bold">No return requests found</h5>
                                <p class="text-muted mb-3">You currently do not have any open return, refund, or replacement tickets.</p>
                                <a href="<?= site_url('account/orders'); ?>" class="btn btn-primary btn-sm align-self-center">Go to Orders</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
