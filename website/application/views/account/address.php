        <!-- page-title -->
        <div class="page-title" style="background-image: url('<?= base_url('assets/images/section/page-title.jpg'); ?>');">
            <div class="container-full">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="heading">Saved Addresses</h3>
                        <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                            <li><a class="link" href="<?= site_url('home'); ?>">Homepage</a></li>
                            <li><i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 11px;"></i></li>
                            <li><a class="link" href="<?= site_url('account/profile'); ?>">My Account</a></li>
                            <li><i class="fa-solid fa-chevron-right mx-2 text-muted" style="font-size: 11px;"></i></li>
                            <li>Saved Address</li>
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
                        <div class="my-account-address">
                            <!-- Existing Addresses -->
                            <h5 class="fw-bold mb-3">Your Saved Addresses</h5>
                            <?php if (!empty($addresses)): ?>
                                <div class="row g-3 mb-4">
                                    <?php foreach ($addresses as $addr): ?>
                                        <div class="col-md-6">
                                            <div class="card border p-3 h-100 position-relative">
                                                <?php if ($addr['is_default']): ?>
                                                    <span class="badge bg-primary position-absolute top-0 end-0 m-3">Default</span>
                                                <?php endif; ?>
                                                <h6 class="fw-bold mb-1"><?= html_escape($addr['first_name'] . ' ' . $addr['last_name']); ?></h6>
                                                <p class="text-muted small mb-1"><?= html_escape($addr['address_1']); ?></p>
                                                <?php if (!empty($addr['address_2'])): ?>
                                                    <p class="text-muted small mb-1"><?= html_escape($addr['address_2']); ?></p>
                                                <?php endif; ?>
                                                <p class="text-muted small mb-1"><?= html_escape($addr['city'] . ', ' . $addr['state'] . ' ' . $addr['postcode']); ?></p>
                                                <p class="text-muted small mb-2"><?= html_escape($addr['country']); ?></p>
                                                <p class="text-muted small mb-3"><i class="fa-solid fa-phone me-1"></i> <?= html_escape($addr['phone']); ?></p>
                                                <div class="mt-auto pt-2 border-top">
                                                    <a href="<?= site_url('account/delete_address/' . $addr['id']); ?>" class="btn btn-outline-danger btn-xs" onclick="return confirm('Remove this address?');">
                                                        <i class="fa-solid fa-trash-can me-1"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-light border mb-4">
                                    You have not saved any addresses yet. Fill in the form below to add your primary shipping address.
                                </div>
                            <?php endif; ?>

                            <!-- Add New Address Form -->
                            <div class="card border p-4">
                                <h6 class="fw-bold mb-3">Add New Address</h6>
                                <form action="<?= site_url('account/address'); ?>" method="POST">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">First Name <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" class="form-control" value="<?= html_escape($user['first_name'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" name="last_name" class="form-control" value="<?= html_escape($user['last_name'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small fw-bold">Street Address <span class="text-danger">*</span></label>
                                            <input type="text" name="address_1" class="form-control" placeholder="House / Flat number, Street address" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small fw-bold">Apartment, suite, unit (optional)</label>
                                            <input type="text" name="address_2" class="form-control" placeholder="Apt, Suite, Building...">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">City <span class="text-danger">*</span></label>
                                            <input type="text" name="city" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">State / Province <span class="text-danger">*</span></label>
                                            <input type="text" name="state" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Postal Code <span class="text-danger">*</span></label>
                                            <input type="text" name="postcode" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Country <span class="text-danger">*</span></label>
                                            <input type="text" name="country" class="form-control" value="United States" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Phone Number <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" class="form-control" value="<?= html_escape($user['phone'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <button type="submit" class="tf-btn btn-fill">
                                                <span class="text text-button">Save Address</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /my-account -->
