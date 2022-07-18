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
		border:1px solid #333;
	}
	table tr th{
		border-collapse: collapse;
		border:1px solid #6777ef;
	}
	table tr td{
		border-collapse: collapse;
		border: 1px solid #333;
	}
	thead, thead tr th{
		background: #6777ef;
		color: #fff;
	}
</style>
<body>
<?php $this->load->view('templates/header-print'); ?>
<div class="sub-header">
	<h3>DATA SUPPLIER</h3>
</div>
<table class="table" border="0" cellpadding="5" cellspacing="0">
	<thead>
		<tr>
			<th>No.</th>
			<th>Nama Supplier</th>
			<th>Alamat</th>
			<th>Kota</th>
			<th>Kontak</th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($supplier) > 0): ?>
			<?php foreach ($supplier as $p): ?>
				<tr>
					<td class="text-center"><?php echo $no++; ?></td>
					<td><?php echo $p->nama_supplier; ?></td>
					<td><?php echo $p->alamat; ?></td>
					<td><?php echo $p->kota; ?></td>
					<td><?php echo $p->kontak; ?></td>
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
</body>
</html>
