@extends('adm')

@section('headerstyles')
    <script src='/js/chosen/chosen.jquery.min.js'></script>
    <link rel="stylesheet" type="text/css" href="/js/chosen/chosen.min.css" />
@endsection

@section('content')
    <h1 class="apage-title relative-apage-title">Створити Матеріал</h1>
    {!! Form::open(array('url' => 'adm/child/add', 'method' => 'POST', 'class' => 'form clearfix', 'files' => 'true')) !!}

    <div class="fields-wrapper">
        <div class="form-group col-md-6">
            {!! Form::label('title', 'Титло', ['class' => 'required']) !!}
            {!! Form::text('title', old('title'), array('class' => 'form-control')) !!}
        </div>

        <div class="form-group col-md-6">
            {!! Form::label('Відноситься до матеріалу') !!}
            {!! Form::select('parent_id', $parents, null, array(
            'class' => 'form-control chosen-select',
            )) !!}
        </div>
    </div>

    <div class="image-wrapper-zone clearfix">
        <div class="form-group fg-streight left col-md-3">
            <output id="result" /></output>
        </div>
        <div class="form-group fg-streight right col-md-9">
            {!! Form::label('cover_image', 'Зображення') !!}
            {!! Form::file('cover_image', array('class' => 'form-control img-upload', 'id' => 'files')) !!}

            <div class="form-group field-left col-md-6">
                {!! Form::label('Альт зображення') !!}
                {!! Form::text('cover_alt', old('cover_alt'), ['class' => 'form-control']) !!}
            </div>
            <div class="form-group field-right col-md-6">
                {!! Form::label('Титло зображення') !!}
                {!! Form::text('cover_title', old('cover_title'), ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('body', 'Текст Матеріалу', ['class' => 'required']) !!}
        {!! Form::textarea('body', old('description'), ['class' => 'form-control my-editor']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Мета титло') !!}
        {!! Form::text('meta_title', old('meta_title'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Мета ключові слова') !!}
        {!! Form::text('meta_keywords', old('meta_keywords'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Мета опис') !!}
        {!! Form::textarea('meta_description', old('meta_description'), ['class' => 'form-control', 'size' => '50x3']) !!}
    </div>
    <div class="form-group published-inline col-md-6">
        {!! Form::label('Опубліковано') !!}
        {!! Form::checkbox('published', 1, true, array('class' => 'form-control')) !!}
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
            $(function () {
                $(".chosen-select").chosen();
            });
        });
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
    </script>
@endsection