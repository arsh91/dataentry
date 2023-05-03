<?php
 if (isset($_POST['downloadcsv']))
 {   
     $fields = array('District', 'State'); // CSV column headings
     $delimiter = ","; 
     $filename = "sample_".date('Y-m-d-H-i-s').".csv"; 
     $f = fopen("php://output", "w");
     fputcsv($f, $fields, $delimiter);
     fclose($f);
     // Telling browser to download file as CSV
     header('Content-Type: text/csv'); 
     header('Content-Disposition: attachment; filename="'.$filename.'";'); 
     exit();
 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>CSV Uploader</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
<?php
    include '../db_connection.php';
	include '../includes/css.php';
    include '../includes/auth.php';
//     ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>
</head>
<style>
</style>
</body>
<main id="main" class="main">
        <!-- Navigation -->
        <?php
            include '../includes/header.php';
            date_default_timezone_set('Asia/Kolkata');
            $LoginUserId =$_SESSION['user']['Id'];
            $showSuccessMsg ="display:none";
            $errors=array();
            if (isset($_POST['submit']))
            {       
                $fileMimes = array(
                    'text/x-comma-separated-values',
                    'text/comma-separated-values',
                    'application/octet-stream',
                    'application/vnd.ms-excel',
                    'application/x-csv',
                    'text/x-csv',
                    'text/csv',
                    'application/csv',
                    'application/excel',
                    'application/vnd.msexcel',
                    'text/plain'
                );
                // Validate selected file is a CSV file or not
                if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes))
                {
                     // Open uploaded CSV file with read-only mode
                    $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
           
                    // Skip the first line
                    fgetcsv($csvFile);
           
                    // Parse data from CSV file line by line        
                    while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE)
                    {
                        $District = $getData[0];
                        $State = $getData[1];
                        
                    //query for fetch data  from SelfDeclarations table According to adharCard value
                    $locationsData =  $db->query('INSERT into Locations (District, state) VALUES (?, ?)', $District, $State);
                        $showSuccessMsg ="";
                    }
                    // Close opened CSV file
                    fclose($csvFile);
                }else{
                    $errors['file'] ="Please select valid file";
                }
              }
        ?>
        <!-- Navigation -->
        <section class="section">
            <div class="row">
               <div class="col-md-12" style="display: flex; justify-content: center;">
               <div class="card" style="width:705px;">
                    <div class="card-header" style="color: #012970;">
                        <h1>CSV Uploader</h1>
                    </div>
                    <div class="card-body">
                        <div class="box-header with-border" id="filter-box">
                        <?php 
                            if(isset($errors['file'])) { ?>
                        <div class="alert alert-danger mt-2" role="alert">
                            <?php echo $errors['file']; ?>
                        </div>
                        <?php } ?>
                        <div class="alert alert-success mt-2 message" style="<?php echo $showSuccessMsg;?>">
                           CSV uploaded successfully!
                            </div>
                            <br>
                            <div style="display: flex; justify-content: center;">
                            <form method="POST" action="" name="uploadcsvform" id="uploadcsvform" enctype="multipart/form-data">
                                <div class="modal-body text-center">
                                    <!-- <div class="row mb-4"> -->
                                    <button class="btn btn-light-primary me-3 mb-4" style="color: #009EF7;border-color: #F1FAFF;background-color: #F1FAFF;" onclick="document.getElementById('csvupload').click(); return false;"> Choose CSV<i class="bi-upload"></i></button>
                                    <input type="file" name="file" id="csvupload" style="display:none">
                                    <!-- </div> -->
                                </div>
                                <div style="margin-left: 186px;" class="text-center">
                                <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                            </div>
                            </form>
                            <form action="" method="post">
                                <input type="submit" style="color: #009EF7;border-color: #F1FAFF;background-color: #F1FAFF;" value="Download Sample CSV"  name="downloadcsv" class="btn btn-primary mb-4"></input>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </section>
    </main>
<?php

	include '../includes/js.php';
?>
<!-- <script src="//code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="../assets/js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {
   
});
setInterval(function(){ 
    updateUserActivity('<?php echo $LoginUserId; ?>');
}, 10000);
</script>
</body>
</html>