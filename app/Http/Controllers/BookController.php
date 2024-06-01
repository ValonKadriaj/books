<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return response()->json(['books' => Book::all()]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateBook($request);
        $validated['user_id'] = auth()->user()->id;
        $book = Book::create($validated);

        return response()->json(['success' => 'Book created successfully.', 'book' => $book]);
    }
 
    public function update(Request $request)
    {
        $validated = $this->validateBook($request);
        $book = Book::findOrFail($request->id);
        $book->update($validated);
        return response()->json(['success' => 'Book has been updated successfully.', 'book' => $book]);
    }

   
    public function destroy(Request $request)
    {
        $book = Book::findOrFail($request->id);
        $book->delete();
        return response()->json(['success' => 'Book has been deleted successfully.']);
    }
    public function validateBook($request)  
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author' => 'required|string|max:255',
        ]);
    }
}
