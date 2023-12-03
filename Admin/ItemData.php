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

$find_data = mysqli_query($con, "SELECT *  FROM item_master ");
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





