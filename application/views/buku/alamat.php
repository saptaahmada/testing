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


<div class="form-group">
  <label>Jenis Buku</label>
  <select class="form-control" id="alamat_rak" name="alamat_rak" onchange="get_buku_from_rak()">
    <option value="">Pilih Rak</option>
    <?php for ($i=1; $i<=$kapasitas[0]['rak']; $i++) { ?>
      <option value="<?=$i?>">
        Rak <?=$i?>
      </option>
    <?php } ?>
  </select>
</div>


<div style="overflow-x: scroll; width: 1500px" id="div_oke">
</div>

<script type="text/javascript">

  var kode_buku = "<?=$kode_buku?>";
  var site_url = "<?=site_url()?>";

  function get_buku_from_rak() {

    $.ajax({
        url : site_url+'buku/get_buku_from_rak',
        data : { kode_buku:kode_buku, alamat_rak:$("#alamat_rak").val() },
        type : "POST",
        dataType : "json",
        async : false,
        success : function(row){
          $('#div_oke').html(row);
        }
    });
  }

  function pilih(kelas, rak, kolom, tinggi) {
    if(kelas == "") {
      if(confirm("apa anda yakin ingin memilih alamat rak ini?")) {
        $.ajax({
            url : site_url+'buku/save_alamat',
            data : { 
              kode_buku:kode_buku, 
              alamat_rak:rak, 
              alamat_kolom:kolom, 
              alamat_tinggi:tinggi 
            },
            type : "POST",
            dataType : "json",
            async : false,
            success : function(result){
              if(result) {
                window.location = site_url+'buku';
              }
            }
        });
      }
    } else {
      alert("rak sudah terisi");
    }
  }

</script>