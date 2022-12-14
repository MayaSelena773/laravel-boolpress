@extends('layouts.dashboard')

@section('content')

<h1>{{ $post->title }}</h1>

<p><strong>Creato il:</strong> {{ $post->created_at->format('j F Y') }}</p>
<p><strong>Aggiornato il:</strong> {{ $post->updated_at->format('j F Y') }}</p>
<p><strong>Slug:</strong> {{ $post->slug }}</p>
<p><strong>Categoria:</strong>{{ $post->category ? $post->category->name : ' nessuna' }}</p>
<div>
    <p><strong>Tags:</strong></p>

    @forelse ($post->tags as $tag)
        {{ $tag->name }}{{ !$loop->last ? ',' : ''}}
    @empty
        nessuno
    @endforelse
</div>

<h3 class="mt-4">Contenuto:</h3>
<p>{{ $post->content}}</p>

<a class="btn btn-primary" href="{{ route('admin.posts.edit', ['post' => $post->id]) }}">Modifica post</a>

<form class="mt-2" action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="post">
    @csrf  
    @method('DELETE')

    <input class="btn btn-danger" type="submit" value="Cancella post" onClick="return confirm('Sei sicuro di voler cancellare?');">
</form>

@endsection  