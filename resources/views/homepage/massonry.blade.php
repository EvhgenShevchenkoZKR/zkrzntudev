@section('bottom-content')
    <div class="massonry-wrapper col-md-12">
        <div class="massonry-wrapper-inner">
        <div class="title-wrapper">
            <h2 class="divide-title">Діяльність Запорізького коледжу радіоелектроніки</h2>
        </div>
        @foreach($massonry as $plate)
            <div class="plate-wrapper">
                <a href="/{{$plate->url}}">
                    <div class="plate-wrapper-inner">
                        <img src="images/massonry/{{$plate->id}}/{{$plate->image}}"
                             alt="{{$plate->image_alt}}"
                             title="{{$plate->image_title}}"
                        >
                        <h4 class="plate-title">{{$plate->title}}</h4>
                        <div class="plate-body">{!! str_limit(strip_tags($plate->body,
                '<a><p><b><strong><em><ol><ul><li>'),
                $limit = 200, $end = '...') !!}</div>
                    </div>
                </a>
            </div>
        @endforeach
        </div>
    </div>
    <div class="friends-wrapper col-md-12">
        <div class="title-wrapper">
            <h2 class="divide-title">Посилання</h2>
        </div>
        <div id="friends" class="fr-wrapper">
            @foreach($links as $link)
                <div class="slide-wrapper">
                    <a href="/{{$link->url}}" class="fr-link">
                    <img class="lazyOwl"
                         style="width: 100%; height: auto; max-height: 100px;"
                         data-src="{{url("images/links")}}/{{$link->id}}/{{$link->image}}"
                         src="/{{url("images/links")}}/{{$link->id}}/{{$link->image}}"
                         alt="{{$link->image_alt}}"
                         title="{{$link->image_title}}"
                    >
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection