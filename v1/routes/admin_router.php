<?php
$uri = explode("/",$_SERVER['REQUEST_URI']);

if (count($uri) > 2) {

//   if (!empty($_GET)) {
//   $query_str = explode("?",$uri[2])[1];
// }else{
//   $query_str = "";
// }
  $query_string = explode("/", $uri[2])[0];

  switch ($uri[1]."/".$uri[2]) {

    case 'create/'.$query_string:
    include APP_PATH."/admin/create_all.php";
    break;

    case 'manage/'.$query_string:
    include APP_PATH."/admin/read_all.php";
    break;

    // case 'read/'.$query_string:
    // include APP_PATH."/admin/read_it.php";
    // break;

    case 'fees/'.$query_string:
    include APP_PATH."/admin/fees_record.php";
    break;

    // fees/student?
    // case 'fees/'.$query_string.'?'.$query_str:
    // include APP_PATH."/admin/fees_record.php";
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

    case 'dashboard':
    include APP_PATH."/admin/dashboard.php";
    break;

    case 'students':
    include APP_PATH."/admin/students.php";
    break;

    case 'edit?'.$query_string:
    include APP_PATH."/admin/update_all.php";
    break;

    case 'delete?'.$query_string:
    include APP_PATH."/admin/delete_all.php";
    break;




  }

}










 ?>
