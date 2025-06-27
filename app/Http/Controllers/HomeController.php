<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Story;
use App\Models\Comment;
use App\Models\Views;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;
use Illuminate\Support\Facades\Log; // Import the Log facade

class HomeController extends Controller
{
    public function index()
    {
        $apiBooks = []; // Initialize as empty array
        try {
            $response = Http::timeout(20)->get('https://www.googleapis.com/books/v1/volumes?q=harry+potter');

            if ($response->successful()) {
                $apiResponse = $response->json(); // Get the whole JSON structure
                $apiBooks = $apiResponse['items'] ?? []; // Use null coalescing and check for 'items'
            } else {
                Log::warning('Google Books API error: ' . $response->status()); // Log the error status
            }
        } catch (\Exception $e) {
            Log::error('Google Books API exception: ' . $e->getMessage());
            // $apiBooks remains an empty array
        }


        $books = Book::with('stories') // eager load stories
        ->get()
        ->sortByDesc(function ($book) {
            $latestStory = $book->stories->sortByDesc('created_at')->first();
            return $latestStory && $latestStory->created_at > $book->created_at
                ? $latestStory->created_at
                : $book->created_at;
        })
        ->take(6);

        $popularBooks = Book::where('status', 1)
        ->orderByDesc('view_count')
        ->take(6)
        ->get();

    $relatedBooks = Book::where('status', 1)->inRandomOrder()->take(6)->get();
    $randomBook = $books->random();
    return view('home', [
        'apiBooks' => $apiBooks,
        'relatedBooks' => $relatedBooks,
        'books' => $books,
        'popularBooks' => $popularBooks,
         'randomBook'=>$randomBook
    ]);
    }

    public function showStoryPart($bookId, $storyId)
    {
        $relatedBooks = Book::where('status', 1)->inRandomOrder()->take(3)->get();

        // Fetch the book and its related stories.  Eager load the stories.
        $book = Book::with('stories')->findOrFail($bookId);

        // Get all stories, ordered by part (or ID).  Use sortByDesc for consistency
        $stories = $book->stories->sortBy('part')->values();

        // Get the current story
        $story = $stories->firstWhere('id', $storyId);
        if (!$story) {
            abort(404, 'Story not found in this book');
        }

        // Get current index
        $currentIndex = $stories->search(function ($s) use ($storyId) {
            return $s->id == $storyId;
        });

        // Determine prev and next stories
        $prevStory = $currentIndex > 0 ? $stories[$currentIndex - 1] : null;
        $nextStory = $currentIndex < $stories->count() - 1 ? $stories[$currentIndex + 1] : null;

        // Track the view
        $this->trackView($bookId);

        // Pass everything to view
        return view('showstories', compact('book', 'story', 'prevStory', 'nextStory', 'relatedBooks'));
    }

    //This method will show book detail page
    public function detail($id)
    {
        $book = Book::with([
            'stories',
            'comments' => function ($query) {
                $query->latest(); // Order comments by created_at DESC
            },
            'comments.user'
        ])->findOrFail($id);

        $relatedBooks = Book::where('status', 1)->inRandomOrder()->take(3)->get();
        $viewCount = Views::where('book_id', $id)->count();

        // Track the view
        $this->trackView($id);

        // Update view count on the model
        $book->view_count = $viewCount;
        $book->save();

        return view('book-detail', [
            'book' => $book,
            'relatedBooks' => $relatedBooks,
            'viewCount' => $viewCount,
            'stories' => $book->stories,
        ]);
    }
    //this will save comment
    public function saveComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'book_id' => 'required|exists:books,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'false',
                'errors' => $validator->errors(),
            ]);
        }

        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->rating = $request->rating;
        $comment->user_id = Auth::user()->id;
        $comment->book_id = $request->book_id;
        $comment->save();
   

        session()->flash('success', 'Comment submitted successfully');
        return redirect()->route('book.detail', $request->book_id);
    }
    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        // Check if the logged-in user is either the author of the comment or the author of the book
        if (auth()->user()->id == $comment->user_id || auth()->user()->id == $comment->book->user_id) {
            // Delete the comment
            $comment->delete();

            return redirect()->route('book.detail', $comment->book->id)->with('success', 'Comment deleted successfully');
        } else {
            return redirect()->route('book.detail', $comment->book->id)->with('error', 'You are not authorized to delete this comment');
        }
    }

    private function trackView($bookId)
    {
        if (Auth::check()) {
            Views::firstOrCreate(
                [
                    'book_id' => $bookId,
                    'user_id' => Auth::id(), // Safer than Auth::user()->id
                ],
                [
                    'viewed_at' => now(),
                ]
            );
        }
    }
    

    public function updateViewCount($bookId)
    {
        $book = Book::findOrFail($bookId);
        // Count views for this book
        $viewCount = Views::where('book_id', $bookId)->count();
        $mostViewedBooks = Book::where('status', 1)->orderByDesc('view_count')->take(6)->get();
        // Update the book's view count (if you want to store it in a column on the Book model)
        $book->view_count = $viewCount;
        $book->save();

        return response()->json([
            'success' => true,
            'view_count' => $viewCount
        ]);
    }
    public function mostViewedBooks()
    {
        $books = Book::orderByDesc('view_count')
            ->where('status', 'published') // optional: filter published books
            ->take(10)
            ->get();

        return view('books.most_viewed', compact('books'));
    }
    
    public function search(Request $request)
    {
        $apiBooks = [];
        try {
            $response = Http::timeout(20)->get('https://www.googleapis.com/books/v1/volumes?q=harry+potter');
    
            if ($response->successful()) {
                $apiResponse = $response->json();
                $apiBooks = $apiResponse['items'] ?? [];
            } else {
                Log::warning('Google Books API error: ' . $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Google Books API exception: ' . $e->getMessage());
        }
    
        $query = $request->input('keyword');
        $relatedBooks = Book::where('status', 1)->inRandomOrder()->take(3)->get();
        $books = Book::where('status', 1)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                    ->orWhere('genre1', 'like', '%' . $query . '%')
                    ->orWhere('author', 'like', '%' . $query . '%');
            })
            ->latest()
            ->paginate(10);
    
        return view('list_books', [  // Change the view to 'search'
            'books' => $books,
            'apiBooks' => $apiBooks,
            'relatedBooks' => $relatedBooks,
            'query' => $query,
        ]);
    }
}

