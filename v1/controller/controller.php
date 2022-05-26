<?php

function authenticate($session, $url){
  if(!isset ($session)){
    header("Location: /$url?msg=You_have_not_logged_in");
  }
}

function say($value){
  echo "<p style='color:red'>*".$value."</p>";
}

function checkIfReadOrPanel($col){
  $tt = explode('_', $col);

    if(count($tt) > 1){
      if($tt[0] == "panel"){
        return $col;
      }elseif($tt[0] == "selection"){
        return $col;
      }elseif($tt[0] == "read"){
        return $col;
      }else{
        return "ignore";
      }
    }else{
      return "ignore";
    }

}

function fetchAllTables($dbconn, $table){
  $tabs = $dbconn->prepare("SHOW Tables FROM $table");
  $tabs->execute();
  $tabss = $tabs->fetchAll();

  $tab = "Tables_in_".$table;
  $table_names = [];
  foreach ($tabss as $key => $value) {
    $table_names[] = checkIfReadOrPanel($value[$tab]);
  }
  return $table_names;
}

function fetchTableColumn($dbconn, $table){
  $col = $dbconn->prepare("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = :tn");
  $col->bindParam(":tn", $table);
  $col->execute();

  $coll = $col->fetchAll();

  $dd = [];
  foreach ($coll as $columns) {
    $dd[] = $columns['COLUMN_NAME'];
  }

  return $dd;
}

function base64url_encode($s) {
  return str_replace(array('+', '/'), array('-', '_'), base64_encode($s));
}

function base64url_decode($s) {
  return base64_decode(str_replace(array('-', '_'), array('+', '/'), $s));
}

function checkIfColVal($col){
  $tt = explode('_', $col);

    if(count($tt) > 1){
      if(strpos($tt[0], "input") !== false){
        return $col;
      }elseif(strpos($tt[0], "text") !== false){
        return $col;
      }elseif(strpos($tt[0], "dated") !== false){
        return $col;
      }elseif(strpos($tt[0], "image") !== false){
        return $col;
      }elseif(strpos($tt[0], "select") !== false){
        return $col;
      }else{
        return "ignore";
      }
    }else{
      return "ignore";
    }


}

function checkIfColVal2($col){
  $tt = explode('_', $col);

    if(count($tt) > 1){
      if(strpos($tt[0], "input") !== false){
        return $col;
      }elseif(strpos($tt[0], "text") !== false){
        return $col;
      }elseif(strpos($tt[0], "dated") !== false){
        return $col;
      }elseif(strpos($tt[0], "image") !== false){
        return $col;
      }elseif(strpos($tt[0], "select") !== false){
        return $col;
      }elseif($col == "date_created"){
        return $col;
      }elseif($col == "time_created"){
        return $col;
      }else{
        return "ignore";
      }
    }else{
      return "ignore";
    }


}

function checkIfSelect($col){
  $tt = explode('_', $col);

    if(count($tt) > 1){
      if(strpos($tt[0], "input") !== false){
        return "ignore";
      }elseif(strpos($tt[0], "text") !== false){
        return "ignore";
      }elseif(strpos($tt[0], "dated") !== false){
        return "ignore";
      }elseif(strpos($tt[0], "image") !== false){
        return "ignore";
      }elseif(strpos($tt[0], "select") !== false){
        return $col;
      }else{
        return "ignore";
      }
    }else{
      return "ignore";
    }

}

function newLk($link){
  $uu = explode("_", $link);
  unset($uu[0]);
  $nmm = implode(" ", $uu);
  return ucfirst($nmm);
}

function selectTab($link){
  // $uu = explode("_", $link);
  // unset($uu[0]);
  // if(count($uu) > 2){
  //   $nmm = implode("_", $uu);
  // }else{
  //   $nmm = $uu[1];
  // }
  // return $nmm;
  $uu = explode("_", $link);
  unset($uu[0]);
  $nmm = implode("_", $uu);
  return $nmm;
}

function fomName($na){

  $nn = explode('_', $na);

  if(count($nn) > 1){
    if($nn[0] == "image"){
      $nmm = "image";
    }elseif($nn[0] == "select"){
      unset($nn[0]);
      $nme = implode(" ", $nn);
      $nmm = $nme;
    }elseif($nn[0] == "input"){
      unset($nn[0]);
      $nme = implode(" ", $nn);
      $nmm = $nme;
    }elseif($nn[0] == "selection"){
      unset($nn[0]);
      $nme = implode(" ", $nn);
      $nmm = $nme;
    }elseif($nn[0] == "panel"){
      unset($nn[0]);
      $nme = implode(" ", $nn);
      $nmm = $nme;
    }elseif($nn[0] == "read"){
      unset($nn[0]);
      $nme = implode(" ", $nn);
      $nmm = $nme;
    }elseif($nn[0] == "dated"){
      unset($nn[0]);
      $nme = implode(" ", $nn);
      $nmm = $nme;
    }else{
      // unset($nn[0]);
      $nmm = implode(" ", $nn);
    }
  }else{
    $nmm = $na;
  }

  return ucfirst($nmm);
}

