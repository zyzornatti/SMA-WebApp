<?php

if(count($uri) <3){
  header("Location: /dashboard");
  exit();
}else{
  $page = $uri[2];
  $tab = new TableRecord;
  $tab->checker = $uri[1];
  $tab->page = $page;
  $tab->conn = $conn;
  $columns = $tab->filter_record_columns();
  $records = $tab->table_records();

  //if there is a select column populate all the select values and save it in an array
  if($columns['select_columns'] != false){
    $category = $columns['select_columns'];
  }
  // echo "<prev>";
  // var_dump($tab->filter_record_columns());
  // echo "</prev>";
  // echo "<hr/>";
  // echo "<prev>";
  // print_r($tab->table_records());
  // echo "</prev>";
  // die;

}

$page_title = "Manage ".ucwords($page);
include "includes/header.php";

 ?>

 <div class="page-wrapper">
   <div class="content container-fluid">

   <div class="page-header">
     <div class="row">
       <div class="col">
         <h3 class="page-title">Students</h3>
         <ul class="breadcrumb">
         <!-- <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li> -->
         <!-- <li class="breadcrumb-item active">Students</li> -->
         </ul>
       </div>
     </div>
   </div>

   <div class="row">
     <div class="col-sm-12">
       <div class="card">
         <div class="card-header">
           <h5 class="card-title mb-2">Manage <?= ucfirst($page) ?></h5>
           <!-- <p class="card-text">
           This is the most basic example of the datatables with zero configuration. Use the <code>.datatable</code> class to initialize datatables.
           </p> -->
         </div>
           <div class="card-body">
             <div class="table-responsive">
               <table id="read" class="table table-stripped">
                 <thead>
                   <tr>
                     <th>S/N</th>
                     <?php foreach ($columns['columns'] as $column): ?>
                       <th><?= fomName($column) ?></th>
                     <?php endforeach; ?>
                     <th columnspan="2">Action</th>
                   </tr>
                 </thead>
                 <tbody>
                   <?php $x = 1 ?>
                   <?php foreach ($records as $record): ?>
                     <tr>
                       <td><?= $x ?></td>
                       <?php foreach ($columns['columns'] as $col): ?>
                         <?php if(explode("_", $col)[0] == "select"): ?>
                           <td><?= $category[$record[$col]] ?></td>
                         <?php else: ?>
                           <td><?= $record[$col] ?></td>
                         <?php endif ?>
                       <?php endforeach; ?>
                       <td><a href="/edit?<?= $page ?>=<?= $record["hash_id"] ?>" class="btn btn-success btn-sm"><i class="fa fa-pen"></i> Edit</a><a href="/delete?<?= $page ?>=<?= $record["hash_id"] ?>" onclick="return confirm('Are you sure you want to delete this?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a></td>
                     </tr>
                     <?php $x++ ?>
                   <?php endforeach; ?>
                 </tbody>
               </table>
             </div>
           </div>
        </div>
     </div>
   </div>
 </div>

 <?php include "includes/footer.php" ?>

 <?php if(isset ($_SESSION['msg'])): ?>
   <script type="text/javascript">
     swal.fire("Done!", "<?= $_SESSION['msg'] ?>", "success");
   </script>
   <?php unset($_SESSION['msg']) ?>
 <?php endif ?>

 <script type="text/javascript">
   $("#read").dataTable({
     // "searching": true
   })
 </script>
