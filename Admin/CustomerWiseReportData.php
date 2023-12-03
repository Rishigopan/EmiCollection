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

 
require_once "../MAIN/Dbconfig.php";

$find_data = mysqli_query($con, "SELECT c.cust_id,c.cust_name,c.cust_phone,d.district_name,r.route_name,c.last_paymentDate,(SELECT SUM(coo.total_amount) FROM customer_master cm INNER JOIN customer_orders coo ON cm.cust_id = coo.cust_id WHERE coo.cust_id = c.cust_id) AS totalAmount ,(SELECT SUM(coo.total_qty) FROM customer_master cm INNER JOIN customer_orders coo ON cm.cust_id = coo.cust_id WHERE coo.cust_id = c.cust_id) AS totalQty FROM customer_master c INNER JOIN customer_orders co ON c.cust_id = co.cust_id INNER JOIN district_master d ON c.cust_district = d.district_id INNER JOIN route_master r ON  c.cust_route = r.route_id GROUP BY c.cust_id ORDER BY c.cust_id ASC;");
if(mysqli_num_rows($find_data) > 0){
    while ($dataRow = mysqli_fetch_assoc($find_data)) {
        $rows[] = $dataRow;
    }
}
else{
    $rows = array();
}


$dataset = array(
    "data" => $rows
);

echo json_encode($dataset);

?>





