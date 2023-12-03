<?php session_start(); ?>
<?php



include '../MAIN/Dbconfig.php';


if(isset($_POST['ProductId'])){

    $custItemId = $_POST['ProductId'];
    $CustomerId = $_POST['CustomerId'];


        $install_details = mysqli_query($con, "SELECT i.item_name,ct.Amount,e.employee_name,ct.createdDate,ct.e_id,u.name FROM customer_transactions ct INNER JOIN customer_items ci ON ct.ci_id = ci.ci_id LEFT JOIN employee_master e ON ct.e_id = e.employee_id INNER JOIN item_master i ON ci.p_id = i.item_id  INNER JOIN user_table u ON ct.createdby = u.user_id  WHERE ci.cust_id = '$CustomerId' AND ci.ci_id = '$custItemId'");

        if(mysqli_num_rows($install_details) > 0){

        foreach($install_details as $install_results){
            $emp_id = $install_results['e_id'];
    ?>
        <tr>
            <td class="rowCount"></td>
            <td> <?php echo $install_results['item_name']; ?> </td>
            <td> <?php echo intval($install_results['Amount']) ; ?> </td>
            <td> <?php echo  date("d M Y h:i A", strtotime($install_results['createdDate']));  ?> </td>
            <!-- <td> <?php echo $install_results['employee_name']; ?> </td> -->
            <td> <?php  
            if($emp_id == 0 )
            { echo $install_results['name'];} 
            else{
                echo $install_results['employee_name'];
            } 
            ?> 
            </td>
        </tr>
    <?php
        }
    }
    else{
        echo '<tr> <td colspan="5" class="text-center" > No Installments </td>  </tr>';
    }
    ?>
                        
<?php
       
}

?>