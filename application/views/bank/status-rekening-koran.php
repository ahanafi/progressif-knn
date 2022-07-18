<?php
$saldo = 0;
$index = 1;
$second_uri = $this->uri->segment(2);
?>
<style type="text/css">
	.card-header-action {
        width: auto !important;
    }
    #table-detail  > tbody > tr > td:first-child{
		width: 12rem !important;
	}
</style>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Status Bank</h1>
            <?php echo showBreadCrumb(); ?>
		</div>

		<div class="section-body">
            <h2 class="section-title">
                Status Rekening Koran : <?php echo $bank->nama_bank . " - " . $bank->no_rekening; ?>
            </h2>
            <p class="section-lead">Status Rekening Koran</p>
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card card-primary">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-md table-bordered dt-responsive nowrap w-100" id="data-table" width='100%'>
									<thead>
									<tr>
										<th>#</th>
										<th>Tanggal</th>
										<th>No. Bukti</th>
										<th>Keterangan</th>
										<th>Jenis Biaya</th>
										<th>Jumlah</th>
										<th>Saldo</th>
										<th>Oleh</th>
										<th>Kode Pembayaran</th>
										<th>Status</th>
									</tr>
									</thead>
									<tbody>
                                    <?php if (count($rekening_koran) > 0): ?>
                                        <?php foreach ($rekening_koran as $rekening):
                                            $jenis = $rekening->jenis_biaya;
                                            if ($jenis === 'MASUK' || $jenis === 'SALDO') {
                                                $saldo += $rekening->nominal;
                                            } else {
                                                $saldo -= $rekening->nominal;
                                            }

                                            $nomorBukti = str_replace("=", "", base64_encode($rekening->no_bukti));
                                            $linkCetak = base_url('cetak/rekening-koran/' . $nomorBukti);
                                            ?>
											<tr>
												<td><?php echo $no++; ?></td>
												 <?php
                                                    $myStrTime = strtotime($rekening->tanggal);
                                                    $newDateFormat = date('d-m-Y',$myStrTime);
                                                ?>
                                                <td data-sort="<?php echo $myStrTime;  ?>"><?php echo IdFormatDate($rekening->tanggal); ?></td>
                                                <td>
                                                    <a href="<?php echo $linkCetak; ?>" class="btn-link" target="_blank">
                                                        <?php echo strtoupper($rekening->no_bukti); ?>
                                                    </a>
                                                </td>
												<td><?php echo $rekening->keterangan; ?></td>
												<td><?php echo "Biaya " . ucwords(strtolower($jenis)); ?></td>
												<td class="format-uang"><?php echo toRupiah($rekening->nominal); ?></td>
												<td class="format-uang"><?php echo toRupiah($saldo); ?></td>
												<td><?php echo $rekening->oleh; ?></td>
												<td><?php echo ($rekening->oleh == "0") ? "-" : strtoupper($rekening->kode_pembayaran); ?></td>
												<td class="text-center">
                                                    <?php if ($rekening->status == 0): ?>
                                                        <a href="<?php echo base_url('rekening-koran/ubah-status/' . $rekening->id_rekening_koran); ?>" class="badge badge-primary">
                                                            DITERIMA
                                                        </a>
                                                    <?php else: ?>
                                                        <?php echo getStatus($rekening->status); ?>
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