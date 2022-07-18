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

$route['jenis-bayar'] = 'JenisBayar/index';
$route['jenis-bayar/create'] = 'JenisBayar/create';
$route['jenis-bayar/(:any)/(:num)'] = 'JenisBayar/$1/$2';

$route['nota-penjualan'] = 'NotaPenjualan/index';
$route['nota-penjualan/daftar'] = 'NotaPenjualan/daftar';
$route['nota-penjualan/create'] = 'NotaPenjualan/create';
$route['nota-penjualan/status'] = 'NotaPenjualan/status';
$route['nota-penjualan/get-total/(:any)'] = 'NotaPenjualan/getTotal/$1';
$route['nota-penjualan/get-ajax'] = 'NotaPenjualan/getNotaPenjualanAjax';
$route['nota-penjualan/(:any)/(:num)'] = 'NotaPenjualan/$1/$2';

$route['retur-penjualan'] = 'ReturPenjualan/index';
$route['retur-penjualan/daftar'] = 'ReturPenjualan/daftar';
$route['retur-penjualan/create'] = 'ReturPenjualan/create';
$route['retur-penjualan/status'] = 'ReturPenjualan/status';
$route['retur-penjualan/get-total/(:any)'] = 'ReturPenjualan/getTotal/$1';
$route['retur-penjualan/(:any)/(:num)'] = 'ReturPenjualan/$1/$2';

$route['pembayaran-piutang'] = 'PembayaranPiutang/index';
$route['pembayaran-piutang/daftar'] = 'PembayaranPiutang/daftar';
$route['pembayaran-piutang/create'] = 'PembayaranPiutang/create';
$route['pembayaran-piutang/status'] = 'PembayaranPiutang/status';
$route['pembayaran-piutang/(:any)/(:num)'] = 'PembayaranPiutang/$1/$2';

$route['pelanggan/get-detail/([a-z]+)/(:num)'] = 'Pelanggan/get_detail/$1/$2';

$route['nota-pembelian'] = 'NotaPembelian/index';
$route['nota-pembelian/create'] = 'NotaPembelian/create';
$route['nota-pembelian/(:any)/(:num)'] = 'NotaPembelian/$1/$2';
$route['daftar-nota-pembelian'] = 'NotaPembelian/daftar';

$route['daftar-bayar'] = 'DaftarBayar/index';
$route['daftar-bayar/create'] = 'DaftarBayar/create';
$route['daftar-bayar/(:any)/(:num)'] = 'DaftarBayar/$1/$2';

$route['uang-masuk'] = 'UangMasuk/index';
$route['uang-masuk/create'] = 'UangMasuk/create';
$route['uang-masuk/(:any)/(:num)'] = 'UangMasuk/$1/$2';

$route['uang-keluar'] = 'UangKeluar/index';
$route['uang-keluar/create'] = 'UangKeluar/create';
$route['uang-keluar/(:any)/(:num)'] = 'UangKeluar/$1/$2';

$route['transfer'] = 'transfer/index';
$route['transfer/create'] = 'transfer/create';
$route['transfer/(:any)/(:num)'] = 'transfer/$1/$2';

$route['retur-supplier'] = 'ReturSupplier/index';
$route['retur-supplier/create'] = 'ReturSupplier/create';
$route['retur-supplier/daftar'] = 'ReturSupplier/daftar';
$route['retur-supplier/status'] = 'ReturSupplier/status';
$route['retur-supplier/get-total/(:any)'] = 'ReturSupplier/getTotal/$1';
$route['retur-supplier/(:any)/(:num)'] = 'ReturSupplier/$1/$2';

$route['nota-supplier'] = 'NotaSupplier/index';
$route['nota-supplier/create'] = 'NotaSupplier/create';
$route['nota-supplier/daftar'] = 'NotaSupplier/daftar';
$route['nota-supplier/status'] = 'NotaSupplier/status';
$route['nota-supplier/get-total/(:any)'] = 'NotaSupplier/getTotal/$1';
$route['nota-supplier/(:any)/(:any)'] = 'NotaSupplier/$1/$2';

$route['pembayaran-hutang'] = 'PembayaranHutang/index';
$route['pembayaran-hutang/create'] = 'PembayaranHutang/create';
$route['pembayaran-hutang/daftar'] = 'PembayaranHutang/daftar';
$route['pembayaran-hutang/status'] = 'PembayaranHutang/status';
$route['pembayaran-hutang/(:any)/(:any)'] = 'PembayaranHutang/$1/$2';

$route['profil-perusahaan'] = 'ProfilPerusahaan';
$route['profil-perusahaan/edit'] = 'ProfilPerusahaan/edit';
$route['profil-perusahaan/upload'] = 'ProfilPerusahaan/upload';

$route['pengaturan-aplikasi'] = 'Pengaturan';
$route['pengaturan-aplikasi/change-sidebar-appearance'] = 'Pengaturan/change_sidebar_appearance';
$route['pengaturan-aplikasi/edit'] = 'Pengaturan/edit';

//Export excel routes
$route['export-excel/(:any)'] = 'ExportExcel/$1';

//Cetak biaya
$route['cetak/biaya-masuk/(:any)'] = 'Cetak/biaya/$1';
$route['cetak/biaya-keluar/(:any)'] = 'Cetak/biaya/$1';

$route['rekening-koran'] = 'RekeningKoran/index';
$route['rekening-koran/create'] = 'RekeningKoran/create';
$route['rekening-koran/daftar'] = 'RekeningKoran/daftar';
$route['rekening-koran/status'] = 'RekeningKoran/status';
$route['rekening-koran/get-kode-pembayaran'] = 'RekeningKoran/get_kode_pembayaran';
$route['rekening-koran/(:any)/(:num)'] = 'RekeningKoran/$1/$2';

$route['perhitungan/(:any)'] = 'Perhitungan/index/$1';
$route['cetak/komisi'] = 'Cetak/perhitungan/komisi';
$route['cetak/cashback'] = 'Cetak/perhitungan/cashback';