<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Nota Supplier</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">Tambah Nota Supplier</h2>
            <p class="section-lead">
                Silahkan isi form di bawah untuk menambahkan nota supplier baru.
            </p>

            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">No. Nota</label>
                                    <div class="col-sm-9">
                                        <input type="text" required name="no_nota"
                                               value="<?php echo strtoupper($no_nota); ?>" class="form-control text-uppercase" placeholder="Masukkan nomor Nota" autocomplete="off">
                                        <?php echo form_error('no_nota'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">Tanggal</label>
                                    <div class="col-sm-9">
                                        <input type="date" required name="tanggal"
                                               value="<?php echo $tanggal; ?>" class="form-control"
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
                                                <option <?= ($id_pelanggan == $p->id_pelanggan) ? 'selected' : ''; ?> value="<?php echo $p->id_pelanggan; ?>"><?php echo strtoupper($p->nama_pelanggan); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php echo form_error('id_pelanggan'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">Supplier</label>
                                    <div class="col-sm-9">
                                        <select name="id_supplier" required class="form-control select2">
                                            <option selected disabled>-- Pilih Supplier --</option>
                                            <?php foreach ($supplier as $p): ?>
                                                <option <?= ($id_supplier == $p->id_supplier) ? 'selected' : ''; ?> value="<?php echo $p->id_supplier; ?>"><?php echo strtoupper($p->nama_supplier); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php echo form_error('id_supplier'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Total (Rp)</label>
                                    <div class="col-sm-9">
                                        <input type="text" onkeypress="formatRupiah(this)" required class="form-control" name="total" placeholder="Total" value="<?= $total ?>">
                                        <?php echo form_error('total'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Total HPP (Rp)</label>
                                    <div class="col-sm-9">
                                        <input type="text" onkeypress="formatRupiah(this)" required class="form-control" name="total_hpp" placeholder="Total" value="<?= $total ?>">
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
                                  <input type="hidden" name='id_nota_supplier' value="<?= $id_nota_supplier; ?>">
                                    <button name="submit" class="btn btn-primary mr-1" type="submit"><?=$button;?></button>
                                    <a href="<?php echo base_url('nota-supplier'); ?>" class="btn btn-secondary" type="reset">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php if($id_nota_supplier !== ''):?>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="card card-primary">
								<div class="card-header">
									<h4 class="card-title">Nota Supplier Saat ini</h4>
								</div>
								<div class="card-body">
									<?php if($file_nota != '' && file_exists(FCPATH . '/uploads/nota-supplier/' . $file_nota)):?>
										<iframe src="<?php echo base_url('uploads/nota-supplier/' . $file_nota); ?>" width="100%" height="360px">
										This browser does not support PDFs. Please download the PDF to view it:
									<?php else: ?>
										<h3 class="text-info">Tidak ada dokumen nota supplier</h3>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
                </div>
            </form>
        </div>
    </section>
</div>
