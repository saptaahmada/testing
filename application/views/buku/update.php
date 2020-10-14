<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Buku</h1>
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
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Buku</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" method="post" action="<?=base_url('buku/update/'.$kode_buku)?>">
            <div class="card-body">
              <?php foreach ($data as $key => $val): ?>
                
              <div class="form-group">
                <label>Nama Buku</label>
                <input type="text" class="form-control" name="nama_buku" value="<?=$val['nama_buku']?>" placeholder="Masukkan Nama Buku">
              </div>
              <div class="form-group">
                <label>Penerbit</label>
                <input type="text" class="form-control" name="penerbit" value="<?=$val['penerbit']?>" placeholder="Masukkan Penerbit">
              </div>
              <div class="form-group">
                <label>Penulis</label>
                <input type="text" class="form-control" name="penulis" value="<?=$val['penulis']?>" placeholder="Masukkan Penulis">
              </div>
              <div class="form-group">
                <label>Jenis Buku</label>
                <select class="form-control" name="jenis_buku">
                  <?php foreach ($jenis_buku as $key => $val2): ?>
                    <option value="<?=$val2['id_jenis_buku']?>" <?=($val['jenis_buku'] == $val2['id_jenis_buku']?'selected':'')?>>
                      <?=$val2['jenis']?>
                    </option>
                  <?php endforeach ?>
                </select>
              </div>

              <?php endforeach ?>

              
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <input type="submit" name="submit" value="submit" class="btn btn-primary">
            </div>
          </form>
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