        <!-- page-title -->
        <div class="page-title" style="background-image: url('<?= base_url('assets/images/section/page-title.jpg'); ?>');">
            <div class="container-full">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="heading">Notifications</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li><a class="link" href="<?= site_url('home'); ?>">Homepage</a></li>
                            <li><i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 11px;"></i></li>
                            <li><a class="link" href="<?= site_url('account/profile'); ?>">My Account</a></li>
                            <li><i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 11px;"></i></li>
                            <li>Notifications</li>
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
                            <h5 class="fw-bold m-0">Recent Notifications</h5>
                            <span class="badge bg-label-primary text-primary"><?= count($notifications); ?> Messages</span>
                        </div>

                        <?php if (!empty($notifications)): ?>
                            <div class="list-group">
                                <?php foreach ($notifications as $notif): ?>
                                    <div class="list-group-item list-group-item-action p-3 mb-2 border rounded shadow-none <?= empty($notif['is_read']) ? 'bg-surface' : ''; ?>">
                                        <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid fa-bell text-primary fs-5 me-2"></i>
                                                <h6 class="mb-0 fw-bold"><?= html_escape($notif['title']); ?></h6>
                                                <span class="badge bg-light text-secondary ms-2 text-uppercase small"><?= html_escape($notif['type']); ?></span>
                                            </div>
                                            <small class="text-muted"><?= date('M d, Y h:i A', strtotime($notif['created_at'])); ?></small>
                                        </div>
                                        <p class="mb-2 text-secondary small"><?= nl2br(html_escape($notif['message'])); ?></p>
                                        <?php if (!empty($notif['link'])): ?>
                                            <div>
                                                <a href="<?= site_url($notif['link']); ?>" class="btn btn-outline-primary btn-xs">
                                                    View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fa-regular fa-bell fs-1 text-muted"></i>
                                </div>
                                <h5 class="fw-bold">No notifications right now</h5>
                                <p class="text-muted">You're all caught up! Order updates, shipping alerts, and promotions will appear here.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- /my-account -->
