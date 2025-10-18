<?php
$userRole = $user['role'] ?? 'student';
$roleColors = [
    'admin' => 'danger',
    'teacher' => 'success', 
    'student' => 'primary'
];
$roleIcons = [
    'admin' => 'shield-fill-check',
    'teacher' => 'person-workspace',
    'student' => 'mortarboard-fill'
];
?>

<div class="hero-section">
    <div class="container">
        <h1>
            <i class="bi bi-<?= $roleIcons[$userRole] ?? 'speedometer2' ?>"></i> 
            <?= ucfirst($userRole) ?> Dashboard
        </h1>
        <p class="lead">Welcome back, <?= esc($user['name']) ?>! You are logged in as a <?= ucfirst($userRole) ?>.</p>
    </div>
</div>

<div class="content-section">
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Profile Information Card -->
        <div class="row mb-4">
            <div class="col-lg-4">
                <div class="feature-card text-center">
                    <i class="bi bi-person-circle display-4 text-<?= $roleColors[$userRole] ?> mb-3"></i>
                    <h4>Profile Information</h4>
                    <hr>
                    <p><strong>Name:</strong> <?= esc($user['name']) ?></p>
                    <p><strong>Email:</strong> <?= esc($user['email']) ?></p>
                    <p><strong>Role:</strong> 
                        <span class="badge bg-<?= $roleColors[$userRole] ?>"><?= ucfirst($userRole) ?></span>
                    </p>
                    <p><strong>User ID:</strong> #<?= $user['id'] ?></p>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="feature-card">
                    <h4><i class="bi bi-graph-up text-<?= $roleColors[$userRole] ?>"></i> Quick Stats</h4>
                    <hr>
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="bg-light p-3 rounded">
                                <i class="bi bi-calendar-check display-6 text-primary"></i>
                                <h5 class="mt-2">Today</h5>
                                <p class="text-muted"><?= date('M d, Y') ?></p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="bg-light p-3 rounded">
                                <i class="bi bi-clock display-6 text-success"></i>
                                <h5 class="mt-2">Time</h5>
                                <p class="text-muted" id="current-time"><?= date('H:i:s') ?></p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="bg-light p-3 rounded">
                                <i class="bi bi-shield-check display-6 text-warning"></i>
                                <h5 class="mt-2">Status</h5>
                                <p class="text-success"><strong>Active</strong></p>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="bg-light p-3 rounded">
                                <i class="bi bi-star display-6 text-info"></i>
                                <h5 class="mt-2">Access Level</h5>
                                <p class="text-muted"><?= ucfirst($userRole) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role-Specific Content -->
        <?php if ($userRole === 'admin'): ?>
            <!-- ADMIN DASHBOARD CONTENT -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="feature-card">
                        <h4><i class="bi bi-shield-fill-check text-danger"></i> Admin Control Panel</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="bg-danger bg-opacity-10 p-3 rounded text-center">
                                    <i class="bi bi-people-fill display-4 text-danger"></i>
                                    <h5 class="mt-2">Total Users</h5>
                                    <h3 class="text-danger"><?= $roleData['totalUsers'] ?? 0 ?></h3>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6>Users by Role:</h6>
                                <?php if (isset($roleData['usersByRole'])): ?>
                                    <?php foreach ($roleData['usersByRole'] as $roleCount): ?>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-<?= $roleColors[$roleCount['role']] ?? 'secondary' ?> me-2">
                                                <?= ucfirst($roleCount['role']) ?>
                                            </span>
                                            <span><?= $roleCount['count'] ?> users</span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="feature-card">
                        <h4><i class="bi bi-clock-history text-info"></i> Recent Users</h4>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($roleData['recentUsers'])): ?>
                                        <?php foreach ($roleData['recentUsers'] as $recentUser): ?>
                                            <tr>
                                                <td>#<?= $recentUser['id'] ?></td>
                                                <td><?= esc($recentUser['name']) ?></td>
                                                <td><?= esc($recentUser['email']) ?></td>
                                                <td>
                                                    <span class="badge bg-<?= $roleColors[$recentUser['role']] ?? 'secondary' ?>">
                                                        <?= ucfirst($recentUser['role']) ?>
                                                    </span>
                                                </td>
                                                <td><?= date('M d, Y', strtotime($recentUser['created_at'])) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif ($userRole === 'teacher'): ?>
            <!-- TEACHER DASHBOARD CONTENT -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="feature-card">
                        <h4><i class="bi bi-person-workspace text-success"></i> Teacher Control Panel</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="bg-success bg-opacity-10 p-3 rounded text-center">
                                    <i class="bi bi-mortarboard-fill display-4 text-success"></i>
                                    <h5 class="mt-2">Total Students</h5>
                                    <h3 class="text-success"><?= $roleData['totalStudents'] ?? 0 ?></h3>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6>Teacher Capabilities:</h6>
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-check-circle text-success"></i> View all students</li>
                                    <li><i class="bi bi-check-circle text-success"></i> Manage assignments</li>
                                    <li><i class="bi bi-check-circle text-success"></i> Grade submissions</li>
                                    <li><i class="bi bi-check-circle text-success"></i> Create courses</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="feature-card">
                        <h4><i class="bi bi-people text-primary"></i> My Students</h4>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Student Name</th>
                                        <th>Email</th>
                                        <th>Enrolled</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($roleData['students'])): ?>
                                        <?php foreach ($roleData['students'] as $student): ?>
                                            <tr>
                                                <td>#<?= $student['id'] ?></td>
                                                <td><?= esc($student['name']) ?></td>
                                                <td><?= esc($student['email']) ?></td>
                                                <td><?= date('M d, Y', strtotime($student['created_at'])) ?></td>
                                                <td><span class="badge bg-success">Active</span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No students found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <!-- STUDENT DASHBOARD CONTENT -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="feature-card">
                        <h4><i class="bi bi-mortarboard-fill text-primary"></i> Student Portal</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="bg-primary bg-opacity-10 p-3 rounded text-center">
                                    <i class="bi bi-book-fill display-4 text-primary"></i>
                                    <h5 class="mt-2">My Courses</h5>
                                    <h3 class="text-primary" id="enrolled-count">
                                        <?= isset($roleData['enrollments']) ? count($roleData['enrollments']) : 0 ?>
                                    </h3>
                                    <small class="text-muted">Enrolled Courses</small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="bg-info bg-opacity-10 p-3 rounded text-center">
                                    <i class="bi bi-clipboard-check-fill display-4 text-info"></i>
                                    <h5 class="mt-2">Available</h5>
                                    <h3 class="text-info" id="available-count">
                                        <?= isset($roleData['availableCourses']) ? count($roleData['availableCourses']) : 0 ?>
                                    </h3>
                                    <small class="text-muted">Courses to Enroll</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrolled Courses Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="feature-card">
                        <h4><i class="bi bi-book-check text-success"></i> My Enrolled Courses</h4>
                        <hr>
                        <div id="enrolled-courses">
                            <?php if (isset($roleData['enrollments']) && !empty($roleData['enrollments'])): ?>
                                <div class="row">
                                    <?php foreach ($roleData['enrollments'] as $enrollment): ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-success">
                                                <div class="card-body">
                                                    <h5 class="card-title text-success">
                                                        <i class="bi bi-book"></i> <?= esc($enrollment['title']) ?>
                                                    </h5>
                                                    <p class="card-text"><?= esc($enrollment['description']) ?></p>
                                                    <p class="text-muted">
                                                        <i class="bi bi-person"></i> Instructor: <?= esc($enrollment['instructor_name']) ?><br>
                                                        <i class="bi bi-calendar"></i> Enrolled: <?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?>
                                                    </p>
                                                    <button class="btn btn-outline-danger btn-sm unenroll-btn" 
                                                            data-course-id="<?= $enrollment['course_id'] ?>"
                                                            data-course-title="<?= esc($enrollment['title']) ?>">
                                                        <i class="bi bi-x-circle"></i> Unenroll
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-book display-4 text-muted"></i>
                                    <p class="mt-2">You are not enrolled in any courses yet.</p>
                                    <p>Browse available courses below to get started!</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Courses Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="feature-card">
                        <h4><i class="bi bi-plus-circle text-primary"></i> Available Courses</h4>
                        <hr>
                        <div id="available-courses">
                            <?php if (isset($roleData['availableCourses']) && !empty($roleData['availableCourses'])): ?>
                                <div class="row">
                                    <?php foreach ($roleData['availableCourses'] as $course): ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-primary">
                                                <div class="card-body">
                                                    <h5 class="card-title text-primary">
                                                        <i class="bi bi-book"></i> <?= esc($course['title']) ?>
                                                    </h5>
                                                    <p class="card-text"><?= esc($course['description']) ?></p>
                                                    <p class="text-muted">
                                                        <i class="bi bi-person"></i> Instructor: <?= esc($course['instructor_name']) ?>
                                                    </p>
                                                    <button class="btn btn-primary enroll-btn" 
                                                            data-course-id="<?= $course['id'] ?>"
                                                            data-course-title="<?= esc($course['title']) ?>">
                                                        <i class="bi bi-plus-circle"></i> Enroll Now
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-check-circle display-4 text-success"></i>
                                    <p class="mt-2">Great! You are enrolled in all available courses.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="feature-card">
                        <h4><i class="bi bi-people text-success"></i> My Classmates</h4>
                        <hr>
                        <?php if (isset($roleData['classmates']) && !empty($roleData['classmates'])): ?>
                            <?php foreach ($roleData['classmates'] as $classmate): ?>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-person-circle text-primary me-3 fs-4"></i>
                                    <div>
                                        <h6 class="mb-0"><?= esc($classmate['name']) ?></h6>
                                        <small class="text-muted"><?= esc($classmate['email']) ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">No classmates found</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="feature-card">
                        <h4><i class="bi bi-trophy text-warning"></i> Academic Progress</h4>
                        <hr>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Overall Progress</span>
                                <span>0%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Assignments Completed</span>
                                <span>0/0</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Common Actions for All Roles -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="feature-card">
                    <h4><i class="bi bi-list-check text-primary"></i> Quick Actions</h4>
                    <hr>
                    <div class="d-grid gap-2">
                        <a href="<?= site_url('/') ?>" class="btn btn-outline-primary">
                            <i class="bi bi-house"></i> Go to Homepage
                        </a>
                        <a href="<?= site_url('/about') ?>" class="btn btn-outline-info">
                            <i class="bi bi-info-circle"></i> About Us
                        </a>
                        <a href="<?= site_url('/contact') ?>" class="btn btn-outline-success">
                            <i class="bi bi-envelope"></i> Contact Support
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="feature-card">
                    <h4><i class="bi bi-gear text-secondary"></i> Account Settings</h4>
                    <hr>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-warning" disabled>
                            <i class="bi bi-person-gear"></i> Edit Profile (Coming Soon)
                        </button>
                        <button class="btn btn-outline-secondary" disabled>
                            <i class="bi bi-key"></i> Change Password (Coming Soon)
                        </button>
                        <a href="<?= site_url('/logout') ?>" class="btn btn-outline-danger" 
                           onclick="return confirm('Are you sure you want to logout?')">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery for AJAX functionality -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Update time every second
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString();
    const timeElement = document.getElementById('current-time');
    if (timeElement) {
        timeElement.textContent = timeString;
    }
}

