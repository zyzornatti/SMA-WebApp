<?php

//check if url is up to 3 wen split by "/"
if(count($uri) < 3){
  header("Location: /dashboard");
  exit();

}else{

  $page = $uri[2];
  $tab = new TableContent;
  $tab->checker = $uri[1];
  $tab->page = $page;
  $tab->conn = $conn;
  $columns = $tab->filter_table_columns();
  $table = $tab->table_name();

}


if(array_key_exists('submit', $_POST)){

  array_pop($_POST);
  if(isset ($_FILES['image_1'])){
    $imgg = uploadImages($_FILES['image_1'], "uploads/");
    if(in_array("true", $imgg)){
      unset($_FILES['image_1']);
      $new['image_1'] = $imgg[1];
    }else{
      die($imgg['err']);
    }
  }

  $clean = array_map('trim', $_POST);

  if($table == "panel_teachers"){
    $new['employment_id'] = rand(1111, 9999)."stf".time();
  }
  if($table == "panel_blog"){
    $new['visibility'] = "show";
  }
  if($table == "panel_students"){
    $new['admission_number'] = rand(1111, 9999)."std".time();
  }

  $new['hash_id'] = time().rand(1000, 9999);
  $new['date_created'] = date("Y-m-d");
  $new['time_created'] = date("H:i:s");

  $post = $new + $clean;
  insertSafe($conn, $table, $post);

  $_SESSION['msg'] = ucfirst($page)." Added Successfully";
  $location = "manage/".$page;
  header("Location: /$location");

}
$page_title = "Create ".ucwords($page);


include "includes/header.php";
 ?>

 <div class="page-wrapper">
   <div class="content container-fluid">

     <div class="page-header">
       <div class="row align-items-center">
         <div class="col">
           <h3 class="page-title">Add <?= ucfirst($page) ?></h3>
         </div>
       </div>
     </div>

     <div class="row">
       <div class="col-sm-12">
         <div class="card">
           <div class="card-body">

             <form action="" method="post" enctype="multipart/form-data">

               <div class="row">
                 <div class="col-12">
                   <h5 class="form-title"><span><?= ucfirst($page) ?> Information</span></h5>
                 </div>
                 <?php foreach ($columns as $key => $value): ?>
                   <?php if(explode("_", $value)[0] == "input"): ?>
                     <div class="col-12 col-sm-6">
                       <div class="form-group">
                         <label><?= fomName($value) ?></label>
                         <input type="text" name="<?= $value ?>" placeholder="Enter <?= fomName($value) ?>" value="" required="" class="form-control">
                       </div>
                     </div>

                 <?php elseif(explode("_", $value)[0] == "dated"): ?>
                     <div class="col-12 col-sm-6">
                       <div class="form-group">
                        <label><?= fomName($value) ?></label>
                         <div>
                           <input type="date" name="<?= $value ?>" placeholder="Select <?= fomName($value) ?>" value="" required="" class="form-control">
                         </div>
                       </div>
                     </div>

                  <?php elseif(explode("_", $value)[0] == "select"): ?>
                    <?php $sel_col = "input_".selectTab($value); ?>
                    <?php $sel_opt = fetchSelection($conn, $value); ?>
                   <div class="col-12 col-sm-6">
                     <div class="form-group">
                       <label>Select <?= fomName($value) ?></label>
                         <select class="form-control" name="<?= $value ?>" required="">
                           <option>--Select <?= fomName($value) ?>--</option>
                         <?php foreach ($sel_opt as $key1 => $value1): ?>
                           <option value="<?= $value1['hash_id']?>"><?= $value1[$sel_col] ?></option>
                         <?php endforeach; ?>
                       </select>
                     </div>
                   </div>

                   <?php elseif(explode("_", $value)[0] == "image"):?>
                     <div class="col-12 col-sm-6">
                         <div class="form-group">
                         <label><?= fomName($value) ?></label>
                         <input type="file" name="<?= $value ?>" placeholder="Enter <?= fomName($value) ?>" value="" required="" class="form-control">
                         </div>
                     </div>
                   <?php else: ?>
                     <div class="col-12 col-sm-6">
                       <div class="form-group">
                         <label><?= fomName($value) ?></label>
                         <textarea class="form-control" name="<?= $value ?>" placeholder="Enter <?= fomName($value) ?>" rows="8" cols="80" required=""></textarea>
                       </div>
                     </div>
                   <?php endif ?>
                 <?php endforeach; ?>
                 <div class="col-12">
                   <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                 </div>
               </div>

             </form>

           </div>
         </div>
       </div>
     </div>
   </div>

 <?php include "includes/footer.php" ?>
