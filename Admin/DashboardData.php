<?php session_start(); ?>
<?php

require_once "../MAIN/Dbconfig.php";
//$GivenDate = '2022-09-22';

//Single Day
if (isset($_POST["action"])) {

    $GivenDate = $_POST['action'];

    $findDistrictWise = mysqli_query($con, "SELECT d.district_name,d.district_id,SUM(ct.Amount) AS TotalCollection FROM customer_transactions ct INNER JOIN route_master r ON ct.r_id = r.route_id INNER JOIN district_master d ON r.d_id = d.district_id WHERE DATE(ct.createdDate) = '$GivenDate' AND ct.r_id <> 0 GROUP BY d.district_id");
    if(mysqli_num_rows($findDistrictWise) > 0){
        while($findDistrictWiseResults =  mysqli_fetch_array($findDistrictWise)){
            $DistrictId  = $findDistrictWiseResults['district_id'];
        ?>

            <tr>
              
                <th> <?php echo $findDistrictWiseResults['district_name']; ?>  </th>
                <th> <?php echo $findDistrictWiseResults['TotalCollection']; ?>  </th>
            </tr>


            <?php  
            
            $findRouteWise = mysqli_query($con, "SELECT r.route_name,SUM(ct.Amount) AS TotalCollectionRoute FROM customer_transactions ct INNER JOIN route_master r ON ct.r_id = r.route_id INNER JOIN district_master d ON r.d_id = d.district_id WHERE d.district_id = '$DistrictId' AND DATE(ct.createdDate) = '$GivenDate' GROUP BY r.route_id");
            foreach($findRouteWise as $findRouteWiseResults){
                echo 
                '<tr> 
                   
                    <td>'.$findRouteWiseResults["route_name"].'</td>  
                    <td>'.$findRouteWiseResults["TotalCollectionRoute"].'</td>  
                
                </tr>';
            }
            
            ?>

            

        <?php
        }
       
        
        $findDayWiseSum = mysqli_query($con, "SELECT SUM(Amount) AS TotalCollectionDay FROM customer_transactions  WHERE DATE(createdDate) = '$GivenDate' AND r_id <> 0");
        foreach($findDayWiseSum as $findDayWiseSumResults){
            echo 
            '<tr> 
                <th>Total</th>
                <th >'.$findDayWiseSumResults["TotalCollectionDay"].'</th>  
            
            </tr>';
        }
                
           
    }
    else{
        echo 
            '<tr > 
                <td colspan="2">No Records Found</td>  

            </tr>';

    }

}




//Custom Range
if (isset($_POST["first"])) {

    $StartDate = $_POST['first'];

    $EndDate = $_POST['last'];

    $findDistrictWise = mysqli_query($con, "SELECT d.district_name,d.district_id,SUM(ct.Amount) AS TotalCollection FROM customer_transactions ct INNER JOIN route_master r ON ct.r_id = r.route_id INNER JOIN district_master d ON r.d_id = d.district_id WHERE ct.r_id <> 0 AND DATE(ct.createdDate) BETWEEN '$StartDate' AND '$EndDate'  GROUP BY d.district_id;");
    if(mysqli_num_rows($findDistrictWise) > 0){
        while($findDistrictWiseResults =  mysqli_fetch_array($findDistrictWise)){
            $DistrictId  = $findDistrictWiseResults['district_id'];
        ?>

            <tr>
               
                <th> <?php echo $findDistrictWiseResults['district_name']; ?>  </th>
                <th> <?php echo $findDistrictWiseResults['TotalCollection']; ?>  </th>
            </tr>


            <?php  
            
            $findRouteWise = mysqli_query($con, "SELECT r.route_name,SUM(ct.Amount) AS TotalCollectionRoute FROM customer_transactions ct INNER JOIN route_master r ON ct.r_id = r.route_id INNER JOIN district_master d ON r.d_id = d.district_id WHERE d.district_id = '$DistrictId' AND DATE(ct.createdDate) BETWEEN '$StartDate' AND '$EndDate' GROUP BY r.route_id");
            foreach($findRouteWise as $findRouteWiseResults){
                echo 
                '<tr> 
                   
                    <td>'.$findRouteWiseResults["route_name"].'</td>  
                    <td>'.$findRouteWiseResults["TotalCollectionRoute"].'</td>  
                
                </tr>';
            }
            
            ?>

        <?php
        }

        $findRangeWiseSum = mysqli_query($con, "SELECT SUM(Amount) AS TotalCollectionDay FROM customer_transactions  WHERE r_id <> 0 AND DATE(createdDate) BETWEEN  '$StartDate' AND '$EndDate'");
        foreach($findRangeWiseSum as $findRangeWiseSumResults){
            echo 
            '<tr> 
                <th>Total</th>
                <th >'.$findRangeWiseSumResults["TotalCollectionDay"].'</th>  
            
            </tr>';
        }
    }
    else{
        echo 
            '<tr > 
                <td colspan="2">No Records Found</td>  

            </tr>';

    }

}







?>

