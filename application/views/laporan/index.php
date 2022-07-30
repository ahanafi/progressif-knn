<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Laporan</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 id="section-title" class="section-title">
                Laporan Data Wajib Pajak
            </h2>
            <p class="section-lead">Data Wajib Pajak</p>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-header-action">
                                <a href="#" onclick="saveAsPDF(this)"
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
                                        <th>NIK</th>
                                        <th>Nomor Polisi</th>
                                        <th>Nama Pemilik</th>
                                        <th>Alamat Pemilik</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count((array)$kendaraan) > 0): ?>
                                        <?php foreach ($kendaraan as $kd) : ?>
                                            <tr>
                                                <td><?php echo $kd->nik_pemilik ?></td>
                                                <td><?php echo strtoupper($kd->nomor_polisi) ?> </td>
                                                <td><?php echo strtoupper($kd->nama_pemilik) ?> </td>
                                                <td><?php echo strtoupper($kd->alamat_pemilik) ?> </td>
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

<script>
    const saveAsPDF = (el) => {
        const mainSidebar = document.querySelector('#main-sidebar');
        const sectionTitle =  document.querySelector('#section-title');

        window.onbeforeprint = (evt) => {
            el.style.display = 'none';
            el.style.visibility = 'hidden';

            mainSidebar.style.display = 'none';
            mainSidebar.style.visibility = 'hidden';

            sectionTitle.style.display = 'none';
            sectionTitle.style.visibility = 'hidden';

            button.style.display = 'none';
            button.style.visibility = 'hidden';
        }

        window.onafterprint = (evt) => {
            el.style.display = 'block';
            el.style.visibility = 'visible';

            mainSidebar.style.display = 'block';
            mainSidebar.style.visibility = 'visible';

            sectionTitle.style.display = 'block';
            sectionTitle.style.visibility = 'visible';

            button.style.display = 'block';
            button.style.visibility = 'visible';
        }

        window.print();
    }
</script>