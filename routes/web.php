<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BookCopyController;
use App\Http\Controllers\Librarian\IssueController;
use App\Http\Controllers\Librarian\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\Librarian\DashboardController as LibrarianDashboard;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (any logged-in user)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Common dashboard — redirects based on role
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('librarian')) {
            return redirect()->route('librarian.dashboard');
        }

        abort(403, 'You do not have a role assigned.');
    })->name('dashboard');

    // Profile routes (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('books',      BookController::class)->except(['show']);
        Route::resource('copies',     BookCopyController::class)->except(['show']);
    });

/*
|--------------------------------------------------------------------------
| Librarian Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:librarian'])
    ->prefix('librarian')
    ->name('librarian.')
    ->group(function () {

        Route::get('/dashboard', [LibrarianDashboard::class, 'index'])->name('dashboard');



        Route::resource('students', StudentController::class)->except(['show']);

        Route::get('/issues', [IssueController::class, 'index'])->name('issues.index');
        Route::get('/issues/create',                   [IssueController::class, 'create'])->name('issues.create');
        Route::post('/issues',                         [IssueController::class, 'store'])->name('issues.store');
        Route::get('/books/{book}/available-copies',   [IssueController::class, 'availableCopies'])->name('books.availableCopies');

        // 👇 Return routes
        Route::get('/issues/{issue}/return',  [IssueController::class, 'showReturn'])->name('issues.showReturn');
        Route::put('/issues/{issue}/return',  [IssueController::class, 'returnBook'])->name('issues.return');
    });

/*
|--------------------------------------------------------------------------
| Breeze Auth Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Reports (admin + librarian)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin|librarian'])
    ->prefix('reports')
    ->name('reports.')
    ->group(function () {
        Route::get('/issued',              [ReportController::class, 'issued'])->name('issued');
        Route::get('/overdue',             [ReportController::class, 'overdue'])->name('overdue');
        Route::get('/students',            [ReportController::class, 'students'])->name('students');
        Route::get('/students/{student}',  [ReportController::class, 'studentHistory'])->name('studentHistory');
        Route::get('/inventory',           [ReportController::class, 'inventory'])->name('inventory');
    });

require __DIR__ . '/auth.php';
