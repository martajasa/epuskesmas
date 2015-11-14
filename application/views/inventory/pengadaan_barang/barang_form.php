</style>
<script type="text/javascript">
    $(function(){

      $('#btn-close').click(function(){
        close_popup();
      }); 
        $('#form-ss').submit(function(){
            var data = new FormData();
            $('#notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
            $('#notice').show();

            data.append('id_mst_inv_barang', $('#v_kode_barang').val());
            data.append('nama_barang', $('#v_nama_barang').val());
            data.append('jumlah', $('#jumlah').val());
            data.append('harga', $('#harga').val());
            data.append('keterangan_pengadaan', $('#keterangan').val());
            $.ajax({
                cache : false,
                contentType : false,
                processData : false,
                type : 'POST',
                url : '<?php echo base_url()."inventory/pengadaanbarang/".$action."_barang/".$kode."/" ?>',
                data : data,
                success : function(response){
                  var res  = response.split("|");
                  if(res[0]=="OK"){
                      $('#notice').hide();
                      $('#notice-content').html('<div class="alert">'+res[1]+'</div>');
                      $('#notice').show();

                      $("#jqxgrid_barang").jqxGrid('updatebounddata', 'cells');
                      close_popup();
                  }
                  else if(res[0]=="Error"){
                      $('#notice').hide();
                      $('#notice-content').html('<div class="alert">'+res[1]+'</div>');
                      $('#notice').show();
                  }
                  else{
                      $('#popup_content').html(response);
                  }
              }
            });

            return false;
        });

        $("#jqxinput").jqxInput(
          {
          placeHolder: " Ketik Kode atau Nama Barang ",
          theme: 'classic',
          width: '100%',
          height: '30px',
          minLength: 2,
          source: function (query, response) {
            var dataAdapter = new $.jqx.dataAdapter
            (
              {
                datatype: "json",
                  datafields: [
                  { name: 'uraian', type: 'string'},
                  { name: 'code', type: 'string'},
                  { name: 'code_tampil', type: 'string'}
                ],
                url: '<?php echo base_url().'inventory/permohonanbarang/autocomplite_barang'; ?>'
              },
              {
                autoBind: true,
                formatData: function (data) {
                  data.query = query;
                  return data;
                },
                loadComplete: function (data) {
                  if (data.length > 0) {
                    response($.map(data, function (item) {
                      return item.code_tampil +' | '+item.uraian;
                    }));
                  }
                }
              });
          }
        });

        $("#jqxinput").select(function(){
            var codebarang = $(this).val();
            var res = codebarang.split(" | ");
            $("#v_nama_barang").val(res[1]);
            $("#v_kode_barang").val(res[0].replace(/\./g,""));
        });
        $("#harga").change(function(){
            var jumlah = document.getElementById("jumlah").value;
            var harga = document.getElementById("harga").value;
            document.getElementById("subtotal").value = jumlah*harga;
        });
    });
</script>

<div style="padding:15px">
  <div id="notice" class="alert alert-success alert-dismissable" <?php if ($notice==""){ echo 'style="display:none"';} ?> >
    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
    <h4>
    <i class="icon fa fa-check"></i>
    Information!
    </h4>
    <div id="notice-content">{notice}</div>
  </div>
	<div class="row">
    <?php echo form_open(current_url(), 'id="form-ss"') ?>
          <div class="box-body">
            <div class="form-group">
              <label>Kode Barang</label>
              <input id="jqxinput" class="form-control" autocomplete="off" name="code_mst_inv" type="text" value="<?php 
                if(set_value('code_mst_inv')=="" && isset($code_mst_inv_barang)){
                  $s = array();
                  $s[0] = substr($code_mst_inv_barang, 0,2);
                  $s[1] = substr($code_mst_inv_barang, 2,2);
                  $s[2] = substr($code_mst_inv_barang, 4,2);
                  $s[3] = substr($code_mst_inv_barang, 6,2);
                  $s[4] = substr($code_mst_inv_barang, 8,2);
                  echo implode(".", $s).' | '.$nama_barang;
                }else{
                  echo  set_value('code_mst_inv');
                }
                ?>" <?php if(isset($disable)){if($disable='disable'){echo "readonly";}} ?>/>
              <input id="v_kode_barang" class="form-control" name="code_mst_inv_barang" type="hidden" value="<?php 
                if(set_value('code_mst_inv_barang')=="" && isset($code_mst_inv_barang)){
                  echo $code_mst_inv_barang;
                }else{
                  echo  set_value('code_mst_inv_barang');
                }
                ?>" />
            </div>
            <div class="form-group">
              <label>Nama Barang</label>
              <input type="text" class="autocomplete form-control" id="v_nama_barang" name="nama_barang"  placeholder="Nama Barang" value="<?php
              if(set_value('nama_barang')=="" && isset($nama_barang)){
                  echo $nama_barang;
                }else{
                  echo  set_value('nama_barang');
                }
                ?>">
            </div>
            <div class="form-group">
              <label>Jumlah</label>
              <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?php 
                if(set_value('jumlah')=="" && isset($jumlah)){
                  echo $jumlah;
                }else{
                  echo  set_value('jumlah');
                }
                ?>">
            </div>
            <div class="form-group">
              <label>Harga Satuan</label>
              <input type="number" class="form-control" name="harga" id="harga" placeholder="Harga Satuan" value="<?php 
                if(set_value('harga')=="" && isset($harga)){
                  echo $harga;
                }else{
                  echo  set_value('harga');
                }
                ?>">
            </div>
            <div class="form-group">
              <label>Sub Total</label>
              <input type="text" class="form-control" name="subtotal"  id="subtotal" placeholder="Sub Total" readonly="">
            </div>
            <div class="form-group">
              <label>Keterangan</label>
              <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan"><?php 
                  if(set_value('keterangan')=="" && isset($keterangan)){
                    echo $keterangan;
                  }else{
                    echo  set_value('keterangan');
                  }
                  ?></textarea>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" id="btn-close" class="btn btn-warning">Batal</button>
        </div>
    </div>
</form>
</div>