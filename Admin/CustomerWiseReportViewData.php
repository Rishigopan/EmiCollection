<?php session_start(); ?>
<?php

if (isset($_SESSION['custid']) && isset($_SESSION['custtype'])) {
    if ($_SESSION['custtype']  == 'SUPERADMIN' || $_SESSION['custtype']  == 'ADMIN') {
    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}

include '../MAIN/Dbconfig.php';


if (isset($_POST['CustId'])) {

    $CustId = $_POST['CustId'];


    $find_custDetails = mysqli_query($con, "SELECT c.cust_id,c.cust_name,d.district_name,r.route_name,c.cust_location,c.cust_phone FROM customer_master c INNER JOIN route_master r ON c.cust_route = r.route_id INNER JOIN district_master d ON c.cust_district = d.district_id WHERE c.cust_id = '$CustId'");
    while ($Details = mysqli_fetch_array($find_custDetails)) {
        //$order_id = $Details['order_id'];
?>
        <div class="row">
            <div class="col-lg-4 d-flex justify-content-center my-auto">
                <div class="">
                    <div class="d-flex pb-2">
                        <dt class="me-3">Name :</dt>
                        <dd> <?php echo $Details['cust_name']; ?> </dd>
                    </div>
                    <div class="d-flex pb-2">
                        <dt class="me-3">Phone :</dt>
                        <dd> <?php echo $Details['cust_phone']; ?> </dd>
                    </div>
                    <div class="d-flex pb-2">
                        <dt class="me-3">District :</dt>
                        <dd> <?php echo $Details['district_name']; ?> </dd>
                    </div>
                    <div class="d-flex pb-2">
                        <dt class="me-3">Route :</dt>
                        <dd> <?php echo $Details['route_name']; ?> </dd>
                    </div>
                    <div class="d-flex ">
                        <dt class="me-3">Location :</dt>
                        <dd> <?php echo $Details['cust_location']; ?> </dd>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="table-responsive mt-lg-0 mt-3" id="table_container">
                    <table class="table table-striped" id="viewDetailTable">
                        <thead class="">
                            <tr>
                                <th>Sl.No</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Start Date</th>
                                <th>Amount</th>
                                <th>Emi</th>
                                <th>Paid</th>
                                <th>Status</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            $order_details = mysqli_query($con, "SELECT * FROM customer_items ci INNER JOIN item_master i ON ci.p_id = i.item_id WHERE ci.cust_id = '$CustId'");
                            foreach ($order_details as $ord_details) {
                            ?>
                                <tr>
                                    <td class="rowCount"></td>
                                    <td> <?php echo $ord_details['item_name']; ?> </td>
                                    <td> <?php echo intval($ord_details['total_qty']); ?> </td>
                                    <td> <?php echo date("d M Y", strtotime($ord_details['start_date'])); ?> </td>
                                    <td> <?php echo number_format($ord_details['total_amount']); ?> </td>
                                    <td> <?php echo number_format($ord_details['emi']); ?> </td>
                                    <td> <?php echo number_format($ord_details['paid_amount']); ?> </td>
                                    <td> <?php echo $ord_details['order_status']; ?> </td>
                                    <td> <button class="del_btn btn shadow-none" <?php if ($_SESSION['custtype']  != 'SUPERADMIN') {
                                                                                        echo "disabled";
                                                                                    } else {
                                                                                    } ?> type="button" value="<?php echo $ord_details['ci_id']; ?>"> <i class="material-icons">delete_outline</i> </button> </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<?php
    }
}

?>



<script>
    $('.del_btn').click(function() {
        var CiDelete = $(this).val();
        console.log(CiDelete);
        var ConfirmDelete = confirm("Are you sure you want to delete this Item?");
        if (ConfirmDelete == true) {
            $.ajax({
                type: "POST",
                url: "CustomerWiseReportOperations.php",
                data: {
                    CiDelete: CiDelete
                },
                beforeSend: function() {
                    //$('#AddRouteForm').addClass("disable");
                },
                success: function(data) {
                    //$('#AddRouteForm').removeClass("disable");
                    console.log(data);
                    var deleteResponse = JSON.parse(data);
                    if (deleteResponse.DeleteCItem == 0) {
                        toastr.warning("Route is Already in Use");
                    } else if (deleteResponse.DeleteCItem == 1) {
                        toastr.success("Successfully Deleted");
                        $('#ViewModal').modal('hide');
                        //itemTable.ajax.reload();
                    } else {
                        toastr.error("Some Error Occured");
                    }
                }
            });
        } else {
            toastr.info("Cancelled!");
        }
    });
</script>