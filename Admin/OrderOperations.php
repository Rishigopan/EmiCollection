<?php //session_start(); ?>
<?php 

        
    include '../MAIN/Dbconfig.php';
    include '../Admin/CommonFunctions.php';

    $userid = $_SESSION['custid'];
   
    //Add item
    if(isset($_POST['ItemId'])){

        $itemID = $_POST['ItemId'];
        $itemQty = SanitizeInt($_POST['ProductQuantity']);
        $itemEmi = SanitizeFloat($_POST['WeeklyInstallment']);
        $itemAmount = SanitizeFloat($_POST['ProductPrice']);
        $itemAdvance = SanitizeFloat($_POST['AdvanceAmount']);
       
        $check_query = mysqli_query($con, "SELECT * FROM temp_table WHERE product = '$itemID' AND user_id = '$userid'");
        if(mysqli_num_rows($check_query) > 0){
        
            $update_Table = mysqli_query($con, "UPDATE temp_table SET qty = qty + $itemQty, emi = emi + ($itemEmi * $itemQty), amount = amount + ($itemAmount * $itemQty),advance = $itemAdvance  WHERE product = '$itemID' AND user_id = '$userid'");

            if($update_Table){
                echo json_encode(array('addItem' => '3'));//updated
            }
            else{
                echo json_encode(array('addItem' => '2'));//failed
            }
        }
        else{

            $find_maxId = mysqli_query($con, "SELECT MAX(temp_id) FROM temp_table ");
            foreach($find_maxId as $Maxids){
                $max_id = $Maxids['MAX(temp_id)'] + 1;
            }

            $itemAmount = $itemAmount * $itemQty;

            $add_Table =  mysqli_query($con, "INSERT INTO temp_table (temp_id,product,qty,amount,emi,advance,user_id) VALUES ('$max_id','$itemID','$itemQty','$itemAmount','$itemEmi','$itemAdvance','$userid')");

            if($add_Table){
                echo json_encode(array('addItem' => '1'));//success
            }
            else{
                echo json_encode(array('addItem' => '2'));//failed
            }
        }

    }

    

    //view product details
    if(isset($_POST['ProductId'])){

        $fetchProductId = $_POST['ProductId'];

        $find_itemDetails = mysqli_query($con, "SELECT item_name,item_price,discount_price,itemEmi FROM item_master WHERE item_id = '$fetchProductId'");
        if(mysqli_num_rows($find_itemDetails) > 0){
            foreach($find_itemDetails as $itemDetails){
                $prName = $itemDetails['item_name'];
                $prPrice = $itemDetails['item_price'];
                $prDiscount =  $itemDetails['discount_price'];
                $prEmi =  $itemDetails['itemEmi'];
            }
            echo json_encode(array('itemStatus' => 1,'itemName' => $prName,'itemPrice' => $prPrice,'itemDiscount' => $prDiscount, 'itemEmi' => $prEmi));
        }
        else{
            echo json_encode(array('itemStatus' => 0));
        }

    }



    
    //delete item
    if(isset($_POST['delValue'])){
 
        $DeleteItem = $_POST['delValue'];
       
        $delete_query =  mysqli_query($con, "DELETE FROM temp_table WHERE temp_id = '$DeleteItem' AND user_id = '$userid'");

        if($delete_query){
            echo json_encode(array('delStatus' => '1'));
        }
        else{
            echo json_encode(array('delStatus' => '0'));
        }
        
    }


    //delete all items
    if(isset($_POST['delAll'])){

        //$delAll = $_POST['delAll'];

        $delAllItems = mysqli_query($con, "DELETE FROM temp_table WHERE user_id = '$userid'");
        if($delAllItems){
            echo json_encode(array('delAllStatus' => 1));
        }
        else{
            echo json_encode(array('delAllStatus' => 0));
        }

    }
    

    //update qty
    if(isset($_POST['editValue'])){
        $updtId = $_POST['editID'];
        $updtEmi = $_POST['editValue'];

        $edit_category = mysqli_query($con, "UPDATE temp_table SET emi = '$updtEmi' WHERE temp_id = '$updtId' AND user_id = '$userid'");
        if($edit_category){
            
            echo json_encode(array('updtStatus' => 1));
        }
        else{
            echo json_encode(array('updtStatus' => 0));
        }
     
    }


    //update advance
    if(isset($_POST['AdvanceValue'])){
        $updtAdvanceId = $_POST['AdvanceID'];
        $updtAdvance = $_POST['AdvanceValue'];

        $edit_advance = mysqli_query($con, "UPDATE temp_table SET advance = '$updtAdvance' WHERE temp_id = '$updtAdvanceId' AND user_id = '$userid'");
        if($edit_advance){
            
            echo json_encode(array('updtStatus' => 1));
        }
        else{
            echo json_encode(array('updtStatus' => 0));
        }
     
    }




?>