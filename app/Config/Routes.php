<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');

$routes->group('admin', ['filter' => 'role:admin'], static function ($routes) {
  $routes->get('dashboard', 'AdminController::dashboard');
});

$routes->group('member', ['filter' => 'role:member'], static function ($routes) {
  $routes->get('dashboard', 'MemberController::dashboard');
});