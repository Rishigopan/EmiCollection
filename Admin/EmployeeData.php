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

$find_data = mysqli_query($con, "SELECT e.employee_id,e.employee_name,e.tag_id,e.employee_phone,e.employee_address,m.route_name AS monday,t.route_name AS tuesday,w.route_name AS wednesday,th.route_name AS thursday,f.route_name AS friday,s.route_name AS saturday,su.route_name AS sunday FROM employee_master e INNER JOIN route_master m ON e.emp_mon = m.route_id INNER JOIN route_master t ON e.emp_tue = t.route_id INNER JOIN route_master w ON e.emp_wed = w.route_id INNER JOIN route_master th ON e.emp_thu = th.route_id INNER JOIN route_master f ON e.emp_fri = f.route_id INNER JOIN route_master s ON e.emp_sat = s.route_id INNER JOIN route_master su ON e.emp_sun = su.route_id");
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





