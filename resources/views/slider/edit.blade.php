@extends('adm')

@section('content')

    @if(Session::has('message'))
        <h3 class="alert">{{Session::get('message')}}</h3>
    @endif

    @if($errors->has())
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    @endif

    <h1 class="apage-title relative-apage-title">Правити слайдер</h1>

    {!! Form::open(array('url' => "/edit-slider/$slider->id",'method' => 'POST', 'class' => 'form', 'files' => true)) !!}
    <div class="form-group">
        {!! Form::label('Титул') !!}
        {!! Form::text('title', $slider->title, array('class' => 'form-control', 'placeholder' => 'Title on slide')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Лінк') !!}
        {!! Form::text('url', $slider->url, array('class' => 'form-control', 'placeholder' => 'Internal link')) !!}
    </div>

    <div class="old-slides-wrapper">
        <?php $i = 0; ?>
        @foreach($slider->slides()->get() as $slide)
            <?php $i++; ?>
            <div style="border-top: 1px solid lightgrey; padding-top: 15px" class="slide-wrapper col-md-12">
                <div class="col-md-5">
                    <div class="card-image"><img src="{{url("images/slider")}}/{{$slider->id}}/thumbnail_{{$slide->image}}"></div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {!! Form::label('Альтернативна назва слайду') !!}
                        {!! Form::text("alt_$i", $slide->alt, array('class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Титул слайду') !!}
                        {!! Form::text("slide_title_$i", $slide->title, array('class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    {!! Form::submit($slide->id, array('name' => 'delete_slide', 'class' => 'btn btn-primary')) !!}
                </div>
                {!! Form::hidden("slide_id_$i", $slide->id) !!}
            </div>
        @endforeach
        {!! Form::hidden('slides_count', $i) !!}
    </div>

    <hr>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Додати ще слайдів') !!}
            {!! Form::file('image[]', array('multiple'=>true, 'class' => 'form-control')) !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Альтернативна назва слайду') !!}
            {!! Form::text('alt', old('alt'), array('class' => 'form-control')) !!}
        </div>

        <div class="form-group">
            {!! Form::label('Титул слайду') !!}
            {!! Form::text('slide_title', old('slide_title'), array('class' => 'form-control')) !!}
        </div>
    </div>
    <hr>

    {{--{{dd($slider->slides()->get()[0])}}--}}

    <div class="form-group published-inline col-md-4">
        {!! Form::label('Опубліковано') !!}
        {!! Form::checkbox('published', 1, $slider->published, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Оновити слайдер', array('name' => 'update_slider', 'class' => 'btn btn-success pull-right')) !!}
    </div>
    {!! Form::close() !!}

@endsection