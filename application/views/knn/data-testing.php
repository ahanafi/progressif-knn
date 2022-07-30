<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data testing</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Daftar testing Saat Ini
            </h2>
            <p class="section-lead">Daftar data testing</p>

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
                                    Update Data Testing
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
                                    <?php if (count((array)$data_testing) > 0): ?>
                                        <?php foreach ($data_testing as $kd) : ?>
                                            <tr>
                                                <td><?php echo strtoupper($kd->nik) ?></td>
                                                <td><?php echo strtoupper($kd->nopol) ?> </td>
                                                <td><?php echo $kd->status_progresif === 1 ? 'Ya' : 'Tidak' ?> </td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-light"
                                                       onclick="showConfirmDelete('data_testing', '<?php echo $kd->id_data_testing ?>')"><i
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
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <form action="<?php echo base_url('data-testing/update'); ?>" id="form-logo" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Data Kendaraan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-0">
                    <div class="pr-2" style="height: 500px;overflow: scroll;">
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
                            <th>Status Progresif</th>
                            <th class="text-center">Pilih</th>
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
                                    <td><?php echo strtoupper($kd->status) ?> </td>
                                    <td class="text-center">
                                        <input
                                           type="checkbox"
                                           <?php echo ($kd->nopol !== null) ? 'checked' : '' ?>
                                           name="kendaraan[]"
                                           value="<?php echo $kd->id_kendaraan ?>" />
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
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" name="update" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>