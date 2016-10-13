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
            <span class="fake-th fake-25">ПІБ</span>
            <span class="fake-th fake-25">Слайд</span>
            <span class="fake-th fake-20">URL</span>
            <span class="fake-th fake-15">Опублiковано</span>
            <span class="fake-th fake-15">Дії</span>
        </div>
        @foreach($sliders as $slider)
            <li id="list_{{$slider->id}}" class="ui-state-default col-md-12 clearfix">
                <div class="inner-div fake-trow">
                    {{-- Title --}}
                    <span class="fake-column fake-25">
                        <span class="glyphicon glyphicon-move"></span>
                        <span class="fake-th">{{$slider->title}}</span>
                    </span>

                    {{-- Slide --}}
                    <span class="fake-column fake-20">
                    @php $sl = $slider->slides()->get()->random(); @endphp
                    <img width="100px" height="auto" src="{{url("images/slider")}}/{{$slider->id}}/{{$sl->image}}">
                    </span>

                    {{-- Url --}}
                    <span class="fake-column fake-25">{{$slider->url}}</span>

                    {{-- Published --}}
                    <span class="fake-column fake-15 graggable-pub">
                        @if($slider->published == true)
                            <span class="agreen">Так</span>
                            <span class="icn_security">
                                <a class="atable-button a-unpublish" href="/adm/slider/{{$slider->id}}/unpublish">&nbsp;</a>
                            </span>
                        @else
                            <span class="ared">Ні</span>
                            <span class="icn_photo">
                                <a class="atable-button a-unpublish" href="/adm/slider/{{$slider->id}}/publish">&nbsp;</a>
                            </span>
                        @endif
                    </span>
                    {{-- Actions --}}
                    <div class='draggable-actions fake-15'>
                        <span class="icn_edit">
                            <a class="atable-button" href="/edit-slider/{{$slider->id}}">&nbsp;</a>
                        </span>
                        <span class="icn_trash">
                            <?php $locale = App::getLocale();  ?>
                            {!! Form::open(array('url' => "/adm/slider/$slider->id/delete", 'method' => 'delete', 'class' => 'form')) !!}
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
                url: "/ajax-slider-reorder",
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