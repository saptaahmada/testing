<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Pelanggan</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<?=$this->session->flashdata('message')?>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Pelanggan</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" method="post" action="<?=base_url('pelanggan/update/'.$kode)?>">
            <div class="card-body">
              <?php foreach ($data as $key => $val): ?>                
              <div class="form-group">
                <label>Kode</label>
                <input type="text" class="form-control" name="kode" value="<?=$val['kode']?>" placeholder="Masukkan Kode">
              </div>
              <div class="form-group">
                <label>Nama</label>
                <input type="text" class="form-control" name="nama" value="<?=$val['nama']?>" placeholder="Masukkan Nama">
              </div>
              <div class="form-group">
                <label>KTP</label>
                <input type="text" class="form-control" name="ktp" value="<?=$val['ktp']?>" placeholder="Masukkan KTP">
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat" placeholder="Masukkan Alamat"><?=$val['alamat']?></textarea>
              </div>
              <div class="form-group">
                <label>HP</label>
                <input type="text" class="form-control" name="hp" value="<?=$val['hp']?>" placeholder="Masukkan HP">
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="email" value="<?=$val['email']?>" placeholder="Masukkan Email">
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