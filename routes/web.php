<?php

use App\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserTypeController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::name('usertype.')->prefix('usertype')->controller(UserTypeController::class)->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('data','getUserTypeData')->name('getUserTypeData');
        Route::get('/permisions/{id}/edit','edit')->name('permissions.edit');
        Route::post('/permisions/{id}/update','update')->name('permissions.update');
    });

    Route::name('users.')->prefix('users')->controller(UserController::class)->group(function(){
        Route::get('/','index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::post('/delete/{id}', 'destroy')->name('destroy');
        Route::get('data','getUserData')->name('getUserData');
        Route::post('change/status/{parameterId}','changeStatus')->name('changeStatus');
    });

    Route::name('slider.')->prefix('slider')->controller(SliderController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/show/{id}', 'show')->name('show');
        Route::post('/delete/{id}', 'destroy')->name('destroy');
        Route::get('data','getSlidersData')->name('getSlidersData');
    });


    Route::name('faq.')->prefix('faq')->controller(FaqController::class)->group(function(){
        Route::get('/','index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::get('/{id}/show', 'show')->name('show');
        Route::post('/{id}/update', 'update')->name('update');
        Route::post('/{id}/delete', 'destroy')->name('destroy');
        Route::get('data','getFaqData')->name('getFaqData');
    });

    Route::name('announcements.')->prefix('announcements')->controller(AnnouncementController::class)->group(function(){
        Route::get('/','index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::get('/{id}/show', 'show')->name('show');
        Route::post('/{id}/update', 'update')->name('update');
        Route::post('/{id}/delete', 'destroy')->name('destroy');
        Route::get('data','getAnnouncementData')->name('getAnnouncementData');
    });


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('theme/change/{theme}',[ThemeController::class,'changeTheme'])->name('theme.change');

});

require __DIR__.'/auth.php';
