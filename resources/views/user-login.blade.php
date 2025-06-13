<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Design by foolishdeveloper.com -->
    <title>CloudTik User Login</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/userlogin.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <title>CloudTik User Login</title>
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

            <input type="hidden" name="mac" value="{{ $mac }}">

            <label for="username">Username</label>
            <input type="text" name="customer_name" placeholder="Email or Phone" id="username">

            <label for="password">Password</label>
            <input type="password" name="customer_pwd" placeholder="Password" id="password">

            <div id="div_login">
                <div>
                    <button type="button">QR Scan</button>
                </div>
                <div>
                    <button type="submit">Log In</button>
                </div>
            </div>

            <div id="div_register">
                <a href="/userregister" id="link_register">Register</a>
                <a href="/" id="link_register">Home</a>
            </div>

            <div class="social">
                {{-- <div class="go"><i class="fab fa-google"></i> Google</div> --}}
                {{-- <div class="fb"><i class="fab fa-facebook"></i> Facebook</div> --}}
            </div>
        </form>
    </div>

</body>

</html>
