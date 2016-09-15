@extends('adm')

@section('headerstyles')
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
@endsection
<div class="container">
    @section('content')
        {!! Form::open(array('url' => "sliders",'method' => 'POST', 'class' => 'form')) !!}
            <div>
                <div id="sortable" class="ui-sortable">
                <?php $i=0; ?>
                @foreach($sliders as $slider)
                    <?php $i++; ?>
                    <div class="ui-state-default ui-sortable-handle col-md-12 clearfix">
                        <div class="col-md-3">
                            <div class="card-image"><img src="{{url("images/slider")}}/{{$slider->id}}/thumbnail_{{$slider->slides()->get()->random()->image}}"></div>
                        </div>
                        <div class="slider-text col-md-3">
                            <div>{{$slider->title}}</div>
                            <div class="slider-url">
                                {{$slider->url}}
                            </div>
                        </div>
                        <div class="slider-weight">
                            {{--<label for="weight_{{$i}}">ID</label>--}}
                            <input type="hidden" name="weight_{{$i}}" value="{{$slider->id}}" class="form-control">
                        </div>
                        <div class="slider-edit-link col-md-3">
                            <a href="/edit-slider/{{$slider->id}}" class="">Змінити</a>
                        </div>
                        <div class="col-md-3">
                            {!! Form::submit($slider->id, array('name' => 'delete_slider', 'class' => 'btn btn-primary')) !!}
                        </div>
                    </div>
                @endforeach
                </div>

            </div>
            {!! Form::submit('Оновити слайдери', array('name' => 'reorder_sliders', 'class' => 'btn btn-primary pull-right')) !!}
        {!! Form::close() !!}
    @endsection
</div>

@section('footerscripts')
    <script>
        $(function() {
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
        });
    </script>
@endsection