<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- <script src="//code.jquery.com/jquery-1.12.4.js"></script> -->
  <script src="../assets/js/jquery.js"></script>
<!-- Include DataTables JS -->
<script src="../assets/js/jquery.dataTables.min.js"></script>
<script src="../assets/js/select2.min.js"></script>
<?php
    include '../db_connection.php';
	include '../includes/css.php';
    include '../includes/auth.php';
    $LoginUserId =$_SESSION['user']['Id'];
    // $draftCount=$proofedCount=$pendingProof=0;
    if(isset($_POST) && !empty($_POST)){
        $draftCount = $db->query("SELECT COUNT(id) as draftcount FROM SelfDeclarations WHERE state=?", $_POST['state'])->fetchArray();  
        $proofedCount = $db->query("SELECT COUNT(id) as proofedcount FROM SelfDeclarations WHERE Status ='proofed' AND State=?", $_POST['state'])->fetchArray();  
        $pendingProof = $db->query("SELECT COUNT(id) as pendingproof FROM SelfDeclarations WHERE Status ='draft' AND State =?", $_POST['state'])->fetchArray();  
        ?>
        <script>$(document).ready(function() { $('#state').val('<?php echo $_POST['state']; ?>');})</script>
<?php
    }else{
        $draftCount = $db->query("SELECT COUNT(id) as draftcount FROM SelfDeclarations")->fetchArray();  
        $proofedCount = $db->query("SELECT COUNT(id) as proofedcount FROM SelfDeclarations WHERE Status ='proofed'")->fetchArray();  
        $pendingProof = $db->query("SELECT COUNT(id) as pendingproof FROM SelfDeclarations WHERE Status ='draft'")->fetchArray();
    }
    $draftCount=$draftCount['draftcount'];
    $proofedCount=$proofedCount['proofedcount'];
    $pendingProof=$pendingProof['pendingproof'];
?>
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="../assets/css/select2.min.css"/>
</head>
<style>
    .select2-container {
        border: 1px solid #ced4da !important;
        width: 351px;
        border-radius: 4px;
        padding: 0.375rem 2.25rem 0.375rem 0.75rem;
        -moz-padding-start: calc(0.75rem - 3px);
        -webkit-appearance: none;
        -moz-appearance: none;
        background-color: white;
    }
    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 0px;
        border-radius: 0px;
        left: 448.953px;
    }
</style>
</body>
<main id="main" class="main">
        <!-- Navigation -->
        <?php
            include '../includes/header.php';
        ?>
        <!-- Navigation -->
        <div class="pagetitle mb-4">
            <div style="display: flex;">
            <div class="me-2">
            <h1>Dashboard</h1>
            <?php echo "<pre>"; print_r($_SERVER);?>
            </div>
            <form method="post" action="" name="selectStateForm">
            <select id="state" style="width:350px;margin-left: 20px;" name ="state" class="form-select search_select" required> 
                <option value="">Select a State...</option>
                <option value="Andra Pradesh">Andra Pradesh</option>
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Madya Pradesh">Madya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Manipur">Manipur</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Orissa">Orissa</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Telangana">Telangana</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttaranchal">Uttaranchal</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="West Bengal">West Bengal</option>
        </select>
            </form>
            </div>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-8 dashboard">
                    <div class="row">
                        <!-- No. of draft entries Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">No. of draft entries</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-card-list"></i>
                                        </div>
                                        <div class="ps-3">
                                        <h6><?php echo $draftCount; ?></h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End No. of draft entries Card -->
                         <!-- No. of Proofed entries Card -->
                         <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">No. of Proofed entries</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-card-list"></i>
                                        </div>
                                        <div class="ps-3">
                                        <h6><?php echo $proofedCount; ?></h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End No. of Proofed entries Card -->
                    </div>
                    <div class="row">
                        <!-- Pending for proofing Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Pending for proofing</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-card-list"></i>
                                        </div>
                                        <div class="ps-3">
                                        <h6><?php echo $pendingProof; ?></h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Pending for proofing Card -->
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php
	include '../includes/js.php';
?>
<script type="text/javascript">
$(document).ready(function() {
    $(".search_select").select2();
    $("#state").on("change", function () { 
        $('form[name=selectStateForm]').submit();
    });
});

setInterval(function(){ 
    updateUserActivity('<?php echo $LoginUserId; ?>');
}, 10000);
</script>
</body>
</html>