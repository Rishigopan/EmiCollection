<?php session_start(); ?>
<?php


/* 
if(isset($_COOKIE['custtypecookie']) && isset($_COOKIE['custidcookie'])){

    if($_COOKIE['custtypecookie'] == 'SuperAdmin' || $_COOKIE['custtypecookie'] == 'Admin'){

    }
    else{
        header("location:../login.php");
    }
    
}
else{

header("location:../login.php");

}
 */

require_once "../MAIN/Dbconfig.php";




function FindTotalPay($custId)
{

    include("../MAIN/Dbconfig.php");
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
    return $to_pay;
}






if (isset($_POST['CustomerId'])) {

    $customerId = $_POST['CustomerId'];
    $find_details = mysqli_query($con, "SELECT * FROM customer_master WHERE cust_id = '$customerId'");
    foreach ($find_details as $find_details_results) {
    }

?>
    <ul class="nav nav-pills mb-3 sticky-top bg-white payPills" id="pills-tab" role="tablist">

        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-total-tab" data-bs-toggle="pill" data-bs-target="#pills-total" type="button" role="tab" aria-controls="pills-total" aria-selected="true">Full</button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-split-tab" data-bs-toggle="pill" data-bs-target="#pills-split" type="button" role="tab" aria-controls="pills-split" aria-selected="false">Split</button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-history-tab" data-bs-toggle="pill" data-bs-target="#pills-history" type="button" role="tab" aria-controls="pills-history" aria-selected="false">History</button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-balance-tab" data-bs-toggle="pill" data-bs-target="#pills-balance" type="button" role="tab" aria-controls="pills-balance" aria-selected="false">Balance</button>
        </li>

    </ul>

    <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade show active" id="pills-total" role="tabpanel" aria-labelledby="pills-total-tab" tabindex="0">
            <form action="" class="mt-3" id="PayFullForm">
                <div class="container payment_collect">
                    <h5>Amount need to pay today.</h5>

                    <div class="input_cont">
                        <input type="text" id="testid" name="CustomerFullPayId" value="<?= $customerId ?>" hidden>
                        <input type="text" value="<?php echo FindTotalPay($customerId); ?>" class="form-control amount_input" disabled>
                    </div>
                </div>

                <div class="fixed-bottom btn_container py-4">
                    <div class="d-flex justify-content-between px-3">
                        <div>
                            <a class="btn btn_call" href="tel:+91<?= $find_details_results['cust_phone']; ?>"><span class="material-icons p-0 m-0">phone_in_talk</span></a>
                        </div>
                        <div>
                            <button type="submit" class="btn rounded-pill btn_collect">Collect</button>
                        </div>

                        <!-- <div>
                            <button type="button" class="btn rounded-pill btn_collect btn_nopay" value="<?= $customerId ?>">Zero Pay</button>
                        </div> -->
                    </div>
                </div>
            </form>
        </div>

        <div class="tab-pane fade" id="pills-split" role="tabpanel" aria-labelledby="pills-split-tab" tabindex="0">
            <div class="px-3 pb-5 mt-3">
                <h5 class="pb-3">Pay amount in split.</h5>

                <form action="" id="PayInSplit" novalidate>

                    <input type="text" id="testid" name="customerId" value="<?php echo $customerId; ?>" hidden>

                    <?php
                    $find_split_amount = mysqli_query($con, "SELECT * FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id INNER JOIN item_master i ON ci.p_id = i.item_id WHERE c.cust_id = '$customerId' AND ci.order_status = 'PENDING'");
                    foreach ($find_split_amount as $find_split_amount_result) {
                        $SplitEmi =  $find_split_amount_result['emi'];
                        $CustRouteId =  $find_split_amount_result['cust_route'];
                        $totalSplitAmount = $find_split_amount_result['total_amount'];
                        $Splitpaid_amount = $find_split_amount_result['paid_amount'];
                        $Splitbalance_amount = $totalSplitAmount - $Splitpaid_amount;
                        if ($Splitbalance_amount > $SplitEmi) {
                            $splitAmount  = $SplitEmi;
                        } else {
                            $splitAmount  = $Splitbalance_amount;
                        }

                    ?>

                        <div class="d-flex justify-content-between">
                            <h6 class="mt-2"> <?php echo $find_split_amount_result['item_name'];  ?> </h6>
                            <div class="mb-3">
                                <input type="text" name="RouteId" value="<?php echo $CustRouteId; ?>" hidden>
                                <input type="text" class="form-control text-center" name="CitemId[]" value="<?php echo $find_split_amount_result['ci_id']; ?>" hidden>
                                <input type="text" class="form-control text-center" name="CAmount[]" data-v-message="Amount exceeds balance" data-v-max="<?php echo $Splitbalance_amount; ?>" value="<?php echo intval($splitAmount); ?>" required>
                            </div>
                        </div>



                    <?php

                    }
                    ?>

                    <div class="fixed-bottom btn_container py-4">
                        <div class="d-flex justify-content-center">
                            <div>
                                <button type="submit" class="btn rounded-pill btn_collect">Pay In split</button>
                            </div>
                        </div>
                    </div>



                </form>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-history" role="tabpanel" aria-labelledby="pills-history-tab" tabindex="0">

            <div class="px-3 mt-3">
                <h5 class="pb-3">View Paid History</h5>



                <!-- <?php
                        $find_split_amount = mysqli_query($con, "SELECT * FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id INNER JOIN item_master i ON ci.p_id = i.item_id WHERE c.cust_id = '$customerId' AND ci.order_status = 'PENDING'");
                        foreach ($find_split_amount as $find_split_amount_result) {
                            $SplitEmi =  $find_split_amount_result['emi'];
                            $totalSplitAmount = $find_split_amount_result['total_amount'];
                            $Splitpaid_amount = $find_split_amount_result['paid_amount'];
                            $Splitbalance_amount = $totalSplitAmount - $Splitpaid_amount;
                            /* if($Splitbalance_amount > $SplitEmi){
                                    $splitAmount  = $SplitEmi;
                                }
                                else{
                                    $splitAmount  = $Splitbalance_amount;
                                } */

                        ?>
                    <div class="d-flex justify-content-between">
                        <h6 class=""> <?php echo $find_split_amount_result['item_name'] . '-' . date("d M y", strtotime($find_split_amount_result['start_date']));  ?> </h6>
                        <h6 class=""> &#8377; <?php echo $Splitbalance_amount;  ?> </h6>
                    </div>
                <?php
                        }
                ?> -->

                <div class="table-responsive" id="balanceTable">

                    <table class="table table-bordered">

                        <thead>
                            <th>Item</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Employee</th>
                        </thead>

                        <tbody>


                            <?php

                            $findItems = mysqli_query($con, "SELECT ci_id FROM  customer_items WHERE cust_id = '$customerId'");
                            foreach ($findItems as $findItemResults) {
                                $customerItemId = $findItemResults['ci_id'];


                                $install_details = mysqli_query($con, "SELECT i.item_name,ct.Amount,e.employee_name,ct.createdDate,ct.e_id,u.name FROM customer_transactions ct INNER JOIN customer_items ci ON ct.ci_id = ci.ci_id LEFT JOIN employee_master e ON ct.e_id = e.employee_id INNER JOIN item_master i ON ci.p_id = i.item_id  INNER JOIN user_table u ON ct.createdby = u.user_id  WHERE ci.cust_id = '$customerId' AND ci.ci_id = '$customerItemId'");

                                if (mysqli_num_rows($install_details) > 0) {

                                    foreach ($install_details as $install_results) {
                                        $emp_id = $install_results['e_id'];
                            ?>
                                        <tr>

                                            <td> <?php echo $install_results['item_name']; ?> </td>
                                            <td> <?php echo intval($install_results['Amount']); ?> </td>
                                            <td> <?php echo  date("d M Y h:i A", strtotime($install_results['createdDate']));  ?> </td>
                                            <!-- <td> <?php echo $install_results['employee_name']; ?> </td> -->
                                            <td> <?php
                                                    if ($emp_id == 0) {
                                                        echo $install_results['name'];
                                                    } else {
                                                        echo $install_results['employee_name'];
                                                    }
                                                    ?>
                                            </td>
                                        </tr>
                            <?php
                                    }
                                } else {
                                    echo '<tr> <td colspan="5" class="text-center" > No Installments </td>  </tr>';
                                }
                            }
                            ?>

                        </tbody>


                    </table>

                </div>


            </div>

        </div>

        <div class="tab-pane fade" id="pills-balance" role="tabpanel" aria-labelledby="pills-balance-tab" tabindex="0">

            <div class="px-3 mt-3">
                <h5 class="pb-3">View Balance Amounts</h5>

                <?php
                $find_split_amount = mysqli_query($con, "SELECT * FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id INNER JOIN item_master i ON ci.p_id = i.item_id WHERE c.cust_id = '$customerId' AND ci.order_status = 'PENDING'");
                foreach ($find_split_amount as $find_split_amount_result) {
                    $SplitEmi =  $find_split_amount_result['emi'];
                    $totalSplitAmount = $find_split_amount_result['total_amount'];
                    $Splitpaid_amount = $find_split_amount_result['paid_amount'];
                    $Splitbalance_amount = $totalSplitAmount - $Splitpaid_amount;
                    /* if($Splitbalance_amount > $SplitEmi){
                                    $splitAmount  = $SplitEmi;
                                }
                                else{
                                    $splitAmount  = $Splitbalance_amount;
                                } */

                ?>
                    <div class="d-flex justify-content-between">
                        <h6 class=""> <?php echo $find_split_amount_result['item_name'] . '-' . date("d M y", strtotime($find_split_amount_result['start_date']));  ?> </h6>
                        <h6 class=""> &#8377; <?php echo $Splitbalance_amount;  ?> </h6>
                    </div>
                <?php
                }
                ?>

                <div class="fixed-bottom btn_container py-4">
                    <div class="d-flex justify-content-center">
                        <div>
                            <button type="button" class="btn rounded-pill btn_collect btn_nopay" value="<?= $customerId ?>">Zero Pay</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>

<?php
}

