<?php session_start(); ?>
<?php

if (isset($_SESSION['custid']) && isset($_SESSION['custtype'])) {
    if ($_SESSION['custtype']  == 'EMPLOYEE') {
    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}

include '../MAIN/Dbconfig.php';





$user_id = $_SESSION['custid'];

$find_employee_from_user = mysqli_query($con, "SELECT e.employee_id FROM user_table u INNER JOIN employee_master e ON u.phone = e.employee_phone WHERE u.user_id = '$user_id'");
foreach ($find_employee_from_user as $find_employee_from_user_result) {
    $employee = $find_employee_from_user_result['employee_id'];
}



$timeNow = date("d-m-y h:i:s");
$dateToday = date("Y-m-d");

$dayToday = date("D");

$empdate = 'emp_' . $dayToday;




$find_employee = mysqli_query($con, "SELECT employee_name,$empdate AS routeId FROM employee_master WHERE employee_id = '$employee'");
foreach ($find_employee as $find_employee_result) {
    $cutRoute = $find_employee_result['routeId'];
}


?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delivery</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>

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
            height: 650px
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
            margin: 2px 2px;
            width: 20%;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.5;
        }

        #balanceTable{
            max-height: 430px;
        }

        #balanceTable table thead th{
           position: sticky;
           top: 0;
           background-color: white;
        }

        #balanceTable table tbody td{
           font-size: 0.7rem ;
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
                width: 20%;
            }

        }
    </style>
