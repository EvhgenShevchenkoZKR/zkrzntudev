@extends('app')

@section('content')
    <h1 class="page-title">Теги</h1>
    @foreach($tags as $tag)
        <div class="tag-wrapper">
            {{$tag->title}}
        </div>
    @endforeach
@endsection