function fetchSelection($dbconn, $table){
  $nn = selectTab($table);
  $tt = "selection_".$nn;
  // $tw = "panel_".$nn;

  // $table_names = fetchAllTables($dbconn);
  //
  // $we = array_keys($table_names, $tt);
  // if(count($we) > 0){
  //   $nm = selectContent($dbconn, $table_names[$we[0]], []);
  //
  // }else{
  //   $nm = selectContent($dbconn, $nn, []);
  //
  // }
  $nm = selectContent($dbconn, $tt, []);

  return $nm;
}

function uploadImages($file, $dir){
  $result = [];

  $image = $file;
  $imageName = $image['name'];
  $imageTmpName = $image['tmp_name'];
  $imageSize = $image['size'];
  $imageError = $image['error'];
  $imageNewExt = strtolower(pathinfo($imageName,PATHINFO_EXTENSION));
  $img_allowed = array('jpg', 'jpeg', 'png');
  $imageNewName = md5($imageName).time().".".$imageNewExt;
  $imageDestination = $dir.$imageNewName;

    if(!in_array($imageNewExt, $img_allowed)){
      // $result['err'] = false;
      $result['err'] = "Image extension not allowed!!!";
    }

    if($imageError !== 0){
      // $result['err'] = false;
      $result['err'] = "Error Uploading Image!!!";
    }

    if($imageSize > 1000000){
      // $result['err'] = false;
      $result['err'] = "Image too large!!!";
    }

    if(empty ($result['err'])){
      move_uploaded_file($imageTmpName, $imageDestination);
      $result[] = true;
      $result[] = $imageNewName;
    }

    return $result;

}

function fetchPay4Students($dbconn, $stid){
   $std = selectContent($dbconn, "read_school_fees", ["student_id"=> $stid]);
   if(count($std) < 1){
     $amounts = [
       "input_amount_paid" => "Not Paid",
       "input_outstanding" => "Not Paid"
     ];
   }else{
      $amount = preg_grep("/input_amount_paid/", $std);
      $outst = preg_grep("/input_outstanding/", $std);
      $amounts = array_merge($amount, $outst);
   }

   return $amounts;
}

///////////////end

function cleans($string){
  $string = str_replace(array('[\', \']'), '', $string);
  $string = preg_replace('/\[.*\]/U', '', $string);
  $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
  $string = htmlentities($string, ENT_COMPAT, 'utf-8');
  // $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
  $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
  return strtolower(trim($string, '-'));
}

function previewBody($string, $count){
  $original_string = $string;
  $words = explode(' ', $original_string);
  if(count($words) > $count){
    $words = array_slice($words, 0, $count);
    $string = implode(' ', $words)."...";
  }
  return strip_tags($string);
}

function shortenText($content){
 $body = $content;
 $string = strip_tags($body);
 if (strlen($string) > 100){
   $stringCut = substr($string, 0, 100);
   $endPoint = strrpos($stringCut, ' ');
   $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
   $string .= '...';
 }
 return $string;
}

// function fetchContent($dbconn, $table){
//   $rc = $dbconn->prepare("SELECT * FROM $table");
//   $rc->execute();
//
//   return $rc;
// }
//
// function fetchRecord($dbconn, $table, $column, $id){
//   $rc = $dbconn->prepare("SELECT * FROM $table WHERE $column=:rc");
//   $rc->bindParam(":rc",$id);
//   $rc->execute();
//
//   $record = $rc->fetch(PDO::FETCH_BOTH);
//   return $record;
// }
//
// function fetchRecords($dbconn, $table, $column, $id){
//   $rc = $dbconn->prepare("SELECT * FROM $table WHERE $column=:rc");
//   $rc->bindParam(":rc", $id);
//   $rc->execute();
//
//   return $rc;
// }
//
// function fetchRecordsWithL($dbconn, $table, $column, $cid, $order, $limit){
//   $rc = $dbconn->prepare("SELECT * FROM $table WHERE $column = :cid ORDER BY $order DESC LIMIT $limit");
//   $rc->bindParam(":cid", $cid);
//   $rc->execute();
//
//   return $rc;
// }

// function deleteRecord($dbconn, $table, $column, $id, $location){
//     $del = $dbconn->prepare("DELETE FROM $table WHERE $column = :id");
//     $del->bindParam(":id", $id);
//     $del->execute();
//
//     header("Location: /$location");
// }

function deleteContent($dbconn,$table,$columnWhere){

  // die($columnWhere);
  try {

    // $what = getVal($parameters);
    $vall = formatWhere($columnWhere);

    // var_dump($parameters);
    $sql = sprintf('DELETE FROM %s',
    $table
  );
  $sql .= " WHERE ".$vall;


  //die(var_dump($sql));
  $stmt =  $dbconn->prepare($sql);
  $newt = $columnWhere;
  // die(var_dump($newt));

  $stmt->execute($newt);

} catch (PDOException $e) {
  var_dump($table);
  die("Error Occured");
}

}

