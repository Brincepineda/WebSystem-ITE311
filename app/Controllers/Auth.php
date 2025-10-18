<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        
        // Security headers
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');
    }

    public function register()
    {
        // Check if form was submitted (POST request)
        if ($this->request->getMethod() === 'POST') {
            // Set validation rules
            $validation = \Config\Services::validation();
            $validation->setRules([
                'name' => [
                    'label' => 'Name',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => 'Name is required.',
                        'min_length' => 'Name must be at least 3 characters long.',
                        'max_length' => 'Name cannot exceed 100 characters.'
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email|is_unique[users.email]',
                    'errors' => [
                        'required' => 'Email is required.',
                        'valid_email' => 'Please enter a valid email address.',
                        'is_unique' => 'This email is already registered.'
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required|min_length[6]',
                    'errors' => [
                        'required' => 'Password is required.',
                        'min_length' => 'Password must be at least 6 characters long.'
                    ]
                ],
                'password_confirm' => [
                    'label' => 'Confirm Password',
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'Please confirm your password.',
                        'matches' => 'Passwords do not match.'
                    ]
                ]
            ]);

            if ($validation->withRequest($this->request)->run()) {
                // Hash the password
                $hashedPassword = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

                // Prepare user data
                $userData = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'password' => $hashedPassword,
                    'role' => 'user',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Insert user into database
                $builder = $this->db->table('users');
                if ($builder->insert($userData)) {
                    $this->session->setFlashdata('success', 'Registration successful! Please login with your credentials.');
                    return redirect()->to('/login');
                } else {
                    $this->session->setFlashdata('error', 'Registration failed. Please try again.');
                }
            } else {
                $this->session->setFlashdata('validation', $validation);
            }
        }

        // Load registration view
        $data = [
            'title' => 'Register - ITE311 PINEDA',
            'active_page' => 'register',
            'content' => view('auth/register')
        ];
        return view('template', $data);
    }

    public function login()
    {
        // Check if form was submitted (POST request)
        if ($this->request->getMethod() === 'POST') {
            // Set validation rules
            $validation = \Config\Services::validation();
            $validation->setRules([
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email is required.',
                        'valid_email' => 'Please enter a valid email address.'
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password is required.'
                    ]
                ]
            ]);

            if ($validation->withRequest($this->request)->run()) {
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');

                // Check database for user
                $builder = $this->db->table('users');
                $user = $builder->where('email', $email)->get()->getRowArray();

                if ($user && password_verify($password, $user['password'])) {
                    // Create user session
                    $sessionData = [
                        'userID' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                        'isLoggedIn' => true
                    ];
                    $this->session->set($sessionData);

                    $this->session->setFlashdata('success', 'Welcome back, ' . $user['name'] . '!');
                    return redirect()->to('/dashboard');
                } else {
                    $this->session->setFlashdata('error', 'Invalid email or password.');
                }
            } else {
                $this->session->setFlashdata('validation', $validation);
            }
        }

        // Load login view
        $data = [
            'title' => 'Login - ITE311 PINEDA',
            'active_page' => 'login',
            'content' => view('auth/login')
        ];
        return view('template', $data);
    }

    public function logout()
    {
        // Destroy the session
        $this->session->destroy();
        $this->session->setFlashdata('success', 'You have been logged out successfully.');
        return redirect()->to('/login');
    }

    public function dashboard()
    {
        // Check if user is logged in
        if (!$this->session->get('isLoggedIn')) {
            $this->session->setFlashdata('error', 'Please login to access the dashboard.');
            return redirect()->to('/login');
        }

        $userRole = $this->session->get('role');
        $userId = $this->session->get('userID');
        
        // Fetch role-specific data
        $roleData = $this->getRoleSpecificData($userRole, $userId);

        // Load dashboard view with role-specific data
        $data = [
            'title' => 'Dashboard - ITE311 PINEDA',
            'active_page' => 'dashboard',
            'content' => view('auth/dashboard', [
                'user' => [
                    'id' => $userId,
                    'name' => $this->session->get('name'),
                    'email' => $this->session->get('email'),
                    'role' => $userRole
                ],
                'roleData' => $roleData
            ]),
            'user' => [
                'id' => $userId,
                'name' => $this->session->get('name'),
                'email' => $this->session->get('email'),
                'role' => $userRole
            ]
        ];
        return view('template', $data);
    }

    private function getRoleSpecificData($role, $userId)
    {
        $data = [];
        
        switch ($role) {
            case 'admin':
                // Admin can see all users and system stats
                $builder = $this->db->table('users');
                $data['totalUsers'] = $builder->countAllResults();
                $data['usersByRole'] = $this->db->query("SELECT role, COUNT(*) as count FROM users GROUP BY role")->getResultArray();
                $data['recentUsers'] = $this->db->table('users')->orderBy('created_at', 'DESC')->limit(5)->get()->getResultArray();
                break;
                
            case 'teacher':
                // Teacher can see student-related data
                $data['totalStudents'] = $this->db->table('users')->where('role', 'student')->countAllResults();
                $data['students'] = $this->db->table('users')->where('role', 'student')->get()->getResultArray();
                break;
                
            case 'student':
                // Student can see their own profile and enrollment info
                $enrollmentModel = new \App\Models\EnrollmentModel();
                $data['profile'] = $this->db->table('users')->where('id', $userId)->get()->getRowArray();
                $data['classmates'] = $this->db->table('users')->where('role', 'student')->where('id !=', $userId)->limit(5)->get()->getResultArray();
                $data['enrollments'] = $enrollmentModel->getUserEnrollments($userId);
                $data['availableCourses'] = $enrollmentModel->getAvailableCourses($userId);
                break;
        }
        
        return $data;
    }
}
