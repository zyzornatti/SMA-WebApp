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

    case 'register':
    include APP_PATH."/auth/signup.php";
    break;

    case 'login':
    include APP_PATH."/auth/login.php";
    break;

    case 'login?'.$query_string:
    include APP_PATH."/auth/login.php";
    break;

    case 'logout':
    include APP_PATH."/auth/logout.php";
    break;


  }

}

 ?>
