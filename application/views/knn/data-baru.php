<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data baru</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <?php if(validation_errors()) : ?>
                            <h3 class="text-danger font-weight-bold" style="width: 300px;"><?php echo form_error('kendaraan[]') ?></h3>
                            <?php endif ?>
                            <div class="card-header-action">
                                <a href="#"
                                   data-toggle="modal" data-target="#form-upload-modal"
                                   class="btn btn-primary btn-icon icon-left float-right">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data Baru
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-md table-bordered dt-responsive nowrap w-100"
                                       id="mytable">
                                    <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nomor Polisi</th>
                                        <th>Status Progressif</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count((array)$data_baru) > 0): ?>
                                        <?php foreach ($data_baru as $kd) : ?>
                                            <tr>
                                                <td><?php echo strtoupper($kd->nik) ?></td>
                                                <td><?php echo strtoupper($kd->nopol) ?> </td>
                                                <td>(?)</td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-light"
                                                       onclick="showConfirmDelete('data_baru', '<?php echo $kd->id_data_baru ?>')"><i
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

<div class="modal fade" tabindex="-1" role="dialog" id="form-upload-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?php echo base_url('data-testing/data-baru'); ?>" id="form-logo" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Form Data Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="inputFile">Pilih Kendaraan yang akan dijadikan sebagai data baru</label>
                    <select name="id_kendaraan" id="" class="form-control" required>
                        <option selected disabled value="">-- Pilih Data --</option>
                        <?php foreach ($kendaraan as $kd): ?>
                            <option value="<?php echo $kd->id_kendaraan ?>">
                                <?php echo "(" . $kd->nomor_polisi . ") " . $kd->nama_pemilik . " | " . $kd->merk . " " . $kd->tipe ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <br>

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>