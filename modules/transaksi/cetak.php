<?php  
/* panggil file database.php untuk koneksi ke database */
require_once "../../config/database.php";
/* panggil file fungsi tambahan */
require_once "../../config/fungsi_tanggal.php";
require_once "../../config/fungsi_rupiah.php";

if (isset($_GET['id'])) {
    // fungsi query untuk menampilkan data dari tabel transaksi
    $query = mysqli_query($mysqli, "SELECT * FROM is_transaksi as a INNER JOIN is_paket as b
                                    ON a.paket=b.id_paket
                                    WHERE a.id_transaksi='$_GET[id]'") 
                                    or die('Ada kesalahan pada query tampil Transaksi : '.mysqli_error($mysqli));
    $data  = mysqli_fetch_assoc($query);

    $t_transaksi       = $data['tanggal'];
    $exp               = explode('-',$t_transaksi);
    $tanggal_transaksi = $exp[2]."-".$exp[1]."-".$exp[0];
}
?>
<!DOCTYPE html>
<html>
  	<head>
	    <meta charset="UTF-8">
	    <title>Struk | Classica</title>
	    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <meta name="description" content="Aplikasi Steam Mobil dan Motor">
	    <meta name="keywords" content="Indra Styawantoro" />

	    <!-- favicon -->
	    <link rel="shortcut icon" href="../../assets/img/favicon.png" />
  	</head>
	<body>
		<br>
		<table>
			<tr>
				<td colspan="3" align="center"><b>Classica Photo Studio</b></td>
			</tr>
			<tr>
				<td colspan="3" align="center">Jl. Bkr No.8 A, Kahuripan, Kec. Tawang <br>
				Kab. Tasikmalaya, Jawa Barat 46115</td>
			</tr>
			<tr>
				<td colspan="3">=================================</td>
			</tr>
			<tr>
				<td>ID Transaksi </td>
				<td>:</td>
				<td align="right"><?php echo $data['id_transaksi']; ?></td>
			</tr>
			<tr>
				<td>Tanggal </td>
				<td>:</td>
				<td align="right"><?php echo tgl_eng_to_ind($tanggal_transaksi); ?></td>
			</tr>
			<tr>
				<td colspan="3">=================================</td>
			</tr>
			<tr>
				<td>Pelanggan </td>
				<td>:</td>
				<td align="right"><?php echo $data['nama_pelanggan']; ?></td>
			</tr>
			<tr>
				<td>Nama Paket </td>
				<td>:</td>
				<td align="right"><?php echo $data['nama_paket']; ?></td>
			</tr>
			<tr>
				<td>Tambahan Orang </td>
				<td>:</td>
				<td align="right"><?php echo $data['tambahan_orang']; ?></td>
			</tr>
			<tr>
				<td colspan="3">=================================</td>
			</tr>
			<tr></tr>
			<tr></tr>
			<tr></tr>
			<tr>
				<td align="center" colspan="3"><b>Total : Rp. <?php echo format_rupiah($data['harga']); ?></b></td>
			</tr>
			<tr>
				<td colspan="3">=================================</td>
			</tr>
			<tr>
				<td align="center" colspan="3">Terima kasih</td>
			</tr>
		</table>
	</body>
</html>