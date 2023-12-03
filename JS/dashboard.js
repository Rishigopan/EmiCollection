//Show data day wise
function SingleDayData(SingleDate) {
    var action = SingleDate;
    $.ajax({
        method: "POST",
        url: "DashboardData.php",
        data: { action: action },
        beforeSend: function() {

        },
        success: function(data) {
            //console.log(data);
            $('#ViewSingleDayData').html(data);
        }
    });
}


//Show data date range wise
function RangeData(Start, End) {
    var first = Start;
    var last = End
    $.ajax({
        method: "POST",
        url: "DashboardData.php",
        data: { first: first, last: last },
        beforeSend: function() {

        },
        success: function(data) {
            //console.log(data);
            $('#ViewCustomDayData').html(data);
        }
    });
}








































/* //total orders
function totalOrders() {
    var action = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "dashboardData.php",
        data: { action: action },
        beforeSend: function() {

        },
        success: function(data) {
            console.log(data);
            $('#totalOrders').html(data);
        }
    });
}


//total quantity
function totalQuantity() {
    var totalQty = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "dashboardData.php",
        data: { totalQty: totalQty },
        beforeSend: function() {

        },
        success: function(data) {
            console.log(data);
            $('#totalQty').html(data);
        }
    });

}


//total weight
function totalWeight() {
    var totalWgt = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "dashboardData.php",
        data: { totalWgt: totalWgt },
        beforeSend: function() {

        },
        success: function(data) {
            console.log(data);
            $('#totalWgt').html(data);
        }
    });

}



//category wise
function categoryWise() {
    var CatWise = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "dashboardData.php",
        data: { CatWise: CatWise },
        beforeSend: function() {

        },
        success: function(data) {
            console.log(data);
            $('#tableCategoryWise').html(data);
        }
    });

}




//staff wise
function staffWise() {
    var StaffWise = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "dashboardData.php",
        data: { StaffWise: StaffWise },
        beforeSend: function() {

        },
        success: function(data) {
            console.log(data);
            $('#tableBillerWise').html(data);
        }
    });

} */