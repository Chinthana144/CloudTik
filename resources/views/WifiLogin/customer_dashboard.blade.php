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
</head>

<body>
    <h1>hi, you have successfully logged in</h1>

    @if (isset($running_data))
        running package
        <input type="hidden" id="running_end_date" value="{{ $running_data->subscriptionEndTime }}">

        <div id="div-countdown">
            Remaining Time
            <p id="countdown" class="text-center text-primary border border-primary"></p>
        </div>
    @elseif (isset($active_data))
        active package
    @elseif(isset($pending_data))
        pending package activated
    @else
        redirect to login
    @endif

    <script>
        $(document).ready(function() {
            var get_time = $("#running_end_date").val();
            var endTime = new Date(get_time).getTime();

            var countdownTimer = setInterval(() => {
                var now = new Date().getTime(); // Get current time
                var distance = endTime - now; // Calculate the difference

                if (distance < 0) {
                    clearInterval(countdownTimer);
                    $('#countdown').html("Package expired");
                    return;
                }

                // Time calculations
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result
                $('#countdown').html(
                    days + "d " + hours + "h " + minutes + "m " + seconds + "s "
                );
            }, 1000);
        });
    </script>
</body>

</html>
