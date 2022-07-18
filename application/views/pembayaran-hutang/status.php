<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Data Pembayaran Hutang</h1>
            <?php echo showBreadCrumb(); ?>
		</div>

		<div class="section-body">
			<h2 class="section-title">
				Status Pembayaran Hutang
			</h2>
			<p class="section-lead">Status data Pembayaran Hutang</p>

			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card card-primary">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-sm table-bordered dt-responsive nowrap" id="data-table">
									<thead>
									<tr>
										<th>#</th>
										<th>Kode Pembayaran</th>
										<th>Tanggal</th>
										<th>Nama Supplier</th>
										<th>Bank</th>
										<th>Jenis Bayar</th>
										<th>Jumlah</th>
										<th>Pot Lain2</th>
										<th>Saldo</th>
										<th class="text-center">Status</th>
										<th class="text-center">Aksi</th>
									</tr>
									</thead>
									<tbody>
                                    <?php if (count($pembayaran_hutang) > 0): ?>
                                        <?php foreach ($pembayaran_hutang as $p): ?>
											<tr>
												<td><?php echo $no++; ?></td>
												<td><?php echo $p->kode_pembayaran; ?></td>
												 <?php
                                                    $myStrTime = strtotime($p->tanggal);
                                                    $newDateFormat = date('d-m-Y',$myStrTime);
                                                ?>
                                                <td data-sort="<?php echo $myStrTime;  ?>"><?php echo IdFormatDate($p->tanggal); ?></td>
												<td><?php echo $p->nama_supplier; ?></td>
												<td><?php echo $p->nama_bank; ?></td>
												<td><?php echo $p->nama_jenis_bayar; ?></td>
												<td class="format-uang"><?php echo toRupiah($p->jumlah); ?></td>
												<td class="format-uang"><?php echo toRupiah($p->potongan_lain_lain); ?></td>
												<td class="format-uang"><?php echo toRupiah($p->saldo); ?></td>
												<td class="text-center">
                                                    <?php if ($p->status == 0): ?>
														<a href="<?php echo base_url('pembayaran-hutang/ubah-status/' . $p->id_pembayaran_hutang); ?>" class="badge badge-primary">
															DITERIMA
														</a>
                                                    <?php else: ?>
														<b><i><small>YES</small></i></b>
                                                    <?php endif; ?>
												</td>
												<td class="text-center">
                                                    <?php if ($p->status != 1 && showOnlyTo("1|3")): ?>
														<a href="<?php echo base_url('pembayaran-hutang/detail/' . $p->id_pembayaran_hutang); ?>" class="btn btn-sm btn-light" data-toggle="tooltip" title="Detail">
															<i class="fa fa-eye"></i>
														</a>
														<a href="<?php echo base_url('pembayaran-hutang/edit-status/' . $p->id_pembayaran_hutang); ?>" class="btn btn-sm btn-light" data-toggle="tooltip" title="Edit">
															<i class="fa fa-edit"></i>
														</a>
                                                    <?php else: ?>
														<b><i><small>No action</small></i></b>
                                                    <?php endif; ?>
												</td>
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
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
