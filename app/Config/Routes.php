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
$routes->post('/register', 'Auth\RegisterController::doRegister');

$routes->get('/admin/tutorial', 'Admin\AppsTutorial::index');

$routes->get('/daftar/(:num)', 'Home::show/$1');

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
$routes->post('/form-login-admin', 'UserController::do_login');



$routes->group('admin', function ($routes) {
	$routes->get('logout', 'UserController::logout');

	$routes->get('ganti-password', 'UserController::view_change_password');
	$routes->post('ganti-password', 'UserController::api_change_password');

	// file routes
	$routes->get('file-lampiran/(:num)', 'Admin\FileDiscoveryController::file_lampiran/$1');

	// menu View laporan 
	$routes->get('/', 'Admin\LaporanController::vw_index');


	$routes->group('laporan', function ($routes) {
		$routes->get('print_bulanan', 'Admin\LaporanController::print_bulanan');
		$routes->get('print_harian', 'Admin\LaporanController::print_harian');
		$routes->get('print_apbn', 'Admin\LaporanController::print_apbn');
		$routes->get('stat_harian', 'Admin\LaporanController::vw_stat_harian');

		// menu API Laporan
		$routes->get('daftar-bulan/(:num)', 'Admin\LaporanController::index_bulan/$1');
		$routes->get('statistik/(:num)', 'Admin\LaporanController::api_statistik/$1');
		$routes->get('harian/print', 'Admin\LaporanController::print_harian');

		// $routes->get('/admin/laporan/apbn-statistik', 'Admin\LaporanController::apbn_statistik');
		$routes->get('apbn-data', 'Admin\LaporanController::apbn_data');
	});


	$routes->group('pengoprasian-kapal', function ($routes) {
		// view menu pengoprasian kapal
		$routes->get('/', 'Admin\PengoprasianKapalController::view_index');
		$routes->get('form/(:num)', 'Admin\PengoprasianKapalController::view_form/$1');
		$routes->get('detail/(:num)', 'Admin\PengoprasianKapalController::view_detail/$1');
		$routes->get('print/(:num)', 'Admin\PengoprasianKapalController::view_print/$1');

		// API menu pengoprasian kapal
		$routes->get('all', 'Admin\PengoprasianKapalController::index');
		$routes->get('(:num)', 'Admin\PengoprasianKapalController::show/$1');

		$routes->post('/', 'Admin\PengoprasianKapalController::create');
		$routes->put('(:num)', 'Admin\PengoprasianKapalController::update/$1');
		$routes->delete('(:num)', 'Admin\PengoprasianKapalController::delete/$1');
	});

	// view menu user management

	$routes->group('user-management', function ($routes) {
		$routes->get('/', 'Admin\UserManagementController::view_index');
		$routes->get('form', 'Admin\UserManagementController::view_form');
		$routes->get('form/(:num)', 'Admin\UserManagementController::view_form/$1');

		// API menu user management
		$routes->get('all', 'Admin\UserManagementController::index');
		$routes->get('(:num)', 'Admin\UserManagementController::show/$1');
		$routes->post('/', 'Admin\UserManagementController::create');
		$routes->put('(:num)', 'Admin\UserManagementController::update/$1');
		$routes->delete('(:num)', 'Admin\UserManagementController::delete/$1');
	});


	// view menu member management
	$routes->group('member-management', function ($routes) {
		$routes->get('/', 'Admin\MemberManagementController::view_index');
		$routes->get('form', 'Admin\MemberManagementController::view_form');
		$routes->get('form/(:num)', 'Admin\MemberManagementController::view_form/$1');

		// API menu user management
		$routes->get('all', 'Admin\MemberManagementController::index');
		$routes->get('(:num)', 'Admin\MemberManagementController::show/$1');
		$routes->post('/', 'Admin\MemberManagementController::create');
		$routes->put('(:num)', 'Admin\MemberManagementController::update/$1');
		$routes->delete('(:num)', 'Admin\MemberManagementController::delete/$1');
	});
});



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

	$routes->get('tutorial', 'PublicTutorial::index');
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
