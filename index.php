<?php
include('header.php');
$company_id=0;
if(!isset($_SESSION['username']))
{
  echo "<script> window.location = 'admin_login.php'</script>";
}
if(isset($_SESSION['companyid']))
{
  $company_id= $_SESSION['companyid'];
}
  $db=db_connect();
  $sql = "SELECT client_visits.id as clientvisitesid,
client_visits.client_work_rate AS client_work_rate,client_visits.client_mileage_rate AS client_mileage_rate,
  client_visits.client_name,client_visits.company_client_id,client_visits.visit_date,client_visits.visit_address,client_visits.departure_time,client_visits.arrival_time,client_visits.distance,client_visits.duration,client_visits.distance,client_visits.pdf_file,client_visits.created_at,client_visits.image,workers.first_name as emp_first_name,workers.last_name as emp_last_name,workers.email as emp_email,workers.work_rate AS emp_work_rate,workers.mileage_rate AS emp_mileage_rate,company_clients.client_company_name,company_clients.office_address as company_address,company_clients.email as company_email,company_clients.work_rate AS client_work_rate1,company_clients.mileage_rate AS client_mileage_rate1,company_clients.due_date_range,client_visits.invoice_paid_status ,client_visits.pdf_file,client_visits.image,client_visits.mileage_status,client_visits.return_mileage_status
    FROM client_visits JOIN workers ON(client_visits.worker_id=workers.id) JOIN company_clients ON(client_visits.company_client_id=company_clients.id) JOIN companies ON(workers.company_id=companies.id) where workers.company_id = $company_id  and  client_visits.visit_status = 1 ORDER BY client_visits.id DESC";
   

   $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);
 foreach ($data as $key => $value){
    $data[$key]['client_name']= $value['client_name'];
    $data[$key]['visit_date']= $value['visit_date'];
    $data[$key]['visit_address']= $value['visit_address'];
    $data[$key]['departure_time']= $value['departure_time'];
    $data[$key]['arrival_time']= $value['arrival_time'];
    $data[$key]['duration']= $value['duration'];
    $data[$key]['distance']= $value['distance'];
    $data[$key]['pdf_file']= $value['pdf_file'];
    $data[$key]['created_at']= $value['created_at'];
    $data[$key]['image']= $value['image'];
    $data[$key]['emp_first_name']= $value['emp_first_name'];
    $data[$key]['emp_last_name']= $value['emp_last_name'];
    $data[$key]['emp_email']= $value['emp_email'];
    $data[$key]['emp_work_rate']= $value['emp_work_rate'];
    $data[$key]['emp_mileage_rate']= $value['emp_mileage_rate'];
    $data[$key]['client_company_name']= $value['client_company_name'];
    $data[$key]['company_address']= $value['company_address'];
    $data[$key]['company_email']= $value['company_email'];
    $data[$key]['client_work_rate']= $value['client_work_rate'];
    $data[$key]['client_mileage_rate']= $value['client_mileage_rate'];
    $data[$key]['due_date_range']= $value['due_date_range'];
    $data[$key]['invoice_paid_status']= $value['invoice_paid_status'];
     $data[$key]['mileage_status']= $value['mileage_status'];
  }
?>
<!DOCTYPE html>
<html>
<head>   
  <meta charset="utf-8">
  <title>EWORXS | Automatically Track Your Mileage</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">     
  <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
</head>
<style>
  body{
    padding: 0px !important;
  }
  .scrollbar{
    height: 70px;
    width: 145px;
    overflow-x: unset!important;
    overflow-y: overlay;
}
.force-overflow{
    min-height: 0px;
}
#style-2::-webkit-scrollbar-track{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    border-radius: 10px;
}

#style-2::-webkit-scrollbar{
    width: 6px;
}

