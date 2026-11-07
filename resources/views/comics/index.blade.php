@extends('layouts.app')

@section('title', 'Comic Recommendations')

@section('content')

    <h2 class="mb-3">List of Recommendations</h2>

    <!-- Add Comic Button -->
    <div class="mb-3">
        <a href="{{ route('comics.create') }}" class="btn btn-primary">
            Add Comic
        </a>
    </div>

    <!-- Success Message Alert -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Active Filters Badge -->
    <div class="alert alert-light border d-flex justify-content-between align-items-center mb-3">
        <div>
            <span class="text-muted">Active filters:</span>
            <span class="badge bg-primary">Genre ID: {{ $genreId }}</span>
            <span class="badge bg-primary">Year: {{ $year }}</span>
        </div>
        <a href="{{ route('comics.index') }}" class="btn btn-sm btn-outline-secondary">Clear all</a>
    </div>

    <!-- Filter by Genre -->
    <div class="mb-3">
        <strong class="me-2">Genre:</strong>
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('comics.index', ['genre_id' => 'all', 'year' => $year]) }}"
               class="btn {{ $genreId === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">All</a>
            @foreach ($genres as $g)
                <a href="{{ route('comics.index', ['genre_id' => $g->id, 'year' => $year]) }}"
                    class="btn {{ (string) $genreId === (string) $g->id ? 'btn-primary' : 'btn-outline-primary' }}">{{ $g->name }}</a>
            @endforeach
        </div>
    </div>

    <!-- Filter by Year -->
    <div class="mb-4">
        <strong class="me-2">Year:</strong>
        <div class="btn-group btn-group-sm" role="group">
            <a href="{{ route('comics.index', ['genre_id' => $genreId, 'year' => 'all']) }}"
               class="btn {{ $year === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">All</a>
            <a href="{{ route('comics.index', ['genre_id' => $genreId, 'year' => '2001']) }}"
               class="btn {{ $year === '2001' ? 'btn-primary' : 'btn-outline-primary' }}">2001</a>
            <a href="{{ route('comics.index', ['genre_id' => $genreId, 'year' => '2014']) }}"
               class="btn {{ $year === '2014' ? 'btn-primary' : 'btn-outline-primary' }}">2014</a>
            <a href="{{ route('comics.index', ['genre_id' => $genreId, 'year' => '2016']) }}"
               class="btn {{ $year === '2016' ? 'btn-primary' : 'btn-outline-primary' }}">2016</a>
            <a href="{{ route('comics.index', ['genre_id' => $genreId, 'year' => '2017']) }}"
               class="btn {{ $year === '2017' ? 'btn-primary' : 'btn-outline-primary' }}">2017</a>
            <a href="{{ route('comics.index', ['genre_id' => $genreId, 'year' => '2018']) }}"
               class="btn {{ $year === '2018' ? 'btn-primary' : 'btn-outline-primary' }}">2018</a>
            <a href="{{ route('comics.index', ['genre_id' => $genreId, 'year' => '2020']) }}"
               class="btn {{ $year === '2020' ? 'btn-primary' : 'btn-outline-primary' }}">2020</a>
        </div>
    </div>

    <!-- Comics Table -->
    <table class="table table-striped table-bordered align-middle">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Year</th>
                <th>Genre</th>
                <th>Price</th>
                <th style="width: 150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($comics as $comic)
                <tr>
                    <td>
                        <a href="{{ route('comics.show', $comic->id) }}">
                            {{ $comic->title }}
                        </a>
                    </td>
                    <td>{{ $comic->author }}</td>
                    <td>{{ $comic->year }}</td>
                    <td>
                        <a href="{{ route('comics.index', ['genre_id' => $comic->genre_id, 'year' => $year]) }}">
                            {{ $comic->genre->name }}
                        </a>
                    </td>
                    <td>${{ number_format($comic->price, 2) }}</td>
                    
                    <!-- ACTIONS COLUMN WITH EDIT BUTTON & DELETE FORM -->
                    <td>
                        <div class="d-flex gap-1">
                            <!-- Edit Button -->
                            <a href="{{ route('comics.edit', $comic) }}" class="btn btn-warning btn-sm">Edit</a>

                            <!-- Delete Form (Part E) -->
                            <form action="{{ route('comics.destroy', $comic) }}" method="POST" 
                                  onsubmit="return confirm('Delete this record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Comics Available</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Part F Requirement: Temporary Query Counter -->
    <p>Queries: {{ count(\Illuminate\Support\Facades\DB::getQueryLog()) }}</p>

@endsection