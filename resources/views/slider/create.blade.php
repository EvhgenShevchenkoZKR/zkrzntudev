@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Створити новий слайдер</h1>

    {!! Form::open(array('url' => 'create-slider','method' => 'POST', 'class' => 'form', 'files' => true)) !!}
    <div class="form-group">
        {!! Form::label('title', 'Титул', ['class' => 'required']) !!}
        {!! Form::text('title', old('title'), array('class' => 'form-control', 'placeholder' => 'Title on slide')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('url', 'Лінк', ['class' => 'required']) !!}
        {!! Form::text('url', old('url'), array('class' => 'form-control', 'placeholder' => 'Internal link')) !!}
    </div>

    <hr>

    {!! Form::label('Додати слайди до нового слайдеру') !!}
    <div class="image-wrapper-zone clearfix">
        <div class="form-group fg-streight left col-md-3">
            <output id="result" /></output>
        </div>
        <div class="form-group fg-streight right col-md-9">
            {!! Form::label('image', 'Слайд', ['class' => 'required']) !!}
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

    <div class="form-group published-inline col-md-4">
        {!! Form::label('Опубліковано') !!}
        {!! Form::checkbox('published', 1, false, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Створити слайдер', array('class' => 'btn btn-success pull-right')) !!}
    </div>
    {!! Form::close() !!}
@endsection

@section('footerscripts')
    <script>
        $(document).ready(function() {
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
        });
    </script>
@endsection