#style-2::-webkit-scrollbar-thumb{
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
}
</style>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include('left_side_bar.php');?>
  <div class="add_employee_list_modal">
  <div class="modal fade" id="add_employee_list_modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create New Employee List</h4>
          <a href="client_visit_csv.php">
            <button class="btn btn-warning pull-right">Export&nbsp;&nbsp;<i class="fa fa-file-excel-o"></i></button></a>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
            <tr>
              <th>Employee Name</th>
              <th>Mobile</th>
              <th>Password</th>
              <th>Employee Type</th>
            </tr>
            <tr>
              <td><input type="text" class="form-control" id="empName"/></td>
              <td><input type="number" class="form-control" id="empMobile"  /></td>
              <td><input type="text" class="form-control" id="empPassword"/></td>
              <td>
                <select class="form-control" id="empType">
                    <option>Engineer</option>
                    <option>Delivery Boy</option>
                  </select>
              </td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn theme-btn" id="add-employee-list-btn" onClick="addNewEmployee();">Create</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
        </div>
      </div>
    </div>
  </div>
  </div>

  <div class="edit_user_list_modal">
  <div class="modal fade" id="edit_user_list_modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit User List</h4>
          <input type="text" class="form-control" id="editUserId" style="display: none;" />
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
            <tr>
              <th>Employee Name</th>
              <th>Mobile</th>
              <th>Password</th>
              <th>Employee Type</th>
            </tr>
            <tr>
              <td><input type="text" class="form-control" id="editempName"/></td>
              <td><input type="number" class="form-control" id="editempMobile"  /></td>
              <td><input type="text" class="form-control" id="editempPassword"/></td>
              <td>
                <select class="form-control" id="editempType">
                    <option>Engineer</option>
                    <option>Delivery Boy</option>
                  </select>
              </td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn theme-btn" id="add-employee-list-btn" onClick="editEmployee();">Edit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 class="make-inline">Client Visits </h1>
     <a href="client_visit_csv.php"><button class="btn btn-warning pull-right">Export&nbsp;&nbsp;<i class="fa fa-file-excel-o"></i></button></a>
       <!--<button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_employee_list_modal" style="margin-right: 10px;">Create New <i class="fa fa-plus-circle"></i></button> -->
    </section>
  <!-- Main content -->
    <section class="content">
     <section class="content">
      <div class="row">
        <div class="">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body" style="overflow:scroll">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Client Name</th>
                  <th>Visit Date</th>
                  <th>Visit Address</th>
                 
                  <th>Arrival Time</th>
                   <th>Departure Time</th>
                  <th>Invoice</th>
                  <th>Created At</th>
                  <th><!-- Emp Name --> Workers's Name</th>
                  <!-- <th>Emp Email</th>
                  <th>Emp Work Rate</th>
                  <th>Emp Mileage Rate</th>
                  <th>Emp Due Bal</th>
                   --><th>Client Company Name</th>
                  <th>Company Address</th>
                  <th>Company Email</th>
                  <th>Client Work Rate</th>
                  <th>Duration</th>
                  
                  
                  <th>Client  Mileage <!-- Travel Time --> Rate</th>
                  


                  <th><!-- Distance -->Mileage</th>



                   <th><!-- Client Due Bal --> <!-- Mileage Amount --> Invoice due amount</th>
                  <th>Client Due Date</th>
                  <th>Invoice PDF</th>
                  <th>Attachment</th>
                  <th>Invoice Paid Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php 

                  foreach ($data as $key =>  $value){
                    $count=$key+1;
                    $id= $value['clientvisitesid'];
                    
                    


                    if($value['mileage_status'] == 1)
                    {
                       
                     if($value['return_mileage_status']==0)
               {

                    $distance=(float)$value['distance'];

                  }
                  else
                  {
                     $distance=(float)$value['distance']*2;
                  }
                      $amount = $distance*(float)$value['client_mileage_rate'];
                        $client_due_bal = (float)$amount+(float)$value['client_work_rate']*(float)$value['duration'];
                  
                    }
                    else
                    {
                       $client_due_bal = (float)$value['client_work_rate']*(float)$value['duration'];
                       $distance=0;
                   
                    }


                    $amount1=$distance*(float)$value['emp_mileage_rate'];
                 
                    $emp_due_bal = (float)$amount1+(float)$value['emp_work_rate'];
                    $due_days = $value['due_date_range'];
                    $due_date = $value['visit_date'];
                   
                    if($due_days>0){
                      $due_days = "+".$due_days." day";
                      $due_date = strtotime($due_days, strtotime($due_date));
                      $due_date = date("Y-m-d", $due_date);
                    }
                    
                          echo'<tr>'; 
                          echo'<td>'.$count.'</td>';
                          echo'<td>'.$value['client_name'].'</td>';
                          echo'<td>'.$value['visit_date'].'</td>';
                          echo'<td><div class="scrollbar" id="style-2">
                        <div class="force-overflow">'.$value['visit_address'].'</div></div></td>';
                          
                          echo'<td>'.$value['arrival_time'].'</td>';
                          echo'<td>'.$value['departure_time'].'</td>';
                          if($value['pdf_file']==""){
                            echo'<td>Invoice not sent</td>';
                          }else{
                            echo'<td>Invoice sent</td>';
                          }
                          echo'<td>'.$value['created_at'].'</td>';
                          echo'<td>'.$value['emp_first_name']." ".$value['emp_last_name'].'</td>';
                         /* echo'<td>'.$value['emp_email'].'</td>';
                          echo'<td>'.$value['emp_work_rate'].'</td>';
                          echo'<td>'.$value['emp_mileage_rate'].'</td>';
                          echo'<td>'.$emp_due_bal.'</td>';
                         */ echo'<td>'.$value['client_company_name'].'</td>';
                          echo'<td>'.$value['company_address'].'</td>';
                          echo'<td>'.$value['company_email'].'</td>';
                          echo'<td>'.$value['client_work_rate'].'</td>';
                          echo'<td>'.$value['duration'].'</td>';
                          echo'<td>'.$value['client_mileage_rate'].'</td>';
                          

                            if($value['mileage_status']== 1)
                              { 

                                echo'<td>'.$distance.'</td>';
                               }
                               else
                               { echo'<td></td>';

                               }

                          echo'<td>'.$client_due_bal.'</td>';
                          echo'<td>'.$due_date.'</td>';
                        
                        if($value['pdf_file']=='')
                         {
                          echo'<td>-</td>';
                         }
                        else
                        {
                          echo'<td><a href="https://eworxs.app/EworxsApi/pdfs/'.$value['pdf_file'].'"/><i class="fa fa-file-pdf-o" style="font-size:28px;color:red"></i></a></td>';
                        }
                         if($value['image']=='')
                         {
                          echo'<td>-</td>';
                         }
                        else
                        {

                          echo'<td><a target="_blank" href="'.$value['image'].'" download />Attachment</a></td>';
                        }

                       echo '<td>';
                       $checked='';
                        if($value['invoice_paid_status']==1)
                       {
                        $checked='checked';
                       } 
                   
                       echo   '<input onchange="chkboxHandler('.$id.')"'.$checked.'  type="checkbox"  value='.$data[0]['invoice_paid_status'].'  id="invoice_paid_status">';
                       echo  '</td>';

                        echo'<td><button type="button" class="btn btn-danger" id="add-employee-list-btn" onclick="deleteClientVisit('.$value['clientvisitesid'].')">Delete</button></td>';
                          echo'</tr>';
                        }
                  ?>
              </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    </section>
  </div>
