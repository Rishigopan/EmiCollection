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

$pageTitle = 'Billing';


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

        <!-- Modal -->
        <div class="modal" id="itemModal" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add an Item</h5>
                        <button type="button" id="itemCloseBtn" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-white">
                        <form action="" id="add_item">
                            <div class="product_details">
                                <div class="inputs">
                                    <label class="form-label" for="Product_id">Product</label>
                                    <select name="ItemId" id="Product_id" class="form-select">
                                        <option hidden value="">Select Product</option>
                                        <?php
                                        $Products_query = mysqli_query($con, "SELECT item_id,item_name FROM item_master");
                                        foreach ($Products_query as $Products_result) {
                                            echo '<option value="' . $Products_result["item_id"] . '"> ' . $Products_result["item_name"] . ' </option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="inputs">
                                            <label class="form-label" for="Product_price">Product Price</label>
                                            <input type="text" class="form-control" id="Product_price" placeholder="" name="ProductPrice">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="inputs">
                                            <label class="form-label" for="Discount_price">Discount Price</label>
                                            <input type="text" class="form-control" id="Discount_price" placeholder="" name="DiscountPrice">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="inputs">
                                            <label class="form-label" for="Product_quantity">Quantity</label>
                                            <input type="number" class="form-control" id="product_quantity" placeholder="" min="1" value="1" name="ProductQuantity">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="inputs">
                                            <label class="form-label" for="Weekly_installment">Weekly Installment</label>
                                            <input type="number" class="form-control" id="Weekly_installment" placeholder="" min="10" value="10" name="WeeklyInstallment">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="inputs">
                                            <label class="form-label" for="advance_amount">Advance</label>
                                            <input type="number" class="form-control" id="advance_amount" placeholder="" min="0" name="AdvanceAmount">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 text-center">
                                    <button type="submit" class="btn btn_submit px-3 py-2">Add item</button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>


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
        <div class="container-lg container-fluid  main-content">

            <h3 class="mt-3 title shadow-sm  py-2 text-center">Order Form</h3>

            <div class="card card-body main-card shadow-sm">
                <form action="" id="add_product" enctype="multipart/form-data" novalidate>
                    <div class="row product_details">
                        <div class="col-md-5 product_details ">

                            <div class="row">
                                <div class="col-md-6 col-6">
                                    <div class="inputs">
                                        <label class="form-label" for="Find_district">District</label>
                                        <select id="Find_district" class="form-select ShowDistrictAll" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <div class="inputs ">
                                        <label class="form-label" for="Find_route">Route</label>
                                        <select id="Find_route" class="form-select ShowRouteByDistrict" required>

                                            <option hidden value="">Select Route</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="inputs">
                                        <label class="form-label" for="Customer">Customer</label>
                                        <select id="Customer_id" class="form-select" name="CustomerId" required>
                                            <option hidden value="">Select Customer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="inputs">
                                        <label class="form-label" for="Purchase_date">Purchase Date</label>
                                        <input type="date" name="PurchaseDate" value="<?php echo date('Y-m-d'); ?>" class="form-control" id="Purchase_date">
                                    </div>
                                </div>
                            </div>

                            <div class=" submit_btn text-center d-flex justify-content-around mt-5">
                                <a class="btn btn_submit px-5" data-bs-toggle="modal" href="#itemModal" type="button"> <span>Add Product</span></a>
                                <button class="btn shadow-none btn_submit px-4">Take Order</button>
                            </div>
                        </div>
                        <div class="col-md-7 mt-5 mt-md-0 ">

                            <!-- <div class="card card-body d-none" id="loadCard">

                                <div id="loader" class="mx-auto"></div>

                            </div> -->

                            <div class="card card-body item_card" id="DisplayItems">

                            </div>

                        </div>


                    </div>
                </form>
            </div>


        </div>





    </div>



    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>


    <script src="../JS/masters.js?ver=1.3"></script>


    <script src="../JS/cart.js"></script>

    <script>
        getcartData(); //get cart details

        GetCustDistrict(); //get all districts

        //get routes by district
        $('#Find_district').change(function() {
            var district = $(this).val();
            GetCustRoute(district);
        });

        //get customers by route 
        $('#Find_route').click(function() {
            var route = $(this).val();
            console.log(route);
            GetCustomerByRoute(route);
        });



        $(document).ready(function() {


            DelAll(); //delete all items on page start

            //delete all function
            function DelAll() {
                var delAll = '*';
                $.ajax({
                    type: "POST",
                    url: "OrderOperations.php",
                    data: {
                        delAll: delAll
                    },
                    beforeSend: function() {
                        $('#DisplayItems').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#DisplayItems').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var response = JSON.parse(data);
                        if (response.delAllStatus == "0") {
                            getcartData();
                            toastr.error("Failed Deleting All");
                        } else if (response.delAllStatus == "1") {
                            getcartData();
                            //toastr.success("Successfully Deleted All");
                        } else {
                            toastr.error("Some Error Occured");
                        }
                    }
                });
            }


            //focus input on modal shown
            const addItemModal = document.getElementById('itemModal');
            addItemModal.addEventListener('shown.bs.modal', event => {
                document.getElementById('Product_id').focus();
            });


            $('#itemCloseBtn').click(function() {
                $('#add_item')[0].reset();
            });


            //Delete all items from cart
            $('#DisplayItems').on('click', '.clearAllBtn', function() {

                let confirmation = window.confirm("Do you want to clear this cart?");
                if (confirmation == true) {
                    var delAll = '*';
                    $.ajax({
                        type: "POST",
                        url: "OrderOperations.php",
                        data: {
                            delAll: delAll
                        },
                        beforeSend: function() {
                            $('#DisplayItems').addClass("d-none");
                            $('#loadCard').removeClass("d-none");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#DisplayItems').removeClass("d-none");
                            $('#loadCard').addClass("d-none");
                            var response = JSON.parse(data);
                            if (response.delAllStatus == "0") {
                                getcartData();
                                toastr.error("Failed Deleting All");
                            } else if (response.delAllStatus == "1") {
                                getcartData();
                                toastr.success("Successfully Deleted All");
                            } else {
                                toastr.error("Some Error Occured");
                            }
                        }
                    });
                    getcartData();
                }

            });


            //Find items by product name
            $('#Product_id').change(function() {
                var ProductId = $(this).val();
                console.log(ProductId);
                $.ajax({
                    type: "POST",
                    url: "OrderOperations.php",
                    data: {
                        ProductId: ProductId
                    },
                    beforeSend: function() {
                        $('#add_item').addClass('disable');
                    },
                    success: function(data) {
                        console.log(data);
                        $('#add_item').removeClass('disable');
                        var response = JSON.parse(data);
                        if (response.itemStatus == "0") {
                            toastr.warning("No Products Found");
                            $('#Product_Name').val('');
                            $('#Weight').val('');
                            $('#Product_Code').val('');
                            $('#Weekly_installment').val('');
                            $('#Product_Manufacturer').val('');
                        } else if (response.itemStatus == "1") {
                            $('#Product_price').val(response.itemPrice);
                            $('#Discount_price').val(response.itemDiscount);
                            $('#Weekly_installment').val(response.itemEmi);
                        } else {
                            toastr.error("Some Error Occured");
                        }
                    }
                });

            });


            //delete items from cart
            $('#DisplayItems').on('click', '.delete_btn', function() {
                var delValue = $(this).val();
                console.log(delValue);
                $.ajax({
                    type: "POST",
                    url: "OrderOperations.php",
                    data: {
                        delValue: delValue
                    },
                    beforeSend: function() {
                        $('#DisplayItems').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#DisplayItems').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var deleteResponse = JSON.parse(data);
                        console.log(deleteResponse);
                        if (deleteResponse.delStatus == 0) {
                            toastr.error("Delete failed");
                        } else if (deleteResponse.delStatus == 1) {
                            toastr.success("Successfully Deleted");
                            getcartData();
                        } else {
                            toastr.error("some error occured");
                        }
                    }
                });
            });


            //update items in cart
            $('#DisplayItems').on('change', '.change_btn', function() {
                var editValue = $(this).val();
                var editID = $(this).attr('id');
                //console.log(editValue);
                //console.log(editID);
                $.ajax({
                    type: "POST",
                    url: "OrderOperations.php",
                    data: {
                        editValue: editValue,
                        editID: editID
                    },
                    beforeSend: function() {
                        $('#DisplayItems').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#DisplayItems').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var editResponse = JSON.parse(data);
                        console.log(editResponse);
                        if (editResponse.updtStatus == 0) {
                            toastr.error("Update failed");
                        } else if (editResponse.updtStatus == 1) {
                            toastr.success("Successfully Updated");
                            getcartData();
                        } else {
                            toastr.error("some error occured");
                        }
                    }
                });
            });


            //update advance amount in cart
            $('#DisplayItems').on('change', '.change_advance', function() {
                var AdvanceValue = $(this).val();
                var AdvanceID = $(this).attr('id');
                console.log(AdvanceValue);
                console.log(AdvanceID);
                $.ajax({
                    type: "POST",
                    url: "OrderOperations.php",
                    data: {
                        AdvanceValue: AdvanceValue,
                        AdvanceID: AdvanceID
                    },
                    beforeSend: function() {
                        $('#DisplayItems').addClass("d-none");
                        $('#loadCard').removeClass("d-none");
                    },
                    success: function(data) {
                        console.log(data);
                        $('#DisplayItems').removeClass("d-none");
                        $('#loadCard').addClass("d-none");
                        var editResponse = JSON.parse(data);
                        console.log(editResponse);
                        if (editResponse.updtStatus == 0) {
                            toastr.error("Update failed");
                        } else if (editResponse.updtStatus == 1) {
                            toastr.success("Successfully Updated");
                            getcartData();
                        } else {
                            toastr.error("some error occured");
                        }
                    }
                });
            });



            /* Add items */
            $(function() {

                let validator = $('#add_item').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                $(document).on('submit', '#add_item', (function(g) {
                    g.preventDefault();
                    var itemData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "OrderOperations.php",
                        data: itemData,
                        beforeSend: function() {
                            $('#DisplayItems').addClass("d-none");
                            $('#loadCard').removeClass("d-none");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#DisplayItems').removeClass("d-none");
                            $('#loadCard').addClass("d-none");
                            var response = JSON.parse(data);
                            if (response.addItem == "1") {
                                toastr.success("Product Added Successfully");
                                getcartData();
                                //$('#itemModal').modal('hide');
                                $('#add_item')[0].reset();
                            } else if (response.addItem == "2") {
                                toastr.error("Failed Adding Product");
                                getcartData();
                            } else if (response.addItem == "3") {
                                toastr.success("Product Updated Successfully");
                                getcartData();
                                //$('#itemModal').modal('hide');
                                $('#add_item')[0].reset();
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
            /* Add items */


            /* Add order */
            $(function() {

                let validator = $('#add_product').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                /* validator.validator.custom = function(el, event) {
                    if ($(el).is('#Customer_name,#Phone') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                } */

                $(document).on('submit', '#add_product', (function(e) {
                    e.preventDefault();
                    var orderData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "PlaceOrder.php",
                        data: orderData,
                        beforeSend: function() {
                            $('#addCategoryForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#addCategoryForm').removeClass("disable");
                            var response = JSON.parse(data);
                            if (response.status == "1") {
                                $('#add_product')[0].reset();
                                toastr.success("Successfully Placed Order");
                                DelAll();
                            } else if (response.status == "0") {
                                toastr.error("Failed Taking Order");
                            } else if (response.status == "2") {
                                toastr.warning("Please Add Something To Cart");
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
            /* Add order */

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