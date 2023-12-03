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



//Display Category
if(isset($_POST["district"])){
    
    $fetchQuery = mysqli_query($con, "SELECT district_id,district_name FROM district_master WHERE district_id <> 0 ORDER BY district_name ASC");
    if(mysqli_num_rows($fetchQuery) > 0){
        foreach($fetchQuery as $result){
    ?> 

        <li class="p-2 ">
            <div class="row  px-3">
                <div class="col-8 col-xxl-10 col-md-8 col-lg-9">
                    <h5 class="mt-2"><?php echo $result['district_name']; ?></h5>
                </div>
                <div class="col-4 d-flex col-xxl-2 col-md-4 col-lg-3">
                    <div><button class="btn btn_edit" value="<?php echo $result['district_id']; ?>"> <i class="ri-pencil-fill"></i></button></div>
                    <div><button class="btn btn_delete" <?php if ($_SESSION['custtype']  != 'SUPERADMIN'){ echo "disabled";}else{ } ?> value="<?php echo $result['district_id']; ?>"> <i class="ri-delete-bin-fill"></i> </button></div>
                </div>
            </div>
        </li>

    <?php

        }
    }
    else{
    ?>
        <li class="p-2 ">
            <div class="row  px-3">
                <div class="col-12 ">
                    <h5 class="mt-2 text-center">No Category Data</h5>
                </div>
                
            </div>
        </li>
    <?php
    }
}


?>







<script>

    //Edit District
    $('.btn_edit').click(function(){
        var EditDistrictId  = $(this).val();
        console.log(EditDistrictId);
        $('#AddDistrictForm')[0].reset();
        $.ajax({
            method:"POST",
            url:"MasterOperations.php",
            data:{EditDistrictId:EditDistrictId},
            beforeSend:function(){
                $('#AddDistrictForm').addClass("disable");
            },
            success:function(data){
                //console.log(data);
                var EditResponse = JSON.parse(data);
                if(EditResponse.EditDistrict == 'error'){
                    toastr.error("Some Error Occured");
                }
                else{
                    $('#AddDistrictForm').removeClass("disable");
                    $('#Update_district_name').val(EditResponse.EditDistrict);   
                    $('#edit_district_id').val(EditDistrictId);
                    $('#UpdateDistrictForm').show();
                    $('#AddDistrictForm').hide(); 
                }        
            },
            error:function(){
                alert("Error");
            }
        })
    });


                 
    //Delete  District
    $('.btn_delete').click(function(){
        var DelDistrictId  = $(this).val();
        console.log(DelDistrictId);
        var ConfirmDelete = confirm("Are you sure you want to delete this District?");
        if(ConfirmDelete == true){
            $.ajax({
                method:"POST",
                url:"MasterOperations.php",
                data:{DelDistrictId:DelDistrictId},
                beforeSend:function(){
                    $('#AddDistrictForm').addClass("disable");
                },
                success:function(data){
                    $('#AddDistrictForm').removeClass("disable");
                    console.log(data);
                    var DeleteResponse = JSON.parse(data);
                    if(DeleteResponse.DistrictDelete == '0'){
                        toastr.warning("District Is In Use");
                    }
                    else if(DeleteResponse.DistrictDelete == '1'){
                        toastr.success("Successfully Deleted");
                        GetDistrictData();
                    }
                    else if(DeleteResponse.DistrictDelete == '2'){
                        toastr.error("Failed Deleting District");
                    }
                },
                error:function(){
                    alert("Error");
                }
            });
        }
        else{
            toastr.info("Cancelled!");
        }
    });


</script>