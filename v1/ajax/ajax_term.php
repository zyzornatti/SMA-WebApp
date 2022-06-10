<?php

// $term = selectContent($conn, "selection_term", []);
$query = "SELECT hash_id, input_term FROM selection_term";
$stmt = $conn->prepare($query);
$stmt->execute();
$term = [];
// $term['data'] = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  $res = [
    "hash_id" => $row['hash_id'],
    "term" => $row['input_term']
  ];

  array_push($term, $res);
}

echo json_encode($term);
 ?>
