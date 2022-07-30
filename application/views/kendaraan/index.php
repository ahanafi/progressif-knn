<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Kendaraan</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Daftar Kendaraan
            </h2>
            <p class="section-lead">Daftar data Kendaraan</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-header-action">
                                <a href="<?php echo base_url('data-kendaraan/create'); ?>"
                                   class="btn btn-primary btn-icon icon-left float-right">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-md table-bordered dt-responsive nowrap w-100"
                                       id="mytable">
                                    <thead>
                                    <tr>
                                        <th>Nomor Polisi</th>
                                        <th>
                                            NIK Pemilik <br>
                                            Nama Pemilik <br>
                                            Alamat Pemilik
                                        </th>
                                        <th>Merk <br> Type</th>
                                        <th>Tahun <br> Warna</th>
                                        <th>No. Rangka<br> No. Mesin</th>
                                        <th>Jenis</th>
                                        <th>Tanggal <br/> Daftar</th>
                                        <th>Tanggal <br/> Bayar</th>
                                        <th>Status</th>
                                        <?php if (showOnlyTo("1|2")): ?>
                                            <th class="text-center">Aksi</th>
                                        <?php endif; ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count((array)$kendaraan) > 0): ?>
                                        <?php foreach ($kendaraan as $kd) : ?>
                                            <tr>
                                                <td><?php echo strtoupper($kd->nomor_polisi) ?> </td>
                                                <td>
                                                    <?php echo strtoupper($kd->nik_pemilik) ?>
                                                    <br/> <?php echo strtoupper($kd->nama_pemilik) ?>
                                                    <br/> <?php echo strtoupper($kd->alamat_pemilik) ?>
                                                </td>
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
                                                <td class="text-center">
                                                    <a href="<?php echo base_url('data-kendaraan/edit/' . $kd->id_kendaraan); ?>"
                                                       class="btn btn-light"><i class="fa fa-edit"></i></a>
                                                    <a href="#" class="btn btn-light"
                                                       onclick="showConfirmDelete('kendaraan', '<?php echo $kd->id_kendaraan ?>')"><i
                                                                class="fa fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="text-center" colspan="10">Tidak ada data</td>
                                        </tr>
                                    <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>