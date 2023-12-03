<?php //session_start(); ?>
<?php   

    require_once "../MAIN/Dbconfig.php";

    include "./CommonFunctions.php";

    $user_id = $_SESSION['custid'];

    $find_employee_from_user = mysqli_query($con, "SELECT e.employee_id FROM user_table u INNER JOIN employee_master e ON u.phone = e.employee_phone WHERE u.user_id = '$user_id'");
    foreach($find_employee_from_user as $find_employee_from_user_result){
        $employee = $find_employee_from_user_result['employee_id'];
    }



    $user = $employee;

    $timeNow = date("Y-m-d h:i:s");


    //pay in terms
    if(isset($_POST['customerId'])){

        mysqli_autocommit($con,FALSE);

        $customerId = $_POST['customerId'];
        $CustomerItemId = $_POST['CitemId'];
        $AmountToPay = $_POST['CAmount'];
        $routeId = $_POST['RouteId'];
        $TotalAmount = 0;

        $findlastEnteredTime = mysqli_query($con, "SELECT createdDate FROM customer_transactions WHERE e_id = '4' ORDER BY t_id DESC LIMIT 1");
        foreach($findlastEnteredTime as $findlastEnteredTimeResult){
           $findlastEnteredTime = $findlastEnteredTimeResult['createdDate'];
        }


        
        

        foreach( $CustomerItemId as $key => $CItemId ) {

            $cid = $CItemId;
            $amount = intval($AmountToPay[$key]);

            $findMax = mysqli_query($con, "SELECT MAX(t_id) FROM customer_transactions");
            foreach($findMax as $Max_result){
                $Max = $Max_result['MAX(t_id)'] + 1;
            }

            $payEmi = mysqli_query($con, "INSERT INTO customer_transactions (t_id,ci_id,r_id,Amount,createdby,createdDate,e_id) 
            VAlUES ('$Max','$CItemId','$routeId','$amount','$user','$timeNow','$user')"); 

            $updateCustomerItems =  mysqli_query($con, "UPDATE customer_items SET paid_amount = paid_amount + '$amount' WHERE ci_id = '$cid'");
       
        }

        if($payEmi && $updateCustomerItems){
            $updateCustomer = mysqli_query($con, "UPDATE customer_master SET last_paymentDate = '$timeNow' WHERE cust_id = '$customerId'");

            if($updateCustomer){
                mysqli_commit($con);
                UpdateOrderStatus($customerId);
                echo json_encode(array('PayParts' => '1'));
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('PayParts' => '2'));
            }
        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('PayParts' => '2'));
        }


    }




    //Pay in Full
    if(isset($_POST['CustomerFullPayId'])){

        $customerFullPayId = $_POST['CustomerFullPayId'];

        $find_Details_orders = mysqli_query($con, "SELECT * FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id WHERE c.cust_id = '$customerFullPayId' AND ci.order_status = 'PENDING'");
        foreach($find_Details_orders as $find_Details_orders_results){
            $Fullemi = $find_Details_orders_results['emi'];
            $FullorderItemId = $find_Details_orders_results['ci_id'];
            $FullorderRouteId = $find_Details_orders_results['cust_route'];

            $FullTotalAmount = $find_Details_orders_results['total_amount'];
            $FullPaidAmount = $find_Details_orders_results['paid_amount'];
            $fullbalance = $FullTotalAmount - $FullPaidAmount;

            if($fullbalance > $Fullemi){
                $FullAmountToPay  = $Fullemi;
            }
            else{
                $FullAmountToPay = $fullbalance;
            }

            $findFullMax = mysqli_query($con, "SELECT MAX(t_id) FROM customer_transactions");
            foreach($findFullMax as $FullMax_result){
                $FullMax = $FullMax_result['MAX(t_id)'] + 1;
            }

            $PayFullEmi = mysqli_query($con, "INSERT INTO customer_transactions (t_id,ci_id,r_id,Amount,createdby,createdDate,e_id) 
            VAlUES ('$FullMax','$FullorderItemId','$FullorderRouteId','$FullAmountToPay','$user','$timeNow','$user')"); 

            $FullupdateCustomerItems =  mysqli_query($con, "UPDATE customer_items SET paid_amount = paid_amount + '$FullAmountToPay' WHERE ci_id = '$FullorderItemId'");
            mysqli_commit($con);
        }
        if($PayFullEmi && $FullupdateCustomerItems){
            $FullupdateCustomer = mysqli_query($con, "UPDATE customer_master SET last_paymentDate = '$timeNow' WHERE cust_id = '$customerFullPayId'");

            if($FullupdateCustomer){
                
                UpdateOrderStatus($customerFullPayId);
                echo json_encode(array('PayFull' => '1'));
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('PayFull' => '2'));
            }
        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('PayFull' => '2'));
        }
    }



    //Pay Zero
    if(isset($_POST['PayZeroCustId'])){

        $customerZeroPayId = $_POST['PayZeroCustId'];

        $find_Details_orders_zero = mysqli_query($con, "SELECT * FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id WHERE c.cust_id = '$customerZeroPayId' AND ci.order_status = 'PENDING'");
        foreach($find_Details_orders_zero as $find_Details_orders_zero_results){
            $FullorderItemId = $find_Details_orders_zero_results['ci_id'];
            $FullorderRouteId = $find_Details_orders_zero_results['cust_route'];

            $findFullMax = mysqli_query($con, "SELECT MAX(t_id) FROM customer_transactions");
            foreach($findFullMax as $FullMax_result){
                $FullMax = $FullMax_result['MAX(t_id)'] + 1;
            }

            $PayZeroEmi = mysqli_query($con, "INSERT INTO customer_transactions (t_id,ci_id,r_id,Amount,createdby,createdDate,e_id) 
            VAlUES ('$FullMax','$FullorderItemId','$FullorderRouteId','0','$user','$timeNow','$user')"); 

          
        }
        if($PayZeroEmi){
            $FullupdateCustomer = mysqli_query($con, "UPDATE customer_master SET last_paymentDate = '$timeNow' WHERE cust_id = '$customerZeroPayId'");

            if($FullupdateCustomer){
                mysqli_commit($con);
                UpdateOrderStatus($customerZeroPayId);
                echo json_encode(array('PayZero' => '1'));
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('PayZero' => '2'));
            }
        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('PayZero' => '2'));
        }
    }




?>