<?php
$grand_total = 0;
$total_potong = 0;
?>
<!doctype html>
<html lang="en">
<head>
	<title>Cetak Retur Pelanggan</title>
</head>
<style type="text/css">
    body {
        margin: 0;
        padding: 0;
        font-family: DejaVu Sans;
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

    table tr th {
        border-collapse: collapse;
        border: 1px solid #6777ef;
    }

    table tr td {
        border-collapse: collapse;
        border: 1px solid #333;
    }

    thead, thead tr th {
        background: #6777ef;
        color: #fff;
    }
</style>
<body>
<?php $this->load->view('templates/header-print'); ?>
<div class="sub-header">
	<h3>DATA RETUR PENJUALAN</h3>
</div>
<table class="table" border="0" cellpadding="5" cellspacing="0">
	<thead>
	<tr>
		<th>No.</th>
		<th>No. Retur</th>
		<th>Tanggal</th>
		<th>Nama Pelanggan</th>
		<th>Total</th>
		<th>Status</th>
	</tr>
	</thead>
	<tbody>
    <?php if (count($retur_penjualan) > 0): ?>
    <?php foreach ($retur_penjualan as $p):
        $grand_total += $p->total;
        ?>
		<tr>
			<td class="text-center"><?php echo $no++; ?></td>
			<td><?php echo $p->no_retur; ?></td>
			 <?php
                                                    $myStrTime = strtotime($p->tanggal);
                                                    $newDateFormat = date('d-m-Y',$myStrTime);
                                                ?>
                                                <td data-sort="<?php echo $myStrTime;  ?>"><?php echo IdFormatDate($p->tanggal); ?></td>
			<td><?php echo $p->nama_pelanggan; ?></td>
			<td class="format-uang"><?php echo toRupiah($p->total); ?></td>
			<td class="text-center"><?php echo ($p->status == 1) ? "YES" : "NO"; ?></td>
		</tr>
    <?php endforeach; ?>
	<tfoot>
	<tr>
		<td class="text-center" colspan="4">TOTAL</td>
		<td class="format-uang"><?php echo toRupiah($grand_total); ?></td>
		<td class="text-center"></td>
	</tr>
	</tfoot>
    <?php else: ?>
		<tr>
			<td class="text-center text-info font-weight-bold" colspan="6">
				Tidak ada data.
			</td>
		</tr>
    <?php endif; ?>
	</tbody>
</table>
</body>
</html>
