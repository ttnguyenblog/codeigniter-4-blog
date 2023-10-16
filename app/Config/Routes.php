<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');



$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {

    $routes->add('login', 'Admin::login');
    $routes->get('success', 'Admin::success');
    $routes->add('logout', 'Admin::logout');
    $routes->add('account', 'Account::index');

    $routes->add('forgot-password', 'Admin::forgot_password');
    $routes->add('reset-password', 'Admin::reset_password');

    $routes->add('article', 'Article::index');
    $routes->add('article/add', 'Article::add');
    $routes->add('article/edit/(:num)', 'Article::edit/$1');

    $routes->add('page', 'Page::index');
    $routes->add('page/add', 'Page::add');
    $routes->add('page/edit/(:num)', 'Page::edit/$1');



});


$routes->group('', ['namespace' => 'App\Controllers'], static function ($routes) {

    
    $routes->add('blog', 'Blog::index');
    $routes->add('contact', 'Contact::index');

});

$routes->add('article/(:any)', 'Article::index/$1');
$routes->add('page/(:any)', 'Page::index/$1');
