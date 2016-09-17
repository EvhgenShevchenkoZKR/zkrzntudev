<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="/packages/jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/packages/bootstrap/bootstrap.min.css">
    <script type="text/javascript" src="/packages/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/totop/jquery.goup.js"></script>
    <link rel="shortcut icon" href="/public/images/icons/favicon.ico">
    {{--<link rel="icon" type="image/png" href="/images/icons/favicon.ico">--}}
    {{--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>--}}
    {{--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>--}}
    <script type="text/javascript" src="/vendor/js/smartmenu/jquery.smartmenus.js"></script>
    <link href="/css/smartmenu/sm-core-css.css" rel="stylesheet" type="text/css" />
    <link href="/css/smartmenu/sm-blue/sm-blue.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/css/app.css">

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
<script>
    $(document).ready(function() {
        //footer sticked to bottom script
        if ($(document).height() <= $(window).height()) {
            $('.vua-footer').addClass('fixed-footer');
        }
        //Scroll top
        $.goup({
            trigger: 1000,
            hideUnderWidth: 1000,
            bottomOffset: 120
        });
    });
</script>
</body>
</html>
