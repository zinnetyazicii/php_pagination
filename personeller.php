<?php
if(!isset($_SESSION)){
	session_start();
	include($_SERVER['DOCUMENT_ROOT'].'/inc/cfg.php');
	include($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
}


if(yetki_kontrol(@$_SESSION["rol"],"pl")){
$sql="SELECT * FROM personel,firma where personel.fir_id=firma.fir_id and personel.aktif=1 order by ad asc";
$query = $db->query($sql, PDO::FETCH_ASSOC);
if ( $query->rowCount() ){
  $sayfada=10;
  $toplam_satir=$query->rowCount();
 
  $toplam_sayfa=ceil($toplam_satir/$sayfada); //ceil yukarı yuvarlar
  
  //$sayfa = isset($_GET['s'])?(int) $_GET['s'] : 1; //urlden gelen sayfa değeri var ise o değeri, yok ise 1 değeri veriyoruz.
  $sayfa = isset($param[2])?(int) $param[2] : 1; //urlden gelen sayfa değeri var ise o değeri, yok ise 1 değeri veriyoruz.

  
   print_r($sayfa);
  if($sayfa<1) $sayfa=1;
  if($sayfa>$toplam_sayfa) $sayfa=$toplam_sayfa;
  
  $limit=($sayfa-1) *$sayfada;
  
 $sql="SELECT * FROM personel,firma where personel.fir_id=firma.fir_id and personel.aktif=1 order by ad asc LIMIT $limit,$sayfada";
$query = $db->query($sql, PDO::FETCH_ASSOC);
  
  ?>

<div class="input-group">
  <input type="text" style="border:2px solid black;" id="personeller" name="uname" autocomplete="off">
  <span class="input-group-text" style="background-color:#04508c;color:white;"><i class=" fa fa-search"></i></span>
</div>

<table class="table table-striped table-bordered table-sm" id="personeltable">
  <thead style=" ">
    <tr>
      <th scope="col"><input type="text" class="filtertable" id="0" style="width:120px" name="uname0" autocomplete="off"><br><a href="javascript:void(0)" style="color:white;">KART ID</a></th>
      <th scope="col"><input type="text" class="filtertable" id="1" style="width:120px" name="uname1" autocomplete="off"><br><a href="javascript:void(0)"style="color:white;">TC</a></th>
      <th scope="col"><input type="text" class="filtertable" id="2" style="width:120px" name="uname2" autocomplete="off"><br><a href="javascript:void(0)"style="color:white;">AD</a></th>
      <th scope="col"><input type="text" class="filtertable" id="3" style="width:120px" name="uname3" autocomplete="off"><br><a href="javascript:void(0)"style="color:white;">SOYAD</a></th>
      <th scope="col"><input type="text" class="filtertable" id="4" style="width:120px" name="uname4" autocomplete="off"><br><a href="javascript:void(0)"style="color:white;">BABA ADI</a></th>
	  <th scope="col"><input type="text" class="filtertable" id="5" style="width:120px" name="uname5" autocomplete="off"><br><a href="javascript:void(0)"style="color:white;">TUTAR</a></th>
      <th scope="col"><input type="text" class="filtertable" id="6" style="width:120px" name="uname6" autocomplete="off"><br><a href="javascript:void(0)"style="color:white;">FİRMA</a></th>
      <th scope="col"><input type="text" class="filtertable" id="7" style="width:120px" name="uname7" autocomplete="off"><br><a href="javascript:void(0)"style="color:white;">İŞLEM</a></th>
    </tr>
  </thead>
  <tbody>
  <?php
  foreach( $query as $row ){
  ?>
    <tr>
      <td><?php echo $row["kart_id"]; ?></td>
	  <td><?php echo $row["tc"]; ?></td>
      <td><?php echo $row["ad"]; ?></td>
      <td><?php echo $row["soyad"]; ?></td>
      <td><?php echo $row["baba_adi"]; ?></td>
	  <td><?php echo $row["kumanya_tutari"]; ?></td>  
      <td><?php echo $row["firma_adi"]; ?></td>
	   
      <td>
	 
	  <?php if(yetki_kontrol(@$_SESSION["rol"],"pg") ){ ?>
	  <a href="<?php echo $url.'/personelguncelle/'.$row["pers_id"]; ?>" ><span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Personel güncelle"><i class="fas fa-cog" style="margin-right : 15px;"></i></span></a>
	  <?php } ?>
	  <?php if(yetki_kontrol(@$_SESSION["rol"],"kue")){ ?>
	  <a href="<?php echo $url.'/tekkumanyaekle/'.$row["pers_id"]; ?>"><span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Kumanya ekle"><i class="fas fa-cart-plus" style="margin-right : 15px;"></i></span></a>
	  <?php } ?>
	  <?php if(yetki_kontrol(@$_SESSION["rol"],"kul") ){ ?>	  
	  <a href="javascript:void(0)" onclick="kumanyagetirbutton(<?php echo "'".$row["ad"]."','".$row["soyad"]."','".$row["baba_adi"]."'"; ?>)"><span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Kumanyasını göster"><i class="far fa-eye" style="margin-right : 15px;"></i></span></a>
	  <?php } ?>
	  <?php if(yetki_kontrol(@$_SESSION["rol"],"ps") ){ ?>	  
	  <a href="javascript:void(0)" onclick="perssilbuton(<?php echo $row["pers_id"]; ?>)" id="perssilbuton"><span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Personeli sil"><i class="fas fa-trash-alt"></i></span></a>
	  <?php } ?>
	  </td>
	</tr>
	<?php
	} }
	?>
  </tbody>
</table>

<div align="right" class="col-md-12"

<?php
$s=0;
while($s<$toplam_sayfa){
	$s++;	
	?>
	
	<a href="/personeller/<?php echo $s; ?>"><?php echo $s?></a>
	<?php
}

?>


<script src="<?php echo $url; ?>/js/merih.js"></script>
<script src="<?php echo $url; ?>/js/zimer.js"></script>
<?php
}
?>
