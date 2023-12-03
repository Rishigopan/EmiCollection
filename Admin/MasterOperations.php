
<?php

include '../MAIN/Dbconfig.php';
include '../Admin/CommonFunctions.php';

$user = $_SESSION['custid'];;
$timeNow = date("d-m-y h:i:s");

//////////////////////////////////District Operations//////////////////////////////////////////

    //Add District
    if (isset($_POST['DistrictName'])) {
        mysqli_autocommit($con, FALSE);
        $DistrictName = SanitizeAndUpper($_POST['DistrictName']);

        $check_add_district_query = mysqli_query($con, "SELECT * FROM district_master WHERE district_name = '$DistrictName'");
        if (mysqli_num_rows($check_add_district_query) > 0) {
            echo json_encode(array('addDistrict' => '0'));
        } else {

            $add_district_max_query = mysqli_query($con, "SELECT MAX(district_id) FROM district_master");
            foreach ($add_district_max_query as $add_district_max_result) {
                $add_district_max = $add_district_max_result['MAX(district_id)'] + 1;
            }

            $add_district_query =  mysqli_query($con, "INSERT INTO district_master (district_id,district_name,createdBy,createdDate) 
                    VALUES ('$add_district_max','$DistrictName','$user','$timeNow')");

            if ($add_district_query) {
                mysqli_commit($con);
                echo json_encode(array('addDistrict' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addDistrict' => '2'));
            }
        }
    }


    //Delete District
    if (isset($_POST['DelDistrictId'])) {

        $DeleteDistrictId = SanitizeInt($_POST['DelDistrictId']);

        mysqli_autocommit($con, FALSE);
        $check_district_delete_query = mysqli_query($con, "SELECT * FROM route_master WHERE d_id = '$DeleteDistrictId'");
        if (mysqli_num_rows($check_district_delete_query) > 0) {
            echo json_encode(array('DistrictDelete' => '0'));
        } else {
            $delete_district_query =  mysqli_query($con, "DELETE FROM district_master WHERE district_id = '$DeleteDistrictId'");

            if ($delete_district_query) {
                mysqli_commit($con);
                echo json_encode(array('DistrictDelete' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('DistrictDelete' => '2'));
            }
        }
    }


    //Edit District
    if (isset($_POST['EditDistrictId'])) {
        $DistrictEditId = SanitizeInt($_POST['EditDistrictId']);

        $edit_district_query = mysqli_query($con, "SELECT district_name FROM district_master WHERE district_id = '$DistrictEditId'");
        if ($edit_district_query) {
            foreach ($edit_district_query as $edit_district_result) {
                $DistrictFetchName = $edit_district_result['district_name'];
                echo json_encode(array('EditDistrict' => $DistrictFetchName));
            }
        } else {
            echo json_encode(array('EditDistrict' => 'error'));
        }
    }


    //Update District
    if (isset($_POST['updateDistrictId'])) {

        $UpdateDistrictName = SanitizeAndUpper($_POST['UpdateDistrictName']);
        $UpdateDistrictId = SanitizeInt($_POST['updateDistrictId']);

        mysqli_autocommit($con, FALSE);
        $check_district_update_query = mysqli_query($con, "SELECT * FROM district_master WHERE district_name = '$UpdateDistrictName'  AND  district_id <> '$UpdateDistrictId'");
        if (mysqli_num_rows($check_district_update_query) > 0) {
            echo json_encode(array('DistrictUpdate' => '0'));
        } else {

            $update_district_query =  mysqli_query($con, "UPDATE district_master SET district_name = '$UpdateDistrictName', updatedBy = '$user', updatedDate = '$timeNow' WHERE district_id = '$UpdateDistrictId'");

            if ($update_district_query) {
                mysqli_commit($con);
                echo json_encode(array('DistrictUpdate' => '1'));
            } else {

                mysqli_rollback($con);
                echo json_encode(array('DistrictUpdate' => '2'));
            }
        }
    }


//////////////////////////////////District Operations//////////////////////////////////////////




//////////////////////////////////Route Operations//////////////////////////////////////////

    //Add Route
    if (isset($_POST['DistrictSelect'])) {

        $RouteDistrictId = SanitizeInt($_POST['DistrictSelect']);
        $RouteName = SanitizeAndUpper($_POST['RouteName']);


        mysqli_autocommit($con, FALSE);
        $check_add_route_query = mysqli_query($con, "SELECT * FROM route_master WHERE route_name = '$RouteName'");
        if (mysqli_num_rows($check_add_route_query) > 0) {
            echo json_encode(array('addRoute' => '0'));
        } else {

            $add_route_max_query = mysqli_query($con, "SELECT MAX(route_id) FROM route_master");
            foreach ($add_route_max_query as $add_route_max_result) {
                $add_route_max = $add_route_max_result['MAX(route_id)'] + 1;
            }

            $add_route_query =  mysqli_query($con, "INSERT INTO route_master (route_id,d_id,route_name,createdBy,createdDate) 
                    VALUES ('$add_route_max','$RouteDistrictId','$RouteName','$user','$timeNow')");

            if ($add_route_query) {
                mysqli_commit($con);
                echo json_encode(array('addRoute' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addRoute' => '2'));
            }
        }
    }


    //Edit Route
    if (isset($_POST['editRouteId'])) {
        $RouteEditId = SanitizeInt($_POST['editRouteId']);

        $edit_route_query = mysqli_query($con, "SELECT route_name,d_id FROM route_master WHERE route_id = '$RouteEditId'");
        if ($edit_route_query) {
            foreach ($edit_route_query as $edit_route_result) {
                $RouteFetchName = $edit_route_result['route_name'];
                $RouteFetchDid = $edit_route_result['d_id'];
                echo json_encode(array('EditRouteName' => $RouteFetchName, 'EditRouteDid' => $RouteFetchDid));
            }
        } else {
            echo json_encode(array('EditRoute' => 'error'));
        }
    }


    //Delete Route
    if (isset($_POST['delRoute'])) {

        $DelRouteId = SanitizeInt($_POST['delRoute']);

        mysqli_autocommit($con, FALSE);
        $check_route_delete_query = mysqli_query($con, "SELECT * FROM employee_master WHERE emp_mon = '$DelRouteId' OR emp_tue = '$DelRouteId' OR emp_wed = '$DelRouteId' OR emp_thu = '$DelRouteId' OR emp_fri = '$DelRouteId' OR emp_sat = '$DelRouteId' OR emp_sun = '$DelRouteId'");
        if (mysqli_num_rows($check_route_delete_query) > 0) {
            echo json_encode(array('DeleteRoute' => '0'));
        } else {
            $delete_route_query =  mysqli_query($con, "DELETE FROM route_master WHERE route_id = '$DelRouteId'");

            if ($delete_route_query) {
                mysqli_commit($con);
                echo json_encode(array('DeleteRoute' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('DeleteRoute' => '2'));
            }
        }
    }



    //Update Route
    if (isset($_POST['UpdateRouteId'])) {

        $UpdateRouteDid = SanitizeInt($_POST['UpdateDistrictSelect']);
        $UpdateRouteId = SanitizeInt($_POST['UpdateRouteId']);
        $UpdateRouteName = SanitizeAndUpper($_POST['UpdateRouteName']);

        mysqli_autocommit($con, FALSE);
        $check_route_update_query = mysqli_query($con, "SELECT * FROM route_master WHERE route_name = '$UpdateRouteName'  AND  d_id = '$UpdateRouteDid' AND route_id <> '$UpdateRouteId'");
        if (mysqli_num_rows($check_route_update_query) > 0) {
            echo json_encode(array('RouteUpdate' => '0'));
        } else {

            $update_route_query =  mysqli_query($con, "UPDATE route_master SET route_name = '$UpdateRouteName', d_id = '$UpdateRouteDid' , updatedBy = '$user', updatedDate = '$timeNow' WHERE route_id = '$UpdateRouteId'");

            if ($update_route_query) {
                mysqli_commit($con);
                echo json_encode(array('RouteUpdate' => '1'));
            } else {

                mysqli_rollback($con);
                echo json_encode(array('RouteUpdate' => '2'));
            }
        }
    }


//////////////////////////////////Route Operations//////////////////////////////////////////




//////////////////////////////////Item Operations//////////////////////////////////////////

    //Add Item
    if (isset($_POST['ProductName'])) {

        $ProductName = SanitizeAndUpper($_POST['ProductName']);
        $ProductCode = SanitizeAndUpper($_POST['ProductCode']);
        $ProductPrice = SanitizeFloat($_POST['ProductPrice']);
        $ProductDiscount = SanitizeFloat($_POST['ProductDiscount']);
        $ProductEMI = SanitizeFloat($_POST['ProductEMI']);


        mysqli_autocommit($con, FALSE);
        $check_add_product_query = mysqli_query($con, "SELECT * FROM item_master WHERE item_name = '$ProductName'");
        if (mysqli_num_rows($check_add_product_query) > 0) {
            echo json_encode(array('addItem' => '0'));
        } else {

            $add_product_max_query = mysqli_query($con, "SELECT MAX(item_id) FROM item_master");
            foreach ($add_product_max_query as $add_product_max_result) {
                $add_product_max = $add_product_max_result['MAX(item_id)'] + 1;
            }

            $add_product_query =  mysqli_query($con, "INSERT INTO item_master (item_id,item_name,item_code,item_price,discount_price,itemEmi,createdBy,createdDate) 
                    VALUES ('$add_product_max','$ProductName','$ProductCode','$ProductPrice','$ProductDiscount','$ProductEMI','$user','$timeNow')");

            if ($add_product_query) {
                mysqli_commit($con);
                echo json_encode(array('addItem' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addItem' => '2'));
            }
        }
    }


    //Edit Item
    if (isset($_POST['editItemId'])) {
        $ItemEditId = SanitizeInt($_POST['editItemId']);

        $edit_item_query = mysqli_query($con, "SELECT item_name,item_code,item_price,discount_price,itemEmi FROM item_master WHERE item_id = '$ItemEditId'");
        if ($edit_item_query) {
            foreach ($edit_item_query as $edit_item_result) {
                $ItemFetchName = $edit_item_result['item_name'];
                $ItemFetchCode = $edit_item_result['item_code'];
                $ItemFetchPrice = $edit_item_result['item_price'];
                $ItemFetchDiscount = $edit_item_result['discount_price'];
                $ItemFetchEMI = $edit_item_result['itemEmi'];
                echo json_encode(array('EditItemName' => $ItemFetchName, 'EditItemCode' => $ItemFetchCode, 'EditItemPrice' => $ItemFetchPrice, 'EditItemDiscount' => $ItemFetchDiscount, 'EditItemEMI' => $ItemFetchEMI));
            }
        } else {
            echo json_encode(array('EditItem' => 'error'));
        }
    }


    //Delete Item
    if (isset($_POST['delItem'])) {

        $DelItemId = SanitizeInt($_POST['delItem']);
        mysqli_autocommit($con, FALSE);
        $check_item_delete_query = mysqli_query($con, "SELECT * FROM customer_items ci INNER JOIN customer_master c ON ci.cust_id = c.cust_id WHERE ci.p_id = '$DelItemId'");
        if (mysqli_num_rows($check_item_delete_query) > 0) {
            foreach($check_item_delete_query as $check_item_delete_result){
                $customerArray[] =  $check_item_delete_result['cust_name'];
            }
            $customerList = implode(" , ",$customerArray);
            echo json_encode(array('DeleteItem' => '0' , 'CustomerList' => $customerList));
        } else {
            $delete_item_query =  mysqli_query($con, "DELETE FROM item_master WHERE item_id = '$DelItemId'");

            if ($delete_item_query) {
                mysqli_commit($con);
                echo json_encode(array('DeleteItem' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('DeleteItem' => '2'));
            }
        }
    }



    //Update Item
    if (isset($_POST['UpdateProductId'])) {


        $UpdateProductId = SanitizeInt($_POST['UpdateProductId']);
        $UpdateProductName = SanitizeAndUpper($_POST['UpdateProductName']);
        $UpdateProductCode = SanitizeAndUpper($_POST['UpdateProductCode']);
        $UpdateProductPrice = SanitizeFloat($_POST['UpdateProductPrice']);
        $UpdateProductDiscount = SanitizeFloat($_POST['UpdateProductDiscount']);
        $UpdateProductEMI = SanitizeFloat($_POST['UpdateProductEMI']);


        mysqli_autocommit($con, FALSE);
        $check_product_update_query = mysqli_query($con, "SELECT * FROM item_master WHERE item_name = '$UpdateProductName' AND item_id <> '$UpdateProductId'");
        if (mysqli_num_rows($check_product_update_query) > 0) {
            echo json_encode(array('ItemUpdate' => '0'));
        } else {

            $update_product_query =  mysqli_query($con, "UPDATE item_master SET item_name = '$UpdateProductName', item_code = '$UpdateProductCode', item_price = '$UpdateProductPrice', discount_price = '$UpdateProductDiscount', itemEmi = '$UpdateProductEMI', updatedBy = '$user', updatedDate = '$timeNow' WHERE item_id = '$UpdateProductId'");

            if ($update_product_query) {
                mysqli_commit($con);
                echo json_encode(array('ItemUpdate' => '1'));
            } else {

                mysqli_rollback($con);
                echo json_encode(array('ItemUpdate' => '2'));
            }
        }
    }


//////////////////////////////////Item Operations//////////////////////////////////////////





//////////////////////////////////Customer Operations//////////////////////////////////////////

    //Add Customer
    if (isset($_POST['CustName'])) {

        $CustomerName = SanitizeAndUpper($_POST['CustName']);
        $CustomerDistrict =  SanitizeInt($_POST['CustDistrict']);
        $CustomerRoute =  SanitizeInt($_POST['CustRoute']);
        $CustomerPhone =  SanitizeInt($_POST['CustPhone']);
        $CustomerLocation = SanitizeAndUpper($_POST['CustLocation']);
        $CustomerPosition = SanitizeInt($_POST['CustPosition']);


        mysqli_autocommit($con, FALSE);
        $check_add_customer_query = mysqli_query($con, "SELECT * FROM customer_master WHERE cust_phone = ' $CustomerPhone'");
        if (mysqli_num_rows($check_add_customer_query) > 0) {
            echo json_encode(array('addCustomer' => '0'));
        } else {

            $checkPositionExists = mysqli_query($con, "SELECT location_position FROM customer_master WHERE cust_route = '$CustomerRoute' AND location_position = '$CustomerPosition'");
            if(mysqli_num_rows($checkPositionExists) > 0){
                echo json_encode(array('addCustomer' => '3'));
            }
            else{
                $add_customer_max_query = mysqli_query($con, "SELECT MAX(cust_id) FROM customer_master");
                foreach ($add_customer_max_query as $add_customer_max_result) {
                    $add_customer_max = $add_customer_max_result['MAX(cust_id)'] + 1;
                }
    
                $add_customer_query =  mysqli_query($con, "INSERT INTO customer_master (cust_id,cust_name,cust_district,cust_route,cust_phone,cust_location,location_position,createdBy,createdDate) 
                        VALUES ('$add_customer_max','$CustomerName','$CustomerDistrict','$CustomerRoute','$CustomerPhone','$CustomerLocation','$CustomerPosition','$user','$timeNow')");
    
                if ($add_customer_query) {
                    mysqli_commit($con);
                    echo json_encode(array('addCustomer' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('addCustomer' => '2'));
                }
            }


            
        }
    }


    //Edit Customer
    if (isset($_POST['editCustId'])) {
        $CustEditId =  SanitizeInt($_POST['editCustId']);

        $edit_customer_query = mysqli_query($con, "SELECT cust_name,cust_phone,cust_district,cust_route,cust_location,location_position FROM customer_master WHERE cust_id = '$CustEditId'");
        if ($edit_customer_query) {
            foreach ($edit_customer_query as $edit_customer_result) {
                $CustFetchName = $edit_customer_result['cust_name'];
                $CustFetchPhone = $edit_customer_result['cust_phone'];
                $CustFetchDistrict = $edit_customer_result['cust_district'];
                $CustFetchLocation = $edit_customer_result['cust_location'];
                $CustFetchPosition = $edit_customer_result['location_position'];
                $CustFetchRoute = $edit_customer_result['cust_route'];

                echo json_encode(array('EditCustName' => $CustFetchName, 'EditCustPhone' => $CustFetchPhone, 'EditCustDistrict' => $CustFetchDistrict, 'EditCustRoute' => $CustFetchRoute, 'EditCustLocation' => $CustFetchLocation, 'EditCustPosition' => $CustFetchPosition));
            }
        } else {
            echo json_encode(array('EditCustomer' => 'error'));
        }
    }


    //Delete Customer
    if (isset($_POST['delCust'])) {

        $DelCustId =  SanitizeInt($_POST['delCust']);

        mysqli_autocommit($con, FALSE);
        $check_cust_delete_query = mysqli_query($con, "SELECT ci_id FROM customer_items WHERE cust_id = '$DelCustId'");
        if (mysqli_num_rows($check_cust_delete_query) > 0) {
           
            foreach ($check_cust_delete_query as $check_add_customer_results) {
                $custItemId =  $check_add_customer_results['ci_id'];
                $DeleteCustTransactions = mysqli_query($con, "DELETE FROM customer_transactions WHERE ci_id = '$custItemId'");
            }

            if ($DeleteCustTransactions) {
                $DeleteCustItems = mysqli_query($con, "DELETE FROM customer_items WHERE cust_id = '$DelCustId'");
                if ($DeleteCustItems) {
                    $DeleteCustOrders = mysqli_query($con, "DELETE FROM customer_orders WHERE cust_id = '$DelCustId'");
                    if ($DeleteCustOrders) {
                        $FinalCustDelete = mysqli_query($con, "DELETE FROM customer_master WHERE cust_id = '$DelCustId'");
                        if ($FinalCustDelete) {
                            mysqli_commit($con);
                            echo json_encode(array('DeleteCust' => '1'));
                        } else {
                            mysqli_rollback($con);
                            echo json_encode(array('DeleteCust' => '2'));
                        }
                    } else {
                        mysqli_rollback($con);
                        echo json_encode(array('DeleteCust' => '2'));
                    }
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('DeleteCust' => '2'));
                }
            } else {
                mysqli_rollback($con);
                echo json_encode(array('DeleteCust' => '2'));
            }
        } else {
            $delete_customer_query =  mysqli_query($con, "DELETE FROM customer_master WHERE cust_id = '$DelCustId'");

            if ($delete_customer_query) {
                mysqli_commit($con);
                echo json_encode(array('DeleteCust' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('DeleteCust' => '2'));
            }
        }
    }



    //Update Customer
    if (isset($_POST['UpdateCustomerId'])) {


        $UpdateCustomerId =  SanitizeInt($_POST['UpdateCustomerId']);
        $UpdateCustomerName = SanitizeAndUpper($_POST['UpdateCustName']);
        $UpdateCustomerDistrict =  SanitizeInt($_POST['UpdateCustDistrict']);
        $UpdateCustomerRoute =  SanitizeInt($_POST['UpdateCustRoute']);
        $UpdateCustomerPhone =  SanitizeInt($_POST['UpdateCustPhone']);
        $UpdateCustomerLocation = SanitizeAndUpper($_POST['UpdateCustLocation']);
        $UpdateCustomerPosition =  SanitizeInt($_POST['UpdateCustPosition']);


        mysqli_autocommit($con, FALSE);
        $check_customer_update_query = mysqli_query($con, "SELECT * FROM customer_master WHERE cust_phone = '$UpdateCustomerPhone' AND cust_id <> '$UpdateCustomerId'");
        if (mysqli_num_rows($check_customer_update_query) > 0) {
            echo json_encode(array('CustomerUpdate' => '0'));
        } else {

            $checkPositionExists2 = mysqli_query($con, "SELECT location_position FROM customer_master WHERE cust_route = '$UpdateCustomerRoute' AND location_position = '$UpdateCustomerPosition'");
            if(mysqli_num_rows($checkPositionExists2) > 0){
                echo json_encode(array('CustomerUpdate' => '3'));
            }
            else{
                $update_customer_query =  mysqli_query($con, "UPDATE customer_master SET cust_name = '$UpdateCustomerName', cust_phone = '$UpdateCustomerPhone', cust_district = '$UpdateCustomerDistrict', cust_route = '$UpdateCustomerRoute', cust_location = '$UpdateCustomerLocation', location_position = '$UpdateCustomerPosition', updatedBy = '$user', updatedDate = '$timeNow' WHERE cust_id = '$UpdateCustomerId'");

                if ($update_customer_query) {
                    mysqli_commit($con);
                    echo json_encode(array('CustomerUpdate' => '1'));
                } else {
    
                    mysqli_rollback($con);
                    echo json_encode(array('CustomerUpdate' => '2'));
                }
            }

            
        }
    }


//////////////////////////////////Customer Operations//////////////////////////////////////////




//////////////////////////////////Employee Operations//////////////////////////////////////////


    //Add Employee
    if (isset($_POST['EmpName'])) {
        mysqli_autocommit($con, FALSE);
        $EmpName = SanitizeAndUpper($_POST['EmpName']);
        $EmpTag = SanitizeAndUpper($_POST['EmpTag']);
        $EmpPhone = SanitizeInt($_POST['EmpPhone']);
        $EmpMon = SanitizeInt($_POST['EmpMon']);
        $EmpTue = SanitizeInt($_POST['EmpTue']);
        $EmpWed = SanitizeInt($_POST['EmpWed']);
        $EmpThu = SanitizeInt($_POST['EmpThu']);
        $EmpFri = SanitizeInt($_POST['EmpFri']);
        $EmpSat = SanitizeInt($_POST['EmpSat']);
        $EmpSun = SanitizeInt($_POST['EmpSun']);
        $EmpAddr = SanitizeAndUpper($_POST['EmpAddr']);


        $check_add_employee_query = mysqli_query($con, "SELECT * FROM employee_master WHERE employee_phone = '$EmpPhone'");
        if (mysqli_num_rows($check_add_employee_query) > 0) {
            echo json_encode(array('addEmployee' => '0'));
        } else {

            $add_employee_max_query = mysqli_query($con, "SELECT MAX(employee_id) FROM employee_master");
            foreach ($add_employee_max_query as $add_employee_max_result) {
                $add_employee_max = $add_employee_max_result['MAX(employee_id)'] + 1;
            }

            $add_employee_query =  mysqli_query($con, "INSERT INTO employee_master (employee_id,employee_name,tag_id,employee_phone,employee_address,emp_mon,emp_tue,emp_wed,emp_thu,emp_fri,emp_sat,emp_sun,createdBy,createdDate) VALUES ('$add_employee_max','$EmpName','$EmpTag','$EmpPhone','$EmpAddr','$EmpMon','$EmpTue','$EmpWed','$EmpThu','$EmpFri','$EmpSat','$EmpSun','$user','$timeNow')");



            if ($add_employee_query) {


                $find_max_user_employee = mysqli_query($con, "SELECT MAX(user_id) FROM user_table");
                foreach ($find_max_user_employee as $max_user_employee) {
                    $MaxEmplUserId = $max_user_employee['MAX(user_id)'] + 1;
                }

                $add_Empl_user_query =  mysqli_query($con, "INSERT INTO user_table (user_id,name,phone,password,role,createdBy,createdDate) 
                        VALUES ('$MaxEmplUserId','$EmpName','$EmpPhone','Password','EMPLOYEE','$user','$timeNow')");

                if ($add_Empl_user_query) {
                    mysqli_commit($con);
                    echo json_encode(array('addEmployee' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('addEmployee' => '2'));
                }
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addEmployee' => '2'));
            }
        }
    }


    //Delete Employee
    if (isset($_POST['delEmp'])) {

        $DelEmpId = SanitizeInt($_POST['delEmp']);

        mysqli_autocommit($con, FALSE);
        $findUserId = mysqli_query($con, "SELECT u.user_id FROM employee_master e INNER JOIN user_table u ON e.employee_phone = u.phone WHERE e.employee_id = '$DelEmpId'");
        foreach ($findUserId as $findUserId_results) {
            $empl_users_id = $findUserId_results['user_id'];
        }
        $check_Employee_delete_query = mysqli_query($con, "SELECT * FROM customer_transactions WHERE createdBy = '$DelEmpId'");
        if (mysqli_num_rows($check_Employee_delete_query) > 0) {
            echo json_encode(array('DeleteEmp' => '0'));
        } else {
            $delete_Employee_query =  mysqli_query($con, "DELETE FROM employee_master WHERE employee_id = '$DelEmpId'");

            if ($delete_Employee_query) {

                $DeleteFromUser = mysqli_query($con, "DELETE FROM user_table WHERE user_id = '$empl_users_id'");

                if ($DeleteFromUser) {
                    mysqli_commit($con);
                    echo json_encode(array('DeleteEmp' => '1'));
                } else {
                    mysqli_rollback($con);
                    echo json_encode(array('DeleteEmp' => '2'));
                }
            } else {
                mysqli_rollback($con);
                echo json_encode(array('DeleteEmp' => '2'));
            }
        }
    }


    //Edit Employee
    if (isset($_POST['editEmpId'])) {
        $CustEmpId = SanitizeInt($_POST['editEmpId']);

        $edit_employee_query = mysqli_query($con, "SELECT employee_name,tag_id,employee_phone,employee_address,emp_mon,emp_tue,emp_wed,emp_thu,emp_fri,emp_sat,emp_sun FROM employee_master WHERE employee_id = '$CustEmpId'");
        if ($edit_employee_query) {
            foreach ($edit_employee_query as $edit_employee_result) {
                $EmpFetchName = $edit_employee_result['employee_name'];
                $EmpFetchPhone = $edit_employee_result['employee_phone'];
                $EmpFetchTag = $edit_employee_result['tag_id'];
                $EmpFetchAddress = $edit_employee_result['employee_address'];
                $EmpFetchMon = $edit_employee_result['emp_mon'];
                $EmpFetchTue = $edit_employee_result['emp_tue'];
                $EmpFetchWed = $edit_employee_result['emp_wed'];
                $EmpFetchThu = $edit_employee_result['emp_thu'];
                $EmpFetchFri = $edit_employee_result['emp_fri'];
                $EmpFetchSat = $edit_employee_result['emp_sat'];
                $EmpFetchSun = $edit_employee_result['emp_sun'];

                echo json_encode(array('EditEmplName' => $EmpFetchName, 'EditEmplPhone' => $EmpFetchPhone, 'EditEmplTag' => $EmpFetchTag, 'EditEmplAddress' => $EmpFetchAddress, 'EditEmplMon' => $EmpFetchMon, 'EditEmplTue' => $EmpFetchTue, 'EditEmplWed' => $EmpFetchWed, 'EditEmplThu' => $EmpFetchThu, 'EditEmplFri' => $EmpFetchFri, 'EditEmplSat' => $EmpFetchSat, 'EditEmplSun' => $EmpFetchSun));
            }
        } else {
            echo json_encode(array('EditEmployee' => 'error'));
        }
    }


    //Update Employee
    if (isset($_POST['UpdateEmployeeId'])) {


        $UpdateEmployeeId = SanitizeInt($_POST['UpdateEmployeeId']);
        $UpdateEmployeeName = SanitizeAndUpper($_POST['UpdtEmpName']);
        $UpdateEmployeeTag = SanitizeAndUpper($_POST['UpdtEmpTag']);
        $UpdateEmployeePhone = SanitizeInt($_POST['UpdtEmpPhone']);
        $UpdateEmployeeAddress = SanitizeAndUpper($_POST['UpdtEmpAddr']);
        $UpdateEmployeeMon = SanitizeInt($_POST['UpdtEmpMon']);
        $UpdateEmployeeTue = SanitizeInt($_POST['UpdtEmpTue']);
        $UpdateEmployeeWed = SanitizeInt($_POST['UpdtEmpWed']);
        $UpdateEmployeeThu = SanitizeInt($_POST['UpdtEmpThu']);
        $UpdateEmployeeFri = SanitizeInt($_POST['UpdtEmpFri']);
        $UpdateEmployeeSat = SanitizeInt($_POST['UpdtEmpSat']);
        $UpdateEmployeeSun = SanitizeInt($_POST['UpdtEmpSun']);

        mysqli_autocommit($con, FALSE);
        $check_employee_update_query = mysqli_query($con, "SELECT * FROM employee_master WHERE employee_phone = '$UpdateEmployeePhone' AND employee_id <> '$UpdateEmployeeId'");
        if (mysqli_num_rows($check_employee_update_query) > 0) {
            echo json_encode(array('EmployeeUpdate' => '0'));
        } else {

            $update_employee_query =  mysqli_query($con, "UPDATE employee_master SET employee_name = '$UpdateEmployeeName', employee_phone = '$UpdateEmployeePhone', employee_address = '$UpdateEmployeeAddress', tag_id = '$UpdateEmployeeTag', emp_mon = '$UpdateEmployeeMon', emp_tue = '$UpdateEmployeeTue', emp_wed = '$UpdateEmployeeWed', emp_thu = '$UpdateEmployeeThu', emp_fri = '$UpdateEmployeeFri', emp_sat = '$UpdateEmployeeSat', emp_sun = '$UpdateEmployeeSun',
                    updatedBy = '$user', updatedDate = '$timeNow' WHERE employee_id = '$UpdateEmployeeId'");

            if ($update_employee_query) {
                mysqli_commit($con);
                echo json_encode(array('EmployeeUpdate' => '1'));
            } else {

                mysqli_rollback($con);
                echo json_encode(array('EmployeeUpdate' => '2'));
            }
        }
    }


//////////////////////////////////Employee Operations//////////////////////////////////////////





//////////////////////////////////User Operations//////////////////////////////////////////

    //Add user
    if (isset($_POST['fullName'])) {

        mysqli_autocommit($con, FALSE);
        $userfullName = SanitizeAndUpper($_POST['fullName']);
        $userName =  SanitizeInt($_POST['userName']);
        $userPass =  $_POST['userPass'];
        $userRole =  SanitizeAndUpper($_POST['userRole']);



        $check_query = mysqli_query($con, "SELECT * FROM user_table WHERE phone = '$userName'");
        if (mysqli_num_rows($check_query) > 0) {
            echo json_encode(array('addUser' => '0'));
        } else {

            $find_max = mysqli_query($con, "SELECT MAX(user_id) FROM user_table");
            foreach ($find_max as $max_id) {
                $userId = $max_id['MAX(user_id)'] + 1;
            }

            $add_query =  mysqli_query($con, "INSERT INTO user_table (user_id,name,phone,password,role,createdBy,createdDate) 
                    VALUES ('$userId','$userfullName','$userName','$userPass','$userRole','$user','$timeNow')");

            if ($add_query) {
                mysqli_commit($con);
                echo json_encode(array('addUser' => '1'));
            } else {
                mysqli_rollback($con);
                echo json_encode(array('addUser' => '2'));
            }
        }
    }


    //Edit User
    if (isset($_POST['edit_user_id'])) {
        $edit_user_id = SanitizeInt($_POST['edit_user_id']);

        $edit_user = mysqli_query($con, "SELECT * FROM user_table WHERE user_id = '$edit_user_id'");
        if ($edit_user) {
            foreach ($edit_user as $edit_users) {
                $usereditId = $edit_users['user_id'];
                $usereditfullName = $edit_users['name'];
                $usereditName = $edit_users['phone'];
                $usereditPass = $edit_users['password'];
                $usereditRole = $edit_users['role'];
                echo json_encode(array('uservalue' => 0, 'userId' => $usereditId, 'userFullname' => $usereditfullName, 'userName' => $usereditName, 'userPass' => $usereditPass, 'userRole' => $usereditRole));
            }
        } else {
            echo json_encode(array('uservalue' => 'error'));
        }
    }


    //Update user
    if (isset($_POST['updateuserId'])) {
        $updateuserId = SanitizeInt($_POST['updateuserId']);
        $updateUserName = SanitizeInt($_POST['updateUserName']);
        $UpdatefullName = SanitizeAndUpper($_POST['updateFullName']);
        $updateUserPass = $_POST['updateUserPass'];
        $updateUserRole = SanitizeAndUpper($_POST['UpdateUserRole']);

        $check_user_query = mysqli_query($con, "SELECT * FROM user_table WHERE phone = '$updateUserName'  AND user_id <> '$updateuserId'");
        if (mysqli_num_rows($check_user_query) > 0) {
            echo json_encode(array('updateUser' => '0'));
        } else {

            $update_query =  mysqli_query($con, "UPDATE user_table SET phone = '$updateUserName', password = '$updateUserPass', name = '$UpdatefullName', role = '$updateUserRole'  WHERE user_id = '$updateuserId'");

            if ($update_query) {
                echo json_encode(array('updateUser' => '1'));
            } else {
                echo json_encode(array('updateUser' => '2'));
            }
        }
    }

//////////////////////////////////User Operations//////////////////////////////////////////