function formatParam($param){
  $result = [];
  foreach($param as $col => $val){
    $result[] = "$col = :$col";
  }
  $new = implode(', ', $result);
  return $new;
}

function formatWhereParam($param){
  $result = [];
  foreach($param as $col => $val){
    $cola = $col."a";
    $result[$cola] = $val;
  }
  // $new = implode(', ', $result);
  return $result;
}

function formatWhere($param){
  $result = [];
  foreach($param as $col => $val){
    $result[] = "$col = :$col";
  }
  $new = implode(' AND ', $result);
  return $new;
}

function formatPutWhere($param){
  $result = [];
  foreach($param as $col => $val){
    $result[] = "$col = :$col"."a";
  }
  $new = implode(' AND ', $result);
  return $new;
}

function insertSafe($conn, $table, $parameters){
  try {
    // array_pop($parameters);
    // var_dump($parameters);
    $sql = sprintf('INSERT INTO %s (%s) VALUES(%s)',
    $table,
    implode(', ',array_keys($parameters)), ':'.implode(',:',array_keys($parameters))
  );
  // //die(var_dump($sql));
  $stmt =  $conn->prepare($sql);
  $stmt->execute($parameters);
} catch (PDOException $e) {
  if (isset($_SESSION['debug'])) {
  die($e);
}else{
  die($e);
    die("Error: Try again After Some Times");
}
}
}

function insertContent($conn, $table, $parameters){
  try {

    // var_dump($parameters);
    $sql = sprintf('INSERT INTO %s (%s) VALUES(%s)',
    $table,
    implode(', ',array_keys($parameters)), ':'.implode(',:',array_keys($parameters))
  );
  // //die(var_dump($sql));
  $stmt =  $conn->prepare($sql);
  $stmt->execute($parameters);
} catch (PDOException $e) {
  if (isset($_SESSION['debug'])) {
  die($e);
}else{
    die("Error: Try again After Some Times");
}
}
}

function insert($conn, $table, $parameters){

  array_pop($parameters);
  // var_dump($parameters);
  $sql = sprintf('INSERT INTO %s (%s) VALUES(%s)',
  $table,
  implode(', ',array_keys($parameters)), ':'.implode(',:',array_keys($parameters))
);
// //die(var_dump($sql));
$stmt =  $conn->prepare($sql);
$stmt->execute($parameters);
}
function displayErrors($error, $field)
{
  $result= "";
  if (isset($error[$field]))
  {
    $result = '<span style="color:red">'.$error[$field].'</span>';
  }
  return $result;
}

function updateContent($dbconn, $table, $parameters,$columnWhere){
  try {



    // array_pop($parameters);
    $what = formatParam($parameters);
    $vall = formatWhere($columnWhere);

    // var_dump($parameters);
    $sql = sprintf('UPDATE %s SET %s',
    $table, $what
  );
  $sql .= " WHERE ".$vall;
  // //die(var_dump($sql));
  $stmt =  $dbconn->prepare($sql);
  $newt = $parameters + $columnWhere;
  // die(var_dump($newt));
  $stmt->execute($newt);
} catch (PDOException $e) {
  die($e);
}
}

function selectContent($dbconn,$table,$columnWhere){
  $vall = formatWhere($columnWhere);
  try{

    // $what = getVal($parameters);

    // var_dump($parameters);
    $sql = sprintf('SELECT * FROM %s',
    $table
  );

  if(count($columnWhere) > 0){
    $sql .= " WHERE ".$vall;
  }

  //die(var_dump($sql));
  $stmt =  $dbconn->prepare($sql);
  $newt = $columnWhere;
  // die(var_dump($newt));
  if(count($columnWhere) > 0){
    $stmt->execute($newt);
  }else{
    $stmt->execute();
  }

  $result = [];
  while($row = $stmt->fetch(PDO::FETCH_BOTH)){
    $result[] = $row;
  }

  return $result;
} catch (PDOException $e) {
      if (isset($_SESSION['debug'])) {
      die($e);
    }else{
        die("Error: Try again After Some Times");
    }
  }
}

function selectContentDesc($dbconn,$table,$columnWhere,$order,$limit){
  $vall = formatWhere($columnWhere);
  try{

    // $what = getVal($parameters);

    // var_dump($parameters);
    $sql = sprintf('SELECT * FROM %s',
    $table
  );

  if(count($columnWhere) > 0){
    $sql .= " WHERE ".$vall;
  }
  $sql.= " ORDER BY ".$order." DESC LIMIT ".$limit;

  //die(var_dump($sql));
  $stmt =  $dbconn->prepare($sql);
  $newt = $columnWhere;
  // die(var_dump($newt));
  if(count($columnWhere) > 0){
    $stmt->execute($newt);
  }else{
    $stmt->execute();
  }

  $result = [];
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $result[] = $row;
  }

  return $result;
} catch (PDOException $e) {
      if (isset($_SESSION['debug'])) {
      die($e);
    }else{
        die("Error: Try again After Some Times");
    }
  }
}
 ?>
