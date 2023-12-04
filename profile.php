<?php
include "header.php";
if ($_SESSION["role"] == 1) {
    echo "<script> window.location = 'admin_login.php'</script>";
}

// echo "<pre>";
// print_r($_SESSION);
// if(isset($_SESSION['company_status'])){

 
  // if($_SESSION['company_status']== 0){
  //   echo "<script> window.location = 'admin_login.php'</script>";
  // }
// }

$db = db_connect();



$company_id = $_SESSION["companyid"];
$sql ="select username,address,email,first_name,last_name,company_name,phone,logo,postal_code,status,send_invoice_status_client from companies where id=" .
    $company_id;
$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);

// echo "<pre>";
// print_r($_SESSION);

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
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>

<style>
  #toggleForm123 input[type=checkbox]{
   height: 0;
   width: 0;
   visibility: hidden;
}

#toggleForm123 label {
   cursor: pointer;
   text-indent: -9999px;
   width: 50px;
   height: 28px;
   background: grey;
   display: block;
   border-radius: 100px;
   position: relative;
}

#toggleForm123 label:after {
   content: '';
   position: absolute;
   top: 2px;
   left: 5px;
   width:23px;
   height: 23px;
   background: #fff;
   border-radius: 90px;
   transition: 0.3s;
}

#toggleForm123 input:checked + label {
   background: #3e276d;
}

#toggleForm123 input:checked + label:after {
   left: calc(100% - 5px);
   transform: translateX(-100%);
}


#toggleForm123 label:active:after {
   width: 32px;
}

   /* Style for the tooltip */
   .tooltip1 {
      position: relative;
      display: inline-block;
   }

   .tooltip1 .tooltiptext {
      visibility: hidden;
      width: 200px;
      background-color: #333;
      color: #fff;
      text-align: center;
      border-radius: 5px;
      padding: 5px;
      position: absolute;
      z-index: 1;
      bottom: 125%;
      left: 50%;
      transform: translateX(-50%);
      opacity: 0;
      transition: opacity 0.3s;
   }

   .tooltip1:hover .tooltiptext {
      visibility: visible;
      opacity: 1;
   }

   body {
      padding: 0px !important;
   }

   .scrollbar {
      height: 70px;
      width: 145px;
      overflow-x: unset !important;
      overflow-y: overlay;
   }

   .force-overflow {
      min-height: 0px;
   }

   #style-2::-webkit-scrollbar-track {
      -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
      border-radius: 10px;
   }

   #style-2::-webkit-scrollbar {
      width: 6px;
   }

   #style-2::-webkit-scrollbar-thumb {
      border-radius: 10px;
      -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
   }

   body {
      background: rgb(99, 39, 120)
   }

   .form-control:focus {
      box-shadow: none;
      border-color: #BA68C8
   }

   .back:hover {
      color: #682773;
      cursor: pointer
   }

   .labels {
      font-size: 11px
   }

   .add-experience:hover {
      background: #BA68C8;
      color: #fff;
      cursor: pointer;
      border: solid 1px #BA68C8
   }

   .mt-5 {
      margin-top: 15px;
   }
     .profile_error {
      font-size: 14px;
      color: red;
      margin-right: 10px;
      line-height: 3.2;
   }
</style>

<body class="hold-transition skin-blue sidebar-mini">
   <div class="wrapper">
      <?php include "left_side_bar.php"; ?>
      <div class="content-wrapper">
         <section class="content-header">
            <h1 class="make-inline" style="margin-left:22%">Profile</h1>
            <a href="subscriptions.php"><button style="margin-right:22%;margin-top:5px;" class="btn btn-warning pull-right">Subscription  <i class="fa fa-file-excel-o"></i></button></a>
            <div class="profile_error  pull-right" id="profile_error_msg"></div>  
         </section>
         <!-- Main content -->
         <section class="content">
            <section class="content">
               <div class="row">
                  <div class="">
                     <div class="box" style="width:60%;margin:0 auto;">
                        <!-- /.box-header -->
                        <div class="box-body">
                           <div class=" rounded bg-white mt-5 mb-5">
                              <div class="row">
                                 <div class="modal fade" id="GSCCModal" role="dialog">
                                    <div class="modal-dialog">

                                       <!-- Modal content-->
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal">×</button>
                                             <h4 class="modal-title">Change Password</h4>
                                          </div>
                                          <div class="modal-body">
                                             <div class="user-info-area">
                                                <div class="row ">
                                                   <div class="col-md-4">
                                                      <div class="personal-info-label">Old Password</div>
                                                      <input type="text" class="form-control" id="old_pass" />
                                                   </div>

                                                   <div class="col-md-4">
                                                      <div class="personal-info-label">New Password</div>
                                                      <input type="text" class="form-control" id="new_pass" />
                                                   </div>

                                                   <div class="col-md-4">
                                                      <div class="personal-info-label">Confirm Password</div>
                                                      <input type="text" class="form-control" id="confirm_pass" />
                                                   </div>

                                                </div>
                                                <hr />
                                                <input id="company" type="hidden" value="<?php echo $company_id; ?>">
                                             </div>
                                          </div>

                                          <div class="modal-footer">
                                             <button type="button" class="btn theme-btn" id="password_submit1">Update</button>
                                             <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-12 ">
                                    <form method="post" id="form">
                                       <div class="p-3 py-5">
                                          <div class="d-flex justify-content-between align-items-center mb-3">
                                             <h4 class="text-right">Profile Settings</h4>
                                             <h5 class="text-right">
                                                <span class="" id="email"><?php echo $data[0]["email"]; ?></span>
                                             </h5>
                                          </div>
                                          <div class="row mt-2">
                                             <div class="col-md-12" style="margin-bottom: 8px;">
                                                <label class="labels">User Name</label>
                                                <sup><i class="fa fa-asterisk" style="font-size: 8px;color:#ff111194"></i></sup>
                                                <input type="text" class="form-control" id="user_name" placeholder="user name" value="<?php echo $data[0]["username"]; ?>">
                                             </div>
                                          </div>
                                          <div class="row mt-2">
                                             <div class="col-md-6" style="margin-bottom: 8px;">
                                                <label class="labels">Name</label>
                                                <sup><i class="fa fa-asterisk" style="font-size: 8px;color:#ff111194"></i></sup>
                                                <input type="text" class="form-control" id="first_name" placeholder="first name" value="<?php echo $data[0]["first_name"]; ?>">
                                             </div>
                                             <div class="col-md-6">
                                                <label class="labels">Lastname</label>
                                                <sup><i class="fa fa-asterisk" style="font-size: 8px;color:#ff111194"></i></sup>
                                                <input type="text" class="form-control" id="last_name" value="<?php echo $data[0]["last_name"]; ?>" placeholder="lastname">
                                             </div>
                                          </div>
                                          <div class="row mt-3">
                                             <div class="col-md-12" style="margin-bottom: 8px;">
                                                <label class="labels">Company Name</label>
                                                <sup><i class="fa fa-asterisk" style="font-size: 8px;color:#ff111194"></i></sup>
                                                <input type="text" class="form-control" id="company_name" placeholder="company name" value="<?php echo $data[0]["company_name"]; ?>">
                                             </div>
                                             <div class="col-md-12" style="margin-bottom: 8px;">
                                                <label class="labels">Phone</label>
                                                <sup><i class="fa fa-asterisk" style="font-size: 8px;color:#ff111194"></i></sup>
                                                <input type="text" class="form-control" placeholder="phone" id="phone" value="<?php echo $data[0]["phone"]; ?>">
                                             </div>
                                             <div class="col-md-12" style="margin-bottom: 8px;">
                                                <label class="labels">Postalcode</label>
                                                <sup><i class="fa fa-asterisk" style="font-size: 8px;color:#ff111194"></i></sup>
                                                <input type="text" class="form-control" id="postal_code" placeholder="postal code" value="<?php echo $data[0]["postal_code"]; ?>">
                                             </div>
                                             <div class="col-md-12" style="margin-bottom: 8px;">
                                                <label class="labels">Address(Include city and state)</label>
                                                <sup><i class="fa fa-asterisk" style="font-size: 8px;color:#ff111194"></i></sup>
                                                <input type="text" class="form-control" id="autocomplete" placeholder="address" value="<?php echo $data[0]["address"]; ?>">
                                             </div>
                                             <div class="col-md-12" style="margin-bottom: 8px;">
                                                <label class="labels">
                                                   <span class="tooltip1">
                                                      <span style="cursor:help;background-color: #f0f0f0; color: #333; border-radius: 50%; padding: 2px; font-weight: bold;">?</span>
                                                      <span class="tooltiptext">when checkbox is checked then invoice will be sent to the client otherwise will be sent to the company</span>
                                                   </span> Send Invoice To Client
                                                </label>
                                                <?php
                          $checked = "";
                          if ($data[0]["send_invoice_status_client"] == 1) {
                              $checked = "checked";
                          }
                          ?>
                                                <input style="vertical-align: text-top;" onchange="chkboxHandler()" <?php echo $checked; ?> type="checkbox" value="<?php echo $data[0]["send_invoice_status_client"]; ?>" id="client_invoice_check">
                                             </div>

                                             <div class="col-md-12" style="margin-bottom: 8px;">
                                             <div id="toggleForm123">
                                                  
                                                    <div>Track on/Track off for mileage</div>
                                                    <div class="form-group">
                                                      <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name='machine_state'>
                                                        <label class="custom-control-label" id="statusText" for="customSwitch1"></label>
                                                      </div>
                                                    </div>
                                                 
                                                </form>
                                             </div>

                                             <div class="text-center">



       

                                                <button class="mt-5 btn theme-btn" type="button" onclick="updateProfile()">Save Profile</button>  
                                                <button class="mt-5 btn theme-btn" type="button" data-toggle="modal" data-target="#GSCCModal">Change Password</button>
                                             </div>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
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
      $('#password_submit1').click(function() {
         var old_pass = $('#old_pass').val();
         var new_pass = $('#new_pass').val();
         var new_pass_confirm = $('#confirm_pass').val();
         var match = new_pass.match(/^(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/);
         if (match == null) {
            alert("Please enter atleast 1 Number, 1 Special Character and Minimum 8 Characters In New Password Field");
            return false;
         }

         if (new_pass != new_pass_confirm) {
            alert("password and confirm password should be same");
            return false;
         }

         $.ajax({
            url: "changecompanypassword.php",
            data: {
               OldPAss: old_pass,
               NewPAss: new_pass,
               NewPAssConfirm: new_pass_confirm
            },
            type: 'post',
            success: function(response) {
               alert(response);
               location.reload();
            },
            error: function(xhr, status, error) {
               var err = eval("(" + xhr.responseText + ")");
               alert(err.Message);
            }
         });
      });

      $(function() {
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

      function updateProfile() {
         var user_name = document.getElementById('user_name').value
         var first_name = document.getElementById('first_name').value;
         var last_name = document.getElementById('last_name').value;
         var postal_code = document.getElementById('postal_code').value;
         var phone = document.getElementById('phone').value;
         var company_name = document.getElementById('company_name').value;
         var address = document.getElementById('autocomplete').value;
         var client_invoice_check = document.getElementById('client_invoice_check').value;
         var email = document.getElementById('email').textContent;

         if (user_name == '') {
            alert("user name field should not be empty");
            document.getElementById('user_name').focus();
            return false;
         }

         if (first_name == '') {
            alert("first name field should not be empty");
            document.getElementById('first_name').focus();
            return false;
         }

         if (last_name == '') {
            alert("last name field should not be empty");
            document.getElementById('last_name').focus();
            return false;
         }

         if (postal_code == '') {
            alert("postal code field should not be empty");
            document.getElementById('postal_code').focus();
            return false;
         }

         if (phone == '') {
            alert("phone field should not be empty");
            document.getElementById('phone').focus();
            return false;
         }

         if (phone.length < 9) {
            this.value = "";
            alert("phone length should be equal 10 digit");
            document.getElementById('phone').focus();
            return false;
         }

         if (company_name == '') {
            alert("comapny name field should not be empty");
            document.getElementById('company_name').focus();
            return false;
         }

         if (address == '') {
            alert("address field should not be empty");
            document.getElementById('autocomplete').focus();
            return false;
         }

         if (email == '') {
            alert("email field should not be empty");
            document.getElementById('email').focus();
            return false;
         }
         $.ajax({
            url: "editprofile.php",
            data: {
               first_name: first_name,
               user_name: user_name,
               last_name: last_name,
               postal_code: postal_code,
               phone: phone,
               company_name: company_name,
               address: address,
               email: email,
               client_invoice_check: client_invoice_check
            },
            type: 'post',
            success: function(response) {
               alert(response);
               location.reload();
            },
            error: function(xhr, status, error) {
               var err = eval("(" + xhr.responseText + ")");
               alert(err.Message);
            }
         });
      }

      function isEmail(email) {
         var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
         return regex.test(email);
      }
   </script>
   <script type="text/javascript">
      $(function() {
         $("#example1").parent().css('overflow-x', 'scroll');
         $("#example1_wrapper").parent().css('overflow', 'unset');
      });

      function chkboxHandler() {
         var chkbox = document.querySelector("input#client_invoice_check")
         if (chkbox.checked) {
            chkbox.value = 1
         } else {
            chkbox.value = 0
         }
      }
   </script>

     <script type="text/javascript">
      $(document).ready(function() {
         $("#profile_error_msg").text("");
         $.ajax({
            url: 'check_profile.php', // URL to your PHP script
            method: 'GET',
            dataType: 'text',
            success: function(response) {
               // console.log("hello");
               if (response.trim() === 'incomplete') {
                  $("#profile_error_msg").text("* Complete profile information to see other features of platform");
               }
            },
            error: function() {
               console.error("An error occurred during profile check.");
            }
         });

      });
   </script>
   
<script>


function putStatus() {
    $.ajax({
        type: "GET",
        url: "mileage_toggle_status_get.php",
        data: {toggle_select: true},
        dataType: 'json',
        success: function (result) {
         console.log(result);
         console.log(result.status);
            if (result.status == 'success' && result.newStatus == '1') {
                $('#customSwitch1').prop('checked', true);
                statusText(1);
            } else {
                $('#customSwitch1').prop('checked', false);
                statusText(0);
            }  
            // lastUpdated();
        }
    });
}

function statusText(status_val) {
    if (status_val == 1) {
        var status_str = "On (active)";
    } else {
        var status_str = "Off (deactive)";
    }
    document.getElementById("statusText").innerText = status_str;
}

function onToggle() {
   
    $('#toggleForm123 :checkbox').change(function () {
     
        if (this.checked) {
            
            updateStatus(1);
            statusText(1);
        } else {
            // alert('NOT checked');
            updateStatus(0);
            statusText(0);
        }
    });
}

function updateStatus(status_val) {
    $.ajax({
        type: "POST",
        url: "mileage_toggle_status.php",
        data: {status: status_val},
        success: function (result) {
            console.log(result);
            // lastUpdated();
        }
    });
}


$(document).ready(function () {
    putStatus();//Set button to current status
    onToggle();//Update when toggled
    statusText();//Last updated text
});
</script>

<script src="https://maps.google.com/maps/api/js?key=AIzaSyCwpns7FoF40IUPN4ianDrtxsOY9zR0RwE&libraries=places&callback=initAutocomplete" type="text/javascript"></script>
   <script src="address.js"></script>

   <?php include "checkcompanystatus.php"; ?>
</body>

</html>