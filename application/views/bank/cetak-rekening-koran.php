<?php
$totalCr = 0;
$totalDr = 0;
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
		font-size: 10px;
    }
    #content{
        margin:40px;

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

    #sub-header > table {
        width: auto !important;
		margin-left: 565px;
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
	.format-uang{
		text-align: right;
		font-style: italic;
	}

	#footer{
		padding-left: 50px;
	}
	.tbl{
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
				<td>NO. REKENING</td>
				<td>
                    <?php echo $bank->no_rekening; ?>
				</td>
			</tr>
		</table>
        <div class="clear"></div>
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
                    if(in_array(strtolower($rek->jenis_biaya), ["masuk", "saldo"])) {
                        $totalDr += $rek->nominal;
                        $totalBalance += $rek->nominal;
                    } else if(strtolower($rek->jenis_biaya) == "keluar") {
                        $totalCr += $rek->nominal;
                        $totalBalance -= $rek->nominal;
                    }

                    ?>
					<tr>
						<td class="text-center"><?php echo $no++; ?></td>
						<td><?php echo $rek->no_bukti; ?></td>
						<td><?php echo strtoupper($rek->keterangan); ?></td>
                        <?php if (strtolower($rek->jenis_biaya) == "keluar") : ?>
							<td class="format-uang">0</td>
							<td class="format-uang"><?php echo toRupiah($rek->nominal); ?></td>
                        <?php elseif (strtolower($rek->jenis_biaya) == "masuk" || strtolower($rek->jenis_biaya) == "saldo"): ?>
							<td class="format-uang"><?php echo toRupiah($rek->nominal); ?></td>
							<td class="format-uang">0</td>
                        <?php endif; ?>
						<td class="format-uang"><?php echo toRupiah($totalBalance); ?></td>
					</tr>
                <?php endforeach; ?>
				<tr>
					<td style="text-align: center" colspan="3"><b>GRAND TOTAL</b></td>
						<td class="format-uang"><?php echo toRupiah($totalDr); ?></td>
						<td class="format-uang"><?php echo toRupiah($totalCr); ?></td>
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
