<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    public function index(Request $request)
    {
        
        DB::enableQueryLog();

        $genres = Genre::all();      
        
        $genreId = $request->query('genre_id');
        $year = $request->query('year');

        
        $query = Comic::query();

        if ($genreId && $genreId !== 'all') {
            $query->where('genre_id', $genreId);
        }

        if ($year && $year !== 'all') {
            $query->where('year', $year);
        }

        $comics = $query->get();

        return view('comics.index', [
            'comics'   => $comics,
            'genres'   => $genres,
            'genreId'  => $genreId,
            'year'     => $year,
        ]);
    }

    public function create()
    {
        
        $genres = Genre::all();
        
        return view('comics.create', compact('genres'));
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'title'       => 'required|max:100',
            'author'      => 'required|max:100',
            'year'        => 'required|digits:4|integer|min:1000|max:' . date('Y'),
            'price'       => 'required|numeric|min:0',
            'genre_id'    => 'required|exists:genres,id', 
            'is_featured' => 'sometimes|boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        
        Comic::create($validated);

        return redirect()
            ->route('comics.index')
            ->with('success', 'Comic added successfully.');
    }

    public function show(Comic $comic)
{
    return view('comics.show', ['comic' => $comic]);
}

    public function edit(Comic $comic)
{
    $genres = Genre::all(); 
    return view('comics.edit', compact('comic', 'genres'));
}

    public function update(Request $request, Comic $comic)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'genre_id' => 'required|exists:genres,id',
    ]);

    $comic->update($validated);

    
    return redirect()->route('comics.index')->with('success', 'Comic updated successfully!');
}

    public function destroy(Comic $comic)
{
    $comic->delete();

    return redirect()->route('comics.index');
}
    public function feature()
    {
        $comic = Comic::where('is_featured', true)->first();

        return view('comics.feature', ['comic' => $comic]);
    }
}