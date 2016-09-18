@section('right_half')
    <div id="advnews" class="advnews">
        <div class="tabs">
            <span id="news-tab" class="active">Новини</span>
            <span id="advert-tab" class="">Оголошення</span>
        </div>
        <div class="news-tab">
            @foreach($freshNews as $news)
                <div class="fn-wrapper">
                    <div class="fn-created">{{$news->created_at->format('d.m.Y, H:i')}}</div>
                    <div class="fn-image">
                        <a href="/news/{{$news->slug}}">
                        @if($news->cover_image)
                        <img src="images/news/{{$news->id}}/thumbnail_{{$news->cover_image}}"
                             alt="{{$news->cover_alt}}"
                             title="{{$news->cover_title}}"
                        >
                        @else
                        <img src="/images/icons/main-korp.jpg"
                             alt="{{$news->cover_alt}}"
                             title="{{$news->cover_title}}"
                             width="100px" height="100px"
                        />
                        @endif
                        </a>
                    </div>
                    <div class="fn-fields">
                        <a href="/news/{{$news->slug}}">
                            <h5 class="fn-title">{{$news->title}}</h5>
                        </a>
                        <div class="fn-body">{!! str_limit(strip_tags($news->body, '<p><b><em><ol><ul><li>'),
                        $limit = 300, $end = '...') !!}</div>
                        <div class="fn-author pull-right">{{$news->author_name}}</div>
                    </div>
                </div>
            @endforeach
            <div class="fn-more">
                <div class="btn">
                    <a class="watch-all neutral-button" href="/news">Переглянути усі</a>
                </div>
            </div>
        </div>
        <div class="advert-tab">
            @foreach($freshAdverts as $advert)
                <div class="fn-wrapper">
                    <div class="fn-created">{{$advert->created_at->format('d.m.Y, H:i')}}</div>
                    <div class="fn-image">
                        <a href="/objava/{{$advert->slug}}">
                            <img src="images/objavas/{{$advert->id}}/thumbnail_{{$advert->cover_image}}"
                                 alt="{{$advert->cover_alt}}"
                                 title="{{$advert->cover_title}}"
                            >
                        </a>
                    </div>
                    <div class="fn-fields">
                        <a href="/objava/{{$advert->slug}}">
                            <h5 class="fn-title">{{$advert->title}}</h5>
                        </a>
                        <div class="fn-body">{!! str_limit(strip_tags($advert->body, '<p><b><em><ol><ul><li>'),
                        $limit = 300, $end = '...') !!}</div>
                        <div class="fn-author pull-right">{{$news->author}}</div>
                    </div>
                </div>
            @endforeach
            <div class="fn-more">
                <div class="btn">
                    <a class="watch-all neutral-button" href="/objavas">Переглянути усі</a>
                </div>
            </div>
        </div>
    </div>
@endsection