</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="PayModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body py-4">
                    <div class="text-center">
                        <img src="../success.gif" class="img-fluid pb-2" alt="">
                        <h3>Payment Succesfull</h3>
                    </div>

                    <div class="text-center pt-3">
                        <button type="button" class="btn btn-secondary btn_close btn_payment_complete px-4 py-2" data-bs-dismiss="modal">Done</button>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">

        <div class="offcanvas-body small px-2 px-sm-4" id="PendingOffcanvas">



        </div>
    </div>



    <nav class="navbar fixed-top top-0" style="background-color:#003282;">
        <div class="container-fluid d-flex justify-content-between">
            <button class="btn border-0 shadow-none" onclick="window.location.reload()">
                <span class="material-icons text-white">sync</span>
            </button>
            <a class="navbar-brand text-white" href="#">
                <strong>Zevans Kart</strong>
                <?php //echo  $dayToday; 
                ?>
            </a>
            <button class="btn border-0 shadow-none" onclick="window.location.href = '../login.php'">
                <span class="material-icons text-white">power_settings_new</span>
            </button>
        </div>
    </nav>

    <main id="main">


        <div class="container px-4 mb-4 mt-4">

            <h4 class="mb-3"> <strong> Hi, <?php echo ucfirst($find_employee_result['employee_name']); ?> </strong></h4>
            <span class="material-icons search_icon">search</span>
            <input type="text" class="form-control search_bar search" name="" id="">

        </div>

        <!--  <div class="d-flex justify-content-around mb-4 icon_buttons">
            <button class="btn add"><span class="material-icons">
                add
                </span></button>
            <button class="btn damage"><span class="material-icons">
                assignment_late
                </span></button>
            <button class="btn return"><span class="material-icons">
                dangerous
                </span></button>
        </div> -->

        

        <section class="balance_section">
            <div class="container px-4 d-flex">

                <div class="card card-body balance_card">
                    <h6>Total Amount To Collect</h6>
                    <h1>&#8377;
                        <?php
                        $to_pay = 0;
                        $find_total_sum = mysqli_query($con, "SELECT * FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id WHERE ci.order_status = 'PENDING' AND c.cust_route = '$cutRoute'");
                        foreach ($find_total_sum as $find_total_sum_result) {
                            $Emi = $find_total_sum_result['emi'];
                            $totalAmount = $find_total_sum_result['total_amount'];
                            $paid_amount = $find_total_sum_result['paid_amount'];
                            $balance_amount = $totalAmount - $paid_amount;
                            if ($balance_amount > $Emi) {
                                $amount_to_pay  = $Emi;
                            } else {
                                $amount_to_pay  = $balance_amount;
                            }
                            $to_pay = $to_pay + $amount_to_pay;
                        }



                        $find_paid_sum = mysqli_query($con, "SELECT SUM(Amount) AS paidSum FROM customer_transactions WHERE e_id = '$employee'AND DATE(createdDate) = '$dateToday'");
                        
                        if (mysqli_num_rows($find_paid_sum) > 0) {
                            foreach ($find_paid_sum as $find_paid_sum_result) {
                                $find_paid_amount = intval($find_paid_sum_result['paidSum']);
                            }
                        } else {
                            $find_paid_amount = "0";
                        }

                        echo $totalPayAmount = $to_pay - $find_paid_amount;





                        ?>
                    </h1>
                    <?php
                    if ($totalPayAmount < 0) {
                        echo '<h5> In Excess</h5>';
                    } else {
                        echo '';
                    }
                    ?>

                    <div class="balance_location d-flex justify-content-between">
                        <span class="badge">
                            <?php
                            $find_route = mysqli_query($con, "SELECT route_name FROM `route_master` WHERE route_id = '$cutRoute'");
                            foreach ($find_route as $find_route_result) {
                                echo ucfirst($find_route_result['route_name']);
                            }
                            ?>
                        </span>
                        <span class="material-icons icon">local_shipping</span>
                    </div>
                </div>

                <div class="card card-body balance_card ">
                    <h6>Total Amount Collected</h6>
                    <h1>&#8377;
                        <?php

                        $find_paid_sum = mysqli_query($con, "SELECT SUM(Amount) AS paidsum FROM customer_transactions WHERE e_id = '$employee' AND DATE(createdDate) = '$dateToday'");
                        if (mysqli_num_rows($find_paid_sum) > 0) {
                            foreach ($find_paid_sum as $find_paid_sum_result) {
                                $find_paid_amount = number_format($find_paid_sum_result['paidsum']);
                            }
                        } else {
                            $find_paid_amount = "0";
                        }
                        echo $find_paid_amount;
                        ?>
                    </h1>

                    <div class="balance_location d-flex justify-content-between">
                        <span class="badge">
                            <?php
                            $find_route = mysqli_query($con, "SELECT route_name FROM `route_master` WHERE route_id = '$cutRoute'");
                            foreach ($find_route as $find_route_result) {
                                echo ucfirst($find_route_result['route_name']);
                            }
                            ?>
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
                                <ul class="list-unstyled collection_items list">
                                    <?php
                                    $find_customers =  mysqli_query($con, "SELECT c.cust_id,c.cust_name,c.cust_location FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id WHERE cust_route = '$cutRoute' AND DATE(c.last_paymentDate) <> '$dateToday' GROUP BY c.cust_id ORDER BY c.location_position ASC");


                                    foreach ($find_customers as $customers_result) {
                                        $custId = $customers_result['cust_id'];
                                    ?>
                                        <li class="mt-3">
                                            <a class="OpenOffcanvas" href="" id="<?= $custId ?>" role="button">
                                                <div class="card card-body customer_item">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="first_section d-flex ">
                                                            <div class="small_box">
                                                                <span class="material-icons">account_circle</span>
                                                            </div>
                                                            <div class="ms-3">
                                                                <h5 class="name"> <?= ucfirst($customers_result['cust_name']);  ?> </h5>
                                                                <p class="m-0 text-muted location"><?= $customers_result['cust_location'];  ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="second_section">
                                                            <h6 class="mt-3">&#8377;
                                                                <?php
                                                                $to_pay = 0;
                                                                $find_total_sum = mysqli_query($con, "SELECT * FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id WHERE c.cust_id = '$custId' AND ci.order_status = 'PENDING'");
                                                                foreach ($find_total_sum as $find_total_sum_result) {
                                                                    $Emi = $find_total_sum_result['emi'];
                                                                    $totalAmount = $find_total_sum_result['total_amount'];
                                                                    $paid_amount = $find_total_sum_result['paid_amount'];
                                                                    $balance_amount = $totalAmount - $paid_amount;
                                                                    if ($balance_amount > $Emi) {
                                                                        $amount_to_pay  = $Emi;
                                                                    } else {
                                                                        $amount_to_pay  = $balance_amount;
                                                                    }
                                                                    $to_pay = $to_pay + $amount_to_pay;
                                                                }
                                                                echo $to_pay;
                                                                ?>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </section>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">

                            <section class="collects">
                                <h5 class="sub_title">Customers List</h5>
                                <ul class="list-unstyled collection_items2">

                                    <?php
                                    $find_customers =  mysqli_query($con, "SELECT c.cust_id,cust_name,cust_location FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id WHERE cust_route = '$cutRoute' AND DATE(c.last_paymentDate) = '$dateToday' GROUP BY c.cust_id ORDER BY c.location_position ASC");

                                    foreach ($find_customers as $customers_result) {
                                        $custId = $customers_result['cust_id'];
                                    ?>
                                        <li class="mt-3">
                                            <div class="card card-body customer_item">
                                                <div class="d-flex justify-content-between">
                                                    <div class="first_section d-flex ">
                                                        <div class="small_box">
                                                            <span class="material-icons">account_circle</span>
                                                        </div>
                                                        <div class="ms-3">
                                                            <h5> <?= $customers_result['cust_name'];  ?> </h5>
                                                            <p class="m-0 text-muted"><?= $customers_result['cust_location'];  ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="second_section">
                                                        <h6 class="mt-3">&#8377;
                                                            <?php

                                                            $find_paid_sum = mysqli_query($con, " SELECT SUM(ct.Amount) AS paidsum FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id INNER JOIN customer_transactions ct ON ci.ci_id = ct.ci_id WHERE c.cust_id = '$custId' AND DATE(ct.createdDate) = '$dateToday' AND ct.e_id != '0'");
                                                            if (mysqli_num_rows($find_paid_sum) > 0) {
                                                                foreach ($find_paid_sum as $find_paid_sum_result) {
                                                                    echo intval($find_paid_sum_result['paidsum']);
                                                                }
                                                            } else {
                                                                echo "0";
                                                            }
                                                            ?>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php
                                    }
                                    ?>

                                </ul>
                            </section>

                        </div>
                    </div>
                </div>
            </div>
        </section>



    </main>


    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>


    <script>
        var options = {
            valueNames: ['name','location']
        };

        var userList = new List('main', options);


        $('.btn_close').click(function() {
            location.reload();
        });


        const myOffcanvas = document.getElementById('offcanvasBottom');
        myOffcanvas.addEventListener('hidden.bs.offcanvas', event => {
            location.reload();
        })


        $('.OpenOffcanvas').click(function(e) {
            e.preventDefault();
            var CustomerId = $(this).attr('id');
            //console.log(CustomerId);
            $.ajax({
                type: "POST",
                url: "DeliveryData.php",
                data: {
                    CustomerId: CustomerId
                },
                beforeSend: function() {
                    $('#offcanvasBottom').offcanvas('show');
                    $('#PendingOffcanvas').html('');
                },
                success: function(data) {
                    //console.log("hello");
                    $('#PendingOffcanvas').html(data);
                    /* var response = JSON.parse(data);
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
                    } */
                }
            });

        });
    </script>



</body>

</html>