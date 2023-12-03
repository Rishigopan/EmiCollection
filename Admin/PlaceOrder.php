<?php //session_start(); ?>
<?php

include '../MAIN/Dbconfig.php';
include '../Admin/CommonFunctions.php';

$userid = $_SESSION['custid'];

$timeNow = date('Y-m-d h:i:s');

//Place order
if (isset($_POST['CustomerId'])) {


    $custName = $_POST['CustomerId'];
    $purchaseDate = $_POST['PurchaseDate'];


    $checkCartEmpty = mysqli_query($con, "SELECT * FROM temp_table WHERE user_id = '$userid'");
    if (mysqli_num_rows($checkCartEmpty) > 0) {

        mysqli_autocommit($con, FALSE);
        $find_max_mainOrder = mysqli_query($con, "SELECT MAX(o_id) FROM customer_orders");
        foreach ($find_max_mainOrder as $find_max_mainOrder_result) {
            $max_mainOrder = $find_max_mainOrder_result['MAX(o_id)'] + 1;
        }

        $mainOrder = 'DEL-' . date("mdY") . '-' . $max_mainOrder;

        $find_totals_query = mysqli_query($con, "SELECT SUM(amount) AS totalAmount, SUM(qty) AS totalQty, COUNT(product) AS totalItems FROM temp_table WHERE user_id = '$userid'");
        foreach ($find_totals_query as $find_total_result) {
            $totalAmount = $find_total_result['totalAmount'];
            $totalQty = $find_total_result['totalQty'];
            $totalItems  = $find_total_result['totalItems'];
        }

        $add_order = mysqli_query($con, "INSERT INTO customer_orders (o_id,order_id,cust_id,total_items,total_qty,total_amount,order_date,createdBy,createdDate) 
            VALUES ('$max_mainOrder','$mainOrder','$custName','$totalItems','$totalQty','$totalAmount','$purchaseDate','$userid','$timeNow')");

        if ($add_order) {
            $find_details = mysqli_query($con, "SELECT * FROM temp_table WHERE user_id = '$userid'");
            foreach ($find_details as $find_results) {
                $ProductId = $find_results['product'];
                $Quantity = $find_results['qty'];
                $Amount = $find_results['amount'];
                $Emi = $find_results['emi'];
                $Advance = $find_results['advance'];
                $find_Max_cust_Order = mysqli_query($con, "SELECT MAX(ci_id) FROM customer_items");
                foreach ($find_Max_cust_Order as $find_Max_cust_Order_result) {
                    $max_custOrder = $find_Max_cust_Order_result['MAX(ci_id)'] + 1;
                }
                $ref_id = 'ORD-' . date("dmY") . '-' . $max_mainOrder . '-' . $max_custOrder;
                $add_order_item = mysqli_query($con, "INSERT INTO customer_items (ci_id,order_id,ref_id,cust_id,p_id,emi,total_amount,total_qty,start_date,order_status,createdBy,createdDate) 
                        VALUES ('$max_custOrder','$mainOrder','$ref_id','$custName','$ProductId','$Emi','$Amount','$Quantity','$purchaseDate','PENDING','$userid','$timeNow')");

                if($add_order_item){
                    $findMaxTransid = mysqli_query($con, "SELECT MAX(t_id) FROM customer_transactions");
                    foreach($findMaxTransid as $findMaxTransidResult){
                        $maxTransId = $findMaxTransidResult['MAX(t_id)'] + 1;
                    } 
                    $add_inital_payment = mysqli_query($con, "INSERT INTO customer_transactions (t_id,ci_id,Amount,createdby,createdDate) 
                    VALUES ('$maxTransId','$max_custOrder','$Advance','$userid','$timeNow')");
                    if($add_inital_payment){
                        $updateCustomerItems =  mysqli_query($con, "UPDATE customer_items SET paid_amount = paid_amount + '$Advance' WHERE ci_id = '$max_custOrder'");
                        if($updateCustomerItems){
                            mysqli_commit($con);
                        }
                        else{
                            mysqli_rollback($con);
                        }
                    }
                    else{
                        mysqli_rollback($con);
                    }
                }
                else{
                    mysqli_rollback($con);
                }
            }
            if ($updateCustomerItems) {
                mysqli_commit($con);
                echo json_encode(array('status' => 1));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('status' => 0));
            }
        } else {
            mysqli_rollback($con);
            echo json_encode(array('status' => 0));
        }
    } else {
        echo json_encode(array('status' => 2));
    }

    UpdateOrderStatus($custName);
}
