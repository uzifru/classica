<?php
/* panggil file database.php untuk koneksi ke database */
require_once "config/database.php";
/* panggil file fungsi tambahan */
require_once "config/fungsi_tanggal.php";
require_once "config/fungsi_rupiah.php";

// fungsi untuk pengecekan status login user 
// jika user belum login, alihkan ke halaman login dan tampilkan message = 1
if (empty($_SESSION['username']) && empty($_SESSION['password'])){
	echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}
// jika user sudah login, maka jalankan perintah untuk pemanggilan file halaman konten
else {
	// jika halaman konten yang dipilih home, panggil file view home
	if ($_GET['module'] == 'home') {
		include "modules/beranda/view.php";
	}

	// jika halaman konten yang dipilih paket, panggil file view paket
	elseif ($_GET['module'] == 'paket') {
		include "modules/paket/view.php";
	}

	// jika halaman konten yang dipilih form paket, panggil file form paket
	elseif ($_GET['module'] == 'form_paket') {
		include "modules/paket/form.php";
	}
	// -----------------------------------------------------------------------------
	
	// jika halaman konten yang dipilih transaksi, panggil file view transaksi
	elseif ($_GET['module'] == 'transaksi') {
		include "modules/transaksi/view.php";
	}

	// jika halaman konten yang dipilih form transaksi, panggil file form transaksi
	elseif ($_GET['module'] == 'form_transaksi') {
		include "modules/transaksi/form.php";
	}
	// -----------------------------------------------------------------------------

	// jika halaman konten yang dipilih laporan, panggil file view laporan
	elseif ($_GET['module'] == 'laporan') {
		include "modules/laporan/view.php";
	}
	// -----------------------------------------------------------------------------
	elseif ($_GET['module'] == 'cetak') {
		include "modules/laporan/cetak.php";
	}
	// jika halaman konten yang dipilih user, panggil file view user
	elseif ($_GET['module'] == 'user') {
		include "modules/user/view.php";
	}

	// jika halaman konten yang dipilih form user, panggil file form user
	elseif ($_GET['module'] == 'form_user') {
		include "modules/user/form.php";
	}
	// -----------------------------------------------------------------------------

	// jika halaman konten yang dipilih password, panggil file view password
	elseif ($_GET['module'] == 'password') {
		include "modules/password/view.php";
	}
}
?>