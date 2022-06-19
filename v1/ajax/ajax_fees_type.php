<?php

 // $fees_type = selectContent($conn, "selection_fees_type", []);
$query = "SELECT hash_id, input_fees_type FROM selection_fees_type";
$stmt = $conn->prepare($query);
$stmt->execute();
$fees_type = [];
// $fees_type['data'] = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  $res = [
    "hash_id" => $row['hash_id'],
    "fees_type" => $row['input_fees_type']
  ];

  array_push($fees_type, $res);
}

echo json_encode($fees_type);
 ?>
