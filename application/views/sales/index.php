<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Data Sales</h1>
            <?php echo showBreadCrumb(); ?>
		</div>

		<div class="section-body">
			<h2 class="section-title">
				Daftar Sales
			</h2>
			<p class="section-lead">Daftar data Sales</p>

			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card card-primary">
						<div class="card-header">
							<div class="card-header-action">
								<a href="<?php echo base_url('sales/create'); ?>" class="btn btn-primary btn-icon icon-left float-right">
									<i class="fa fa-plus"></i>
									Tambah Data
								</a>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-md table-bordered w-100" id="mytable">
									<thead>
									<tr>
										<th>#</th>
										<th>Nama Sales</th>
										<th>Alamat</th>
										<th>Kota</th>
										<th>Kontak</th>
                                        <?php if (showOnlyTo("1|2")): ?>
											<th class="text-center">Aksi</th>
                                        <?php endif; ?>
									</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>