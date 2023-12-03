<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delivery</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        #main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
            background: url('./LOGIN-01.png');
            background-repeat: no-repeat;
            background-size: cover;
        }
        
        #main .login_div .card {
            padding: 70px 50px;
            border-radius: 40px;
            border: none;
        }
        
        #main .login_div .card .heading {
            font-size: 30px;
            font-weight: 700;
            padding-bottom: 20px;
        }
        
        #main .login_div .card .abovetext {
            font-weight: 500;
            text-align: center;
            padding-bottom: 20px;
            color: rgb(61, 61, 61);
        }
        
        #main .login_div .card input {
            height: 45px;
            margin: 20px 0px;
            font-weight: 500;
        }
        
        #main .login_div .card .undertext {
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 30px;
        }
        
        #main .login_div .card button {
            height: 45px;
            margin: 20px 0px;
            background-color: #ccff66;
            font-weight: 700;
        }
        
        @media only screen and (min-width:1068px) {
            #main .login_div .card {
                padding: 70px 50px;
                border-radius: 40px;
                border: none;
                width: 450px;
            }
        }

        @media only screen and (max-width : 370px) {
            #main .login_div .card {
                padding: 40px 20px;
                border-radius: 40px;
                border: none;
                margin: 5px 10px;
            }
        }
    </style>
</head>

<body>








    <main id="main">

        <div class="login_div">
            <div class="card card-body shadow-lg">
                <h3 class="text-center heading">Agent Login</h3>
                <p class="abovetext">Hey,Enter your details to get sign in <br> to your account</p>
               

                <form action="" id="loginform" class="px-3">
                    
                    <input type="text" name="userName" class="form-control" placeholder="Enter Phone No" required>
                    <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                    
                    <div id="message">

                    </div>
                    <button id="login" class="btn mt-4 btn_signin" type="submit" style="width:100%">Sign in</button>

                </form>


              
            </div>
            <div class="text-center mt-2">
                <h6 class="">Copyright @Zevans Kart | Privacy Policy</h6>
            </div>
        </div>




    </main>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function(){
            $('#loginform').submit(function(e){
                e.preventDefault();
                var form = $(this).serializeArray();
                console.log(form);
                $.post(
                    "login_verify.php",
                    form,
                    function(form){
                        $('#message').show();
                        $('#message').html(form);
                        //console.log("hello");
                        var response = JSON.parse(form);
                        if(response.success == "1"){
                            $('#message').hide();
                            //alert("admin");
                            location.href = "./Admin/DistrictMaster.php";
                        }
                        else if(response.success == "2"){
                            $('#message').hide();
                            //alert("customer");
                            location.href = "./Admin/DistrictMaster.php"; 
                        }
                        else if(response.success == "3"){
                            $('#message').hide();
                            //alert("customer");
                            location.href = "./Admin/DeliveryScreen.php"; 
                        }
                        
                        else{

                        }
                      
                    }
                );
            });
        });
    </script>

</body>

</html>