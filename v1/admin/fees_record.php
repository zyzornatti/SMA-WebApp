<?php

if(count($uri) < 3){
  header("Location: /dashboard");
  exit();
}else{
  // $page = $uri[2];
  // var_dump($page);
  // die;
  $check_for_getid = explode("?", $uri[2]);
  if($check_for_getid >= 1){
    $page = $check_for_getid[0];
  }
  $tab = new TableRecord;
  $tab->checker = $uri[1];
  $tab->page = $page;
  $tab->conn = $conn;

  if($tab->table_name() == false){
    die("Error: This page doesn't exist!!!");
  }

}

$page_title = "Fees Record";
include "includes/header.php";

 ?>

 <div class="page-wrapper">
   <div class="content container-fluid">

     <div class="page-header">
       <div class="row">
         <div class="col">
           <h3 class="page-title">Payment Record</h3>
           <ul class="breadcrumb">
           </ul>
         </div>
       </div>
     </div>

     <div class="row">
       <div class="col-sm-12">
         <div class="card">
           <div class="card-header">
             <h5 class="card-title mb-2">Manage Payments</h5>
           </div>
           <div class="card-body">
             <form class="form-inline">
               <div class="input-group mb-2 mr-sm-2">
                 <div class="input-group-prepend">
                    <div class="input-group-text">Session</div>
                  </div>
                 <select class="custom-select" id="sesh">
                   <option value="">Choose...</option>
                 </select>
               </div>

               <div class="input-group mb-2 mr-sm-2">
                 <div class="input-group-prepend">
                    <div class="input-group-text">Term</div>
                  </div>
                 <select class="custom-select" id="term">
                   <option value="">Choose...</option>
                 </select>
               </div>

               <div class="input-group mb-2 mr-sm-2">
                 <div class="input-group-prepend">
                    <div class="input-group-text">Class</div>
                  </div>
                 <select class="custom-select" id="clas">
                   <option value="">Choose...</option>
                 </select>
               </div>

               <div class="input-group mb-2 mr-sm-2">
                 <div class="input-group-prepend">
                    <div class="input-group-text">Fees Type</div>
                  </div>
                 <select class="custom-select" id="fees_type">
                   <option value="">Choose...</option>
                 </select>
               </div>

               <button type="button" id="filter" class="btn btn-primary mb-2">Filter</button>
               <button type="button" id="reset" class="btn btn-secondary mb-2">Reset</button>
             </form>

             <div class="table-responsive">
               <table id="read" class="table table-stripped">
                 <thead>
                   <tr>
                     <th>S/N</th>
                     <th>Student</th>
                     <th>Class</th>
                     <th>Session</th>
                     <th>Term</th>
                     <th>Fee Type</th>
                     <th>Fee Amount</th>
                     <th>Amount Paid</th>
                     <th>Outsanding</th>
                     <th>Action</th>

                     <!-- <th columnspan="2">Action</th> -->
                   </tr>
                 </thead>
                 <tbody>

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
 // $("#read").dataTable({
 //   // "searching": true
 // })
   function fetch_session(){
     $.ajax({
       url: "/fetch_session",
       type: "post",
       dataType: "json",
       success: function(data){
         // console.log(data[0]['hash_id']);
         var resSes = "";
         for (let i in data) {
           resSes += "<option value="+data[i]['hash_id']+">"+data[i]['input_session']+"</option>";
         }
         $("#sesh").append(resSes);
       }
     })
   }
   fetch_session();

   function fetch_term(){
     $.ajax({
       url: "/fetch_term",
       type: "post",
       dataType: "json",
       success: function(data){
          // console.log(data);
          var resterm = "";
          for (var i in data) {
            resterm +='<option value='+data[i]['hash_id']+'>'+data[i]['term']+'</option>';
          }
          $("#term").append(resterm);
       }
     })
   }
   fetch_term();

   function fetch_class(){
     $.ajax({
       url: "/fetch_class",
       type: "post",
       dataType: "json",
       success: function(data){
          // console.log(data);
          var resCla = "";
          for (var i in data) {
            resCla +='<option value='+data[i]['hash_id']+'>'+data[i]['class']+'</option>';
          }
          $("#clas").append(resCla);
       }
     })
   }
   fetch_class();

   function fetch_fees_type(){
     $.ajax({
       url: "/fetch_fees_type",
       type: "post",
       dataType: "json",
       success: function(data){
          // console.log(data);
          var resFt = "";
          for (var i in data) {
            resFt +='<option value='+data[i]['hash_id']+'>'+data[i]['fees_type']+'</option>';
          }
          $("#fees_type").append(resFt);
       }
     })
   }
   fetch_fees_type();

   function fetch(sess, tr, cl, ft){
     $.ajax({
       url: "/fetch_fees",
       type: "post",
       data: {
         sesh: sess,
         term: tr,
         clas: cl,
         fees_type: ft
       },
       dataType: "json",
       success: function(data){
          // console.log(data);
          let i = 1;
          $('#read').DataTable({
            "data": data,
             "columns": [
                 {
                   data: 'id',
                    render: function ( data, type, row ) {
                        // return row.id;
                        return i++;
                    }
                  },
                 {
                   data: 'name',
                     render: function ( data, type, row ) {
                         return row.name;
                     }
                 },
                 {
                   data: 'st_class',
                   render: function ( data, type, row ) {
                       return row.st_class;
                   }
                 },
                 {
                   data: 'tr_session',
                   render: function ( data, type, row ) {
                       return row.tr_session;
                   }
                 },
                 {
                   data: 'term',
                   render: function ( data, type, row ) {
                       return row.term;
                   }
                 },
                 {
                   data: 'fees_type',
                   render: function ( data, type, row ) {
                       return row.fees_type;
                   }
                 },
                 {
                   data: 'amount',
                   render: function ( data, type, row ) {
                       return row.amount;
                   }
                 },
                 {
                   data: 'amount_paid',
                    render: function ( data, type, row ) {
                        return row.amount_paid;
                    }
                 },
                 {
                   data: 'outstanding',
                    render: function ( data, type, row ) {
                        return row.outstanding;
                    }
                 },
                 {
                   data: 'hash_id',
                    render: function ( data, type, row ) {
                        return '<a href="/pay?students='+row.hash_id+'" class="btn btn-success btn-sm">Pay</a>';
                    }
                 }
             ],
         });

       }
     })
   }
   fetch();

   $(document).on('click', '#filter', function(e){
     e.preventDefault();

     let sesh = $("#sesh").val();
     let tam = $("#term").val();
     let clas = $("#clas").val();
     let fees_type = $("#fees_type").val();

     //check if they are empty POST values or not
     let seshh = sesh == "" ? "": sesh;
     let tamm = tam == "" ? "": tam;
     let clase = clas == "" ? "": clas;
     let fees_typee = fees_type == "" ? "": fees_type;
     // alert(sesh+" "+tam);

     //destroy datatable table and use the parameters sent to fetch function to fetch datas based on the parameters sent
     $("#read").DataTable().destroy();
     fetch(seshh, tamm, clase, fees_typee);

   });

   $(document).on('click', '#reset', function(e){
     e.preventDefault();

     $("#read").DataTable().destroy();
     $("#sesh").html("<option value=''>Choose...</option>");
     fetch_session();
     $("#term").html("<option value=''>Choose...</option>");
     fetch_term();
     $("#clas").html("<option value=''>Choose...</option>");
     fetch_class();
     $("#fees_type").html("<option value=''>Choose...</option>");
     fetch_fees_type();
     fetch();
   });


 </script>
