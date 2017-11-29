<?php 
class BlioniaClass
{
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function hitNewProduct() {
        $row = $this->db->query("SELECT COUNT(admin_check) AS jumlah_uncheck FROM tbl_barang WHERE admin_check='0'")->fetch_array();
        return $row["jumlah_uncheck"];
    }

	public function hitNewKontak() {
        $row = $this->db->query("SELECT COUNT(id_kontak) AS jumlah_kontak FROM tbl_kontak WHERE status='0'")->fetch_array();
        return $row["jumlah_kontak"];
    }
	public function hitNewConfirmasi() {
        
		$row = $this->db->query("SELECT id_confirmasi FROM tbl_confirmasi WHERE status_confirmasi='0' GROUP BY id_confirmasi");
		
		return mysqli_num_rows($row);
    }
	
	public function hitNewKonsumen() {
        
		$row = $this->db->query("SELECT id_pelanggan FROM tbl_pelanggan WHERE admin_cek='0'");
		
		return mysqli_num_rows($row);
    }
	
	public function hitNewBankConfirmasi() {
        
		$row = $this->db->query("SELECT id_confirmasi FROM tbl_bukti_transfer WHERE admin_cek='0'");
		
		return mysqli_num_rows($row);
    }
	
    public function HargaPoin() {

        $row = $this->db->query("SELECT nilai_jual, nilai_tukar FROM tbl_harga_poin WHERE id_harga_poin='B1P2015'")->fetch_array();
        			
		return $row;
		
    }
	
	public function infoHargaPoin() {

        $row = $this->db->query("SELECT * FROM tbl_ket_poin")->fetch_object();
        			
		return $row;
		
    }
	
