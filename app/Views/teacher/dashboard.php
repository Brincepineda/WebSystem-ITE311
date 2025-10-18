<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info">
                <h4><i class="bi bi-person-workspace me-2"></i>Teacher Dashboard</h4>
                <p>Welcome, <strong><?= esc($user['name']) ?></strong>! You have successfully accessed the teacher dashboard.</p>
                <p><strong>Role:</strong> <?= ucfirst($user['role']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5><i class="bi bi-book me-2"></i>My Courses</h5>
                    <p>Manage your courses</p>
                    <a href="<?= site_url('/teacher/courses') ?>" class="btn btn-light btn-sm">View Courses</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5><i class="bi bi-people me-2"></i>My Students</h5>
                    <p>View student information</p>
                    <a href="<?= site_url('/teacher/students') ?>" class="btn btn-light btn-sm">View Students</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5><i class="bi bi-trophy me-2"></i>Grades</h5>
                    <p>Manage student grades</p>
                    <a href="<?= site_url('/teacher/grades') ?>" class="btn btn-dark btn-sm">Manage Grades</a>
                </div>
            </div>
        </div>
    </div>
</div>
