@extends('adm')

@section('content')
    <h1 class="apage-title relative-apage-title">Створити анкету співробітника</h1>

    {!! Form::open(['url' => 'adm/employee/add', 'method' => 'POST', 'class' => 'form', 'files' => 'true']) !!}

    <div class="form-group">
        {!! Form::label('fio', 'ПІБ', ['class' => 'required']) !!}
        {!! Form::text('fio', old('fio'), ['class' => 'form-control']) !!}

    </div>

    <div class="image-wrapper-zone clearfix">
        <div class="form-group fg-streight left col-md-3">
            <output id="result" /></output>
        </div>
        <div class="form-group fg-streight right col-md-9">
            {!! Form::label('position', 'Посада', ['class' => 'required']) !!}
            {!! Form::text('position', old('position'), ['class' => 'form-control']) !!}

            {!! Form::label('photo', 'Фото', ['class' => 'required']) !!}
            {!! Form::file('photo', array('class' => 'form-control img-upload', 'id' => 'files')) !!}
        </div>
    </div>


    <div class="form-group clearfix">
        {!! Form::label('body', 'Опис', ['class' => 'required']) !!}
        {!! Form::textarea('body', old('body'), ['class' => 'form-control cke-text']) !!}
    </div>

    <div class="form-group published-inline col-md-4">
        {!! Form::label('Адміністрація') !!}
        {!! Form::hidden('administration', false) !!}
        {!! Form::checkbox('administration', 1, true, array('class' => 'form-control')) !!}
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