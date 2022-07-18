<style>
    .table-responsive {
        width: auto;
        overflow-x: scroll !important;
    }
</style>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Pembayaran Piutang</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Daftar Pembayaran Piutang
            </h2>
            <p class="section-lead">Daftar data Pembayaran Piutang</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table w-100 table-striped table-sm table-bordered dt-responsive nowrap" id="data-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Pembayaran</th>
                                        <th>Tanggal</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Bank</th>
                                        <th>Jenis Bayar</th>
                                        <th>Jumlah</th>
                                        <th>Pot Lain2</th>
                                        <th>Status</th>
                                        <th>Saldo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count($pembayaran_piutang) > 0): ?>
                                        <?php foreach ($pembayaran_piutang as $p): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <a href="<?php echo base_url('pembayaran-piutang/detail/'. $p->id_pembayaran_piutang); ?>" class="btn-link">
                                                        <?php echo $p->kode_pembayaran; ?>
                                                    </a>
                                                </td>
                                                 <?php
                                                    $myStrTime = strtotime($p->tanggal);
                                                    $newDateFormat = date('d-m-Y',$myStrTime);
                                                ?>
                                                <td data-sort="<?php echo $myStrTime;  ?>"><?php echo IdFormatDate($p->tanggal); ?></td>
                                                <td><?php echo $p->nama_pelanggan; ?></td>
                                                <td><?php echo $p->nama_bank; ?></td>
                                                <td><?php echo $p->nama_jenis_bayar; ?></td>
                                                <td class="format-uang"><?php echo toRupiah($p->jumlah); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($p->potongan_lain_lain); ?></td>
                                                <td><?php echo getStatus($p->status); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($p->saldo); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="text-center text-info font-weight-bold" colspan="11">
                                                Tidak ada data.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
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