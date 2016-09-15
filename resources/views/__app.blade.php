<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    @yield('headerstyles')
</head>
<body>
<div class="navigation">
    @yield('navigation')
</div>
<div class="slider-wrapper">
    @yield('slider')
</div>
<div class="container">
    <div class="content col-md-12">
        @if(Session::has('message'))
            <h4 class="alert">{{Session::get('message')}}</h4>
        @endif

        @if($errors->has())
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        @endif
    </div>
</div>
<div class="content-wrapper clearfix col-md-12">
    <div class="col-md-10">
        @yield('content')
    </div>
    <div class="col-md-2">
        @yield('sidebar_right')
    </div>
    <div class="left-half col-md-6">
        @yield('left_half')
    </div>
    <div class="right-half col-md-6">
        @yield('right_half')
    </div>
    <div class="bottom-content">
        @yield('bottom-content')
    </div>
</div>
@yield('footerscripts')
@yield('footer')
</body>
</html>
