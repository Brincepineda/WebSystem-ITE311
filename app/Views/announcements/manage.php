<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="bi bi-megaphone me-2"></i>
                    Manage Announcements
                </h2>
                <a href="<?= site_url('/announcements/create') ?>" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i>
                    Create New Announcement
                </a>
            </div>

            <!-- Success/Error Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Announcements Table -->
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-list-ul me-2"></i>
                        All Announcements
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($announcements)): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-info-circle text-muted" style="font-size: 3rem;"></i>
                            <h4 class="text-muted mt-3">No Announcements Found</h4>
                            <p class="text-muted">Create your first announcement to get started.</p>
                            <a href="<?= site_url('/announcements/create') ?>" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>
                                Create Announcement
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Content Preview</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($announcements as $announcement): ?>
                                        <tr>
                                            <td><?= $announcement['id'] ?></td>
                                            <td>
                                                <strong><?= esc($announcement['title']) ?></strong>
                                            </td>
                                            <td>
                                                <?= esc(substr($announcement['content'], 0, 100)) ?>
                                                <?= strlen($announcement['content']) > 100 ? '...' : '' ?>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= date('M d, Y g:i A', strtotime($announcement['created_at'])) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= site_url('/announcements/edit/' . $announcement['id']) ?>" 
                                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="<?= site_url('/announcements/delete/' . $announcement['id']) ?>" 
                                                       class="btn btn-sm btn-outline-danger" title="Delete"
                                                       onclick="return confirm('Are you sure you want to delete this announcement?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Back to Announcements -->
            <div class="mt-4">
                <a href="<?= site_url('/announcements') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Back to Announcements
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.table th {
    border-top: none;
}

.btn-group .btn {
    margin-right: 2px;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}
</style>
