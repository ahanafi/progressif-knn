<style>
    .table-responsive {
        width: auto;
        overflow-x: scroll !important;
    }
</style>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Data Pembayaran Piutang</h1>
            <?php echo showBreadCrumb(); ?>
		</div>

		<div class="section-body">
			<h2 class="section-title">
				Status Pembayaran Piutang
			</h2>
			<p class="section-lead">Status Pembayaran Piutang</p>

			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card card-primary">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table w-100 table-striped table-sm table-bordered dt-responsive nowrap" id="data-table">
									<thead>
									<tr>
										<th>#</th>
                                        <th>Kode Pembayaran</th>
										<th>Tanggal</th>
										<th>Nama Pelanggan</th>
										<th>Bank</th>
										<th>Jenis Bayar</th>
										<th>Jumlah</th>
										<th>Pot Lain2</th>
										<th>Saldo</th>
										<th>Status</th>
										<th>Aksi</th>
									</tr>
									</thead>
									<tbody>
                                    <?php if (count($pembayaran_piutang) > 0): ?>
                                        <?php foreach ($pembayaran_piutang as $p): ?>
											<tr>
												<td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $p->kode_pembayaran; ?></td>
												 <?php
                                                    $myStrTime = strtotime($p->tanggal);
                                                    $newDateFormat = date('d-m-Y',$myStrTime);
                                                ?>
                                                <td data-sort="<?php echo $myStrTime;  ?>"><?php echo IdFormatDate($p->tanggal); ?></td>
												<td><?php echo $p->nama_pelanggan; ?></td>
												<td><?php echo $p->nama_bank; ?></td>
												<td><?php echo $p->nama_jenis_bayar; ?></td>
												<td class="format-uang"><?php echo toRupiah($p->jumlah); ?></td>
												<td class="format-uang"><?php echo toRupiah($p->potongan_lain_lain); ?></td>
												<td class="format-uang"><?php echo toRupiah($p->saldo); ?></td>
												<td class="text-center">
                                                    <?php if ($p->status == 0): ?>
														<a href="<?php echo base_url('pembayaran-piutang/ubah-status/' . $p->id_pembayaran_piutang); ?>" class="badge badge-primary">
															DITERIMA
														</a>
                                                    <?php else: ?>
														<b><i><small>YES</small></i></b>
                                                    <?php endif; ?>
												</td>
												<td class="text-center">
                                                    <?php if ($p->status != 1 && showOnlyTo("1|3")): ?>
														<a href="<?php echo base_url('pembayaran-piutang/detail/' . $p->id_pembayaran_piutang); ?>" class="btn btn-sm btn-light" data-toggle="tooltip" title="Detail">
															<i class="fa fa-eye"></i>
														</a>
														<a href="<?php echo base_url('pembayaran-piutang/edit-status/' . $p->id_pembayaran_piutang); ?>" class="btn btn-sm btn-light" data-toggle="tooltip" title="Edit">
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
											<td class="text-center text-info font-weight-bold" colspan="11">
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