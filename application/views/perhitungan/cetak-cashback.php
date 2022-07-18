<?php
$jumlahTotalBayar = 0;
$totalCashback = 0;
?>
<!doctype html>
<html lang="en">
<head>
    <title>Cetak Pelanggan</title>
</head>
<style type="text/css">
    body {
        margin: 0;
        padding: 0;
        font-family: DejaVu Sans;
        font-size: 12px;
    }

    .align-middle {
        text-align: center;
        vertical-align: middle;
    }

    #header {
        margin-bottom: 30px;
        border-bottom: 2px solid #000;
        padding-bottom: 30px;
    }

    .text-center {
        text-align: center;
        vertical-align: middle;
    }

    .logo > img {
        width: 10%;
        position: fixed;
    }

    .kop-text {
        display: block;
        text-align: center;
    }

    h1, h2, h3, h4, h5, h6, p {
        margin: 0;
    }

    .sub-header {
        margin-bottom: 20px !important;
    }

    .sub-header > h3 {
        text-align: center;
        margin-bottom: 20px;
    }

    .box-ket table tr td:nth-child(1) {
        width: 120px;
    }

    .box-ket table tr td:nth-child(2) {
        width: 40px;
    }

    .text-center {
        text-align: center;
        vertical-align: middle;
    }

    .font-weight-bold {
        font-weight: bold !important;
    }

    table {
        width: 100%;
        border: 1px solid #333;
    }

    table tr {
        border: 1px solid #6777ef;
    }

    table tr th {
        border-collapse: collapse;
        border: 1px solid #fff;
    }

    table tr td {
        border-collapse: collapse;
        border: 1px solid #333;
    }

    thead, thead tr th {
        background: #6777ef;
        color: #fff;
    }

    .format-uang {
        text-align: right;
        font-style: italic;
    }
</style>
<body>
<?php $this->load->view('templates/header-print'); ?>
<div class="sub-header">
    <h3>DATA CASHBACK</h3>
</div>
<table class="table" border="0" cellpadding="5" cellspacing="0">
    <thead>
    <tr>
        <th>#</th>
        <th>Kode Pemb.</th>
        <th width="70px">Tgl. Uang Masuk</th>
        <th>Jml. Transfer</th>
        <th>Nama Pelanggan</th>
        <th>No. Nota</th>
        <th width="70px">Tgl. Nota</th>
        <th>Jml. Bayar</th>
        <th>Jml. Hari</th>
        <th width="30px">Cashback</th>
        <th>Nominal Cashback</th>
    </tr>
    </thead>
    <tbody>
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
                <td><?php echo IdFormatDate($p->tanggal_nota); ?></td>
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
</body>
</html>
