
<?php
session_start();
error_reporting(E_ALL^(E_NOTICE|E_WARNING));
ob_start();

// Panggil koneksi database.php untuk koneksi database
require_once "../../config/database.php";
// panggil fungsi untuk format tanggal
include "../../config/fungsi_tanggal.php";
// panggil fungsi untuk format rupiah
include "../../config/fungsi_rupiah.php";

$hari_ini = date("d-m-Y");
// ambil data hasil submit dari form
$tgl1     = $_GET['tgl_awal'];
$explode  = explode('-',$tgl1);
$tgl_awal = $explode[2]."-".$explode[1]."-".$explode[0];

$tgl2      = $_GET['tgl_akhir'];
$explode   = explode('-',$tgl2);
$tgl_akhir = $explode[2]."-".$explode[1]."-".$explode[0];

if (isset($_GET['tgl_awal'])) {
    $no    = 1;
    $total = 0;
    // fungsi query untuk menampilkan data dari tabel transaksi
    $query = mysqli_query($mysqli, "SELECT * FROM is_transaksi as a INNER JOIN is_paket as b
                                    ON a.paket=b.id_paket
                                    WHERE a.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
                                    ORDER BY a.id_transaksi ASC") 
                                    or die('Ada kesalahan pada query tampil Transaksi : '.mysqli_error($mysqli));
    $count  = mysqli_num_rows($query);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml"> <!-- Bagian halaman HTML yang akan konvert -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Rekap Data Transaksi</title>
        <link rel="stylesheet" type="text/css" href="../../assets/css/laporan.css" />
    </head>
    <body>
        <div id="title">
            REKAP DATA TRANSAKSI 
        </div>
    <?php  
    if ($tgl_awal==$tgl_akhir) { ?>
        <div id="title-tanggal">
            Tanggal <?php echo tgl_eng_to_ind($tgl1); ?>
        </div>
    <?php
    } else { ?>
        <div id="title-tanggal">
            Tanggal <?php echo tgl_eng_to_ind($tgl1); ?> s.d. <?php echo tgl_eng_to_ind($tgl2); ?>
        </div>
    <?php
    }
    ?>
        
        <hr><br>
        <div id="isi">
            <table width="100%" border="0.3" cellpadding="0" cellspacing="0">
                <thead style="background:#e8ecee">
                    <tr class="tr-title">
                        <th height="20" align="center" valign="middle">No.</th>
                        <th height="20" align="center" valign="middle">ID Transaksi</th>
                        <th height="20" align="center" valign="middle">Tanggal</th>
                        <th height="20" align="center" valign="middle">Nama Pelanggan</th>
                        <th height="20" align="center" valign="middle">Nama Paket</th>
                        <th height="20" align="center" valign="middle">Tambahan Orang</th>
                        <th height="20" align="center" valign="middle">Biaya</th>
                    </tr>
                </thead>
                <tbody>
<?php
    // jika data ada
    if($count == 0) {
        echo "  <tr>
                    <td width='40' height='13' align='center' valign='middle'></td>
                    <td width='150' height='13' align='center' valign='middle'></td>
                    <td width='150' height='13' align='center' valign='middle'></td>
                    <td width='150' height='13' align='center' valign='middle'></td>
                    <td width='150' height='13' align='center' valign='middle'></td>
                    <td style='padding-left:5px;' width='150' height='13' valign='middle'></td>
                    <td style='padding-right:5px;' width='150' height='13' align='right' valign='middle'></td>
                </tr>
                <tr>
                    <td height='15' colspan='6' align='left' valign='middle'><strong>  Total</strong></td>
                    <td style='padding-right:5px;' height='15' width='120' align='right' valign='middle'><strong></strong></td>
                </tr>";
    }
    // jika data tidak ada
    else {
        // tampilkan data
        while ($data = mysqli_fetch_assoc($query)) {
            $t_transaksi       = $data['tanggal'];
            $exp               = explode('-',$t_transaksi);
            $tanggal_transaksi = tgl_eng_to_ind($exp[2]."-".$exp[1]."-".$exp[0]);

            // $jumlah = $data['harga'] + + ($data['tambahan_orang'] * $data['harga_tambahan']);
            // $jumlah = $data['total'];
            // menampilkan isi tabel dari database ke tabel di aplikasi
            echo "  <tr>
                        <td width='40' height='13' align='center' valign='middle'>$no</td>
                        <td width='130' height='13' align='center' valign='middle'>$data[id_transaksi]</td>
                        <td width='150' height='13' align='center' valign='middle'>$tanggal_transaksi</td>
                        <td style='padding-left:5px;' width='180' height='13' valign='middle'>$data[nama_pelanggan]</td>
                        <td width='120' height='13' align='center' valign='middle'>$data[nama_paket]</td>
                        <td style='padding-left:5px;' width='150' height='13' valign='middle'>$data[tambahan_orang]</td>
                        <td style='padding-right:5px;' width='150' height='13' align='right' valign='middle'>Rp. ".format_rupiah($data['total'])."</td>
                    </tr>";
            $no++;

            $total += $data['total'];
        }
            echo "  <tr>
                        <td height='15' colspan='6' align='left' valign='middle'><strong>  Total</strong></td>
                        <td style='padding-right:5px;' height='15' width='120' align='right' valign='middle'><strong>Rp. ".format_rupiah($total)."</strong></td>
                    </tr>";
    }
?>  
                </tbody>
            </table>

            <div id="footer-tanggal">
                Bandung, <?php echo tgl_eng_to_ind("$hari_ini"); ?>
            </div>
            <div id="footer-jabatan">
                Pimpinan
            </div>
            
            <div id="footer-nama">
                Fauzi Rizky Utama, Calon S.T
            </div>
        </div>
    </body>
</html><!-- Akhir halaman HTML yang akan di konvert -->
<?php
$filename="Rekap Data Transaksi.pdf"; //ubah untuk menentukan nama file pdf yang dihasilkan nantinya

$content = ob_get_contents();
echo $content;
ob_clean();
// panggil library html2pdf
require_once('../../assets/plugins/html2pdf-4.4.0/html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('L','F4','en', false, 'ISO-8859-15',array(10, 10, 10, 10));
    $html2pdf->setDefaultFont('Arial');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output($filename);
}
catch(HTML2PDF_exception $e) { echo $e; }
?>
