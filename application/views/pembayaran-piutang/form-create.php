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
			<h1>Pembayaran Piutang</h1>
			<?php echo showBreadCrumb(); ?>
		</div>

		<div class="section-body">
			<h2 class="section-title">Tambah Pembayaran Piutang</h2>
			<p class="section-lead">
				Silahkan isi form di bawah untuk menambahkan Pembayaran Piutang baru.
			</p>

			<form action="<?php echo base_url('pembayaran-piutang/create'); ?>" method="post">
				<div class="row">
					<div class="col-12 col-md-12 col-lg-12">
						<div class="card card-primary">
							<div class="card-body">
								<div class="form-group row">
									<label for="inputnama_rekening3" class="col-sm-2 col-form-label">Kode Pembayaran</label>
									<div class="col-sm-4">
										<input type="text" required name="kode_pembayaran" readonly value="<?php echo $kode_pembayaran; ?>" class="form-control" placeholder="Kode Pemabayaran" autocomplete="off">
                                        <?php echo form_error('kode_pembayaran'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputnama_rekening3" class="col-sm-2 col-form-label">Tanggal</label>
									<div class="col-sm-4">
										<input type="date" required name="tanggal" value="<?php echo set_value('tanggal'); ?>" class="form-control" maxlength="30" placeholder="Nomor Rekening" autocomplete="off">
                                        <?php echo form_error('tanggal'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputnama_rekening3" class="col-sm-2 col-form-label">Nama Pelanggan</label>
									<div class="col-sm-4">
										<select onchange="showNotaByPelanggan(this)" name="id_pelanggan" required class="form-control form-control-sm select2" id="id_pelanggan">
											<option selected disabled>-- Pilih Pelanggan --</option>
                                            <?php foreach ($pelanggan as $p): ?>
												<option <?= (set_value('id_pelanggan') == $p->id_pelanggan) ? 'selected' : ''; ?> value="<?php echo $p->id_pelanggan; ?>"><?php echo strtoupper($p->nama_pelanggan); ?></option>
                                            <?php endforeach; ?>
										</select>
                                        <?php echo form_error('id_pelanggan'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputnama_rekening3" class="col-sm-2 col-form-label">Bank</label>
									<div class="col-sm-4">
										<select name="id_bank" required class="form-control select2">
											<option selected disabled>-- Pilih Bank --</option>
                                            <?php foreach ($bank as $b): ?>
												<option <?= (set_value('id_bank') == $b->id_bank) ? 'selected' : ''; ?> value="<?php echo $b->id_bank; ?>">
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
										<select name="id_jenis_bayar" required class="form-control select2">
											<option selected disabled>-- Pilih Jenis Bayar --</option>
                                            <?php foreach ($jenis_bayar as $b): ?>
												<option <?= (set_value('id_bank') == $b->id_jenis_bayar) ? 'selected' : ''; ?> value="<?php echo $b->id_jenis_bayar; ?>">
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
										<input type="text" class="form-control" name="no_giro_cek" placeholder="Nomor Giro/Cek" required>
                                        <?php echo form_error('no_giro_cek'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-2 col-form-label">Jumlah Transfer (Rp)</label>
									<div class="col-sm-4">
										<input type="text" id="jumlah" required class="form-control form-money" name="jumlah" placeholder="Jumlah" onkeyup="formatRupiah(this)" value="<?= set_value('jumlah') ?>" autocomplete="off">
                                        <?php echo form_error('jumlah'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-2 col-form-label">Sisa (Rp)</label>
									<div class="col-sm-4">
										<input type="text" required class="form-control form-money" id="sisa" readonly autocomplete="off">
									</div>
								</div>
								<div class="form-group row border-bottom border-dark pt-3 pb-1">
									<div class="col-sm-6" id="action-button">
										<label class="font-weight-bold text-uppercase" style="font-size: 1rem;">
											Alokasi Dana
										</label>
										<button type="button" onclick="addRow()" id="btn-add-row" class="btn btn-sm btn-info ml-2">Tambah Baris</button>
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
										<tbody id="list-item">
											<tr data-index="1">
												<td>
													<select onchange="getTotal(this, 'nota', 1)" name="no_nota[]" class="form-control no_nota_1 list-nota-penjualan select2">
														<option selected value="">-- Pilih Nota --</option>
													</select>
													<?php echo form_error('no_nota[]'); ?>
												</td>
												<td>
													<input width="120px" readonly type="date" name="tanggal_nota[]" class="form-control tanggal_nota_1" autocomplete="off">
													<?php echo form_error('tanggal_nota[]'); ?>
												</td>
												<td>
													<input onkeyup="hitungTotalBayar()" type="text" class="form-control form-money nominal-bayar bayar_1" name="bayar[]" autocomplete="off">
													<?php echo form_error('bayar[]'); ?>
												</td>
												<td>
													<input type="text" data-total-nota="0" readonly class="form-control form-money total-per-nota total_nota_1" name="total_nota[]" autocomplete="off">
												</td>
												<td>
													<select name="no_retur[]" onchange="getTotal(this, 'retur', 1)" class="form-control no_retur_1 list-retur-penjualan select2">
														<option selected value="">-- Pilih Retur --</option>
													</select>
												</td>
												<td>
													<input type="text" onkeyup="hitungTotalPotongRetur()" class="form-control form-money nominal-potong-retur potong_retur_1" name="potong_retur[]" autocomplete="off">
												</td>
												<td>
													<input type="text" readonly class="form-control form-money total-per-retur total_retur_1" name="total_retur[]" autocomplete="off">
												</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<td class="text-center font-weight-bold" colspan="2">GRAND TOTAL</td>
												<td class="form-money" id="total-bayar"></td>
												<td class="form-money" id="total-nota"></td>
												<td></td>
												<td class="form-money" id="total-potong-retur"></td>
												<td class="form-money" id="total-retur"></td>
											</tr>
										</tfoot>
									</table>
								</div>
								<div class="form-group row mt-3">
									<label for="" class="col-sm-9 text-right col-form-label">Pot. Lain2 (Rp)</label>
									<div class="col-sm-3">
										<input type="number" class="form-control form-money" id="potongan-lainnya" name="potongan_lain_lain" placeholder="Potongan lain-lain" value="<?= set_value('potongan_lain_lain') ?>" autocomplete="off">
                                        <?php echo form_error('potongan_lain_lain'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-9 text-right col-form-label">Ket. Lain2</label>
									<div class="col-sm-3">
										<select name="id_keterangan" required class="form-control select2">
											<option selected disabled>-- Pilih Keterangan --</option>
                                            <?php foreach ($keterangan as $k): ?>
												<option <?= (set_value('id_keterangan') == $k->id_keterangan) ? 'selected' : ''; ?> value="<?php echo $k->id_keterangan; ?>">
                                                    <?php echo strtoupper($k->nama_keterangan) . " - ($k->penjelasan)"; ?>
												</option>
                                            <?php endforeach; ?>
										</select>
                                        <?php echo form_error('id_keterangan'); ?>
									</div>
								</div>
								<div class="text-right">
									<button name="submit" id="btn-submit" disabled class="btn btn-primary mr-1" type="submit">Simpan Data</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
</div>