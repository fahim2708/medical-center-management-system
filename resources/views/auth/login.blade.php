<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>PDM</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend/img') }}/favicon.png">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/normalize.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/main.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/all.min.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="{{ asset('backend/fonts') }}/flaticon.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/animate.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css') }}/style.css">
    <!-- Modernize js -->
    <script src="{{ asset('backend/js') }}/modernizr-3.6.0.min.js"></script>
</head>

<body>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <!-- Login Page Start Here -->
    <div class="login-page-wrap" style="background-image: url({{ asset('backend/img') }}/figure/login-bg.jpg);">
        <div class="login-page-content">
            <div class="login-box">
                <div class="item-logo">
                    <h2 class="font-weight-bold">PDM</h2>
                </div>
                <form action="{{ route('login') }}" method="POST" class="login-form">
                    @csrf
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" placeholder="Enter username"
                            class="form-control @error('username')
                        border-red
                    @enderror"
                            name="username">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" placeholder="Enter password"
                            class="form-control  @error('password')
                        border-red
                    @enderror"
                            name="password">
                        @error('password')
                            <div class="text-red text-xs">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @session('status')
                        <div class="text-center text-red">
                            {{ session('status') }}
                        </div>
                    @endsession
                    <div class="form-group">
                        <button type="submit" class="login-btn">Login</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
    <!-- Login Page End Here -->
    <!-- jquery-->
    <script src="{{ asset('backend/js') }}/jquery-3.3.1.min.js"></script>
    <!-- Plugins js -->
    <script src="{{ asset('backend/js') }}/plugins.js"></script>
    <!-- Popper js -->
    <script src="{{ asset('backend/js') }}/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('backend/js') }}/bootstrap.min.js"></script>
    <!-- Scroll Up Js -->
    <script src="{{ asset('backend/js') }}/jquery.scrollUp.min.js"></script>
    <!-- Custom Js -->
    <script src="{{ asset('backend/js') }}/main.js"></script>

</body>

</html>
