<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Nota Penjualan</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">Tambah Nota Penjualan</h2>
            <p class="section-lead">
                Silahkan isi form di bawah untuk menambahkan nota penjualan baru.
            </p>

            <form action="<?php echo base_url('nota-penjualan/edit/' . $nota->id_nota_penjualan); ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">No. Nota</label>
                                    <div class="col-sm-9">
                                        <input type="text" required name="no_nota"
                                               value="<?php echo $nota->no_nota; ?>" class="form-control"
                                               placeholder="Nomor Nota" autocomplete="off">
                                        <?php echo form_error('no_nota'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">Tanggal</label>
                                    <div class="col-sm-9">
                                        <input type="date" required name="tanggal"
                                               value="<?php echo $nota->tanggal; ?>" class="form-control"
                                               maxlength="30" placeholder="Nomor Rekening" autocomplete="off">
                                        <?php echo form_error('tanggal'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">Pelanggan</label>
                                    <div class="col-sm-9">
                                        <select name="id_pelanggan" required class="form-control select2">
                                            <option selected disabled>-- Pilih Pelanggan --</option>
                                            <?php foreach ($pelanggan as $p): ?>
                                                <option <?= ($nota->id_pelanggan == $p->id_pelanggan) ? 'selected' : ''; ?> value="<?php echo $p->id_pelanggan; ?>"><?php echo strtoupper($p->nama_pelanggan); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php echo form_error('id_pelanggan'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">Sales</label>
                                    <div class="col-sm-9">
                                        <select name="id_sales" required class="form-control select2">
                                            <option selected disabled>-- Pilih Sales --</option>
                                            <?php foreach ($sales as $p): ?>
                                                <option <?= ($nota->id_sales == $p->id_sales) ? 'selected' : ''; ?> value="<?php echo $p->id_sales; ?>"><?php echo strtoupper($p->nama_sales); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php echo form_error('id_supplier'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Total (Rp)</label>
                                    <div class="col-sm-9">
                                        <input type="text" onkeyup="formatRupiah(this)" required class="form-control" name="total" id="inputPassword3" placeholder="Total" value="<?= toRupiah($nota->total) ?>" autocomplete="off">
                                        <?php echo form_error('total'); ?>
                                    </div>
                                </div>
								<div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Upload Nota</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" name="file_nota">
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
                                    <a href="<?= base_url('nota-penjualan') ?>" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-12 col-md-6 col-lg-6">
                        <div class="card card-primary">
							<div class="card-header">
								<h4 class="card-title">Nota Penjualan Saat ini</h4>
							</div>
                            <div class="card-body">
								<?php if($nota->file_nota != '' && file_exists(FCPATH . '/uploads/nota-penjualan/' . $nota->file_nota)):?>
									<iframe src="<?php echo base_url('uploads/nota-penjualan/' . $nota->file_nota); ?>" width="100%" height="360px">
									This browser does not support PDFs. Please download the PDF to view it:
								<?php else: ?>
									<h3 class="text-info">Tidak ada dokumen nota penjualan</h3>
								<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>