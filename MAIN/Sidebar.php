<div class="offcanvas offcanvas-start" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">

            <div class="offcanvas-body">
                <div class="text-start" id="Menu_heading">
                    <h4>DELIVERY</h4>
                </div>

                <div id="Menu_options">
                    <ul class="list-unstyled">
                        <li class=" <?php if($_SESSION['custtype'] == 'SUPERADMIN'){} else{ echo "d-none" ;} ?> ">
                            <a href="./Dashboard.php" class=" <?php echo ($pageTitle == 'Dashboard')? 'active' : "" ; ?>" >
                                <i class="bi bi-grid-1x2-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class=" <?php if($_SESSION['custtype'] == 'SUPERADMIN' || $_SESSION['custtype'] == 'ADMIN'){} else{ echo "d-none" ;} ?> ">
                            <a href="./DistrictMaster.php" class=" <?php echo ($pageTitle == 'District')? 'active' : "" ; ?> ">
                                <i class="bi bi-map-fill"></i>
                                <span>District Master</span>
                            </a>
                        </li>
                        <li class=" <?php if($_SESSION['custtype'] == 'SUPERADMIN' || $_SESSION['custtype'] == 'ADMIN'){} else{ echo "d-none" ;} ?> ">
                            <a href="./RouteMaster.php" class=" <?php echo ($pageTitle == 'Route')? 'active' : "" ; ?>  ">
                                <i class="bi bi-geo-alt-fill"></i>
                                <span>Route Master</span>
                            </a>
                        </li>
                        <li class=" <?php if($_SESSION['custtype'] == 'SUPERADMIN' || $_SESSION['custtype'] == 'ADMIN'){} else{ echo "d-none" ;} ?> ">
                            <a href="./ItemMaster.php" class=" <?php echo ($pageTitle == 'Product')? 'active' : "" ; ?>  ">
                                <i class="bi bi-box-seam-fill"></i>
                                <span>Product Master</span>
                            </a>
                        </li>
                        <li class=" <?php if($_SESSION['custtype'] == 'SUPERADMIN' || $_SESSION['custtype'] == 'ADMIN'){} else{ echo "d-none" ;} ?> ">
                            <a href="./CustomerMaster.php" class=" <?php echo ($pageTitle == 'Customer')? 'active' : "" ; ?>  ">
                                <i class="bi bi-people-fill"></i>
                                <span>Customer Master</span>
                            </a>
                        </li>
                        <li class=" <?php if($_SESSION['custtype'] == 'SUPERADMIN' || $_SESSION['custtype'] == 'ADMIN'){} else{ echo "d-none" ;} ?> ">
                            <a href="./EmployeeMaster.php" class=" <?php echo ($pageTitle == 'Employee')? 'active' : "" ; ?>  ">
                                <i class="bi bi-person-badge-fill"></i>
                                <span>Employee Master</span>
                            </a>
                        </li>
                        <li class=" <?php if($_SESSION['custtype'] == 'SUPERADMIN' || $_SESSION['custtype'] == 'ADMIN'){} else{ echo "d-none" ;} ?> ">
                            <a href="./EmployeeTracking.php" class=" <?php echo ($pageTitle == 'EmployeeTracking')? 'active' : "" ; ?>  ">
                                <i class="bi bi-eye-fill"></i>
                                <span>Employee Tracking</span>
                            </a>
                        </li>
                        <li class=" <?php if($_SESSION['custtype'] == 'SUPERADMIN'){} else{ echo "d-none" ;} ?> ">
                            <a href="./UserMaster.php" class=" <?php echo ($pageTitle == 'User')? 'active' : "" ; ?>  ">
                                <i class="bi bi-person-bounding-box"></i>
                                <span>User Master</span>
                            </a>
                        </li>
                        <li class=" <?php if($_SESSION['custtype'] == 'SUPERADMIN' || $_SESSION['custtype'] == 'ADMIN'){} else{ echo "d-none" ;} ?> ">
                            <a href="./BillingScreen.php" class=" <?php echo ($pageTitle == 'Billing')? 'active' : "" ; ?>  ">
                                <i class="bi bi-cart-fill"></i>
                                <span>Billing Screen</span>
                            </a>
                        </li>

                        <li class=" <?php if($_SESSION['custtype'] == 'SUPERADMIN' || $_SESSION['custtype'] == 'ADMIN'){} else{ echo "d-none" ;} ?> ">
                            <a href="./CustomerWiseReport.php" class=" <?php echo ($pageTitle == 'CustomerWiseReport')? 'active' : "" ; ?>  ">
                                <i class="bi bi-bar-chart-fill"></i>
                                <span>Customer Wise Report</span>
                            </a>
                        </li>

                        <li class=" <?php if($_SESSION['custtype'] == 'SUPERADMIN' || $_SESSION['custtype'] == 'ADMIN'){} else{ echo "d-none" ;} ?> ">
                            <a href="./BlacklistReport.php" class=" <?php echo ($pageTitle == 'BlacklistReport')? 'active' : "" ; ?>  ">
                                <i class="bi bi-slash-circle-fill"></i>
                                <span>Blacklist Report</span>
                            </a>
                        </li>


                        <hr>

                        <li>
                            <a href="../signout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>