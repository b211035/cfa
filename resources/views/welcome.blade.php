<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CoachForAll</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="css/app.css" rel="stylesheet" type="text/css">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
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
		padding: 0.5em 1em;
    		margin: 2em 0;
    		font-weight: bold;
    		color: #6091d3;/*文字色*/
   		background: #FFF;
   		border: solid 3px #6091d3;/*線*/
    		border-radius: 10px;/*角の丸み*/
            }

	    .link_btn {
 		position: relative;
    		display: inline-block;
    		font-weight: bold;
    		padding: 0.25em 0.5em;
    		text-decoration: none;
    		color: #00BCD4;
    		background: #ECECEC;
    		transition: .4s;
	    }
	    .link_btn:hover {
    		background: #00bcd4;
 		color: white;
	    }
            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
       <!--     @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif
	-->
            <div class="content">
                <div class="title m-b-md">
		    <img src="images/cfa_logo.png" width=100%>
                </div>

                <div class="links">
		 @if (Route::has('login'))
                	  @auth
                	        <a href="{{ url('/home') }}" class="link_btn">Home</a>
                	    @else
                	        <a href="{{ route('login') }}" class="link_btn">ログイン</a>
                	    @endauth
           	 @endif
                </div>
                </div>
            </div>
        </div>
    </body>
</html>
