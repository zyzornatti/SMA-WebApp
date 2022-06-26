<?php

if(count($uri) < 2){
  header("Location: /dashboard");
  exit();
}

$page_title = "Manage Students";
include "Includes/header.php";

 ?>


  <div class="page-wrapper">
    <div class="content container-fluid">

      <div class="page-header">
        <div class="row">
          <div class="col">
            <h3 class="page-title">Students</h3>
            <ul class="breadcrumb">
            </ul>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title mb-2">Manage Students</h5>
            </div>
            <div class="card-body">
              <form class="form-inline">

                <div class="input-group mb-2 mr-sm-2">
                  <div class="input-group-prepend">
                     <div class="input-group-text">Class</div>
                   </div>
                  <select class="custom-select" id="clas">
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
                      <th>Email</th>
                      <th>Gender</th>
                      <th>Phone Number</th>
                      <th>Nationality</th>
                      <th>Admission</th>
                      <th>Religion</th>
                      <th>Class</th>
                      <th>Address</th>
                      <th>Guardian</th>
                      <th>Image</th>
                      <th>Date Created</th>
                      <th>Time Created</th>
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

    function fetch(cl){
      $.ajax({
        url: "/fetch_students",
        type: "post",
        data: {
          clas: cl
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
                    data: 'email',
                    render: function ( data, type, row ) {
                        return row.email;
                    }
                  },
                  {
                    data: 'gender',
                    render: function ( data, type, row ) {
                        return row.gender;
                    }
                  },
                  {
                    data: 'phone_number',
                    render: function ( data, type, row ) {
                        return row.phone_number;
                    }
                  },
                  {
                    data: 'nationality',
                    render: function ( data, type, row ) {
                        return row.nationality;
                    }
                  },
                  {
                    data: 'admission_num',
                    render: function ( data, type, row ) {
                        return row.admission_num;
                    }
                  },
                  {
                    data: 'religion',
                     render: function ( data, type, row ) {
                         return row.religion;
                     }
                  },
                  {
                    data: 'class',
                     render: function ( data, type, row ) {
                         return row.class;
                     }
                  },
                  {
                    data: 'address',
                     render: function ( data, type, row ) {
                         return row.address;
                     }
                  },
                  {
                    data: 'guardian',
                     render: function ( data, type, row ) {
                         return row.guardian;
                     }
                  },
                  {
                    data: 'image',
                     render: function ( data, type, row ) {
                         return row.image;
                     }
                  },
                  {
                    data: 'date',
                     render: function ( data, type, row ) {
                         return row.date;
                     }
                  },
                  {
                    data: 'time',
                     render: function ( data, type, row ) {
                         return row.time;
                     }
                  },
                  {
                    data: 'hash_id',
                     render: function ( data, type, row ) {
                         return '<a href="/edit?students='+row.hash_id+'" class="btn btn-success btn-sm"><i class="fa fa-pen"></i> Edit</a><a href="/delete?students='+row.hash_id+'" id="del" class="btn btn-danger btn-sm"><i class="fa fa-trash"> Delete</a>';
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

      let clas = $("#clas").val();

      //check if they are empty POST values or not
      let clase = clas == "" ? "": clas;
      // alert(sesh+" "+tam);

      //destroy datatable table and use the parameters sent to fetch function to fetch datas based on the parameters sent
      $("#read").DataTable().destroy();
      fetch(clase);

    });

    $(document).on('click', '#reset', function(e){
      e.preventDefault();

      $("#read").DataTable().destroy();
      $("#clas").html("<option value=''>Choose...</option>");
      fetch_class();
      fetch();
    });

    $(document).on('click', '#del', function(e){
      e.preventDefault();
      return confirm('Are you sure you want to delete this?');
    });

    $('.dataTable').on('click', 'tbody td', function() {
        //get textContent of the TD
        console.log('TD cell textContent : ', this.textContent)

        //get the value of the TD using the API
        console.log('value by API : ', table.cell({ row: this.parentNode.rowIndex, column : this.cellIndex }).data());
      })


  </script>
