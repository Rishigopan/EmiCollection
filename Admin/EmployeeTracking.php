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

$pageTitle = 'EmployeeTracking';


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

    <style>
        #main {
            margin-top: 70px;
        }

        #main .search_icon {
            font-size: 30px;
            position: absolute;
            color: #1e87ff;
            margin-top: 10px;
            margin-left: 10px;
        }

        #main .search_bar {
            border-radius: 50px;
            padding: 10px 40px;
            border: 2px solid #1e87ff;
        }

        #main .icon_buttons .btn {
            border-radius: 50%;
            padding: 10px 10px;
        }

        #main .icon_buttons button.add {
            background-color: black;
        }

        #main .icon_buttons button.damage {
            background-color: black;
        }

        #main .icon_buttons button.return {
            background-color: black;
        }

        #main .icon_buttons .btn span {
            vertical-align: middle;
            font-size: 30px;
            color: white;
        }

        .navbar a .material-icons {
            color: black;
            text-decoration: none;
        }

        .balance_section .container {
            overflow: scroll;
        }

        .balance_section .container::-webkit-scrollbar {
            display: none;
        }


        .balance_section .balance_card {
            margin: 0px 15px 30px 0px;
            border-radius: 28px;
            background-color: #1e87ff;
            padding: 30px 30px;
            color: white;
            border: none;
            box-shadow: 0px 13px 20px rgb(220, 218, 218);
            min-width: 300px;

        }

        .balance_section .balance_card h6 {
            font-weight: 400;
            padding-bottom: 5px;
        }

        .balance_section .balance_card h1 {
            font-size: 50px;
            font-weight: 600;
            padding-bottom: 8px;
        }

        .balance_section .balance_card .balance_location .badge {
            background-color: #003282;
            padding: 14px 20px;
            font-size: 17px;
            font-weight: 500;
            color: white;
            border-radius: 10px;
        }

        .balance_section .balance_card .balance_location .icon {
            font-size: 40px;
            vertical-align: middle;
        }

        .navigations {
            margin-top: 35px;
        }

        .navigations .navtabs .nav-pills {
            display: flex;
            justify-content: space-between;
        }

        .navigations .navtabs .nav-pills .nav-item {
            width: 47%;
        }

        .navigations .navtabs .nav-pills .nav-item button {
            width: 100%;
            border-radius: 13px;
            padding: 13px 10px;
            font-weight: 500;
        }

        .navigations .navtabs .nav-pills .nav-item button .material-icons {
            vertical-align: middle;
            color: black;
        }

        .navigations .navtabs .nav-pills .nav-item button span {
            color: black;
        }

        .navigations .navtabs .nav-pills #pills-home-tab {
            background-color: #ffcb66;
        }

        .navigations .navtabs .nav-pills #pills-home-tab.active {
            background-color: #fd7f17;
            color: white;
        }

        .navigations .navtabs .nav-pills .nav-item button.active span {
            color: white;
        }

        .navigations .navtabs .nav-pills #pills-profile-tab {
            background-color: #b3e0b8;
        }

        .navigations .navtabs .nav-pills #pills-profile-tab.active {
            background-color: #00cc14;
        }

        .collects .sub_title {
            font-weight: 700;
        }

        .collects .collection_items .customer_item {
            padding: 12px;
            border: none;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgb(230, 229, 229);
        }

        .collects .collection_items2 .customer_item {
            padding: 12px;
            border: none;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgb(230, 229, 229);
        }

        .collects .collection_items2 .customer_item .first_section .small_box {
            width: 55px;
            height: 55px;
            background: url('../user.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: rgb(65, 65, 65);
        }

        .collects .collection_items .customer_item .first_section .small_box {
            width: 55px;
            height: 55px;
            background: url('../user.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: rgb(65, 65, 65);
        }

        .collects .collection_items a {
            text-decoration: none;
            color: inherit;
        }

        .collects .collection_items .customer_item .first_section .small_box span {
            font-size: 35px;
            display: none;
        }

        .collects .collection_items2 .customer_item .first_section .small_box span {
            font-size: 35px;
            display: none;
        }

        .collects .collection_items .customer_item .second_section h6 {
            font-weight: 700;
        }

        .collects .collection_items2 .customer_item .second_section h6 {
            font-weight: 700;
        }

        #offcanvasBottom .payment_collect .amount_input {
            font-size: 40px;
            text-align: center;
            font-weight: 600;
            border-radius: 18px;
            padding: 10px 55px;
            border: 2px solid lightblue;
        }

        #offcanvasBottom .payment_collect .amount_input:focus {
            outline: none !important;
            box-shadow: none;
        }

        #offcanvasBottom {
            border-radius: 40px 40px 0 0;
            height: 500px
        }

        #offcanvasBottom .offcanvas-body {
            padding: 30px 20px;
        }

        #offcanvasBottom .payment_collect .input_cont {
            padding: 25px 0px;
        }

        #offcanvasBottom .payment_collect .input_cont:before {
            content: '₹';
            position: absolute;
            color: gray;
            font-weight: 500;
            font-size: 30px;
            margin-top: 18px;
            margin-left: 18px;
        }

        #offcanvasBottom .btn_container .btn_call {
            background-color: #ccff66;
            border-radius: 50%;
            padding: 10px 12px;
            box-shadow: 0px 3px 8px rgb(177, 207, 116);
        }

        #offcanvasBottom .btn_container .btn_call span {
            vertical-align: middle;
        }

        #offcanvasBottom .btn_container .btn_collect {
            padding: 10px 30px;
            background-color: black;
            color: white;
            font-weight: 600;
            box-shadow: 0px 3px 8px rgb(164, 164, 164);
        }

        #PayModal img {
            width: 150px;
            height: 150px;
        }

        .payPills {
            display: flex;
            justify-content: center;
        }

        .payPills li button {
            font-size: 17px;
            font-weight: 500;
            width: 100%;
            padding-bottom: 8px;
            padding-top: 8px;
        }

        .payPills li {
            margin: 5px 2px;
            width: 30%;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.5;
        }

        @media only screen and (max-width : 370px) {

            .navigations .navtabs .nav-pills .nav-item button span {
                font-size: 16px;
            }

            .balance_section .balance_card {

                min-width: 250px;

            }

            .payPills li button {
                font-size: 15px;
                font-weight: 500;
                width: 100%;
                padding-bottom: 8px;
                padding-top: 8px;
            }

            .payPills li {
                margin: 5px 2px;
                width: 30%;
            }

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
        <div class="container-lg container-fluid  main-content">
            
            <div class="col-md-3 mt-3 mb-5">
                <h4>Choose An Employee</h4>
                <select name="" class="form-select" id="FilterRoute">
                    <option value="">Choose Employee</option>
                    <?php

                    $findAllRoutes = mysqli_query($con, "SELECT employee_name,employee_id FROM employee_master");
                    if (mysqli_num_rows($findAllRoutes) > 0) {
                        foreach ($findAllRoutes as $RoutesResults) {
                            echo '<option value="' . $RoutesResults["employee_id"] . '">' . $RoutesResults["employee_name"] . '</option>';
                        }
                    } else {
                        echo '<option value="">No Results</option>';
                    }

                    ?>
                </select>
            </div>


            <div id="DisplayData">


                <section class="balance_section">
                    <div class="container px-4 d-flex" >

                        <div class="card card-body balance_card" >
                            <h6>Total Amount To Collect</h6>
                            <h1>&#8377; 0
                                
                            </h1>
                           
                            
                            <div class="balance_location d-flex justify-content-between">
                                <span class="badge">

                                    <span style="visibility: hidden;">kazhakootam </span>
                                   
                                </span>
                                   
                                <span class="material-icons icon">local_shipping</span>
                            </div>
                        </div>

                        <div class="card card-body balance_card ">
                            <h6>Total Amount Collected</h6>
                            <h1>&#8377; 0
                              
                            </h1>

                            <div class="balance_location d-flex justify-content-between">
                                <span class="badge">
                                    <span style="visibility: hidden;">kazhakootam </span>
                                </span>
                                <span class="material-icons icon">local_shipping</span>
                            </div>
                        </div>

                    </div>
                </section>

                <section class="navigations">
                    <div class="container px-4">
                        <div class="navtabs">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                                        <span class="material-icons">pending_actions</span>
                                        <span>Pending</span>
                                    </button>
                                </li>
                                <li class="nav-item " role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                                        
                                        <span class="material-icons">check_circle</span>
                                        <span>Completed</span>
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                    <section class="collects">
                                        <h5 class="sub_title mb-3">Customers List</h5>
                                        <div class="row collection_items">
                                           
                                        </div>
                                    </section>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">

                                    <section class="collects">
                                        <h5 class="sub_title">Customers List</h5>
                                        <div class="row collection_items2">

                                           

                                        </div>
                                    </section>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>





            </div>




        </div>





    </div>



    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>


    <script src="../JS/masters.js?ver=1.3"></script>


    <script>
        $(document).ready(function() {

            $('#FilterRoute').change(function() {

                var EmpId = $(this).val();
                console.log(EmpId);
                $.ajax({
                    method: "POST",
                    url: "EmployeeTrackingData.php",
                    data: { EmpId: EmpId },
                    beforeSend: function() {

                    },
                    success: function(data) {
                        //console.log(data);
                        $('#DisplayData').html(data);
                    }
                });

            });

        });
    </script>





</body>

</html>