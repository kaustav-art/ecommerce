        <!-- Customer Login -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm p-4 p-md-5 bg-white">
                            <h3 class="fw-bold mb-2 text-center">Customer Sign In</h3>
                            <p class="text-muted text-center small mb-4">Access your orders, addresses, and wishlist</p>

                            <form action="<?= site_url('auth/login'); ?>" method="POST">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="john@example.com" placeholder="name@example.com" required autofocus>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Password</label>
                                    <input type="password" name="password" class="form-control" value="user123" placeholder="••••••••" required>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-4 small">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember" checked>
                                        <label class="form-check-label" for="remember">Remember me</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">Sign In</button>
                            </form>

                            <div class="alert alert-light border small">
                                <div class="fw-bold"><i class="fa-solid fa-user me-1"></i> Preloaded Customer Login:</div>
                                <code>john@example.com</code> / <code>user123</code>
                            </div>

                            <div class="text-center small mt-3">
                                Don't have an account? <a href="<?= site_url('register'); ?>" class="fw-bold text-primary">Register here</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