?>

<script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>


<script>
    $(document).ready(function() {

        //pay in parts
        $(function() {
            let validator = $('#PayInSplit').jbvalidator({
                //language: 'dist/lang/en.json',
                successClass: false,
                html5BrowserDefault: true
            });

            $(document).one('submit', '#PayInSplit', (function(e) {
                var ConfirmSplit = confirm('You want to collect payment in split?');
                if (ConfirmSplit == true) {
                    e.preventDefault();
                    var SplitData = new FormData(this);
                    var Test = $('#testid').val();
                    //console.log(SplitData);
                    //console.log(Test);
                    $.ajax({
                        type: "POST",
                        url: "DeliveryOperations.php",
                        data: SplitData,
                        beforeSend: function() {
                            //$('#PayInSplit').addClass("disable");
                            $('#PendingOffcanvas').html('');
                            //$('#offcanvasBottom').offcanvas('hide');
                        },
                        success: function(data) {
                            $('#PayInSplit').removeClass("disable");
                            console.log(data);
                            var response = JSON.parse(data);
                            if (response.PayParts == "1") {
                                $('#PayModal').modal('show');
                                //toastr.success("Successfully Added Item");
                            } else if (response.PayParts == "2") {
                                toastr.error("Payment Failed");
                            } else {
                                toastr.error("Some Error Occured");
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                } else {

                }
            }));
        });




        //pay in full
        $(function() {
            let validator = $('#PayFullForm').jbvalidator({
                //language: 'dist/lang/en.json',
                successClass: false,
                html5BrowserDefault: true
            });


            $(document).one('submit', '#PayFullForm', (function(f) {
                var ConfirmSplit = confirm('You want to collect full payment ?');
                if (ConfirmSplit == true) {
                    f.preventDefault();
                    var FullData = new FormData(this);
                    //var Test = $('#testid').val();
                    //console.log(FullData);
                    //console.log(Test);
                    $.ajax({
                        type: "POST",
                        url: "DeliveryOperations.php",
                        data: FullData,
                        beforeSend: function() {
                            //$('#PayFullForm').addClass("disable");
                            //$('#offcanvasBottom').offcanvas('hide');
                            $('#PendingOffcanvas').html('');
                        },
                        success: function(data) {
                            $('#PayFullForm').removeClass("disable");
                            console.log(data);
                            var response = JSON.parse(data);
                            if (response.PayFull == "1") {
                                $('#PayModal').modal('show');
                                //toastr.success("Successfully Added Item");
                            } else if (response.PayFull == "2") {
                                toastr.error("Payment Failed");
                            } else {
                                toastr.error("Some Error Occured");
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
                else{

                }    
            }));



        });






        //pay zero
        $('.btn_nopay').click(function() {
            var ConfirmSplit = confirm('You want to collect zero payment?');
            if (ConfirmSplit == true) {
                var PayZeroCustId = $(this).val();
                console.log(PayZeroCustId);
                $.ajax({
                    type: "POST",
                    url: "DeliveryOperations.php",
                    data: {
                        PayZeroCustId: PayZeroCustId
                    },
                    beforeSend: function() {
                        $('#offcanvasBottom').offcanvas('hide');
                        //console.log("hello");
                    },
                    success: function(data) {
                        //$('#PayFullForm').removeClass("disable");
                        console.log(data);
                        var response = JSON.parse(data);
                        if (response.PayZero == "1") {
                            $('#PayModal').modal('show');
                            //toastr.success("Successfully Added Item");
                        } else if (response.PayZero == "2") {
                            toastr.error("Payment Failed");
                        } else {
                            toastr.error("Some Error Occured");
                        }
                    }
                });
            }
            else{

            }

        });






    });
</script>