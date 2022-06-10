<?php

 // $class = selectContent($conn, "selection_class", []);
$query = "SELECT hash_id, input_class FROM selection_class";
$stmt = $conn->prepare($query);
$stmt->execute();
$class = [];
// $class['data'] = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  $res = [
    "hash_id" => $row['hash_id'],
    "class" => $row['input_class']
  ];

  array_push($class, $res);
}

echo json_encode($class);
 ?>
