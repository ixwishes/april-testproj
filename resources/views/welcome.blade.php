<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>April and Kirt</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ url('/css/homepage.css') }}?v=2" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            a{
              text-decoration: none !important;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .btn-large {
              display: inline-block;
              margin: 3px 8px;
              padding: 10px;
              min-width: 70px;
              font-size: .7em;
              color: #FFFFFF;
              text-align: center;
              border-radius: 5px;
            }

            .btn-pink {
              background: #fc0373;
            }

            .btn-blue {
              background: #139ed1;
            }


        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="slideshow">
                <div class="slideshow-image" style="background-image: url('{{ url("/images/IMG_2827.JPG") }}')"></div>
                <div class="slideshow-image" style="background-image: url('{{ url("/images/IMG_2769.JPG") }}')"></div>
                <div class="slideshow-image" style="background-image: url('{{ url("/images/B29A6161.jpg") }}')"></div>
                <div class="slideshow-image" style="background-image: url('{{ url("/images/IMG_2341.jpg") }}')"></div>
            </div>
            <div class="content">
              <h1>APRIL & KIRT
                <small><a href="https://www.appycouple.com/wedding/kirtplusapril/events/" class="btn-large btn-pink">Wedding Website</a>
                <a href="http://aprilandkirt.com/blog" class="btn-large btn-blue">Our Blog</a></small>
              </h1>


            </div>
        </div>
    </body>
</html>