	public function profilkonsumen($id_pelanggan) {

        $row = $this->db->query("SELECT a.*, b.id_prov, b.nama AS nama_provinsi, c.id_kab, c.nama AS nama_kabupaten, d.id_kec, d.nama AS nama_kecamatan, e.id_kel, e.nama AS nama_kelurahan
							FROM tbl_pelanggan a
							LEFT JOIN daerah_provinsi b ON a.id_prov = b.id_prov
							LEFT JOIN daerah_kabupaten c ON a.id_kab = c.id_kab
							LEFT JOIN daerah_kecamatan d ON a.id_kec = d.id_kec
							LEFT JOIN daerah_kelurahan e ON a.id_kel = e.id_kel
							WHERE a.id_pelanggan ='$id_pelanggan'")->fetch_object();
        			
		return $row;
		
    }
	
	public function allKategori() {
		$get = array();
        $row = $this->db->query("SELECT nama_kategori FROM tbl_kategori");
		
		while($data = $row->fetch_object())
		{
			$get[] = $data->nama_kategori;
		}
        			
		return $get;
		
    }
	
	public function detailsProduct($id_barang) {

        $q = $this->db->query("SELECT a.*,
										b.nama_kategori,
										c.nama_brand
										
									FROM tbl_barang a
									INNER JOIN tbl_kategori b ON a.id_kategori=b.id_kategori
									INNER JOIN tbl_brand c ON a.id_brand=c.id_brand
									
									WHERE id_barang = '$id_barang' AND status_barang='1'
								");
		if(mysqli_num_rows($q)>0)
		{
			$row = $q->fetch_object();
			
		}else{
			$row = "404";
		}
		
		return $row;
        
		
		
    }

	public function brand($id_brand) {

        $brand = $this->db->query("SELECT id_brand, nama_brand FROM tbl_brand WHERE id_brand='$id_brand'")->fetch_object();
        			
		return $brand;
		
    }
	
	public function kategori($id_kategori) {

       $nama_kat = $this->db->query("SELECT id_kategori, nama_kategori FROM tbl_kategori WHERE id_kategori='$id_kategori'")->fetch_object();
        			
		return $nama_kat;
		
    }
	
	public function page($page_id) {

       $page = $this->db->query("SELECT * FROM tbl_page WHERE page_id='$page_id'")->fetch_object();
        			
		return $page;
		
    }
	
	public function sub_page($id_sub_page) {

       $page = $this->db->query("SELECT * FROM tbl_sub_page WHERE id_sub_page='$id_sub_page'")->fetch_object();
        			
		return $page;
		
    }
	
	
	public function gambarArray($id_barang,$limit=null)
	{
		//-------------------gambar------------------------//
		if($limit===null)
		{
			$qg= $this->db->query("SELECT url_images FROM tbl_images_barang WHERE id_barang='$id_barang' AND url_images<>''");
		}else{
			$qg= $this->db->query("SELECT url_images FROM tbl_images_barang WHERE id_barang='$id_barang' AND url_images<>'' LIMIT $limit");
		}
		
		$img = array();
		
		while($gmr =$qg->fetch_object())
		{
			
			$img[]=$gmr->url_images;
		}
		return ($img);
	}
	
	
	//banner
	
	public function banner() {

		$data = $this->db->query("SELECT * FROM tbl_banner LIMIT 1")->fetch_object();
				
		return $data;
		
    }
	
	
	//********************************member*************************************//
	
	public function member($id_pelanggan) {

		$data = $this->db->query("SELECT * FROM tbl_pelanggan WHERE id_pelanggan='$id_pelanggan'")->fetch_object();
				
		return $data;
		
    }
	
	public function member_confirm($id_pelanggan) {
		$get = array();
		$rowSet = $this->db->query("SELECT a.*, b.nama_pelanggan, b.id_pelanggan ,c.resi_shipping,d.nama_shipping,d.id_shipping
								FROM tbl_confirmasi a 
								INNER JOIN tbl_pelanggan b ON a.id_pelanggan = b.id_pelanggan 
								LEFT JOIN tbl_final_confirmasi c ON a.id_confirmasi = c.id_confirmasi 		
								LEFT JOIN tbl_shipping d ON c.id_shipping = d.id_shipping 								
								WHERE b.id_pelanggan='$id_pelanggan' AND YEAR(a.tgl_confirmasi) = YEAR(CURDATE())
								GROUP BY a.id_confirmasi 								
								ORDER BY a.status_confirmasi ASC, a.id_uniq DESC LIMIT 10							
								");  	 		 
	
	
		while($data = $rowSet->fetch_object())
		{
			$get[] = $data;
		}
        			
		return $get;
		
	}

	
}

function no_image()
{
	return 'no_image.jpg';
}

function link_member()
{
	 return "member.php";
	 //return "/member.aspx";
}

function ambil_nama_kat($db,$id_kat)
{
	$kat = explode(",",$id_kat);
	$id  = $kat[0];
	$nama_kat = $db->query("SELECT nama_kategori FROM tbl_kategori WHERE id_kategori='$id'")->fetch_object();
	
	return $nama_kat->nama_kategori;
}


 function menu_link($link)
 {
	 return $link.".php";
	 //return $link.".aspx";
 }
 

function link_detail($id_barang,$kategori,$link)
{
	return "details.php?id_barang=".$id_barang."&kategori=".buat_link($kategori)."&link=".buat_link($link);
	//return "/detail/".$id_barang."/".buat_link($kategori)."/".buat_link($link);
}

function link_kategori($id_kategori,$nama_kategori)
{
	return "kategori.php?id_kategori=".$id_kategori."&nama_kategori=".buat_link($nama_kategori);
	//return "/kategori/".$id_kategori."/".buat_link($nama_kategori);
	
}



function link_sub_kategori($id_sub_kategori,$nama_sub_kategori)
{
	//return "#";
	return "sub_kategori.php?id_sub_kategori=".$id_sub_kategori."&nama_sub_kategori=".buat_link($nama_sub_kategori);
	//return "/kategori/".$id_kategori."/".buat_link($nama_kategori);
	
}

function link_brand($id_brand,$nama_brand)
{
	return "brand.php?id_brand=".$id_brand."&nama_brand=".buat_link($nama_brand);
	//return "/brand/".$id_brand."/".buat_link($nama_brand);
	
}

function link_toko($id_toko,$nama_toko)
{
	return "toko.php?id_toko=".$id_toko."&nama_toko=".buat_link($nama_toko);
	//return "/toko/".$id_toko."/".buat_link($nama_toko);
	
}

function link_page($page_id,$page_judul)
{
	return "page.php?page_id=".$page_id."&page_judul=".buat_link($page_judul);
	//return "/page/".$page_id."/".buat_link($page_judul);
}

function link_sub_page($id_sub_page,$nama_sub_page)
{
	
	return "sub_page.php?id_sub_page=".$id_sub_page."&nama_sub_page=".buat_link($nama_sub_page);
	//return "/page/".$page_id."/".buat_link($page_judul);
}

function link_cari($term)
{
	return "cari.php?term=".$term;
	//return "cari.aspx?term=".$term;
	
}

function link_kasir($id_barang,$harga,$stok_barang)
{
	return "kasir.php?by_produk_id=$id_barang&harga_barang=$harga&stok_barang=$stok_barang&save_to_keranjang";
	
}
function potong($isinya, $jumlah=50){
 if(strlen($isinya) > $jumlah) 
 $isinya = substr($isinya, 0, $jumlah).'...';
 $isinya = htmlentities($isinya);
 return $isinya;
}

function buat_link($text)
{ 
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
  $text = trim($text, '-');
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  $text = strtolower($text);
  $text = preg_replace('~[^-\w]+~', '', $text);
  if (empty($text))
  {
    return 'n-a';
  }
  return $text;
}



function hanya_nomor($string) 
{
    return preg_replace('/\D/', '', $string);
}
function rupiah($nilai, $pecahan = 0) 
{
    return number_format($nilai, $pecahan, ',', '.');
}

function buang_single_quote($string)
{
	return str_replace("'","`",$string);
}


function tanggalindo($tanggal)
{
$taketgl = substr($tanggal, 0,10);
$tahun = substr($taketgl, 0,4);
$bulan = substr($taketgl, 5,2);
$tanggal = substr($taketgl, 8,2);

if($bulan=="01") $bulan = "Januari";
if($bulan=="02") $bulan = "Februari";
if($bulan=="03") $bulan = "Maret";
if($bulan=="04") $bulan = "April";
if($bulan=="05") $bulan = "Mei";
if($bulan=="06") $bulan = "Juni";
if($bulan=="07") $bulan = "Juli";
if($bulan=="08") $bulan = "Agustus";
if($bulan=="09") $bulan = "September";
if($bulan=="10") $bulan = "Oktober";
if($bulan=="11") $bulan = "November";
if($bulan=="12") $bulan = "Desember";

$tgl = $tanggal." ".$bulan." ".$tahun;

return $tgl;
}

function bulanindo($bulan)
{
if($bulan=="01") $bulan = "Januari";
if($bulan=="02") $bulan = "Februari";
if($bulan=="03") $bulan = "Maret";
if($bulan=="04") $bulan = "April";
if($bulan=="05") $bulan = "Mei";
if($bulan=="06") $bulan = "Juni";
if($bulan=="07") $bulan = "Juli";
if($bulan=="08") $bulan = "Agustus";
if($bulan=="09") $bulan = "September";
if($bulan=="10") $bulan = "Oktober";
if($bulan=="11") $bulan = "November";
if($bulan=="12") $bulan = "Desember";
return $bulan;
}

function diskon($harga_coret, $harga_barang)
{
	
	$untung = $harga_barang-$harga_coret;
	$persen = ($untung/$harga_coret)*(100/100);
	return $off = (number_format($persen,2)*100)." %";
	//return $persen;

}



function session_sementara(){
	
	$ua	= dapat_browser();
	$ub = $ua['name'] ."-". $ua['version'].''.$ua['userAgent']."-".date('Ymdhis');
	return base64_encode($ub);
	
}

function id_confirmasi($id)
{
	$data = "SH".date("ymdhis")."_".$id;
	
	return $data;
}


function dapat_browser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
   
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
   
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        
    }
    
    $i = count($matches['browser']);
    if ($i != 1) {
       
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
   
    
    if ($version==null || $version=="") {$version="?";}
   
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}




function buat_random($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function hit_hari($tgl)
{
	$now   		= strtotime(date("Y-m-d"));
	$start  	= strtotime($tgl);
	$datediff 	= $now - $start;
	$lamanya 	= floor($datediff/(60*60*24));
	return $lamanya;
}

function ukuran($string)
{
	$jadi = preg_replace("/[^0-9,.]/", "", $string);
	$jadi = str_replace(",", ".", $jadi);
	return $jadi;

}


function isMobile()
{
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	return preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4));
}


function ambil_thumbs($url)
{		
	if(strpos($url, 'user_image') !== false) {
	 	$url_images = explode("user_image",$url);
		$get_images = str_replace("/images/","user_image/_thumbs/Images/",$url_images[1]);	
			
		return $url_images[0].$get_images;
	} else {
		return $url;
	}

}


function anti_inject($des)
{
	$a = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($des))))));
	return  preg_replace("/&#?[a-z0-9]{2,8};/i","",$a);
}



