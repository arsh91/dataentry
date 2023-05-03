<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Users</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
<?php
    include '../db_connection.php';
	include '../includes/css.php';
    include '../includes/auth.php';
?>
</head>
<style>
.poniter{
    cursor: pointer;
}
</style>
</body>
<main id="main" class="main">
        <!-- Navigation -->
        <?php
        date_default_timezone_set('Asia/Kolkata');
            $showSuccessMsg ="display:none";
            include '../includes/header.php';
            $LoginUserId =$_SESSION['user']['Id'];
            if(isset($_POST) && !empty($_POST)){
                $email=null;
                if(isset($_POST['email']) && !empty($_POST['email'])){
                    $email = $_POST['email'];
                } 
                $UsersData =  $db->query('INSERT into Users (Name, Phone, Email, State, password, Role, Created_at) VALUES (?, ?, ?, ?, ?, ?, ?)', $_POST['name'], $_POST['phone'], $email, $_POST['state'], $_POST['password'], 4, date("Y-m-d H:i:s"));
                $showSuccessMsg="";
            }
             if(isset($_SESSION['user']['Role']) && $_SESSION['user']['Role'] ==1){
                $UsersData = $db->query("SELECT * FROM Users WHERE Role != 1 ORDER BY last_activity DESC")->fetchAll();  
             }else{
                $UsersData = $db->query("SELECT * FROM Users WHERE Role != 1 AND ROLE !=4 ORDER BY last_activity DESC")->fetchAll();  
             }
        ?>
        <!-- Navigation -->
        <div class="pagetitle">
            <h1>Users List</h1>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
               <div class="col-md-12">
               <div class="card">
        <div class="card-body">
        <?php if(isset($_SESSION['user']['Role']) && $_SESSION['user']['Role'] ==1){?>
        <button class="btn btn-primary mt-3" onClick="openAddInchargeModal()">ADD INCHARGE USER</button>
        <?php } ?>
               <div class="box-body table-responsive mt-3" style="margin-bottom: 5%">
               <div class="alert alert-success mt-2" style="<?php echo $showSuccessMsg;?>">
               Incharge user created successfully.
                </div>
               <div class="alert alert-success mt-2 message" style="display:none">
                </div>
                    <table class="table table-borderless dashboard" id="selfDeclarationTable">
                        <thead>
                            <tr>
                                <th>Online</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>State</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(count($UsersData) >0){
                            foreach($UsersData as $data){
                                $current_time = date("Y-m-d H:i:s"); 
                                $time_difference = strtotime($current_time) - strtotime($data['last_activity']);
                                if($time_difference > 1800){
                                    $onlineUser ='color:#ff9c07;';
                                }else{
                                    $onlineUser ='color:#208719c7;';
                                }
                        ?>
                            <tr>
                                <td> <i style="<?php echo $onlineUser;?>font-size: 12px;" class="bi bi-circle-fill me-2"></i><?php
                                if(!empty($data['last_activity'])){
                                    echo date("m-d-Y h:i a", strtotime($data['last_activity']));
                                }else{
                                    echo "----";
                                } ?></td>
                                <td><?php echo $data['Name']?></td>
                                <td><?php echo $data['Phone']?></td>
                                <td><?php echo $data['Email']?></td>
                                <td><?php echo $data['password']?></td>
                                <td><?php echo $data['State']?></td>
                                <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="roleuser_<?php echo $data['Id'];?>" id="dataentryuser_<?php echo $data['Id'];?>" onclick="changeRoleFunc('<?php echo $data['Id'];?>', 3)"
                                            <?php echo ($data['Role']===3 ? 'checked' : '');?>>
                                            <label class="form-check-label" for="dataentryuser">
                                                Data Entry User
                                            </label>
                                            </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="roleuser_<?php echo $data['Id'];?>" id="proofinguser_<?php echo $data['Id'];?>" onclick="changeRoleFunc('<?php echo $data['Id'];?>', 2)"
                                            <?php echo ($data['Role']===2 ? 'checked' : '');?>>
                                            <label class="form-check-label" for="proofinguser">
                                                Proofing User
                                            </label>
                                        </div>
                                        <?php if(isset($_SESSION['user']['Role']) && $_SESSION['user']['Role'] !=4){?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="roleuser_<?php echo $data['Id'];?>" id="inchargeuser_<?php echo $data['Id'];?>" onclick="changeRoleFunc('<?php echo $data['Id'];?>', 4)"
                                            <?php echo ($data['Role']===4 ? 'checked' : '');?>>
                                            <label class="form-check-label" for="inchargeuser">
                                                Incharge User
                                            </label>
                                        </div>
                                        <?php } ?>
                                </td>
                            </tr>
                            <?php
                            }
                        }else{
                            ?>
                           <tr>
                                <td colspan="6">No data found.</td>
                            </tr>
                            <?php
                        }
                           ?>
                        </tbody>
                    </table>
                </div>
                </div>
                    </div>
                    </div>
            </div>

