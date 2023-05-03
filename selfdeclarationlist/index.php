<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Self Declaration List</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
<?php
    include '../db_connection.php';
	include '../includes/css.php';
    include '../includes/auth.php';
?>
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" /> -->
<!-- <script src="//code.jquery.com/jquery-1.12.4.js"></script> -->
<link src="../assets/css/select2.min.css"></link>
<script src="../assets/js/jquery.js"></script>
</head>
<style>
    .new_loader img {
    position: absolute;
    top: 40%;
    left: 40%;
}

.new_loader {
    display: none;
    width: 100%;
    height: 100%;
    position: absolute;
    z-index: 333333;
    background: rgb(255 255 255 / 53%);
    margin: 0;
    right: 0;
    top: 0;
    padding: 0;
}
.select2-container {
        border: 1px solid #ced4da !important;
        width: 351px;
        border-radius: 4px;
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
    .select2-container{
    z-index:100000;
}
.proofed{
  --bg-opacity: 1;
  background-color: #def7ec;
  background-color: rgba(222,247,236,var(--bg-opacity));
  --text-opacity: 1;
  color: #046c4e;
  color: rgba(4,108,78,var(--text-opacity));
}
.draft{
  --bg-opacity: 1;
  background-color: #feecdc;
  background-color: rgba(254,236,220,var(--bg-opacity));
  --text-opacity: 1;
  color:  #b43403;
  color: rgba(180,52,3,var(--text-opacity));
}
    </style>
</body>
<main id="main" class="main">
        <!-- Navigation -->
        <?php
            include '../includes/header.php';
            $showSuccessMsg ="display:none";
            $LoginUserId =$_SESSION['user']['Id'];
            // $search_adharcard_no='';
            // if(isset($_POST) && !empty($_POST) && isset($_POST['submit'])){
            //     $search_adharcard_no= $_POST['search_adharcard_no'];
            // }
            if(isset($_POST) && !empty($_POST) && isset($_POST['proofedsubmit'])){
                $tehsil =$block =null;
                if(isset($_POST['tehsil']) && !empty($_POST['tehsil'])){
                    $tehsil=$_POST['tehsil'];
                }
                if(isset($_POST['block']) && !empty($_POST['block'])){
                    $block=$_POST['block'];
                }
                $search_adharcard_no=$_POST['adharcard_no'];
                $changeRole =  $db->query('UPDATE SelfDeclarations SET Name =?, GuardianName =?, GuardianRelation =?, Address =?, DateOfBirth=?, Block =?, AdharcardNo =?, Tehsil =?, District =?, State =?, Pincode=?, Status=?, ProofedUserId=? WHERE Id=?', $_POST['full_name'], $_POST['guardian_name'], $_POST['guardian_relation'], $_POST['address'], $_POST['dateofbirth'], $block, $_POST['adharcard_no'], $tehsil, $_POST['district'], $_POST['state'], $_POST['pincode'],'Proofed', $_SESSION['user']['Id'], $_POST['declarationId']);
                $showSuccessMsg ="";
            }
            // $SelfDeclarationData = $db->query("SELECT d.*, u1.Name AS draft_user_name, u2.Name AS proof_user_name
            // FROM SelfDeclarations d LEFT JOIN Users u1 ON d.DraftUserId = u1.Id LEFT JOIN Users u2 ON d.ProofedUserId = u2.Id WHERE d.AdharcardNo=?",$search_adharcard_no)->fetchAll();  
            $SelfDeclarationData = $db->query("SELECT d.*, u1.Name AS draft_user_name, u2.Name AS proof_user_name
            FROM SelfDeclarations d LEFT JOIN Users u1 ON d.DraftUserId = u1.Id LEFT JOIN Users u2 ON d.ProofedUserId = u2.Id")->fetchAll(); 
        ?>
        <!-- <script>$(document).ready(function() { $('#search_adharcard_no').val('<?php //echo $search_adharcard_no; ?>');})</script> -->

        <!-- Navigation -->
        <div class="pagetitle">
            <h1>Self Declaration List</h1>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
               <div class="col-md-12">
               <div class="card">
        <div class="card-body">
            <!-- <form method="post" action="" class="needs-validation" novalidate>
                <div class="row mb-4 mt-4">
                    <div class="col-sm-6">
                    <input type="text" class="form-control" name="search_adharcard_no" id="search_adharcard_no" placeholder="Enter adharcard no" required>
                    </div>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary" name="submit">Search</button>
                    </div>
                </div>
            </form> -->
               <div class="box-body table-responsive mt-3" style="margin-bottom: 5%">
                    <table class="table table-borderless dashboard" id="selfDeclarationTable">
                    <div class="alert alert-success mt-2 message" style="<?php echo $showSuccessMsg;?>">
                           Self declaration proofed successfully!
                            </div>
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Father Name</th>
                                <th>Adharcard No</th>
                                <th>Block</th>
                                <th>Address</th>
                                <th>Data Entry User</th>
                                <th>Proofing User</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(count($SelfDeclarationData) >0){
                            foreach($SelfDeclarationData as $data){
                        ?>
                            <tr>
                                <td><?php echo $data['Name']?></td>
                                <td><?php echo $data['GuardianRelation'].' '.$data['GuardianName']?></td>
                                <td><?php echo $data['AdharcardNo']?></td>
                                <td><?php echo $data['Block']?></td>
                                <td><?php echo $data['Address']?></td>
                                <td><?php echo $data['draft_user_name']?></td>
                                <td><?php if(!empty($data['proof_user_name'])){
                                        echo $data['proof_user_name'];
                                        }else{
                                            echo "----";
                                        }
                                ?></td>
                                <td>
                                <?php if( $data['Status'] == 'draft'){?>
                                    <span class="badge rounded-pill draft">Draft</span>
                                    <?php } ?>
                                    <?php if( $data['Status'] == 'Proofed'){?>
                                    <span class="badge rounded-pill proofed">Proofed</span>
                                    <?php } ?>
                                </td>
                                <!-- <td>
                                    <?php //if( $data['Status'] == 'draft'){?>
                                    <button type="button" class="btn btn-primary" onclick="recheckDeclaraction('<?php //echo $data['Id']?>')">Draft</button>
                                    <?php //} ?>
                                    <?php //if( $data['Status'] == 'Proofed'){?>
                                    <button type="button" class="btn btn-success">Proofed</button>
                                    <?php //} ?>
                            </td> -->
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
<!--start: recheck declaration Modal -->
<div class="modal fade" id="recheckDeclarationModal" tabindex="-1" aria-labelledby="recheckDeclarationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width:705px;">
            <div class="modal-header">
                <h5 class="modal-title" id="recheckDeclarationModalLabel">Recheck Declaration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="recheckDeclarationModalForm" action="" class="needs-validation" novalidate>
            <input type="hidden" class="form-control" name="declarationId" id="declarationId" value="">
                <div class="modal-body">
                <div class="new_loader">
                    <img src="../assets/img/new_loader.gif">
                </div>
                    <div class="alert alert-danger" style="display:none"></div>
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
                        <label for="dateofbirth" class="col-sm-3 col-form-label required">Date Of Birth</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="dateofbirth" id="dateofbirth" required>
                        </div>
                    </div>
                    <div class="row mb-3 mt-4">
                        <label for="guardian_name" class="col-sm-3 col-form-label required">Guardian Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="guardian_name" id="guardian_name" required>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="proofedsubmit">Proofed</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end:  recheck declaration Modal -->
        </section>
    </main>
<?php
	include '../includes/js.php';
?>
<!-- Include DataTables JS -->
<!-- <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script> -->
<script src="../assets/js/jquery.dataTables.min.js"></script>
<script src="../assets/js/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    setTimeout(function() {
        $('.message').fadeOut("slow");
    }, 1000);
    $('#selfDeclarationTable').DataTable({
        "order": []
        //"columnDefs": [ { "orderable": false, "targets": 7 }]
    });

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

    $("#district").on("change", function () { 
        var district =$("#district").val();
            $.ajax({
                type: 'POST',
                url: "../selfdeclarationform/getState.php",
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
function recheckDeclaraction(id){
    $("#recheckDeclarationModalForm").removeClass("was-validated");
    $(".new_loader").show();
    $('#recheckDeclarationModalForm')[0].reset();  
    $('#recheckDeclarationModal').modal('show');
    $.ajax({
        type: "POST",
        url: "getRecheckDeclaration.php",
        data: {
            id: id,
        },
        dataType: 'json',
        success: function(res) {
            if(res.status =="1"){
              $("#declarationId").val(res.declaration.Id);
              $("#adharcard_no").val(res.declaration.AdharcardNo);
              $("#full_name").val(res.declaration.Name);
              $("#guardian_name").val(res.declaration.GuardianName);
              $("#guardian_relation").val(res.declaration.GuardianRelation);
              $("#dateofbirth").val(res.declaration.DateOfBirth);
              $("#address").val(res.declaration.Address);
              $("#block").val(res.declaration.Block);
              $("#tehsil").val(res.declaration.Tehsil);
              $('#district').val(res.declaration.District).trigger('change');
              $('#state').val(res.declaration.State).trigger('change');
              $("#pincode").val(res.declaration.Pincode);
            }
            $(".new_loader").hide();
        }
    });
}
setInterval(function(){ 
    updateUserActivity('<?php echo $LoginUserId; ?>');
}, 10000);
</script>
</body>
</html>