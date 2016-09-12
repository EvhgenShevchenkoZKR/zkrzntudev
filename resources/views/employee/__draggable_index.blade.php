@extends('adm')

@section('headerscripts')
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src='/js/nested-sortable/jquery.mjs.nestedSortable.js'></script>
    <link rel="stylesheet" href="/css/admin_draggable.css">
@endsection

<span style="display: none;" href="#" id="try" data-token="{{ csrf_token() }}"></span>
@section('content')
    <h1 class="apage-title relative-apage-title">{{trans('m.regions')}}</h1>
    {{--<table>--}}
    <ol id="sortable" class="ui-sortable fake-table">
        <?php $title_lang = 'title_' .  App::getLocale(); ?>
        <?php $i = 0; ?>
        <div class="fake-thead">
            <span class="fake-th fake-th-title">{{trans('m.title')}}</span>
            <span class="fake-th fake-th-alias">{{trans('m.alias')}}</span>
            <span class="fake-th fake-th-pub">{{trans('m.pub')}}</span>
            <span class="fake-th fake-th-actions">{{trans('m.actions')}}</span>
        </div>
        @foreach($regions as $region)
            <li id="list_{{$region->id}}" class="ui-state-default col-md-12 clearfix">
                <div class="inner-div fake-trow">
                    <span class="fake-column draggable-title">
                        <span class="glyphicon glyphicon-move"></span>
                        <span class="fake-th">{{$region->$title_lang}}</span>
                    </span>
                    <span class="fake-column draggable-alias">{{$region->slug}}</span>
                    <span class="fake-column graggable-pub">
                        @if($region->published == true)
                        <span class="agreen">{{trans('m.yes')}}</span>
                        <span class="icn_security">
                            <a class="atable-button a-unpublish" href="/{{App::getLocale()}}/adm/region/{{$region->id}}/unpublish">&nbsp;</a>
                        </span>
                        @else
                        <span class="ared">{{trans('m.no')}}</span>
                        <span class="icn_photo">
                            <a class="atable-button a-publish"  href="/{{App::getLocale()}}/adm/region/{{$region->id}}/publish">&nbsp;</a>
                        </span>
                        @endif
                    </span>
                    <div class='draggable-actions'>
                        <span class="icn_edit">
                            <a class="atable-button" href="/{{App::getLocale()}}/adm/region/{{$region->id}}/edit">&nbsp;</a>
                        </span>
                        <span class="icn_trash">
                            <?php $locale = App::getLocale();  ?>
                            {!! Form::open(array('url' => "/$locale/adm/region/$region->id/delete", 'method' => 'delete', 'class' => 'form')) !!}
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
                url: "/ajax-regions-reorder",
                type:"POST",
                data: data,
                success:function(data){
//                    console.log('returned');
                    console.log(data.msg);
                    console.log(data.serialized);
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