<!--start: create incharge user Modal -->
<div class="modal fade" id="addInchargeUserModal" tabindex="-1" aria-labelledby="addInchargeUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInchargeUserModalLabel">Create Incharge User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="addInchargeUserModalForm" name="addInchargeUserModalForm" action="" class="needs-validation" novalidate>
               <div class="alert alert-danger mt-2 me-2 errormessage" style="display:none;margin-left:7px;">
                    </div>
                <div class="modal-body">
                <div class="col-12">
                      <label for="yourName" class="form-label">Your Name</label>
                      <input type="text" name="name" class="form-control" id="yourName" required>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Your Phone</label>
                      <input type="text" name="phone" class="form-control" id="yourPhone" required>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Your Email</label>
                      <input type="email" name="email" class="form-control" id="yourEmail">
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">State</label>
                      <input type="text" name="state" class="form-control" id="yourState" required>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <div style="display: flex;">
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <i class="bi bi-eye-slash mt-2" id="eye" style="margin-left: -30px; cursor: pointer;"></i>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Confirm Password</label>
                      <input type="password" name="confirmpassword" class="form-control" id="confirmpassword" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="createIncharge" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end:  create incharge user Modal -->
        </section>
    </main>
<?php
	include '../includes/js.php';
?>
<!-- <script src="//code.jquery.com/jquery-1.12.4.js"></script>-->
<script src="../assets/js/jquery.js"></script> 
<!-- Include DataTables JS -->
<!-- <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> -->
<script src="../assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    setTimeout(function() {
        $('.message').fadeOut("slow");
    }, 1000);

    $('#selfDeclarationTable').DataTable({
        "order": []
        //"columnDefs": [ { "orderable": false, "targets": 7 }]
    });

    // function to show password
    $('#eye').click(function(){
       if($(this).hasClass('bi-eye-slash')){
         $(this).removeClass('bi-eye-slash');
         $(this).addClass('bi-eye');
         $('#yourPassword').attr('type','text');
       }else{
         $(this).removeClass('bi-eye');
         $(this).addClass('bi-eye-slash');  
         $('#yourPassword').attr('type','password');
       }
   });
    
});
function changeRoleFunc(id,roleStatus){
    $.ajax({
        type: "POST",
        url: "changeUserRole.php",
        data: {
            id: id,
            roleStatus: roleStatus
        },
        dataType: 'json',
        success: function(res) {
            if(res.status =="1"){
                $(".message").html('User role changed successfully!');
                $(".message").show();
            }
        }
    });
}

// to orpn modal
function openAddInchargeModal(){
    $("#addInchargeUserModalForm").removeClass("was-validated");
    $('#addInchargeUserModalForm')[0].reset(); 
    $(".errormessage").html('');
    $(".errormessage").hide();
    $("#addInchargeUserModal").modal("show");
}

    // function to check validation of incharge user form
    $('#addInchargeUserModalForm').submit(function(event) {
    var password = $("#yourPassword").val();
    var confirmPassword = $("#confirmpassword").val();
    var name = $("#yourName").val();
    var phone = $("#yourPhone").val();
    var state = $("#yourState").val();
    var error =0;
    if(!name){error++; return false;}
    if(!phone){error++; return false;}
    if(!state){error++; return false;}
    if(!password){error++; return false;}
    if(!confirmPassword){error++; return false;}
    
    if(password != confirmPassword){
        event.preventDefault();
        error++;
        $(".errormessage").html('Please enter same passwords!');
        $(".errormessage").show();
    }
   
    if(error ==0){
        $('form[name=addInchargeUserModalForm]').submit();
    }
});
setInterval(function(){ 
    updateUserActivity('<?php echo $LoginUserId; ?>');
}, 10000);
</script>
</body>
</html>