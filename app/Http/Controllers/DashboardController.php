<?php
namespace App\Http\Controllers;

use App\Services\TotalService;

class DashboardController extends Controller
{
    protected $totalService;

    public function __construct(TotalService $totalService)
    {
        $this->totalService = $totalService;
    }

    public function index()
    {
        // Get totals
        $totalUsers = $this->totalService->totalUsers();
        $totalBooks = $this->totalService->totalBooks();
        $totalLikes = $this->totalService->totalLikes();
        $totalViews = $this->totalService->totalViews();
        $totalLikesOnBooks = $this->totalService->totalLikesOnBooks();
        $totalViewsOnBooks = $this->totalService->totalViewsOnBooks();

        return view('dashboard', compact(
            'totalUsers',
            'totalBooks',
            'totalLikes',
            'totalViews',
            'totalLikesOnBooks',
            'totalViewsOnBooks'
        ));
    }
}
