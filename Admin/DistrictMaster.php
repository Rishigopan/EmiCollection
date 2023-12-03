<?php session_start(); ?>
<?php

if(isset($_SESSION['custid']) && isset($_SESSION['custtype'])){
    if($_SESSION['custtype']  == 'SUPERADMIN' || $_SESSION['custtype']  == 'ADMIN'){
    }
    else{
        header("location:../login.php");
    }
}
else{
header("location:../login.php");
}


include '../MAIN/Dbconfig.php';

$pageTitle = 'District';



?>

<!doctype html>
<html lang="en">

<head>


    <?php


    include '../MAIN/Header.php';

    ?>
    <style>
        .disable {
            opacity: 0.3;
            pointer-events: none;
        }
    </style>


</head>

<body>

    <div class="wrapper">


        <!--NAVBAR-->
        <nav class="navbar fixed-top navbar-expand-lg bg-light p-1">
            <div class="container-fluid px-xl-5">
                <button class="btn btn-menu rounded-pill" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop"> <i class="material-icons">menu</i> <span class="d-md-inline-block d-none"> Menu </span></button>
                <a class="navbar-brand" href="#"> <strong>BETA</strong> </a>
                <button class="btn btn-menu  rounded-pill"> <span class="d-md-inline-block d-none"> <?php echo $_SESSION['custname']; ?> </span> <i class="material-icons">account_circle</i> </button>

            </div>
        </nav>


        
        <?php include '../MAIN/Sidebar.php'; ?>
   




        <!--CONTENTS-->
        <div class="container main-content">

            <h3 class="mt-3 title shadow-sm  py-2 text-center">Add District</h3>

            <div class="card card-body main-card shadow-sm">
                <div id="add_manufacturer">
                    <div class="row">
                        <div class="col-md-5 product_details mt-2 px-xl-2">
                            <form action="" id="AddDistrictForm" novalidate>
                                <div class="inputs">
                                    <label class="form-label" for="District_name">District Name</label>
                                    <input type="text" class="form-control" id="District_name" data-v-max-length="20" data-v-message="Maximum 20 characters" placeholder="" name="DistrictName" required>
                                </div>

                                <div class="text-center submit_btn">
                                    <button class="btn btn_submit" type="submit">Save </button>
                                </div>
                            </form>
                            <form action="" id="UpdateDistrictForm" style="display: none;" novalidate>
                                <div class="inputs">
                                    <label class="form-label" for="Update_district_name">District Name</label>
                                    <input type="text" id="edit_district_id" name="updateDistrictId" hidden>
                                    <input type="text" class="form-control" id="Update_district_name" name="UpdateDistrictName" data-v-max-length="20" data-v-message="Maximum 20 characters" placeholder=""  required>
                                </div>

                                <div class="text-center submit_btn">
                                    <button class="btn btn_submit" type="submit">Update </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-7 p-0  px-xl-4">

                            <div class="card card-body view_details p-0">

                                <div class="card card-body bg-transparent border-0 d-none" id="loadCard"> 

                                    <div id="loader" class="mx-auto"></div>

                                </div>

                                <ul class="list-unstyled px-1" id="DisplayDistrict">



                                </ul>

                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>





    </div>



    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>

    <script src="../JS/masters.js"></script>

    <script>

        GetDistrictData();


        $(document).ready(function() {

            $('#District_name').focus();

            /* Add District Start */
            $(function() {

                let validator = $('#AddDistrictForm').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#District_name') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#AddDistrictForm', (function(e) {
                    e.preventDefault();
                    var DistrictData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: DistrictData,
                        beforeSend: function() {
                            $('#AddDistrictForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#AddDistrictForm').removeClass("disable");
                            var response = JSON.parse(data);
                            if (response.addDistrict == "0") {
                                toastr.warning("District is Already Present");
                            } else if (response.addDistrict == "1") {
                                toastr.success("Successfully Added District");
                                $('#AddDistrictForm')[0].reset();
                                GetDistrictData();
                                $('#District_name').focus();
                            } else if (response.addDistrict == "2") {
                                toastr.error("Some Error Occured");
                            } else {
                                toastr.error("Some Error Occured");
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }));

            });
            /* Add District  End */


            /* Update District Start */
            $(function() {

                let validator = $('#UpdateDistrictForm').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#Update_district_name') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#UpdateDistrictForm', (function(e) {
                    e.preventDefault();
                    var UpdateDistrictData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: UpdateDistrictData,
                        beforeSend: function() {
                            $('#UpdateDistrictForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#UpdateDistrictForm').removeClass("disable");
                            var UpdateResponse = JSON.parse(data);
                            if (UpdateResponse.DistrictUpdate == "0") {
                                toastr.warning("District is Already Present");
                            } else if (UpdateResponse.DistrictUpdate == "1") {
                                toastr.success("Successfully Updated District");
                                $('#UpdateDistrictForm')[0].reset();
                                GetDistrictData();
                                $('#UpdateDistrictForm').hide();
                                $('#AddDistrictForm').show();
                                $('#District_name').focus();
                            } else if (UpdateResponse.DistrictUpdate == "2") {
                                toastr.error("Some Error Occured");
                            } else {
                                toastr.error("Some Error Occured");
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }));

            });
            /* Update District End */


        });


        toastr.options = {
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>


</body>

</html>