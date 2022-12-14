@extends('layouts.dashboard')

@section('content')

    <h1>Modifica Post</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.posts.update', ['post' => $post->id]) }}" method="post">
        @csrf
        @method('PUT')

    <div class="mb-3">
        <label for="title" class="form-label">Titolo</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}">
    </div>

    <div class="mb-3">
        <label for="category_id">Categoria</label>
        <select class="form-select" id="category_id" name="category_id">
            <option value="">Nessuna</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $post->category->id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option> 
            @endforeach
        </select>
    </div>

    <div class="form-check">
        <h5>Tags:</h5>

        @foreach ($tags as $tag)
        @if ($errors->any())
        {{--Se ci sono errori di validazione valuto la old, per lasciare il checked selezionato --}}
        <div class="form-check">

            <input class="form-check-input" 
            type="checkbox" 
            value="{{ $tag->id }}" 
            id="tag-{{ $tag->id }}" 
            name="tags[]"
            {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>

            <label class="form-check-label" for="tag-{{ $tag->id }}">
                {{$tag->name}}
            </label>
        </div>
            
        @else
        {{--Altrimenti carico la collection dei tag --}}
        <div class="form-check">

            <input class="form-check-input" 
            type="checkbox" 
            value="{{ $tag->id }}" 
            id="tag-{{ $tag->id }}" 
            name="tags[]"
            {{ $post->tags->contains($tag) ? 'checked' : '' }}>

            <label class="form-check-label" for="tag-{{ $tag->id }}">
                {{$tag->name}}
            </label>
        </div>
            
        @endif
        @endforeach
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Contenuto</label>
        <textarea class="form-control" id="content" name="content" rows="5">{{ old('content', $post->content) }}</textarea>
    </div>

    <input type="submit" value="Salva modifiche">

    </form>

@endsection