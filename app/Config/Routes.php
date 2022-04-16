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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::vw_index');
$routes->get('/all', 'Home::index');

$routes->get('/login', 'Auth\LoginController::index');
$routes->post('/login', 'Auth\LoginController::login');
$routes->get('/logout', 'UserController::logout');

$routes->get('/register', 'Auth\RegisterController::index');
$routes->post('/register', 'Auth\RegisterController::register');

$routes->get('/tutorial', 'PublicTutorial::index');
$routes->get('/admin/tutorial', 'Admin\AppsTutorial::index');

// $routes->get('/daftar/(:num)', 'Home::show/$1');

// $routes->get('/daftar', 'Home::view_daftar');
// $routes->post('/daftar', 'Home::create');

// $routes->get('/perbaikan-data/(:segment)', 'Home::vw_edit/$1');
// $routes->post('/perbaikan-data/(:segment)', 'Home::update/$1');

$routes->get('/file-lampiran/(:num)/(:segment)', 'Admin\FileDiscoveryController::file_lampiran_public/$1/$2');

$routes->get('/validation/(:segment)', 'ValidationController::qrcode/$1');
$routes->get('/validation-lap-bulan/(:segment)', 'ValidationController::qrcodeLaporanBulanan/$1');
$routes->get('/validation-lap-hari/(:segment)', 'ValidationController::qrcodeLaporanHarian/$1');
// $routes->get('/admin/qrcode/image', 'ValidationController::qrcodeImage');

$routes->get('/form-login-admin', 'UserController::view_login');
$routes->post('/form-login-admin', 'UserController::api_check_login');

$routes->get('/admin/logout', 'UserController::logout');

$routes->get('/admin/ganti-password', 'UserController::view_change_password');
$routes->post('/admin/ganti-password', 'UserController::api_change_password');

// file routes
$routes->get('/admin/file-lampiran/(:num)', 'Admin\FileDiscoveryController::file_lampiran/$1');

// menu View laporan 
$routes->get('/admin', 'Admin\LaporanController::vw_index');
$routes->get('/admin/laporan/print_bulanan', 'Admin\LaporanController::print_bulanan');
$routes->get('/admin/laporan/print_harian', 'Admin\LaporanController::print_harian');
$routes->get('/admin/laporan/print_apbn', 'Admin\LaporanController::print_apbn');
$routes->get('/admin/laporan/stat_harian', 'Admin\LaporanController::vw_stat_harian');

// menu API Laporan
$routes->get('/admin/laporan/daftar-bulan/(:num)', 'Admin\LaporanController::index_bulan/$1');
$routes->get('/admin/laporan/statistik/(:num)', 'Admin\LaporanController::api_statistik/$1');
$routes->get('/admin/laporan/harian/print', 'Admin\LaporanController::print_harian');

// $routes->get('/admin/laporan/apbn-statistik', 'Admin\LaporanController::apbn_statistik');
$routes->get('/admin/laporan/apbn-data', 'Admin\LaporanController::apbn_data');



// view menu pengoprasian kapal
$routes->get('/admin/pengoprasian-kapal/', 'Admin\PengoprasianKapalController::view_index');
$routes->get('/admin/pengoprasian-kapal/form/(:num)', 'Admin\PengoprasianKapalController::view_form/$1');
$routes->get('/admin/pengoprasian-kapal/detail/(:num)', 'Admin\PengoprasianKapalController::view_detail/$1');
$routes->get('/admin/pengoprasian-kapal/print/(:num)', 'Admin\PengoprasianKapalController::view_print/$1');

// API menu pengoprasian kapal
$routes->get('/admin/pengoprasian-kapal/all', 'Admin\PengoprasianKapalController::index');
$routes->get('/admin/pengoprasian-kapal/(:num)', 'Admin\PengoprasianKapalController::show/$1');

$routes->post('/admin/pengoprasian-kapal/', 'Admin\PengoprasianKapalController::create');
$routes->put('/admin/pengoprasian-kapal/(:num)', 'Admin\PengoprasianKapalController::update/$1');
$routes->delete('/admin/pengoprasian-kapal/(:num)', 'Admin\PengoprasianKapalController::delete/$1');


// view menu user management

$routes->get('/admin/user-management', 'Admin\UserManagementController::view_index');
$routes->get('/admin/user-management/form', 'Admin\UserManagementController::view_form');
$routes->get('/admin/user-management/form/(:num)', 'Admin\UserManagementController::view_form/$1');

// API menu user management
$routes->get('/admin/user-management/all', 'Admin\UserManagementController::index');
$routes->get('/admin/user-management/(:num)', 'Admin\UserManagementController::show/$1');
$routes->post('/admin/user-management/', 'Admin\UserManagementController::create');
$routes->put('/admin/user-management/(:num)', 'Admin\UserManagementController::update/$1');
$routes->delete('/admin/user-management/(:num)', 'Admin\UserManagementController::delete/$1');


// member area
$routes->group('member', function ($routes) {
	$routes->get('/', 'Member\DashboardController::index');

	$routes->group('tambat-labuh', function ($routes) {
		$routes->get('/', 'Member\TambatLabuhController::index');
		$routes->get('list', 'Member\TambatLabuhController::getList');
		$routes->get('detail/(:num)', 'Member\TambatLabuhController::getDetail/$1');
		$routes->get('print/(:num)', 'Member\TambatLabuhController::print/$1');

		$routes->get('show/(:num)', 'Member\TambatLabuhController::show/$1');

		$routes->get('create', 'Member\TambatLabuhController::create');
		$routes->post('create', 'Member\TambatLabuhController::store');

		$routes->get('edit/(:num)', 'Member\TambatLabuhController::edit/$1');
		$routes->post('edit/(:num)', 'Member\TambatLabuhController::update/$1');
		$routes->delete('/(:num)', 'Member\TambatLabuhController::delete/$1');
	});

	$routes->get('file-lampiran/(:num)', 'Admin\FileDiscoveryController::file_lampiran/$1');

	$routes->get('ganti-password', 'Member\UserController::change_password');
	$routes->post('ganti-password', 'Member\UserController::do_change_password');
});

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
