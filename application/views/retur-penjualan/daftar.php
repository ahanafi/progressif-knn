<?php
$getParameter = $get_parameter;
$index = 1;
?>

<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Retur Penjualan</h1>
            <?php echo showBreadCrumb(); ?>
		</div>

		<div class="section-body">
			<h2 class="section-title">
				Daftar Retur Penjualan
			</h2>
			<p class="section-lead">Daftar Retur Penjualan</p>

			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class='card-body'>
						<form action='' method='get'>
							<div class='form-group row col-sm-6'>
								<label class='col-sm-3 col-form-label'>
									Pelanggan
								</label>
								<div class='col-sm-9'>
									<select class='form-control select2' name="id_pelanggan">
										<option disabled selected>-- Pilih Pelanggan --</option>
                                        <?php foreach ($pelanggan as $p): ?>
											<option <?php echo (isset($_GET['id_pelanggan']) && $_GET['id_pelanggan'] === $p->id_pelanggan) ? 'selected' : ''; ?> value="<?php echo $p->id_pelanggan; ?>"><?php echo $p->nama_pelanggan; ?></option>
                                        <?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class='form-group col-sm-6 row'>
								<label class='col-sm-3 col-form-label'>
									Bulan
								</label>
								<div class='col-sm-9'>
									<select class='form-control select2' name="bulan">
										<option disabled selected>-- Pilih Bulan --</option>
                                        <?php foreach ($bulan as $b): ?>
											<option <?php echo (isset($_GET['bulan']) && $_GET['bulan'] == $index) ? 'selected' : ''; ?> value="<?php echo $index; ?>"><?php echo $b; ?></option>
                                            <?php $index++; ?>
                                        <?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class='row col-sm-6'>
								<div class='col-sm-3'>
								</div>
								<div class='col-sm-9'>
									<button type="submit" class="btn btn-primary btn-icon icon-left">
										<i class="fa fa-eye"></i>
										Tampilkan
									</button> &nbsp;
                                    <?php if (isset($_GET['id_pelanggan']) || isset($_GET['bulan']) || isset($_GET['bulan'])): ?>
										<a href="<?php echo base_url('retur-penjualan/daftar'); ?>" class="btn btn-danger">
											<i class="fa fa-retweet"></i>
											<span>Reset Filter</span>
										</a>
                                    <?php endif; ?>
									<a href="<?php echo base_url('cetak/retur-penjualan') . $getParameter;; ?>" class="btn btn-primary btn-icon icon-left" target="_blank">
										<i class="fa fa-print"></i>
										Cetak
									</a>
								</div>
							</div>

						</form>
					</div>
					<div class="card card-primary">
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
											<td><?php echo getStatus($retur->lunas, "pelunasan"); ?></td>
										</tr>
                                    <?php endforeach; ?>
									<tfoot>
									<tr>
										<th colspan="5" class="text-center ui-priority-primary">GRAND TOTAL</th>
										<th class="format-uang">Rp. <?php echo toRupiah($grand_total); ?></th>
										<th></th>
										<th class="format-uang">Rp. <?php echo toRupiah($total_potong); ?></th>
										<th></th>
									</tr>
									</tfoot>
                                    <?php else: ?>
										<tr>
											<td class="text-center text-info font-weight-bold" colspan="7">
												Tidak ada data.
											</td>
										</tr>
                                    <?php endif; ?>
									</tbody>
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