// Update time immediately and then every second
updateTime();
setInterval(updateTime, 1000);

// AJAX Enrollment Functionality
$(document).ready(function() {
    // Handle enrollment
    $('.enroll-btn').on('click', function(e) {
        e.preventDefault();
        
        const button = $(this);
        const courseId = button.data('course-id');
        const courseTitle = button.data('course-title');
        
        // Disable button and show loading
        button.prop('disabled', true);
        button.html('<i class="bi bi-spinner-border"></i> Enrolling...');
        
        // Get CSRF token
        const csrfToken = $('meta[name="csrf-token"]').attr('content') || '<?= csrf_hash() ?>';
        
        $.post('<?= site_url('/course/enroll') ?>', {
            course_id: courseId,
            '<?= csrf_token() ?>': csrfToken
        })
        .done(function(response) {
            if (response.success) {
                // Show success message
                showAlert('success', response.message);
                
                // Remove course from available courses
                button.closest('.col-md-6').fadeOut(500, function() {
                    $(this).remove();
                    updateCourseCounts();
                });
                
                // Dynamically update enrollments without page reload
                setTimeout(function() {
                    updateEnrollmentSections();
                }, 500);
                
            } else {
                showAlert('danger', response.message);
                // Re-enable button
                button.prop('disabled', false);
                button.html('<i class="bi bi-plus-circle"></i> Enroll Now');
            }
        })
        .fail(function(xhr) {
            let errorMessage = 'An error occurred. Please try again.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            showAlert('danger', errorMessage);
            
            // Re-enable button
            button.prop('disabled', false);
            button.html('<i class="bi bi-plus-circle"></i> Enroll Now');
        });
    });
    
    // Handle unenrollment
    $('.unenroll-btn').on('click', function(e) {
        e.preventDefault();
        
        const button = $(this);
        const courseId = button.data('course-id');
        const courseTitle = button.data('course-title');
        
        // Confirm unenrollment
        if (!confirm(`Are you sure you want to unenroll from "${courseTitle}"?`)) {
            return;
        }
        
        // Disable button and show loading
        button.prop('disabled', true);
        button.html('<i class="bi bi-spinner-border"></i> Unenrolling...');
        
        // Get CSRF token
        const csrfToken = $('meta[name="csrf-token"]').attr('content') || '<?= csrf_hash() ?>';
        
        $.post('<?= site_url('/course/unenroll') ?>', {
            course_id: courseId,
            '<?= csrf_token() ?>': csrfToken
        })
        .done(function(response) {
            if (response.success) {
                // Show success message
                showAlert('success', response.message);
                
                // Remove course from enrolled courses
                button.closest('.col-md-6').fadeOut(500, function() {
                    $(this).remove();
                    updateCourseCounts();
                });
                
                // Dynamically update enrollments without page reload
                setTimeout(function() {
                    updateEnrollmentSections();
                }, 500);
                
            } else {
                showAlert('danger', response.message);
                // Re-enable button
                button.prop('disabled', false);
                button.html('<i class="bi bi-x-circle"></i> Unenroll');
            }
        })
        .fail(function(xhr) {
            let errorMessage = 'An error occurred. Please try again.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            showAlert('danger', errorMessage);
            
            // Re-enable button
            button.prop('disabled', false);
            button.html('<i class="bi bi-x-circle"></i> Unenroll');
        });
    });
});

