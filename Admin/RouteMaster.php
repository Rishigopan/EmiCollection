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

$pageTitle = 'Route';



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

            
        <h3 class="mt-3 title shadow-sm  py-2 text-center">Add Route</h3>


            <div class="card card-body main-card shadow-sm">
                <div id="add_manufacturer">
                    <div class="row">
                        <div class="col-md-5 product_details mt-2 px-xl-2">
                            <form action="" id="AddRouteForm" novalidate>
                                <div class="inputs">
                                    <label class="form-label" for="District_select">Choose District</label>
                                    <select name="DistrictSelect" class="form-select" id="District_select" required>
                                        <option hidden value="">Choose...</option>
                                        <?php
                                            $list_districts_query = mysqli_query($con, "SELECT district_id,district_name FROM district_master WHERE district_id <> 0 ORDER BY district_name ASC");
                                            foreach($list_districts_query as $list_districts_result){
                                                echo '<option  value="'.$list_districts_result["district_id"].'">'.$list_districts_result["district_name"].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="inputs">
                                    <label class="form-label" for="Route_name">Route Name</label>
                                    <input type="text" class="form-control" id="Route_name" name="RouteName"  data-v-max-length="20" data-v-message="Maximum 20 characters" placeholder="" required>
                                </div>
                              
                                <div class="text-center submit_btn">
                                    <button class="btn btn_submit" type="submit">Save </button>
                                </div>
                            </form>
                            <form action="" id="UpdateRouteForm" style="display: none;" novalidate>
                                <div class="inputs">
                                    <input type="text" id="Edit_route_id" name="UpdateRouteId" hidden>
                                    <label class="form-label" for="Update_District_select">Choose District</label>
                                    <select name="UpdateDistrictSelect" class="form-select" id="Update_District_select" required>
                                        <option hidden value="">Choose...</option>
                                        <?php
                                            $list_districts_query = mysqli_query($con, "SELECT district_id,district_name FROM district_master ORDER BY district_name ASC");
                                            foreach($list_districts_query as $list_districts_result){
                                                echo '<option  value="'.$list_districts_result["district_id"].'">'.$list_districts_result["district_name"].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="inputs">
                                    <label class="form-label" for="Update_route_name">Route Name</label>
                                    <input type="text" class="form-control" id="Update_route_name" name="UpdateRouteName" data-v-max-length="20" data-v-message="Maximum 20 characters" placeholder=""  required>
                                </div>

                                <div class="text-center submit_btn">
                                    <button class="btn btn_submit" type="submit">Update </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-7 p-0  px-xl-4">

                            <div class="card card-body view_table p-0">

                                <div class="card card-body bg-transparent border-0 d-none" id="loadCard"> 

                                    <div id="loader" class="mx-auto"></div>

                                </div>

                                <table class="table table-striped display text-nowrap text-center " id="Route_table" style="width:100% ;">
                                    <thead class="text-center">
                                        <tr class="text-center">
                                            <th class="text-center">Sl.No</th>
                                            <th class="text-center">District</th>
                                            <th class="text-center">Route Name</th>
                                            <th class="text-center">Edit</th>
                                            <th class="text-center">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">


                                    </tbody>
                                </table> 

                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>





    </div>



    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>

    

    <script>

      

        $(document).ready(function() {

            $('#District_select').focus();

            var routeTable = $('#Route_table').DataTable({
                "processing": true,
                "ajax": "RouteData.php",
                "scrollX": true,
                "scrollY":"400px",
                "dom": '<"top"fl>rt<"bottom"ip>',
                "columns": [
                    { "data": null,"sortable": true, 
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        } 
                    },
                    {
                        data: 'district_name',
                    },
                    {
                        data: 'route_name'
                    },
                    {
                        data: 'route_id',
                        render: function(data,type,row,meta){
                            if (type == 'display') {
                                data = '<button class="edit_btn btn shadow-none " type="button" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'route_id',
                        "render": function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<button class="del_btn btn shadow-none" <?php if ($_SESSION['custtype']  != 'SUPERADMIN'){ echo "disabled";}else{ } ?> type="button" value="' + data + '"> <i class="material-icons">delete_outline</i> </button>';
                            }
                            return data;
                        }
                    }

                ]


            });


            /* Add Route Start */
            $(function() {

                let validator = $('#AddRouteForm').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#Route_name') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#AddRouteForm', (function(e) {
                    e.preventDefault();
                    var DistrictData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: DistrictData,
                        beforeSend: function() {
                            $('#AddRouteForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#AddRouteForm').removeClass("disable");
                            var response = JSON.parse(data);
                            if (response.addRoute == "0") {
                                toastr.warning("Route is Already Present");
                            } else if (response.addRoute == "1") {
                                toastr.success("Successfully Added Route");
                                $('#AddRouteForm')[0].reset();
                                routeTable.ajax.reload();
                                $('#District_select').focus();
                            } else if (response.addRoute == "2") {
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
            /* Add Route End */



            /* Update Route Start */
            $(function() {

                let validator = $('#UpdateRouteForm').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#Update_route_name') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#UpdateRouteForm', (function(e) {
                    e.preventDefault();
                    var UpdateRouteData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: UpdateRouteData,
                        beforeSend: function() {
                            $('#UpdateRouteForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#UpdateRouteForm').removeClass("disable");
                            var UpdateResponse = JSON.parse(data);
                            if (UpdateResponse.RouteUpdate == "0") {
                                toastr.warning("Route is Already Present");
                            } else if (UpdateResponse.RouteUpdate == "1") {
                                toastr.success("Successfully Updated Route");
                                $('#UpdateRouteForm')[0].reset();
                                $('#UpdateRouteForm').hide();
                                $('#AddRouteForm').show();
                                routeTable.ajax.reload();
                                $('#District_select').focus();
                            } else if (UpdateResponse.RouteUpdate == "2") {
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
            /* Update Route End */



            //edit Route
            $('#Route_table tbody').on('click', '.edit_btn', function() {
                var editRouteId = $(this).val();
                $('#AddRouteForm')[0].reset();
                console.log(editRouteId);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: {editRouteId: editRouteId},
                    beforeSend: function() {
                        $('#AddRouteForm').addClass("disable");
                    },
                    success: function(data) {
                        $('#AddRouteForm').removeClass("disable");
                        console.log(data);
                        var editResponse = JSON.parse(data);
                        if(editResponse.EditRoute == 'error'){
                            toastr.error("Some Error Occured");
                        }
                        else{
                            $('#Update_route_name').val(editResponse.EditRouteName);   
                            $('#Update_District_select').val(editResponse.EditRouteDid).change();   
                            $('#Edit_route_id').val(editRouteId);
                            $('#UpdateRouteForm').show();
                            $('#AddRouteForm').hide(); 
                        }      
                    }
                });
             
            });



            //delete Route
            $('#Route_table tbody').on('click', '.del_btn', function() {
                var delRoute = $(this).val();
                console.log(delRoute);
                var ConfirmDelete = confirm("Are you sure you want to delete this Route?");
                if(ConfirmDelete == true){
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: {delRoute: delRoute},
                        beforeSend: function() {
                            $('#AddRouteForm').addClass("disable");
                        },
                        success: function(data) {
                            $('#AddRouteForm').removeClass("disable");
                            console.log(data);
                            var deleteResponse = JSON.parse(data);
                            if (deleteResponse.DeleteRoute == 0) {
                                toastr.warning("Route is Already in Use");
                            } else if (deleteResponse.DeleteRoute == 1) {
                                toastr.success("Successfully Deleted");
                                routeTable.ajax.reload();
                            } else {
                                toastr.error("Some Error Occured");
                            }
                        }
                    });
                }
                else{
                    toastr.info("Cancelled!");
                }
            });





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