<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Jenis Buku</h1>
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
            <h3 class="card-title">Jenis Buku</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" method="post" action="<?=base_url('jenisbuku/create')?>">
            <div class="card-body">
              <div class="form-group">
                <label>Jenis</label>
                <input type="text" class="form-control" name="jenis" placeholder="Masukkan Jenis">
              </div>
              <div class="form-group">
                <label>Tipe</label>
                <textarea class="form-control" name="type" placeholder="Masukkan Type Deskripsi"></textarea>
              </div>
              <div class="form-group">
                <label>Tarif Dasar</label>
                <input type="text" class="form-control" name="tarif_dasar" placeholder="Masukkan Tarif Dasar">
              </div>
              
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