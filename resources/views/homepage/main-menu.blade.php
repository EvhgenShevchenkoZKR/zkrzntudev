@section('navigation')
    <div class="main-menu-wrapper clearfix">

        <ul id="main-menu" class="sm sm-blue">
            <h2 class="site-slogan">Запорізький коледж радіоелектроніки ЗНТУ</h2>
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
