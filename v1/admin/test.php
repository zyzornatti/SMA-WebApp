<?php
echo "This is a Test Page";
echo "<br/>";
echo "<hr/>";

$id = "16515710505127";

if(isset ($_POST['submit'])){
  // var_dump($_FILES);
  // die;
  $imgg = uploadImages($_FILES['image_1'], "uploads/");
  if(in_array("true", $imgg)){
    unset($_FILES['image_1']);
    $new_image = $imgg[1];
  }else{
    die($imgg['err']);
  }
  updateContent($conn, "panel_students", ["image_1"=>$new_image], ['hash_id'=>$id]);
  echo "Upload Successful";
}


 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>

     <!-- <script type="text/javascript" src="/assets/js/jquery.js"></script>
     <script type="text/javascript" src="/assets/js/jquery-1.10.2.min.js"></script>
     <script type="text/javascript" src="/assets/js/sweetalert2.all.min.js"></script>
     <script type="text/javascript">
       swal.fire("Done", "successfully done", "success")
     </script> -->
   </head>
   <body>
     <form class="" action="" method="post" enctype="multipart/form-data">
       <input type="file" name="image_1" value=""><br/><br/>
       <input type="submit" name="submit" value="Upload">
     </form>
   </body>
 </html>