##captcha##
function randomnya($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
function captcha($banyak = 10){
$rand = randomnya($banyak);
$captcha="<script type='text/javascript' src='jquery-1.10.2.min.js'></script>
<script>
$(document).ready(function(){
		$('#submit').attr('disabled', true);
		$( '#captcha' ).keyup(function() {
			var captcha = $('#captcha').val();
		    var c1 = '".$rand."';
				if(captcha !== c1){			      
				  	$('#test_captcha').html('<img src=http://s22.postimg.org/5axggip0d/warning.gif height=18px>');
					}else{
					$('#test_captcha').html('<img src=http://s10.postimg.org/47u3rn7xh/true.gif height=18px>');
						var styles = {
						  backgroundColor : '#ddd',
						  fontWeight: '',
						};

					$('#captcha').css(styles);
					$('#captcha').attr('readonly', 'readonly');
					$('#submit').removeAttr('disabled');
					$('#submit').addClass('button');
					}
		});
		$('.reload').click(function(){
			$('#captcha').val('');
		});	
});
</script>
<style>
#isi_c1{color:#800080;font-size: 24px;font-family: comic sans ms,cursive;background-color:#e6e6fa;width:150px;}
#submit{width:150px;}
#captcha{width:150px;}
</style>
	<div id='semua'>
	<div id='isi_c1'>$rand<span > <img src='http://s23.postimg.org/cveu83u0n/reload.png' class='reload' align='right'></span></div>
	<input type='text' name='captcha'  class='pendek' id='captcha' required><span class='' id='test_captcha'></span>
    <br>
	<br>
	<input type='submit' name='submit' value='Submit' id='submit'   >
	</div>";
return $captcha;
}


?>