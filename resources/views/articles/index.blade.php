@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 800px">
        @if (session('info'))
            <div class="alert alert-info">
                {{session('info')}}
            </div>
        @endif
        {{ $articles->links() }}

        @foreach ($articles as $article)
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title">{{ $article->title}}</h4>
                    <div class="text-muted" style="font-size: 0.8em">
                        <b class="text-success">{{ $article->user->name }}</b> ,
                        <b>Category:</b>{{$article->category->name}},
                        <b>Comments:</b>{{count($article->comments)}}
                        <span class="text-info">
                            {{ $article->created_at->diffForHumans()}}
                        </span>
                    </div>
                    <div class="">
                        {{ $article->body}}
                    </div>
                    <a href="{{ url("/articles/detail/$article->id")}}"
                        class="card-link">Detail</a>
                </div>
            </div>
        @endforeach
    </div>

@endsection