</div>
<!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jQuery/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="plugins/jQuery/raphael-min.js"></script>
<!-- daterangepicker -->
<script src="plugins/jQuery/moment.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script type="text/javascript">

function deleteClientVisit(id)
{
 if(confirm("Are you sure you want to delete this?")){
    $.ajax({
        url:"AjaxDeleteClientVisit.php",
        data:{id:id
        },
        type:'post',
        dataType: 'json',
        success:function(response){
          alert(response.Message);
          location.reload();
        },
        error: function(xhr, status, error) {
      var err = eval("(" + xhr.responseText + ")");
      alert(err.Message);
    }
   });
}
}
</script>

<script type="text/javascript">
$('#password_submit').click(function(){
var old_pass = $('#old_password').val();
var new_pass = $('#new_password').val();
var new_pass_confirm = $('#new_password_confirm').val();

$.ajax({
    url:"ChangeAdminPassword.php",
    data:{OldPAss:old_pass,
    NewPAss:new_pass,
    NewPAssConfirm:new_pass_confirm},
    type:'post',
    success:function(response){
      alert(response);
      location.reload();
    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
    }
   });
});

$(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });

$('#empMobile').keydown(function(){
  //alert(this.value);
  //$("#myField").val(this.value.match(/[0-9]*/));
  if( this.value.length>9){
     this.value="";
     alert("value should not be more than 10 or less than 10.");
    return false;
  }
});

