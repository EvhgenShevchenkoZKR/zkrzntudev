@extends('app')

@section('headerstyles')
    {{--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>--}}
    {{--<script src='/vendor/js/jquery-sortable/jquery-sortable.js'></script>--}}

    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src='/vendor/js/nested-sortable/jquery.mjs.nestedSortable.js'></script>
    <style>
        body.dragging,
        body.dragging * {
            cursor: move !important;
        }

        .dragged {
            position: absolute;
            opacity: 0.5;
            z-index: 2000;
        }

        ul#sortable li.placeholder {
        position: relative;
        /** More li styles **/
        }
        ul#sortable li.placeholder:before {
        position: absolute;
        /** Define arrowhead **/
        }
        .inner-div .menu-text {
            width: 35%;
            display: inline-block;
        }
        .inner-div .btn {
            margin-right:5px;
        }
        .inner-div .menu-check {
            display: inline-block;
            width: 20px;
            vertical-align: middle;
            box-shadow: none;
        }
        .sortable-sumbenu,
        .ui-sortable {
            list-style-type: none;
            padding-left: 0;
        }

    </style>
@endsection

@section('content')
    <ol class="dd">
        <li><div id="qwe0">Some content</div></li>
        <li>
            <div id="qwe4">Some content</div>
            <ol>
                <li><div id="qwe1">Some sub-item content</div></li>
                <li><div id="qwe2">Some sub-item content</div></li>
            </ol>
        </li>
        <li><div>Some content</div></li>
    </ol>

    <ol class="sortable ui-sortable">
        <li id="list_1"><div>Oryx and Crake1</div></li>
        <li id="list_2"><div>Oryx and Crake2</div></li>
        <li id="list_sub_3"><div>Oryx and Crake3</div></li>
        <li id="list_qwe"><div>Oryx and Crake4</div></li>
    </ol>
    <a href="#" id="try" data-link="{{ url('/quest') }}" data-token="{{ csrf_token() }}">Try</a>
    <div class="crako">BUTTON</div>
    {!! Form::open(array('url' => 'menus-list', 'method' => 'POST', 'class' => 'form main-form')) !!}
    <ol id="sortable" class="ui-sortable">
    <?php $i=0; ?>
        @foreach($menus as $menu)
            <?php $i++; ?>
            <li id="list_{{$menu->id}}" class="ui-state-default col-md-12 clearfix">
                <div class="inner-div">
                    {{$menu->title}}
                    {!! Form::text("menu_title_$i", $menu->title, array('class' => 'form-control form-inline menu-text')) !!}
                    {!! Form::text("menu_url_$i", $menu->url, array('class' => 'form-control form-inline menu-text')) !!}
                    {!! Form::label('Опубліковано') !!}
                    {!! Form::checkbox("published_$i", 1, $menu->published, ['class' => 'form-control form-inline menu-check']) !!}
                    {!! Form::submit($menu->id, array('name' => 'update_menu', 'class' => 'btn btn-primary pull-right form-inline')) !!}
                    {!! Form::submit($menu->id, array('name' => 'delete_menu', 'class' => 'btn btn-danger pull-right form-inline')) !!}
                    <span class="menu-weight">
                        <input type="hidden" name="weight_{{$i}}" value="{{$menu->id}}">
                    </span>
                </div>
                @if(isset($menu['submenu']))
                    <ol class="sortable-sumbenu">
                        <?php $j=0; ?>
                        @foreach($menu['submenu'] as $submenu)
                            <?php $j++ ?>
                            <li id="list_{{$submenu->id}}"  class="ui-state-default ui-sortable-handle col-md-12 clearfix">
                                <div>
                                    {{$submenu->title}}
                                    <div class="submenu-weight">
                                        <input type="hidden" name="subeight_{{($i + rand(1,100) )* $j}}" value="{{$submenu->id}}">
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                @endif
            </li>
            <hr/>
        @endforeach
    </ol>
        {!! Form::submit('Перепорядкувти меню', array('name' => 'reorder_menus', 'class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

    {!! Form::open(array('url' => 'menu-add', 'method' => 'POST', 'class' => 'form')) !!}

    <div class="form-group">
        {!! Form::label('Заголовок') !!}
        {!! Form::text('title', old('title'), array('class' => 'form-control', 'placeholder' => 'Назва пункту меню')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Лінк') !!}
        {!! Form::text('url', old('url'), array('class' => 'form-control', 'placeholder' => 'Internal link')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Опубліковано') !!}
        {!! Form::checkbox('published', 1, false, ['class' => 'form-control']) !!}
    </div>

    {!! Form::submit('Створити меню', array('name' => 'add-menu', 'class' => 'btn btn-priary')) !!}
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
//                protectRoot: true
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
                    console.log('returned');
                    console.log(data.msg);
                },
                error:function(){
                    alert("error!!!!");
                }
            });
        }

    </script>
@endsection