<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Status Bank</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 class="section-title">
                Status Bank
            </h2>
            <p class="section-lead">Daftar status akun Bank</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-md table-bordered dt-responsive nowrap w-100" id="data-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Bank</th>
                                        <th>No. Rekening</th>
                                        <th>Nama Rekening</th>
                                        <th>Alamat</th>
                                        <th>Kontak</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count($banks) > 0): ?>
                                        <?php foreach ($banks as $bank): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $bank->nama_bank; ?></td>
                                                <td>
													<a href="<?php echo base_url('bank/status/'.$bank->id_bank); ?>">
														<?php echo $bank->no_rekening; ?>
													</a>
												</td>
                                                <td><?php echo $bank->nama_rekening; ?></td>
                                                <td><?php echo $bank->alamat; ?></td>
                                                <td><?php echo $bank->kontak; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="text-center text-info font-weight-bold" colspan="6">
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