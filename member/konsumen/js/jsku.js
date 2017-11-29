
function loading_menu()
{
	$("#loading").fadeIn();	

}

function loading_menu_hide()
{

	$("#loading").fadeOut();
	
}


function load_menu(id_tombol,url_target)
{
	
	$("#"+id_tombol).click(function(){
	loading_menu();
	$("#isi_content").hide().html('');
		if($.get(url_target,function(e){
			$("#isi_content").html(e);
			$("#isi_content").fadeIn(1000);
		}))
		{
			loading_menu_hide();
		}
		
		
	});

}

function load_menu_hash(url_target)
{
	$("#isi_content").hide();
	loading_menu();
		if($("#isi_content").html(''))
		{
			$.get(url_target,function(e){
				if($("#isi_content").html(e))
				{
					loading_menu_hide();
					$("#isi_content").fadeIn(1000);
				}
				
			});
		}
		
				
}



function tambah_barang(){
	loading_menu();
	$("#t4_table,#judul_h1").fadeOut();
	$.get("part/form_barang.php", function(e){
		
		$("#t4_tambah_data").html(e);
		
		$("#t4_tambah_data").fadeIn("slow");
		
		
		loading_menu_hide();
		
	});
	
	return false;		
	
}

function panggil_form(alamat){
	loading_menu();
	$("#t4_table,#judul_h1").fadeOut();
	$.get(alamat, function(e){
		
		$("#t4_tambah_data").html(e);
		
		$("#t4_tambah_data").fadeIn("slow");
		
		
		loading_menu_hide();
		
	});
	
	return false;		
	
}


function go_to(id_togo){
	
	$('html,body').animate({scrollTop: $("#"+id_togo).offset().top},'slow');

}


function notif_function(id_nya,tblnya)
{
	
	$.get("part/count_function.php?"+tblnya,function(e){
		
			if(e <= 0){				
				$("#"+id_nya).hide();
			}else{
				$("#"+id_nya).html('<span class="badge badge-notify">'+e+'</span>');	
			}						
		
	});
	
	
}



//link hash
if(window.location.hash) 
{
  var link = window.location.hash.substr(1);
  load_menu_hash("part/"+link+".php");
  
}


bootstrap_alert = function() {}
bootstrap_alert.warning = function(message) 
{
    $('#alert_placeholder').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Error! </strong><span> '+message+'</span></div>')
}
		
bootstrap_alert.success = function(message) 
{
    $('#alert_placeholder').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Success! </strong><span> '+message+'</span></div>')
}

function add_warning(pesan,tempat_pesan){
	
	$("#"+tampat_pesan).html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Success! </strong><span> '+message+'</span></div>');
	
}
