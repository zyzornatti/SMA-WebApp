<?php

//check if url is up to 3 wen split by "/"
if(count($uri) < 2){
  header("Location: /dashboard");
  exit();

}else{
  $pg = explode("?", $uri[1]);
  $pag = explode("=", $pg[1]);
  $page = $pag[0];

  if(isset($_GET[$page])){
    $hash_id = $_GET[$page];
  }else{
    header("Location: /dashboard");
  }

  $tab = new TableRecord;
  $tab->checker = "edit";
  $tab->page = $page;
  $tab->conn = $conn;
  $tab->where = ["hash_id"=>$hash_id];
  $columns = $tab->filter_table_columns();
  $records = $tab->table_record();
  $table = $tab->table_name();
  // var_dump($columns);
  // echo "<hr/>";
  // var_dump($record);
  // die;


}


if(array_key_exists('submit', $_POST)){

  array_pop($_POST);
  if(isset ($_FILES['image_1'])){
    $old_image = $records[0]['image_1'];
    $path = 'uploads/'.$old_image;
    $img = uploadImages($_FILES['image_1'], "uploads/");

    if(in_array("true", $img)){
      unlink($path);
      unset($_FILES['image_1']);
      $new['image_1'] = $img[1];
    }else{
      die($img['err']);
    }
  }

  $clean = array_map('trim', $_POST);

  $post = $clean;
  updateContent($conn, $table, $post, $tab->where);

  $_SESSION['msg'] = ucfirst($page)." Updated Successfully";
  $location = "manage/".$page;
  header("Location: /$location");
}
$page_title = "Create";


include "includes/header.php";
 ?>

 <div class="page-wrapper">
   <div class="content container-fluid">

     <div class="page-header">
       <div class="row align-items-center">
         <div class="col">
           <h3 class="page-title">Edit <?= ucfirst($page) ?></h3>
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
                    <?php foreach ($records as $record): ?>
                      <?php if(explode("_", $value)[0] == "input"): ?>
                        <div class="col-12 col-sm-6">
                          <div class="form-group">
                            <label><?= fomName($value) ?></label>
                            <input type="text" name="<?= $value ?>" placeholder="Enter <?= fomName($value) ?>" value="<?= $record[$value] ?>" required="" class="form-control">
                          </div>
                        </div>

                      <?php elseif(explode("_", $value)[0] == "dated"): ?>
                          <div class="col-12 col-sm-6">
                            <div class="form-group">
                             <label><?= fomName($value) ?></label>
                              <div>
                                <input type="date" name="<?= $value ?>" placeholder="Select <?= fomName($value) ?>" value="<?= $record[$value] ?>" required="" class="form-control">
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
                                <option value="">--Select <?= fomName($value) ?>--</option>
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
                              <input type="file" name="<?= $value ?>" placeholder="Enter <?= fomName($value) ?>" value="<?= $record[$value] ?>" required="" class="form-control">
                              </div>
                          </div>
                        <?php else: ?>
                          <div class="col-12 col-sm-6">
                            <div class="form-group">
                              <label><?= fomName($value) ?></label>
                              <textarea class="form-control" name="<?= $value ?>" placeholder="Enter <?= fomName($value) ?>" rows="8" cols="80" required=""><?= $record[$value] ?></textarea>
                            </div>
                          </div>
                        <?php endif ?>
                    <?php endforeach; ?>
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
