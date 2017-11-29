<br>
<div class="alert alert-info">
<?php
//post
$id_bank			= $_POST['nama_bank'];
$id_confirmasi 		= $_POST['id_confirmasi'];
$atas_nama_pengirim = $_POST['atas_nama_pengirim'];
$jumlah_transfer	= hanya_nomor($_POST['jumlah_transfer']);
$url_image			= $id_confirmasi.".jpg";


//pengaturan gambar
$target_dir = "user_image/bukti_transfer/";
$target_file = $target_dir . $id_confirmasi.".jpg";
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$image_post = $_FILES["file_bukti_transfer"]["tmp_name"];
// Check if image file is a actual image or fake image
if(isset($_POST["submit"]) && isset($_FILES["file_bukti_transfer"])) {
    $check = getimagesize($_FILES["file_bukti_transfer"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {        
		echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["file_bukti_transfer"]["size"] > 2000000) {
    echo "Maaf.. file terlalu besar.. ".$_FILES["file_bukti_transfer"]["size"];
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
	 echo "<br>Sorry, there was an error uploading your file..[null]";	 
	die();
// if everything is ok, try to upload file
} else {
	//set ukuran gambar 
	$width=800;
	$size=GetimageSize($image_post);
	$height=round($width*$size[1]/$size[0]);
	$images_orig = ImageCreateFromJPEG($image_post);
	$photoX = ImagesX($images_orig);
	$photoY = ImagesY($images_orig);
	$images_fin = ImageCreateTrueColor($width, $height);
	ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
	ImageJPEG($images_fin,$target_file);
	ImageDestroy($images_orig);
	ImageDestroy($images_fin);
	        
	//simpan ke database bukti pembayaran
	$cek = $db->query("SELECT id_confirmasi FROM tbl_bukti_transfer WHERE id_confirmasi='$id_confirmasi'");
	if(mysqli_num_rows($cek)>0){
		$db->query("UPDATE tbl_bukti_transfer SET id_confirmasi='$id_confirmasi', url_image='$url_image', jumlah_transfer='$jumlah_transfer', atas_nama_pengirim='$atas_nama_pengirim', id_bank='$id_bank' WHERE id_confirmasi='$id_confirmasi'");	
	}else{
		$db->query("INSERT INTO tbl_bukti_transfer SET id_confirmasi='$id_confirmasi', url_image='$url_image', jumlah_transfer='$jumlah_transfer', atas_nama_pengirim='$atas_nama_pengirim', id_bank='$id_bank'");	
	}
	echo "<strong>Terimakasih..!!</strong> Konfirmasi anda akan segera kami tindak lanjuti, Terimakasih telah memberi kepercayaan kepada homesmart.co.id";
	
	
}

?>
</div>
<div style="clear:both"></div>


<?php
die();
?>