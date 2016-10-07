<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="/packages/jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/packages/bootstrap/bootstrap.min.css">
    <script type="text/javascript" src="/packages/bootstrap/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="/images/icons/favicon_adm.ico">

    <script src="/js/admin/hideshow.js"></script>
    {{--Main css files compiled from less via gulp--}}
    <link rel="stylesheet" type="text/css" href="/css/admin.css">

    @yield('headerstyles')
</head>
<body>
<div class="navigation">
    @yield('navigation')
</div>
<div class="container">
    <div class="content col-md-12">
        <aside id="sidebar" class="amenu column col-md-2">
            <h3>Цитати</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/quote/add">Створити</a></li>
                <li class="icn_categories"><a href="/adm/quotes">Список</a></li>
            </ul>
            <h3>Посилання</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/link/add">Створити</a></li>
                <li class="icn_categories"><a href="/adm/links">Список</a></li>
            </ul>
            <h3>Співробітники</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/employee/add">Створити</a></li>
                <li class="icn_categories"><a href="/adm/employees">Список</a></li>
            </ul>
            <h3>Новини</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/news/add">Створити</a></li>
                <li class="icn_categories"><a href="/adm/news">Список</a></li>
            </ul>
            <h3>Теги з новин</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/tags/add">Створити</a></li>
                <li class="icn_categories"><a href="/adm/tags">Список</a></li>
            </ul>
            <h3>Головне меню</h3>
            <ul class="toggle">
                <li class="icn_categories"><a href="/menus-list">Список</a></li>
            </ul>
            <h3>Оголошення</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/objava/add">Створити</a></li>
                <li class="icn_categories"><a href="/adm/objavas">Список</a></li>
            </ul>
            <h3>Слайдер</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/slider/add">Створити</a></li>
                <li class="icn_categories"><a href="/sliders">Список</a></li>
            </ul>
            <h3>Базова сторінка</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/parent/add">Створити</a></li>
                <li class="icn_categories"><a href="/adm/parents">Список</a></li>
            </ul>
            <h3>Матеріали</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/child/add">Створити</a></li>
                <li class="icn_categories"><a href="/adm/childs">Список</a></li>
            </ul>
            <h3>Плитки</h3>
            <ul class="toggle">
                <li class="icn_new_article"><a href="/adm/massonry/add">Створити</a></li>
                <li class="icn_categories"><a href="/adm/massonrys">Список</a></li>
            </ul>
            {{--TODO
            sliders
            slides
            --}}
        </aside>
        <div class="col-md-10">
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
            @yield('content')
        </div>
    </div>
</div>
@yield('footerscripts')
<script>
    $(document).ready(function() {
//footer sticked to bottom script
        if ($(document).height() <= $(window).height()) {
            $('.vua-footer').addClass('fixed-footer');
        }
    });
</script>
</body>
</html>
