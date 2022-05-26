<?php

function LoginAdmin($dbconn, $email, $pword){
  $rec = selectContent($dbconn, "admin", ["input_email"=> $email]);

  if(count($rec) != 1 || !password_verify($pword, $rec[0]['input_password'])){
    $suc = 'Invalid Email or Password';
    $message = preg_replace('/\s+/', '_', $suc);
    header("Location:login?err=$message");

  }else{

    if($rec[0]['verification'] !== "1"){
      $suc = 'Dear '.ucwords($rec[0]['input_firstname']).', You have not been verified, kindly visit your email for verification link';
      $message = preg_replace('/\s+/', '_', $suc);
      header("Location:login?wn=$message");
      die;
    }

    $_SESSION['admin'] = $rec[0]['hash_id'];
    header("Location: /dashboard");
  }
}

function RegisterAdmin($dbconn, $input){
  try{
  $rnd = rand(0000000000,9999999999);
  $split = $input['input_firstname'];
  $id = $rnd.cleans($split);
  $hash_id = time().str_shuffle($id);
  $verify = 0;
  $ad_status = 0;

  $hash = password_hash($input['input_password'], PASSWORD_BCRYPT);
  #insert data
  $stmt = $dbconn->prepare("INSERT INTO admin(hash_id,input_firstname,input_lastname,input_email,input_password,verification,admin_status,time_created,date_created) VALUES(:hid,:fn,:ln,:em,:pw,:vf,:as,NOW(),NOW())");
  #bind params...
  $data = [
    ':hid' => $hash_id,
    ':fn' => $input['input_firstname'],
    ':ln' => $input['input_lastname'],
    ':em' => $input['input_email'],
    ':pw' => $hash,
    ':vf' => $verify,
    ':as' => $ad_status
];
$stmt->execute($data);

$result = [];
$token_s = 0;
$ran = rand(0000000000,999999999);
$tim = time();
$process = $ran."TmADashboardVerification".$hash_id;
$token = $tim."_".str_shuffle($process);


$updatever = $dbconn->prepare("INSERT INTO verify VALUES(NULL,:em,:tk,:tks,:en)");
$data2 = [
  ':em' => $hash_id,
  ':tk' => $token,
  ':tks' => $token_s,
  ':en' => $input['input_email']
];
$updatever->execute($data2);
$result[] = $token;
return $result;

}catch(PDOException $e){
  die($e->getMessage());

  }
}

 ?>
