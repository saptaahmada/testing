
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
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Jenis Buku</h3>
            <a class="float-right btn btn-primary" href="<?=base_url('jenisbuku/create')?>">Tambah</a>
          </div>
          <div class="card-body">
            
            <table class="table table-bordered" id="tb_jenisbuku">
              <thead>
                <th>No</th>
                <th>Jenis</th>
                <th>Type</th>
                <th>Tarif Dasar</th>
                <th>Aksi</th>
              </thead>
            </table>
          </div>
            <!-- /.card-body -->

            <!-- <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form> -->
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

<script type="text/javascript">
$(window).on('load', function(){
  getDatatable();
});

var id_cabang = 1;


function getDatatable(){
  $('#tb_jenisbuku').DataTable({
       "filter": true,
        "destroy": true,
        "ordering": true,
        "processing": true, 
        "serverSide": true, 
        "searching": true, 
        "responsive":true,
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "jenisbuku/datatable_jenisbuku/",
            "type": "POST",
        },

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [0], //first column / numbering column
                "orderable": false, //set not orderable
            },
        ],

    });
}

</script>