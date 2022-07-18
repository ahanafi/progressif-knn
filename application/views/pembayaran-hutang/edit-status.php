<style>
    .form-group {
        margin-bottom: 10px !important;
    }

    td {
        padding: 10px !important;
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

    .form-money {
        text-align: right !important;
        font-style: italic !important;
    }
</style>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Pembayaran Hutang</h1>
            <?php echo showBreadCrumb(); ?>
		</div>

		<div class="section-body">
			<h2 class="section-title">Edit Pembayaran Hutang</h2>
			<p class="section-lead">
				Silahkan isi form di bawah untuk menambahkan Pembayaran Hutang baru.
			</p>

			<form action="<?php echo base_url('pembayaran-hutang/edit-status/' . $pembayaran->id_pembayaran_hutang); ?>" method="post">
				<div class="row">
					<div class="col-12 col-md-12 col-lg-12">
						<div class="card card-primary">
							<div class="card-body">
								<div class="form-group row">
									<label for="inputnama_rekening3" class="col-sm-2 col-form-label">Kode Pembayaran</label>
									<div class="col-sm-4">
										<input type="text" required name="kode_pembayaran" readonly value="<?php echo $pembayaran->kode_pembayaran; ?>" class="form-control" placeholder="Kode Pemabayaran" autocomplete="off">
                                        <?php echo form_error('kode_pembayaran'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputnama_rekening3" class="col-sm-2 col-form-label">Tanggal</label>
									<div class="col-sm-4">
										<input type="date" required name="tanggal" readonly value="<?php echo $pembayaran->tanggal; ?>" class="form-control" maxlength="30" placeholder="Nomor Rekening" autocomplete="off">
                                        <?php echo form_error('tanggal'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputnama_rekening3" class="col-sm-2 col-form-label">Nama Supplier</label>
									<div class="col-sm-4">
										<select onchange="showNotaBySupplier(this)" name="id_supplier" id="id_supplier" required class="form-control form-control-sm select2" disabled>
											<option selected disabled>-- Pilih Supplier --</option>
                                            <?php foreach ($supplier as $p): ?>
												<option <?= ($pembayaran->id_supplier == $p->id_supplier) ? 'selected' : ''; ?> value="<?php echo $p->id_supplier; ?>"><?php echo strtoupper($p->nama_supplier); ?></option>
                                            <?php endforeach; ?>
										</select>
                                        <?php echo form_error('id_supplier'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputnama_rekening3" class="col-sm-2 col-form-label">Bank</label>
									<div class="col-sm-4">
										<select name="id_bank" required class="form-control select2" disabled>
											<option selected disabled>-- Pilih Bank --</option>
                                            <?php foreach ($bank as $b): ?>
												<option <?= ($pembayaran->id_bank == $b->id_bank) ? 'selected' : ''; ?> value="<?php echo $b->id_bank; ?>">
                                                    <?php echo strtoupper($b->nama_bank) . " - " . strtoupper($b->nama_rekening); ?>
												</option>
                                            <?php endforeach; ?>
										</select>
                                        <?php echo form_error('id_bank'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputnama_rekening3" class="col-sm-2 col-form-label">Jenis Bayar</label>
									<div class="col-sm-4">
										<select name="id_jenis_bayar" required class="form-control select2" disabled>
											<option selected disabled>-- Pilih Jenis Bayar --</option>
                                            <?php foreach ($jenis_bayar as $b): ?>
												<option <?= ($pembayaran->id_bank == $b->id_jenis_bayar) ? 'selected' : ''; ?> value="<?php echo $b->id_jenis_bayar; ?>">
                                                    <?php echo strtoupper($b->nama_jenis_bayar); ?>
												</option>
                                            <?php endforeach; ?>
										</select>
                                        <?php echo form_error('id_jenis_bayar'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputnama_rekening3" class="col-sm-2 col-form-label">No. Giro/Cek</label>
									<div class="col-sm-4">
										<input type="text" required class="form-control" name="no_giro_cek" placeholder="Nomor Giro/Cek" value="<?= $pembayaran->no_giro_cek ?>" autocomplete="off">
                                        <?php echo form_error('no_giro_cek'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputnama_rekening3" class="col-sm-2 col-form-label">Saldo</label>
									<div class="col-sm-4">
										<input type="text" oninput="formatRupiah(this)" name="saldo" value="<?php echo $pembayaran->saldo; ?>" class="form-control format-uang">
                                        <?php echo form_error('saldo'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-2 col-form-label">Jumlah Transfer (Rp)</label>
									<div class="col-sm-4">
										<input type="text" required class="form-control form-money" name="jumlah" readonly id="jumlah" placeholder="Jumlah" onkeyup="formatRupiah(this)" value="<?= toRupiah($pembayaran->jumlah); ?>" autocomplete="off">
                                        <?php echo form_error('jumlah'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-2 col-form-label">Sisa (Rp)</label>
									<div class="col-sm-4">
										<input type="text" required class="form-control form-money" id="sisa" readonly autocomplete="off" value="0">
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
											<td class="format-uang"><?php echo toRupiah($d->nominal_bayar); ?></td>
											<td class="format-uang"><?php echo toRupiah($d->total_nota); ?></td>
                                            <?php if ($d->no_retur != '' || $d->no_retur != NULL): ?>
												<td><?php echo $d->no_retur; ?></td>
												<td class="format-uang"><?php echo toRupiah($d->potongan_retur); ?></td>
												<td class="format-uang"><?php echo toRupiah($d->total_retur); ?></td>
                                            <?php else: ?>
												<td>-</td>
												<td class="format-uang">0</td>
												<td class="format-uang">0</td>
                                            <?php endif; ?>
										</tr>
                                    <?php endforeach; ?>
									</tbody>
									<tfoot>
									<tr>
										<td class="text-center font-weight-bold" colspan="2">GRAND TOTAL</td>
										<td class="format-uang"><?php echo toRupiah($totalBayar); ?></td>
										<td class="format-uang"><?php echo toRupiah($totalNota); ?></td>
										<td></td>
										<td class="format-uang"><?php echo toRupiah($totalPotong); ?></td>
										<td class="format-uang"><?php echo toRupiah($totalRetur); ?></td>
									</tr>
									</tfoot>
								</table>
							</div>
								<div class="form-group row mt-3">
									<label for="" class="col-sm-9 text-right col-form-label">Pot. Lain2 (Rp)</label>
									<div class="col-sm-3">
										<input type="number" class="form-control form-money" readonly id="potongan-lainnya" name="potongan_lain_lain" placeholder="Potongan lain-lain" value="<?= toRupiah($pembayaran->potongan_lain_lain); ?>" autocomplete="off">
                                        <?php echo form_error('potongan_lain_lain'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-9 text-right col-form-label">Ket. Lain2</label>
									<div class="col-sm-3">
										<select name="id_keterangan" required class="form-control select2" disabled>
											<option selected disabled>-- Pilih Keterangan --</option>
                                            <?php foreach ($keterangan as $k): ?>
												<option <?= ($pembayaran->id_keterangan == $k->id_keterangan) ? 'selected' : ''; ?> value="<?php echo $k->id_keterangan; ?>">
                                                    <?php echo strtoupper($k->nama_keterangan) . " - ($k->penjelasan)"; ?>
												</option>
                                            <?php endforeach; ?>
										</select>
                                        <?php echo form_error('id_keterangan'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-9 text-right col-form-label">Status</label>
									<div class="col-sm-3">
										<select name="status" required class="form-control select2">
											<option selected disabled>-- Pilih Status --</option>
											<option value="1">DITERIMA</option>
											<option value="0">BATAL</option>
										</select>
                                        <?php echo form_error('status'); ?>
									</div>
								</div>
								<div class="text-right">
									<button name="update" disabled class="btn btn-primary mr-1" id="btn-submit" type="submit">Simpan Perubahan</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
</div>
