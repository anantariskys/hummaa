<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\BankSoalController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\DiscussionCommentarController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TryoutController;
use App\Http\Controllers\Admin\AdminTryoutController;
use App\Http\Controllers\Admin\AdminMateriController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return view('home.welcome');
})->name('home');

// Google Auth Routes - Only for guests
Route::middleware('guest')->group(function () {
    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth-google-callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

// Protected Routes - Require Authentication
Route::middleware(['auth', 'verified'])->group(function () {

    //Admin Page
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        
        // Admin Dashboard

        // Admin Dashboard - Route utama untuk /admin
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard');
        
        // Admin Materials Routes

        Route::prefix('materials')->group(function () {
            Route::get('/', [AdminMateriController::class, 'index'])->name('materials.index');
            Route::get('/create', [AdminMateriController::class, 'create'])->name('materials.create');
            Route::post('/', [AdminMateriController::class, 'store'])->name('materials.store');
            Route::get('/{material}/edit', [AdminMateriController::class, 'edit'])->name('materials.edit');
            Route::put('/{material}', [AdminMateriController::class, 'update'])->name('materials.update');
            Route::delete('/{material}', [AdminMateriController::class, 'destroy'])->name('materials.destroy');
        });

        // Admin Tryout Routes
        Route::prefix('tryout')->group(function () {
            Route::get('/', [AdminTryoutController::class, 'index'])->name('tryout.index');
            Route::get('/create', [AdminTryoutController::class, 'create'])->name('tryout.create');
            Route::post('/', [AdminTryoutController::class, 'store'])->name('tryout.store');
            Route::get('/{tryout_id}', [AdminTryoutController::class, 'show'])->name('tryout.show');
            Route::get('/{tryout_id}/edit', [AdminTryoutController::class, 'edit'])->name('tryout.edit');
            Route::put('/{tryout_id}', [AdminTryoutController::class, 'update'])->name('tryout.update');
            Route::delete('/{tryout_id}', [AdminTryoutController::class, 'destroy'])->name('tryout.destroy');

            // Routes untuk manajemen soal
            Route::prefix('{tryout_id}/questions')->name('tryout.questions.')->group(function () {
                Route::get('/create', [AdminTryoutController::class, 'createQuestion'])->name('create');
                Route::post('/', [AdminTryoutController::class, 'storeQuestion'])->name('store');
                Route::get('/{question_id}/edit', [AdminTryoutController::class, 'editQuestion'])->name('edit');
                Route::put('/{question_id}', [AdminTryoutController::class, 'updateQuestion'])->name('update');
                Route::delete('/{question_id}', [AdminTryoutController::class, 'destroyQuestion'])->name('destroy');
            });
        });

        Route::prefix('events')->group(function () {
            Route::get('/', [EventsController::class, 'index'])->name('events.index');
            Route::get('/create', [EventsController::class, 'create'])->name('events.create');
            Route::post('/', [EventsController::class, 'store'])->name('events.store');
            Route::get('/{event}', [EventsController::class, 'show'])->name('events.show');
            Route::get('/{event}/edit', [EventsController::class, 'edit'])->name('events.edit');
            Route::put('/{event}', [EventsController::class, 'update'])->name('events.update');
            Route::delete('/{event}', [EventsController::class, 'destroy'])->name('events.destroy');
        });

        // Route::prefix('questions')->group(function () {
        //     Route::get('/', [QuestionController::class, 'index'])->name('questions');
        //     Route::get('/create', [QuestionController::class, 'create'])->name('questions.create');
        //     Route::post('/', [QuestionController::class, 'store'])->name('questions.store');
        //     Route::get('/{question}', [QuestionController::class, 'show'])->name('questions.show');
        //     Route::get('/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
        //     Route::put('/{question}', [QuestionController::class, 'update'])->name('questions.update');
        //     Route::delete('/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
        // });

    });

    //User Page
    Route::middleware('role:user')->group(function () {
        // Tryout Routes - UPDATED LINE
        Route::prefix('tryout')->name('tryout.')->group(function () {
            // Changed from closure to controller method
            Route::get('/', [TryoutController::class, 'index'])->name('index');
            
            Route::get('/{tryout_id}', [TryoutController::class, 'start'])->name('start');
            Route::post('/submit/{attempt_id}', [TryoutController::class, 'submit'])->name('submit');
            Route::get('/hasil/{attempt_id}', [TryoutController::class, 'showResult'])->name('result');
            Route::get('/review/{tryout_id}', [TryoutController::class, 'review'])->name('review');
            Route::get('/{tryout_id}/learn', [TryoutController::class, 'startLearningMode'])->name('learn');
            Route::get('{tryout_id}/history', [TryoutController::class, 'showHistory'])->name('history');
        });

        Route::get('/bank-soal', [BankSoalController::class, 'index'])->name('bank-soal.index');

        // Forum Routes
        Route::get('/forum', [DiscussionController::class, 'index'])->name('forum');
        Route::resource('discussions', DiscussionController::class)->only(['store', 'show']);
        Route::resource('discussions.comments', DiscussionCommentarController::class)
            ->shallow()
            ->only(['store', 'edit', 'update', 'destroy']);

        // ============================================
        // USER MATERIALS ROUTES - UPDATED
        // ============================================
        Route::prefix('materials')->name('materials.')->group(function () {
            Route::get('/', [MateriController::class, 'index'])->name('index');
            Route::get('/{materi}', [MateriController::class, 'show'])->name('show');
            Route::get('/{materi}/view', [MateriController::class, 'view'])->name('view');
            Route::get('/{materi}/download', [MateriController::class, 'download'])->name('download');
            Route::patch('/{materi}/progress', [MateriController::class, 'updateProgress'])->name('updateProgress');
        });
    });

    //User & Admin Page
    Route::middleware('role:admin,user')->group(function () {
        // Dashboard
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
        
        // Profile Management
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'edit'])->name('edit');
            Route::patch('/', [ProfileController::class, 'update'])->name('update');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        });
    });
});

require __DIR__ . '/auth.php';