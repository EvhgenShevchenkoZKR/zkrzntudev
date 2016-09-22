<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="/packages/jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/packages/bootstrap/bootstrap.min.css">
    <script type="text/javascript" src="/packages/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/totop/jquery.goup.js"></script>
    <link rel="shortcut icon" href="/images/icons/favicon.ico">
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
            $('.zkr-footer').addClass('fixed-footer');
        }

        //Scroll to top button
        $.goup({
            trigger: 1000,
            hideUnderWidth: 1000,
            bottomOffset: 120,
            zIndex: 300
        });

        //hide gerb
        if($('.gerb-wrapper').length){
            //clock zkrzntu logo reload
            $('.content-wrapper').css('z-index', '101');
            $('.slider-wrapper').css('margin-bottom', '0');
            var imagefile = document.getElementById("clock-logo");
            var src = imagefile.src;
            imagefile.src = src+"?a="+Math.random();

            var link = $('.content-wrapper');
            var toPosition = link.position().top - 225;

            var interval = setInterval(function() {
                if ($(window).scrollTop() >= toPosition) {
                    $('.navigation').css('z-index', '200');
                    $('.site-logo img').fadeIn('fast');
                    $('.gerb-wrapper').fadeOut('fast');
                }
                else if ($(window).scrollTop() < toPosition) {
                    $('.site-logo img').fadeOut();
                    $('.navigation').css('z-index', '100');
                    $('.gerb-wrapper').fadeIn();
                }
            }, 250);
        }


    });
</script>
</body>
</html>
