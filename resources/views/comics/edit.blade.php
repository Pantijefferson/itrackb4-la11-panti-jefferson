@extends('layouts.app')

@section('title', 'Edit Comic')

@section('content')
    <div class="card">
        <div class="card-body">
            <h3 class="card-title mb-3">Edit Comic </h3>

            <form method="POST" action="{{ route('comics.update', $comic) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $comic->title) }}">
                    @error('title')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" name="author" id="author" class="form-control" value="{{ old('author', $comic->author) }}">
                    @error('author')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="year" class="form-label">Year</label>
                    <input type="number" name="year" id="year" class="form-control" value="{{ old('year', $comic->year) }}" placeholder="e.g. 2020">
                    @error('year')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="genre_id" class="form-label">Genre</label>
                    <select name="genre_id" id="genre_id" class="form-select">
                        <option value="">Choose a genre</option>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}"
                                @selected(old('genre_id', $comic->genre_id) == $genre->id)
                            >{{ $genre->name }}</option>
                        @endforeach
                    </select>
                    @error('genre_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" name="price" id="price" class="form-control" value="{{ old('price', $comic->price) }}" placeholder="e.g. 19.99">
                    @error('price')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" @checked(old('is_featured', $comic->is_featured))>
                    <label for="is_featured" class="form-check-label">Featured Comic</label>
                    @error('is_featured')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save Comic</button>
                <a href="{{ route('comics.index') }}" class="btn btn-secondary">Cancel</a>

            </form>
        </div>
    </div>
@endsection