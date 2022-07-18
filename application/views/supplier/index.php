<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Data Supplier</h1>
            <?php echo showBreadCrumb(); ?>
		</div>

		<div class="section-body">
			<h2 class="section-title">
				Daftar Supplier
			</h2>
			<p class="section-lead">Daftar Supplier</p>

			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card card-primary">
						<div class="card-header">
							<div class="card-header-action">
								<a href="<?php echo base_url('supplier/create'); ?>" class="btn btn-primary btn-icon icon-left float-right">
									<i class="fa fa-plus"></i>
									Tambah Data
								</a>
								<a target="_blank" href="<?php echo base_url('cetak/supplier'); ?>" class="btn btn-light btn-icon icon-left float-right mr-2">
									<i class="fa fa-print"></i>
									Cetak Data
								</a>
							</div>
						</div>
						<div class="card-body">

							<table id='mytable' class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
								<thead>
								<tr>
									<th class="text-center">#</th>
									<th>Nama Supplier</th>
									<th>Alamat</th>
									<th>Kota</th>
									<th>Kontak</th>
									<th class="text-center">Aksi</th>
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
