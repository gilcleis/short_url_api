<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('{shortUrl:code}', function (\App\Models\ShortUrl $shortUrl) {
    $shortUrl->visits()->create([
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);

    return ['Laravel' => app()->version()];
});