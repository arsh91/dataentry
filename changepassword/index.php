<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Change Password</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
<?php
    include '../db_connection.php';
    include '../includes/auth.php';
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
?>
 <!-- Vendor CSS Files -->
 <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
 <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<style>
</style>
</body>
<main id="main" class="main">
        <!-- Navigation -->
        <?php
            include '../includes/header.php';
            $LoginUserId =$_SESSION['user']['Id'];
            $showSuccessMsg ="display:none";
            $errors =array();
            if(isset($_POST) && !empty($_POST)){
                $password = '';
                if(isset($_POST['new_password']) && !empty($_POST['new_password'])){
                    $password = $_POST['new_password'];
                } else {
                    $errors['new_password'] = 'Please enter your new password!';
                }
                if(empty($errors)) {
                    $changePassword =  $db->query('UPDATE Users SET password =? WHERE Id=?', $password,  $_SESSION['user']['Id']);
                    $showSuccessMsg ="";
                }
              }
        ?>
        <!-- Navigation -->
        <section class="section">
            <div class="row">
               <div class="col-md-12" style="display: flex; justify-content: center;">
               <div class="card" style="width:705px;">
                    <div class="card-header" style="color: #012970;">
                        <h1>Change password</h1>
                    </div>
                    <div class="card-body">
                        <div class="box-header with-border" id="filter-box">
                        <?php 
                            if(isset($errors['new_password'])) { ?>
                        <div class="alert alert-danger mt-2" role="alert">
                            <?php echo $errors['new_password']; ?>
                        </div>
                        <?php } ?>
                        <div class="alert alert-success mt-2 message" style="<?php echo $showSuccessMsg;?>">
                           Password changed successfully!
                            </div>
                            <br>
                            <form method="post" action="" id="checkAdharCardForm" class="needs-validation" novalidate>
                                <div class="modal-body">
                                    <!-- <div class="row mb-4">
                                        <label for="current_password" class="col-sm-3 col-form-label required">Current Password</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="current_password" id="current_password" required>
                                        </div>
                                    </div> -->
                                    <div class="row mb-4">
                                        <label for="new_password" class="col-sm-3 col-form-label required">New Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" name="new_password" id="new_password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </section>
    </main>
 <!-- Vendor JS Files -->
 <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- <script src="//code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="../assets/js/jquery.js"></script>
 <!-- Template Main JS File -->
 <script src="../assets/js/main.js"></script>
 <script src="../assets/js/common.js"></script>
<script type="text/javascript">
$(document).ready(function() {
});
setInterval(function(){ 
    updateUserActivity('<?php echo $LoginUserId; ?>');
}, 10000);
</script>
</body>
</html>