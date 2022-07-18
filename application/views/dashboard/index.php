<?php
defined('BASEPATH') or exit('No direct script access allowed');
//Nota supplier
$grandTotalHpp = 0;
$grandTotalReturSupplier = 0;
$grandTotalPembayaranSupplier = 0;

//Penjualan
$grandTotalPenjualan = 0;
$grandTotalReturPenjualan = 0;
$grandTotalPembayaranPenjualan = 0;
?>
<style>
    table tr td, table tr th {
        padding: .5rem !important;
        height: auto !important;
    }

    .filter-selection {
        width: 16rem !important;
        border-radius: 5px !important;
        padding: 4px 8px !important;
        height: auto !important;
        margin-left: 30px !important;
    }
</style>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Dashboard</h1>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="wizard-steps mb-4">
					<div class="wizard-step wizard-step-active">
						<div class="wizard-step-icon">
							<span class="bigger-text"><?php echo $total_pelanggan; ?></span>
						</div>
						<div class="wizard-step-label">Pelanggan</div>
					</div>
					<div class="wizard-step wizard-step-active bg-danger">
						<div class="wizard-step-icon">
							<span class="bigger-text"><?php echo $total_supplier; ?></span>
						</div>
						<div class="wizard-step-label">Supplier</div>
					</div>
					<div class="wizard-step wizard-step-active bg-info">
						<div class="wizard-step-icon">
							<span class="bigger-text"><?php echo $total_nota_penjualan; ?></span>
						</div>
						<div class="wizard-step-label">Nota Penjualan</div>
					</div>
					<div class="wizard-step wizard-step-success">
						<div class="wizard-step-icon">
							<span class="bigger-text"><?php echo $total_nota_supplier; ?></span>
						</div>
						<div class="wizard-step-label">Nota Supplier</div>
					</div>
					<div class="wizard-step wizard-step-active bg-warning">
						<div class="wizard-step-icon">
							<span class="bigger-text"><?php echo $total_retur_penjualan; ?></span>
						</div>
						<div class="wizard-step-label">Retur Penjualan</div>
					</div>
					<div class="wizard-step wizard-step-active bg-dark">
						<div class="wizard-step-icon">
							<span class="bigger-text"><?php echo $total_retur_supplier; ?></span>
						</div>
						<div class="wizard-step-label">Retur Supplier</div>
					</div>
				</div>
			</div>
		</div>
		<div class="section-body">
			<div class="row">
				<div class="col-lg-12 col-12">
					<div class="card card-primary" id="nota-supplier">
						<div class="card-header">
							<h3 class="text-uppercase text-primary" style="width: auto !important;">Nota Supplier</h3>
							<select onchange="filterNotaSupplier(this)" class="form-control form-control-sm filter-selection">
								<option value="" selected>ALL</option>
                                <?php foreach ($supplier as $sup): ?>
									<option <?php echo (isset($supplier_params) && $supplier_params == $sup->id_supplier) ? "selected" : ""; ?> value="<?php echo $sup->id_supplier; ?>"><?php echo strtoupper($sup->nama_supplier); ?></option>
                                <?php endforeach; ?>
							</select>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered table-striped mb-0" id="report-table">
									<thead>
									<tr>
										<th>Bulan</th>
										<th>Total HPP Supplier</th>
										<th>Total Retur Supplier</th>
										<th>Pembayaran</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<td>Hutang Lama</td>
										<td class="text-right font-italic">Rp. <?php echo toRupiah($hutang_lama); ?></td>
										<td colspan="2" class="bg-light"></td>
									</tr>
                                    <?php foreach ($nota_supplier as $ns) : ?>
										<tr>
											<td><?php echo strtoupper($ns->bulan); ?></td>
											<td class="text-right font-italic">Rp. <?php echo toRupiah($ns->total_hpp); ?></td>
											<td class="text-right font-italic">Rp. <?php echo toRupiah($ns->total_retur); ?></td>
											<td class="text-right font-italic">Rp. <?php echo toRupiah($ns->total_pembayaran); ?></td>
										</tr>
                                        <?php
                                        $grandTotalHpp += $ns->total_hpp;
                                        $grandTotalReturSupplier += $ns->total_retur;
                                        $grandTotalPembayaranSupplier += $ns->total_pembayaran;

                                    endforeach; ?>
									</tbody>
									<tfoot>
									<tr>
										<th>TOTAL</th>
										<th class="text-right font-italic">Rp. <?php echo toRupiah($grandTotalHpp + $hutang_lama); ?></th>
										<th class="text-right font-italic">Rp. <?php echo toRupiah($grandTotalReturSupplier); ?></th>
										<th class="text-right font-italic">Rp. <?php echo toRupiah($grandTotalPembayaranSupplier); ?></th>
									</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
					<div class="card card-primary" id="nota-penjualan">
						<div class="card-header">
							<h3 class="text-uppercase text-primary" style="width: auto !important;">Penjualan</h3>
							<select onchange="filterNotaSales(this)" class="form-control form-control-sm filter-selection">
								<option value="" selected>ALL</option>
                                <?php foreach ($sales as $s): ?>
									<option <?php echo (isset($sales_params) && $sales_params == $s->id_sales) ? "selected" : ""; ?> value="<?php echo $s->id_sales; ?>"><?php echo strtoupper($s->nama_sales); ?></option>
                                <?php endforeach; ?>
							</select>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered table-striped mb-0" id="report-table">
									<thead>
									<tr>
										<th>Bulan</th>
										<th>Total Penjualan</th>
										<th>Total Retur Penjualan</th>
										<th>Pembayaran</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<td>Piutang Lama</td>
										<td class="text-right font-italic">Rp. <?php echo toRupiah($piutang_lama); ?></td>
										<td colspan="2" class="bg-light"></td>
									</tr>
									</tr>
                                    <?php foreach ($penjualan as $pj) : ?>
										<tr>
											<td><?php echo strtoupper($pj->bulan); ?></td>
											<td class="text-right font-italic">Rp. <?php echo toRupiah($pj->total_penjualan); ?></td>
											<td class="text-right font-italic">Rp. <?php echo toRupiah($pj->total_retur); ?></td>
											<td class="text-right font-italic">Rp. <?php echo toRupiah($pj->total_pembayaran); ?></td>
										</tr>
                                        <?php
                                        $grandTotalPenjualan += $pj->total_penjualan;
                                        $grandTotalReturPenjualan += $pj->total_retur;
                                        $grandTotalPembayaranPenjualan += $pj->total_pembayaran;
                                    endforeach; ?>
									</tbody>
									<tfoot>
									<tr>
										<th>TOTAL</th>
										<th class="text-right font-italic">Rp. <?php echo toRupiah($grandTotalPenjualan + $piutang_lama); ?></th>
										<th class="text-right font-italic">Rp. <?php echo toRupiah($grandTotalReturPenjualan); ?></th>
										<th class="text-right font-italic">Rp. <?php echo toRupiah($grandTotalPembayaranPenjualan); ?></th>
									</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
