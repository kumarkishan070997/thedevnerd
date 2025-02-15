<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
      
    </head>
    <body>
        <div class="container">
            <form action="{{url('/send')}}" method="post" class="form-group mt-5">
                @csrf
                <input class="form-control" type="text" placeholder="Input here…" name="query">
                <button type="submit" class="btn btn-primary my-2">Confirm</button>
            </form>
        </div>
    </body>
</html>