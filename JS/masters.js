//data show in district master
function GetDistrictData() {
    var district = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "DistrictData.php",
        data: { district: district },
        beforeSend: function() {
            $('#DisplayDistrict').addClass("d-none");
            $('#loadCard').removeClass("d-none");
        },
        success: function(data) {
            //console.log(data);
            $('#DisplayDistrict').removeClass("d-none");
            $('#loadCard').addClass("d-none");
            $('#DisplayDistrict').html(data);
        }
    });
}




//data show in add customer
function GetCustDistrict() {
    var custDistrict = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "MasterExtras.php",
        data: { custDistrict: custDistrict },
        beforeSend: function() {
            //$('#DisplayDistrict').addClass("d-none");
            //$('#loadCard').removeClass("d-none");
        },
        success: function(data) {
            //console.log(data);
            //$('#DisplayDistrict').removeClass("d-none");
            //$('#loadCard').addClass("d-none");
            $('.ShowDistrictAll').html(data);
        }
    });
}


//Show Route by district
function GetCustRoute(dist) {
    var custRoute = dist;
    $.ajax({
        method: "POST",
        url: "MasterExtras.php",
        data: { custRoute: custRoute },
        beforeSend: function() {
            //$('#DisplayDistrict').addClass("d-none");
            //$('#loadCard').removeClass("d-none");
        },
        success: function(data) {
            //console.log(data);
            //$('#DisplayDistrict').removeClass("d-none");
            //$('#loadCard').addClass("d-none");
            $('.ShowRouteByDistrict').html(data);
        }
    });
}



//data show all routes
function GetCustUpdateRoute() {
    var custAllRoute = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "MasterExtras.php",
        data: { custAllRoute: custAllRoute },
        beforeSend: function() {
            //$('#DisplayDistrict').addClass("d-none");
            //$('#loadCard').removeClass("d-none");
        },
        success: function(data) {
            //console.log(data);
            //$('#DisplayDistrict').removeClass("d-none");
            //$('#loadCard').addClass("d-none");
            $('#Update_Cust_route').html(data);
        }
    });
}





//data show customer via route
function GetCustomerByRoute(route) {
    var FindCustomer = route;
    $.ajax({
        method: "POST",
        url: "MasterExtras.php",
        data: { FindCustomer: FindCustomer },
        beforeSend: function() {
            //$('#DisplayDistrict').addClass("d-none");
            //$('#loadCard').removeClass("d-none");
        },
        success: function(data) {
            //console.log(data);
            //$('#DisplayDistrict').removeClass("d-none");
            //$('#loadCard').addClass("d-none");
            $('#Customer_id').html(data);
        }
    });
}


//get users data
function getUserData() {
    var user = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "UserData.php",
        data: { user: user },
        beforeSend: function() {
            $('#displayUser').addClass("d-none");
            $('#loadCard').removeClass("d-none");
        },
        success: function(data) {
            //console.log(data);
            $('#displayUser').removeClass("d-none");
            $('#loadCard').addClass("d-none");
            $('#displayUser').html(data);
        }
    });
}