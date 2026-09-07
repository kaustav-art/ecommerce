        <!-- page-title -->
        <div class="page-title" style="background-image: url('<?= base_url('assets/images/section/page-title.jpg'); ?>');">
            <div class="container-full">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="heading">My Profile</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li><a class="link" href="<?= site_url('home'); ?>">Homepage</a></li>
                            <li><i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 11px;"></i></li>
                            <li>My Profile</li>
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
                        <div class="account-details">
                            <!-- Personal Information -->
                            <form action="<?= site_url('account/profile'); ?>" method="POST" class="form-account-details mb-5">
                                <input type="hidden" name="action" value="update_profile">
                                <div class="account-info mb-4">
                                    <h5 class="title fw-bold mb-3">Personal Information</h5>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">First Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="first_name" value="<?= html_escape($user['first_name'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Last Name <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="last_name" value="<?= html_escape($user['last_name'] ?? ''); ?>" required>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Email Address</label>
                                            <input class="form-control bg-light" type="email" value="<?= html_escape($user['email'] ?? ''); ?>" disabled readonly>
                                            <small class="text-muted">Contact support to change your account email.</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Phone Number</label>
                                            <input class="form-control" type="text" name="phone" value="<?= html_escape($user['phone'] ?? ''); ?>" placeholder="+1 234 567 8900">
                                        </div>
                                    </div>
                                    <div class="button-submit mt-3">
                                        <button class="tf-btn btn-fill" type="submit">
                                            <span class="text text-button">Save Changes</span>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <hr class="my-4">

                            <!-- Change Password -->
                            <form action="<?= site_url('account/profile'); ?>" method="POST" class="form-account-details">
                                <input type="hidden" name="action" value="change_password">
                                <div class="account-password">
                                    <h5 class="title fw-bold mb-3">Change Password</h5>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Current Password <span class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="current_password" required placeholder="Enter current password">
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">New Password <span class="text-danger">*</span></label>
                                            <input class="form-control" type="password" name="new_password" required placeholder="Minimum 6 characters">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Confirm New Password <span class="text-danger">*</span></label>
                                            <input class="form-control" type="password" name="confirm_password" required placeholder="Re-enter new password">
                                        </div>
                                    </div>
                                    <div class="button-submit mt-3">
                                        <button class="tf-btn btn-fill" type="submit">
                                            <span class="text text-button">Update Password</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /my-account -->
