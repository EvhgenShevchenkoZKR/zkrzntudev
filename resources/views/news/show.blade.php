@extends('app')

@section('headerstyles')

    <script type="text/javascript" src="/vendor/js/smartmenu/jquery.smartmenus.js"></script>
    <link href="/css/smartmenu/sm-core-css.css" rel="stylesheet" type="text/css" />
    <link href="/css/smartmenu/sm-blue/sm-blue.css" rel="stylesheet" type="text/css" />

    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- Important Owl stylesheet -->
    <link rel="stylesheet" href="/vendor/js/owl/owl-carousel/owl.carousel.css">
    <!-- Default Theme -->
    <link rel="stylesheet" href="/vendor/js/owl/owl-carousel/owl.theme.css">
    <!-- Include js plugin -->
    <script src="/vendor/js/owl/owl-carousel/owl.carousel.js"></script>

@endsection

@extends('homepage.main-menu')

@section('content')

    <h1 class="page-title">{{$news->title}}</h1>
    <p class="news-body">{!! $news->body !!}</p>

@endsection

@section('footerscripts')
    <script>
        $(document).ready(function() {

            $('#main-menu').smartmenus({
                subMenusSubOffsetX: 1,
                subMenusSubOffsetY: -8
            });
        });
    </script>
@endsection