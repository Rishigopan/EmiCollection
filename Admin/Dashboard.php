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

$pageTitle = 'CustomerWiseReport';

$GivenDate = date('Y-m-d');


?>

<!doctype html>
<html lang="en">

<head>


    <?php


    include '../MAIN/Header.php';

    ?>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
   

    <style>
        .dashcard{
            border-radius: 16px;
        }

        .dashcard .headdiv{
            background-color: #0066cc;
            color: white;
            border-radius: 15px 15px 0px 0px;
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
        <div class="container-fluid px-5 main-content">


            <div class="row pt-3" >


                <div class="col-lg-6">

                    <div class="card dashcard card-body px-0 py-0 mb-5">

                        <div class="d-flex headdiv justify-content-between px-3 py-3" >
                            <h4>Day Wise Collection Summary</h4>
                            <div>
                                <input type="text" id="SingleDate" class="form-control">
                            </div>
                        </div>

                        <table class="table table-hover table-striped text-center ">
                            <thead class=" text-white" style="background-color:grey;">
                                <tr>
                                    <th>Name</th>
                                    <th>Collection</th>
                                </tr>
                            </thead>

                            <tbody id="ViewSingleDayData">

                            </tbody>
                        </table>

                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="card dashcard card-body px-0  py-0">

                        <div class="d-flex headdiv justify-content-between px-3 py-3">

                            <h4>Weekly Collection Summary</h4>
                            <div>
                                <input type="text" id="CustomDate" class="form-control" placeholder="Range Select">
                            </div>
                        </div>

                        <table class="table table-hover table-striped text-center">
                            <thead class=" text-white" style="background-color: grey;">
                                <tr>
                                    <th>Name</th>
                                    <th>Collection</th>
                                </tr>
                            </thead>

                            <tbody id="ViewCustomDayData">

                            </tbody>
                        </table>

                    </div>

                </div>


            </div>


           





            






        </div>





    </div>


    <script src="../JS/dashboard.js"></script>


    <script>
        $(document).ready(function() {


            var DateToday = '<?= $GivenDate ?>';
            SingleDayData(DateToday);



            $(function() {
                $('#SingleDate').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    //minYear: 1901,
                    //maxYear: parseInt(moment().format('YYYY'),10)
                }, function(start, end, label) {
                    SingleDayData(start.format('YYYY-MM-DD'));
                });
            });



            $(function() {
                $('#CustomDate').daterangepicker({
                    opens: 'left',
                    showDropdowns: true,
                }, function(start, end, label) {
                    //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                    RangeData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                });
            });







        });
    </script>


</body>

</html>