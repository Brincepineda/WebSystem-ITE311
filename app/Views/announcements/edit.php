<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil me-2"></i>
                        Edit Announcement
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Error Messages -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Validation Errors -->
                    <?php if (isset($validation)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($validation->getErrors() as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Edit Form -->
                    <form method="POST" action="<?= site_url('/announcements/edit/' . $announcement['id']) ?>">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">
                                <i class="bi bi-type me-1"></i>
                                Announcement Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="title" 
                                   name="title" 
                                   value="<?= old('title', $announcement['title']) ?>"
                                   placeholder="Enter announcement title"
                                   required>
                            <div class="form-text">
                                Enter a clear and descriptive title for your announcement.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label">
                                <i class="bi bi-text-paragraph me-1"></i>
                                Announcement Content <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" 
                                      id="content" 
                                      name="content" 
                                      rows="8"
                                      placeholder="Enter the full announcement content here..."
                                      required><?= old('content', $announcement['content']) ?></textarea>
                            <div class="form-text">
                                Provide detailed information about the announcement. You can use line breaks for formatting.
                            </div>
                        </div>

                        <!-- Announcement Info -->
                        <div class="alert alert-info">
                            <h6><i class="bi bi-info-circle me-1"></i> Announcement Information</h6>
                            <p class="mb-1"><strong>ID:</strong> <?= $announcement['id'] ?></p>
                            <p class="mb-1"><strong>Created:</strong> <?= date('F j, Y \a\t g:i A', strtotime($announcement['created_at'])) ?></p>
                            <?php if ($announcement['updated_at'] && $announcement['updated_at'] !== $announcement['created_at']): ?>
                                <p class="mb-0"><strong>Last Updated:</strong> <?= date('F j, Y \a\t g:i A', strtotime($announcement['updated_at'])) ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= site_url('/announcements/manage') ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-1"></i>
                                Update Announcement
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-eye me-1"></i>
                        Live Preview
                    </h6>
                </div>
                <div class="card-body">
                    <div id="preview-content">
                        <h5 class="text-primary" id="preview-title"><?= esc($announcement['title']) ?></h5>
                        <p id="preview-text"><?= nl2br(esc($announcement['content'])) ?></p>
                        <small class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            Posted on <?= date('F j, Y \a\t g:i A', strtotime($announcement['created_at'])) ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Live preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    const previewTitle = document.getElementById('preview-title');
    const previewText = document.getElementById('preview-text');

    function updatePreview() {
        const title = titleInput.value.trim();
        const content = contentInput.value.trim();
        
        previewTitle.textContent = title || 'Your title will appear here...';
        
        // Convert line breaks to <br> tags for preview
        if (content) {
            previewText.innerHTML = content.replace(/\n/g, '<br>');
        } else {
            previewText.textContent = 'Your content will appear here...';
        }
    }

    titleInput.addEventListener('input', updatePreview);
    contentInput.addEventListener('input', updatePreview);
});
</script>

<style>
.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.card {
    transition: transform 0.2s ease-in-out;
}

#preview-content {
    min-height: 100px;
    padding: 1rem;
    background: rgba(0, 123, 255, 0.05);
    border-radius: 8px;
}

.alert-info {
    background-color: rgba(13, 202, 240, 0.1);
    border-color: rgba(13, 202, 240, 0.2);
}
</style>
