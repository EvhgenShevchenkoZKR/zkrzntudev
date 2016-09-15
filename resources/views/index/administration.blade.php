@extends('app')

@section('headerstyles')

    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- Important Owl stylesheet -->
    <link rel="stylesheet" href="/vendor/js/owl/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="/vendor/js/owl/owl-carousel/owl.theme.css">
    <script src="/vendor/js/owl/owl-carousel/owl.carousel.js"></script>
    {{--vertical slider--}}
    <script src="/vendor/js/unislider/unislider.min.js"></script>
    <link rel="stylesheet" href="/vendor/js/unislider/unislider.css">
    <link rel="stylesheet" href="/vendor/js/unislider/unislider-dots.css">
    {{--vertical slider ends--}}
    <title>Адміністрація</title>
    <meta name="keywords" content="адміністрація зкр директор коледжу">
    <meta name="description" content="Інформація про керівництво Запорізького коледжу електроніки">
@endsection

@extends('homepage.main-menu')

@section('content')
    @if(isset($breadcrumbs))
        <div class="breadcrumbs container">
            <ul>
                <li class="breadcrumb-home"><a href="/">Головна<span>/</span></a></li>
                @foreach($breadcrumbs as $crumb)
                    <li><a href="{{$crumb['breadcrumb_url']}}">{{$crumb->title}}<span>/</span></a></li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="title-wrapper">
        <h1 class="page-title">Адміністрація</h1>
    </div>
    <div class="adm-wrapper news-gorizontal clearfix">
        @foreach($materials as $material)
            <div class="employee-wrapper">
                <h4 class="adm-fio">{{$material->fio}}</h4>
                <div class="adm-photo">
                    <img src="/images/employees/{{$material->id}}/photo_{{$material->photo}}"
                    width="275px"
                    >
                </div>
                <div class="adm-posada">{{$material->position}}</div>
                <div class="adm-body">{!! clean($material->body) !!}</div>
            </div>
        @endforeach
    </div>

@endsection

@extends('partials.top_news')

@extends('partials.footer')

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

