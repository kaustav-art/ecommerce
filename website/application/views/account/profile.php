        <!-- breadcrumb -->
        <div class="bg-light py-2 border-bottom">
            <div class="container" style="max-width: 1240px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size: 12px;">
                        <li class="breadcrumb-item"><a href="<?= site_url('home'); ?>" class="text-muted text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('account/profile'); ?>" class="text-muted text-decoration-none">My Account</a></li>
                        <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Profile Information</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- /breadcrumb -->

        <!-- my-account -->
        <section class="py-4" style="background-color: #f1f3f6; min-height: 80vh;">
            <div class="container" style="max-width: 1240px;">
                <div class="row g-3">
                    <!-- Left Sidebar -->
                    <div class="col-lg-3 col-md-4">
                        <?php $this->load->view('account/sidebar'); ?>
                    </div>

                    <!-- Right Content -->
                    <div class="col-lg-9 col-md-8">
                        <div class="card border rounded-1 shadow-sm bg-white p-3 p-md-4 mb-3" style="border-color: #f0f0f0 !important;">
                            <!-- Flash messages -->
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show rounded-1 py-2 px-3 small mb-4" role="alert">
                                    <i class="fa-solid fa-circle-check me-2"></i><?= $this->session->flashdata('success'); ?>
                                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show rounded-1 py-2 px-3 small mb-4" role="alert">
                                    <i class="fa-solid fa-circle-exclamation me-2"></i><?= $this->session->flashdata('error'); ?>
                                    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <!-- Personal Information -->
                            <form action="<?= site_url('account/profile'); ?>" method="POST" class="mb-4">
                                <input type="hidden" name="action" value="update_profile">
                                <h5 class="fw-bold mb-3 text-dark" style="font-size: 17px;">Personal Information</h5>
                                
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-dark">First Name <span class="text-danger">*</span></label>
                                        <input class="form-control rounded-1" type="text" name="first_name" value="<?= html_escape($user['first_name'] ?? ''); ?>" required style="height: 46px; border-color: #e0e0e0;">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-dark">Last Name <span class="text-danger">*</span></label>
                                        <input class="form-control rounded-1" type="text" name="last_name" value="<?= html_escape($user['last_name'] ?? ''); ?>" required style="height: 46px; border-color: #e0e0e0;">
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-dark">Email Address</label>
                                        <input class="form-control bg-light rounded-1" type="email" value="<?= html_escape($user['email'] ?? ''); ?>" disabled readonly style="height: 46px; border-color: #e0e0e0;">
                                        <small class="text-muted" style="font-size: 11px;">Email cannot be modified directly.</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-dark">Mobile Number</label>
                                        <input class="form-control rounded-1" type="tel" name="phone" value="<?= html_escape($user['phone'] ?? ''); ?>" placeholder="10-digit mobile number" style="height: 46px; border-color: #e0e0e0;">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary fw-bold text-uppercase px-4 py-2 w-100 w-sm-auto rounded-1 shadow-sm" style="background-color: #2874f0; border-color: #2874f0; height: 44px; letter-spacing: 0.5px;">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Card -->
                        <div class="card border rounded-1 shadow-sm bg-white p-3 p-md-4" style="border-color: #f0f0f0 !important;">
                            <form action="<?= site_url('account/profile'); ?>" method="POST">
                                <input type="hidden" name="action" value="change_password">
                                <h5 class="fw-bold mb-3 text-dark" style="font-size: 17px;">Change Password</h5>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-dark">Current Password <span class="text-danger">*</span></label>
                                    <input class="form-control rounded-1" type="password" name="current_password" required placeholder="Enter current password" style="height: 46px; border-color: #e0e0e0; max-width: 450px;">
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-dark">New Password <span class="text-danger">*</span></label>
                                        <input class="form-control rounded-1" type="password" name="new_password" required placeholder="Minimum 6 characters" style="height: 46px; border-color: #e0e0e0;">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold text-dark">Confirm New Password <span class="text-danger">*</span></label>
                                        <input class="form-control rounded-1" type="password" name="confirm_password" required placeholder="Re-enter new password" style="height: 46px; border-color: #e0e0e0;">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary fw-bold text-uppercase px-4 py-2 w-100 w-sm-auto rounded-1 shadow-sm" style="background-color: #2874f0; border-color: #2874f0; height: 44px; letter-spacing: 0.5px;">
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /my-account -->
