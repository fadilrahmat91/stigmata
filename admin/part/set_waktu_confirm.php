<?php
if(session_id() == '') {
    session_start();
}

if(!isset($_SESSION['id_admin']))
{
	header ('location: login.php');
}
include_once(dirname(__FILE__) . '/../../config/config.php');
include_once(dirname(__FILE__) . '/../../config/setting.php');
include_once(dirname(__FILE__) . '/../../config/function.php');

//form action
if(isset($_GET['hari']))
{
	$hari = $_GET['hari'];
	$db->query("UPDATE tbl_set_waktu_confirm SET hari='$hari'");
	die();
}


$get = $db->query("SELECT hari FROM tbl_set_waktu_confirm")->fetch_object();
$hari = $get->hari;


?>	

<div class="alert alert-danger" id="t4_auto_reject">
	Data auto reject : <input type="text" id="inp_hari" value="<?php echo $hari?>" class="text-center" style="width:30px"> hari  
	&nbsp;&nbsp;&nbsp;&nbsp;<input class="btn btn-success btn-xs" name="set_hari" id="btn_set_autoreject" type="button" value="Set">  
	&nbsp;&nbsp;&nbsp;&nbsp; (<small>Untuk mengatur auto reject pesanan jika tidak dikonfirmasi</small>)
	
</div>

<script>
$("#btn_set_autoreject").click(function(){
	var hari = $("#inp_hari").val();	
	//alert(hari);
	$.get("part/set_waktu_confirm.php",{hari:hari},function(e){
		//alert(e);
		$("#t4_auto_reject").attr("class","alert alert-success").fadeOut().fadeIn();
	});
	
	
	return false;
});
</script>