<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title><?= isset($title) ? $title : 'ITE311 PINEDA' ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: rgba(0, 0, 0, 0.8) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .nav-link {
            transition: all 0.3s ease;
            border-radius: 20px;
            margin: 0 5px;
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2) !important;
        }
        
        .content-wrapper {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            margin-top: 2rem;
            margin-bottom: 2rem;
            overflow: hidden;
        }
        
        .hero-section {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 3rem 0;
            text-align: center;
        }
        
        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .hero-section p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .content-section {
            padding: 2rem;
        }
        
        .feature-card {
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .btn-custom {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 25px;
            padding: 0.8rem 2rem;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            color: white;
        }
        
        footer {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: 3rem;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="<?= site_url('/') ?>">
            <i class="bi bi-code-slash"></i> ITE311 PINEDA
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link <?= (isset($active_page) && $active_page == 'home') ? 'active' : '' ?>" href="<?= site_url('/') ?>">
                <i class="bi bi-house-fill"></i> Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= (isset($active_page) && $active_page == 'about') ? 'active' : '' ?>" href="<?= site_url('/about') ?>">
                <i class="bi bi-person-fill"></i> About
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= (isset($active_page) && $active_page == 'contact') ? 'active' : '' ?>" href="<?= site_url('/contact') ?>">
                <i class="bi bi-envelope-fill"></i> Contact
              </a>
            </li>
            <?php if (session()->get('isLoggedIn')): ?>
            <li class="nav-item">
              <a class="nav-link <?= (isset($active_page) && $active_page == 'announcements') ? 'active' : '' ?>" href="<?= site_url('/announcements') ?>">
                <i class="bi bi-megaphone-fill"></i> Announcements
              </a>
            </li>
            <?php endif; ?>
          </ul>
          <ul class="navbar-nav ms-auto">
            <?php if (session()->get('isLoggedIn')): ?>
              <?php 
              $userRole = session()->get('role');
              $roleColors = [
                  'admin' => 'danger',
                  'teacher' => 'success', 
                  'student' => 'primary'
              ];
              ?>
              
              <!-- Role-specific navigation items -->
              <?php if ($userRole === 'admin'): ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-shield-fill-check text-danger"></i> Admin Panel
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= site_url('/dashboard') ?>">
                      <i class="bi bi-speedometer2"></i> Dashboard
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?= site_url('/announcements/manage') ?>">
                      <i class="bi bi-megaphone"></i> Manage Announcements
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="alert('Feature coming soon!')">
                      <i class="bi bi-people"></i> Manage Users
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="alert('Feature coming soon!')">
                      <i class="bi bi-gear"></i> System Settings
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="alert('Feature coming soon!')">
                      <i class="bi bi-bar-chart"></i> Reports
                    </a></li>
                  </ul>
                </li>
              <?php elseif ($userRole === 'teacher'): ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-workspace text-success"></i> Teacher Tools
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= site_url('/dashboard') ?>">
                      <i class="bi bi-speedometer2"></i> Dashboard
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" onclick="alert('Feature coming soon!')">
                      <i class="bi bi-people"></i> My Students
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="alert('Feature coming soon!')">
                      <i class="bi bi-book"></i> Courses
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="alert('Feature coming soon!')">
                      <i class="bi bi-clipboard-check"></i> Assignments
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="alert('Feature coming soon!')">
                      <i class="bi bi-graph-up"></i> Grades
                    </a></li>
                  </ul>
                </li>
              <?php else: ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-mortarboard-fill text-primary"></i> Student Portal
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= site_url('/dashboard') ?>">
                      <i class="bi bi-speedometer2"></i> Dashboard
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" onclick="alert('Feature coming soon!')">
                      <i class="bi bi-book"></i> My Courses
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="alert('Feature coming soon!')">
                      <i class="bi bi-clipboard-check"></i> Assignments
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="alert('Feature coming soon!')">
                      <i class="bi bi-trophy"></i> Grades
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="alert('Feature coming soon!')">
                      <i class="bi bi-people"></i> Classmates
                    </a></li>
                  </ul>
                </li>
              <?php endif; ?>
              
              <!-- User profile dropdown -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                  <i class="bi bi-person-circle"></i> 
                  <span class="badge bg-<?= $roleColors[$userRole] ?? 'secondary' ?> me-1"><?= ucfirst($userRole) ?></span>
                  <?= esc(session()->get('name')) ?>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="<?= site_url('/dashboard') ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                  </a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#" onclick="alert('Feature coming soon!')">
                    <i class="bi bi-person-gear"></i> Edit Profile
                  </a></li>
                  <li><a class="dropdown-item" href="#" onclick="alert('Feature coming soon!')">
                    <i class="bi bi-key"></i> Change Password
                  </a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item text-danger" href="<?= site_url('/logout') ?>" onclick="return confirm('Are you sure you want to logout?')">
                    <i class="bi bi-box-arrow-right"></i> Logout
                  </a></li>
                </ul>
              </li>
            <?php else: ?>
              <li class="nav-item">
                <a class="nav-link <?= (isset($active_page) && $active_page == 'login') ? 'active' : '' ?>" href="<?= site_url('/login') ?>">
                  <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= (isset($active_page) && $active_page == 'register') ? 'active' : '' ?>" href="<?= site_url('/register') ?>">
                  <i class="bi bi-person-plus"></i> Register
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="content-wrapper">
            <?php if (isset($content)) echo $content; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2025 ITE311 PINEDA. Built with CodeIgniter 4 & Bootstrap 5.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
