@extends('adm')

@section('headerstyles')
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src='/vendor/js/nested-sortable/jquery.mjs.nestedSortable.js'></script>
    <link rel="stylesheet" href="/css/admin_draggable.css">
@endsection

<span style="display: none;" href="#" id="try" data-token="{{ csrf_token() }}"></span>
@section('content')
    <h1 class="apage-title relative-apage-title">Список співробітників</h1>
    {{--<table>--}}
    <ol id="sortable" class="ui-sortable fake-table">
        <?php $i = 0; ?>
        <div class="fake-thead">
            <span class="fake-th fake-th-title">ПІБ</span>
            <span class="fake-th fake-th-alias">Посада</span>
            <span class="fake-th fake-th-pub">Адміністрація</span>
            <span class="fake-th fake-th-actions">Дії</span>
        </div>
        @foreach($employees as $employee)
            <li id="list_{{$employee->id}}" class="ui-state-default col-md-12 clearfix">
                <div class="inner-div fake-trow">
                    <span class="fake-column draggable-title">
                        <span class="glyphicon glyphicon-move"></span>
                        <span class="fake-th">{{$employee->fio}}</span>
                    </span>
                    <span class="fake-column draggable-alias">{{$employee->position}}</span>
                    <span class="fake-column graggable-pub">
                        @if($employee->administration == true)
                        <span class="agreen">Так</span>
                        @else
                        <span class="ared">Ні</span>
                        @endif
                    </span>
                    <div class='draggable-actions'>
                        <span class="icn_edit">
                            <a class="atable-button" href="/adm/employee/{{$employee->id}}/edit">&nbsp;</a>
                        </span>
                        <span class="icn_trash">
                            <?php $locale = App::getLocale();  ?>
                            {!! Form::open(array('url' => "/adm/employee/$employee->id/delete", 'method' => 'delete', 'class' => 'form')) !!}
                            {!! Form::submit('&nbsp;', ['class' => 'btn-delete']) !!}
                            {!! Form::close() !!}
                        </span>
                    </div>

                </div>
            </li>
        @endforeach
    </ol>
@endsection

@section('footerscripts')
    <script>

        $(document).ready(function(){

            $('.ui-sortable').nestedSortable({
                handle: 'div',
                items: 'li',
                toleranceElement: '> div',
                maxLevels: 1,
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
                url: "/ajax-employees-reorder",
                type:"POST",
                data: data,
                success:function(data){
                    $('.content .apage-title').prepend('<div id="panel" class="alert success">' + data.msg + '</div>');
                    $("#panel").fadeIn( 600 ).delay( 800 ).fadeOut( 800 );
                },
                error:function(){
                    alert("Щось не так зі зміною порядку у меню");
                }
            });
        }

    </script>
@endsection