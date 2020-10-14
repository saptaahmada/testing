<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Peminjaman</h1>
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
            <h3 class="card-title">Peminjaman</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" method="post" action="<?=base_url('peminjaman/create')?>">
            <div class="card-body">
              <div class="form-group">
                <label>Kode Pelanggan</label>
                <select class="form-control select2" id="kode_pelanggan" name="kode_pelanggan"></select>
              </div>
              <div class="form-group">
                <label>Jumlah Buku</label>
                <input type="number" class="form-control" id="jumlah_buku" name="jumlah_buku" placeholder="Masukkan Jumlah Buku">
                <input class="btn btn-success" type="button" value="oke" onclick="generate_jumlah_buku()">
              </div>
              <div class="form-group" id="div_kode_buku"></div>
              
              <div class="form-group">
                <label>Berapa hari</label>
                <input type="number" class="form-control" name="jumlah_hari" placeholder="Masukkan Berapa Hari">
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

<link href="<?=base_url();?>assets/select2/select2.min.css" rel="stylesheet" type="text/css">
<script src="<?=base_url();?>assets/select2/select2.min.js" type="text/javascript"></script>


<script type="text/javascript">

var site_url = "<?=site_url()?>";


$('#kode_pelanggan').select2({
    ajax: {
        url: site_url+'pelanggan/get_pelanggan_select2',
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                kode: params.term // search term
            };
        },
        processResults: function(response) {
            return {
                results: response
            };
        },
        cache: true
    },
    placeholder: "Pilih Pelanggan",
    allowClear: true
});

function initSelect2() {
  
  $('.kode_buku').select2({
      ajax: {
          url: site_url+'buku/get_data_buku',
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function(params) {
              return {
                  kode_buku: params.term // search term
              };
          },
          processResults: function(response) {
              return {
                  results: response
              };
          },
          cache: true
      },
      placeholder: "Pilih Buku",
      allowClear: true
  });
}


  function generate_jumlah_buku() {
    var jumlah_buku = $('#jumlah_buku').val();
    var html = "";
    for(var i=0; i<jumlah_buku; i++)
    {
      html = html +
      '<select class="form-control select2 kode_buku" name="kode_buku[]"></select>';
      // '<input type="text" class="form-control" name="kode_buku[]" placeholder="Masukkan Kode Buku ke-'+(i+1)+'">';
    }
    $('#div_kode_buku').html(html);
    initSelect2();
  }
</script>