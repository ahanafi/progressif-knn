<?php
defined('BASEPATH') or exit('No direct script access allowed');
//Nota supplier
$grandTotalHpp = 0;
$grandTotalReturSupplier = 0;
$grandTotalPembayaranSupplier = 0;

//Penjualan
$grandTotalPenjualan = 0;
$grandTotalReturPenjualan = 0;
$grandTotalPembayaranPenjualan = 0;
?>
<style>
    table tr td, table tr th {
        padding: .5rem !important;
        height: auto !important;
    }

    .filter-selection {
        width: 16rem !important;
        border-radius: 5px !important;
        padding: 4px 8px !important;
        height: auto !important;
        margin-left: 30px !important;
    }
</style>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Dashboard</h1>
		</div>
		<div class="section-body">
			<div class="row">
				<div class="col-lg-12 col-12">
					<div class="card card-primary" id="nota-supplier">
						<div class="card-header">
							<h4 class="text-uppercase text-primary" style="width: auto !important;">Dashboard</h4>
						</div>
						<div class="card-body d-flex flex-column justify-content-center align-items-center text-center" style="height: 380px;">
                            <img src="<?php echo base_url('assets/img/logo-prov-jabar.png') ?>" alt="Logo Prov Jabar" style="width: 200px;">
							<h3 class="mt-5">Selamat datang di Aplikasi <br> Pengelolaan Pengecekan Kendaraan Progresif</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
