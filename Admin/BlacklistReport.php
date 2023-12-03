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
$pageTitle = 'BlacklistReport';




?>

<!doctype html>
<html lang="en">

<head>




    <?php


    include '../MAIN/Header.php';

    ?>

    <style>
        
    
    </style>



</head>

<body>

    <div class="wrapper">

        <!-- delete Modal -->
        <div class="modal fade" id="delModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                        
                    </div>
                    <div class="modal-body">
                        <h4 class="text-center">Do you want to delete this item?</h4>

                        <div class="text-center mt-3">
                            <button type="button" id="confirmYes" class="btn btn-primary me-5">Yes</button>
                            <button type="button" id="confirmNo" class="btn btn-secondary ms-5" data-bs-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal modal-lg " id="ViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Customer Detailed View</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item me-4" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Products</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" value="" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Installments</button>
                            </li>
                           
                        </ul>
                        <div class="tab-content mt-3" id="myTabContent">

                            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                <div id="DetailedView">
                    
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                
                                <div id="CustomerDetailed" style="min-height: 350px;"> 
                                   
                                </div>
                            
                            </div>

                            
                        </div>
                    
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
        <div class="container-fluid px-4 main-content">
            <div class="toolbar">
                <div class="card card-body p-2 px-3 text-white">
                    <div class="row">
                        <div class="col-7 col-md-6">
                            <div class="col-12 col-md-6">
                                <label for="Search" class="d-flex">
                                    <span class="mt-2">Search</span>
                                    <input type="text" class="form-control ms-2 shadow-none" id="searchbox">
                                </label>
                            </div>
                        </div>
                    
                        <div class="col-5 col-md-6 text-end">

                            <div class="row">

                                <div class="col-md-6">
                                    <select name="" class="form-select" id="FilterDistrict">
                                        <option value="">District</option>
                                        <?php 

                                            $findAllDistricts = mysqli_query($con, "SELECT DISTINCT(district_name) FROM district_master");
                                            if(mysqli_num_rows($findAllDistricts) > 0){
                                                foreach($findAllDistricts as $districtResults){
                                                    echo '<option value="'.$districtResults["district_name"].'">'.$districtResults["district_name"].'</option>';
                                                }
                                            }
                                            else{
                                                echo '<option value="">No Results</option>';
                                            }

                                        ?>
                                    </select>
                                </div>


                                <div class="col-md-6">
                                    <select name="" class="form-select" id="FilterRoute">
                                        <option value="">Route</option>
                                        <?php 

                                            $findAllRoutes = mysqli_query($con, "SELECT DISTINCT(route_name) FROM route_master");
                                            if(mysqli_num_rows($findAllRoutes) > 0){
                                                foreach($findAllRoutes as $RoutesResults){
                                                    echo '<option value="'.$RoutesResults["route_name"].'">'.$RoutesResults["route_name"].'</option>';
                                                }
                                            }
                                            else{
                                                echo '<option value="">No Results</option>';
                                            }

                                        ?>
                                    </select>
                                </div>
                                
                            </div>

                            

                            

                            <!-- <h5 class="mt-2"><strong>Customer Wise Report</strong></h5> -->
                        </div>

                            
                    </div>
                    
                </div>
            </div>

            <div class="card card-body mt-2 table-card p-0 py-1">

                <form action="" id="frm">
                    <div class="table-responsive">
                        <table class="table table-striped display" id="itemWiseReport" style="width:100% ;">
                            <thead class="text-center">
                                <tr>
                                    <th class="text-center">Customer Id</th>
                                    <th class="text-center">Customer Name</th>
                                    <th class="text-center">Phone Number</th>
                                    <th class="text-center">District</th>
                                    <th class="text-center">Route</th>
                                    <th class="text-center">Last Payment</th>
                                    <th class="text-center">Total Amount</th>
                                    <th class="text-center">Total Qty</th>
                                    <!-- <th class="text-center">Delete</th> -->
                                </tr>
                            </thead>
                            <tbody class="text-center">


                            </tbody>
                        </table>
                    </div>
                </form>
            </div>


        </div>





    </div>

 

    <script>

        

        

        
        $(document).ready(function() {



            

            var itemTable = $('#itemWiseReport').DataTable({
                "processing": true,
                "ajax": "BlacklistReportData.php",
                //"responsive": true,
                //"fixedHeader": true,
                "dom": '<"top"pl>rt<"bottom"ip>',
                //"select":true,
                "columns": [
                    { 
                        data: 'cust_id', 
                        searchable: false,
                    },
                    {
                        data: 'cust_name',
                       
                    },
                    {
                        data: 'cust_phone'
                    },
                    {
                        data: 'district_name',
                        
                    },
                    {
                        data: 'route_name'
                    },
                    {
                        data: 'last_paymentDate'
                    },
                    {
                        data: 'totalAmount',
                        searchable: false,
                        render: $.fn.dataTable.render.number(',', 0, '', '', '')
                    },
                    {
                        data: 'totalQty',
                        searchable: false,
                        render: $.fn.dataTable.render.number(',', 0, '', '', '')
                    }
                ]
            });



            $('#searchbox').keyup(function() {
                itemTable.search($(this).val()).draw();
            });



            $('#FilterDistrict').on('change', function(e){
                var DistrictFilter = $(this).val();
                console.log(DistrictFilter);
                //dataTable.column(6).search('\\s' + status + '\\s', true, false, true).draw();
                itemTable.column(3).search(DistrictFilter).draw();
            });

            $('#FilterRoute').on('change', function(e){
                var RouteFilter = $(this).val();
                console.log(RouteFilter);
                //dataTable.column(6).search('\\s' + status + '\\s', true, false, true).draw();
                itemTable.column(4).search(RouteFilter).draw();
            });


        });


    </script>


</body>

</html>