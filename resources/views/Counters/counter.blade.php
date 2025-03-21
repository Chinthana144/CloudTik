<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CloudTik Counter</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <style>
        #div_main {
            width: 50%;
            margin-left: 25%;
            padding-top: 12vh;
        }

        @media screen and (max-width: 800px) {
            #div_main {
                width: 90%;
                margin-left: 5%;
                padding-top: 12vh;
            }
        }
    </style>
</head>

<body>
    <div id="div_main">
        <div class="card">
            <div class="card-header">
                <h4 class="text-center">Start Counter</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('counter.store') }}" method="post">
                    @csrf
                    <label for="" class="form-label m-2">Counter start amount (AED)</label>
                    <input type="number" step="0.01" name="counterStartAmount" class="form-control" value="0">

                    <div class="row mt-3">
                        <div class="col-6">
                            <a href="/home" class="btn btn-success w-100">Home</a>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary w-100 float-end">Start Counter</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>
