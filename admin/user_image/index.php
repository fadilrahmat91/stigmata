<?php
$id_toko = $_GET['id_toko'];
$alamat = "http://localhost:88/blionia/";

$lokasi_img_asli = "../../../user_image/images/";
$lokasi_img_thumb = "../../../user_image/_thumbs/Images/";

if (!file_exists($lokasi_img_asli.$id_toko)) {
	mkdir($lokasi_img_asli.$id_toko, 0777, true);
}
if (!file_exists($lokasi_img_thumb.$id_toko)) {
	mkdir($lokasi_img_thumb.$id_toko, 0777, true);
}

date_default_timezone_set("Asia/jakarta");

function resize($source_image, $destination, $tn_w, $tn_h, $quality = 100, $wmsource = false)
{
    $info = getimagesize($source_image);
    $imgtype = image_type_to_mime_type($info[2]);

    #assuming the mime type is correct
    switch ($imgtype) {
        case 'image/jpeg':
            $source = imagecreatefromjpeg($source_image);
            break;
        case 'image/gif':
            $source = imagecreatefromgif($source_image);
            break;
        case 'image/png':
            $source = imagecreatefrompng($source_image);
            break;
        default:
            die('Invalid image type.');
    }

    #Figure out the dimensions of the image and the dimensions of the desired thumbnail
    $src_w = imagesx($source);
    $src_h = imagesy($source);


    #Do some math to figure out which way we'll need to crop the image
    #to get it proportional to the new size, then crop or adjust as needed

    $x_ratio = $tn_w / $src_w;
    $y_ratio = $tn_h / $src_h;

    if (($src_w <= $tn_w) && ($src_h <= $tn_h)) {
        $new_w = $src_w;
        $new_h = $src_h;
    } elseif (($x_ratio * $src_h) < $tn_h) {
        $new_h = ceil($x_ratio * $src_h);
        $new_w = $tn_w;
    } else {
        $new_w = ceil($y_ratio * $src_w);
        $new_h = $tn_h;
    }

    $newpic = imagecreatetruecolor(round($new_w), round($new_h));
    imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
    $final = imagecreatetruecolor($tn_w, $tn_h);
    $backgroundColor = imagecolorallocate($final, 255, 255, 255);
    imagefill($final, 0, 0, $backgroundColor);
    //imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);
    imagecopy($final, $newpic, (($tn_w - $new_w)/ 2), (($tn_h - $new_h) / 2), 0, 0, $new_w, $new_h);

    #if we need to add a watermark
    if ($wmsource) 
	{
        #find out what type of image the watermark is
        $info    = getimagesize($wmsource);
        $imgtype = image_type_to_mime_type($info[2]);

        #assuming the mime type is correct
        switch ($imgtype) {
            case 'image/jpeg':
                $watermark = imagecreatefromjpeg($wmsource);
                break;
            case 'image/gif':
                $watermark = imagecreatefromgif($wmsource);
                break;
            case 'image/png':
                $watermark = imagecreatefrompng($wmsource);
                break;
            default:
                die('Invalid watermark type.');
        }

        #if we're adding a watermark, figure out the size of the watermark
        #and then place the watermark image on the bottom right of the image
        $wm_w = imagesx($watermark);
        $wm_h = imagesy($watermark);
        imagecopy($final, $watermark, $tn_w - $wm_w, $tn_h - $wm_h, 0, 0, $tn_w, $tn_h);

    }
    if (imagejpeg($final, $destination, $quality)) 
	{
        return true;
    }
    return false;
}



