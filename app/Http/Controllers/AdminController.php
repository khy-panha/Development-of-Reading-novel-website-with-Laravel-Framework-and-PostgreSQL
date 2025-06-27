<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
 use App\Models\Setting;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Book;
use App\Models\Like;
use App\Models\Views;
use App\Models\Story;  
 use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function pendingAuthors()
    {
        // Show users who have requested to become authors (pending status)
        $authors = User::where('author_status', 'pending')->get();
        $mode = Setting::where('key', 'author_approval_mode')->first(); // Get current approval mode
        
        // If mode not found, set to 'manual' by default
        if (!$mode) {
            $mode = 'manual';
        } else {
            $mode = $mode->value;
        }
        
        return view('admin.pending-authors', compact('authors','mode'));
    }
    
public function approveAuthor($authorId)
{
    $author = User::findOrFail($authorId);
    $author->author_status = 'approved';
    $author->role = 'author'; // ✅ This line is essential!
    $author->is_approved = true; // Optional tracking
    $author->save();

    return back()->with('success', 'Author has been approved.');
}

    
   public function autoApproveAuthor($authorId)
{
    $author = User::findOrFail($authorId);
    $author->author_status = 'approved';
    $author->role = 'author'; // ✅ This must be added
    $author->is_approved = true;
    $author->save();

    return back()->with('success', 'Author has been auto-approved.');
}
    
        public function toggleApprovalMode()
    {
        // Get the current setting for 'author_approval_mode'
        $mode = Setting::where('key', 'author_approval_mode')->first();

        // Toggle between 'manual' and 'auto'
        if (!$mode || $mode->value == 'auto') {
            $modeValue = 'manual'; // Set to manual if it was previously auto or doesn't exist
        } else {
            $modeValue = 'auto'; // Set to auto if it was previously manual
        }

        // Update the approval mode in the settings table
        Setting::updateOrCreate(
            ['key' => 'author_approval_mode'],
            ['value' => $modeValue]
        );

        // Redirect back to the admin dashboard or pending authors page
        session(['approval_mode' => $mode]); // Or use a database setting
        return back()->with('success', 'Approval mode changed.');
    }
         
    public function index()
    {
        $authors = User::where('author_status', 'pending')->get();
        $mode = Setting::where('key', 'author_approval_mode')->first(); // Get current approval mode

        // Get the current approval mode from the settings table
        $modeSetting = Setting::where('key', 'author_approval_mode')->first(); 
    
        // If mode not found, set to 'manual' by default
        $mode = $modeSetting ? $modeSetting->value : 'manual';  

        $feedbacks = Feedback::all();

        $totalSubscriptions = Subscription::count();
        $totalUsers = User::whereNotNull('email')->count();
        $totalBooks = Book::count();
        $totalLikes = Like::count();
        $totalViews = Views::count();

            // Query to fetch the top subscribed books
        $topSubscribedBooks = DB::table('books')
                ->join('subscriptions', 'books.id', '=', 'subscriptions.book_id') // Assuming 'book_id' is the foreign key in subscriptions
                ->select('books.id', 'books.title', 'books.author', DB::raw('COUNT(subscriptions.id) as subscription_count'))
                ->groupBy('books.id', 'books.title', 'books.author')
                ->orderByDesc('subscription_count')
                ->limit(10) // Get top 10 most subscribed books
                ->get();

        // Query to fetch book uploads per day (for the graph)
        $booksPerDay = DB::table('books')
                ->select(DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD') as day"), DB::raw("COUNT(*) as count"))
                ->groupBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD')"))
                ->orderBy(DB::raw("TO_CHAR(created_at, 'YYYY-MM-DD')"))
                ->pluck('count', 'day');

        // Query for subscription trends (for graph)
        $subscriptionTrends = DB::table('subscriptions')
                ->select(DB::raw("COUNT(*) as count"))
                ->pluck('count');

        $users = User::all();  
        $books = Book::all();  
        $stories = Story::with('book')->get();

        // Pass the mode to the view
        return view('admin.dashboard', compact(
            'mode',
            'totalUsers',
            'totalBooks',
            'totalLikes',
            'totalViews',
            'totalSubscriptions',
            'users',   
            'books',   
            'stories',
            'authors',
            'mode', 
            'subscriptionTrends',
            'booksPerDay',
            'topSubscribedBooks' ,
            'feedbacks'
        ));
    }
   
    public function manageUsers()
        {
            $users = User::all(); // or paginate if needed
            $authors = User::where('role', 'author')->get(); // This provides the $authors variable

            return view('admin.users', compact('users', 'authors'));
        }


    public function feedbackReports()
    {
        return view('admin.feedback');
    }

    public function settings()
    {
        return view('admin.settings');
    }  
        
}
