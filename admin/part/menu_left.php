<?php 
$ongkir = $db->query("SELECT free_limit, harga FROM tbl_set_ongkir")->fetch_object();

?>

<div class="alert alert-warning">
	
	<form role="form" id="form_harga_ongkir">
		<div class="form-group has-feedback">
			Harga Ongkir (Rp)	
			<input type="text" class="form-control" id="harga" name="harga" value="<?php echo rupiah($ongkir->harga)?>"  required>
		</div>
		<div class="form-group has-feedback">
			Limit Free Ongkir (Kg)	
			<input type="text" class="form-control" id="free_limit" name="free_limit" value="<?php echo $ongkir->free_limit?>"  required>
		</div>
		<input type="submit"  class="btn btn-danger btn-xs" value="Edit &rarr;">
		
  </form>
	<div style="clear:both"></div>
	
</div>



<script>
$("#form_harga_ongkir").on("submit",function(){
	var harga 		= $("#harga").val();	
	var free_limit 	= $("#free_limit").val();
	var form_harga_ongkir 	= "form_harga_ongkir";
	$.get("part/action_table.php",{harga:harga,free_limit:free_limit,form_harga_ongkir:form_harga_ongkir},function(e){
		var arr_e = e.split("-");
		 //alert( arr_e[0]);
		 $("#harga").parent().fadeOut().addClass("has-success").fadeIn();	
		 $("#free_limit").parent().fadeOut().addClass("has-success").fadeIn();	
		 $("#harga").val(arr_e[0]);	
		 $("#free_limit").val(arr_e[1]);	
		 
	});
	
	return false;
});
</script>



