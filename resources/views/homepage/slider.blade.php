@extends('app')

@section('headerstyles')
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- Important Owl stylesheet -->
    <link rel="stylesheet" href="/vendor/js/owl/owl-carousel/owl.carousel.css">
    <!-- Default Theme -->
    <link rel="stylesheet" href="/vendor/js/owl/owl-carousel/owl.theme.css">
    <!-- Include js plugin -->
    <script src="/vendor/js/owl/owl-carousel/owl.carousel.js"></script>

    <link rel="stylesheet" href="/css/custom_css/homepage.css">

    <script type="text/javascript" src="/vendor/js/smartmenu/jquery.smartmenus.js"></script>
    <link href="/css/smartmenu/sm-core-css.css" rel="stylesheet" type="text/css" />
    <link href="/css/smartmenu/sm-blue/sm-blue.css" rel="stylesheet" type="text/css" />

    <link href="/css/app.css" rel="stylesheet" type="text/css" />

    <title>Запорізький коледж радіоелектроніки</title>
    <meta name="keywords" content="колледж техникум ЗКР Запорожье">
    <meta name="description" content="Запорізький коледж радіоелектроніки ЗНТУ. Офіційний сайт ЗКР ЗНТУ.
    Ласкаво просимо до наших лав. ЗКР ЗНТУ запорожье. ЗКР ЗНТУ запоріжжя набирає студентів на базі 9-ти
    та 11-ти класів. Запорожский колледж радиоэлектроники ЗНТУ среди колледжей Запорожья занимает
    лидирующие позиции в подготовке младших специалистов по компьютерным специальностям.
    Колледжи Запорожья. Коледжі Запоріжжя">

@endsection

@extends('homepage.main-menu')

@section('slider')
    <div class="gerb-wrapper">
        <div class="clock-logo-wrapper"><a href="/"><img id="clock-logo" src="/images/icons/zkr_bg.gif" width="130px"></a></div>
        {{--<div class="clock-logo-wrapper"><a href="/"><img id="clock-logo" src="/images/icons/zkr_zntu.gif" width="100px"></a></div>--}}
        {{--<div class="clock-gerb-wrapper"><a href="/"><img src="/images/icons/gerb.png" width="150px"></a></div>--}}
    </div>
    <div id="owl-example" class="owl-carousel">
        @foreach($sliders as $slider)
            <div class="slide-wrapper">
                <img class="lazyOwl"
                     {{$slide = $slider->slides()->get()->random()}}
                     {{--data-src="{{url("images/slider")}}/{{$slider->id}}/{{$slide->image}}"--}}
                     style="width: 100%; height: 500px !important; max-height: 500px; background-image:url({{url("images/slider")}}/{{$slider->id}}/{{$slide->image}});"
                     {{--src="{{url("images/slider")}}/{{$slider->id}}/slide_{{$slide->image}}"--}}
                     alt="{{$slide->alt}}"
                     title="{{$slide->title}}"
                >
                <div class="slide-title-wrapper">
                    <h3 class="slide-title-text">{{$slider->title}}</h3>
                    <a href="{{url($slider->url)}}" class="slider-title-link">Перейти</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@extends('homepage.top-news')

@extends('homepage.news-adverts')

@extends('homepage.massonry')

@section('footerscripts')
    <script>
        $(document).ready(function() {
            $('#advnews .tabs span').click(function(){
                var $clickedElement = ($(this).attr('id'));
                $('#advnews .tabs span').each(function() {
                    $( this ).removeClass( "active" );
                    if($(this).attr('id') != $clickedElement) {
                        $('#advnews .' + $(this).attr('id')).hide();
                    }
                });
                $(this).toggleClass('active');
                $('#advnews .' + $clickedElement).fadeIn();
            });

            $("#owl-example").owlCarousel({
                singleItem: true,
                slideSpeed : 600,
                paginationSpeed : 600,
                navigation : true,
                autoPlay: true,
                stopOnHover: true,
                navigationText: false,
                responsive: true,
//                lazyLoad: true,
//                lazyFollow: true,
                addClassActive: true,
                pagination: false
            });

            $("#top-news").owlCarousel({
                singleItem: true,
                slideSpeed : 600,
                paginationSpeed : 600,
                navigation : false,
                autoPlay: true,
                stopOnHover: true,
                navigationText: false,
                responsive: true,
                lazyLoad: true,
                lazyFollow: true,
                addClassActive: true,
                pagination: true
            });

            $("#friends").owlCarousel({
                singleItem: false,
                slideSpeed : 600,
                paginationSpeed : 600,
                navigation : true,
                autoPlay: true,
                stopOnHover: true,
                navigationText: false,
                responsive: true,
                lazyLoad: true,
                lazyFollow: true,
                addClassActive: true,
                pagination: false
            });

            $('#main-menu').smartmenus({
                subMenusSubOffsetX: 1,
                subMenusSubOffsetY: -8
            });
        });
    </script>
    <script src="/js/custom_js/homepage.js"></script>
@endsection

@extends('partials.footer')