function addNewEmployee(){
  userType=3;
  var emp = document.getElementById('empType').value;
  if(emp=="Engineer"){
    userType=2;
  }
  var name = document.getElementById('empName').value;
  var mobile = document.getElementById('empMobile').value;
  var password = document.getElementById('empPassword').value;
  $.ajax({
      url:"CreateEmployee.php",
      data:{EmpName:name,UserType:userType,EmpMobile:mobile,EmpPassword:password},
      type:'post',
      success:function(response){
        alert(response);
        location.reload();
      },
      error: function(xhr, status, error) {
    var err = eval("(" + xhr.responseText + ")");
    alert(err.Message);
  }
     });
}

function showCaseDetail(id){
  var brand = $("#brand"+id).val();
  var model = $("#model"+id).val();
  var description = $("#description"+id).val();
  document.getElementById("brand1").innerHTML=brand;
  document.getElementById("model1").innerHTML=model;
  document.getElementById("problem1").innerHTML=description;
}

function deleteUser(id){
    $.ajax({
        url:"deleteUser.php",
        data:{UserId:id},
        type:'post',
        success:function(response){
          alert(response);
          location.reload();
        },
        error: function(xhr, status, error) {
      var err = eval("(" + xhr.responseText + ")");
      alert(err.Message);
      }
       });
  }

function editEmp(id){
  var name = $("#name"+id).val();
  var mobile = $("#mobile"+id).val();
  var userType = $("#userType"+id).val();
   $("#editempName").val(name);
   $("#editempMobile").val(mobile);
   $("#editempPassword").val("xxxxxxx");
   $("#editUserId").val(id);
   if(userType==2){
      $("#editempType").val("Engineer");
   }else{
      $("#editempType").val("Delivery Boy");
   }
}

function editEmployee(){
  userType=3;
  var emp = document.getElementById('editempType').value;
  if(emp=="Engineer"){
    userType=2;
  }
  var name = document.getElementById('editempName').value;
  var mobile = document.getElementById('editempMobile').value;
  var password = document.getElementById('editempPassword').value;
  var userId = document.getElementById('editUserId').value;
  $.ajax({
      url:"EditEmployee.php",
      data:{EmpName:name,UserType:userType,EmpMobile:mobile,EmpPassword:password,EmpId:userId},
      type:'post',
      success:function(response){
        alert(response);
        location.reload();
      },
      error: function(xhr, status, error) {
    var err = eval("(" + xhr.responseText + ")");
    alert(err.Message);
  }
     });
}

function showCaseList(array1){
$("#case_list").html('');
  array1.forEach(function(element) {
    console.log(element);
    $("#case_list").append('<li>'+element+'</li>');
});
}

function chkboxHandler(visit_id) {
          var chkbox = document.querySelector("input#invoice_paid_status")
          if (chkbox.checked) {
            chkbox.value = 1
          } else {
            chkbox.value = 0
          }

 $.ajax({
      url:"invoice_paid_status_update.php",
      data:{visit_id:visit_id,status:chkbox.value},
      type:'post',
      success:function(response){
        alert(response);
        location.reload();
      },
      error: function(xhr, status, error) {
    var err = eval("(" + xhr.responseText + ")");
    alert(err.Message);
  }
     });

        }
</script>
<script type="text/javascript">
$(function() {
  $("#example1").parent().css('overflow-x','scroll');
  $("#example1_wrapper").parent().css('overflow','unset');
});
</script>
<?php include "checkcompanystatus.php"; ?>
</body>
</html>
