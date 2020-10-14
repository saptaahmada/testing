<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Detail Peminjaman</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">
              INVOICE RENT BOOK<br>

            </h3>
            <a class="float-right btn btn-primary" href="<?=base_url('peminjaman/lunas/'.$kode_pelanggan)?>" onclick="return confirm('yakin ini lunas?')">Lunas</a>
          </div>
          <div class="card-body">

            <?php foreach ($data_pelanggan as $key => $val): ?>
            <div class="row">
              <div class="col-sm-2">To</div>
              <div class="col-sm-6"><?=$val['nama']?></div>
            </div>
            <div class="row">
              <div class="col-sm-2">Address</div>
              <div class="col-sm-6"><?=$val['alamat']?></div>
            </div>
            <div class="row">
              <div class="col-sm-2">KTP</div>
              <div class="col-sm-6"><?=$val['ktp']?></div>
            </div>
            <?php endforeach ?>
            <br>

            
            <table class="table table-bordered">
              <thead>
                <th>No</th>
                <th>Description</th>
                <th>Item (Days)</th>
                <th>Amount (IDR)</th>
              </thead>
              <tbody>
                <?php foreach ($data_transaksi as $key => $val): ?>
                  <tr>
                    <td><?=$key+1?></td>
                    <td>
                      <?=$val['nama_buku'].'('.$val['kode_buku'].')'?><br>
                      <?php
                        echo '('.$val['tanggal_pinjam'].' until '.$val['tanggal_kembali'].')';
                      ?>
                    </td>
                    <td><?=$val['item_days']?></td>
                    <td><?=$val['amount']?></td>
                  </tr>
                <?php endforeach ?>
                <tr>
                  <td colspan="3">Sub Total</td>
                  <td><?=$subtotal?></td>
                </tr>
                <tr>
                  <td colspan="3">Tax</td>
                  <td><?=$tax?></td>
                </tr>
                <tr>
                  <td colspan="3">Stamp</td>
                  <td><?=$stamp?></td>
                </tr>
                <tr>
                  <td colspan="3">Total</td>
                  <td><?=$total?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.card -->

        
      </div>
      <!--/.col (left) -->
      <!-- right column -->
      
      <!--/.col (right) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->