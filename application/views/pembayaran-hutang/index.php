<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Pembayaran Hutang</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Data Pembayaran Hutang
            </h2>
            <p class="section-lead">Data Pembayaran Hutang</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-header-action">
                                <a href="<?php echo base_url('pembayaran-hutang/create'); ?>" class="btn btn-primary btn-icon icon-left float-right">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered dt-responsive nowrap" id="data-table" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Pembayaran</th>
                                        <th>Tanggal</th>
                                        <th>Nama Supplier</th>
                                        <th>Bank</th>
                                        <th>Jenis Bayar</th>
                                        <th>Jumlah</th>
                                        <th>Pot Lain2</th>
                                        <th>Status</th>
                                        <th>Saldo</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count($pembayaran_hutang) > 0): ?>
                                        <?php foreach ($pembayaran_hutang as $p): ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td>
                                                    <a href="<?php echo base_url('pembayaran-hutang/detail/' . $p->id_pembayaran_hutang); ?>" class="btn-link">
                                                        <?php echo $p->kode_pembayaran; ?>
                                                    </a>
                                                </td>
                                                <?php
                                                $myStrTime = strtotime($p->tanggal);
                                                $newDateFormat = date('d-m-Y', $myStrTime);
                                                ?>
                                                <td data-sort="<?php echo $myStrTime;  ?>"><?php echo IdFormatDate($p->tanggal); ?></td>
                                                <td><?php echo $p->nama_supplier; ?></td>
                                                <td><?php echo $p->nama_bank; ?></td>
                                                <td><?php echo $p->nama_jenis_bayar; ?></td>
                                                <td class="format-uang"><?php echo toRupiah($p->jumlah); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($p->potongan_lain_lain); ?></td>
                                                <td><?php echo getStatus($p->status); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($p->saldo); ?></td>
                                                <td class="text-center">
                                                    <?php if ($p->status != 1): ?>
                                                        <a href="<?php echo base_url('pembayaran-hutang/edit/' . $p->id_pembayaran_hutang); ?>" class="btn btn-light" data-toggle="tooltip" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-light" onclick="showConfirmDelete('pembayaran-hutang', <?php echo $p->id_pembayaran_hutang; ?>)" data-toggle="tooltip" title="Hapus">
                                                            <i class="fa fa-trash-alt"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <b><i><small>No action</small></i></b>

                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
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
