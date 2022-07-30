<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div id="section-header" class="section-header">
            <h1>Pencetakan Surat</h1>
            <?php echo showBreadCrumb(); ?>
        </div>

        <div class="section-body">
            <h2 id="section-title" class="section-title">Form Pencetakan Surat</h2>
            <p id="section-lead" class="section-lead">
                Silahkan isi form di bawah untuk mencetak surat.
            </p>

            <form action="<?php echo base_url('pencetakan-surat'); ?>" method="post">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div id="card-form" class="card card-primary">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="inputnama_rekening3" class="col-sm-3 col-form-label">
                                        Masukkan NOPOL :
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="text" required name="nopol"
                                               value="<?php echo set_value('nopol'); ?>"
                                               class="form-control text-uppercase" placeholder="Nomor Polisi"
                                               autocomplete="off">
                                        <?php echo form_error('nopol'); ?>
                                    </div>
                                    <div class="col-sm-2">
                                        <button name="submit" class="btn btn-block btn-primary" type="submit">
                                            Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (isset($_POST['submit'])): ?>
                            <div class="card card-primary">
                                <div class="card-body">
                                    <table class="table table-striped table-md table-bordered dt-responsive nowrap w-100"
                                           id="mytable">
                                        <thead>
                                        <tr>
                                            <th>Ke</th>
                                            <th>Nomor Polisi</th>
                                            <th>
                                                NIK Pemilik <br>
                                                Nama Pemilik <br>
                                                Alamat Pemilik
                                            </th>
                                            <th>Merk <br> Type</th>
                                            <th>Tanggal <br/> Daftar</th>
                                            <th>Tanggal <br/> Bayar</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (count((array)$kendaraan) > 0): ?>
                                            <?php foreach ($kendaraan as $kd) : ?>
                                                <tr>
                                                    <td><?php echo $nomor++ ?></td>
                                                    <td><?php echo strtoupper($kd->nomor_polisi) ?> </td>
                                                    <td>
                                                        <?php echo strtoupper($kd->nik_pemilik) ?>
                                                        <br/> <?php echo strtoupper($kd->nama_pemilik) ?>
                                                        <br/> <?php echo strtoupper($kd->alamat_pemilik) ?>
                                                    </td>
                                                    <td><?php echo strtoupper($kd->merk) ?>
                                                        <br/> <?php echo strtoupper($kd->tipe) ?> </td>
                                                    <td><?php echo strtoupper($kd->tanggal_daftar) ?> </td>
                                                    <td><?php echo strtoupper($kd->tanggal_bayar) ?> </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php else: ?>
                                            <tr>
                                                <td class="text-center" colspan="10">Tidak ada data</td>
                                            </tr>
                                        <?php endif ?>
                                        </tbody>
                                    </table>
                                    <br>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary" type="button" onclick="saveAsPDF(this)">
                                            <i class="fa fa-print"></i>
                                            <span>Cetak</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
    const saveAsPDF = (el) => {
        const mainSidebar = document.querySelector('#main-sidebar');
        const sectionTitle = document.querySelector('#section-title');
        const sectionLead = document.querySelector('#section-lead');
        const cardForm = document.querySelector('#card-form');
        const headerH1 = document.querySelector('#section-header > h1');
        const breadCrumb = document.querySelector('.section-header-breadcrumb');

        window.onbeforeprint = (evt) => {
            el.style.display = 'none';
            el.style.visibility = 'hidden';

            mainSidebar.style.display = 'none';
            mainSidebar.style.visibility = 'hidden';

            cardForm.style.display = 'none';
            cardForm.style.visibility = 'hidden';

            sectionTitle.style.display = 'none';
            sectionTitle.style.visibility = 'hidden';

            sectionLead.style.display = 'none';
            sectionLead.style.visibility = 'hidden';

            breadCrumb.style.display = 'none';
            breadCrumb.style.visibility = 'hidden';

            headerH1.innerText = 'DATA KEPEMILIKAN KENDARAAN PAJAK PROGRESIF (CEK NOPOL)';
        }

        window.onafterprint = (evt) => {
            el.style.display = 'block';
            el.style.visibility = 'visible';

            mainSidebar.style.display = 'block';
            mainSidebar.style.visibility = 'visible';

            cardForm.style.display = 'block';
            cardForm.style.visibility = 'visible';

            sectionTitle.style.display = 'block';
            sectionTitle.style.visibility = 'visible';

            sectionLead.style.display = 'block';
            sectionLead.style.visibility = 'visible';

            breadCrumb.style.display = 'block';
            breadCrumb.style.visibility = 'visible';

            headerH1.innerText = 'Pencetakan Surat';
        }

        window.print();
    }
</script>