<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Register</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
<?php
    include '../db_connection.php';
	include '../includes/css.php';
  date_default_timezone_set('Asia/Kolkata');
    $showSuccessMsg ="display:none";
	$errors = array();
	if(isset($_POST) && !empty($_POST)){
        $name = $phone = $state = $password = '';
        if(isset($_POST['name']) && !empty($_POST['name'])){
            $username = $_POST['name'];
        } else {
            $errors['name'] = 'Please, enter your name!';
        }

        if(isset($_POST['phone']) && !empty($_POST['phone'])){
            $phone = $_POST['phone'];
        } else {
            $errors['phone'] = 'Please enter your phone!';
        }

        if(isset($_POST['password']) && !empty($_POST['password'])){
            // $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $password = $_POST['password'];
        } else {
            $errors['password'] = 'Please enter your password!';
        }

        if(isset($_POST['state']) && !empty($_POST['state'])){
            $state = $_POST['state'];
        } else {
            $errors['state'] = 'Please enter your state!';
        }

        if(isset($_POST['confirmpassword']) && !empty($_POST['confirmpassword'])){
            $confirmpassword = $_POST['confirmpassword'];
        } else {
            $errors['confirmpassword'] = 'Please enter confirm password!';
        }

        if(isset($password) && !empty($password) && isset($confirmpassword) && !empty($confirmpassword)){
          if($password != $confirmpassword){
            $errors['confirmpassword'] = 'Please enter same passwords!';
          }
        } 
            
        $email=null;
        if(isset($_POST['email']) && !empty($_POST['email'])){
            $email = $_POST['email'];
        } 
        if(empty($errors)) {
            $registerData =  $db->query('INSERT into Users (Name, Phone, Email, State, password, Role, Created_at) VALUES (?, ?, ?, ?, ?, ?, ?)', $username, $phone, $email, $state, $password, 3,date('Y-m-d H:i:s'));
            $showSuccessMsg="";
		}
    }
?>
</head>
</body>
<main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Data Entry</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>
                  <div class="alert alert-success message" style="<?php echo $showSuccessMsg;?>">
                   Account created successfully!
                  </div>
                  <form method="post" action="" class="row g-3 needs-validation" novalidate>
                  <?php 
                      if(isset($errors['confirmpassword'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errors['confirmpassword']; ?>
                    </div>
                    <?php } ?>
                    <div class="col-12">
                      <label for="yourName" class="form-label">Your Name</label>
                      <input type="text" name="name" class="form-control" id="yourName" required>
                      <?php
                      if(isset($errors['name'])) { ?>
                        <div class="invalid-feedback" style="display:block;">
                            <?php echo $errors['name']; ?>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Your Phone</label>
                      <input type="text" name="phone" class="form-control" id="yourPhone" required>
                      <?php
                      if(isset($errors['phone'])) { ?>
                        <div class="invalid-feedback" style="display:block;">
                            <?php echo $errors['phone']; ?>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Your Email</label>
                      <input type="email" name="email" class="form-control" id="yourEmail">
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">State</label>
                      <input type="text" name="state" class="form-control" id="yourState" required>
                      <?php
                      if(isset($errors['state'])) { ?>
                        <div class="invalid-feedback" style="display:block;">
                            <?php echo $errors['state']; ?>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <div style="display: flex;">
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <i class="bi bi-eye-slash mt-2" id="eye" style="margin-left: -30px; cursor: pointer;"></i>
                      </div>
                      <?php
                      if(isset($errors['password'])) { ?>
                        <div class="invalid-feedback" style="display:block;">
                            <?php echo $errors['password']; ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Confirm Password</label>
                      <input type="password" name="confirmpassword" class="form-control" id="confirmpassword" required>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Create Account</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="/">Log in</a></p>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->
<?php
	include '../includes/js.php';
?>
<!-- <script src="//code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="../assets/js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {
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
</script>
</body>
</html>