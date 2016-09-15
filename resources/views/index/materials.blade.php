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
    <title>{{$page_title}}</title>
    <meta name="keywords" content="{{$page_title}} колледж техникум ЗКР Запорожье">
    <meta name="description" content="Запорізький коледж радіоелектроніки ЗНТУ. Офіційний сайт ЗКР ЗНТУ.
    Ласкаво просимо до наших лав. ЗКР ЗНТУ запорожье. ЗКР ЗНТУ запоріжжя набирає студентів на базі 9-ти
    та 11-ти класів. Запорожский колледж радиоэлектроники ЗНТУ среди колледжей Запорожья занимает
    лидирующие позиции в подготовке младших специалистов по компьютерным специальностям.
    Колледжи Запорожья. Коледжі Запоріжжя {{$page_title}}">
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
    <?php $count = 0; ?>
    <div class="title-wrapper">
        <h1 class="page-title">{{$page_title}}</h1>
    </div>
    <div class="news-index clearfix">
    @foreach($materials as $material)
        <div class="news-wrapper clearfix {{(++$count%2 ? "odd" : "even")}}">
            <div class="n-image col-md-3">
                <a href="/{{$sinlge_link}}/{{$material->slug}}">
                <img src="/images/{{$folder}}/{{$material->id}}/{{$image_prefix}}_{{$material->cover_image}}"
                 alt="{{$material->cover_alt}}"
                 title="{{$material->cover_title}}"
                 width="250px" height="180px"
                />
                </a>
            </div>
            <div class="n-text col-md-9">
                <h4>
                    <a href="/{{$sinlge_link}}/{{$material->slug}}">
                    {{$material->title}}
                    </a>
                </h4>
                <div class="n-tags">
                    @if(isset($material->tag[0]))
                        <span>Теги:</span>
                        @foreach($material->tag as $k => $tag)
                            @if($k != 0)<span class="comma">,</span> @endif
                            <span><a href="/tag/{{$tag->slug}}">{{$tag->title}}</a></span>
                        @endforeach
                    @endif
                </div>
                <div class="n-published">
                    <span>Опубліковано:</span>
                    <span class="n-time">{{$material->created_at->format('H:i m.d.Y')}}</span>
                </div>
                <div class="nbody">
                    {!! str_limit(strip_tags($material->body, '<p><b><em><ol><ul><li>'),
                        $limit = 550, $end = '...') !!}
                    <span class="read-more"><a href="/{{$sinlge_link}}/{{$material->slug}}">читати далі</a></span>
                </div>
                <div class="n-author">{{$material->author_name}}</div>
            </div>
        </div>
        <hr class="divider">
    @endforeach
        <div class="pagination-block">{{ $materials->links() }}</div>
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

