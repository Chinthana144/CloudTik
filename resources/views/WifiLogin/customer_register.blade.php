<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/userregister.css') }}">
</head>
<body>
    <div id="div_register_form">
        <form action="" method="post">
            @csrf
            <h3>Register Here</h3>

            <div class="form-group mb-3">
                <label for="username">Username</label>
                <input type="text" name="customer_name" placeholder="Email or Phone" id="username" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="contact_no">Phone No</label>
                <input type="text" name="contact_no" placeholder="Phone" id="contact_no" class="form-control" required>
            </div>

            <div class="form-group mb-3">
              <label for="password">Password</label>
                <input type="password" name="customer_pwd" placeholder="Password" id="password" class="form-control" required>
            </div>

            <button type="submit" id="btn_register">Register</button>

            <div id="div_login">
                <a href="/userlogin" id="link_login">Login</a>
            </div>
        </form>
    </div>
</body>
</html>
