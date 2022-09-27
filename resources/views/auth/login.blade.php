<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PSDKP | Log in</title>

    <script src="https://kit.fontawesome.com/3c3b5dd79d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/splash.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="preloader">
        <div class="door" id="door1">
            <!-- Desired markup for content is placed within the grid-item-interior div -->
            <div class="grid-item-interior" style="background: url({{ asset('/img/bookshelf.png') }}) no-repeat center center; background-size: cover;">
                
                <div class="welcome">
                    <div class="bg-welcome text-center">
                        <img src="{{ asset('img/logo_psdkp.png') }}" style="width: 100px" class="mb-3">
                        <p class="mb-0 h1 text-light">Welcome!</p>
                        <p class="h6 mt-0 h3 text-light mb-5">Usaka</p>
                        <button id="start" class="btn btn-success">Login Now</button>

                    </div>
                </div>

            </div>

            <!-- left/right 'Door' panels / animations applied to these divs -->
            <div class="left" style="background: url({{ asset('/img/left-door.svg') }}) no-repeat center center; background-size: cover;"></div>
            <div class="right" style="background: url({{ asset('/img/right-door.svg') }}) no-repeat center center; background-size: cover;"></div>
        </div><!-- end /.door -->
    </div>

    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>PSDKP</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                @error('email')
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" value="{{ old('username') }}"
                            placeholder="Username" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                @if (Route::has('register'))
                    <p class="mb-0">
                        <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
                    </p>
                @endif
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/splash.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(".door").click(function() {
                $(this).toggleClass("active");
            });
        });
    </script>


</body>

</html>
