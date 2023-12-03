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



//Display Branch
if (isset($_POST["user"])) {

    $fetchUser = mysqli_query($con, "SELECT * FROM user_table WHERE role <> 'SuperAdmin'");
    if (mysqli_num_rows($fetchUser) > 0) {
        foreach ($fetchUser as $User) {
?>
            <li class="p-2 ">
                <div class="row px-3">
                    <div class="col-8 col-xxl-10 col-md-8 col-lg-9">
                        <h5 class="mt-2"><?php echo $User['name']; ?> <span class="badge text-bg-primary"><?php echo $User['role']; ?></span> </h5>
                        
                        
                    </div>
                    <div class="col-4 d-flex justify-content-end col-xxl-2 col-md-4 col-lg-3">
                        <div><button class="btn btn_edit" value="<?php echo $User['user_id']; ?>"> <i class="ri-pencil-fill"></i></button></div>
                        <!--<div><button class="btn btn_delete" value="<?php echo $User['user_id']; ?>"> <i class="ri-delete-bin-fill"></i> </button></div> -->
                    </div>
                    <div class="col-6 mt-2">
                        <h6> <i class="material-icons" style="vertical-align: middle;">account_box</i>    <span><?php echo $User['phone']; ?></span> </h6>
                    </div>
                    <div class="col-6 text-end mt-2">
                        <h6> <i class="material-icons" style="vertical-align: middle;"> vpn_key </i>  <span><?php echo $User['password']; ?></span>  </h6>
                    </div>
                </div>
            </li>

        <?php

        }
    } else {
        ?>
            <li class="p-2 ">
                <div class="row  px-3">
                    <div class="col-12 ">
                        <h5 class="mt-2 text-center">No User Data</h5>
                    </div>

                </div>
            </li>
        <?php
    }
}


?>







<script>
    //Edit User
    $('.btn_edit').click(function() {
        var edit_user_id = $(this).val();
        console.log(edit_user_id);

        $.ajax({
            method: "POST",
            url: "MasterOperations.php",
            data: {
                edit_user_id: edit_user_id
            },
            beforeSend: function() {
                $('#addUserForm').addClass("disable");
            },
            success: function(data) {
                //console.log(data);
                var editUser = JSON.parse(data);
                if (editUser.uservalue == 'error') {
                    toastr.error("Some Error Occured");
                } else {
                    $('#addUserForm').removeClass("disable");
                    $('#EditFull_name').val(editUser.userFullname);
                    $('#EditUser_name').val(editUser.userName);
                    $('#EditUser_pass').val(editUser.userPass);
                    $('#EditUser_role').val(editUser.userRole).change();
                    $('#updateuserId').val(edit_user_id);
                    $('#updateUserForm').show();
                    $('#addUserForm').hide();
                }

            },
            error: function() {
                alert("Error");
            }
        })
    });

    /*
    //DELETE user
    $('.btn_delete').click(function() {
        var del_user_id = $(this).val();
        console.log(del_user_id);
        $.ajax({
            method: "POST",
            url: "user_operations.php",
            data: {
                del_user_id: del_manufacture_id
            },
            beforeSend: function() {
                $('#addManufacturerForm').addClass("disable");
            },
            success: function(data) {

                $('#addManufacturerForm').removeClass("disable");
                console.log(data);

                var deleteMan = JSON.parse(data);
                if (deleteMan.manufacturerdel == '0') {
                    toastr.warning("Manufacturer Is In Use");
                } else if (deleteMan.manufacturerdel == '1') {
                    toastr.success("Successfully Deleted");
                    getManufacturerData();

                } else if (deleteMan.manufacturerdel == '2') {
                    toastr.error("Failed Deleting Manufacturer");
                }

            },
            error: function() {
                alert("Error");
            }
        })
    });

    */
</script>