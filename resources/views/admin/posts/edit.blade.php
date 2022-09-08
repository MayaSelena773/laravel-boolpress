@extends('layouts.dashboard')

@section

    <h1>Modifica Post</h1>

    <form action="{{ route('admin.posts.update', ['post' => $post->id]) }}" method="post">
        @csrf
        @method('PUT')

    <div class="mb-3">
        <label for="title" class="form-label">Titolo</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}">
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Contenuto</label>
        <textarea class="form-control" id="content" name="content" rows="5">{{ $post->content }}</textarea>
    </div>

    <input type="submit" value="Salva modifiche">

    </form>

@endsection