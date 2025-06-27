<?php
namespace App\Services;

use App\Models\Book;
use App\Models\User;
use App\Models\BookLike;
use App\Models\BookView;

class TotalService
{
    // Get total users
    public function totalUsers()
    {
        return User::count();
    }

    // Get total books
    public function totalBooks()
    {
        return Book::count();
    }

    // Get total likes
    public function totalLikes()
    {
        return BookLike::count();
    }

    // Get total views
    public function totalViews()
    {
        return BookView::count();
    }

    // Get total likes across all books (assuming there's a 'likes' column on the Book model)
    public function totalLikesOnBooks()
    {
        return Book::sum('likes');
    }

    // Get total views across all books (assuming there's a 'views' column on the Book model)
    public function totalViewsOnBooks()
    {
        return Book::sum('views');
    }
}
