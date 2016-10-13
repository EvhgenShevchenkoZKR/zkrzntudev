@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Правити слайдер</h1>

    {!! Form::open(array('url' => "/edit-slider/$slider->id",'method' => 'POST', 'class' => 'form', 'files' => true)) !!}
    <div class="form-group">
        {!! Form::label('title', 'Титул', ['class' => 'required']) !!}
        {!! Form::text('title', $slider->title, array('class' => 'form-control', 'placeholder' => 'Title on slide')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('url', 'Лінк', ['class' => 'required']) !!}
        {!! Form::text('url', $slider->url, array('class' => 'form-control', 'placeholder' => 'Internal link')) !!}
    </div>

    <div class="old-slides-wrapper">
        <?php $i = 0; ?>
        @foreach($slider->slides()->get() as $slide)
            <?php $i++; ?>
            <div style="border-top: 1px solid lightgrey; padding-top: 15px" class="slide-wrapper col-md-12">
                <div class="col-md-3">
                    <img width="100px" height="auto" src="{{url("images/slider")}}/{{$slider->id}}/{{$slide->image}}">
                </div>
                <div class="col-md-9">
                    <div class="form-group col-md-5">
                        {!! Form::label('Альтернативна назва слайду') !!}
                        {!! Form::text("alt_$i", $slide->alt, array('class' => 'form-control')) !!}
                    </div>
                    <div class="form-group col-md-5">
                        {!! Form::label('Титул слайду') !!}
                        {!! Form::text("slide_title_$i", $slide->title, array('class' => 'form-control')) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::submit($slide->id, array('name' => 'delete_slide', 'class' => 'btn btn-primary delete-slide')) !!}
                    </div>
                </div>

                {!! Form::hidden("slide_id_$i", $slide->id) !!}
            </div>
        @endforeach
        {!! Form::hidden('slides_count', $i) !!}
    </div>

    <br>
    <hr>

    <div class="image-wrapper-zone clearfix">
        <div class="form-group fg-streight left col-md-3">
            <output id="result" /></output>
        </div>
        <div class="form-group fg-streight right col-md-9">
            {!! Form::label('image', 'Додати ще слайдів') !!}
            {!! Form::file('image[]', array('multiple'=>true, 'class' => 'form-control', 'id' => 'files')) !!}

            <div class="form-group field-left col-md-6">
                {!! Form::label('Альт зображень') !!}
                {!! Form::text('alt', old('alt'), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group field-right col-md-6">
                {!! Form::label('Титло зображень') !!}
                {!! Form::text('slide_title', old('slide_title'), ['class' => 'form-control']) !!}
            </div>
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