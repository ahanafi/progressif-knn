<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Retur Penjualan</h1>
            <?php echo showBreadCrumb(); ?>
		</div>

		<div class="section-body">
			<h2 class="section-title">
				Tambah Retur Penjualan
			</h2>
			<p class="section-lead">Tambah Data Retur Penjualan</p>

			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card card-primary">
						<div class="card-header">
							<div class="card-header-action">
								<a href="<?php echo base_url('retur-penjualan/create'); ?>" class="btn btn-primary btn-icon icon-left float-right">
									<i class="fa fa-plus"></i>
									<span>Tambah Data</span>
								</a>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-md table-bordered dt-responsive nowrap w-100" id="data-table">
									<thead>
									<tr>
										<th>#</th>
										<th>No. retur</th>
										<th>Tanggal</th>
										<th>Nama Pelanggan</th>
                                        <th>Sales</th>
										<th class="text-center">Total</th>
										<th>Status</th>
										<th>Potong</th>
										<th>Lunas</th>
										<th class="text-center">Aksi</th>
									</tr>
									</thead>
									<tbody>
                                    <?php if (count($retur_penjualan) > 0): ?>
                                        <?php foreach ($retur_penjualan as $retur): ?>
											<tr>
												<td><?php echo $no++; ?></td>
												<td>
                                                    <?php if ($retur->file_retur != '' && file_exists(FCPATH . 'uploads/retur-penjualan/' . $retur->file_retur)): ?>
														<a href="#" onclick="showFileNota('<?php echo $retur->pdflink; ?>')" class="btn-link"><?php echo $retur->no_retur; ?></a>
                                                    <?php else: ?>
                                                        <?php echo $retur->no_retur; ?>
                                                    <?php endif; ?>
												</td>
												  <td data-sort="<?php echo strtotime($retur->tanggal);  ?>"><?php echo IdFormatDate($retur->tanggal); ?></td>
												<td><?php echo $retur->nama_pelanggan; ?></td>
                                                <td><?php echo $retur->sales; ?></td>
												<td class="format-uang"><?php echo toRupiah($retur->total); ?></td>
												<td><?php echo getStatus($retur->status); ?></td>
												<td class="format-uang"><?php echo toRupiah($retur->potong); ?></td>
												<td><?php echo getStatus($retur->lunas, 'pelunasan'); ?></td>
												<td class="text-center">
                                                    <?php if ($retur->status == 0): ?>
														<a href="<?php echo base_url('retur-penjualan/edit/' . $retur->id_retur_penjualan); ?>" class="btn btn-light">
															<i class="fa fa-edit"></i>
														</a>
														<a href="#" class="btn btn-light" onclick="showConfirmDelete('retur-penjualan', <?php echo $retur->id_retur_penjualan; ?>)">
															<i class="fa fa-trash-alt"></i>
														</a>
                                                    <?php else: ?>
														<b><i><small>No action</small></i></b>
                                                    <?php endif; ?>
												</td>
											</tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
										<tr>
											<td class="text-center text-info font-weight-bold" colspan="9">
												Tidak ada data.
											</td>
										</tr>
                                    <?php endif; ?>
									</tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-center font-weight-bold">GRAND TOTAL</th>
                                        <th class="format-uang font-weight-bold"><?php echo toRupiah($grand_total_retur); ?></th>
                                        <th></th>
                                        <th class="format-uang font-weight-bold"><?php echo toRupiah($grand_total_potong); ?></th>
                                        <th></th>
                                        <th></th>
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
<div class="modal fade" id="preview-nota" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Pratinjau Nota</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<iframe id="target-view" src="" width="100%" height="520px"></iframe>
			</div>
		</div>
	</div>
</div>