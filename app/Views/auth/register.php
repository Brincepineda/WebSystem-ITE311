<div class="hero-section">
    <div class="container">
        <h1><i class="bi bi-person-plus"></i> Create Account</h1>
        <p class="lead">Join ITE311 PINEDA and start your journey with us</p>
    </div>
</div>

<div class="content-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="feature-card">
                    <h3 class="text-center mb-4">
                        <i class="bi bi-person-circle text-primary"></i> Register New Account
                    </h3>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php 
                    $validation = session()->getFlashdata('validation');
                    if ($validation): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                <?php foreach ($validation->getErrors() as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= site_url('/register') ?>">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="bi bi-person"></i> Full Name
                            </label>
                            <input type="text" class="form-control <?= ($validation && $validation->hasError('name')) ? 'is-invalid' : '' ?>" 
                                   id="name" name="name" value="<?= old('name') ?>" placeholder="Enter your full name" required>
                            <?php if ($validation && $validation->hasError('name')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('name') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope"></i> Email Address
                            </label>
                            <input type="email" class="form-control <?= ($validation && $validation->hasError('email')) ? 'is-invalid' : '' ?>" 
                                   id="email" name="email" value="<?= old('email') ?>" placeholder="Enter your email address" required>
                            <?php if ($validation && $validation->hasError('email')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('email') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock"></i> Password
                            </label>
                            <input type="password" class="form-control <?= ($validation && $validation->hasError('password')) ? 'is-invalid' : '' ?>" 
                                   id="password" name="password" placeholder="Enter your password" required>
                            <?php if ($validation && $validation->hasError('password')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('password') ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-text">Password must be at least 6 characters long.</div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirm" class="form-label">
                                <i class="bi bi-lock-fill"></i> Confirm Password
                            </label>
                            <input type="password" class="form-control <?= ($validation && $validation->hasError('password_confirm')) ? 'is-invalid' : '' ?>" 
                                   id="password_confirm" name="password_confirm" placeholder="Confirm your password" required>
                            <?php if ($validation && $validation->hasError('password_confirm')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('password_confirm') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-custom btn-lg">
                                <i class="bi bi-person-plus"></i> Create Account
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">Already have an account? 
                                <a href="<?= site_url('/login') ?>" class="text-decoration-none">
                                    <i class="bi bi-box-arrow-in-right"></i> Login here
                                </a>
                            </p>
                        </div>
                    </form>
                </div>

                <div class="text-center mt-4">
                    <a href="<?= site_url('/') ?>" class="btn btn-outline-primary">
                        <i class="bi bi-house"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
