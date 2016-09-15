@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Правити оголошення</h1>

    {!! Form::open(['url' => "adm/objava/$advert->id/edit", 'method' => 'PATCH', 'class' => 'form', 'files' => 'true']) !!}

    <div class="form-group">
        {!! Form::label('Титло') !!}
        {!! Form::text('title', $advert->title, ['class' => 'form-control']) !!}
    </div>


    <div class="image-wrapper-zone clearfix">
    <div class="old-image col-md-6">
        {!! Form::label('Поточне зображення') !!}
        <img src="/images/objavas/{{$advert->id}}/thumbnail_{{$advert->cover_image}}"/>
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('Змінити зображення') !!}
        {!! Form::file('cover_image', array('class' => 'form-control')) !!}
    </div>
    <div class="alttitle-edit-wrapper col-md-12">
    <div class="form-group col-md-6">
        {!! Form::label('Альт зображення') !!}
        {!! Form::text('cover_alt', $advert->cover_alt, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-md-6">
        {!! Form::label('Титло зображення') !!}
        {!! Form::text('cover_title', $advert->cover_title, ['class' => 'form-control']) !!}
    </div>
    </div>
    </div>

    <div class="form-group clearfix">
        {!! Form::label('body', 'Текст оголошення', ['class' => 'required']) !!}
        {!! Form::textarea('body', $advert->body, ['class' => 'form-control cke-text']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Автор оголошення') !!}
        {!! Form::text('author', $advert->author, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Мета титло') !!}
        {!! Form::text('meta_title', $advert->meta_title, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Мета ключові слова') !!}
        {!! Form::text('meta_keywords', $advert->meta_keywords, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Мета опис') !!}
        {!! Form::textarea('meta_description', $advert->meta_description, ['class' => 'form-control', 'size' => '50x3']) !!}
    </div>
    <div class="form-group published-inline col-md-4">
        {!! Form::label('Опубліковано') !!}
        {!! Form::checkbox('published', 1, $advert->published, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Зберегти', ['class' => 'btn btn-success pull-right']) !!}
    </div>
    {!! Form::close() !!}
@endsection

@section('footerscripts')
    <script src="/vendor/js/ckeditor_dark/ckeditor.js"></script>
    <script src="/vendor/js/ckeditor_dark/adapters/jquery.js"></script>
    <script>
        $(document).ready(function() {
            $('textarea.cke-text').ckeditor();
        });
    </script>
@endsection