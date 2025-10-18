<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">
                            <i class="bi bi-megaphone me-2"></i>
                            Announcements
                        </h2>
                        <?php if (session()->get('role') === 'admin'): ?>
                            <a href="<?= site_url('/announcements/manage') ?>" class="btn btn-light btn-sm">
                                <i class="bi bi-gear me-1"></i>
                                Manage
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($announcements)): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-info-circle text-muted" style="font-size: 3rem;"></i>
                            <h4 class="text-muted mt-3">No Announcements Yet</h4>
                            <p class="text-muted">Check back later for updates and important information.</p>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($announcements as $announcement): ?>
                                <div class="col-12 mb-4">
                                    <div class="card border-left-primary">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h5 class="card-title text-primary mb-0">
                                                    <?= esc($announcement['title']) ?>
                                                </h5>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    <?= date('M d, Y', strtotime($announcement['created_at'])) ?>
                                                </small>
                                            </div>
                                            <p class="card-text">
                                                <?= nl2br(esc($announcement['content'])) ?>
                                            </p>
                                            <div class="text-muted small">
                                                <i class="bi bi-clock me-1"></i>
                                                Posted on <?= date('F j, Y \a\t g:i A', strtotime($announcement['created_at'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 4px solid #007bff !important;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.bg-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}
</style>
