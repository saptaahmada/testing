<script src="<?=base_url('assets/adminlte/')?>plugins/jquery/jquery.min.js"></script>

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


<div style="overflow-x: scroll; width: 1500px" id="div_oke">
</div>

<?php foreach ($data as $key => $val): ?>
  
  <table>
    <tr>
      <td>Kode</td>
      <td><?=$val['kode_buku']?></td>
    </tr>
    <tr>
      <td>Nama</td>
      <td><?=$val['nama_buku']?></td>
    </tr>
    <tr>
      <td>Rak</td>
      <td><?=$val['alamat_rak']?></td>
    </tr>
    <tr>
      <td>Kolom</td>
      <td><?=$val['alamat_kolom']?></td>
    </tr>
    <tr>
      <td>Tinggi</td>
      <td><?=$val['alamat_tinggi']?></td>
    </tr>
    <tr>
      <td>Penerbit</td>
      <td><?=$val['penerbit']?></td>
    </tr>
    <tr>
      <td>Penulis</td>
      <td><?=$val['penulis']?></td>
    </tr>
    <tr>
      <td>Jenis</td>
      <td><?=$val['jenis']?></td>
    </tr>
  </table>

<?php endforeach ?>


<script type="text/javascript">

  $( document ).ready(function() {
    get_tracking();
  });

  var kode_buku   = "<?=$kode_buku?>";
  var site_url    = "<?=site_url()?>";
  var data        = <?=json_encode($data)?>;

  function get_tracking() {

    $.ajax({
        url : site_url+'buku/get_tracking',
        data : { kode_buku:kode_buku, alamat_rak:data[0].alamat_rak },
        type : "POST",
        dataType : "json",
        async : false,
        success : function(row){
          $('#div_oke').html(row);
        }
    });
  }

</script>