<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;




Route::get('/', function () {
    return view('splash');
})->name('splash');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome-portal');

Route::get('/signup-portal', function () {
    return view('signup.signup');
})->name('signup-portal');



//Signup Route Process
Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');

//Login Route Process
Route::post('/login-user', [SignupController::class, 'LoginUser'])->name('login.user');

//Login Page
Route::get('/login', function () {
    return view('welcome');
})->name('login');

//Logout Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('welcome-portal')->with('success', 'Logged out successfully!');
})->name('logout');

//User Dashboard
Route::get('/user-dashboard', [UserController::class, 'dashboard'])
    ->middleware('auth')
    ->name('user.dashboard');

//User Document Requests
Route::get('/my-requests', [UserController::class, 'myRequests'])
    ->middleware('auth')
    ->name('user.requests');

//Request Document Routes
Route::post('/request-document', [UserController::class, 'requestDocument'])
    ->middleware('auth')
    ->name('user.request.document');

//Individual Document Request Pages
Route::get('/request/indigency', [UserController::class, 'requestIndigency'])
    ->middleware('auth')
    ->name('user.request.indigency');

Route::get('/request/agricultural', [UserController::class, 'requestAgricultural'])
    ->middleware('auth')
    ->name('user.request.agricultural');

Route::get('/request/barangay', [UserController::class, 'requestBarangay'])
    ->middleware('auth')
    ->name('user.request.barangay');

Route::get('/request/business', [UserController::class, 'requestBusiness'])
    ->middleware('auth')
    ->name('user.request.business');

Route::get('/request/good-moral', [UserController::class, 'requestGoodMoral'])
    ->middleware('auth')
    ->name('user.request.good-moral');

//Admin Dashboard
Route::get('/admin-portal', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'admin'])->name('home.admin');

// Main Admin Dashboard with Statistics
Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');


Route::get('/dashboard', [AdminController::class, 'indigency'])
    ->middleware(['auth', 'admin'])
    ->name('dashboard.portal');


Route::get('/add-user', function () {
    return view('portals.add-user');
})->middleware(['auth', 'admin'])->name('add-user.portal');

Route::post('/add-user', [AdminController::class, 'storeResident'])
    ->middleware(['auth', 'admin'])
    ->name('admin.store-resident');

Route::get('/agri-dashboard', function () {
    return view('portals.agriculture-cert');
})->middleware(['auth', 'admin'])->name('dashboard.agriculture');


Route::get('/residents', [AdminController::class, 'residentsList'])
    ->middleware(['auth', 'admin'])
    ->name('dashboard-residents.residents');

Route::get('/residents/{id}/id-file', [AdminController::class, 'viewResidentIdFile'])
    ->middleware(['auth', 'admin'])
    ->name('admin.residents.id-file');

Route::put('/residents/{id}', [AdminController::class, 'updateResident'])
    ->middleware(['auth', 'admin'])
    ->name('admin.residents.update');

Route::delete('/residents/{id}', [AdminController::class, 'archiveUser'])
    ->middleware(['auth', 'admin'])
    ->name('admin.residents.delete');

Route::post('/users/{id}/archive', [AdminController::class, 'archiveUser'])
    ->middleware(['auth', 'admin'])
    ->name('admin.users.archive');

Route::post('/users/{id}/restore', [AdminController::class, 'restoreUser'])
    ->middleware(['auth', 'admin'])
    ->name('admin.users.restore');

Route::get('/archived-users', [AdminController::class, 'archiveList'])
    ->middleware(['auth', 'admin'])
    ->name('admin.archive');

Route::get('/document-requests', [AdminController::class, 'documentRequests'])
    ->middleware(['auth', 'admin'])
    ->name('dashboard.document-requests');

Route::get('/document-request/{id}', [AdminController::class, 'showDocumentRequest'])
    ->middleware(['auth', 'admin'])
    ->name('document-request.show');

Route::post('/document-request/{id}/approve', [AdminController::class, 'approveRequest'])
    ->middleware(['auth', 'admin'])
    ->name('document-request.approve');

Route::post('/document-request/{id}/reject', [AdminController::class, 'rejectRequest'])
    ->middleware(['auth', 'admin'])
    ->name('document-request.reject');

Route::get('/document-request/{id}/view', [AdminController::class, 'viewDocument'])
    ->middleware(['auth', 'admin'])
    ->name('document-request.view');

// Admin Logs
Route::get('/admin-logs', [AdminController::class, 'adminLogs'])
    ->middleware(['auth', 'admin'])
    ->name('admin.logs');

// Create Admin Account
Route::get('/create-admin', [AdminController::class, 'createAdminForm'])
    ->middleware(['auth', 'admin'])
    ->name('admin.create-admin');

Route::post('/create-admin', [AdminController::class, 'createAdmin'])
    ->middleware(['auth', 'admin'])
    ->name('admin.create-admin.store');

Route::get('/admins', [AdminController::class, 'adminsList'])
    ->middleware(['auth', 'admin'])
    ->name('admin.admins-list');

// Residents Geo-tagging
Route::get('/residents-map', [AdminController::class, 'residentsWithGeoTag'])
    ->middleware(['auth', 'admin'])
    ->name('admin.residents-map');

// Cash Assistance Events
Route::get('/admin/events', [AdminController::class, 'events'])
    ->middleware(['auth', 'admin'])
    ->name('admin.events');

Route::post('/admin/events', [AdminController::class, 'storeEvent'])
    ->middleware(['auth', 'admin'])
    ->name('admin.events.store');

Route::get('/admin/events/{id}', [AdminController::class, 'showEvent'])
    ->middleware(['auth', 'admin'])
    ->name('admin.events.show');

Route::delete('/admin/events/{id}', [AdminController::class, 'deleteEvent'])
    ->middleware(['auth', 'admin'])
    ->name('admin.events.delete');

// User Request Status
Route::get('/user/request-status/{id}', [UserController::class, 'viewRequestStatus'])
    ->middleware('auth')
    ->name('user.request-status');

Route::get('/user/events', [UserController::class, 'events'])
    ->middleware('auth')
    ->name('user.events');

Route::get('/barangay-certification', function () {
    return view('portals.barangay-certification');
})->middleware(['auth', 'admin'])->name('dashboard.barangay-certification');

Route::get('/business-certification', function () {
    return view('portals.business-certification');
})->middleware(['auth', 'admin'])->name('dashboard.business-certification');

Route::get('/good-moral-certification', function () {
    return view('portals.good-moral-certification');
})->middleware(['auth', 'admin'])->name('dashboard.good-moral-certification');




Route::get('/events-display', [EventsController::class, 'EventDisplay'])->name('events.index');
