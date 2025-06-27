<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Story;
use App\Models\Like;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

// Removed unused imports
use Intervention\Image\Facades\Image as Image;

class BookController extends Controller
{

public function index(Request $request)
{
    $relatedBooks = Book::withCount('views')
        ->orderByDesc('views_count')
        ->take(5)
        ->get();

    $genres = Book::select('genre1')->distinct()->pluck('genre1');
    $mostViewedByGenre = [];

    foreach ($genres as $genre) {
        $book = Book::where('genre1', $genre)
            ->orWhere('genre2', $genre)
            ->withCount('views')
            ->orderByDesc('views_count')
            ->first();

        if ($book) {
            $mostViewedByGenre[$genre] = $book;
        }
    }

    $query = Book::orderBy("created_at", "desc");

    if (!empty($request->keyword)) {
        $query->where('title', 'like', '%' . $request->keyword . '%');
    }

    // ROLE FILTER
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->role === 'author') {
            $query->where('user_id', $user->id);
        }

        // Admin sees all books, so we skip any user_id filter
    }

    $books = $query->paginate(9);

    $relatedBooks = Book::where('status', 1)
        ->take(3)
        ->inRandomOrder()
        ->get();

    return view('books.list', [
        'books' => $books,
        'relatedBooks' => $relatedBooks
    ]);
}


    public function showByGenre($genre)
    {
        $books = Book::withCount('views')  // Count views for each book
            ->where('genre1', $genre)
            ->orWhere('genre2', $genre)
            ->orderByDesc('views_count')  // Order by the count of views
            ->get();
    
        return view('genre_results', [
            'books' => $books,
            'genre' => $genre,
        ]);
    }
    
    

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:5',
            'author' => 'required|min:3',
            'status' => 'required',
            'image' => 'required|image',
            'genre1' => 'required|string|max:255',
            'genre2' => 'nullable|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('books.create')
                ->withInput()
                ->withErrors($validator);
        }

        // Save book in DB
        $book = new Book();
        $book->title = $request->title;
        $book->description = $request->description;
        $book->author = $request->author;
        $book->user_id = auth()->id(); 
        $book->status = $request->status;
        $book->genre1 = $request->genre1;
        $book->genre2 = $request->genre2;

        // Upload book image here
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('uploads/books/'), $imageName);

            $book->image = $imageName; // save the image name to the book entity
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }


    public function edit($id)
    {
        $book = Book::findOrFail($id);
        if (auth()->user()->role === 'author' && $book->user_id !== auth()->id()) {
            abort(403);
        }
        return view('books.edit', [
            'book' => $book,
        ]);
    }

    public function update(Request $request)
    {
        $book = Book::findOrFail($request->id);
        $rules = [
            'title' => 'required|min:5',
            'author' => 'required|min:3',
            'status' => 'required',
            'image' => 'image' ,
            'genre1' => 'required|string|max:255',
            'genre2' => 'nullable|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('books.edit', $book->id)
                ->withInput()
                ->withErrors($validator);
        }

        // Update book in DB
        $book->title = $request->title;
        $book->description = $request->description;
        $book->author = $request->author;
        $book->status = $request->status;
        $book->genre1 = $request->genre1;
        $book->genre2 = $request->genre2;

        // Upload book image here
        if ($request->hasFile('image')) {
            // Delete old book image
            if (File::exists(public_path('uploads/books/' . $book->image))) {
                File::delete(public_path('uploads/books/' . $book->image));
            }

            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('uploads/books/'), $imageName);
            
            $book->image = $imageName; // save the new image name to the book entity
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Request $request)
    {
        $book = Book::find($request->id);
        if (auth()->user()->role === 'author' && $book->user_id !== auth()->id()) {
            abort(403);
        }
        if ($book == null) {
            session()->flash('error', 'Book not found');
            return response()->json([
                'status' => false,
                'message' => 'Book not found'
            ]);
        } else {
            // Delete the image if it exists
            if (File::exists(public_path('uploads/books/' . $book->image))) {
                File::delete(public_path('uploads/books/' . $book->image));
            }

            $book->delete();
            session()->flash('success', 'Book deleted successfully.');
            return response()->json([
                'status' => true,
                'message' => 'Book deleted successfully.',
            ]);
        }
    }
    public function likeBook($bookId)
    {
        $book = Book::findOrFail($bookId);
        $user = auth()->user();
    
        $existingLike = Like::where('book_id', $book->id)
                            ->where('user_id', $user->id)
                            ->first();
    
        if ($existingLike) {
            $existingLike->delete(); // Unlike
        } else {
            Like::create([
                'book_id' => $book->id,
                'user_id' => $user->id,
            ]);
        }
    
        return back(); // No message
    }
    
    public function subscribeToBook($bookId)
    {
        $book = Book::findOrFail($bookId);
        $user = auth()->user();
    
        $existingSubscription = Subscription::where('book_id', $book->id)
                                            ->where('user_id', $user->id)
                                            ->first();
    
        if ($existingSubscription) {
            $existingSubscription->delete(); // Unsubscribe
        } else {
            Subscription::create([
                'book_id' => $book->id,
                'user_id' => $user->id,
            ]);
        }
    
        return back(); // No message
    }
    
    
}

