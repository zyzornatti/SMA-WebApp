<?php

 // $sesh = selectContent($conn, "selection_session", []);
$query = "SELECT hash_id, input_session FROM selection_session";
$stmt = $conn->prepare($query);
$stmt->execute();
$sesh = [];
// $sesh['data'] = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  $res = [
    "hash_id" => $row['hash_id'],
    "input_session" => $row['input_session']
  ];

  array_push($sesh, $res);
}

echo json_encode($sesh);
 ?>
