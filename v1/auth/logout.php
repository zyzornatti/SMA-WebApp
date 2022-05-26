<?php
if(isset ($_SESSION['admin'])){
  unset($_SESSION['admin']);
  header("Location: /login");
}else{
  unset($_SESSION['admin']);
  header("Location: /login");
}

 ?>
