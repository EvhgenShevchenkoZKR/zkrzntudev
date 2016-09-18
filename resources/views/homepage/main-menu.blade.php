@section('navigation')
    <div class="main-menu-wrapper clearfix">
        <div class="left-nav-wrapper col-md-6">
            <div class="site-logo pull-left col-md-2"><a href="/"><img src="/images/icons/gerb.png" width="60px"></a></div>
            <h2 class="site-slogan col-md-10"><span class="ss-inside">Запорізький коледж радіоелектроніки ЗНТУ</span></h2>
        </div>
        <ul id="main-menu" class="sm sm-blue">
            @foreach($menus as $menu)
                <li class="item"><a href="/{{$menu->url}}"><span>{{$menu->title}}</span></a>
                    @if(count($menu['submenus']) > 0)
                        <ul class="sub-menu">
                            @foreach($menu['submenus'] as $sumbenu)
                                <li><a href="/{{$sumbenu->url}}"><span>{{$sumbenu->title}}</span></a></li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endsection
