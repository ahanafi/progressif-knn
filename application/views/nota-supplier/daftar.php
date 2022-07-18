<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Nota Supplier</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <div class='card'>
                <div class='card-header'>
                    <h4 class="section-title">Filter</h4>
                </div>
                <div class='card-body'>
                    <form action='' method='get'>
                        <div class='form-group row'>
                            <label class='col-sm-3 col-form-label'>
                                Nama Pelanggan
                            </label>
                            <div class='col-sm-9'>
                                <select class='form-control select2' name='pelanggan'>
                                    <option disabled selected>--Pilih Pelanggan--</option>
                                    <?php foreach ($pelanggan as $p): ?>
                                        <option <?php echo (isset($_GET['pelanggan']) && $_GET['pelanggan'] === $p->id_pelanggan) ? 'selected' : ''; ?> value="<?php echo $p->id_pelanggan; ?>"><?php echo $p->nama_pelanggan; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class='form-group row'>
                            <label class='col-sm-3 col-form-label'>
                                Supplier
                            </label>
                            <div class='col-sm-9'>
                                <select class='form-control select2' name="supplier">
                                    <option disabled selected>--Pilih Supplier--</option>
                                    <?php foreach ($supplier as $s): ?>
                                        <option <?php echo (isset($_GET['supplier']) && $_GET['supplier'] === $s->id_supplier) ? 'selected' : ''; ?> value="<?php echo $s->id_supplier; ?>"><?php echo $s->nama_supplier; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class='form-group row'>
                            <label class='col-sm-3 col-form-label'>
                                Bulan
                            </label>
                            <div class='col-sm-9'>
                                <select class='form-control select2' name="bulan">
                                    <option disabled selected>--Pilih Bulan--</option>
                                    <?php $no = 1;
                                    for ($i = 0; $i <= 11; $i++): ?>
                                        <option <?php echo (isset($_GET['bulan']) && $_GET['bulan'] === $index[$i]) ? 'selected' : ''; ?> value="<?php echo $index[$i]; ?>"><?php echo $bulan[$i]; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-3'>
                            </div>
                            <div class='col-sm-9'>
                                <button type="submit" class="btn btn-primary btn-icon icon-left">
                                    <i class="fa fa-eye"></i>
                                    Tampilkan
                                </button> &nbsp;
                                <?php if (isset($_GET['supplier']) || isset($_GET['pelanggan']) || isset($_GET['bulan'])): ?>
                                    <a href="<?php echo base_url('nota-supplier/daftar'); ?>" class="btn btn-icon icon-left btn-danger">
                                        <i class="fa fa-retweet"></i>
                                        <span>Reset Filter</span>
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo base_url('cetak/nota-supplier') . $get_parameter; ?>" class="btn btn-primary btn-icon icon-left" target='_blank'>
                                    <i class="fa fa-print"></i>
                                    Cetak
                                </a>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <table class="table table-striped table-md table-bordered" id='data-table' width='100%'>
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No Nota</th>
                                    <th>Tanggal</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Total</th>
                                    <th>Total HPP</th>
                                    <th>Supplier</th>
                                    <th class="text-center">Status</th>
                                    <th>Transfer</th>
                                    <th>Lunas</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (count($notasupplier) > 0): ?>
                                    <?php foreach ($notasupplier as $nota): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td>
                                                <?php if ($nota->file_nota != '' && file_exists(FCPATH . 'uploads/nota-supplier/' . $nota->file_nota)): ?>
                                                    <a href="#" onclick="showFileNota('<?php echo $nota->pdflink; ?>')" class="btn-link"><?php echo $nota->no_nota; ?></a>
                                                <?php else: ?>
                                                    <?php echo $nota->no_nota; ?>
                                                <?php endif; ?>
                                            </td>
                                             <td data-sort="<?php echo strtotime($nota->tanggal);  ?>"><?php echo IdFormatDate($nota->tanggal); ?></td>
                                            <td><?php echo $nota->nama_pelanggan; ?></td>
                                            <td class="format-uang"><?php echo toRupiah($nota->total); ?></td>
                                            <td class="format-uang"><?php echo toRupiah($nota->total_hpp); ?></td>
                                            <td><?php echo $nota->nama_supplier; ?></td>
                                            <td class="text-center"><?php echo getStatus($nota->status); ?></td>
                                            <td class="format-uang"><?php echo toRupiah($nota->bayar); ?></td>
                                            <td class="format-uang">
                                                <?php echo getStatus($nota->is_lunas, "pelunasan"); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="4" class="text-center font-weight-bold">GRAND TOTAL</th>
                                    <th class="format-uang"><?php echo toRupiah($grand_total); ?></th>
                                    <th class="format-uang"><?php echo toRupiah($grand_total_hpp); ?></th>
                                    <th></th>
                                    <th></th>
                                    <th class="format-uang"><?php echo toRupiah($total_bayar); ?></th>
                                    <th></th>
                                </tr>
                                </tfoot>
                            </table>
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
