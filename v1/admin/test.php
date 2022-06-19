<?php
echo "This is a Test Page";
echo "<br/>";
echo "<hr/>";

$name = "Abdul-Azeez";
$nam = "Fatimah";

$gender = isset($name) && $name == "Fatimah" ? "Male" : "Female";
echo $gender;
echo "<br>";
if(isset($_POST['button'])){
  // $_POST['name'] = "Abdul-Azeez";
  $current_sesh = selectContentDesc($conn, "selection_session", [], "id", 1)[0];
  // var_dump($current_sesh['hash_id']);
  $_POST['name'] = isset($_POST['name']) && $_POST['name'] == "" ? $current_sesh['hash_id'] : $_POST['name'];
  var_dump($_POST);
}

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form class="" action="" method="post">
      <input type="text" name="name" value="">
      <button type="submit" name="button">Go</button>
    </form>

    <script type="text/javascript">
      let sesh = "Me";
      let seshh = sesh == "" ? "": sesh;
      alert(seshh)
    </script>
  </body>
</html>