//upload
if(isset($_GET['upload']))
{
	
	

	if(is_array($_FILES)) 
	{	
		$no=0;
		foreach ($_FILES['userfile']['name'] as $name => $value)
		{
			$no++;
						
			$file_name = $_FILES['userfile']['name'][$name];						
			$file_name = str_replace(".jpg","",$file_name);						
			$file_name = str_replace(".png","",$file_name);						
			$file_name = str_replace(".gif","",$file_name);						
			$file_name = str_replace(".jpeg","",$file_name);						
			$file_name = preg_replace("/[^a-zA-Z0-9]-_/", "", $file_name);
			$nama_foto = $file_name."_".date("ymdhi")."_".$no.".jpg";
			$target_file = $lokasi_img_asli.$id_toko."/".$nama_foto;
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
				$check = getimagesize($_FILES["userfile"]["tmp_name"][$name]);
				if($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}
			}
			// Check file size
			
			if ($_FILES["userfile"]["size"][$name] > 20000000) {
				echo "Sorry, your file is too large.";
				$uploadOk = 0;
			}
			
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["userfile"]["tmp_name"][$name], $target_file)) {
					
					
					//membuat foto kecil------------------------------------------------------//
					resize($lokasi_img_asli.$id_toko."/".$nama_foto, $lokasi_img_asli.$id_toko."/".$nama_foto, 500, 500);
					
					//membuat thumb----------------------------------------------------------//					
					resize($lokasi_img_asli.$id_toko."/".$nama_foto, $lokasi_img_thumb.$id_toko."/".$nama_foto, 150, 150);
					
				} else {
					//copy($no_image, $target_file);
					//echo 0;
				}
			}
			
		}
	}
	echo $nama_foto;
	die();
	
	
	
}else if(isset($_GET['ajaxupload']))
{
	
	die("1");		
}


//----------------------open galery------------------//

//config url
$url = '../../../user_image/images/'.$id_toko.'/';
$id_toko = $_GET['id_toko'];
//set type yang muncul
$arr_ext	= array("jpg","jpeg","png","gif");

$server_link = $alamat.$url;

if(isset($_GET['url']) && !empty($_GET['url'])){
	$url = $_GET['url'];
}else{
	$url = $url;
}


if ($handle = opendir($url)) {
	
	
	$get_img = array();

    while (false !== ($entry = readdir($handle))) {
		
		$ext = pathinfo($entry, PATHINFO_EXTENSION);
		

        if ($entry != "." && $entry != ".." && in_array($ext,$arr_ext)) {

            //echo "$entry";
			$get_img[] = $entry;
			
			
        }
    }

    closedir($handle);
}

?>



<div class='clear'></div>
<div class='browse_gambar_custom'>
<button class='btn btn-danger btn-xs' id='close_galery'>Close</button>
<div class='clear'></div>


<!------------------form upload----------------------------------->

<div class="gallery-bg">
<form id="uploadForm" action="<?php echo dirname($_SERVER['PHP_SELF']) ?>/index.php?upload=image&id_toko=<?php echo $_GET['id_toko']?>" method="post">

<div id="uploadFormLayer">
<div id='loading_upload'></div>	
		<div class="col-sm-3 alert alert-success">
			<input name="userfile[]" id="userfile" type="file" />
			<span id="btn_remove_form" class="glyphicon glyphicon-remove alert-danger" style="position:absolute;right:0px;"></span>
		</div>
		<span id="t4_tambah_form"></span>
		<div id="btn_add_form" class="btn btn-danger"><span class="glyphicon glyphicon-plus-sign"></span></div>
	<div style="clear:both"></div>
	<p><input type="submit" value="Upload" class="btn btn-success" /><p>
	<div style="clear:both"></div>
</div>
</form>
</div>

<script>
//ajax auto upload//
/*
	$(function(){
			
	   new AjaxUpload('#userfile', {
			action: '<?php echo $alamat?>../index.php?ajaxupload=ajaxupload&id_toko=<?php echo $_GET['id_toko']?>',
			onComplete: function(file, response){                   
				alert(response)
				//buka_image_manager();
			}
		});
	});
*/
</script>

<?php
//mengambil satu terahir selesai upload'//
foreach($get_img as $src)
{
	if($src == $_GET['last_img'])
	{
		$image = '
		<div class="img img-rounded" style="position:relative; top:0px; z-index:9999px; border:1px solid red;">
		  <a href="'.$alamat."user_image/images/".$id_toko."/".$src.'">
			<img src="'.$alamat."user_image/images/".$id_toko."/".$src.'" alt="'.$src.'" width="200" height="200">
		  </a>
		  <div class="desc">'.substr($src, 0, 26).'</div>
		</div>';
		
		echo $image;
	}
}


