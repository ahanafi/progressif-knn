<style>
    .form-group {
        margin-bottom: 10px !important;
    }

    th, td {
        padding: 10px !important;
		height: auto !important;
    }

    .form-control {
        border-radius: 0 !important;
        padding: 5px 8px !important;
        height: auto !important;
    }

    #alokasi-dana {
        height: auto !important;
        max-height: 320px !important;
        overflow-x: scroll;
    }

    .display-currency {
        text-align: right;
        font-style: italic;
    }
</style>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Pembayaran Piutang</h1>
            <?php echo showBreadCrumb(); ?>
		</div>

		<div class="section-body">
			<h2 class="section-title">Tambah Pembayaran Piutang</h2>
			<p class="section-lead">
				Silahkan isi form di bawah untuk menambahkan Pembayaran Piutang baru.
			</p>

			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="card card-primary">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-12">

									<table class="table table-bordered">
										<tr>
											<td>Kode Pembayaran</td>
											<td>:</td>
											<td><?php echo $pembayaran->kode_pembayaran; ?></td>
										</tr>
										<tr>
											<td>Tanggal</td>
											<td>:</td>
											<td><?php echo IdFormatDate($pembayaran->tanggal); ?></td>
										</tr>
										<tr>
											<td>Nama Pelanggan</td>
											<td>:</td>
											<td><?php echo $pembayaran->nama_pelanggan; ?></td>
										</tr>
										<tr>
											<td>Bank</td>
											<td>:</td>
											<td><?php echo $pembayaran->nama_bank; ?></td>
										</tr>
										<tr>
											<td>Jenis Bayar</td>
											<td>:</td>
											<td><?php echo $pembayaran->nama_jenis_bayar; ?></td>
										</tr>
										<tr>
											<td>No. Giro/Cek</td>
											<td>:</td>
											<td><?php echo $pembayaran->no_giro_cek; ?></td>
										</tr>
										<tr>
											<td>Jumlah Transfer (Rp)</td>
											<td>:</td>
											<td class="display-currency"><?php echo toRupiah($pembayaran->jumlah); ?></td>
										</tr>
										<tr>
											<td>Potongan Lain-lain (Rp)</td>
											<td>:</td>
											<td class="display-currency"><?php echo toRupiah($pembayaran->potongan_lain_lain); ?></td>
										</tr>
										<tr>
											<td>Keterangan</td>
											<td>:</td>
											<td><?php echo $pembayaran->nama_keterangan; ?></td>
										</tr>
									</table>

								</div>
							</div>
							<div class="form-group row border-bottom border-dark pt-3 pb-1">
								<div class="col-sm-6" id="action-button">
									<label class="font-weight-bold text-uppercase" style="font-size: 1rem;">
										Alokasi Dana
									</label>
								</div>
							</div>
							<div class="row" id="alokasi-dana">
								<table class="table table-bordered">
									<thead>
									<tr>
										<th style="width: 160px;">No. Nota</th>
										<th style="width: 140px !important;">Tanggal</th>
										<th>Bayar</th>
										<th>Total Nota</th>
										<th>No. Retur</th>
										<th>Potong Retur</th>
										<th>Total Retur</th>
									</tr>
									</thead>
									<tbody>
                                    <?php
                                    $totalBayar = 0;
                                    $totalPotong = 0;
                                    $totalNota = 0;
                                    $totalRetur = 0;
                                    foreach ($detail as $d):
                                        $totalBayar += $d->nominal_bayar;
                                        $totalPotong += $d->potongan_retur;
                                        $totalNota += $d->total_nota;
                                        $totalRetur += $d->total_retur;
                                        ?>
										<tr>
											<td><?php echo $d->no_nota; ?></td>
											<td><?php echo IdFormatDate($d->tanggal); ?></td>
											<td class="display-currency"><?php echo toRupiah($d->nominal_bayar); ?></td>
											<td class="display-currency"><?php echo toRupiah($d->total_nota); ?></td>
                                            <?php if ($d->no_retur != '' || $d->no_retur != NULL): ?>
												<td><?php echo $d->no_retur; ?></td>
												<td class="display-currency"><?php echo toRupiah($d->potongan_retur); ?></td>
												<td class="display-currency"><?php echo toRupiah($d->total_retur); ?></td>
                                            <?php else: ?>
												<td>-</td>
												<td class="display-currency">0</td>
												<td class="display-currency">0</td>
                                            <?php endif; ?>
										</tr>
                                    <?php endforeach; ?>
									</tbody>
									<tfoot>
									<tr>
										<td class="text-center font-weight-bold" colspan="2">GRAND TOTAL</td>
										<td class="display-currency"><?php echo toRupiah($totalBayar); ?></td>
										<td class="display-currency"><?php echo toRupiah($totalNota); ?></td>
										<td></td>
										<td class="display-currency"><?php echo toRupiah($totalPotong); ?></td>
										<td class="display-currency"><?php echo toRupiah($totalRetur); ?></td>
									</tr>
									</tfoot>
								</table>
							</div>
							<div class="mt-3">
								<a href="#" onclick="window.history.back();" class="btn btn-primary">Kembali</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>