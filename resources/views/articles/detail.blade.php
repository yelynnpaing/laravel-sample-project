@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 800px">
            @if(session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
            @endif
            <div class="card mb-3" style="font-size: 1.3em">
                <div class="card-body">
                    <h4 class="card-title">{{ $article->title}}</h4>
                    <div class="card-subtitle text-muted small" style="font-size: 0.8em">
                        <b class="text-success">{{ $article->user->name }}</b>
                        Category: <b>{{ $article->category->name }}</b>
                        <span class="text-info">
                            {{ $article->created_at->diffForHumans()}}
                        </span>
                    </div>
                    <p class="card-text mb-3">
                        {{ $article->body}}
                    </p>
                    @auth
                        @can('delete-article', $article)
                            <a href="{{url("/articles/edit/$article->id")}}"
                                class="btn btn-secondary btn-sm" >Edit</a>
                            <a href="{{ url("/articles/delete/$article->id")}}"
                                class="btn btn-danger btn-sm">Delete</a>
                        @endcan
                    @endauth
                </div>
            </div>
            <hr>
            <ul class="list-group">
                <li class="list-group-item active">
                    Comments
                    <span class="badge bg-info">
                        {{ count($article->comments)}}
                    </span>
                </li>
                @foreach ($article->comments as $comment )
                   <li class="list-group-item">
                        @auth
                            @can('delete-comment', $comment)
                                <a href="{{ url("/comments/delete/$comment->id") }}"
                                    class="btn-close float-end"></a>
                            @endcan
                        @endauth
                        <div class="small mt-2">
                            <b class="text-success">{{ $comment->user->name }} ... </b>
                            {{ $comment->created_at->diffForHumans() }}
                        </div>
                        {{$comment->content}}
                   </li>
                @endforeach
            </ul>
            @auth
                <form action="{{ url("/comments/add") }}" method="post">
                    @csrf
                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                    <textarea name="content" class="form-control my-2"></textarea>
                    <button class="btn btn-secondary">Add Comment</button>
                </form>
            @endauth

    </div>
@endsection
