<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use Intervention\Image\ImageManager;
use Inervention\Image\Drivers\Gd\Driver;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/book/{id}',[HomeController::class, 'detail'])->name('book.detail');
Route::get('/books/genre/{genre}', [BookController::class, 'showByGenre'])->name('books.byGenre');

Route::post('/save-book-comment',[HomeController::class,'saveComment'])->name('book.saveComment');
Route::delete('/comment/{commentId}', [HomeController::class, 'deleteComment'])->name('comment.delete');        

Route::get('/book/{bookId}/story/{storyId}', [HomeController::class, 'showStoryPart'])->name('story.part');

Route::post('/book/{bookId}/track-view', [HomeController::class, 'trackView'])->name('book.trackView');
Route::get('/book/{bookId}/update-view-count', [HomeController::class, 'updateViewCount'])->name('book.updateViewCount');
Route::get('/books/most-viewed', [HomeController::class, 'mostViewed'])->name('books.most_viewed');
Route::get('/search', [HomeController::class, 'search'])->name('book.search');

Route::prefix('account')->group(function () {

    // 🔓 Guest-only routes (registration, login)
    Route::group(['middleware'=>'guest'],function(){
        Route::get('register',[AccountController::class,'register'])->name('account.register');
        
        Route::post('register',[AccountController::class,'processRegister'])->name('account.processRegister');
        Route::get('login',[AccountController::class,'login'])->name('account.login');Route::post('account/register',[AccountController::class,'processRegister'])->name('account.processRegister');
        // Forget Password (Request Email)
        Route::get('forgot_password', [AccountController::class, 'forgotPasswordForm'])->name('account.forgotPassword');
        Route::post('forgot_password', [AccountController::class, 'sendResetLink'])->name('account.sendResetLink');

        // Reset Password (after clicking email)
        Route::get('reset-password/{token}', [AccountController::class, 'resetPasswordForm'])->name('account.resetPassword');
        Route::post('reset-password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');

        Route::post('login',[AccountController::class,'authenticate'])->name('account.authenticate'); 
        Route::post('/logout', [AccountController::class, 'logout'])->name('account.logout');
    });

    // 🔐 Authenticated user routes
    Route::middleware('auth')->group(function () {
        // Account/Profile
        Route::get('profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::get('account', [AccountController::class, 'menu_account'])->name('account.menu_account');
        Route::post('update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::get('logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::post('/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::post('/request-author', [AccountController::class, 'requestAuthor'])->name('account.requestAuthor');


        // 👍 User interactions: like and subscribe
        Route::post('/book/{book}/like', [BookController::class, 'likeBook'])->name('book.like');
        Route::post('/book/{book}/subscribe', [BookController::class, 'subscribeToBook'])->name('book.subscribe');

        // Route::get('contact', [FeedbackController::class, 'showForm'])->name('home');
        Route::post('contact', [FeedbackController::class, 'submitForm'])->name('contact.submit');
    });

    // ✏️ Author (and Admin) routes - book & story management
    Route::middleware(['auth', 'role:author,admin'])->group(function () {
        // Book routes
        Route::get('books', [BookController::class, 'index'])->name('books.index');
        Route::get('books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('books', [BookController::class, 'store'])->name('books.store');
        Route::get('books/edit/{id}', [BookController::class, 'edit'])->name('books.edit');
        Route::post('books/edit/{id}', [BookController::class, 'update'])->name('books.update');
        Route::delete('books', [BookController::class, 'destroy'])->name('books.destroy');

        // Story routes
        Route::get('/books/{book}/stories', [StoryController::class, 'index'])->name('stories.index');
        Route::get('/books/{book}/stories/create', [StoryController::class, 'create'])->name('stories.create');
        Route::post('/books/{book}/stories', [StoryController::class, 'store'])->name('stories.store');
        Route::get('/books/{book}/stories/{story}/edit', [StoryController::class, 'edit'])->name('stories.edit');
        Route::put('/books/{book}/stories/{story}', [StoryController::class, 'update'])->name('stories.update');
        Route::delete('/books/{book}/stories/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');
        // Route::post('/book/{book}/like', [BookController::class, 'likeBook'])->name('book.like');
        // Route::post('/book/{book}/subscribe', [BookController::class, 'subscribeToBook'])->name('book.subscribe');

    });

    // 🛠️ Admin-only routes
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users');
     
        Route::get('/categories', [AdminController::class, 'manageCategories'])->name('admin.categories');
        Route::get('/subscriptions', [AdminController::class, 'manageSubscriptions'])->name('admin.subscriptions');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
        Route::get('/feedback', [AdminController::class, 'feedbackReports'])->name('admin.feedback');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::get('/pending-authors', [AdminController::class, 'pendingAuthors'])->name('admin.pendingAuthors');
        Route::post('/approve-author/{id}', [AdminController::class, 'approveAuthor'])->name('admin.approveAuthor');
        Route::post('/auto-approve-author/{id}', [AdminController::class, 'autoApproveAuthor'])->name('admin.autoApproveAuthor');
        Route::post('admin/toggle-approval-mode', [AdminController::class, 'toggleApprovalMode'])->name('admin.toggleApprovalMode');

        // Add more admin routes as needed
    });

});

