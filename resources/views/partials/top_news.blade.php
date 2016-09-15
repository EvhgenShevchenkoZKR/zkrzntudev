@section('sidebar_right')
    <div class="qoute-vertical">
        <div class="qoute-title">Цитата</div>
        {!! clean($quote[0]->body) !!}
        <div class="pull-right">{{$quote[0]->author}}</div>
    </div>
    <div class="topnews-slider">
    <ul>
    <?php $slidesAtOnce = 5; ?>
    @foreach($topNews as $key=>$topnew)
        @if($key == 0 || $key % $slidesAtOnce === 0)
        <li>
        @endif
        <div class="topn-slide slide-wrapper">
            <a href="news/{{$topnew->id}}">
            <img src="/images/news/{{$topnew->id}}/news_{{$topnew->cover_image}}" width="200px" height="150px"
            alt="{{$topnew->cover_alt}}"
            title="{{$topnew->cover_title}}"
            >
            </a>
        </div>
        @if(($key+1) % $slidesAtOnce === 0)
        </li>
        @endif
    @endforeach
    </ul>
    </div>
    <script>
        $(document).ready(function() {
            $('.topnews-slider').unslider({
                animation: 'vertical',
                autoplay: false,
                infinite: true,
                arrows: true,
                speed: 1100,
                delay: 6000
            });
        });
    </script>
@endsection