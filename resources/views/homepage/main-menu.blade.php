@section('navigation')
    <div class="main-menu-wrapper clearfix">
        <div class="left-nav-wrapper col-md-12">
            <div class="site-logo pull-left col-md-4"><a href="/"><img src="/images/icons/gerb.png" width="60px"></a></div>
            <h2 class="site-slogan col-md-8"><span class="ss-inside"><a href="/">Запорізький коледж радіоелектроніки ЗНТУ</a></span></h2>
        </div>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse">
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


    </div>
@endsection