// Helper functions
function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Insert alert at the top of the content section
    $('.content-section .container').prepend(alertHtml);
    
    // Auto-dismiss after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}

function updateCourseCounts() {
    const enrolledCount = $('#enrolled-courses .col-md-6').length;
    const availableCount = $('#available-courses .col-md-6').length;
    
    $('#enrolled-count').text(enrolledCount);
    $('#available-count').text(availableCount);
}

function addToEnrolledCourses(courseId, courseTitle) {
    // This would require fetching the full course details
    // For now, we'll just refresh the page or show a message
    // In a production app, you'd make another AJAX call to get the course details
}

function updateEnrollmentSections() {
    // Fetch updated enrollment data and refresh both sections
    $.get('<?= site_url('/course/getUserEnrollments') ?>')
    .done(function(enrollmentResponse) {
        $.get('<?= site_url('/course/getAvailableCourses') ?>')
        .done(function(availableResponse) {
            // For now, just reload the page to show updated data
            // In a production app, you'd rebuild the HTML sections dynamically
            location.reload();
        });
    });
}

function refreshAvailableCourses() {
    // Refresh available courses section
    $.get('<?= site_url('/course/getAvailableCourses') ?>')
    .done(function(response) {
        if (response.success && response.courses.length > 0) {
            // Rebuild available courses section
            // This is a simplified version - in production you'd rebuild the HTML
            location.reload(); // For now, just reload the page
        }
    });
}
</script>
