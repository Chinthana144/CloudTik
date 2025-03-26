<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CloudTik Receipt</title>

    <script>
        window.onload = function() {
            window.print();

            setTimeout(() => {
                window.close();
                history.back();
            }, 500);
        }
    </script>

</head>

<body>
    <p>receipt page</p>
    <p>{{ $subscription->price }}</p>
</body>

</html>
