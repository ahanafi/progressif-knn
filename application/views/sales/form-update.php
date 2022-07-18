<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Sales</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">Edit Sales</h2>
            <p class="section-lead">
                Silahkan isi form di bawah untuk memperbarui data Sales.
            </p>

            <form action="<?php echo base_url('sales/edit/' . $sales->id_sales); ?>" method="post">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">Nama Sales</label>
                                    <div class="col-sm-9">
                                        <input type="text" required name="nama_sales" value="<?php echo $sales->nama_sales; ?>" class="form-control" placeholder="Nama Sales" autocomplete="off">
                                        <?php echo form_error('nama_sales'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <textarea name="alamat" required cols="30" rows="3" class="form-control" placeholder="Alamat"><?php echo $sales->alamat; ?></textarea>
                                        <?php echo form_error('alamat'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">Kota</label>
                                    <div class="col-sm-9">
                                        <input type="text" required name="kota" value="<?php echo $sales->kota; ?>" class="form-control" placeholder="Kota" autocomplete="off">
                                        <?php echo form_error('kota'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Kontak</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control" name="kontak" id="inputPassword3" placeholder="Kontak" value="<?php echo $sales->kontak; ?>" autocomplete="off">
                                        <?php echo form_error('kontak'); ?>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button name="update" class="btn btn-primary mr-1" type="submit">Simpan Perubahan</button>
                                    <a href="<?php echo base_url('sales'); ?>" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>