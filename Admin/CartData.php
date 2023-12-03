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

$userid = $_SESSION['custid'];

require_once "../MAIN/Dbconfig.php";







//Display cart items


if (isset($_POST["cart"])) {

?>

    <div class="d-flex justify-content-between mb-2">
        <h4 class="m-0 pb-2 my-auto">Order Table</h4>
        <button class="btn py-0 shadow-none btn-danger clearAllBtn" type="button">Clear all</button>
    </div>

    <div class="table-responsive">

    

    <table class="table-striped table table_items">
        <thead class="text-center">
            <tr>
                <th>Sl</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Advance</th>
                <th>Emi</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
    <?php
    $fetchCart = mysqli_query($con, "SELECT t.temp_id,t.qty,t.amount,t.emi,t.advance,i.item_name FROM temp_table t INNER JOIN item_master i ON t.product = i.item_id WHERE t.user_id = '$userid' ORDER BY t.temp_id ASC");

    
    if (mysqli_num_rows($fetchCart) > 0) {
    foreach ($fetchCart as $Cart) {


?>
    <tr>
        <td><?php echo $Cart['temp_id'];?></td>
        <td><?php echo $Cart['item_name']; ?></td>
        <td><?php echo $Cart['qty']; ?></td>
        <td >&#8377;<?php  echo number_format($Cart['amount']);?></td>
        <td><input type="number" id="<?php echo $Cart['temp_id']; ?>" class="form-control numberInput change_advance text-center px-1 m-0" value="<?php echo $Cart['advance'] ;?>"></td>
        <td><input type="number" id="<?php echo $Cart['temp_id']; ?>" class="form-control numberInput change_btn text-center px-1 m-0 " value="<?php echo $Cart['emi'] ;?>"></td>
        <td><button class="btn px-2 py-1 delete_btn btn_delete shadow-none ms-3" type="button" value="<?php echo $Cart['temp_id'];?>" > <i class="ri-delete-bin-4-line"></i> </button></td>
    </tr>
        <?php

        }
?>

        </tbody>

        </table>

        </div>


       



<?php
    } 
    else {
        ?>

            <tr>
                <td class="text-center" colspan="7"> <strong>Please add some products</strong> </td>
            </tr>

        <?php
    }



?>
    <?php
}

?>


