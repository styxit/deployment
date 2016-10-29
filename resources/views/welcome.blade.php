<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Deployment statuses</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet">
        <!-- Styles -->
        <style>
            html, body {
                color: #636b6f;
                height: 100vh;
                margin: 0;
                font-size: 15px;
            }

            .btn{
                color: #5c5c5e;
                padding: 7px;
                background-color: #ffffff;
                border: rgba(92,92,94,0.8) 1px solid;
                text-decoration: none;
            }

            .btn-github {
                padding: 20px;
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

            .content {
                text-align: center;
            }

            .title {
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                font-size: 15vw;
            }
            @media (min-width: 480px) {
                .title {
                    font-size: 84px;
                }
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body class="lock-screen">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Deployments
                </div>
                @if (Auth::check())
                    <div class="lock-wrapper">
                        <div class="lock-box text-center">
                            <img src="{{ Auth::user()->avatar }}" alt="Avatar" width="75"/>
                            <h1>Hi {{ Auth::user()->name}}</h1>
                            <span class="locked">You are authenticated through GitHub</span>
                            <div>
                                <a class="btn btn-continue" href="/home">
                                    Continue <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <h2>
                        <a href="/auth/github" class="btn btn-github">
                            <span class="fa fa-github"></span> Sign in with GitHub
                        </a>
                    </h2>
                @endif
            </div>
        </div>
    </body>
</html>
