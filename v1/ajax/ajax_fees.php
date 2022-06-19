<?php
//get the latest/current/present session
$current_sesh = selectContentDesc($conn, "selection_session", [], "id", 1)[0];

$query = '
  SELECT st.id, CONCAT(st.input_first_name, " ", st.input_last_name) AS name, cl.input_class AS class, tr.input_amount_to_be_paid AS amount, tr.input_transaction_amount AS amount_paid, tr.input_balance AS outstanding, st.hash_id, tt.input_fees_type AS fees_type, ss.input_session AS session, t.input_term AS term, tr.select_session, tr.select_term, tr.select_class, tr.select_fees_type
  FROM transactions AS tr
  INNER JOIN panel_students AS st ON tr.student_id = st.hash_id
  INNER JOIN selection_session AS ss ON tr.select_session = ss.hash_id
  INNER JOIN selection_term AS t ON tr.select_term = t.hash_id
  INNER JOIN selection_class AS cl ON tr.select_class = cl.hash_id
  INNER JOIN selection_fees_type AS tt ON tr.select_fees_type = tt.hash_id
';

//fetch all records without sorting
if(!isset($_POST['sesh']) && !isset($_POST['term']) && !isset($_POST['clas']) && !isset($_POST['fees_type'])){
  $stmt = $conn->prepare($query);
  $stmt->bindParam(":s", $current_sesh['hash_id']);
  $stmt->execute();
  // $result = $statement->fetch(PDO::FETCH_ASSOC);
}



//sorting record with session, term, class, fees_type
if(isset($_POST['sesh']) && isset($_POST['term']) && isset($_POST['clas']) && isset($_POST['fees_type'])){
    // var_dump($_POST);
    $term_q = $_POST['term'] != "" ? "AND tr.select_term = :tt" : "";
    $clas_q = $_POST['clas'] != "" ? "AND tr.select_class = :cl" : "";
    $fees_q = $_POST['fees_type'] != "" ? "AND tr.select_fees_type = :ft" : "";
    $filter_query = $query . " WHERE tr.select_session = :ss {$term_q} {$clas_q} {$fees_q}";

  //if POST['sesh'] is not sent by user from front end use the current session of the school to query db
  $_POST['sesh'] = $_POST['sesh'] != "" ? $_POST['sesh'] : $current_sesh['hash_id'];

  $stmt = $conn->prepare($filter_query);
  $stmt->bindParam(":ss", $_POST['sesh']);
  if($_POST['term'] != ""){
    $stmt->bindParam(":tt", $_POST['term']);
  }
  if($_POST['clas'] != ""){
    $stmt->bindParam(":cl", $_POST['clas']);
  }
  if($_POST['fees_type'] != ""){
    $stmt->bindParam(":ft", $_POST['fees_type']);
  }
  // var_dump($stmt);
  $stmt->execute();

// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$result = [];
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  extract($row);
  $res = [
    "id" => $id,
    "hash_id" => $hash_id,
    "name" => $name,
    "st_class" => $class,
    "amount" => $amount,
    "amount_paid" => $amount_paid,
    "outstanding" => $outstanding,
    "fees_type" => $fees_type,
    "tr_session" => $session,
    "term" => $term,

  ];

  array_push($result, $res);
}

echo json_encode($result);

 ?>
