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
			<h2 class="section-title">Tambah Pembayaran Hutang</h2>
			<p class="section-lead">
				Silahkan isi form di bawah untuk menambahkan Pembayaran Hutang baru.
			</p>

			<form action="<?php echo base_url('pembayaran-hutang/edit/' . $pembayaran->id_pembayaran_hutang); ?>" method="post">
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
										<input type="date" required name="tanggal" value="<?php echo $pembayaran->tanggal; ?>" class="form-control" maxlength="30" placeholder="Nomor Rekening" autocomplete="off">
                                        <?php echo form_error('tanggal'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputnama_rekening3" class="col-sm-2 col-form-label">Nama Supplier</label>
									<div class="col-sm-4">
										<select onchange="showNotaBySupplier(this)" name="id_supplier" id="id_supplier" required class="form-control form-control-sm select2">
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
										<select name="id_bank" required class="form-control select2">
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
										<select name="id_jenis_bayar" required class="form-control select2">
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
									<label for="" class="col-sm-2 col-form-label">Jumlah Transfer (Rp)</label>
									<div class="col-sm-4">
										<input type="text" required class="form-control form-money" name="jumlah" id="jumlah" placeholder="Jumlah" onkeyup="formatRupiah(this)" value="<?= toRupiah($pembayaran->jumlah); ?>" autocomplete="off">
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
										<button type="button" onclick="addRow(true)" id="btn-add-row" class="btn btn-sm btn-info ml-2">Tambah Baris</button>
									</div>
								</div>
								<div class="row" id="alokasi-dana">
									<table class="table table-bordered" id="table-form">
										<thead>
										<tr>
											<th class="text-center">Hapus</th>
											<th style="width: 160px;">No. Nota</th>
											<th style="width: 140px !important;">Tanggal</th>
											<th>Transfer</th>
											<th>Total Nota</th>
											<th>No. Retur</th>
											<th>Potong Retur</th>
											<th>Total Retur</th>
										</tr>
										</thead>
										<tbody id="list-item">

                                        <?php
                                        $totalBayar = 0;
                                        $totalPotong = 0;
                                        $totalNota = 0;
                                        $totalRetur = 0;
                                        $index = 1;
                                        foreach ($detail as $d):
                                            $totalBayar += $d->nominal_bayar;
                                            $totalPotong += $d->potongan_retur;
                                            $totalNota += $d->total_nota;
                                            $totalRetur += $d->total_retur;
                                            ?>
											<tr data-index="<?php echo $index; ?>" id="row-<?= $index; ?>" class="rows">
												<td class="text-center">
                                                    <?php if ($index > 1): ?>
														<small class="badge badge-danger" style="padding: .25em .4em;" data-toggle="tooltip" title="Hapus">
															<a href="#" onclick="removeItem(<?php echo $index; ?>)" class="text-white">
																<i class="fa fa-times"></i>
															</a>
														</small>
                                                    <?php else: ?>
														#
                                                    <?php endif; ?>
												</td>
												<td>
													<select onchange="getTotal(this, 'nota', <?= $index; ?>)" name="no_nota[]" class="form-control select2 no_nota_<?= $index; ?> list-nota">
														<option selected value="">-- Pilih Nota --</option>
                                                        <?php foreach ($nota_supplier as $nota): ?>
															<option <?php echo ($nota->no_nota == $d->no_nota) ? "selected" : ""; ?> value="<?php echo $nota->no_nota; ?>"><?php echo $nota->no_nota; ?></option>
                                                        <?php endforeach; ?>
													</select>
                                                    <?php echo form_error('no_nota[]'); ?>
												</td>
												<td>
													<input data-tanggal="0" width="120px" readonly type="date" name="tanggal_nota[]" value="<?php echo $d->tanggal; ?>" class="form-control tanggal-nota tanggal_nota_1" autocomplete="off">
                                                    <?php echo form_error('tanggal_nota[]'); ?>
												</td>
												<td>
													<input onkeyup="hitungTotalBayar()" type="text" class="form-control form-money nominal-bayar bayar_<?= $index; ?>" value="<?php echo toRupiah($d->nominal_bayar); ?>" name="bayar[]" autocomplete="off">
                                                    <?php echo form_error('bayar[]'); ?>
												</td>
												<td>
													<input type="text" data-total-nota="0" readonly class="form-control form-money total-per-nota total_nota_<?= $index; ?>" value="<?php echo toRupiah($totalNota); ?>" name="total_nota[]" autocomplete="off">
												</td>
												<td>
													<select name="no_retur[]" onchange="getTotal(this, 'retur', <?= $index; ?>)" class="form-control list-retur no_retur_<?= $index; ?> select2">
														<option selected value="">-- Pilih No. Retur --</option>
                                                        <?php foreach ($retur_supplier as $retur): ?>
															<option <?php echo ($retur->no_retur == $d->no_retur) ? "selected" : ""; ?> value="<?php echo $retur->no_retur; ?>"><?php echo $retur->no_retur; ?></option>
                                                        <?php endforeach; ?>
													</select>
												</td>
												<td>
													<input type="text" onkeyup="hitungTotalPotongRetur()" value="<?php echo toRupiah($d->potongan_retur); ?>" class="form-control form-money nominal-potong-retur potong_retur_<?= $index; ?>" name="potong_retur[]" autocomplete="off">
												</td>
												<td>
													<input type="text" readonly class="form-control form-money total-per-retur total_retur_<?= $index; ?>" name="total_retur[]" autocomplete="off" value="<?php echo toRupiah($totalRetur); ?>">
												</td>
											</tr>
                                            <?php
                                            $index++;
                                        endforeach; ?>
										</tbody>
										<tfoot>
										<tr>
											<td class="text-center font-weight-bold" colspan="3">GRAND TOTAL</td>
											<td id="total-bayar" class="form-money"><?php echo toRupiah($totalBayar); ?></td>
											<td id="total-nota" class="form-money"><?php echo toRupiah($totalNota); ?></td>
											<td></td>
											<td id="total-potong-retur" class="form-money"><?php echo toRupiah($totalPotong); ?></td>
											<td id="total-retur" class="form-money"><?php echo toRupiah($totalRetur); ?></td>
										</tr>
										</tfoot>
									</table>
								</div>
								<div class="form-group row mt-3">
									<label for="" class="col-sm-9 text-right col-form-label">Pot. Lain2 (Rp)</label>
									<div class="col-sm-3">
										<input type="number" class="form-control form-money" id="potongan-lainnya" name="potongan_lain_lain" placeholder="Potongan lain-lain" value="<?= ($pembayaran->potongan_lain_lain); ?>" autocomplete="off">
                                        <?php echo form_error('potongan_lain_lain'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-9 text-right col-form-label">Ket. Lain2</label>
									<div class="col-sm-3">
										<select name="id_keterangan" required class="form-control select2">
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
