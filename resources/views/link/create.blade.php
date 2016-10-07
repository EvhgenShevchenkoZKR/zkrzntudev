@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Створити посилання</h1>

    {!! Form::open(['url' => 'adm/link/add', 'method' => 'POST', 'class' => 'form', 'files' => 'true']) !!}

    <div class="form-group">
        <div class="fg-streight left col-md-6">
            {!! Form::label('title', 'Титло', ['class' => 'required']) !!}
            {!! Form::text('title', old('title'), ['class' => 'form-control']) !!}
        </div>
        <div class="fg-streight right col-md-6">
            {!! Form::label('url', 'URL', ['class' => 'required']) !!}
            {!! Form::text('url', old('url'), array('class' => 'form-control')) !!}
        </div>
    </div>
    <div id="selectImage">
    <div class="form-group fg-streight left col-md-6">
        {!! Form::label('Зображення') !!}
        {!! Form::file('image', array('class' => 'form-control img-upload', 'id' => 'files')) !!}
        <output id="result" /></output>
    </div>
    </div>

    <div class="form-group fg-streight right col-md-6">
        {!! Form::label('Альт зображення') !!}
        {!! Form::text('image_alt', old('image_alt'), ['class' => 'form-control']) !!}

        {!! Form::label('Титло зображення') !!}
        {!! Form::text('image_title', old('image_title'), ['class' => 'form-control']) !!}
    </div>

    <div class="col-md-6 pull-right">
        <div class="form-group published-inline col-md-7">
            {!! Form::label('Опубліковано') !!}
            {!! Form::hidden('published', false) !!}
            {!! Form::checkbox('published', 1, true, array('class' => 'form-control')) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Зберегти', ['class' => 'btn btn-success pull-right']) !!}
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@section('footerscripts')
    <script>
        $(document).ready(function(){
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