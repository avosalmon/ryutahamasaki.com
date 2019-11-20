@extends('layouts.app')

@section('content')
    @foreach ($posts as $post)
        <article class="mb-10">
            <a class="flex flex-col md:flex-row" href="/posts/{{ $post->slug }}">
                <img class="object-cover mb-2 md:h-48 md:w-48 md:mr-10" src="{{ $post->featured_image }}">
                <div>
                    <h1 class="text-2xl font-semibold leading-tight mb-2">{{ $post->title }}</h1>
                    <p class="text-gray-600 mb-4">{{ $post->publish_date->format('M d, Y') }}</p>
                    <p class="leading-relaxed hidden md:block">{{ $post->excerpt }}</p>
                </div>
            </a>
        </article>
    @endforeach
@endsection
