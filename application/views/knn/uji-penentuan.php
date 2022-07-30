<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Uji Penentuan</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Data Testing</h4>
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
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count((array)$data_testing) > 0): ?>
                                        <?php foreach ($data_testing as $kd) : ?>
                                            <tr>
                                                <td><?php echo strtoupper($kd->nik) ?></td>
                                                <td><?php echo strtoupper($kd->nopol) ?> </td>
                                                <td><?php echo $kd->status_progresif === 1 ? 'Ya' : 'Tidak' ?> </td>
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

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Data Baru</h4>
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
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count((array)$data_baru) > 0): ?>
                                        <?php foreach ($data_baru as $kd) : ?>
                                            <tr>
                                                <td><?php echo strtoupper($kd->nik) ?></td>
                                                <td><?php echo strtoupper($kd->nopol) ?> </td>
                                                <td>( ? )</td>
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
                            <div class="d-flex justify-content-end align-items-center">
                                <form action="<?php echo base_url('uji-penentuan') ?>" method="post">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="" class="font-weight-bold">Input Nilai K :</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input value="<?php echo isset($k_value) && $k_value !== '' ? $k_value : '' ?>"
                                                   type="number" class="form-control" name="k" required>
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-block btn-primary" type="submit" name="uji">
                                                Uji Data
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php if (isset($_POST['uji'])): ?>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Euclidean Distance</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Ranking</th>
                                        <th>NIK</th>
                                        <th>Nopol</th>
                                        <th>Euclidean Distance</th>
                                        <th>Status Progresif</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $rank = 1;
                                    foreach ($results as $result):?>
                                        <tr>
                                            <td><?php echo $rank++; ?></td>
                                            <td><?php echo $result['nik']; ?></td>
                                            <td><?php echo $result['nopol']; ?></td>
                                            <td><?php echo $result['euclidean_distance']; ?></td>
                                            <td><?php echo $result['status'] === 1 ? 'Ya' : 'T'; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <div id="result" class="mt-5">
                                    <h3>K = <?php echo isset($k_value) && $k_value !== '' ? $k_value : '' ?></h3>
                                    <br>

                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Ranking</th>
                                            <th>NIK</th>
                                            <th>Nopol</th>
                                            <th>Euclidean Distance</th>
                                            <th>Status Progresif</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $rank = 1;
                                        foreach ($results as $result):
                                            if ($rank <= $k_value): ?>
                                                <tr>
                                                    <td><?php echo $rank++; ?></td>
                                                    <td><?php echo $result['nik']; ?></td>
                                                    <td><?php echo $result['nopol']; ?></td>
                                                    <td><?php echo $result['euclidean_distance']; ?></td>
                                                    <td><?php echo $result['status'] === 1 ? 'Ya' : 'T'; ?></td>
                                                </tr>
                                            <?php
                                            endif;
                                        endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </section>
</div>