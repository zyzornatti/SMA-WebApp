<?php
$pg = explode("?", $uri[1]);
$pag = explode("=", $pg[1]);
$page = $pag[0];

if(isset($_GET[$page])){
  $hash_id = $_GET[$page];
  $tab = new TableRecord;
  $tab->conn = $conn;
  $tab->checker = "create";
  $tab->page = $page;
  $tab->where = ['hash_id'=>$hash_id];
  $tab->delete_record();

  $_SESSION['msg'] = ucfirst($page)." Deleted Successfully";
  header("Location: /manage/$page");

}else{
  header("Location: /dashboard");
}



 ?>
