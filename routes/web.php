<?php

use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware(['auth', 'active-user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export', [DashboardController::class, 'export'])->name('dashboard.export');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('policies', PolicyController::class)->only(['index', 'show', 'create', 'store']);
    Route::post('/policies/{policyVersion}/acknowledge', [PolicyController::class, 'acknowledge'])->name('policies.acknowledge');
    Route::post('/policies/{policy}/archive', [PolicyController::class, 'archive'])->name('policies.archive');

    Route::get('/training', [TrainingController::class, 'index'])->name('training.index');
    Route::get('/training/{trainingVersion}', [TrainingController::class, 'show'])->name('training.show');
    Route::post('/training/assignments/{assignment}/sections/{section}/complete', [TrainingController::class, 'markSectionComplete'])->name('training.complete');
    
    Route::get('/quiz/{quizVersion}', [\App\Http\Controllers\QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{quizVersion}', [\App\Http\Controllers\QuizController::class, 'submit'])->name('quiz.submit');

    Route::get('/incidents', [IncidentController::class, 'index'])->name('incidents.index');
    Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');
    Route::post('/incidents/{incident}/resolve', [IncidentController::class, 'resolve'])->name('incidents.resolve');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::post('users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        Route::post('users/{user}/reactivate', [UserController::class, 'reactivate'])->name('users.reactivate');
        Route::get('/audit', [AuditController::class, 'index'])->name('audit.index');
    });
});
