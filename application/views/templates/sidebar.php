<?php
defined('BASEPATH') or exit('No direct script access allowed');
$uri1 = $this->uri->segment(1);
$uri2 = $this->uri->segment(2);

$pembayaran_penjualan_submenu = [
    //'bank',
	'keterangan', 'jenis-bayar', 'daftar-bayar', 'uang-masuk',
    'pembayaran-piutang'
];
$pembayaran_penjualan = "";
if (in_array($uri1, $pembayaran_penjualan_submenu)) {
    $pembayaran_penjualan = "active ";
}

$getPengaturan = getData('pengaturan_aplikasi');
$pengaturan = null;
if ($getPengaturan) {
    $pengaturan = $getPengaturan[0];
}
$appName = "Progressif KNN";
if ($pengaturan !== null) {
    $appName = $pengaturan->app_name;
}
$bank_dan_rekening_koran = "";
if($uri1 == "bank" || $uri1 == "rekening-koran") {
	$bank_dan_rekening_koran = "active ";
}
?>
<div class="main-sidebar sidebar-style-2">
	<aside id="sidebar-wrapper">
		<div class="sidebar-brand border-bottom border-primary">
			<a class="text-primary" href="<?= base_url('dashboard'); ?>"><?php echo $appName; ?></a>
		</div>
		<div class="sidebar-brand sidebar-brand-sm">
			<a href="<?= base_url('dashboard'); ?>">
                <?php
                $splittedAppName = explode(" ", $appName);
                $shortAppName = $splittedAppName[0][0] . $splittedAppName[1][0];
                echo $shortAppName;
                ?>
			</a>
		</div>
		<ul class="sidebar-menu">
			<li class="dropdown <?= $uri1 == '' || $uri1 == 'dashboard' ? 'active' : ''; ?>">
				<a href="<?= base_url('dashboard'); ?>" class="nav-link">
					<i class="fas fa-fire"></i><span>Dashboard</span>
				</a>
			</li>
            <?php if (!showOnlyTo("4")): ?>
				<li class="dropdown <?= ($uri1 == 'pelanggan' || $uri1 == "sales") ? 'active' : ''; ?>">
					<a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-user-friends"></i>
						<span>Pelanggan</span>
					</a>
					<ul class="dropdown-menu">
                        <?php if (showOnlyTo("1|2")): ?>
							<li class="<?= ($uri1 == 'pelanggan' && $uri2 == '') ? 'active' : ''; ?>">
								<a class="nav-link" href="<?= base_url('pelanggan'); ?>">Daftar Pelanggan</a>
							</li>
                        <?php endif; ?>
						<li class="<?= ($uri1 == 'pelanggan' && $uri2 == 'piutang') ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('pelanggan/piutang'); ?>">Piutang Pelanggan</a>
						</li>
						<li class="<?= ($uri1 == 'sales') ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('sales'); ?>">Data Sales</a>
						</li>
					</ul>
				</li>
            <?php endif; ?>
            <?php if (!showOnlyTo("4")): ?>
				<li class="dropdown <?= $uri1 == 'supplier' ? 'active' : ''; ?>">
					<a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-user-tag"></i> <span>Supplier</span>
					</a>
					<ul class="dropdown-menu">
                        <?php if (showOnlyTo("1|2")): ?>
							<li class="<?= $uri1 == 'supplier' && $uri2 == '' ? 'active' : ''; ?>">
								<a class="nav-link" href="<?= base_url('supplier'); ?>">Daftar Supplier</a>
							</li>
                        <?php endif; ?>
						<li class="<?= $uri1 == 'supplier' && $uri2 == 'hutang' ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('supplier/hutang'); ?>">Hutang ke Supplier</a>
						</li>
					</ul>
				</li>
            <?php endif; ?>
            <?php if (!showOnlyTo("4")): ?>
				<li class="dropdown <?= $uri1 == 'nota-penjualan' ? 'active' : ''; ?>">
					<a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-sticky-note"></i>
						<span>Nota Penjualan</span>
					</a>
					<ul class="dropdown-menu">
                        <?php if (showOnlyTo("1|2")): ?>
							<li class="<?= ($uri1 == 'nota-penjualan' && ($uri2 == "create" || $uri2 == "index" || $uri2 == '') || $uri2 == "edit") ? 'active' : ''; ?>">
								<a class="nav-link" href="<?= base_url('nota-penjualan'); ?>">Tambah Nota Penjualan</a>
							</li>
                        <?php endif; ?>
						<li class="<?= ($uri1 == 'nota-penjualan' && $uri2 == 'daftar') ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('nota-penjualan/daftar'); ?>">Daftar Nota Penjualan</a>
						</li>
                        <?php if (showOnlyTo("1|3")): ?>
							<li class="<?= ($uri1 == 'nota-penjualan' && $uri2 == 'status') ? 'active' : ''; ?>">
								<a class="nav-link" href="<?= base_url('nota-penjualan/status'); ?>">
									Status Nota Penjualan
								</a>
							</li>
                        <?php endif; ?>
					</ul>
				</li>
            <?php endif; ?>
			<li class="dropdown <?= $uri1 == 'nota-supplier' ? 'active' : ''; ?>">
				<a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
					<i class="fas fa-sticky-note"></i>
					<span>Nota Supplier</span>
				</a>
				<ul class="dropdown-menu">
                    <?php if (showOnlyTo("1|4")): ?>
						<li class="<?= ($uri1 == 'nota-supplier' && ($uri2 == "" || $uri2 == "create" || $uri2 == "edit")) ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('nota-supplier'); ?>">Tambah Nota Supplier</a>
						</li>
                    <?php endif; ?>
					<li class="<?= ($uri1 == 'nota-supplier' && ($uri2 == 'daftar')) ? 'active' : ''; ?>">
						<a class="nav-link" href="<?= base_url('nota-supplier/daftar'); ?>">Daftar Nota Supplier</a>
					</li>
                    <?php if (showOnlyTo("1|2")): ?>
						<li class="<?= ($uri1 == 'nota-supplier' && $uri2 == 'status') ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('nota-supplier/status'); ?>">Status Nota Supplier</a>
						</li>
                    <?php endif; ?>
				</ul>
			</li>
            <?php if (!showOnlyTo("4")): ?>
				<li class="dropdown <?= $uri1 == 'retur-penjualan' ? 'active' : ''; ?>">
					<a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-exchange-alt"></i>
						<span>Retur Penjualan</span>
					</a>
					<ul class="dropdown-menu">
                        <?php if (showOnlyTo("1|2")): ?>
							<li class="<?= ($uri1 == 'retur-penjualan' && ($uri2 == 'index' || $uri2 == '' || $uri2 == "create")) ? 'active' : ''; ?>">
								<a class="nav-link" href="<?= base_url('retur-penjualan'); ?>">Tambah Retur Penjualan</a>
							</li>
                        <?php endif; ?>
						<li class="<?= ($uri1 == 'retur-penjualan' && $uri2 == "daftar") ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('retur-penjualan/daftar'); ?>">Daftar Retur Penjualan</a>
						</li>
                        <?php if (showOnlyTo("1|3")): ?>
							<li class="<?= ($uri1 == 'retur-penjualan' && $uri2 == 'status') ? 'active' : ''; ?>">
								<a class="nav-link" href="<?= base_url('retur-penjualan/status'); ?>">Status Retur Penjualan</a>
							</li>
                        <?php endif; ?>
					</ul>
				</li>
            <?php endif; ?>
			<li class="dropdown <?= ($uri1 == 'retur-supplier') ? 'active' : ''; ?>">
				<a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
					<i class="fas fa-exchange-alt"></i>
					<span>Retur Supplier</span>
				</a>
				<ul class="dropdown-menu">
                    <?php if (showOnlyTo("1|4")): ?>
						<li class="<?= ($uri1 == 'retur-supplier' && ($uri2 == "" || $uri2 == "create" || $uri2 == "update")) ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('retur-supplier'); ?>">Tambah Retur Supplier</a>
						</li>
                    <?php endif; ?>
					<li class="<?= ($uri1 == 'retur-supplier' && $uri2 == 'daftar') ? 'active' : ''; ?>">
						<a class="nav-link" href="<?= base_url('retur-supplier/daftar'); ?>">Daftar Retur Supplier</a>
					</li>
                    <?php if (showOnlyTo("1|2")): ?>
						<li class="<?= ($uri1 == 'retur-supplier' && $uri2 == 'status') ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('retur-supplier/status'); ?>">Status Retur Supplier</a>
						</li>
                    <?php endif; ?>
				</ul>
			</li>
            <?php if (!showOnlyTo("4")): ?>
				<li class="dropdown <?= $uri1 == 'biaya' ? 'active' : ''; ?>">
					<a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-dollar-sign"></i>
						<span>Biaya</span>
					</a>
					<ul class="dropdown-menu">
                        <?php if (showOnlyTo("1|2")): ?>
							<li class="<?= ($uri1 == 'biaya' && ($uri2 == "create" || $uri2 == '')) ? 'active' : ''; ?>">
								<a class="nav-link" href="<?= base_url('biaya'); ?>">Tambah Biaya</a>
							</li>
                        <?php endif; ?>
						<li class="<?= ($uri1 == 'biaya' && $uri2 == "daftar") ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('biaya/daftar'); ?>">Daftar Biaya</a>
						</li>
                        <?php if (showOnlyTo("1|3")): ?>
							<li class="<?= ($uri1 == 'biaya' && $uri2 == "status") ? 'active' : ''; ?>">
								<a class="nav-link" href="<?= base_url('biaya/status'); ?>">Status Biaya</a>
							</li>
                        <?php endif; ?>
					</ul>
				</li>
            <?php endif; ?>
			<li class="dropdown <?= $bank_dan_rekening_koran; ?>">
				<a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
					<i class="fas fa-book"></i>
					<span>Bank &amp; Rekening Koran</span>
				</a>
				<ul class="dropdown-menu">
					<li class="<?= ($uri1 == 'bank' && $uri2 != 'status') ? 'active' : ''; ?>">
						<a class="nav-link" href="<?= base_url('bank'); ?>">Daftar Bank</a>
					</li>
                    <li class="<?= ($uri1 == 'bank' && $uri2 == "status") ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?= base_url('bank/status'); ?>">Status Bank</a>
                    </li>
					<li class="<?= $uri1 == 'rekening-koran' ? 'active' : ''; ?>">
						<a class="nav-link" href="<?= base_url('rekening-koran'); ?>">Rekening Koran</a>
					</li>
				</ul>
			</li>
            <?php if (!showOnlyTo("4")): ?>
				<li class="dropdown <?= $pembayaran_penjualan; ?>">
					<a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-money-bill-wave"></i>
						<span>Pembayaran Penjualan</span>
					</a>
					<ul class="dropdown-menu">
                        <?php if (showOnlyTo("1|2")): ?>
							<li class="<?= $uri1 == 'keterangan' ? 'active' : ''; ?>">
								<a class="nav-link" href="<?= base_url('keterangan'); ?>">Daftar Keterangan</a>
							</li>
							<li class="<?= $uri1 == 'jenis-bayar' ? 'active' : ''; ?>">
								<a class="nav-link" href="<?= base_url('jenis-bayar'); ?>">Daftar Jenis Bayar</a>
							</li>
							<li class="<?= ($uri1 == 'pembayaran-piutang' && ($uri2 == '' || $uri2 == 'create' || $uri2 == 'edit' || $uri2 == 'detail')) ? 'active' : ''; ?>">
								<a class="nav-link" href="<?= base_url('pembayaran-piutang'); ?>">Pembayaran Piutang</a>
							</li>
                        <?php endif; ?>
						<li class="<?= ($uri1 == 'pembayaran-piutang' && $uri2 == 'daftar') ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('pembayaran-piutang/daftar'); ?>">Daftar Pemb. Piutang</a>
						</li>
                        <?php if (showOnlyTo("1|3")): ?>
							<li class="<?= ($uri1 == 'pembayaran-piutang' && $uri2 == 'status') ? 'active' : ''; ?>">
								<a class="nav-link" href="<?= base_url('pembayaran-piutang/status'); ?>">Status Pemb. Piutang</a>
							</li>
                        <?php endif; ?>
					</ul>
				</li>
            <?php endif; ?>
            <?php if (!showOnlyTo("4")): ?>
				<li class="dropdown <?= ($uri1 == 'pembayaran-hutang') ? 'active' : '' ?>">
					<a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-money-bill-wave-alt"></i> <span>Pembayaran ke Supplier</span>
					</a>
					<ul class="dropdown-menu">
                        <?php if (showOnlyTo("1|2")): ?>
							<li class="<?= ($uri1 == 'pembayaran-hutang' && ($uri2 == '' || $uri2 == 'create')) ? 'active' : ''; ?>">
								<a class="nav-link" href="<?= base_url('pembayaran-hutang'); ?>">Pembayaran Hutang</a>
							</li>
                        <?php endif; ?>
						<li class="<?= ($uri1 == 'pembayaran-hutang' && $uri2 == 'daftar') ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('pembayaran-hutang/daftar'); ?>">Daftar Pemb. Hutang</a>
						</li>
                        <?php if (showOnlyTo("1|3")): ?>
							<li class="<?= ($uri1 == 'pembayaran-hutang' && $uri2 == 'status') ? 'active' : ''; ?>">
								<a class="nav-link" href="<?= base_url('pembayaran-hutang/status'); ?>">Status Pemb. Hutang</a>
							</li>
                        <?php endif; ?>
					</ul>
				</li>
            <?php endif; ?>
			<li class="dropdown <?= ($uri1 == 'perhitungan') ? 'active' : '' ?>">
					<a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-wallet"></i> <span>Perhitungan</span>
					</a>
					<ul class="dropdown-menu">
						<li class="<?= ($uri1 == 'perhitungan' && $uri2 == 'komisi') ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('perhitungan/komisi'); ?>">Komisi</a>
						</li>
                        <li class="<?= ($uri1 == 'perhitungan' && $uri2 == 'cashback') ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('perhitungan/cashback'); ?>">Cashback</a>
						</li>
					</ul>
				</li>
            <?php if (showOnlyTo("1")): ?>
				<li class="dropdown <?= $uri1 == 'user' ? 'active' : ''; ?>">
					<a href="<?= base_url('user'); ?>" class="nav-link">
						<i class="fas fa-user-alt"></i><span>Pengguna</span>
					</a>
				</li>
            <?php endif; ?>
            <?php if (showOnlyTo("1|2")): ?>
				<li class="dropdown <?= ($uri1 == 'profil-perusahaan' || $uri1 == 'pengaturan-aplikasi' || $uri1 == 'pengaturan') ? 'active' : '' ?>">
					<a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
						<i class="fas fa-cogs"></i> <span>Pengaturan</span>
					</a>
					<ul class="dropdown-menu">
						<li class="<?= ($uri1 == 'profil-perusahaan') ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('profil-perusahaan'); ?>">Profil Perusahaan</a>
						</li>
						<li class="<?= ($uri1 == 'pengaturan-aplikasi') ? 'active' : ''; ?>">
							<a class="nav-link" href="<?= base_url('pengaturan-aplikasi'); ?>">Pengaturan Aplikasi</a>
						</li>
					</ul>
				</li>
            <?php endif; ?>
		</ul>
		<div class="mt-0 mb-4 p-3 hide-sidebar-mini">
			<a href="#" onclick="showConfirmLogout()" class="btn btn-danger text-white btn-lg btn-block btn-icon-split">
				<i class="fas fa-power-off"></i> <span>Logout</span>
			</a>
		</div>
	</aside>
</div>
