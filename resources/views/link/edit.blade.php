@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Створити посилання</h1>

    {!! Form::open(['url' => "adm/link/$link->id/edit", 'method' => 'PATCH', 'class' => 'form', 'files' => 'true']) !!}

    <div class="form-group">
        <div class="fg-streight left col-md-6">
            {!! Form::label('title', 'Титло', ['class' => 'required']) !!}
            {!! Form::text('title', $link->title, ['class' => 'form-control']) !!}
        </div>
        <div class="fg-streight right col-md-6">
            {!! Form::label('url', 'URL', ['class' => 'required']) !!}
            {!! Form::text('url', $link->url, array('class' => 'form-control')) !!}
        </div>
    </div>
    <div class="form-group fg-streight left col-md-6">
        <div class="old-image old-photo">
            {!! Form::label('Поточне Фото') !!}
            <img src="/images/links/{{$link->id}}/small_{{$link->image}}"/>
        </div>
        <div class="form-group fg-streight right">
            {!! Form::label('Змінити Зображення') !!}
            {!! Form::file('image', array('class' => 'form-control')) !!}
        </div>
    </div>
    <div class="form-group fg-streight right col-md-6">
        {!! Form::label('Альт зображення') !!}
        {!! Form::text('image_alt', $link->image_alt, ['class' => 'form-control']) !!}

        {!! Form::label('Титло зображення') !!}
        {!! Form::text('image_title', $link->image_title, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group published-inline col-md-4">
        {!! Form::label('Опубліковано') !!}
        {!! Form::checkbox('published', 1, $link->published, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Зберегти', ['class' => 'btn btn-success pull-right']) !!}
    </div>
    {!! Form::close() !!}
@endsection