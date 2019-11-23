@extends('layouts.app')

@section('title', $post->title)
@section('description', substr($post->excerpt), 0, 155))

@section('content')
    <article>
        <a href="/posts/{{ $post->slug }}">
            <h1 class="text-4xl md:text-5xl font-semibold leading-tight mb-4">{{ $post->title }}</h1>
        </a>
        <div class="mb-10">
            <span class="text-gray-600 mr-3">{{ $post->publish_date->format('M d, Y') }}</span>
            @foreach ($post->tags as $tag)
                <span class="bg-gray-300 rounded px-2 py-1 mr-1">{{ $tag->name }}</span>
            @endforeach
        </div>
        <img class="object-cover mb-10" src="{{ $post->featured_image }}">
        <div class="post-body text-xl leading-relaxed">{!! $post->body !!}</div>
    </article>
@endsection
