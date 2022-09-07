@extends('layouts.dashboard')

@section('content')

<h1>{{ $post->title }}</h1>

<p><strong>Creato il:</strong> {{ $post->created_at }}</p>
<p><strong>Aggiornato il:</strong> {{ $post->updated_at }}</p>
<p><strong>Slug:</strong> {{ $post->slug }}</p>

<h3 class="mt-4">Contenuto:</h3>
<p>{{ $post->content}}</p>

@endsection  