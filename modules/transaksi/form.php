<script type="text/javascript">
  function tampil_paket(input){
    var num     = input.value

    $.post("modules/transaksi/paket.php", {
      dataidpaket: num,
    }, function(response) {
      var data = $.parseJSON(response);
      $('#biaya').html(data[0]);
      var biaya_a = Number(data[1]), // biaya awal/asli
          biaya_t = Number(data[2]); // biaya tambahan

      // fungsi untuk mengupdate tampilan harga
      function update_biaya(b_a, b_t) {
        // hitung biaya tambahan
        var orang    = Number($('#tambahan_orang').val());
        var tambahan = b_t * orang;
        // update biaya tambahan
        $('#harga_tambahan').val(tambahan.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.'));

        var total = b_a + tambahan;
        $('#total').val(total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.'));
      }
      // tetap jalan saat berganti paket
      update_biaya(biaya_a, biaya_t);

      // tambah event handler untuk tambahan orang
      $('#tambahan_orang').on('change', function(){
        // dijalankan saat berubah jumlah tambahan orang
        update_biaya(biaya_a, biaya_t);
      });
    });
  }

</script>

 <?php  
// fungsi untuk pengecekan tampilan form
// jika form add data yang dipilih
if ($_GET['form']=='add') { ?> 
  <!-- tampilan form add data -->
	<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i style="margin-right:7px" class="fa fa-edit"></i> Input Transaksi
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=home"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=transaksi"> Transaksi </a></li>
      <li class="active"> Tambah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" method="POST" action="modules/transaksi/proses.php?act=insert" method="POST" name="formtr">
            <div class="box-body">

              <div class="form-group">

                <?php  
                // fungsi untuk membuat id transaksi
                $query_id = mysqli_query($mysqli, "SELECT RIGHT(id_transaksi,5) as kode FROM is_transaksi
                                                  ORDER BY id_transaksi DESC LIMIT 1")
                                                  or die('Ada kesalahan pada query tampil transaksi : '.mysqli_error($mysqli));

                $count = mysqli_num_rows($query_id);

                if ($count <> 0) {
                    // mengambil data id_transaksi
                    $data_id = mysqli_fetch_assoc($query_id);
                    $kode    = $data_id['kode']+1;
                } else {
                    $kode = 1;
                }

                // buat id_transaksi
                $buat_id      = str_pad($kode, 5, "0", STR_PAD_LEFT);
                $id_transaksi = "TR-$buat_id";
                ?>
                <label class="col-sm-2 control-label">ID Transaksi</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="id_transaksi" value="<?php echo $id_transaksi; ?>" readonly>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Tanggal</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tanggal" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" required>
                </div>
              </div>

              <hr>

              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Pelanggan</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nama_pelanggan" autocomplete="off" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Paket</label>
                <div class="col-sm-5">
                  <select class="form-control" id="paket" name="paket" onchange="tampil_paket(this)" required>
                    <option value=""></option>
                    <?php
                      $query_paket = mysqli_query($mysqli, "SELECT * FROM is_paket ORDER BY id_paket ASC")
                                                            or die('Ada kesalahan pada query tampil paket: '.mysqli_error($mysqli));

                      while ($data_paket = mysqli_fetch_assoc($query_paket)) {
                        echo"<option value=\"$data_paket[id_paket]\"> $data_paket[nama_paket] </option>";
                      }
                    ?>
                  </select>
                </div>
              </div>
              
              <span id='biaya'>
              <div class="form-group">
                <label class="col-sm-2 control-label">Biaya</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon">Rp.</span>
                    <input type="text" class="form-control" id="biaya" name="biaya" readonly>
                  </div>
                </div>
              </div>
              </span>

              <div class="form-group">
                <label class="col-sm-2 control-label">Tambahan Orang</label>
                <div class="col-sm-5">
                  <input type="number" class="form-control" id="tambahan_orang" name="tambahan_orang" min='0' autocomplete="off" required>
                </div>
              </div>

              <span>
              <div class="form-group">
                <label class="col-sm-2 control-label">Biaya Tambahan</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon">Rp.</span>
                    <input type="text" class="form-control" id="harga_tambahan" name="harga_tambahan" readonly>
                  </div>
                </div>
              </div>
              </span>

              <span>
              <div class="form-group">
                <label class="col-sm-2 control-label">Total Biaya</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon">Rp.</span>
                    <input type="text" class="form-control" id="total" name="total" readonly>
                  </div>
                </div>
              </div>
              </span>

            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                  <a href="?module=transaksi" class="btn btn-default btn-reset">Batal</a>
                </div>
              </div>
            </div><!-- /.box footer -->
          </form>
        </div><!-- /.box -->
      </div><!--/.col -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
<?php
}
// jika form edit data yang dipilih
// isset : cek data ada / tidak
elseif ($_GET['form']=='edit') { 
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
  <!-- tampilan form edit data -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i style="margin-right:7px" class="fa fa-edit"></i> Ubah Transaksi
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=home"><i class="fa fa-home"></i> Beranda </a></li>
      <li><a href="?module=transaksi"> Transaksi </a></li>
      <li class="active"> Ubah </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- form start -->
          <form role="form" class="form-horizontal" method="POST" action="modules/transaksi/proses.php?act=update" method="POST">
            <div class="box-body">

              <div class="form-group">
                <label class="col-sm-2 control-label">ID Transaksi</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="id_transaksi" value="<?php echo $data['id_transaksi']; ?>" readonly>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Tanggal</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="tanggal" autocomplete="off" value="<?php echo $tanggal_transaksi; ?>" required>
                </div>
              </div>

              <hr>

              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Pelanggan</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="nama_pelanggan" autocomplete="off" value="<?php echo $data['nama_pelanggan']; ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Paket</label>
                <div class="col-sm-5">
                  <select class="form-control" id="paket" name="paket" onchange="tampil_paket(this)" required>
                    <option value="<?php echo $data['id_paket']; ?>"><?php echo $data['nama_paket']; ?></option>
                    <?php
                      $query_paket = mysqli_query($mysqli, "SELECT * FROM is_paket ORDER BY id_paket ASC")
                                                            or die('Ada kesalahan pada query tampil paket: '.mysqli_error($mysqli));
                      while ($data_paket = mysqli_fetch_assoc($query_paket)) {
                        echo"<option value=\"$data_paket[id_paket]\"> $data_paket[nama_paket] </option>";
                      }
                    ?>
                  </select>
                </div>
              </div>
              
              <span id='biaya'>
              <div class="form-group">
                <label class="col-sm-2 control-label">Biaya</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon">Rp.</span>
                    <input type="text" class="form-control" id="biaya" name="biaya" value="<?php echo format_rupiah($data['harga']); ?>" readonly>
                  </div>
                </div>
              </div>
              </span>

              <div class="form-group">
                <label class="col-sm-2 control-label">Tambahan Orang</label>
                <div class="col-sm-5">
                  <input type="number" class="form-control" id="tambahan_orang" name="tambahan_orang" min="0" autocomplete="off" value="<?php echo $data['tambahan_orang']; ?>" required>
                </div>
              </div>

              <span id='biaya'>
              <div class="form-group">
                <label class="col-sm-2 control-label">Biaya Tambahan</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon">Rp.</span>
                    <input type="text" class="form-control" id="harga_tambahan" name="harga_tambahan" value="<?php echo format_rupiah($data['harga_tambahan']*$data['tambahan_orang']); ?>" readonly>
                  </div>
                </div>
              </div>
              </span>

              <span id='biaya'>
              <div class="form-group">
                <label class="col-sm-2 control-label">Biaya Total</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <span class="input-group-addon">Rp.</span>
                    <input type="text" class="form-control" id="total" name="total" value="<?php echo format_rupiah($data['total']); ?>" readonly>
                  </div>
                </div>
              </div>
              </span>

            </div><!-- /.box body -->

            <div class="box-footer">
              <div class="form-group">
                <div class="col-sm-offset-1 col-sm-11">
                  <input type="submit" class="btn btn-primary btn-submit" name="simpan" value="Simpan">
                  <a href="?module=transaksi" class="btn btn-default btn-reset">Batal</a>
                </div>
              </div>
            </div><!-- /.box footer -->
          </form>
        </div><!-- /.box -->
      </div><!--/.col -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
<?php
}
?>
