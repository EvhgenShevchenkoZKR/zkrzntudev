@extends('app')

@section('headerstyles')

    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- Important Owl stylesheet -->
    <link rel="stylesheet" href="/vendor/js/owl/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="/vendor/js/owl/owl-carousel/owl.theme.css">
    <script src="/vendor/js/owl/owl-carousel/owl.carousel.js"></script>
    <title>{{$material->meta_title}}</title>
    <meta name="keywords" content="{{$material->meta_keywords}}">
    <meta name="description" content="{{$material->meta_description}}">
@endsection

@extends('homepage.main-menu')

@section('bottom-content')
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
        <h1 class="page-title">{{$material->title}}</h1>
    </div>
    <div class="news-wrapper news-gorizontal clearfix">
        <div class="n-text">
            <div class="nbody">
                {!! clean($material->description) !!}
            </div>
        </div>
    </div>
    @if(count($material->children()->get()))
        <div class="title-wrapper">
            <h2 class="divide-title">{{$material->title_children}}</h2>
        </div>
        <div class="all-c-wrapper clearfix">
            @foreach($material->children()->get() as $child)
                <div class="c-wrapper clearfix">
                    @if($child->cover_image && strpos($child->cover_image, '/') !== 0)
                    <div class="c-image col-md-3">
                        <a href="/child/{{$child->slug}}">
                            <img src="/images/child/{{$child->id}}/small_{{$child->cover_image}}"
                                 alt="{{$child->cover_alt}}"
                                 title="{{$child->cover_title}}"
                                 width="250px" height="180px"
                            />
                        </a>
                    </div>
                    <div class="c-text col-md-9">
                    @else
                    <div class="c-text col-md-12">
                    @endif
                        <h4 class="child-title">
                            <a href="/child/{{$child->slug}}">{{$child->title}}</a>
                        </h4>
                        <div class="child-body">
                            {!! str_limit(strip_tags($child->body, '<p><b><em><ol><ul><li>'),
                            $limit = 450, $end = '...') !!}
                            <span class="read-more"><a href="/child/{{$child->slug}}">читати далі</a></span>
                        </div>
                    </div>
                    <hr class="divider show">
                </div>
            @endforeach
        </div>
    @endif
    @if(count($relatedNews))
    <div class="title-wrapper">
        <h2 class="divide-title">{{$material->title_tags}}</h2>
    </div>
    <div class="related-news-wrapper container">
    <span id="related-left" class="hidden" data-token="{{$relatedLeft}}">{{$relatedLeft}}</span>
    <span id="related-id" class="hidden" data-token="{{$material->id}}"></span>
    <span id="rel-sinlge_link" class="hidden" data-token="{{$sinlge_link}}"></span>
    <span id="rel-type" class="hidden" data-token="{{$material_sinlge_link}}"></span>
    <span id="rel-folder" class="hidden" data-token="{{$folder}}"></span>
    <span id="rel-image_prefix" class="hidden" data-token="{{$image_prefix}}"></span>
    <span id="try" class="hidden" data-token="{{ csrf_token() }}"></span>
    @foreach($relatedNews as $related)
            <div class="news-wrapper clearfix">
                <div class="n-image col-md-3">
                    <a href="/{{$sinlge_link}}/{{$related->slug}}">
                        <img src="/images/{{$folder}}/{{$related->id}}/{{$image_prefix}}_{{$related->cover_image}}"
                             alt="{{$related->cover_alt}}"
                             title="{{$related->cover_title}}"
                             width="250px" height="180px"
                        />
                    </a>
                </div>
                <div class="n-text col-md-9">
                    <h4>
                        <a href="/{{$sinlge_link}}/{{$related->slug}}">
                            {{$related->title}}
                        </a>
                    </h4>
                    <div class="n-tags">
                        @if(isset($related->tag[0]))
                            <span>Теги:</span>
                            @foreach($related->tag as $k => $tag)
                                @if($k != 0)<span class="comma">,</span> @endif
                                <span><a href="/tag/{{$tag->slug}}">{{$tag->title}}</a></span>
                            @endforeach
                        @endif
                    </div>
                    <div class="n-published">
                        <span>Опубліковано:</span>
                        <span class="n-time">{{$related->created_at->format('H:i m.d.Y')}}</span>
                    </div>
                    <div class="nbody">
                        {!! str_limit(strip_tags($related->body, '<p><b><em><ol><ul><li>'),
                            $limit = 550, $end = '...') !!}
                        <span class="read-more"><a href="/{{$sinlge_link}}/{{$related->slug}}">читати далі</a></span>
                    </div>
                    <div class="n-author">{{$related->author_name}}</div>
                </div>
            </div>
        <hr class="divider">
        @endforeach
    </div>
        @if($relatedLeft > 0)
            <button id="more" class="btn btn-zkr">Показати більше схожих матеріалів</button>
        @endif
    @endif
    @if(!count($material->children()->get()) && !count($relatedNews))
        <div class="qoute-horizontal">
            <div class="qoute-title">Цитата</div>
            {!! clean($quote[0]->body) !!}
            <div class="quote-author">{{$quote[0]->author}}</div>
        </div>
        <div id="top-n-horizontal" class="top-n-horizontal owl-carousel">
            @foreach($topNews as $news)
                <div class="slide-wrapper">
                    <a href="/news/{{$news->slug}}">
                        <img class="lazyOwl" src="/images/news/{{$news->id}}/news_{{$news->cover_image}}"
                             width="240px" height="170px"
                             alt="{{$news->cover_alt}}"
                             title="{{$news->cover_title}}"
                        >
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@endsection

@extends('partials.footer')

@section('footerscripts')
    <script>
        $(document).ready(function() {

            $('#more').click(function(){
                more();
            });

            function more() {
                var data = {
                    _token: $('#try').data('token'),
                    relatedLeft: $('#related-left').html(),
                    relatedId: $('#related-id').data('token'),
                    relatedSingleLink: $('#rel-sinlge_link').data('token'),
                    relatedFolder: $('#rel-folder').data('token'),
                    relatedImagePrefix: $('#rel-image_prefix').data('token'),
                    relatedType: $('#rel-type').data('token')
                };

                $.ajax({
                    url: "/ajax-more-parent",
                    type: "POST",
                    data: data,
                    success: function (data) {
                        console.log(data.left);
                        $('.related-news-wrapper').append(data.html);
                        $('#related-left').html(data.left);
                        if(data.left <= 0){
                            $('#more').remove();
                        }
                    },
                    error: function () {
                        alert("Щось не так зі зміною порядку у меню");
                    }
                });
            }

            $("#top-n-horizontal").owlCarousel({
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
@endsection

