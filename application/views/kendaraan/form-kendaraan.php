<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Kendaraan</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">Tambah Kendaraan</h2>
            <p class="section-lead">
                Silahkan isi form di bawah untuk menambahkan data kendaraan baru.
            </p>

            <form action="<?php echo $url; ?>" method="post">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">Nomor Polisi</label>
                                    <div class="col-sm-9">
                                        <input type="text" required name="nomor_polisi" value="<?php echo $nomor_polisi ?>" class="form-control text-uppercase" placeholder="Nomor Polisi" autocomplete="off">
                                        <?php echo form_error('nomor_polisi'); ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">NIK pemilik</label>
                                    <div class="col-sm-9">
                                        <input type="text" required name="nik_pemilik" value="<?php echo $nik_pemilik ?>" class="form-control text-uppercase" placeholder="Nama Pemilik" autocomplete="off">
                                        <?php echo form_error('nik_pemilik'); ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">Nama pemilik</label>
                                    <div class="col-sm-9">
                                        <input type="text" required name="nama_pemilik" value="<?php echo $nama_pemilik ?>" class="form-control text-uppercase" placeholder="Nama Pemilik" autocomplete="off">
                                        <?php echo form_error('nama_pemilik'); ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Alamat Pemilik</label>
                                    <div class="col-sm-9">
                                        <textarea name="alamat_pemilik" required cols="30" rows="3" class="form-control text-uppercase" placeholder="Alamat Pemilik"><?php echo $alamat_pemilik ?></textarea>
                                        <?php echo form_error('alamat_pemilik'); ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">Merk</label>
                                    <div class="col-sm-9">
                                        <input type="text" required name="merk" value="<?php echo $merk ?>" class="form-control text-uppercase" placeholder="Merk" autocomplete="off">
                                        <?php echo form_error('merk'); ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Tipe</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control text-uppercase" value="<?php echo $tipe ?>" name="tipe" id="inputPassword3" placeholder="Tipe" autocomplete="off">
                                        <?php echo form_error('tipe'); ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">Tahun</label>
                                    <div class="col-sm-9">
                                        <input type="number" min="1990" maxlength="4" minlength="4" max="<?php echo date('Y') ?>" required name="tahun" value="<?php echo $tahun ?>" class="form-control text-uppercase" placeholder="Tahun" autocomplete="off">
                                        <?php echo form_error('tahun'); ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Warna</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control text-uppercase" value="<?php echo $warna ?>" name="warna" id="inputPassword3" placeholder="Warna" autocomplete="off">
                                        <?php echo form_error('warna'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card card-primary">
                            <div class="card-body">


                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">No. Rangka</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control text-uppercase" value="<?php echo $nomor_rangka ?>" name="nomor_rangka" id="inputPassword3" placeholder="No. Rangka" autocomplete="off">
                                        <?php echo form_error('nomor_rangka'); ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">No. Mesin</label>
                                    <div class="col-sm-9">
                                        <input type="text" required name="nomor_mesin" value="<?php echo $nomor_mesin ?>" class="form-control text-uppercase" placeholder="No. Mesin" autocomplete="off">
                                        <?php echo form_error('nomor_mesin'); ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Jenis</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control text-uppercase" value="<?php echo $jenis ?>" name="jenis" id="inputPassword3" placeholder="Jenis" autocomplete="off">
                                        <?php echo form_error('jenis'); ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">Tanggal Daftar</label>
                                    <div class="col-sm-9">
                                        <input type="date" required name="tanggal_daftar" value="<?php echo $tanggal_daftar ?>" class="form-control text-uppercase" placeholder="Tanggal Daftar" autocomplete="off">
                                        <?php echo form_error('tanggal_daftar'); ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">Tanggal Bayar</label>
                                    <div class="col-sm-9">
                                        <input type="date" required name="tanggal_bayar" value="<?php echo $tanggal_bayar ?>" class="form-control text-uppercase" placeholder="Tanggal Bayar" autocomplete="off">
                                        <?php echo form_error('tanggal_bayar'); ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Status Progresif</label>
                                    <div class="col-sm-9">
                                        <select name="status" required id="" class="form-control">
                                            <option value="" disabled selected>-- Pilih Status --</option>
                                            <option value="1">YA</option>
                                            <option value="0">TIDAK</option>
                                        </select>
                                        <?php echo form_error('status'); ?>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button name="<?php echo $action ?>" class="btn btn-primary mr-1" type="submit">Simpan Data
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