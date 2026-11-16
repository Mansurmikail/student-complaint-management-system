
<?php

use App\Http\Controllers\ComplaintController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\StudentController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Protected student routes
Route::middleware(['auth', 'role:student'])->group(function () {

    Route::get('/home', function () {
        return view('student.dashboard');
    })->name('home');

    Route::get('/complaints', [ComplaintController::class, 'index'])
        ->name('complaints.index');

    Route::get('/complaints/create', [ComplaintController::class, 'create'])
        ->name('complaints.create');

    Route::get('/complaints/{id}', [ComplaintController::class, 'show'])
        ->name('complaints.show');

    Route::post('/complaints', [ComplaintController::class, 'store'])
        ->name('complaints.store');
});

// Protected administrator routes
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/students', [StudentController::class, 'index'])
        ->name('admin.students.index');

    Route::get('/admin/students/{id}', [StudentController::class, 'show'])
        ->name('admin.students.show');

    Route::get('/admin/students/{id}/edit', [StudentController::class, 'edit'])
        ->name('admin.students.edit');

    Route::put('/admin/students/{id}', [StudentController::class, 'update'])
        ->name('admin.students.update');

    Route::patch('/admin/students/{id}/status', [StudentController::class, 'toggleStatus'])
        ->name('admin.students.toggleStatus');

    Route::post('/admin/students/{id}/password-reset', [StudentController::class, 'sendPasswordReset'])
        ->name('admin.students.passwordReset');

    Route::get('/admin/complaints', [AdminComplaintController::class, 'index'])
        ->name('admin.complaints.index');

    // Print route must appear before the {id} route
    Route::get('/admin/complaints/print', [AdminComplaintController::class, 'printReport'])
        ->name('admin.complaints.print');

    Route::get('/admin/complaints/export-pdf', [AdminComplaintController::class, 'exportPdf'])
        ->name('admin.complaints.exportPdf');

    Route::get('/admin/complaints/{id}', [AdminComplaintController::class, 'show'])
        ->name('admin.complaints.show');

    Route::put('/admin/complaints/{id}/status', [AdminComplaintController::class, 'updateStatus'])
        ->name('admin.complaints.updateStatus');

    Route::post('/admin/complaints/{id}/response', [AdminComplaintController::class, 'storeResponse'])
        ->name('admin.complaints.storeResponse');
});
