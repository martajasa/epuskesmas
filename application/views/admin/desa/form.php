<script type="text/javascript">
    $(document).ready(function(){
       $("button,submit,reset").jqxInput({ theme: 'fresh', height: '28px' }); 
    });
</script>
<div style="padding:5px;text-align:center">
<form method="POST" id="frmData">
	<button type="button" onClick="save_{action}_dialog($('#frmData').serialize());">Simpan</button>
	<button type="reset">Ulang</button>
	<button type="button" onClick="close_dialog();">Batal</button>
    <br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" class="panel" align="center">
		<tr>
			<td>

				<table border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>ID Desa</td>
						<td>:</td>
						<td>
                            <input class=input type="text" size="10" name="id_desa" <?php if($action=="edit") echo "readonly"; ?> value="<?php 
								if(set_value('id_desa')=="" && isset($id_desa)){
								 	echo $id_desa;
								}else{
									echo  set_value('id_desa');
								}
								?>"/>
						</td>
					</tr>
					<tr>
						<td>Nama Desa</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="nama_desa" value="<?php 
								if(set_value('nama_desa')=="" && isset($nama_desa)){
								 	echo $nama_desa;
								}else{
									echo  set_value('nama_desa');
								}
								 ?>"/>
						</td>
					</tr>
					<tr>
						<td colspan="3" height="30"></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
</form>
</div>