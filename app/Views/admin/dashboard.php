<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                <h4><i class="bi bi-shield-check me-2"></i>Admin Dashboard</h4>
                <p>Welcome, <strong><?= esc($user['name']) ?></strong>! You have successfully accessed the admin dashboard.</p>
                <p><strong>Role:</strong> <?= ucfirst($user['role']) ?></p>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5><i class="bi bi-people me-2"></i>Users</h5>
                    <p>Manage system users</p>
                    <a href="<?= site_url('/admin/users') ?>" class="btn btn-light btn-sm">View Users</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5><i class="bi bi-gear me-2"></i>Settings</h5>
                    <p>System configuration</p>
                    <a href="<?= site_url('/admin/settings') ?>" class="btn btn-light btn-sm">View Settings</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5><i class="bi bi-bar-chart me-2"></i>Reports</h5>
                    <p>System reports</p>
                    <a href="<?= site_url('/admin/reports') ?>" class="btn btn-light btn-sm">View Reports</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5><i class="bi bi-megaphone me-2"></i>Announcements</h5>
                    <p>Manage announcements</p>
                    <a href="<?= site_url('/announcements/manage') ?>" class="btn btn-dark btn-sm">Manage</a>
                </div>
            </div>
        </div>
    </div>
</div>
