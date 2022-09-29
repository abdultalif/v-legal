<?php
namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::index');
$routes->get('/profile', 'Home::profile');

// Provinsi
$routes->get('/provinsi', 'Provinsi::index');
$routes->get('/provinsi/add', 'Provinsi::add');
$routes->delete('/provinsi/(:number)', 'Provinsi::delete/$1');
$routes->get('/provinsi/(:number)', 'Provinsi::edit/$1');

// Kabupaten
$routes->get('/kabupaten', 'Kabupaten::index');
$routes->get('/kabupaten/add', 'Kabupaten::add');
$routes->delete('/kabupaten/(:number)', 'Kabupaten::delete/$1');
$routes->get('/kabupaten/(:number)', 'Kabupaten::edit/$1');
$routes->get('/vlegal', 'Service::index');
$routes->get('/terkirim', 'Service::terkirim');
// $routes->get('/pembatalan', 'Service::list_pembatalan');

// Untuk Client
$routes->get('/download', 'Pengajuan::hasil');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
