<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Self Declaration Form</title>
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
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />-->
<link rel="stylesheet" href="../assets/css/select2.min.css"/>

</head>
<style>
     .declarationFormInputs{
        display: none;
    }
    .select2-container {
        border: 1px solid #ced4da !important;
        border-radius: 4px;
        width: 351px;
        padding: 0.375rem 2.25rem 0.375rem 0.75rem;
        -moz-padding-start: calc(0.75rem - 3px);
        -webkit-appearance: none;
        -moz-appearance: none;
    }
    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 0px;
        border-radius: 0px;
    }
</style>
</body>
<main id="main" class="main">
        <!-- Navigation -->
        <?php
        date_default_timezone_set('Asia/Kolkata');
            include '../includes/header.php';
            $LoginUserId =$_SESSION['user']['Id'];
            $showSuccessMsg ="display:none";
            $successMsg='';
            if(isset($_POST) && !empty($_POST)){
                
                $tehsil =$block =null;
                if(isset($_POST['tehsil']) && !empty($_POST['tehsil'])){
                    $tehsil=$_POST['tehsil'];
                }
                if(isset($_POST['block']) && !empty($_POST['block'])){
                    $block=$_POST['block'];
                }
                if(isset($_POST['saveDeclarationBtn'])){
                     //query for fetch data  from SelfDeclarations table According to adharCard value
                     $declarationData =  $db->query('INSERT into SelfDeclarations (Name, GuardianName, GuardianRelation, Address, DateOfBirth, Block, AdharcardNo, Tehsil, District, State, Pincode, Status, DraftUserId, CreatedAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', $_POST['full_name'], $_POST['guardian_name'], $_POST['guardian_relation'], $_POST['address'] , $_POST['dateofbirth'], $block, $_POST['adharcard_no'], $tehsil, $_POST['district'], $_POST['state'], $_POST['pincode'], 'draft', $_SESSION['user']['Id'], date('Y-m-d H:i:s'));
                     $successMsg='Self declaration added successfully!';
                }
                if(isset($_POST['dataProofingBtn'])){
                    $changeRole =  $db->query('UPDATE SelfDeclarations SET Name =?, GuardianName =?, GuardianRelation =?, Address =?, DateOfBirth=?, Block =?, AdharcardNo =?, Tehsil =?, District =?, State =?, Pincode=?, Status=?, ProofedUserId=? WHERE Id=?', $_POST['full_name'], $_POST['guardian_name'], $_POST['guardian_relation'], $_POST['address'], $_POST['dateofbirth'], $block, $_POST['adharcard_no'], $tehsil, $_POST['district'], $_POST['state'], $_POST['pincode'],'Proofed', $_SESSION['user']['Id'], $_POST['declarationId']);
                    $successMsg='Self declaration proofed successfully!';
                }
                    $showSuccessMsg ="";
              }
        ?>
        <!-- Navigation -->
        <section class="section">
            <div class="row">
               <div class="col-md-12" style="display: flex; justify-content: center;">
               <div class="card" style="width:705px;">
                    <div class="card-header" style="color: #012970;">
                    <?php if($_SESSION['user']['Role'] ==3){?>
                        <h1>Self Declaration</h1>
                        <?php } 
                        else{
                        ?>
                        <h1>Data Proofing</h1>
                        <?php 
                        }
                        ?>
                    </div>
                    <div class="card-body">
                        <div class="box-header with-border" id="filter-box">
                        <div class="alert alert-danger mt-2" style="display:none"></div>
                        <div class="alert alert-success mt-2 message" style="<?php echo $showSuccessMsg;?>">
                        <?php echo $successMsg;?>
                            </div>
                            <br>
                            <form method="post" action="" id="checkAdharCardForm" class="needs-validation" novalidate>
                                <div class="modal-body">
                                    <div class="adharcardmsg mb-3 text-center"><b>Please enter adharcard number first</b></div>
                                    <div class="row mb-4">
                                        <label for="check_adharcard_no" class="col-sm-3 col-form-label required">Adharcard no</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="check_adharcard_no" id="check_adharcard_no" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                            </form>
                            <form method="post" action="" id="declarationForm" class="needs-validation declarationFormInputs" novalidate>
                            <div class=" modal-body">
                                <div class="row mb-4">
                                    <label for="adharcard_no" class="col-sm-3 col-form-label required">Adharcard no</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="adharcard_no" id="adharcard_no" required>
                                    </div>
                                </div>
                                <div>
                                <div class="row mb-3 mt-4">
                                    <label for="full_name" class="col-sm-3 col-form-label required">Full Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="full_name" id="full_name" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="guardian_relation" class="col-sm-3 col-form-label required">Guardian Relation </label>
                                    <!-- <span style="font-size: 11px;color: #6c757d;">S/o, D/o, W/o, C/o</span> -->
                                    <div class="col-sm-3">
                                        <!-- <input type="text" class="form-control" name="guardian_relation" id="guardian_relation" required> -->
                                        <select name="guardian_relation" class="form-select" style="width:200px;" id="guardian_relation" required>
                                        <option value="">Select a Relation...</option>
                                        <option value="S/o">S/o</option>
                                        <option value="D/o">D/o</option>
                                        <option value="W/o">W/o</option>
                                        <option value="C/o">C/o</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3 mt-4">
                                    <label for="guardian_name" class="col-sm-3 col-form-label required">Guardian Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="guardian_name" id="guardian_name" required>
                                    </div>
                                </div>
                                <div class="row mb-3 mt-4">
                                    <label for="dateofbirth" class="col-sm-3 col-form-label required">Date Of Birth</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control" name="dateofbirth" id="dateofbirth" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="address" class="col-sm-3 col-form-label required">Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="address" id="address" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="block" class="col-sm-3 col-form-label">Block</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="block" id="block">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="tehsil" class="col-sm-3 col-form-label">Tehsil</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="tehsil" id="tehsil">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="district" class="col-sm-3 col-form-label required">District</label>
                                    <div class="col-sm-6">
                                        <!-- <input type="text" class="form-control" name="district" id="district" required> -->
                                        <select id="district" style="width:350px;" name ="district" class="form-select search_select" required> 
                                            <option value="">Select a District...</option>
                                            <?php 
                                            $Districts = $db->query("SELECT District FROM Locations ")->fetchAll();  
                                            foreach($Districts as $district){?>
                                            <option value="<?php echo $district['District']; ?>"><?php echo $district['District']; ?></option>
                                            <?php } ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="state" class="col-sm-3 col-form-label required">State</label>
                                    <div class="col-sm-6">
                                        <!-- <input type="text" class="form-control" name="state" id="state" required> -->
                                        <select id="state" style="width:350px;" name ="state" class="form-select search_select" required> 
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
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="pincode" class="col-sm-3 col-form-label">Pincode</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="pincode" id="pincode" maxlength="6">
                                    </div>
                                </div>
                                <input type="hidden" name="loginuserrole" id="loginuserrole" value="<?php echo $_SESSION['user']['Role']; ?>">
                                <input type="hidden" name="declarationId" id="declarationId" value="">
                            </div>
                            </div>
                            <div class="card-footer text-center">
                            <?php if($_SESSION['user']['Role'] ==3){ ?>
                                <button type="submit" name="saveDeclarationBtn" class="btn btn-primary saveDeclarationBtn">Save</button>
                                <?php }else{ ?>
                                <button type="submit" name="dataProofingBtn" class="btn btn-primary">Data Proofing</button>
                                <?php } ?>
                            </div>
                        </form>
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
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script> -->
<script src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    //change selectboxes to selectize mode to be searchable
   $(".search_select").select2();
   
   // on first focus (bubbles up to document), open the menu
    $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
    $(this).closest(".select2-container").siblings('select:enabled').select2('open');
    });

    // steal focus during close - only capture once and stop propogation
    $('select.select2').on('select2:closing', function (e) {
    $(e.target).data("select2").$selection.one('focus focusin', function (e) {
        e.stopPropagation();
    });
});
    $("#checkAdharCardForm").submit(function (event) {
        event.preventDefault();
        var loginuserrole = $('#loginuserrole').val();
        $('.alert-danger').html('');
        var adharCard = $('#check_adharcard_no').val();
        if(adharCard ==''){
            $('.alert-danger').show();
            $('.alert-danger').append('Please enter adharcard!');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: "checkExistAdharCard.php",
            data: {adharCard:adharCard},
            success: (data) => {
            var response = JSON.parse(data);
                if (response.status == "Existed") {
                    if(loginuserrole ==3){
                        $('.alert-danger').show();
                        $('.alert-danger').append('Adharcard already Exist! Your Id is '+ response.data.Id+'.');
                    }else{
                        if(response.data.Status =="draft"){
                            $('.alert-danger').html('');
                            $('.alert-danger').hide();
                            $('#checkAdharCardForm').hide();
                            $('.adharcardmsg').hide();
                            $('.declarationFormInputs').show();
                            $('#declarationId').val(response.data.Id);
                            $('#adharcard_no').val(adharCard);
                            $('#full_name').val(response.data.Name);
                            $('#guardian_relation').val(response.data.GuardianRelation);
                            $('#guardian_name').val(response.data.GuardianName);
                            $('#dateofbirth').val(response.data.DateOfBirth);
                            $('#address').val(response.data.Address);
                            $('#block').val(response.data.Block);
                            $('#tehsil').val(response.data.Tehsil);
                            $('#district').val(response.data.District).trigger('change');
                            $('#state').val(response.data.State).trigger('change');
                            $('#pincode').val(response.data.Pincode);
                        }else{
                            $('.alert-danger').show();
                            $('.alert-danger').append('Self declaration already Proofed! Your Id is '+ response.data.Id+'.');
                        }
                    }
                   
                } else {
                    $('#adharcard_no').val(adharCard);
                    $('.alert-danger').html('');
                    $('.alert-danger').hide();
                    $('#checkAdharCardForm').hide();
                    $('.adharcardmsg').hide();
                    $('.declarationFormInputs').show();
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    $("#district").on("change", function () { 
        var district =$("#district").val();
            $.ajax({
                type: 'POST',
                url: "getState.php",
                data: {district:district},
                success: (data) => {
                var response = JSON.parse(data);
                    if (response.status == 200) {
                        $('#state').val(response.data.State).trigger('change');
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
     });
});
setInterval(function(){ 
    updateUserActivity('<?php echo $LoginUserId; ?>');
}, 10000);
</script>
</body>
</html>