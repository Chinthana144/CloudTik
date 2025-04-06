<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CloudTik Counter</title>

    <script>
        window.onload = function() {
            window.print();

            setTimeout(() => {
                window.close();
                window.location.href = "/home";
            }, 500);
        }
    </script>
</head>

<body>
    <h3>Counter Report</h3>

    @foreach ($totals as $total)
        <p>{{ $total->package->name }}</p>
        <p>{{ $total->total_price }}</p>
    @endforeach
</body>

</html>
