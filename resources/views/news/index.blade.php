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
@endsection

@extends('homepage.main-menu')

@section('content')
    <?php $count = 0; ?>
    <h1 class="page-title">Новини</h1>
    <div class="news-index clearfix">
    @foreach($news as $single_news)
        <div class="news-wrapper clearfix {{(++$count%2 ? "odd" : "even")}}">
            <div class="n-image col-md-3">
                <a href="/news/{{$single_news->slug}}">
                <img src="/images/news/{{$single_news->id}}/news_{{$single_news->cover_image}}"
                 alt="{{$single_news->cover_alt}}"
                 title="{{$single_news->cover_title}}"
                 width="250px" height="180px"
                />
                </a>
            </div>
            <div class="n-text col-md-9">
                <h4>
                    <a href="/news/{{$single_news->slug}}">
                    {{$single_news->title}}
                    </a>
                </h4>
                <div class="n-tags">
                    @if(isset($single_news->tag[0]))
                        <span>Теги:</span>
                        @foreach($single_news->tag as $k => $tag)
                            @if($k != 0)<span class="comma">,</span> @endif
                            <span><a href="tag/{{$tag->slug}}">{{$tag->title}}</a></span>
                        @endforeach
                    @endif
                </div>
                <div class="n-published">
                    <span>Опубліковано:</span>
                    <span class="n-time">{{$single_news->created_at->format('H:i m.d.Y')}}</span>
                </div>
                <div class="nbody">
                    {!! str_limit(strip_tags($single_news->body, '<p><b><em><ol><ul><li>'),
                        $limit = 550, $end = '...') !!}
                    <span class="read-more"><a href="/news/{{$single_news->slug}}">читати далі</a></span>
                </div>
                <div class="n-author">{{$single_news->author_name}}</div>
            </div>
        </div>
    @endforeach
        <div class="pagination-block">{{ $news->links() }}</div>
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

