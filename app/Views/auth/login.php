<div class="hero-section">
    <div class="container">
        <h1><i class="bi bi-box-arrow-in-right"></i> Welcome Back</h1>
        <p class="lead">Login to access your ITE311 PINEDA account</p>
    </div>
</div>

<div class="content-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="feature-card">
                    <h3 class="text-center mb-4">
                        <i class="bi bi-person-check text-success"></i> Login to Your Account
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

                    <form method="POST" action="<?= site_url('/login') ?>">
                        <?= csrf_field() ?>
                        
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

                        <div class="mb-4">
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
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-custom btn-lg">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">Don't have an account? 
                                <a href="<?= site_url('/register') ?>" class="text-decoration-none">
                                    <i class="bi bi-person-plus"></i> Register here
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
