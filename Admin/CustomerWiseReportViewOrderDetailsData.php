<?php session_start(); ?>
<?php
include '../MAIN/Dbconfig.php';



if(isset($_POST['CustomerOrderId'])){

    $CustomerOrderId = $_POST['CustomerOrderId'];
?>
        <div class="row my-4">
            <div class="col-lg-3">
                <label for="CustomerProdutSelect" class="form-label"> <strong>Product</strong>  </label>
                <select name="" id="CustomerProdutSelect" class="form-select"  data-value="<?php echo $CustomerOrderId ?>"> 
                            <option value="">Choose...</option>
                        <?php
                            $find_Allorders = mysqli_query($con, "SELECT ci.ci_id,i.item_name,ci.start_date FROM customer_items ci INNER JOIN item_master i ON ci.p_id = i.item_id WHERE ci.cust_id = '$CustomerOrderId' ");
                            foreach($find_Allorders  as $Allorders){
                                echo '<option value='.$Allorders['ci_id'].' >'.$Allorders['item_name'].' - '. date("d M Y", strtotime($Allorders['start_date']))    .'</option>';
                            }
                        ?>
                </select>

               
            </div>

            <div class="col-lg-9">
                <form action="" id="all_itemsForm">
                    <div class="table-responsive mt-lg-0 mt-3" id="table_container">
                       
                        <table class="table table-striped" id="viewDetailTable">
                            <thead>
                                <tr>
                                    <th>Sl. No</th>
                                    <th>Product</th>
                                    <th>Paid</th>
                                    <th>Date</th>
                                    <th>Collected By</th>
                                </tr>
                            </thead>
                            <tbody id="display_allitems">

                            </tbody>
                        
                        </table>
                    </div>
                </form>
            </div>
        </div>

        <?php
    
}

?>
