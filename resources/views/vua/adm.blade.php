<!DOCTYPE html>
<html>
<head>
    <title>{{trans('m.admin_area')}}</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    {{--<script type="text/javascript" src="/js/jquery/jquery-2.2.4.min.js"></script>--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.min.css">
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/js/admin/hideshow.js"></script>
    {{--Main css files compiled from less via gulp--}}
    <link rel="stylesheet" type="text/css" href="/css/admin.css">

    @yield('headerscripts')
</head>
<body>
<div class="container">
    <div class="logs">
        @if(Session::has('message'))
            <h4 class="msg alert">{{Session::get('message')}}</h4>
        @endif

        @if(count($errors->all()))
            <ul class="msg-errors">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="content">
        <aside id="sidebar" class="amenu column col-md-2">
            <h3>{{trans('m.companies')}}</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/company/add">{{trans('m.create')}}</a></li>
                <li class="icn_categories"><a href="/adm/companies">{{trans('m.list')}}</a></li>
            </ul>
            <h3>{{trans('m.regions')}}</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/region/add">{{trans('m.create')}}</a></li>
                <li class="icn_categories"><a href="/adm/regions">{{trans('m.list')}}</a></li>
            </ul>
            <h3>{{trans('m.company_types')}}</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/company-type/add">{{trans('m.create')}}</a></li>
                <li class="icn_categories"><a href="/adm/company-types">{{trans('m.list')}}</a></li>
            </ul>
            <h3>{{trans('m.service_types')}}</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/service-type/add">{{trans('m.create')}}</a></li>
                <li class="icn_categories"><a href="/adm/service-types">{{trans('m.list')}}</a></li>
            </ul>
            <h3>{{trans('m.goods_types')}}</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/goods-type/add">{{trans('m.create')}}</a></li>
                <li class="icn_categories"><a href="/adm/goods-types">{{trans('m.list')}}</a></li>
            </ul>
            <h3>{{trans('m.main_menu')}}</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/main-menu/add">{{trans('m.create')}}</a></li>
                <li class="icn_categories"><a href="/adm/main-menus">{{trans('m.list')}}</a></li>
            </ul>
        </aside>
        <div class="col-md-10">
            @yield('content')
        </div>
    </div>
</div>
@yield('footerscripts')
</body>
</html>
