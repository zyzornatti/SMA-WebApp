<?php
 define("DBNAME", getenv('DB_NAME'));
 define("DBUSER", getenv('DB_USER'));
 define("DBPASS", getenv('DB_PASSWORD'));

        try{

          $conn = new PDO('mysql:host=localhost;dbname='.DBNAME, DBUSER, DBPASS);

          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e) {
                echo $e->getMessage();
        }

 ?>
