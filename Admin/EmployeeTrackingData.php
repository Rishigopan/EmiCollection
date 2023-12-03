<?php session_start(); ?>
<?php

require_once "../MAIN/Dbconfig.php";

$timeNow = date("d-m-y h:i:s");
$dateToday = date("Y-m-d");
$dayToday = date("D");

$empdate = 'emp_'.$dayToday;

if(isset($_POST['EmpId'])){

    $employee = $_POST['EmpId'];

    $find_employee = mysqli_query($con, "SELECT employee_name,$empdate AS routeId FROM employee_master WHERE employee_id = '$employee'");
    foreach($find_employee as $find_employee_result){
        $cutRoute = $find_employee_result['routeId'];
    }

?>



    <section class="balance_section">
        <div class="container px-4 d-flex" >

            <div class="card card-body balance_card" >
                <h6>Total Amount To Collect</h6>
                <h1>&#8377; 
                    <?php 
                        $to_pay = 0;   
                        $find_total_sum = mysqli_query($con, "SELECT * FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id WHERE ci.order_status = 'PENDING' AND c.cust_route = '$cutRoute'");
                        foreach($find_total_sum as $find_total_sum_result){                                                                 
                            $Emi = $find_total_sum_result['emi'];
                            $totalAmount = $find_total_sum_result['total_amount'];
                            $paid_amount = $find_total_sum_result['paid_amount'];
                            $balance_amount = $totalAmount - $paid_amount ;
                            if($balance_amount > $Emi){
                                $amount_to_pay  = $Emi;
                            }
                            else{
                                $amount_to_pay  = $balance_amount;
                            }
                            $to_pay = $to_pay + $amount_to_pay;
                        }

                        

                        $find_paid_sum = mysqli_query($con, "SELECT SUM(Amount) AS paidsum FROM customer_transactions WHERE e_id = '$employee' AND DAY(createdDate) = '$dateToday'");
                        if(mysqli_num_rows($find_paid_sum) > 0){
                            foreach($find_paid_sum as $find_paid_sum_result){
                                $find_paid_amount = intval($find_paid_sum_result['paidsum']) ;
                            }
                        }
                        else{
                            $find_paid_amount = "0";
                        }

                        echo $totalPayAmount = $to_pay - $find_paid_amount;
                        
                        



                    ?>
                </h1>
                <?php
                    if($totalPayAmount < 0){
                        echo '<h5> In Excess</h5>';
                    }
                    else{
                        echo '';
                    }
                ?>
                
                <div class="balance_location d-flex justify-content-between">
                    <span class="badge">
                        <?php
                        $find_route = mysqli_query($con, "SELECT route_name FROM `route_master` WHERE route_id = '$cutRoute'");
                        foreach($find_route as $find_route_result){
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
                        if(mysqli_num_rows($find_paid_sum) > 0){
                            foreach($find_paid_sum as $find_paid_sum_result){
                                $find_paid_amount = number_format($find_paid_sum_result['paidsum']) ;
                            }
                        }
                        else{
                            $find_paid_amount = "0";
                        }
                        echo $find_paid_amount;
                    ?>
                </h1>

                <div class="balance_location d-flex justify-content-between">
                    <span class="badge">
                        <?php
                        $find_route = mysqli_query($con, "SELECT route_name FROM `route_master` WHERE route_id = '$cutRoute'");
                        foreach($find_route as $find_route_result){
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
        <div class="container px-4 pb-5">
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
                    <!-- Amount to collect customer list-->
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                        <section class="collects">
                            <h5 class="sub_title mb-3">Customers List</h5>
                            <div class="row collection_items">
                                <?php 
                                    $find_customers =  mysqli_query($con, "SELECT c.cust_id,cust_name,cust_location FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id WHERE cust_route = '$cutRoute' AND DATE(c.last_paymentDate) <> '$dateToday' GROUP BY c.cust_id");

                                    foreach($find_customers as $customers_result){
                                        $custId = $customers_result['cust_id'];
                                        ?>
                                        <div class="mt-3 col-lg-4 col-md-6 col-12">
                                            <a class="OpenOffcanvas" href="" id="<?= $custId ?>" role="button">
                                                <div class="card card-body customer_item">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="first_section d-flex ">
                                                            <div class="small_box">
                                                                <span class="material-icons">account_circle</span>
                                                            </div>
                                                            <div class="ms-3">
                                                                <h5> <?=   ucfirst($customers_result['cust_name']);  ?> </h5>
                                                                <p class="m-0 text-muted"><?= $customers_result['cust_location'];  ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="second_section">
                                                            <h6 class="mt-3">&#8377; 
                                                                <?php 
                                                                    $to_pay = 0;   
                                                                    $find_total_sum = mysqli_query($con, "SELECT * FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id WHERE c.cust_id = '$custId' AND ci.order_status = 'PENDING'");
                                                                    foreach($find_total_sum as $find_total_sum_result){                                                                 
                                                                        $Emi = $find_total_sum_result['emi'];
                                                                        $totalAmount = $find_total_sum_result['total_amount'];
                                                                        $paid_amount = $find_total_sum_result['paid_amount'];
                                                                        $balance_amount = $totalAmount - $paid_amount ;
                                                                        if($balance_amount > $Emi){
                                                                            $amount_to_pay  = $Emi;
                                                                        }
                                                                        else{
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
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>
                        </section>
                    </div>

                    <!-- Amount Collected customer list -->
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">

                        <section class="collects">
                            <h5 class="sub_title">Customers List</h5>
                            <div class="row collection_items2">

                                <?php 
                                    $find_customers =  mysqli_query($con, "SELECT c.cust_id,cust_name,cust_location FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id WHERE cust_route = '$cutRoute' AND DATE(c.last_paymentDate) = '$dateToday' GROUP BY c.cust_id");

                                    foreach($find_customers as $customers_result){
                                        $custId = $customers_result['cust_id'];
                                        ?>
                                        <div class="mt-3 col-lg-4 col-md-6 col-12">
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
                                                            
                                                                $find_paid_sum = mysqli_query($con, "SELECT SUM(ct.Amount) AS paidsum FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id INNER JOIN customer_transactions ct ON ci.ci_id = ct.ci_id WHERE c.cust_id = '$custId' AND DATE(ct.createdDate) = '$dateToday' AND ct.e_id = '$employee'");
                                                                if(mysqli_num_rows($find_paid_sum) > 0){
                                                                    foreach($find_paid_sum as $find_paid_sum_result){
                                                                        echo intval($find_paid_sum_result['paidsum']) ;
                                                                    }
                                                                }
                                                                else{
                                                                    echo "0";
                                                                }
                                                            ?>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                ?>

                            </div>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </section>





<?php

}

















?>