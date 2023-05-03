<!DOCTYPE html>
<html lang="en">
<?php
    include 'db_connection.php';
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>
</body>
<?php
	$errors = array();
	if(isset($_POST) && !empty($_POST)){
        $phone = $password = '';
        if(isset($_POST['phone']) && !empty($_POST['phone'])){
            $phone = $_POST['phone'];
        } else {
            $errors['phone'] = 'Please enter your phone!';
        }

        if(isset($_POST['password']) && !empty($_POST['password'])){
            $password = $_POST['password'];
        } else {
            $errors['password'] = 'Please enter your password!';
        }
        if(empty($errors)) {
			$account = $db->query('SELECT * FROM Users WHERE phone = ? AND password = ?', $phone,  $password)->fetchArray();
			if(!empty($account)) {
				$_SESSION['user'] = $account;
				header("Location: dashboard"); 
				exit;
			} else { 
				$errors['auth'] = "Invalid Phone or Password.";
			}
		}
    }
?>
<main>
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">Management</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                    </div>

                                    <form method="post" action=""
                                        class="row g-3 needs-validation" novalidate>
                                        <?php 
                                            if(isset($errors['auth'])) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $errors['auth']; ?>
                                        </div>
                                        <?php } ?>
                                        <div class="col-12">
                                            <label for="phone" class="form-label">Phone</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="phone" class="form-control" id="phone"
                                                    required>
                                            </div>
                                            <?php 
                                            if(isset($errors['phone'])) { ?>
                                            <div class="invalid-feedback" style="display:block;">
                                                <?php echo $errors['phone']; ?>
                                            </div>
                                            <?php } ?>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control"
                                                id="yourPassword" required>
                                                <?php 
                                            if(isset($errors['password'])) { ?>
                                            <div class="invalid-feedback" style="display:block;">
                                                <?php echo $errors['password']; ?>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Don't have account? <a href="/register">Create an account</a></p>
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
  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>