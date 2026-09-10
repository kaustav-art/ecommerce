        <!-- Customer Register -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm p-4 p-md-5 bg-white">
                            <h3 class="fw-bold mb-2 text-center">Create an Account</h3>
                            <p class="text-muted text-center small mb-4">Join <?= html_escape($site_name ?? ($store_settings['site_name'] ?? 'us')); ?> for personalized shopping & fast checkout</p>

                            <form action="<?= site_url('auth/register'); ?>" method="POST">
                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold">First Name <span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" class="form-control" required placeholder="John">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" name="last_name" class="form-control" required placeholder="Doe">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required placeholder="john@example.com">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" placeholder="+1 555 0199">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-bold">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" required placeholder="Minimum 6 characters">
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">Register Account</button>
                            </form>

                            <div class="text-center small mt-3">
                                Already have an account? <a href="<?= site_url('login'); ?>" class="fw-bold text-primary">Sign in here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
