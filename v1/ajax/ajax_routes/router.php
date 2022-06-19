<?php
$uri = explode("/",$_SERVER['REQUEST_URI']);

if (count($uri) > 2) {

//   if (!empty($_GET)) {
//   $query_string = explode("?",$uri[2])[1];
// }else{
//   $query_string = "";
// }
  $query_string = explode("/", $uri[2])[0];

  switch ($uri[1]."/".$uri[2]) {

    // case 'create/'.$query_string:
    // include APP_PATH."/views/admin/create_all.php";
    // break;
    //
    // case 'manage/'.$query_string:
    // include APP_PATH."/views/admin/manage_all.php";
    // break;

    // case 'edit/'.$query_string:
    // include APP_PATH."/views/admin/edit_all.php";
    // break;

  }

}else{
  if (!empty($_GET)) {
  $query_string = explode("?",$uri[1])[1];
}else{
  $query_string = "";
}
  // $query_string = explode("?",$uri[1])[1];
  switch ($uri[1]) {

    case 'ajax_test':
    include APP_PATH."/ajax/test.php";
    break;

    case 'fetch_session':
    include APP_PATH."/ajax/ajax_session.php";
    break;

    case 'fetch_term':
    include APP_PATH."/ajax/ajax_term.php";
    break;

    case 'fetch_class':
    include APP_PATH."/ajax/ajax_class.php";
    break;

    case 'fetch_fees_type':
    include APP_PATH."/ajax/ajax_fees_type.php";
    break;

    case 'fetch_fees':
    include APP_PATH."/ajax/ajax_fees.php";
    break;




  }

}










 ?>
