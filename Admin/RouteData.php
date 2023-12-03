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

$find_data = mysqli_query($con, "SELECT route_id,d_id,route_name,district_name FROM route_master r INNER JOIN district_master d ON r.d_id = d.district_id WHERE d.district_id <> 0");
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





