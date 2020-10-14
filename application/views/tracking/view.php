
<style type="text/css">
  .rect {
    width: 15px; 
    height: 15px;
    display: inline-block;
    border-style: solid;
    border-width: 1px;
  }
  .rect-no-border {
    width: 15px; 
    height: 15px;
    display: inline-block;
    border-style: solid;
    border-width: 1px;
    border-color: white;
  }
  .rect-filled {
    background-color: blue; 
  }
  .font-10 {
    font-size: 10px;
  }
</style>

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
            <h3 class="card-title">Tracking Buku</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <div class="card-body">
            <select class="form-control select2" id="kode_buku" name="kode_buku"></select>


            <div style="overflow-x: scroll; width: 1500px" id="div_oke"></div>
            <div id="div_detail"></div>

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

<link href="<?=base_url();?>assets/select2/select2.min.css" rel="stylesheet" type="text/css">
<script src="<?=base_url();?>assets/select2/select2.min.js" type="text/javascript"></script>

<script type="text/javascript">

var site_url = "<?=site_url()?>";


$('#kode_buku').select2({
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
    placeholder: "Pilih Kode Buku",
    allowClear: true
});


$("#kode_buku").on("change", function (e){
    var kode_buku = $("#kode_buku option:selected").val();

    alamat_rak = get_alamat_rak(kode_buku);

    $.ajax({
        url : site_url+'buku/get_tracking',
        data : { kode_buku:kode_buku, alamat_rak:alamat_rak },
        type : "POST",
        dataType : "json",
        async : false,
        success : function(row){
          $('#div_oke').html(row);
        }
    });

    $.ajax({
        url : site_url+'buku/get_buku_detail',
        data : { kode_buku:kode_buku },
        type : "POST",
        dataType : "json",
        async : false,
        success : function(row){

          $html = "<table>" +
            "<tr>" +
              "<td>Kode</td>" +
              "<td>"+row.kode_buku+"</td>" +
            "</tr>" +
            "<tr>" +
              "<td>Nama</td>" +
              "<td>"+row.nama_buku+"</td>" +
            "</tr>" +
            "<tr>" +
              "<td>Rak</td>" +
              "<td>"+row.alamat_rak+"</td>" +
            "</tr>" +
            "<tr>" +
              "<td>Kolom</td>" +
              "<td>"+row.alamat_kolom+"</td>" +
            "</tr>" +
            "<tr>" +
              "<td>Tinggi</td>" +
              "<td>"+row.alamat_tinggi+"</td>" +
            "</tr>" +
            "<tr>" +
              "<td>Penerbit</td>" +
              "<td>"+row.penerbit+"</td>" +
            "</tr>" +
            "<tr>" +
              "<td>Penulis</td>" +
              "<td>"+row.penulis+"</td>" +
            "</tr>" +
            "<tr>" +
              "<td>Jenis</td>" +
              "<td>"+row.jenis+"</td>" +
            "</tr>" +
          "</table>";

          $('#div_detail').html($html);
        }
    });
});

function get_alamat_rak(kode_buku) {
  var alamat_rak = "";

  $.ajax({
      url : site_url+'buku/get_alamat_rak',
      data : { kode_buku:kode_buku },
      type : "POST",
      dataType : "json",
      async : false,
      success : function(result){
        alamat_rak = result;
      }
  });

  return alamat_rak;
}

</script>

