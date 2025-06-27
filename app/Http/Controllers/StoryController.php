<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Story;
use App\Models\Like;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index($bookId, $storyId = null)
    {
        $book = Book::findOrFail($bookId);
        $stories = $book->stories()->orderBy('part')->get();
    
        // Ensure there's always a selectedStory
        // if ($storyId) {
        //     $selectedStory = Story::where('book_id', $bookId)->where('id', $storyId)->firstOrFail();
        // } else {
        //     $selectedStory = $stories->first(); // default to first story
        // }
    
        $user = auth()->user(); 
        $existingLike = Like::where('book_id', $book->id)
                            ->where('user_id', $user->id)
                            ->first();
    
        $relatedBooks = Book::where('status', 1)
                            ->inRandomOrder()
                            ->take(3)
                            ->get();
    
        return view('stories.index',[
            'book' => $book,
            'stories' => $stories,
            'relatedBooks' => $relatedBooks,
            'existingLike' => $existingLike,
            // 'selectedStory' => $selectedStory,
        ]);
    }
    



    public function create($bookId)
    {
        $book = Book::findOrFail($bookId);
        return view('stories.create', compact('book'));
    }

    public function store(Request $request, $bookId)
{
    $request->validate([
        'part' => 'required|string|max:255',
        'story' => 'required|string',
        'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
    ]);

    $story = new Story($request->all());
    $story->book_id = $bookId;

    if ($request->hasFile('pdf_file')) {
        // Store the PDF file
        $story->pdf_file = $request->file('pdf_file')->store('pdfs', 'public');
    }

    $story->save();

    return redirect()->route('stories.index', $bookId)->with('success', 'Story part added successfully.');
}

    

public function edit($bookId, $id)
{
    
    $book = Book::findOrFail($bookId);  // Find the book by ID
    $story = Story::findOrFail($id);    // Find the story by ID
    return view('stories.edit', compact('book', 'story'));  // Pass both $book and $story to the view
}


    public function update(Request $request, $bookId, $id)
    {
        $story = Story::findOrFail($id);
    
        $request->validate([
            'part' => 'required|string|max:255',
            'story' => 'required|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
        ]);
    
        $story->update($request->only('part', 'story'));
    
        if ($request->hasFile('pdf_file')) {
            $story->pdf_file = $request->file('pdf_file')->store('pdfs', 'public');
        }
    
        return redirect()->route('stories.index', $bookId)->with('success', 'Story part updated successfully.');
    }
    

    public function destroy($bookId, $id)
    {
        $story = Story::where('id', $id)->where('book_id', $bookId)->firstOrFail();
        $story->delete();
    
        return redirect()->route('stories.index', $bookId)->with('success', 'Story part deleted successfully.');
    }
    
}
