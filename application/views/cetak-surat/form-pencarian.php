<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pencetakan Surat</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">Form Pencetakan Surat</h2>
            <p class="section-lead">
                Silahkan isi form di bawah untuk mencetak surat.
            </p>

            <form action="<?php echo base_url('pencetan-surat'); ?>" method="post">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">
                                        Masukkan NOPOL :
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="text" required name="nopol" value="<?php echo set_value('nopol'); ?>" class="form-control text-uppercase" placeholder="Nomor Polisi" autocomplete="off">
                                        <?php echo form_error('nopol'); ?>
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