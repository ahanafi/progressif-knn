
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Data Rekening Koran</h1>
            <?php echo showBreadCrumb(); ?>
		</div>

		<div class="section-body">
			<h2 class="section-title">Tambah Rekening Koran</h2>
			<p class="section-lead">
				Silahkan isi form di bawah untuk menambahkan rekening koran baru.
			</p>

			<form action="<?php echo base_url('rekening-koran/create?bank=' . $id_bank); ?>" method="post">
				<div class="row">
					<div class="col-12 col-md-6 col-lg-6">
						<div class="card card-primary">
							<div class="card-body">
								<div class="form-group row">
									<label for="tanggal" class="col-sm-3 col-form-label">Bank</label>
									<div class="col-sm-9">
										<select name="id_bank" required class="form-control">
											<option disabled selected>-- Pilih Nomor Rekening --</option>
											<?php foreach ($bank as $bank): ?>
												<option <?= (set_value('id_bank') == $bank->id_bank || ($id_bank == $bank->id_bank)) ? 'selected' : 'disabled'; ?> value="<?php echo $bank->id_bank; ?>"><?php echo $bank->nama_bank . " - ". $bank->no_rekening; ?></option>
											<?php endforeach; ?>
										</select>
										<?php echo form_error('id_bank'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
									<div class="col-sm-9">
										<input type="date" required name="tanggal" value="<?php echo set_value('tanggal'); ?>" class="form-control" placeholder="Tanggal" autocomplete="off">
                                        <?php echo form_error('tanggal'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="tanggal" class="col-sm-3 col-form-label">No. Bukti</label>
									<div class="col-sm-9">
										<input type="text" required name="no_bukti" value="<?php echo set_value('no_bukti'); ?>" class="form-control text-uppercase" placeholder="Nomor bukti" autocomplete="off">
                                        <?php echo form_error('no_bukti'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="inputPassword3" class="col-sm-3 col-form-label">Keterangan</label>
									<div class="col-sm-9">
										<textarea name="keterangan" required cols="30" rows="3" class="form-control text-uppercase" placeholder="Keterangan"><?php echo set_value('keterangan'); ?></textarea>
                                        <?php echo form_error('keterangan'); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-6">
						<div class="card card-primary">
							<div class="card-body">
								<div class="form-group row">
									<label for="jenis_biaya" class="col-sm-3 col-form-label">Jenis Biaya</label>
									<div class="col-sm-9">
										<select name="jenis_biaya" required class="form-control">
											<option disabled selected>-- Pilih Jenis --</option>
											<option <?= (set_value('jenis_biaya') == 'SALDO') ? 'selected' : ''; ?> value="SALDO">SALDO</option>
											<option <?= (set_value('jenis_biaya') == 'MASUK') ? 'selected' : ''; ?> value="MASUK">UANG MASUK</option>
											<option <?= (set_value('jenis_biaya') == 'KELUAR') ? 'selected' : ''; ?> value="KELUAR">UANG KELUAR</option>
										</select>
                                        <?php echo form_error('jenis_biaya'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="nominal" class="col-sm-3 col-form-label">Nominal</label>
									<div class="col-sm-9">
										<input type="text" onkeyup="formatRupiah(this)" name="nominal" value="<?php echo set_value('nominal'); ?>" class="form-control" maxlength="30" placeholder="Masukan nominal" autocomplete="off">
                                        <?php echo form_error('nominal'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="oleh" class="col-sm-3 col-form-label">Oleh</label>
									<div class="col-sm-9">
										<input type="text" required name="oleh" value="<?php echo set_value('oleh'); ?>" class="form-control text-uppercase" placeholder="Oleh" autocomplete="off">
                                        <?php echo form_error('oleh'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="tanggal" class="col-sm-3 col-form-label">Kode Pembayaran</label>
									<div class="col-sm-9">
										<input type="text" name="kode_pembayaran" value="<?php echo set_value('kode_pembayaran'); ?>" class="form-control text-uppercase" placeholder="Kode pembayaran" autocomplete="off" id="kode-pembayaran">
                                        <?php echo form_error('kode_pembayaran'); ?>
									</div>
								</div>
								<div class="text-right">
									<button name="submit" class="btn btn-primary mr-1" type="submit">Simpan Data</button>
									<a href="<?php echo base_url('rekening-koran'); ?>" class="btn btn-secondary">Kembali</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
</div>