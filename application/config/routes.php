<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'authentication';
$route['404_override'] = 'Errorpage';
$route['translate_uri_dashes'] = TRUE;

//CUSTOM ROUTE LIST
$route['auth'] = 'Authentication';
$route['login'] = 'Authentication/index';
$route['logout'] = 'Authentication/logout';

//Restrict page route
$route['restrict-page'] = 'Errorpage/restrict_page';

$route['data-kendaraan'] = 'Kendaraan/index';
$route['data-kendaraan/get-data-kendaraan'] = 'Kendaraan/get_data_kendaraan';
$route['data-kendaraan/create'] = 'Kendaraan/create';
$route['data-kendaraan/(:any)/(:num)'] = 'Kendaraan/$1/$2';

$route['data-progressif'] = 'Progressif/index';
$route['data-progressif/create'] = 'Progressif/create';
$route['data-progressif/(:any)/(:num)'] = 'Progressif/$1/$2';

$route['profil-perusahaan'] = 'ProfilPerusahaan';
$route['profil-perusahaan/edit'] = 'ProfilPerusahaan/edit';
$route['profil-perusahaan/upload'] = 'ProfilPerusahaan/upload';

$route['pengaturan-aplikasi'] = 'Pengaturan';
$route['pengaturan-aplikasi/change-sidebar-appearance'] = 'Pengaturan/change_sidebar_appearance';
$route['pengaturan-aplikasi/edit'] = 'Pengaturan/edit';

//Export excel routes
$route['export-excel/(:any)'] = 'ExportExcel/$1';