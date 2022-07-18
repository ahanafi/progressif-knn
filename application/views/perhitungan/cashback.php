<?php
$jumlahTotalBayar = 0;
$totalCashback = 0;
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Cashback</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Data Cashback
            </h2>
            <p class="section-lead">Data Cashback</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-header-action">
                                <form action="" class="text-left">
                                    <div class="form-group row mb-0">
                                        <label for="" class="col-auto col-form-label">Filter Tgl. Uang Masuk</label>
                                        <div class="col-sm-2">
                                            <input type="date" class="form-control" required name="from" value="<?php echo $first_date; ?>">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="date" class="form-control" required name="to" value="<?php echo $last_date; ?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fa fa-eye"></i>
                                                <span>Tampilkan</span>
                                            </button>
                                            <a target="_blank" href="<?php echo base_url('cetak/cashback') . $get_parameter; ?>" class="btn btn-light">
                                                <i class="fa fa-print"></i>
                                                <span>Cetak</span>
                                            </a>
                                            <?php if (!empty(trim($first_date)) && !empty(trim($last_date))): ?>
                                                <a href="<?php echo base_url('perhitungan/cashback'); ?>" class="btn btn-danger">
                                                    <i class="fa fa-retweet"></i>
                                                    <span>Reset</span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table w-100 table-striped table-sm table-bordered dt-responsive nowrap" id="data-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Pembayaran</th>
                                        <th>Tgl. Uang Masuk</th>
                                        <th>Jumlah Transfer</th>
                                        <th>Nama Pelanggan</th>
                                        <th>No. Nota</th>
                                        <th>Tgl. Nota</th>
                                        <th>Jumlah Bayar</th>
                                        <th>Jumlah Hari</th>
                                        <th>Cashback</th>
                                        <th>Nominal Cashback</th>
                                    </tr>
                                    </thead>
                                    <?php if (count($pembayaran) > 0): ?>
                                        <?php foreach ($pembayaran as $p):

                                            $jumlahHari = $p->jumlah_hari;
                                            $persentase = 0;
                                            if ($jumlahHari >= 0 && $jumlahHari <= 7) {
                                                $persentase = 0.03;
                                            } elseif ($jumlahHari > 7 && $jumlahHari <= 30) {
                                                $persentase = 0.02;
                                            } elseif ($jumlahHari > 30 && $jumlahHari <= 60) {
                                                $persentase = 0.01;
                                            }

                                            $cashback = $persentase * (int)$p->jumlah_bayar;
                                            $nominalCashback = $cashback;
                                            $cashback = $persentase * 100;

                                            $jumlahTotalBayar += $p->jumlah_bayar;
                                            $totalCashback += $nominalCashback;

                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td><?php echo $p->kode_pembayaran; ?></td>
                                                 <td data-sort="<?php echo strtotime($p->tanggal_masuk);  ?>"><?php echo IdFormatDate($p->tanggal_masuk); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($p->jumlah_transfer); ?></td>
                                                <td><?php echo $p->nama_pelanggan; ?></td>
                                                <td><?php echo $p->no_nota; ?></td>
                                                <td data-sort="<?php echo strtotime($p->tanggal_nota); ?>"><?php echo IdFormatDate($p->tanggal_nota); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($p->jumlah_bayar); ?></td>
                                                <td class="text-center"><?php echo $p->jumlah_hari; ?></td>
                                                <td class="text-center"><?php echo $cashback . "%"; ?></td>
                                                <td class="format-uang"><?php echo toRupiah($nominalCashback); ?></td>
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
                                    <tfoot>
                                    <tr>
                                        <td colspan="7" class="text-center font-weight-bold">TOTAL</td>
                                        <td class="format-uang font-weight-bold"><?php echo toRupiah($jumlahTotalBayar); ?></td>
                                        <td colspan="2"></td>
                                        <td class="format-uang font-weight-bold"><?php echo toRupiah($totalCashback); ?></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>