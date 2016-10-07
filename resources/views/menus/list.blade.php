@extends('adm')

@section('headerstyles')
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src='/vendor/js/nested-sortable/jquery.mjs.nestedSortable.js'></script>
    <link rel="stylesheet" href="/css/custom_css/admin.css">
    {{--<link rel="stylesheet" href="/css/app.css">--}}
@endsection

@section('content')

    <h1 class="apage-title relative-apage-title">Список меню</h1>
    {!! Form::open(array('url' => 'menus-list', 'method' => 'POST', 'class' => 'form main-form clearfix')) !!}
    <div class="form-description">Ви можете змінювати порядок меню перетягуючи їх, порядок зберігається автоматично.
        <br> Для змiни меню введiть новi данi та натиснiть кнопку зберегти
        <p></p>
    </div>
    <span style="display: none;" href="#" id="try" data-token="{{ csrf_token() }}"></span>
    <ol id="sortable" class="ui-sortable">
    <?php $i=0; ?>
        @foreach($menus as $menu)
            <?php $i++; ?>
            <li id="list_{{$menu->id}}" class="ui-state-default col-md-12 clearfix">
                <div class="inner-div">
                    <span class="glyphicon glyphicon-move"></span>
                    {!! Form::text("menu_title_$menu->id", $menu->title, array('class' => 'form-control form-inline menu-text offset-left')) !!}
                    {!! Form::text("menu_url_$menu->id", $menu->url, array('class' => 'form-control form-inline menu-text')) !!}
                    {!! Form::label('Опубліковано') !!}
                    {!! Form::checkbox("published_$menu->id", 1, $menu->published, ['class' => 'form-control form-inline menu-check']) !!}
                    {!! Form::submit($menu->id, array('name' => 'delete_menu', 'class' => 'btn button-icon delete_menu btn-danger pull-right form-inline')) !!}
                    {!! Form::submit($menu->id, array('name' => 'update_menu', 'class' => 'btn button-icon update_menu btn-primary pull-right form-inline')) !!}
                </div>
                @if(isset($menu['submenu']))
                    <ol class="sortable-sumbenu">
                        <?php $j=0; ?>
                        @foreach($menu['submenu'] as $submenu)
                            <?php $j++ ?>
                            <li id="list_{{$submenu->id}}"  class="ui-state-default ui-sortable-handle col-md-12 clearfix">
                                <div class="inner-div">
                                    <span class="glyphicon glyphicon-move"></span>
                                    {!! Form::text("menu_title_$submenu->id", $submenu->title, array('class' => 'form-control form-inline menu-text offset-left')) !!}
                                    {!! Form::text("menu_url_$submenu->id", $submenu->url, array('class' => 'form-control form-inline menu-text')) !!}
                                    {!! Form::label('Опубліковано') !!}
                                    {!! Form::checkbox("published_$submenu->id", 1, $submenu->published, ['class' => 'form-control form-inline menu-check']) !!}
                                    {!! Form::submit($submenu->id, array('name' => 'delete_menu', 'class' => 'btn button-icon delete_menu btn-danger pull-right form-inline')) !!}
                                    {!! Form::submit($submenu->id, array('name' => 'update_menu', 'class' => 'btn button-icon update_menu btn-primary pull-right form-inline')) !!}

                                    <div class="submenu-weight">
                                        <input type="hidden" name="subeight_{{($i + rand(1,100) )* $j}}" value="{{$submenu->id}}">
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                @endif
            </li>
        @endforeach
    </ol>
    {!! Form::close() !!}
    <hr/>
    <h2 class="apage-title relative-apage-title">Створити новий пункт меню</h2>
    {!! Form::open(array('url' => 'menu-add', 'method' => 'POST', 'class' => 'form')) !!}
    <div class="form-group">
        {!! Form::label('title', 'Заголовок', ['class' => 'required']) !!}
        {!! Form::text('title', old('title'), array('class' => 'form-control', 'placeholder' => 'Назва пункту меню')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('url', 'Лінк', ['class' => 'required']) !!}
        {!! Form::text('url', old('url'), array('class' => 'form-control', 'placeholder' => 'Internal link')) !!}
    </div>

    <div class="form-group published-inline col-md-4">
        {!! Form::label('Опубліковано') !!}
        {!! Form::checkbox('published', 1, false, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Створити меню', array('name' => 'add-menu', 'class' => 'btn btn-success pull-right')) !!}
    </div>
    {!! Form::close() !!}

@endsection

@section('footerscripts')
    <script>

        $(document).ready(function(){

            $('.ui-sortable').nestedSortable({
                handle: 'div',
                items: 'li',
                toleranceElement: '> div',
                maxLevels: 2,
                stop: function() { save_order(); }
            });
        });

        function save_order(){
            var r = $('#sortable').nestedSortable('serialize');
            var data = {
                _token:$('#try').data('token'), //todo - get some normal way of getting token
                testdata: r
            };

            $.ajax({
                url: "ajax-menus-reorder",
                type:"POST",
                data: data,
                success:function(data){
                    $('.content').prepend('<div id="panel" class="alert success">' + data.msg + '</div>');
                    $("#panel").fadeIn( 600 ).delay( 800 ).fadeOut( 800 );
                },
                error:function(){
                    alert("Щось не так зі зміною порядку у меню");
                }
            });
        }
    </script>
@endsection