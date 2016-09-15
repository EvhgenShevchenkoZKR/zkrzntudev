@extends('app')

@section('content')
    <h1 class="page-title">{{$card->title}}</h1>
    <div class="card-body">{{$card->body}}</div>
    <div class="image-wrapper">
        {{$card->image}}
    </div>
    @if(isset($card->notes[0]))
        <hr>
        <h3 class="notes-title text-center">Notes</h3>
        @foreach($card->notes as $note)
            <hr>
            <div class="note-body">{{$note->body}}
                <a href="#"><span class="pull-right">{{$note->user->name}}</span></a>
            </div>
            <div class="image-wrapper">
                {{$card->image}}
            </div>
        @endforeach
    @endif

    <hr>
    <h3 class="text-center">Add note</h3>
    <form method="POST" action="note/store">
        <div class="form-group">
            <label for="body"></label>
            {{--<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>--}}
            {{--<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>--}}
            {{--<script>--}}
                {{--$('textarea').ckeditor();--}}
                {{--// $('.textarea').ckeditor(); // if class is prefered.--}}
            {{--</script>--}}
            {{--<textarea name="body" class="ckeditor" id="note-body" cols="40" rows="4"></textarea>--}}


            {{--<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>--}}
            {{--<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>--}}
            {{--<script>--}}
                {{--$('textarea').ckeditor({--}}
                    {{--filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',--}}
                    {{--filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',--}}
                    {{--filebrowserBrowseUrl: '/laravel-filemanager?type=Images',--}}
                    {{--filebrowserUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}'--}}
                {{--});--}}
            {{--</script>--}}

            {{--<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>--}}
            {{--<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>--}}
            {{--<textarea name="content" class="form-control my-editor"></textarea>--}}
            {{--<script>--}}
                {{--$('textarea.my-editor').ckeditor({--}}
                    {{--filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',--}}
                    {{--filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',--}}
                    {{--filebrowserBrowseUrl: '/laravel-filemanager?type=Files',--}}
                    {{--filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}'--}}
                {{--});--}}
            {{--</script>--}}

            {{--<script src="/vendor/js/ckeditor_dark/ckeditor.js"></script>--}}
            {{--<script src="/vendor/js/ckeditor_dark/adapters/jquery.js"></script>--}}

            {{--<textarea name="content" class="form-control my-editor"></textarea>--}}
            {{--<script>--}}
                {{--$('textarea.my-editor').ckeditor({--}}
                    {{--filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',--}}
                    {{--filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',--}}
                    {{--filebrowserBrowseUrl: '/laravel-filemanager?type=Images',--}}
                    {{--filebrowserUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}'--}}
                {{--});--}}
            {{--</script>--}}

            {{--working with troubles uploading --}}
            <script src="/vendor/js/ckeditor_dark/ckeditor.js"></script>
            <script src="/vendor/js/ckeditor_dark/adapters/jquery.js"></script>

            <textarea name="content" class="form-control my-editor"></textarea>
            <script>
                $('textarea.my-editor').ckeditor({
                    filebrowserBrowseUrl: '/elfinder/ckeditor',
                    {{--filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',--}}
                    {{--filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',--}}
                    {{--filebrowserBrowseUrl: '/laravel-filemanager?type=Files',--}}
                    {{--filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}'--}}
                });
            </script>
            {{--working with troubles uploading ENDS --}}
        </div>
        <div class="form-group">
            <button class="btn btn-primary pull-right" type="submit">Add Note</button>
        </div>
    </form>
@endsection