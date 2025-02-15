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
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1> QR Generation by thedevnerd </h1>
                </div>
            </div>
            <form action="{{route('qr.generate')}}" method="POST">
                @csrf
                <div class="row my-3">
                    <div class="col-md-12 text-center">
                        <input type="text" class="form-control" name="detail" required />
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-md-3 my-3">
                        <button type="submit" class="form-control btn-primary" name="action" value="generateQR">Generate QR</button>
                    </div>
                    <div class="col-md-3 my-3">
                        <button type="submit" class="form-control btn-warning" name="action" value="generateColoredQR">Generate Colored QR</button>
                    </div>
                    <div class="col-md-3 my-3">
                        <button type="submit" class="form-control btn-info" name="action" value="generateDottedQR">Generate Dotted QR</button>
                    </div>
                    <div class="col-md-3 my-3">
                        <button type="submit" class="form-control btn-dark" name="action" value="generateGradientQR">Generate gradient QR</button>
                    </div>
                    <div class="col-md-3 my-3">
                        <button type="submit" class="form-control btn-primary" name="action" value="generateEmailQR">Generate Email QR</button>
                    </div>
                    <div class="col-md-3 my-3">
                        <button type="submit" class="form-control btn-warning" name="action" value="generatePhoneNumberQR">Generate Phone QR</button>
                    </div>
                    <div class="col-md-3 my-3">
                        <button type="submit" class="form-control btn-info" name="action" value="generateSmsQR">Generate SMS QR</button>
                    </div>
                    <div class="col-md-3 my-3">
                        <button type="submit" class="form-control btn-dark" name="action" value="generateWifiQR">Generate WIFI QR</button>
                    </div>
                    <div class="col-md-3 my-3">
                        <button type="submit" class="form-control btn-dark" name="action" value="generateGeoQR">Generate GeoLocation QR</button>
                    </div>
                </div>
            </form>

            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    @if (session('image'))
                        {{session('image')}}
                    @else
                        <p>No QR code available.</p>
                    @endif
                </div>
            </div>
            
            
        </div>
    </body>
</html>