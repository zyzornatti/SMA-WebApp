<?php
$uri = explode("/",$_SERVER['REQUEST_URI']);


if (count($uri) > 2) {

  if (!empty($_GET)) {
  $query_string = explode("?",$uri[2])[1];
}else{
  $query_string = "";
}

  switch ($uri[1]."/".$uri[2]) {

  }

}else{
  if (!empty($_GET)) {
  $query_string = explode("?",$uri[1])[1];
}else{
  $query_string = "";
}
  // $query_string = explode("?",$uri[1])[1];
  switch ($uri[1]) {
    case 'test':
    include APP_PATH."/admin/test.php";
    break;

    case 'test?'.$query_string:
    include APP_PATH."/admin/test.php";
    break;

    case '':
    include APP_PATH."/views/home.php";
    break;

    case 'home':
    include APP_PATH."/views/home.php";
    break;


  }

}






 ?>
