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



//Display District
if(isset($_POST["custDistrict"])){
    
    echo '<option hidden value=""> Select District</option>';
    $fetchDistrict = mysqli_query($con, "SELECT district_id,district_name FROM district_master WHERE district_id <> 0 ORDER BY district_name ASC");
    if(mysqli_num_rows($fetchDistrict) > 0){
        foreach($fetchDistrict as $fetchResult){
            echo '<option value="'.$fetchResult["district_id"].'">  '.$fetchResult["district_name"].' </option>';
        }
    }
    else{
        echo '<option hidden value=""> No Results</option>';
    }
}


//Display Route by district
if(isset($_POST["custRoute"])){
    
    $districtId = $_POST['custRoute'];

    $fetchRoute = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE d_id = '$districtId' ORDER BY route_name ASC");
    if(mysqli_num_rows($fetchRoute) > 0){
        foreach($fetchRoute as $fetchRouteResult){
            echo '<option value="'.$fetchRouteResult["route_id"].'">  '.$fetchRouteResult["route_name"].' </option>';
        }
    }
    else{
        echo '<option hidden value=""> Select Route</option>';
    }
}


//Display All Route
if(isset($_POST["custAllRoute"])){
    
    
    $fetchAllRoute = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE route_id <> 0 ORDER BY route_name ASC");
    if(mysqli_num_rows($fetchAllRoute) > 0){
        foreach($fetchAllRoute as $fetchAllRouteResult){
            echo '<option value="'.$fetchAllRouteResult["route_id"].'">  '.$fetchAllRouteResult["route_name"].' </option>';
        }
    }
    else{
        echo '<option hidden value=""> Select Route</option>';
    }
}



//Display Customers on Route
if(isset($_POST["FindCustomer"])){
    
    $routeId = $_POST['FindCustomer'];

    $fetchCustomer = mysqli_query($con, "SELECT cust_id,cust_name,cust_phone FROM customer_master WHERE cust_route = '$routeId' ORDER BY location_position ASC");
    if(mysqli_num_rows($fetchCustomer) > 0){
        foreach($fetchCustomer as $fetchCustomerResult){
            echo '<option value="'.$fetchCustomerResult["cust_id"].'">  '.$fetchCustomerResult["cust_name"].'  -  '.$fetchCustomerResult["cust_phone"].' </option>';
        }
    }
    else{
        echo '<option hidden value="">No Customer</option>';
    }
}



?>

