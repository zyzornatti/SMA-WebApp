<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <label for="session">Session</label>
          <select class="custom-select" id="session">
            <option id="">Choose..</option>
          </select>
          <label for="class">Class</label>
          <select class="custom-select" id="class">
            <option id="">Choose..</option>
          </select>
        </div>
      </div>
    </div>


    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
             console.log(data[0]['hash_id']);
             var resSes = "";
             for (let i in data) {
               resSes += "<option value="+data[i]['hash_id']+">"+data[i]['input_session']+"</option>";
             }
             $("#session").append(resSes);
          }
        })
      }
      fetch_session();
      function fetch_class(){
        $.ajax({
          url: "/fetch_class",
          type: "post",
          dataType: "json",
          success: function(data){
             console.log(data);
             var resCla = "";
             for (var i in data) {
               resCla +='<option id='+data[i]['hash_id']+'>'+data[i]['input_class']+'</option>';
             }
             $("#class").append(resCla);
          }
        })
      }
      fetch_class();
    </script>
  </body>
</html>
