<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\TrainerWebController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\QuoteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Dashboard - all authenticated; content differs by role in view
    Route::get('/', function () {
        $stats = null;
        if (auth()->user()->role === 'admin') {
            $stats = [
                'members_count' => DB::table('members')->count(),
                'plans_count' => DB::table('plans')->count(),
                'trainers_count' => DB::table('trainers')->count(),
                'workouts_count' => DB::table('workouts')->count(),
            ];
        }
        return view('dashboard', ['stats' => $stats]);
    })->name('dashboard');

    // Quote proxy (avoids CORS; returns { "text", "author" })
    Route::get('quote', QuoteController::class)->name('quote');

    // Plans - view list and detail (all roles)
    Route::get('plans', [PlanController::class, 'index'])->name('plans');
    Route::get('plans/show/{id}', [PlanController::class, 'show'])->name('plans.show');

    // Trainers - view list and detail (all roles)
    Route::get('trainers', [TrainerWebController::class, 'index'])->name('trainers');
    Route::get('trainers/show/{id}', [TrainerWebController::class, 'show'])->name('trainers.show');

    // Bookings - user books for themselves; admin sees all
    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');

    // Admin-only: members, plan/trainer/workout management
    Route::middleware(['role:admin'])->group(function () {
        Route::get('members', [MemberController::class, 'index'])->name('members');
        Route::get('add_member', [MemberController::class, 'create'])->name('add_member');
        Route::post('store_member', [MemberController::class, 'store'])->name('store_member');
        Route::post('delete_member', [MemberController::class, 'delete'])->name('delete_member');
        Route::post('edit_member', [MemberController::class, 'edit'])->name('edit_member');
        Route::post('update_member', [MemberController::class, 'update'])->name('update_member');
        Route::post('file_add', [MemberController::class, 'file_add'])->name('file_add');
        Route::post('process', [MemberController::class, 'process'])->name('process');
        Route::post('upload_member_photo', [MemberController::class, 'uploadPhoto'])->name('upload_member_photo');

        Route::get('add_plan', [PlanController::class, 'create'])->name('add_plan');
        Route::post('store_plan', [PlanController::class, 'store'])->name('store_plan');
        Route::post('edit_plan', [PlanController::class, 'edit'])->name('edit_plan');
        Route::post('update_plan', [PlanController::class, 'update'])->name('update_plan');
        Route::post('delete_plan', [PlanController::class, 'delete'])->name('delete_plan');

        Route::get('add_trainer', [TrainerWebController::class, 'create'])->name('add_trainer');
        Route::post('store_trainer', [TrainerWebController::class, 'store'])->name('store_trainer');
        Route::post('edit_trainer', [TrainerWebController::class, 'edit'])->name('edit_trainer');
        Route::post('update_trainer', [TrainerWebController::class, 'update'])->name('update_trainer');
        Route::post('delete_trainer', [TrainerWebController::class, 'delete'])->name('delete_trainer');

        Route::get('workouts', [WorkoutController::class, 'index'])->name('workouts');
        Route::get('add_workout', [WorkoutController::class, 'create'])->name('add_workout');
        Route::post('store_workout', [WorkoutController::class, 'store'])->name('store_workout');
        Route::post('delete_workout', [WorkoutController::class, 'delete'])->name('delete_workout');
    });
});
