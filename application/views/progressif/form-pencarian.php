<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Progressif</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">Form Data Progressif</h2>
            <p class="section-lead">
                Silahkan isi form di bawah untuk mencari data progressif.
            </p>

            <form action="<?php echo base_url('data-progressif'); ?>" method="post">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">
                                        Masukkan NIK :
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="text" required name="nik" value="<?php echo set_value('nik'); ?>" class="form-control text-uppercase" placeholder="Nomor Induk Kependudukan" autocomplete="off">
                                        <?php echo form_error('nik'); ?>
                                    </div>
                                    <div class="col-sm-2">
                                        <button name="submit" class="btn btn-block btn-primary" type="submit">
                                            Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>