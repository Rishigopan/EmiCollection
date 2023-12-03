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

$pageTitle = 'Customer';



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

            
            <h3 class="mt-3 title shadow-sm  py-2 text-center">Add Customer</h3>


            <div class="card card-body main-card shadow-sm">
                <div id="add_manufacturer">
                    <div class="row">
                        <div class="col-md-5 product_details mt-2 px-xl-2">
                            <form action="" id="AddCustomerForm" novalidate>

                                <div class="row">
                                    <div class="inputs col-12">
                                        <label class="form-label" for="Customer_name">Customer Name</label>
                                        <input type="text" class="form-control" id="Customer_name" name="CustName"  data-v-max-length="20" data-v-message="Maximum 20 characters" placeholder="" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Cust_district">District</label>
                                        <select name="CustDistrict" class="form-select ShowDistrictAll" id="Cust_district" required>

                                        </select>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Cust_route">Route</label>
                                        <select name="CustRoute" class="form-select ShowRouteByDistrict" id="Cust_route" required>
                                            <option hidden value="">Select Route</option>
                                        </select>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Cust_phone">Phone Number</label>
                                        <input type="number" class="form-control" id="Cust_phone" name="CustPhone" min="0"  data-v-message="" placeholder="" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Cust_location">Location</label>
                                        <input type="text" class="form-control" id="Cust_location" name="CustLocation" data-v-max-length="40" data-v-message="maximum 40 characters" placeholder="" required>
                                    </div>
                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Location_position">Position</label>
                                        <input type="number" class="form-control" id="Location_position" name="CustPosition" min="0" placeholder="" required>
                                    </div>
                                </div>
                                
                              
                                <div class="text-center submit_btn">
                                    <button class="btn btn_submit" type="submit">Save </button>
                                </div>
                            </form>
                            <form action="" id="UpdateCustomerForm" style="display: none;" novalidate>
                                

                                <div class="row">
                                    <div class="inputs col-12">
                                        <input type="text" name="UpdateCustomerId" id="Edit_customer_id" hidden>
                                        <label class="form-label" for="Update_Customer_name">Customer Name</label>
                                        <input type="text" class="form-control" id="Update_Customer_name" name="UpdateCustName"  data-v-max-length="20" data-v-message="Maximum 20 characters" placeholder="" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Update_Cust_district">District</label>
                                        <select name="UpdateCustDistrict" class="form-select ShowDistrictAll" id="Update_Cust_district" required>

                                        </select>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Update_Cust_route">Route</label>
                                        <select name="UpdateCustRoute" class="form-select ShowRouteByDistrict" id="Update_Cust_route" required>
                                            <option hidden value="">Select Route</option>
                                        </select>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Update_Cust_phone">Phone Number</label>
                                        <input type="number" class="form-control" id="Update_Cust_phone" name="UpdateCustPhone" min="0"  data-v-message="" placeholder="" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Update_Cust_location">Location</label>
                                        <input type="text" class="form-control" id="Update_Cust_location" name="UpdateCustLocation" data-v-max-length="40" data-v-message="maximum 40 characters" placeholder="" required>
                                    </div>
                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Update_Location_position">Position</label>
                                        <input type="number" class="form-control" id="Update_Location_position" name="UpdateCustPosition" min="0" placeholder="" required>
                                    </div>
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

                                <table class="table table-striped display text-nowrap text-center " id="Cust_table" style="width:100% ;">
                                    <thead class="text-center">
                                        <tr class="text-center">
                                            <th class="text-center">Sl.No</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Phone</th>
                                            <th class="text-center">Route</th>
                                            <th class="text-center">Location</th>
                                            <th class="text-center">Position</th>
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

  
    <script src="../JS/masters.js?ver=1.5"></script>

    <script>

        GetCustDistrict();
        GetCustUpdateRoute(); 

        $('#Cust_district').change(function(){
            var FindRoute = $(this).val();
            GetCustRoute(FindRoute);
        });

        
        $('#Update_Cust_district').click(function(){
            var FindRoute = $(this).val();
            GetCustRoute(FindRoute);
        });
        
        

      
        

        $(document).ready(function() {

            $('#Customer_name').focus();

            var custTable = $('#Cust_table').DataTable({
                "processing": true,
                "ajax": "CustomerData.php",
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
                        data: 'cust_name',
                    },
                    {
                        data: 'cust_phone'
                    },
                    {
                        data: 'route_name'
                    },
                    {
                        data: 'cust_location'
                        
                    },
                    {
                        data: 'location_position'
                    },
                    {
                        data: 'cust_id',
                        render: function(data,type,row,meta){
                            if (type == 'display') {
                                data = '<button class="edit_btn btn shadow-none " type="button" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'cust_id',
                        "render": function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<button class="del_btn btn shadow-none" <?php if ($_SESSION['custtype']  != 'SUPERADMIN'){ echo "disabled";}else{ } ?> type="button" value="' + data + '"> <i class="material-icons">delete_outline</i> </button>';
                            }
                            return data;
                        }
                    }

                ]


            });


            /* Add Customer Start */
            $(function() {

                let validator = $('#AddCustomerForm').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#Customer_name,#Cust_phone,#Cust_location') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#AddCustomerForm', (function(e) {
                    e.preventDefault();
                    var CustomerData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: CustomerData,
                        beforeSend: function() {
                            $('#AddCustomerForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#AddCustomerForm').removeClass("disable");
                            var response = JSON.parse(data);
                            if (response.addCustomer == "0") {
                                toastr.warning("Customer is Already Present");
                            } else if (response.addCustomer == "1") {
                                toastr.success("Successfully Added Customer");
                                //$('#AddCustomerForm')[0].reset();
                                custTable.ajax.reload();
                                $('#Customer_name').val('');
                                $('#Cust_phone').val('');
                                $('#Cust_location').val('');
                                //GetCustRoute();
                                $('#Customer_name').focus();
                            } else if (response.addCustomer == "2") {
                                toastr.error("Some Error Occured");
                            } else if (response.addCustomer == "3") {
                                toastr.error("This Position Number Is Already In Use");
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
            /* Add Customer End */



            /* Update Customer Start */
            $(function() {

                let validator = $('#UpdateCustomerForm').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#Update_Customer_name,#Update_Cust_phone,#Update_Cust_location,#Update_Location_position') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#UpdateCustomerForm', (function(e) {
                    e.preventDefault();
                    var UpdateCustData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: UpdateCustData,
                        beforeSend: function() {
                            $('#UpdateCustomerForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#UpdateCustomerForm').removeClass("disable");
                            var UpdateResponse = JSON.parse(data);
                            if (UpdateResponse.CustomerUpdate == "0") {
                                toastr.warning("Customer is Already Present");
                            } else if (UpdateResponse.CustomerUpdate == "1") {
                                toastr.success("Successfully Updated Customer");
                                $('#UpdateCustomerForm')[0].reset();
                                $('#UpdateCustomerForm').hide();
                                $('#AddCustomerForm').show();
                                custTable.ajax.reload();
                                $('#Customer_name').focus();
                            } else if (UpdateResponse.CustomerUpdate == "2") {
                                toastr.warning("Some Error Occured");
                            } else if (UpdateResponse.CustomerUpdate == "3") {
                                toastr.warning("This Position Number Is Already In Use");
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
            /* Update Customer End */



            //edit customer
            $('#Cust_table tbody').on('click', '.edit_btn', function() {
                
                var editCustId = $(this).val();
                $('#AddCustomerForm')[0].reset();
                console.log(editCustId);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: {editCustId: editCustId},
                    beforeSend: function() {
                        $('#AddCustomerForm').addClass("disable");
                        
                    },
                    success: function(data) {
                        $('#AddCustomerForm').removeClass("disable");
                        console.log(data);
                        var editResponse = JSON.parse(data);
                        if(editResponse.EditCustomer == 'error'){
                            toastr.error("Some Error Occured");
                        }
                        else{
                            $('#Update_Customer_name').val(editResponse.EditCustName);   
                            $('#Update_Cust_phone').val(editResponse.EditCustPhone);   
                            $('#Update_Cust_location').val(editResponse.EditCustLocation);   
                            $('#Update_Location_position').val(editResponse.EditCustPosition);  
                            $('#Update_Cust_district').val(editResponse.EditCustDistrict).change(); 
                            $('#Update_Cust_route').val(editResponse.EditCustRoute).change();  
                            $('#Edit_customer_id').val(editCustId);
                            $('#UpdateCustomerForm').show();
                            $('#AddCustomerForm').hide(); 
                        }      
                    }
                });
            });



            //delete customer
            $('#Cust_table tbody').on('click', '.del_btn', function() {
                var delCust = $(this).val();
                console.log(delCust);
                var ConfirmDelete = confirm("Are you sure you want to delete this Customer? Deleting this customer will delete all the orders and all the transactions done by them.");
                if(ConfirmDelete == true){
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: {delCust: delCust},
                        beforeSend: function() {
                            $('#AddCustomerForm').addClass("disable");
                        },
                        success: function(data) {
                            $('#AddCustomerForm').removeClass("disable");
                            console.log(data);
                            var deleteResponse = JSON.parse(data);
                            if (deleteResponse.DeleteCust == 0) {
                                toastr.warning("Customer is already in the orders");
                            } else if (deleteResponse.DeleteCust == 1) {
                                toastr.success("Successfully Deleted");
                                custTable.ajax.reload();
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