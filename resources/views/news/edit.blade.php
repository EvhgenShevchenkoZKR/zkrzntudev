@extends('adm')

@section('headerstyles')
    <script src='/js/chosen/chosen.jquery.min.js'></script>
    <link rel="stylesheet" type="text/css" href="/js/chosen/chosen.min.css" />
@endsection

@section('content')
    <h1 class="apage-title relative-apage-title">Правити новину</h1>
    {!! Form::open(array('url' => "adm/news/$news->id/edit", 'method' => 'POST', 'class' => 'form clearfix', 'files' => 'true')) !!}
    <div class="hidden" id="select-something">Оберiть щось</div>
    <div class="form-group">
        <div class="fg-streight left col-md-6">
            {!! Form::label('title', 'Титло', ['class' => 'required']) !!}
            {!! Form::text('title', $news->title, array('class' => 'form-control')) !!}
        </div>
        <div class="fg-streight right col-md-6">
            {!! Form::label('Автор') !!}
            {!! Form::text('author_name', $news->author_name, array('class' => 'form-control')) !!}
        </div>
    </div>

    <div class="image-wrapper-zone clearfix">
        <div class="old-image old-photo col-md-3">
            <div class="img-outer-wrapper">
                <div class="img-wrapper thumbnail-wrapper">
                    <img class="thumbnail"  src="/images/news/{{$news->id}}/thumbnail_{{$news->cover_image}}"/>
                </div>
            </div>
            <output id="result" /></output>
        </div>
        <div class="form-group fg-streight right col-md-9">
            {!! Form::label('cover_image', 'Зображення', ['class' => 'required']) !!}
            {!! Form::file('cover_image', array('class' => 'form-control img-upload', 'id' => 'files')) !!}

            <div class="form-group field-left col-md-6">
                {!! Form::label('Альт зображення') !!}
                {!! Form::text('cover_alt', $news->cover_alt, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group field-right col-md-6">
                {!! Form::label('Титло зображення') !!}
                {!! Form::text('cover_title', $news->cover_title, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('Теги') !!}
        {!! Form::select('tags[]', $tags, $selected_tags, array(
        'class' => 'form-control chosen-select',
        'multiple' => 'multiple',
        )) !!}
    </div>

    <div class="form-group">
        {!! Form::label('body', 'Текст новини', ['class' => 'required']) !!}
        {!! Form::textarea('body', $news->body, ['class' => 'form-control my-editor']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Мета титло') !!}
        {!! Form::text('meta_title', $news->meta_title, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Мета ключові слова') !!}
        {!! Form::text('meta_keywords', $news->meta_keywords, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Мета опис') !!}
        {!! Form::textarea('meta_description', $news->meta_description, ['class' => 'form-control', 'size' => '50x3']) !!}
    </div>
    <div class="form-group published-wrapper col-md-4">
        {!! Form::label('Опубліковано') !!}
        {!! Form::hidden('published', false) !!}
        {!! Form::checkbox('published', 1, $news->published, array('class' => 'form-control')) !!}
    </div>
    <div class="form-group published-wrapper col-md-4">
        {!! Form::label('Важлива новина (виводиться на головній сторінці зліва)') !!}
        {!! Form::hidden('important', false) !!}
        {!! Form::checkbox('important', 1, $news->important, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group published-wrapper col-md-4">
        {!! Form::label('В слайдер (Виводити зображення в боковому слайдері з новинами?') !!}
        {!! Form::hidden('cover_show', false) !!}
        {!! Form::checkbox('cover_show', 1, $news->cover_show, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Зберегти', array('class' => 'btn btn-success pull-right')) !!}
    </div>
    {!! Form::close() !!}
@endsection

@section('footerscripts')
    <script src="/vendor/js/ckeditor_dark/ckeditor.js"></script>
    <script src="/vendor/js/ckeditor_dark/adapters/jquery.js"></script>
    <script>
        $('textarea.my-editor').ckeditor({
            filebrowserBrowseUrl: '/elfinder/ckeditor',
        });
    </script>
    <script>
        $(document).ready(function() {
            var multi_select_label = $('#select-something').html();
            $(function(){
                $(".chosen-select").chosen({
                    placeholder_text_multiple: multi_select_label
                });
            });
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