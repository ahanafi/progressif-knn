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
                                        <button name="cari" value="cari" class="btn btn-block btn-primary" type="submit">
                                            Cari
                                        </button>
                                    </div>
                                </div>
                                <br>

                                <?php if(isset($kendaraan) && $kendaraan !== null && $is_found): ?>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-md table-bordered dt-responsive nowrap w-100"
                                               id="mytable">
                                            <thead>
                                            <tr>
                                                <th>Nomor Polisi</th>
                                                <th>Nama Pemilik <br> Alamat Pemilik</th>
                                                <th>Merk <br> Type</th>
                                                <th>Tahun <br> Warna</th>
                                                <th>No. Rangka<br> No. Mesin</th>
                                                <th>Jenis</th>
                                                <th>Tanggal <br/> Daftar</th>
                                                <th>Tanggal <br/> Bayar</th>
                                                <th>Status</th>
                                                <th>CC</th>
                                                <th>Persentasi <br/> Progressif</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($kendaraan as $kd) : ?>
                                                    <tr>
                                                        <td><?php echo strtoupper($kd->nomor_polisi) ?> </td>
                                                        <td><?php echo strtoupper($kd->nama_pemilik) ?>
                                                            <br/> <?php echo strtoupper($kd->alamat_pemilik) ?> </td>
                                                        <td><?php echo strtoupper($kd->merk) ?>
                                                            <br/> <?php echo strtoupper($kd->tipe) ?> </td>
                                                        <td><?php echo strtoupper($kd->tahun) ?>
                                                            <br/> <?php echo strtoupper($kd->warna) ?> </td>
                                                        <td><?php echo strtoupper($kd->nomor_rangka) ?>
                                                            <br/> <?php echo strtoupper($kd->nomor_mesin) ?> </td>
                                                        <td><?php echo strtoupper($kd->jenis) ?> </td>
                                                        <td><?php echo strtoupper($kd->tanggal_daftar) ?> </td>
                                                        <td><?php echo strtoupper($kd->tanggal_bayar) ?> </td>
                                                        <td><?php echo strtoupper($kd->status) ?> </td>
                                                        <td><?php echo strtoupper($kd->cc) ?> </td>
                                                        <td><?php echo strtoupper($kd->persentase_progressif) ?> </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <?php if(isset($_POST['cari'])): ?>
                                        <div class="d-flex justify-content-center align-items-center py-3">
                                            <h4>Data tidak ditemukan. Silahkan lakukan pencarian kembali.</h4>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>