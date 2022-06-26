<?php

$query = '
  SELECT st.id, st.hash_id, st.input_first_name, st.input_last_name, st.input_email, g.input_gender, st.input_phone_number, st.input_nationality, st.admission_number, r.input_religion, c.input_class, st.input_address, st.input_guardian, st.image_1, st.date_created, st.time_created FROM panel_students AS st
  INNER JOIN selection_gender AS g ON st.select_gender = g.hash_id
  INNER JOIN selection_religion AS r ON st.select_religion = r.hash_id
  INNER JOIN selection_class AS c ON st.select_class = c.hash_id

';

if(isset ($_POST['clas'])){
  $filter_query = $query . " WHERE st.select_class = :cl";
  $stmt = $conn->prepare($filter_query);
  $stmt->bindParam(":cl", $_POST['clas']);
  $stmt->execute();

}else{
  
  $stmt = $conn->prepare($query);
  $stmt->execute();
}


$results = [];

while($row = $stmt->fetch(PDO::FETCH_BOTH)){
  $res = [
    "id" => $row['id'],
    "hash_id" => $row['hash_id'],
    "name" => $row['input_first_name']." ".$row['input_last_name'],
    "email" => $row['input_email'],
    "gender" => $row['input_gender'],
    "phone_number" => $row['input_phone_number'],
    "nationality" => $row['input_nationality'],
    "admission_num" => $row['admission_number'],
    "religion" => $row['input_religion'],
    "class" => $row['input_class'],
    "address" => $row['input_address'],
    "guardian" => $row['input_guardian'],
    "image" => $row['image_1'],
    "date" => $row['date_created'],
    "time" => $row['time_created']
  ];

  array_push($results, $res);
}

echo json_encode($results);



 ?>
