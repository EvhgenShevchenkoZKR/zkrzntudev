@extends('adm')

@section('headerstyles')
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src='/vendor/js/nested-sortable/jquery.mjs.nestedSortable.js'></script>
    <link rel="stylesheet" href="/css/admin_draggable.css">
@endsection

<span style="display: none;" href="#" id="try" data-token="{{ csrf_token() }}"></span>
@section('content')
    <h1 class="apage-title relative-apage-title">Список банерів</h1>
    {{--<table>--}}
    <ol id="sortable" class="ui-sortable fake-table">
        <?php $i = 0; ?>
        <div class="fake-thead">
            <span class="fake-th fake-25">Титло</span>
            <span class="fake-th fake-25">URL</span>
            <span class="fake-th fake-20">Зображення</span>
            <span class="fake-th fake-10">Опубліковано</span>
            <span class="fake-th fake-10">Дії</span>
        </div>
        @foreach($massonrys as $massonry)
            <li id="list_{{$massonry->id}}" class="ui-state-default col-md-12 clearfix">
                <div class="inner-div fake-trow">
                    <span class="fake-column draggable-25">
                        <span class="glyphicon glyphicon-move"></span>
                        <span class="fake-th">{{$massonry->title}}</span>
                    </span>
                    <span class="fake-column draggable-25"><a href="/{{$massonry->url}}">{{$massonry->url}}</a></span>
                    <span class="fake-column draggable-20"><img src="/images/massonry/{{$massonry->id}}/thumbnail_{{$massonry->image}}"></span>
                    <span class="fake-column draggable-10">
                        @if($massonry->published == true)
                            <span class="agreen">Так</span>
                            <span class="icn_security">
                            <a class="atable-button a-unpublish"  href="/adm/massonry/{{$massonry->id}}/unpublish">&nbsp;</a>
                        </span>
                        @else
                            <span class="ared">Ні</span>
                            <span class="icn_photo">
                            <a class="atable-button a-publish"  href="/adm/massonry/{{$massonry->id}}/publish">&nbsp;</a>
                        </span>
                        @endif
                    </span>
                    <div class='draggable-10'>
                        <span class="icn_edit">
                            <a class="atable-button" href="/adm/massonry/{{$massonry->id}}/edit">&nbsp;</a>
                        </span>
                        <span class="icn_trash">
                            <?php $locale = App::getLocale();  ?>
                            {!! Form::open(array('url' => "/adm/massonry/$massonry->id/delete", 'method' => 'delete', 'class' => 'form')) !!}
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
            console.log(r);
            var data = {
                _token:$('#try').data('token'), //todo - get some normal way of getting token
                testdata: r
            };

            $.ajax({
                url: "/ajax-massonry-reorder",
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