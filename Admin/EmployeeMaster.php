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

include '../MAIN/Dbconfig.php';

$pageTitle = 'Employee';


?>

<!doctype html>
<html lang="en">

<head>


    <?php


    include '../MAIN/Header.php';

    ?>
    <style>
        .disable {
            opacity: 0.3;
            pointer-events: none;
        }
    </style>


</head>

<body>

    <div class="wrapper">


        <!--NAVBAR-->
        <nav class="navbar fixed-top navbar-expand-lg bg-light p-1">
            <div class="container-fluid px-xl-5">
                <button class="btn btn-menu rounded-pill" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop"> <i class="material-icons">menu</i> <span class="d-md-inline-block d-none"> Menu </span></button>
                <a class="navbar-brand" href="#"> <strong>BETA</strong> </a>
                <button class="btn btn-menu  rounded-pill"> <span class="d-md-inline-block d-none"> <?php echo $_SESSION['custname']; ?> </span> <i class="material-icons">account_circle</i> </button>

            </div>
        </nav>


        <?php include '../MAIN/Sidebar.php'; ?>




        <!--CONTENTS-->
        <div class="container main-content">


            <h3 class="mt-3 title shadow-sm  py-2 text-center">Add Employee</h3>


            <div class="card card-body main-card shadow-sm">
                <div id="add_manufacturer">
                    <div class="row">
                        <div class="col-md-5 product_details mt-2 px-xl-2">
                            <form action="" id="AddEmployeeForm" novalidate>

                                <div class="row">
                                    <div class="inputs col-12">
                                        <label class="form-label" for="Employee_name">Employee Name</label>
                                        <input type="text" class="form-control" id="Employee_name" name="EmpName" data-v-max-length="20" data-v-message="Maximum 20 characters" placeholder="" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Employee_tag">Tag ID</label>
                                        <input type="text" name="EmpTag" class="form-control" id="Employee_tag" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Employee_phone">Phone Number</label>
                                        <input type="number" name="EmpPhone" class="form-control" id="Employee_phone" required>
                                    </div>

                                    <div class="inputs col-lg-3">
                                        <label class="form-label" for="Employee_monday">Monday</label>
                                        <select name="EmpMon" class="form-select" id="Employee_monday" required>
                                            <option selected value="0">NO ROUTE</option>
                                            <?php
                                            $findDistrict = mysqli_query($con, "SELECT district_id,district_name FROM district_master WHERE district_id <> 0 ORDER BY district_name ASC");
                                            foreach ($findDistrict as $district_results) {
                                                echo '<optgroup label="' . $district_results["district_name"] . '"></optgroup>';
                                                $district_id = $district_results["district_id"];
                                                $find_routes = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE d_id = '$district_id' ORDER BY route_name ASC");
                                                foreach ($find_routes as $route_results) {
                                                    echo '<option value="' . $route_results["route_id"] . '">' . $route_results["route_name"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="inputs col-lg-3">
                                        <label class="form-label" for="Employee_tuesday">Tuesday</label>
                                        <select name="EmpTue" class="form-select" id="Employee_tuesday" required>
                                            <option selected value="0">NO ROUTE</option>
                                            <?php
                                            $findDistrict = mysqli_query($con, "SELECT district_id,district_name FROM district_master  WHERE district_id <> 0 ORDER BY district_name ASC");
                                            foreach ($findDistrict as $district_results) {
                                                echo '<optgroup label="' . $district_results["district_name"] . '"></optgroup>';
                                                $district_id = $district_results["district_id"];
                                                $find_routes = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE d_id = '$district_id' ORDER BY route_name ASC");
                                                foreach ($find_routes as $route_results) {
                                                    echo '<option value="' . $route_results["route_id"] . '">' . $route_results["route_name"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>


                                    <div class="inputs col-lg-3">
                                        <label class="form-label" for="Employee_wednesday">Wednesday</label>
                                        <select name="EmpWed" class="form-select" id="Employee_wednesday" required>
                                            <option selected value="0">NO ROUTE</option>
                                            <?php
                                            $findDistrict = mysqli_query($con, "SELECT district_id,district_name FROM district_master  WHERE district_id <> 0 ORDER BY district_name ASC");
                                            foreach ($findDistrict as $district_results) {
                                                echo '<optgroup label="' . $district_results["district_name"] . '"></optgroup>';
                                                $district_id = $district_results["district_id"];
                                                $find_routes = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE d_id = '$district_id' ORDER BY route_name ASC");
                                                foreach ($find_routes as $route_results) {
                                                    echo '<option value="' . $route_results["route_id"] . '">' . $route_results["route_name"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="inputs col-lg-3">
                                        <label class="form-label" for="Employee_thursday">Thursday</label>
                                        <select name="EmpThu" class="form-select" id="Employee_thursday" required>
                                            <option selected value="0">NO ROUTE</option>
                                            <?php
                                            $findDistrict = mysqli_query($con, "SELECT district_id,district_name FROM district_master WHERE district_id <> 0 ORDER BY district_name ASC");
                                            foreach ($findDistrict as $district_results) {
                                                echo '<optgroup label="' . $district_results["district_name"] . '"></optgroup>';
                                                $district_id = $district_results["district_id"];
                                                $find_routes = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE d_id = '$district_id' ORDER BY route_name ASC");
                                                foreach ($find_routes as $route_results) {
                                                    echo '<option value="' . $route_results["route_id"] . '">' . $route_results["route_name"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="inputs col-lg-3">
                                        <label class="form-label" for="Employee_friday">Friday</label>
                                        <select name="EmpFri" class="form-select" id="Employee_friday" required>
                                            <option selected value="0">NO ROUTE</option>
                                            <?php
                                            $findDistrict = mysqli_query($con, "SELECT district_id,district_name FROM district_master WHERE district_id <> 0 ORDER BY district_name ASC");
                                            foreach ($findDistrict as $district_results) {
                                                echo '<optgroup label="' . $district_results["district_name"] . '"></optgroup>';
                                                $district_id = $district_results["district_id"];
                                                $find_routes = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE d_id = '$district_id' ORDER BY route_name ASC");
                                                foreach ($find_routes as $route_results) {
                                                    echo '<option value="' . $route_results["route_id"] . '">' . $route_results["route_name"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="inputs col-lg-3">
                                        <label class="form-label" for="Employee_saturday">Saturday</label>
                                        <select name="EmpSat" class="form-select" id="Employee_saturday" required>
                                            <option selected value="0">NO ROUTE</option>
                                            <?php
                                            $findDistrict = mysqli_query($con, "SELECT district_id,district_name FROM district_master WHERE district_id <> 0 ORDER BY district_name ASC");
                                            foreach ($findDistrict as $district_results) {
                                                echo '<optgroup label="' . $district_results["district_name"] . '"></optgroup>';
                                                $district_id = $district_results["district_id"];
                                                $find_routes = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE d_id = '$district_id' ORDER BY route_name ASC");
                                                foreach ($find_routes as $route_results) {
                                                    echo '<option value="' . $route_results["route_id"] . '">' . $route_results["route_name"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="inputs col-lg-3">
                                        <label class="form-label" for="Employee_sunday">Sunday</label>
                                        <select name="EmpSun" class="form-select" id="Employee_sunday" required>
                                            <option selected value="0">NO ROUTE</option>
                                            <?php
                                            $findDistrict = mysqli_query($con, "SELECT district_id,district_name FROM district_master WHERE district_id <> 0 ORDER BY district_name ASC");
                                            foreach ($findDistrict as $district_results) {
                                                echo '<optgroup label="' . $district_results["district_name"] . '"></optgroup>';
                                                $district_id = $district_results["district_id"];
                                                $find_routes = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE d_id = '$district_id' ORDER BY route_name ASC");
                                                foreach ($find_routes as $route_results) {
                                                    echo '<option value="' . $route_results["route_id"] . '">' . $route_results["route_name"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="inputs col-lg-12">
                                        <label class="form-label" for="Employee_address">Address</label>
                                        <textarea name="EmpAddr" id="Employee_address" class="form-control" cols="30" rows="3" required></textarea>
                                    </div>

                                </div>


                                <div class="text-center submit_btn">
                                    <button class="btn btn_submit" type="submit">Save </button>
                                </div>
                            </form>
                            <form action="" id="UpdateEmployeeForm" style="display: none;" novalidate>
                                <div class="row">

                                    <div class="inputs col-12">
                                        <input type="text" id="Edit_employee_id" name="UpdateEmployeeId" hidden>
                                        <label class="form-label" for="Update_Employee_name">Employee Name</label>
                                        <input type="text" class="form-control" id="Update_Employee_name" name="UpdtEmpName" data-v-max-length="20" data-v-message="Maximum 20 characters" placeholder="" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Update_Employee_tag">Tag ID</label>
                                        <input type="text" name="UpdtEmpTag" class="form-control" id="Update_Employee_tag" required>
                                    </div>

                                    <div class="inputs col-lg-6">
                                        <label class="form-label" for="Update_Employee_phone">Phone Number</label>
                                        <input type="number" name="UpdtEmpPhone" class="form-control" id="Update_Employee_phone" required>
                                    </div>

                                    <div class="inputs col-lg-3">
                                        <label class="form-label" for="Update_Employee_monday">Monday</label>
                                        <select name="UpdtEmpMon" class="form-select" id="Update_Employee_monday" required>
                                            <option value="0">NO ROUTE</option>
                                            <?php
                                            $findDistrict = mysqli_query($con, "SELECT district_id,district_name FROM district_master WHERE district_id <> 0 ORDER BY district_name ASC");
                                            foreach ($findDistrict as $district_results) {
                                                echo '<optgroup label="' . $district_results["district_name"] . '"></optgroup>';
                                                $district_id = $district_results["district_id"];
                                                $find_routes = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE d_id = '$district_id' ORDER BY route_name ASC");
                                                foreach ($find_routes as $route_results) {
                                                    echo '<option value="' . $route_results["route_id"] . '">' . $route_results["route_name"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="inputs col-lg-3">
                                        <label class="form-label" for="Update_Employee_tuesday">Tuesday</label>
                                        <select name="UpdtEmpTue" class="form-select" id="Update_Employee_tuesday" required>
                                            <option value="0">NO ROUTE</option>
                                            <?php
                                            $findDistrict = mysqli_query($con, "SELECT district_id,district_name FROM district_master WHERE district_id <> 0 ORDER BY district_name ASC");
                                            foreach ($findDistrict as $district_results) {
                                                echo '<optgroup label="' . $district_results["district_name"] . '"></optgroup>';
                                                $district_id = $district_results["district_id"];
                                                $find_routes = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE d_id = '$district_id' ORDER BY route_name ASC");
                                                foreach ($find_routes as $route_results) {
                                                    echo '<option value="' . $route_results["route_id"] . '">' . $route_results["route_name"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>


                                    <div class="inputs col-lg-3">
                                        <label class="form-label" for="Update_Employee_wednesday">Wednesday</label>
                                        <select name="UpdtEmpWed" class="form-select" id="Update_Employee_wednesday" required>
                                            <option value="0">NO ROUTE</option>
                                            <?php
                                            $findDistrict = mysqli_query($con, "SELECT district_id,district_name FROM district_master WHERE district_id <> 0 ORDER BY district_name ASC");
                                            foreach ($findDistrict as $district_results) {
                                                echo '<optgroup label="' . $district_results["district_name"] . '"></optgroup>';
                                                $district_id = $district_results["district_id"];
                                                $find_routes = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE d_id = '$district_id' ORDER BY route_name ASC");
                                                foreach ($find_routes as $route_results) {
                                                    echo '<option value="' . $route_results["route_id"] . '">' . $route_results["route_name"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="inputs col-lg-3">
                                        <label class="form-label" for="Update_Employee_thursday">Thursday</label>
                                        <select name="UpdtEmpThu" class="form-select" id="Update_Employee_thursday" required>
                                            <option value="0">NO ROUTE</option>
                                            <?php
                                            $findDistrict = mysqli_query($con, "SELECT district_id,district_name FROM district_master WHERE district_id <> 0 ORDER BY district_name ASC");
                                            foreach ($findDistrict as $district_results) {
                                                echo '<optgroup label="' . $district_results["district_name"] . '"></optgroup>';
                                                $district_id = $district_results["district_id"];
                                                $find_routes = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE d_id = '$district_id' ORDER BY route_name ASC");
                                                foreach ($find_routes as $route_results) {
                                                    echo '<option value="' . $route_results["route_id"] . '">' . $route_results["route_name"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="inputs col-lg-3">
                                        <label class="form-label" for="Update_Employee_friday">Friday</label>
                                        <select name="UpdtEmpFri" class="form-select" id="Update_Employee_friday" required>
                                            <option value="0">NO ROUTE</option>
                                            <?php
                                            $findDistrict = mysqli_query($con, "SELECT district_id,district_name FROM district_master WHERE district_id <> 0 ORDER BY district_name ASC");
                                            foreach ($findDistrict as $district_results) {
                                                echo '<optgroup label="' . $district_results["district_name"] . '"></optgroup>';
                                                $district_id = $district_results["district_id"];
                                                $find_routes = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE d_id = '$district_id' ORDER BY route_name ASC");
                                                foreach ($find_routes as $route_results) {
                                                    echo '<option value="' . $route_results["route_id"] . '">' . $route_results["route_name"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="inputs col-lg-3">
                                        <label class="form-label" for="Update_Employee_saturday">Saturday</label>
                                        <select name="UpdtEmpSat" class="form-select" id="Update_Employee_saturday" required>
                                            <option value="0">NO ROUTE</option>
                                            <?php
                                            $findDistrict = mysqli_query($con, "SELECT district_id,district_name FROM district_master WHERE district_id <> 0 ORDER BY district_name ASC");
                                            foreach ($findDistrict as $district_results) {
                                                echo '<optgroup label="' . $district_results["district_name"] . '"></optgroup>';
                                                $district_id = $district_results["district_id"];
                                                $find_routes = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE d_id = '$district_id' ORDER BY route_name ASC");
                                                foreach ($find_routes as $route_results) {
                                                    echo '<option value="' . $route_results["route_id"] . '">' . $route_results["route_name"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="inputs col-lg-3">
                                        <label class="form-label" for="Update_Employee_sunday">Sunday</label>
                                        <select name="UpdtEmpSun" class="form-select" id="Update_Employee_sunday" required>
                                            <option value="0">NO ROUTE</option>
                                            <?php
                                            $findDistrict = mysqli_query($con, "SELECT district_id,district_name FROM district_master WHERE district_id <> 0 ORDER BY district_name ASC");
                                            foreach ($findDistrict as $district_results) {
                                                echo '<optgroup label="' . $district_results["district_name"] . '"></optgroup>';
                                                $district_id = $district_results["district_id"];
                                                $find_routes = mysqli_query($con, "SELECT route_id,route_name FROM route_master WHERE d_id = '$district_id' ORDER BY route_name ASC");
                                                foreach ($find_routes as $route_results) {
                                                    echo '<option value="' . $route_results["route_id"] . '">' . $route_results["route_name"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="inputs col-lg-12">
                                        <label class="form-label" for="Update_Employee_address">Address</label>
                                        <textarea name="UpdtEmpAddr" id="Update_Employee_address" class="form-control" cols="30" rows="3" required></textarea>
                                    </div>

                                </div>


                                <div class="text-center submit_btn">
                                    <button class="btn btn_submit" type="submit">Update </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-7 p-0  px-xl-4">

                            <div class="card card-body view_table p-0">

                                <div class="card card-body bg-transparent border-0 d-none" id="loadCard">

                                    <div id="loader" class="mx-auto"></div>

                                </div>

                                <table class="table table-striped display text-nowrap text-center " id="Employee_table" style="width:100% ;">
                                    <thead class="text-center">
                                        <tr class="text-center">
                                            <th class="text-center">Sl.No</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Tag</th>
                                            <th class="text-center">Phone</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Mon</th>
                                            <th class="text-center">Tue</th>
                                            <th class="text-center">Wed</th>
                                            <th class="text-center">Thu</th>
                                            <th class="text-center">Fri</th>
                                            <th class="text-center">Sat</th>
                                            <th class="text-center">Sun</th>
                                            <th class="text-center">Edit</th>
                                            <th class="text-center">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">


                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>





    </div>



    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>




    <script>
        $(document).ready(function() {

            $('#Employee_name').focus();

            var empTable = $('#Employee_table').DataTable({
                "processing": true,
                "ajax": "EmployeeData.php",
                "scrollX": true,
                "scrollY": "400px",
                "dom": '<"top"fl>rt<"bottom"ip>',
                "columns": [{
                        "data": null,
                        "sortable": true,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'employee_name',
                    },
                    {
                        data: 'tag_id'
                    },
                    {
                        data: 'employee_phone'
                    },
                    {
                        data: 'employee_address'
                    },
                    {
                        data: 'monday'
                    },
                    {
                        data: 'tuesday'
                    },
                    {
                        data: 'wednesday'
                    },
                    {
                        data: 'thursday'
                    },
                    {
                        data: 'friday'
                    },
                    {
                        data: 'saturday'
                    },
                    {
                        data: 'sunday'
                    },

                    {
                        data: 'employee_id',
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<button class="edit_btn btn shadow-none " type="button" value="' + data + '"> <i class="material-icons">edit</i> </button>';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'employee_id',
                        "render": function(data, type, row, meta) {
                            if (type == 'display') {
                                data = '<button class="del_btn btn shadow-none" <?php if ($_SESSION['custtype']  != 'SUPERADMIN'){ echo "disabled";}else{ } ?> type="button" value="' + data + '"> <i class="material-icons">delete_outline</i> </button>';
                            }
                            return data;
                        }
                    }

                ]


            });



            /* Add Employee Start */
            $(function() {

                let validator = $('#AddEmployeeForm').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#Employee_name,#Employee_tag,#Employee_phone,#Employee_address') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#AddEmployeeForm', (function(e) {
                    e.preventDefault();
                    var EmployeeData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: EmployeeData,
                        beforeSend: function() {
                            $('#AddEmployeeForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#AddEmployeeForm').removeClass("disable");
                            var response = JSON.parse(data);
                            if (response.addEmployee == "0") {
                                toastr.warning("Employee is Already Present");
                            } else if (response.addEmployee == "1") {
                                toastr.success("Successfully Added Employee");
                                $('#AddEmployeeForm')[0].reset();
                                empTable.ajax.reload();
                                $('#Employee_name').focus();
                            } else if (response.addEmployee == "2") {
                                toastr.error("Some Error Occured");
                            } else {
                                toastr.error("Some Error Occured");
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }));

            });
            /* Add Employee End */



            /* Update Employee Start */
            $(function() {

                let validator = $('#UpdateEmployeeForm').jbvalidator({
                    //language: 'dist/lang/en.json',
                    successClass: false,
                    html5BrowserDefault: true
                });

                validator.validator.custom = function(el, event) {
                    if ($(el).is('#Update_Employee_name,#Update_Employee_tag,#Update_Employee_phone,#Update_Employee_address') && $(el).val().trim().length == 0) {
                        return 'Cannot be empty';
                    }
                }

                $(document).on('submit', '#UpdateEmployeeForm', (function(e) {
                    e.preventDefault();
                    var UpdateEmplData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: UpdateEmplData,
                        beforeSend: function() {
                            $('#UpdateCustomerForm').addClass("disable");
                        },
                        success: function(data) {
                            console.log(data);
                            $('#UpdateEmployeeForm').removeClass("disable");
                            var UpdateEmplData = JSON.parse(data);
                            if (UpdateEmplData.EmployeeUpdate == "0") {
                                toastr.warning("Customer is Already Present");
                            } else if (UpdateEmplData.EmployeeUpdate == "1") {
                                toastr.success("Successfully Updated Customer");
                                $('#UpdateEmployeeForm')[0].reset();
                                $('#UpdateEmployeeForm').hide();
                                $('#AddEmployeeForm').show();
                                empTable.ajax.reload();
                                $('#Employee_name').focus();
                            } else if (UpdateEmplData.EmployeeUpdate == "2") {
                                toastr.error("Some Error Occured");
                            } else {
                                toastr.error("Some Error Occured");
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }));

            });
            /* Update Employee End */



            //edit Employee
            $('#Employee_table tbody').on('click', '.edit_btn', function() {

                var editEmpId = $(this).val();
                $('#AddEmployeeForm')[0].reset();
                console.log(editEmpId);
                $.ajax({
                    type: "POST",
                    url: "MasterOperations.php",
                    data: {
                        editEmpId: editEmpId
                    },
                    beforeSend: function() {
                        $('#AddEmployeeForm').addClass("disable");

                    },
                    success: function(data) {
                        $('#AddEmployeeForm').removeClass("disable");
                        console.log(data);
                        var editResponse = JSON.parse(data);
                        if (editResponse.EditEmployee == 'error') {
                            toastr.error("Some Error Occured");
                        } else {
                            $('#Update_Employee_name').val(editResponse.EditEmplName);
                            $('#Update_Employee_tag').val(editResponse.EditEmplTag);
                            $('#Update_Employee_phone').val(editResponse.EditEmplPhone);
                            $('#Update_Employee_address').val(editResponse.EditEmplAddress);
                            $('#Update_Employee_monday').val(editResponse.EditEmplMon).change();
                            $('#Update_Employee_tuesday').val(editResponse.EditEmplTue).change();
                            $('#Update_Employee_wednesday').val(editResponse.EditEmplWed).change();
                            $('#Update_Employee_thursday').val(editResponse.EditEmplThu).change();
                            $('#Update_Employee_friday').val(editResponse.EditEmplFri).change();
                            $('#Update_Employee_saturday').val(editResponse.EditEmplSat).change();
                            $('#Update_Employee_sunday').val(editResponse.EditEmplSun).change();
                            $('#Edit_employee_id').val(editEmpId);
                            $('#UpdateEmployeeForm').show();
                            $('#AddEmployeeForm').hide();
                        }
                    }
                });
            });



            //delete Employee
            $('#Employee_table tbody').on('click', '.del_btn', function() {
                var delEmp = $(this).val();
                console.log(delEmp);
                var ConfirmDelete = confirm("Are you sure you want to delete this Employee?");
                if (ConfirmDelete == true) {
                    $.ajax({
                        type: "POST",
                        url: "MasterOperations.php",
                        data: {
                            delEmp: delEmp
                        },
                        beforeSend: function() {
                            $('#AddEmployeeForm').addClass("disable");
                        },
                        success: function(data) {
                            $('#AddEmployeeForm').removeClass("disable");
                            console.log(data);
                            var deleteResponse = JSON.parse(data);
                            if (deleteResponse.DeleteEmp == 0) {
                                toastr.warning("Employee is already in the orders");
                            } else if (deleteResponse.DeleteEmp == 1) {
                                toastr.success("Successfully Deleted");
                                empTable.ajax.reload();
                            } else {
                                toastr.error("Some Error Occured");
                            }
                        }
                    });
                } else {
                    toastr.info("Cancelled!");
                }
            });

        });


        toastr.options = {
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>


</body>

</html>