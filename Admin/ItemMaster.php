<?php session_start(); ?>
<?php

if (isset($_SESSION['custid']) && isset($_SESSION['custtype'])) {
    if ($_SESSION['custtype']  == 'SUPERADMIN' || $_SESSION['custtype']  == 'ADMIN') {
    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}

include '../MAIN/Dbconfig.php';

$pageTitle = 'Product';



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

        <!-- Confirmation Modal -->
        <div class="modal fade" id="ConfirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Alert</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" >
                        <div id="ResponseMessage" class="text-center">

                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Understood</button>
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
        <div class="container main-content">


            <h3 class="mt-3 title shadow-sm  py-2 text-center">Add Product</h3>


            <div class="card card-body main-card shadow-sm">
                <div id="add_manufacturer">
                    <div class="row">
                        <div class="col-md-5 product_details mt-2 px-xl-2">
                            <form action="" id="AddItemForm" novalidate>

                                <div class="row">
                                    <div class="inputs col-12">
                                        <label class="form-label" for="Product_name">Product Name</label>
                                        <input type="text" class="form-control" id="Product_name" name="ProductName" data-v-max-length="20" data-v-message="Maximum 20 characters" placeholder="" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Product_code">Product Code</label>
                                        <input type="text" class="form-control" id="Product_code" name="ProductCode" data-v-max-length="10" data-v-message="Maximum 10 characters" placeholder="" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Product_price">Product Price</label>
                                        <input type="number" class="form-control" id="Product_price" name="ProductPrice" min="0" data-v-message="" placeholder="" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Product_discount">Discount Price</label>
                                        <input type="number" class="form-control" id="Product_discount" name="ProductDiscount" min="0" data-v-message="" placeholder="" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Product_emi">Product EMI</label>
                                        <input type="number" class="form-control" id="Product_emi" name="ProductEMI" min="0" data-v-message="" placeholder="">
                                    </div>
                                </div>


                                <div class="text-center submit_btn">
                                    <button class="btn btn_submit" type="submit">Save </button>
                                </div>
                            </form>
                            <form action="" id="UpdateItemForm" style="display: none;" novalidate>


                                <div class="row">
                                    <div class="inputs col-12">
                                        <input type="text" class="form-control" id="edit_product_id" name="UpdateProductId" hidden required>
                                        <label class="form-label" for="Update_Product_name">Product Name</label>
                                        <input type="text" class="form-control" id="Update_Product_name" name="UpdateProductName" data-v-max-length="20" data-v-message="Maximum 20 characters" placeholder="" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Update_Product_code">Product Code</label>
                                        <input type="text" class="form-control" id="Update_Product_code" name="UpdateProductCode" data-v-max-length="10" data-v-message="Maximum 10 characters" placeholder="" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Update_Product_price">Product Price</label>
                                        <input type="number" class="form-control" id="Update_Product_price" name="UpdateProductPrice" min="0" data-v-message="" placeholder="" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Update_Product_discount">Discount Price</label>
                                        <input type="number" class="form-control" id="Update_Product_discount" name="UpdateProductDiscount" min="0" data-v-message="" placeholder="" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Update_Product_emi">Product EMI</label>
                                        <input type="number" class="form-control" id="Update_Product_emi" name="UpdateProductEMI" min="0" data-v-message="" placeholder="">
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

                                <table class="table table-striped display text-nowrap text-center " id="Item_table" style="width:100% ;">
                                    <thead class="text-center">
                                        <tr class="text-center">
                                            <th class="text-center">Sl.No</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Code</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Discounted</th>
                                            <th class="text-center">EMI</th>
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

            $('#Product_name').focus();

            var itemTable = $('#Item_table').DataTable({
                "processing": true,
                "ajax": "ItemData.php",
                "scrollX": true,
                "scrollY": "400px",
                "dom": '<"top"fl>rt<"bottom"ip>',
                "columns": [{
                        "data": null,
                        "sortable": true,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'item_name',
                    },
                    {
                        data: 'item_code'
                    },
                    {
                        data: 'item_price'
                    },
                    {
                        data: 'discount_price'
                    },
                    {
                        data: 'itemEmi'
                    },
                    {
                        data: 'item_id',
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<button class="edit_btn btn shadow-none " type="button" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'item_id',
                        "render": function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<button class="del_btn btn shadow-none" <?php if ($_SESSION['custtype']  != 'SUPERADMIN') {
                                                                                    echo "disabled";
                                                                                } else {
                                                                                } ?> type="button" value="' + data + '"> <i class="material-icons">delete_outline</i> </button>';
                            }
                            return data;
                        }
                    }

                ]


            });



            /* Add Item Start */
            $(function() {

                let validator = $('#AddItemForm').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#Product_name,#Product_code,#Product_price,#Product_discount') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#AddItemForm', (function(e) {
                    e.preventDefault();
                    var ItemData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: ItemData,
                        beforeSend: function() {
                            $('#AddItemForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#AddItemForm').removeClass("disable");
                            var response = JSON.parse(data);
                            if (response.addItem == "0") {
                                toastr.warning("Item is Already Present");
                            } else if (response.addItem == "1") {
                                toastr.success("Successfully Added Item");
                                $('#AddItemForm')[0].reset();
                                itemTable.ajax.reload();
                                $('#Product_name').focus();
                            } else if (response.addItem == "2") {
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
            /* Add Item End */



            /* Update Item Start */
            $(function() {

                let validator = $('#UpdateItemForm').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#Update_Product_name,#Update_Product_code,#Update_Product_price,#Update_Product_discount') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#UpdateItemForm', (function(e) {
                    e.preventDefault();
                    var UpdateItemData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: UpdateItemData,
                        beforeSend: function() {
                            $('#UpdateItemForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#UpdateItemForm').removeClass("disable");
                            var UpdateResponse = JSON.parse(data);
                            if (UpdateResponse.ItemUpdate == "0") {
                                toastr.warning("Product is Already Present");
                            } else if (UpdateResponse.ItemUpdate == "1") {
                                toastr.success("Successfully Updated Product");
                                $('#UpdateItemForm')[0].reset();
                                $('#UpdateItemForm').hide();
                                $('#AddItemForm').show();
                                itemTable.ajax.reload();
                                $('#Product_name').focus();
                            } else if (UpdateResponse.ItemUpdate == "2") {
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
            /* Update Item End */



            //edit item
            $('#Item_table tbody').on('click', '.edit_btn', function() {
                var editItemId = $(this).val();
                $('#AddItemForm')[0].reset();
                console.log(editItemId);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: {
                        editItemId: editItemId
                    },
                    beforeSend: function() {
                        $('#AddItemForm').addClass("disable");
                    },
                    success: function(data) {
                        $('#AddItemForm').removeClass("disable");
                        console.log(data);
                        var editResponse = JSON.parse(data);
                        if (editResponse.EditItem == 'error') {
                            toastr.error("Some Error Occured");
                        } else {
                            $('#Update_Product_name').val(editResponse.EditItemName);
                            $('#Update_Product_code').val(editResponse.EditItemCode);
                            $('#Update_Product_price').val(editResponse.EditItemPrice);
                            $('#Update_Product_discount').val(editResponse.EditItemDiscount);
                            $('#Update_Product_emi').val(editResponse.EditItemEMI);
                            $('#edit_product_id').val(editItemId);
                            $('#UpdateItemForm').show();
                            $('#AddItemForm').hide();
                        }
                    }
                });
            });



            //delete item
            $('#Item_table tbody').on('click', '.del_btn', function() {
                var delItem = $(this).val();
                console.log(delItem);
                var ConfirmDelete = confirm("Are you sure you want to delete this Product?");
                if (ConfirmDelete == true) {
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: {
                            delItem: delItem
                        },
                        beforeSend: function() {
                            $('#AddItemForm').addClass("disable");
                        },
                        success: function(data) {
                            $('#AddItemForm').removeClass("disable");
                            console.log(data);
                            var deleteResponse = JSON.parse(data);
                            if (deleteResponse.DeleteItem == 0) {
                                $('#ConfirmModal').modal('show');
                                $('#ResponseMessage').html('<p class="px-3"> This Product is Already linked in the orders of the following customers </br> <strong> '+ deleteResponse.CustomerList + ',</strong> </br> Please delete these orders and then try deleting this product again</p>');
                                console.log(deleteResponse.CustomerList);
                                toastr.warning("Item is Already in Use");
                            } else if (deleteResponse.DeleteItem == 1) {
                                toastr.success("Successfully Deleted");
                                itemTable.ajax.reload();
                            } else {
                                toastr.error("Some Error Occured");
                            }
                        }
                    });
                } else {
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