<style>
	th {
		text-align: center;
		font-weight: bold;
	}
</style>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Data Kendaraan</h1>
			<?php echo showBreadCrumb(); ?>
		</div>

		<div class="section-body">
			<h2 class="section-title">
				Piutang Kendaraan
			</h2>
			<p class="section-lead">Daftar piutang Kendaraan</p>

			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card card-primary">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-md table-bordered dt-responsive nowrap w-100" id="data-table">
									<thead>
										<tr>
											<th>#</th>
											<th>Nama Kendaraan</th>
											<th>Piutang Lama</th>
											<th>Piutang</th>
											<th>Retur</th>
											<th>Bayar</th>
											<th>Lain-lain</th>
											<th>Sisa</th>
										</tr>
									</thead>
									<tbody>
                                    <?php if (count($kendaraans) > 0): ?>
                                        <?php foreach ($kendaraans as $kendaraan): ?>
											<tr>
												<td><?php echo $no++; ?></td>
												<td><?php echo $kendaraan->nama_kendaraan; ?></td>
												<td class="format-uang"><a href="#" onclick="showDetails('piutang-lama', <?php echo $kendaraan->id_kendaraan; ?>)"><?php echo toRupiah($kendaraan->piutang_lama); ?></a></td>
												<td class="format-uang"><a href="#" onclick="showDetails('piutang', <?php echo $kendaraan->id_kendaraan; ?>)"><?php echo toRupiah($kendaraan->piutang); ?></a></td>
												<td class="format-uang"><a href="#" onclick="showDetails('retur', <?php echo $kendaraan->id_kendaraan; ?>)"><?php echo toRupiah($kendaraan->retur); ?></a></td>
												<td class="format-uang"><a href="#" onclick="showDetails('bayar', <?php echo $kendaraan->id_kendaraan; ?>)"><?php echo toRupiah($kendaraan->bayar); ?></a></td>
												<td class="format-uang"><a href="#" onclick="showDetails('lain-lain', <?php echo $kendaraan->id_kendaraan; ?>)"><?php echo toRupiah($kendaraan->lain_lain); ?></a></td>
												<td class="format-uang"><?php echo toRupiah($kendaraan->sisa); ?></td>
											</tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
										<tr>
											<td class="text-center text-info font-weight-bold" colspan="7">
												Tidak ada data.
											</td>
										</tr>
                                    <?php endif; ?>
									</tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="text-center font-weight-bold" colspan="2">GRAND TOTAL</th>
                                        <th class="format-uang font-weight-bold"><?php echo toRupiah($total_piutang_lama); ?></th>
                                        <th class="format-uang font-weight-bold"><?php echo toRupiah($total_piutang); ?></th>
                                        <th class="format-uang font-weight-bold"><?php echo toRupiah($total_retur); ?></th>
                                        <th class="format-uang font-weight-bold"><?php echo toRupiah($total_bayar); ?></th>
                                        <th class="format-uang font-weight-bold"><?php echo toRupiah($total_lain_lain); ?></th>
                                        <th class="format-uang font-weight-bold"><?php echo toRupiah($total_sisa); ?></th>
                                    </tr>
                                    </tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="detail-modal">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead id="table-header"></thead>
						<tbody id="table-body"></tbody>
                        <tfoot id="table-footer"></tfoot>
					</table>
				</div>
			</div>
			<div class="modal-footer bg-whitesmoke br">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>