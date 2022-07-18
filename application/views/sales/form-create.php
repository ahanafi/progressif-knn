<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Sales</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">Tambah Sales</h2>
            <p class="section-lead">
                Silahkan isi form di bawah untuk menambahkan data Sales baru.
            </p>

            <form action="<?php echo base_url('sales/create'); ?>" method="post">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">Nama Sales</label>
                                    <div class="col-sm-9">
                                        <input type="text" required name="nama_sales" value="<?php echo set_value('nama_sales'); ?>" class="form-control text-uppercase" placeholder="Nama Sales" autocomplete="off">
                                        <?php echo form_error('nama_sales'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Alamat</label>
                                    <div class="col-sm-9">
                                        <textarea name="alamat" required cols="30" rows="3" class="form-control text-uppercase" placeholder="Alamat"><?php echo set_value('alamat'); ?></textarea>
                                        <?php echo form_error('alamat'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">Kota</label>
                                    <div class="col-sm-9">
                                        <input type="text" required name="kota" value="<?php echo set_value('kota'); ?>" class="form-control text-uppercase" placeholder="Kota" autocomplete="off">
                                        <?php echo form_error('kota'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Kontak</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control text-uppercase" value="<?php echo set_value('kontak'); ?>" name="kontak" id="inputPassword3" placeholder="Kontak" autocomplete="off">
                                        <?php echo form_error('kontak'); ?>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button name="submit" class="btn btn-primary mr-1" type="submit">Simpan Data
                                    </button>
                                    <button name="reset" class="btn btn-secondary" type="reset">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>