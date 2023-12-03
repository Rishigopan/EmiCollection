
<?php

include '../MAIN/Dbconfig.php';
include '../Admin/CommonFunctions.php';
//Delete Customer Items

if (isset($_POST['CiDelete'])) {

    $DelCustItemId = SanitizeInt($_POST['CiDelete']);

    mysqli_autocommit($con, FALSE);
    $findOrderItemDetails = mysqli_query($con, "SELECT order_id,total_amount,total_qty FROM customer_items WHERE ci_id = '$DelCustItemId'");
    foreach($findOrderItemDetails as $findOrderItemDetailsResults){
        $mainOrderId = $findOrderItemDetailsResults['order_id'];
        $totalAmount = $findOrderItemDetailsResults['total_amount'];
        $totalQty = $findOrderItemDetailsResults['total_qty'];
    }

    $deleteAllTransactions =  mysqli_query($con, "DELETE FROM customer_transactions WHERE ci_id = '$DelCustItemId'");
    if($deleteAllTransactions){
        $deleteOrderItem = mysqli_query($con, "DELETE FROM customer_items WHERE ci_id = '$DelCustItemId'");
        if($deleteOrderItem){
            $updateMainOrder = mysqli_query($con, "UPDATE customer_orders SET total_amount =  total_amount - '$totalAmount',total_qty = total_qty - '$totalQty',total_items = total_items - '1' WHERE order_id = '$mainOrderId'");
            if($updateMainOrder){
                mysqli_commit($con);
                echo json_encode(array('DeleteCItem' => '1'));
                UpdateMainOrder($mainOrderId);
            }
            else{
                mysqli_rollback($con);
                echo json_encode(array('DeleteCItem' => '2'));
            }
        }
        else{
            mysqli_rollback($con);
            echo json_encode(array('DeleteCItem' => '2'));
        }
    }
    else{
        mysqli_rollback($con);
        echo json_encode(array('DeleteCItem' => '2'));
    }





}

?>