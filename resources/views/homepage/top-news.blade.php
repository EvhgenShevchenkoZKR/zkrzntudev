@section('left_half')
    <div id="top-news" class="owl-carousel top-news">
        @foreach($top_news as $top_new)
            <div class="slide-wrapper">
                <a href="{{url("/news/$top_new->slug")}}">
                <img class="lazyOwl"
                     style="height: 350px; max-height: 350px; min-height: 350px; margin: auto; display: block"
                     src="{{url("images/news")}}/{{$top_new->id}}/{{$top_new->cover_image}}"
                     alt="{{$top_new->cover_alt}}"
                     title="{{$top_new->cover_title}}"
                >
                </a>
                <div class="news-slide-bottom">
                    <a href="{{url("/news/$top_new->slug")}}">
                    <h4 class="news-ttitle">{{$top_new->title}}</h4>
                    </a>
                    <p class="news-tbodt">{!!strip_tags($top_new->body)!!}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection