
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
        <h1>Tracking</h1>
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
            <h3 class="card-title">Tracking Peminjaman Buku</h3>
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

    $.ajax({
        url : site_url+'peminjaman/get_peminjaman_detail',
        data : { kode_buku:kode_buku },
        type : "POST",
        dataType : "json",
        async : false,
        success : function(row){

          var html = "";

          if(row != null)
          {
            html = "<table>" +
              "<tr>" +
                "<td>Kode</td>" +
                "<td>"+row.kode_buku+"</td>" +
              "</tr>" +
              "<tr>" +
                "<td>Nama</td>" +
                "<td>"+row.nama_buku+"</td>" +
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
              "<tr>" +
                "<td>Peminjam</td>" +
                "<td>"+row.peminjam+"</td>" +
              "</tr>" +
              "<tr>" +
                "<td>Alamat Peminjam</td>" +
                "<td>"+row.alamat_peminjam+"</td>" +
              "</tr>" +
              "<tr>" +
                "<td>Tanggal Pinjam</td>" +
                "<td>"+row.tanggal_pinjam+"</td>" +
              "</tr>" +
              "<tr>" +
                "<td>Tanggal Kembali</td>" +
                "<td>"+row.tanggal_kembali+"</td>" +
              "</tr>" +
            "</table>";
          }

          $('#div_detail').html(html);
        }
    });
});

</script>

