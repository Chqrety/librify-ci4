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

  $routes->get('books', 'BookController::index');
  $routes->get('books/create', 'BookController::create');
  $routes->post('books/store', 'BookController::store');
  $routes->get('books/edit/(:num)', 'BookController::edit/$1');
  $routes->post('books/update/(:num)', 'BookController::update/$1');
  $routes->get('books/delete/(:num)', 'BookController::delete/$1');

  $routes->get('books/show/(:num)', 'BookController::show/$1');
});

$routes->group('member', ['filter' => 'role:member'], static function ($routes) {
  $routes->get('dashboard', 'MemberController::dashboard');
  $routes->get('search', 'MemberController::search'); // <--- TAMBAHKAN BARIS INI

  $routes->get('payment/fine/(:num)', 'PaymentController::payFine/$1');
  $routes->get('payment/success/(:num)', 'PaymentController::success/$1');
});

$routes->group('api', ['filter' => 'apikey'], static function ($routes) {
  $routes->get('books', 'Api\BookApi::index');
});