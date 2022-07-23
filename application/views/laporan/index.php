<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Laporan</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Laporan Data Wajib Pajak
            </h2>
            <p class="section-lead">Data Wajib Pajak</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-header-action">
                                <a href="<?php echo base_url('laporan/cetak'); ?>"
                                   class="btn btn-primary btn-icon icon-left float-right">
                                    <i class="fa fa-print"></i>
                                    Cetak
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
                                        <th>Nama Pemilik <br> Alamat Pemilik</th>
                                        <th>Merk <br> Type</th>
                                        <th>Tahun <br> Warna</th>
                                        <th>No. Rangka<br> No. Mesin</th>
                                        <th>Jenis</th>
                                        <th>Tanggal <br/> Daftar</th>
                                        <th>Tanggal <br/> Bayar</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count((array)$kendaraan) > 0): ?>
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
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="text-center" colspan="9">Tidak ada data</td>
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