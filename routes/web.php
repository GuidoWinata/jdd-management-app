<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventContentController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\SidebarMenuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::get('test', function () {
    Benchmark::dd(function () {
        (string) view('welcome');
    });
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Users Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::middleware('access_type:1')->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/add', [UserController::class, 'add'])->name('add');
        Route::post('/create', [UserController::class, 'doCreate'])->name('create');
        Route::get('/detail/{id}', [UserController::class, 'detail'])->name('detail');
        Route::get('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::post('/update/{id}', [UserController::class, 'doUpdate'])->name('doUpdate');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');
        Route::post('/reset-password/{id}', [UserController::class, 'resetPassword'])->name('resetPassword');
    });

    Route::middleware('access_type:1')->prefix('sidebar-menu')->name('sidebar_menu.')->group(function () {
        Route::get('/', [SidebarMenuController::class, 'index'])->name('index');
        Route::get('/refresh-cache', [SidebarMenuController::class, 'refreshCache'])->name('refresh_cache');
        Route::get('/add', [SidebarMenuController::class, 'add'])->name('add');
        Route::post('/create', [SidebarMenuController::class, 'doCreate'])->name('create');
        Route::get('/update/{id}', [SidebarMenuController::class, 'update'])->name('update');
        Route::post('/update/{id}', [SidebarMenuController::class, 'doUpdate'])->name('doUpdate');
        Route::delete('/delete/{id}', [SidebarMenuController::class, 'delete'])->name('delete');
        Route::get('/{id}/access', [SidebarMenuController::class, 'access'])->name('access');
        Route::post('/{id}/access', [SidebarMenuController::class, 'doAccess'])->name('doAccess');
        Route::get('/role-access/{accessType}', [SidebarMenuController::class, 'roleAccess'])->name('role_access');
        Route::post('/role-access/{accessType}', [SidebarMenuController::class, 'doRoleAccess'])->name('doRoleAccess');
    });

    Route::middleware('access_type:1,2,3')->prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/add', [EventController::class, 'add'])->name('add');
        Route::post('/create', [EventController::class, 'doCreate'])->name('create');
        Route::get('/detail/{id}', [EventController::class, 'detail'])->name('detail');
        Route::get('/update/{id}', [EventController::class, 'update'])->name('update');
        Route::post('/update/{id}', [EventController::class, 'doUpdate'])->name('doUpdate');
        Route::delete('/delete/{id}', [EventController::class, 'delete'])->name('delete');
    });

    $eventContentRoutes = [
        'event-sections' => ['name' => 'event_sections', 'resource' => 'sections'],
        'event-speakers' => ['name' => 'event_speakers', 'resource' => 'speakers'],
        'event-materials' => ['name' => 'event_materials', 'resource' => 'materials'],
        'event-agenda' => ['name' => 'event_agenda_groups', 'resource' => 'agenda_groups'],
        'event-merchandises' => ['name' => 'event_merchandises', 'resource' => 'merchandises'],
        'event-tickets' => ['name' => 'event_tickets', 'resource' => 'tickets'],
        'event-partners' => ['name' => 'event_partners', 'resource' => 'partners'],
    ];

    foreach ($eventContentRoutes as $uri => $route) {
        Route::middleware('access_type:1,2,3')->prefix($uri)->name($route['name'].'.')->group(function () use ($route) {
            Route::get('/', [EventContentController::class, 'index'])->defaults('resource', $route['resource'])->name('index');
            Route::get('/add', [EventContentController::class, 'add'])->defaults('resource', $route['resource'])->name('add');
            Route::post('/create', [EventContentController::class, 'doCreate'])->defaults('resource', $route['resource'])->name('create');
            Route::get('/detail/{id}', [EventContentController::class, 'detail'])->defaults('resource', $route['resource'])->name('detail');
            Route::get('/update/{id}', [EventContentController::class, 'update'])->defaults('resource', $route['resource'])->name('update');
            Route::post('/update/{id}', [EventContentController::class, 'doUpdate'])->defaults('resource', $route['resource'])->name('doUpdate');
            Route::delete('/delete/{id}', [EventContentController::class, 'delete'])->defaults('resource', $route['resource'])->name('delete');
        });
    }

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/change-password', [UserController::class, 'changePassword'])->name('change_password');
        Route::post('/change-password', [UserController::class, 'doChangePassword'])->name('do_change_password');
    });

});