echo '<div class="clear"></div>';


//mengambil img lama//
foreach($get_img as $src)
{
	if($src !== $_GET['last_img'])
	{		
		$image = '
		<div class="img">
		  <a href="'.$alamat."user_image/images/".$id_toko."/".$src.'">
			<img src="'.$alamat."user_image/_thumbs/Images/".$id_toko."/".$src.'" alt="'.$src.'" width="100" height="100">
		  </a>
		  <div class="desc">'.substr($src, 0, 10).'</div>
		</div>';
	
	}
		
	echo $image;
}
echo "<div class='clear'></div>";
echo "</div>";

?>
<script>
function add_img(id,src)
{
	$(".browse_gambar_custom").on("click","div a", function(e){
			var get = $(this).attr("href");
			$("#"+id).attr("value",get);			
			$("#"+src).attr("src",get);
			$(".browse_gambar_custom").fadeOut();
			$('#myModal').modal('hide');
			//alert(get);
		return false;
	});
	
	$("#close_galery").on("click",function(e){
			
			$(".browse_gambar_custom").fadeOut();
			//alert(get);
		return false;
	});

}

var id_img_show = "<?php echo $_GET['id_img_show']?>";
var input_id 	= "<?php echo $_GET['input_id']?>";
add_img(input_id,id_img_show);



//upload//
$(document).ready(function (e) {
	$("#uploadForm").on('submit',(function(e) {			
	
	
		$('#loading_upload').hide().html("Loading...").fadeIn();		
		
		//--------------validasi---------------------------
		var inps = document.getElementsByName('userfile[]');
		for (var i = 0; i <inps.length; i++) 
		{
			var inp=inps[i];
			//alert("userfile["+i+"].value="+inp.value);
			if(inp.value !== "")
			{
				
				var ext = inp.value.split('.').pop().toLowerCase();
				if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
				{
					alert('invalid extension!');
					$('#loading_upload').fadeOut();
					return false;
				}
				
			}
			
		}
		
		//--------------validasi---------------------------//
		
		
		e.preventDefault();
		$.ajax({
        	url: $(this).attr("action"),
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data){
				
				$('#loading_upload').fadeOut();
				//alert(data);
				buka_image_manager(data);
		    },
		  	error: function(){} 	        
	   });
	   
	}));
	
	$("#btn_add_form").click(function(){
		 var add_form = '<div class="col-sm-3 alert alert-success"><input name="userfile[]" id="userfile" type="file" /><span id="btn_remove_form" class="glyphicon glyphicon-remove alert-danger" style="position:absolute;right:0px;"></span></div>';
		 $("#t4_tambah_form").append(add_form);
	})
	
	$("#uploadFormLayer ").on("click","#btn_remove_form",function(){
		$(this).parent().remove();
	});
	
});




</script>


<style>

div.img {
    margin: 5px;
    padding: 5px;
    border: 1px solid #cfb316;
    height: auto;
    width: auto;
    float: left;
    text-align: center;
	background:#fff;
	box-shadow: 5px 5px 3px #373735;
}

div.img img {
    display: inline;
    margin: 5px;
    border: 1px solid #ffffff;
}

div.img a:hover img {
    border:1px solid #cfb316;
}

div.desc {
    text-align: center;
    font-weight: normal;
    width: 120px;
    margin: 5px;
}

.browse_gambar_custom{
	width:100%;
	border:1px solid #d3d3d3;
	border-radius:10px;
	padding:10px;
	background:#aaaaaa;
	color:#000;
	
	height: 390px;
    overflow-y: scroll;
	
}

.clear{
	clear: both;
}

.gallery-bg {width: 100%;background-color: #F9D735;border-radius:4px;}

#uploadFormLayer{padding: 10px;}
.inputFile {padding: 4px;background-color: #FFFFFF;border-radius:4px;}
.txt-subtitle {font-size:1.2em;}
</style>
