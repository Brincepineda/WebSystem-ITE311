<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/about', 'Home::about');
$routes->get('/contact', 'Home::contact');

// Authentication routes
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/dashboard', 'Auth::dashboard');

// Course enrollment routes
$routes->post('/course/enroll', 'Course::enroll');
$routes->post('/course/unenroll', 'Course::unenroll');
$routes->get('/course/getAvailableCourses', 'Course::getAvailableCourses');
$routes->get('/course/getUserEnrollments', 'Course::getUserEnrollments');

// Announcements routes
$routes->get('/announcements', 'Announcement::index');
$routes->get('/announcements/manage', 'Announcement::manage');
$routes->get('/announcements/create', 'Announcement::create');
$routes->post('/announcements/create', 'Announcement::create');
$routes->get('/announcements/edit/(:num)', 'Announcement::edit/$1');
$routes->post('/announcements/edit/(:num)', 'Announcement::edit/$1');
$routes->get('/announcements/delete/(:num)', 'Announcement::delete/$1');

// Admin routes (protected by RoleAuth filter)
$routes->group('admin', function($routes) {
    $routes->get('/', 'Admin::dashboard');
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('users', 'Admin::users');
    $routes->get('settings', 'Admin::settings');
    $routes->get('reports', 'Admin::reports');
});

// Teacher routes (protected by RoleAuth filter)
$routes->group('teacher', function($routes) {
    $routes->get('/', 'Teacher::dashboard');
    $routes->get('dashboard', 'Teacher::dashboard');
    $routes->get('courses', 'Teacher::courses');
    $routes->get('students', 'Teacher::students');
    $routes->get('grades', 'Teacher::grades');
});


