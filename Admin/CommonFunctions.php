<?php session_start(); ?>
<?php 




function UpdateOrderStatus($customerID){

    include "../MAIN/Dbconfig.php";
    $find_orderdetails =  mysqli_query($con, "SELECT * FROM customer_master c INNER JOIN customer_items ci ON c.cust_id = ci.cust_id  WHERE c.cust_id = '$customerID' AND ci.order_status = 'PENDING'");
    foreach($find_orderdetails as $order_result){
        $TotalAmount = $order_result['total_amount'];
        $PaidAmount = $order_result['paid_amount'];
        $OrderItemId = $order_result['ci_id'];
        //echo 'the total amount is '.$TotalAmount.'and paid amount is '.$PaidAmount.' And OrderItem id is '.$OrderItemId.'';
         if($TotalAmount == $PaidAmount){
            $update_order = mysqli_query($con, "UPDATE customer_items SET order_status = 'COMPLETED' WHERE ci_id = '$OrderItemId'");

            if($update_order){
                //echo "successfully Updated";
            } 

            //echo 'equal';
        }
        else{
            //echo 'not equal';
        }
    }
}


//UpdateOrderStatus(2);



//Santize the the string and change to uppercase
function SanitizeAndUpper($input){
    $input = trim($input);
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    $input = strtoupper($input);
    return $input;
}


//sanitize the input integer
function SanitizeInt($intinput){
    $intinput = trim($intinput);
    $intinput = htmlspecialchars($intinput);
    $intinput = stripslashes($intinput);
    $intinput = filter_var($intinput, FILTER_SANITIZE_NUMBER_INT);
    $intinput = ($intinput == '') ? 0 : $intinput;
    return $intinput;
}


function SanitizeFloat($floatinput){
    $floatinput = trim($floatinput);
    $floatinput = htmlspecialchars($floatinput);
    $floatinput = stripslashes($floatinput);
    $floatinput = filter_var($floatinput, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
    $floatinput = ($floatinput == '') ? 0.000 : $floatinput;
    return $floatinput;
}



function UpdateMainOrder($orderId){
    include "../MAIN/Dbconfig.php";
    $find_mainorderdetails =  mysqli_query($con, "SELECT total_items,total_qty,total_amount FROM customer_orders WHERE order_id = '$orderId'");
    foreach($find_mainorderdetails as $mainorder_result){
        $Totalamount = $mainorder_result['total_amount'];
        $Totalqty = $mainorder_result['total_qty'];
        $Totalitems = $mainorder_result['total_items'];
       
        if($Totalamount == 0 && $Totalitems == 0 && $Totalqty == 0){
            $DeleteMainOrder = mysqli_query($con, "DELETE FROM customer_orders WHERE order_id = '$orderId'");
            if($DeleteMainOrder){
                //echo "success";
            }
            else{
                 //echo "failed";
            }
        }
        else{
            //echo 'not correct';
        }
    }
}


?>