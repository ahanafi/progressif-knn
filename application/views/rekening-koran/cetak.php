<?php
$totalCrDr = 0;
$totalBalance = 0;
?>
<!doctype html>
<html lang="en">
<head>
	<title>Cetak Bukti</title>
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
        margin-bottom: 15px;
    }

    .text-center {
        text-align: center;
        vertical-align: middle;
    }

    h1, h2, h3, h4, h5, h6, p {
        margin: 0;
    }

    .text-center {
        text-align: center;
        vertical-align: middle;
    }

    .font-weight-bold {
        font-weight: bold !important;
    }

    #sub-header > table {
        width: auto !important;
        margin-left: 580px;
    }

    #sub-header > p > span {
        width: 100%;
        border-bottom: 3px dashed #000;
    }

    table {
        width: 100%;
        border: 1px solid #333;
    }

    table tr th, table tr td {
        border-collapse: collapse;
        border: 1px solid #333;
    }

    #table-data {
        margin-top: 15px;
    }

    .format-uang {
        text-align: right;
        font-style: italic;
    }

    #footer {
        padding-left: 50px;
    }

    .tbl {
        margin-bottom: 20px;
    }
</style>
<body>
<div id="content">
	<div id="header">
		<h1>REKENING KORAN</h1>
	</div>
	<div id="sub-header">
		<table border="1" cellspacing="0" cellpadding="3">
			<tr>
				<td>TGL</td>
				<td><?php echo getCurrentDate(); ?></td>
			</tr>
			<tr>
				<td>NO</td>
				<td>
                    <?php echo $detail->no_bukti; ?>
				</td>
			</tr>
		</table>
		<p style="width: 75%;border-bottom: 2px solid #000;">
			<span style="border-bottom: 2px solid #fff !important;">Dibayar kepada :</span>
            <?php echo $detail->oleh; ?>
		</p>
		<div id="table-data">
			<table class="table" cellpadding="3" cellspacing="0">
				<thead>
				<tr>
					<th rowspan="2">NO</th>
					<th rowspan="2">KODE TRANSAKSI</th>
					<th rowspan="2">KETERANGAN</th>
					<th colspan="2">JUMLAH</th>
					<th rowspan="2">BALANCE</th>
				</tr>
				<tr>
					<th>DR</th>
					<th>CR</th>
				</tr>
				</thead>
				<tbody>
                <?php foreach ($rekening as $rek):
                    $totalCrDr += $rek->nominal;
                    $totalBalance += $rek->nominal;
                    ?>
					<tr>
						<td><?php echo $no++; ?></td>
						<td><?php echo $rek->no_bukti; ?></td>
						<td><?php echo strtoupper($rek->keterangan); ?></td>
                        <?php if (strtolower($rek->jenis_biaya) == "keluar") : ?>
							<td class="format-uang">0</td>
							<td class="format-uang"><?php echo toRupiah($rek->nominal); ?></td>
                        <?php elseif (strtolower($rek->jenis_biaya) == "masuk" || strtolower($rek->jenis_biaya) == "saldo"): ?>
							<td class="format-uang"><?php echo toRupiah($rek->nominal); ?></td>
							<td class="format-uang">0</td>
                        <?php endif; ?>
						<td>-</td>
					</tr>
                <?php endforeach; ?>
				<tr>
					<td colspan="3">TOTAL</td>
                    <?php if (strtolower($detail->jenis_biaya) == "keluar") : ?>
						<td class="format-uang">0</td>
						<td class="format-uang"><?php echo toRupiah($totalCrDr); ?></td>
                    <?php elseif (strtolower($detail->jenis_biaya) == "masuk" || strtolower($detail->jenis_biaya) == "saldo"): ?>
						<td class="format-uang"><?php echo toRupiah($totalCrDr); ?></td>
						<td class="format-uang">0</td>
                    <?php endif; ?>
					<td class="format-uang"><?php echo toRupiah($totalBalance); ?></td>
				</tr>
				</tbody>
			</table>
			<br>
			<div id="footer">
				<p class="tbl">
					Terbilang :
                    <?php echo ucfirst(terbilang($totalBalance)) . " rupiah"; ?>
				</p>
				<div style="width: 60%;float: left;">
					<span style="padding-left: 50px;">Disiapkan oleh :</span>
					<br>
					<br>
					<br>
					<br>
					<br>
					(_____________________________)
				</div>
				<div style="width: 40%;float: left;">
					<span style="padding-left: 50px;">Disetujui oleh :</span>
					<br>
					<br>
					<br>
					<br>
					<br>
					(_____________________________)
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
