<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CloudTik User Login</title>


</head>

<body>
    <!-- partial:index.partial.html -->
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Design by foolishdeveloper.com -->
        <title>CloudTik User Login</title>

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/userlogin.css') }}">
        <!--Stylesheet-->
        <style media="screen">

        </style>
    </head>

    <body>
        <div class="background">
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        <div id="div_login_form">
            <form action="{{ route('wifi.login') }}" method="post">
                @csrf
                <h3>Login Here</h3>

                <label for="username">Username</label>
                <input type="text" name="customer_name" placeholder="Email or Phone" id="username">

                <label for="password">Password</label>
                <input type="password" name="customer_pwd" placeholder="Password" id="password">

                <button type="submit">Log In</button>
                <div class="social">
                    {{-- <div class="go"><i class="fab fa-google"></i> Google</div> --}}
                    {{-- <div class="fb"><i class="fab fa-facebook"></i> Facebook</div> --}}
                </div>
            </form>
        </div>

    </body>

    </html>
    <!-- partial -->

</body>

</html>
