function getcartData() {
    var cart = 'fetch_data';
    $.ajax({
        method: "POST",
        url: "CartData.php",
        data: { cart: cart },
        success: function(data) {
            //console.log(data);
            $('#DisplayItems').html(data);
        }
    });
}