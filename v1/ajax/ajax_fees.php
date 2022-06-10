<?php

$query = '
  SELECT st.id, CONCAT(st.input_first_name, " ", st.input_last_name) AS name, cl.input_class AS class, tr.input_amount_to_be_paid AS amount, tr.input_transaction_amount AS amount_paid, tr.input_balance AS outstanding, st.hash_id, tt.input_fees_section AS fee_type, ss.input_session AS session, t.input_term AS term
  FROM panel_students AS st
  INNER JOIN transactions AS tr ON st.hash_id = tr.student_id
  INNER JOIN selection_fees_type AS tt ON tr.select_transaction_type = tt.hash_id
  INNER JOIN selection_session AS ss ON tr.select_session = ss.hash_id
  INNER JOIN selection_term AS t ON tr.select_term = t.hash_id
  INNER JOIN selection_class AS cl ON tr.select_class = cl.hash_id
';

//fetch all records without sorting
if(!isset ($_POST['sesh']) && !isset($_POST['term']) && !isset($_POST['class'])){
  $stmt = $conn->prepare($query);
  $stmt->execute();
}

//sorting record with session nd term
if(isset ($_POST['sesh']) && isset($_POST['term']) && isset($_POST['class'])){

  if($_POST['sesh'] != "" && $_POST['term'] != "" && $_POST['term'] != ""){

    $fil_query = $query . '
      WHERE tr.select_session = :s AND (tr.select_term = :t) AND (tr.select_class = :cl)
    ';

    $stmt = $conn->prepare($fil_query);
    $stmt->bindParam(":s", $_POST['sesh']);
    $stmt->bindParam(":t", $_POST['term']);
    $stmt->bindParam(":cl", $_POST['class']);
    $stmt->execute();

  }elseif($_POST['sesh'] != "" && $_POST['term'] == "" && $_POST['class'] == ""){
    //sorting record with session only
    $fil_query = $query . '
      WHERE tr.select_session = :s
    ';

    $stmt = $conn->prepare($fil_query);
    $stmt->bindParam(":s", $_POST['sesh']);
    $stmt->execute();

  }elseif($_POST['sesh'] == "" && $_POST['term'] != "" && $_POST['class'] == ""){
    //sorting record with term only
    $fil_query = $query . '
      WHERE tr.select_term = :t
    ';

    $stmt = $conn->prepare($fil_query);
    $stmt->bindParam(":t", $_POST['term']);
    $stmt->execute();

  }else{
    //sorting record with term only
    $fil_query = $query . '
      WHERE tr.select_class = :cl
    ';

    $stmt = $conn->prepare($fil_query);
    $stmt->bindParam(":cl", $_POST['class']);
    $stmt->execute();
  }

}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
// $result = [];
// while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
//   extract($row);
//   $res = [
//     "id" => $id,
//     "hash_id" => $hash_id,
//     "name" => $name,
//     "amount" => $amount,
//     "amount_paid" => $amount_paid,
//     "outstanding" => $outstanding,
//     "fee_type" => $fee_type,
//     "session" => $session,
//     "term" => $term,
//
//   ];
//
//   array_push($result, $res);
// }

echo json_encode($result);

 ?>
