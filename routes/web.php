<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\BankSoalController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\DiscussionCommentarController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TryoutController;
use App\Http\Controllers\Admin\AdminTryoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
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
        
        // Admin Dashboard - Route utama untuk /admin
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        
        Route::prefix('materials')->group(function () {
            Route::get('/', [MateriController::class, 'indexAdmin'])->name('materials');
            Route::get('/create', [MateriController::class, 'create'])->name('materials.create');
            Route::post('/', [MateriController::class, 'store'])->name('materials.store');
            Route::get('/{material}/edit', [MateriController::class, 'edit'])->name('materials.edit');
            Route::put('/{material}', [MateriController::class, 'update'])->name('materials.update');
            Route::delete('/{material}', [MateriController::class, 'destroy'])->name('materials.destroy');
        });

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
        // Tryout Routes
        Route::prefix('tryout')
            ->name('tryout.')
            ->group(function () {
                Route::get('/', function () {
                    return view('tryout.tryout-landing-page');
                })->name('index');

                Route::get('/{tryout_id}', [TryoutController::class, 'start'])->name('start');

                Route::post('/submit/{attempt_id}', [TryoutController::class, 'submit'])->name('submit');

                Route::get('/hasil/{attempt_id}', [TryoutController::class, 'showResult'])->name('result');

                Route::get('/review/{tryout_id}', [TryoutController::class, 'review'])->name('review');

                Route::get('/{tryout_id}/learn', [TryoutController::class, 'startLearningMode'])->name('learn');

                Route::get('{tryout_id}/history', [TryoutController::class, 'showHistory'])->name('history');
            });

        Route::get('/bank-soal', [BankSoalController::class, 'index'])->name('bank-soal.index');


        // Forum
        Route::get('/forum', [DiscussionController::class, 'index'])->name('forum');
        Route::resource('discussions', DiscussionController::class)->only(['store', 'show']);
        Route::resource('discussions.comments', DiscussionCommentarController::class)
            ->shallow()
            ->only(['store', 'edit', 'update', 'destroy']);

        Route::resource('materials', MateriController::class);

        Route::get('materials/{materi}/download', [MateriController::class, 'download'])->name('materials.download');
        Route::patch('materials/{materi}/progress', [MateriController::class, 'updateProgress'])->name('materials.updateProgress');
    });

    //User & Admin Page
    Route::middleware('role:admin,user')->group(function () {
        // Dashboard
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
        // Profile Management
        Route::prefix('profile')
            ->name('profile.')
            ->group(function () {
                Route::get('/', [ProfileController::class, 'edit'])->name('edit');
                Route::patch('/', [ProfileController::class, 'update'])->name('update');
                Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
            });
    });
});

require __DIR__ . '/auth.php';