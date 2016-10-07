@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Правити оголошення</h1>

    {!! Form::open(['url' => "adm/objava/$advert->id/edit", 'method' => 'PATCH', 'class' => 'form', 'files' => 'true']) !!}

    <div class="form-group">
        <div class="fg-streight left col-md-6">
            {!! Form::label('title', 'Титло', ['class' => 'required']) !!}
            {!! Form::text('title', $advert->title, array('class' => 'form-control')) !!}
        </div>
        <div class="fg-streight right col-md-6">
            {!! Form::label('Автор') !!}
            {!! Form::text('author', $advert->author, array('class' => 'form-control')) !!}
        </div>
    </div>

    <div class="image-wrapper-zone clearfix">
        <div class="old-image old-photo col-md-3">
            <div class="img-outer-wrapper">
                <div class="img-wrapper thumbnail-wrapper">
                    <img class="thumbnail"  src="/images/objavas/{{$advert->id}}/thumbnail_{{$advert->cover_image}}"/>
                </div>
            </div>
            <output id="result" /></output>
        </div>
        <div class="form-group fg-streight right col-md-9">
            {!! Form::label('cover_image', 'Зображення', ['class' => 'required']) !!}
            {!! Form::file('cover_image', array('class' => 'form-control img-upload', 'id' => 'files')) !!}

            <div class="form-group field-left col-md-6">
                {!! Form::label('Альт зображення') !!}
                {!! Form::text('cover_alt', $advert->cover_alt, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group field-right col-md-6">
                {!! Form::label('Титло зображення') !!}
                {!! Form::text('cover_title', $advert->cover_title, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>


    {{--<div class="image-wrapper-zone clearfix">--}}
    {{--<div class="old-image col-md-6">--}}
        {{--{!! Form::label('Поточне зображення') !!}--}}
        {{--<img src="/images/objavas/{{$advert->id}}/thumbnail_{{$advert->cover_image}}"/>--}}
    {{--</div>--}}
    {{--<div class="form-group col-md-6">--}}
        {{--{!! Form::label('Змінити зображення') !!}--}}
        {{--{!! Form::file('cover_image', array('class' => 'form-control')) !!}--}}
    {{--</div>--}}
    {{--<div class="alttitle-edit-wrapper col-md-12">--}}
    {{--<div class="form-group col-md-6">--}}
        {{--{!! Form::label('Альт зображення') !!}--}}
        {{--{!! Form::text('cover_alt', $advert->cover_alt, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
    {{--<div class="form-group col-md-6">--}}
        {{--{!! Form::label('Титло зображення') !!}--}}
        {{--{!! Form::text('cover_title', $advert->cover_title, ['class' => 'form-control']) !!}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

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
    <script>
        $(document).ready(function() {
            //code taken from http://stackoverflow.com/questions/20779983/multiple-image-upload-and-preview
            //allows us to preview multiple image before upload
            //also modified to create alt and title input`s
            if(window.File && window.FileList && window.FileReader)
            {
                var filesInput = document.getElementById("files");
                filesInput.addEventListener("change", function(event){
                    var files = event.target.files; //FileList object
                    var output = document.getElementById("result");
                    for(var i = 0; i< files.length; i++)
                    {
                        var file = files[i];
                        //Only pics
                        if(!file.type.match('image'))
                            continue;
                        $('.img-outer-wrapper').remove();
                        $('#result div').remove();// removing old images on uploading new
                        var picReader = new FileReader();
                        var j = 0;
                        picReader.addEventListener("load",function(event){
                            j++;
                            var picFile = event.target;
                            var div = document.createElement("div");
                            div.innerHTML = "<div class='thumbnail-wrapper'><img class='thumbnail' src='" + picFile.result + "'" +
                                    "title='" + picFile.name + "'/></div>";
                            output.insertBefore(div,null);
                        });
                        //Read the image
                        picReader.readAsDataURL(file);
                    }
                });
            }
            else
            {
                console.log("Your browser does not support File API");
            }
        });
    </script>
@endsection