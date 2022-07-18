<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Retur Supplier</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title"><?php echo $button; ?> Retur Supplier</h2>
            <p class="section-lead">
                Silahkan isi form di bawah untuk menambahkan data retur supplier baru.
            </p>

            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="no_retur" class="col-sm-3 col-form-label">No. Retur</label>
                                    <div class="col-sm-9">
                                        <input type="text" required name="no_retur" value="<?php echo $no_retur; ?>" class="form-control text-uppercase" placeholder="Masukkan nomor Retur" autocomplete="off">
                                        <?php echo form_error('no_retur'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                                    <div class="col-sm-9">
                                        <input type="date" required name="tanggal" value="<?php echo $tanggal; ?>" class="form-control" placeholder="Tanggal" autocomplete="off">
                                        <?php echo form_error('tanggal'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="id_supplier" class="col-sm-3 col-form-label">Supplier</label>
                                    <div class="col-sm-9">
                                        <select class='form-control select2' name="id_supplier">
                                          <option selected disabled>-- Pilih Supplier --</option>
                                          <?php if(count($supplier)> 0):
                                            foreach($supplier as $supplier): ?>
                                            <option value="<?php echo $supplier->id_supplier; ?>" <?php echo ($supplier->id_supplier == $id_supplier) ?'selected':''?>><?php echo $supplier->nama_supplier; ?></option>
                                          <?php endforeach; endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="total" class="col-sm-3 col-form-label">Total</label>
                                    <div class="col-sm-9">
                                        <input type="text" autocomplete="off" onkeyup="formatRupiah(this)" required class="form-control" value="<?php echo toRupiah($total); ?>" name="total" id="total" placeholder="Total">
                                        <?php echo form_error('total'); ?>
                                    </div>
                                </div>
								<div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Upload Nota</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" name="file_retur">
                                         <?php
											if (isset($err_upload) && $err_upload !== '') {
												$errorMessage = $err_upload['error'];
												echo "<small class='form-text text-danger'>$errorMessage</small>";
											}
                                        ?>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <input type="hidden" name="id_retur_supplier" value="<?php echo $id_retur_supplier; ?>" />
                                    <button name="submit" class="btn btn-primary mr-1" type="submit"><?php echo $button ?></button>
                                    <a href="<?php echo base_url('retur-supplier'); ?>" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php if($id_retur_supplier !== ''):?>
						<div class="col-12 col-md-6 col-lg-6">
							<div class="card card-primary">
								<div class="card-header">
									<h4 class="card-title">Nota Supplier Saat ini</h4>
								</div>
								<div class="card-body">
									<?php if($file_retur != '' && file_exists(FCPATH . '/uploads/retur-supplier/' . $file_retur)):?>
										<iframe src="<?php echo base_url('uploads/retur-supplier/' . $file_retur); ?>" width="100%" height="360px">
										This browser does not support PDFs. Please download the PDF to view it:
									<?php else: ?>
										<h3 class="text-info">Tidak ada dokumen retur supplier</h3>
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
