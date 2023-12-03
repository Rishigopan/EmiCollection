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

$find_data = mysqli_query($con, "SELECT cust_id,cust_name,cust_phone,d.district_name,r.route_name,cust_location,location_position FROM customer_master cm INNER JOIN district_master d ON cm.cust_district = d.district_id INNER JOIN route_master r ON cm.cust_route = r.route_id;");
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





