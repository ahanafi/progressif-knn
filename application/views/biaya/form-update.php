<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Biaya</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">Tambah Biaya</h2>
            <p class="section-lead">
                Silahkan isi form di bawah untuk menambahkan akun pengguna baru.
            </p>

            <form action="<?php echo base_url('biaya/edit/' . $biaya->id_biaya); ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-8">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                                    <div class="col-sm-9">
                                        <input type="date" required name="tanggal" value="<?php echo $biaya->tanggal; ?>" class="form-control" placeholder="Tanggal" autocomplete="off">
                                        <?php echo form_error('tanggal'); ?>
                                    </div>
                                </div>
								<div class="form-group row">
									<label for="tanggal" class="col-sm-3 col-form-label">Kode Transaksi</label>
									<div class="col-sm-9">
										<input type="text" required name="kode_transaksi" value="<?php echo $biaya->kode_transaksi; ?>" class="form-control text-uppercase" placeholder="Kode transaksi" autocomplete="off">
                                        <?php echo form_error('kode_transaksi'); ?>
									</div>
								</div>
								<div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <textarea name="keterangan" required cols="30" rows="3" class="form-control" placeholder="Keterangan"><?php echo $biaya->keterangan; ?></textarea>
                                        <?php echo form_error('keterangan'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
									<label for="jenis_biaya" class="col-sm-3 col-form-label">Jenis Biaya</label>
									<div class="col-sm-9">
										<select name="jenis_biaya" required class="form-control">
											<option disabled selected>-- Pilih Jenis --</option>
											<option <?= ($biaya->jenis_biaya == 'MASUK') ? 'selected' : ''; ?> value="MASUK">MASUK</option>
											<option <?= ($biaya->jenis_biaya == 'KELUAR') ? 'selected' : ''; ?> value="KELUAR">KELUAR</option>
										</select>
                                        <?php echo form_error('jenis_biaya'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="nominal" class="col-sm-3 col-form-label">Jumlah nominal</label>
									<div class="col-sm-9">
										<input type="text" onkeyup="formatRupiah(this)" name="nominal" value="<?php echo toRupiah($biaya->nominal); ?>" class="form-control" maxlength="30" placeholder="Masukan nominal" autocomplete="off">
                                        <?php echo form_error('nominal'); ?>
									</div>
								</div>
								<div class="form-group row">
									<label for="oleh" class="col-sm-3 col-form-label">Oleh</label>
									<div class="col-sm-9">
										<input type="text" required name="oleh" value="<?php echo $biaya->oleh; ?>" class="form-control" placeholder="Oleh" autocomplete="off">
                                        <?php echo form_error('oleh'); ?>
									</div>
								</div>
                                <div class="form-group row">
                                    <label for="saldo" class="col-sm-3 col-form-label">Slip Bukti</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="foto" class="form-control" onchange="readURL(this)">
                                        <input type="hidden" name="foto_lama" value="<?=$biaya->foto?>" class="form-control">
                                        <?php
                                        if (isset($err_upload) && $err_upload !== '') {
                                            $errorMessage = $err_upload['error'];
                                            echo "<small class='form-text text-danger'>$errorMessage</small>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button name="update" class="btn btn-primary mr-1" type="submit">Simpan Perubahan</button>
                                    <a href="<?php echo base_url('biaya'); ?>" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-12 col-md-4 col-lg-4">
						<div class="card card-primary">
							<div class="card-body">
								<div class="alert alert-light mt-2 mb-0">
									<div class="alert-icon">

									</div>
									<div class="alert-body">
										<div class="alert-title"><i class="fa fa-info-circle"></i> Informasi</div>
										<ul class="pl-3 mb-0">
											<li>Format foto yang didukung : <i><b>JPG, PNG, JPEG</b></i></li>
											<li>Ukuran foto maskimal <b>2048 Kb (2 MB)</b></li>
											<li>Reolusi foto maksimal <b>1280x768</b> pixel</li>
										</ul>
									</div>
								</div>
								<div id="preview-img" class="mt-3">
									<h5 class="h5">Pratinjau Foto</h5>
									<hr>
									<img id="target-img" src="<?php echo ($biaya->foto !== '') ? base_url( 'uploads/bukti/' . $biaya->foto) : base_url('assets/img/no-image.jpg'); ?>" alt="" class="img img-fluid">
								</div>
							</div>
						</div>
					</div>
                </div>
            </form>
        </div>
    </section>
</div>
