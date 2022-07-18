<?php
$getParameter = $get_parameter;
$index = 1;

$grandTotal = 0;
$totalBayar = 0;
?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Nota Penjualan</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Daftar Nota Penjualan
            </h2>
            <p class="section-lead">Daftar Nota Penjualan</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <?php if (showOnlyTo("1|2|3")): ?>
                        <div class="card card-primary mb-0" id="card-filter">
                            <div class="card-body pb-0">
                                <h6>Filter</h6>
                                <div class="row">
                                    <form action="" class="col-md-12">
                                        <div class="form-group row mb-1">
                                            <label for="" class="col-form-label-sm col-sm-2">Nama Pelanggan</label>
                                            <div class="col-sm-4">
                                                <select name="id_pelanggan" id="" class="form-control select2">
                                                    <option disabled selected>-- Pilih Pelanggan --</option>
                                                    <?php foreach ($pelanggan as $p): ?>
                                                        <option <?php echo (isset($_GET['id_pelanggan']) && $_GET['id_pelanggan'] === $p->id_pelanggan) ? 'selected' : ''; ?> value="<?php echo $p->id_pelanggan; ?>"><?php echo $p->nama_pelanggan; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label for="" class="col-form-label-sm col-sm-2">Nama Sales</label>
                                            <div class="col-sm-4">
                                                <select name="id_sales" id="" class="form-control select2">
                                                    <option disabled selected>-- Pilih Sales --</option>
                                                    <?php foreach ($sales as $s): ?>
                                                        <option <?php echo (isset($_GET['id_sales']) && $_GET['id_sales'] === $s->id_sales) ? 'selected' : ''; ?> value="<?php echo $s->id_sales; ?>"><?php echo $s->nama_sales; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-2">
                                            <label for="" class="col-form-label-sm col-sm-2">Bulan</label>
                                            <div class="col-sm-4">
                                                <select name="bulan" id="" class="form-control select2">
                                                    <option disabled selected>-- Pilih Bulan --</option>
                                                    <?php foreach ($bulan as $b): ?>
                                                        <option <?php echo (isset($_GET['bulan']) && $_GET['bulan'] == $index) ? 'selected' : ''; ?> value="<?php echo $index; ?>"><?php echo $b; ?></option>
                                                        <?php $index++; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-1">
                                            <div class="col-sm-4 offset-sm-2">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-eye"></i>
                                                    <span>Tampilkan</span>
                                                </button>
                                                <?php if (isset($_GET['id_sales']) || isset($_GET['id_pelanggan']) || isset($_GET['bulan'])): ?>
                                                    <a href="<?php echo base_url('nota-penjualan/daftar'); ?>" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-retweet"></i>
                                                        <span>Reset Filter</span>
                                                    </a>
                                                <?php endif; ?>
                                                <a target="_blank" href="<?php echo base_url('cetak/nota-penjualan') . $getParameter; ?>" class="btn btn-sm btn-secondary">
                                                    <i class="fa fa-print"></i>
                                                    <span>Cetak</span>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-md table-bordered dt-responsive nowrap w-100" id="data-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No. Nota</th>
                                        <th>Tanggal</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Sales</th>
                                        <th class="text-center">Total</th>
                                        <th>Status</th>
                                        <th>Bayar</th>
                                        <th>Lunas</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count($nota_penjualan) > 0): ?>
                                        <?php foreach ($nota_penjualan as $nota):
                                            $grandTotal += $nota->total;
                                            $totalBayar += $nota->bayar;
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <?php if ($nota->file_nota !== '' && file_exists(FCPATH . 'uploads/nota-penjualan/' . $nota->file_nota)): ?>
                                                        <a href="#" onclick="showFileNota('<?php echo $nota->pdflink; ?>')" class="btn-link"><?php echo $nota->no_nota; ?></a>
                                                    <?php else: ?>
                                                        <?php echo $nota->no_nota; ?>
                                                    <?php endif; ?>
                                                </td>
                                                 <td data-sort="<?php echo strtotime($nota->tanggal);  ?>"><?php echo IdFormatDate($nota->tanggal); ?></td>
                                                <td><?php echo $nota->nama_pelanggan; ?></td>
                                                <td><?php echo $nota->nama_sales; ?></td>
                                                <td class="format-uang"><?php echo toRupiah($nota->total); ?></td>
                                                <td><?php echo getStatus($nota->status); ?></td>
                                                <td class="format-uang"><?php echo toRupiah($nota->bayar); ?></td>
                                                <td style="font-weight:bold;text-align: center;">
                                                    <?php echo getStatus($nota->is_lunas, "pelunasan"); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="text-center text-info font-weight-bold" colspan="10">
                                                Tidak ada data.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-center font-weight-bold">GRAND TOTAL</th>
                                        <th class="format-uang"><?php echo toRupiah($grandTotal); ?></th>
                                        <th></th>
                                        <th class="format-uang"><?php echo toRupiah($totalBayar); ?></th>
                                        <th></th>
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
<div class="modal fade" id="preview-nota" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pratinjau Nota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="target-view" src="" width="100%" height="520px"></iframe>
            </div>
        </div>
    </div>
</div>