@extends('landing.layouts.app')
@section('content')
    <div class="container mx-auto" style="min-height: 100vh;padding-top: 100px;">
        <h1> {{ $blog->title }}</h1>
        <small>Last Update on:{{ $blog->updated_at }}</small>
        <br>
        @foreach($blog->blog_tags as $tag)
            <b>{{ $tag->name }} {{ $loop->last?'':',' }}</b>
        @endforeach

        <p></p>
        <article class="container">
            {!! $blog->body !!}
        </article>
    </div>
@endsection
