<?php

if(isset($_GET['token'])){

$stmt = $conn->prepare("SELECT * FROM verify WHERE token=:tk");
$data = [
  ":tk"=> $_GET['token']
];
$stmt->execute($data);
if($stmt->rowCount() < 1){
    die("error");
}else{

  $row = $stmt->fetch(PDO::FETCH_BOTH);
  // extract($row);
  $hash_id = $row['input_email'];


  $whereHash_id['hash_id'] = $hash_id;
  $userinfo = selectContent($conn, 'admin', $whereHash_id);

  $stmt = $conn->prepare("UPDATE admin SET verification=:vs,admin_status=:us WHERE input_email=:gid");
  $ver = 1;
  $status = 1;
  $stmt->bindParam(":gid",$hash_id);
  $stmt->bindParam(":vs",$ver);
  $stmt->bindParam(":us",$status);
  $stmt->execute();


  $stmt2 = $conn->prepare("DELETE FROM verify WHERE token=:tk");
  $stmt2->execute($data);
  $_SESSION['id'] = $hash_id;
  header("Location: /dashboard");
}

}else{
  die("error");
}


 ?>
