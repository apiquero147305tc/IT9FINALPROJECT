<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {

    $products = [
        [
            'name' => 'Rice (5kg)',
            'price' => 250,
            'image' => '/images/rice.jpg'
        ],
        [
            'name' => 'Cooking Oil',
            'price' => 120,
            'image' => '/images/oil.jpg'
        ],
        [
            'name' => 'Canned Goods',
            'price' => 80,
            'image' => '/images/canned.jpg'
        ],
        [
            'name' => 'Laundry Detergent',
            'price' => 150,
            'image' => '/images/detergent.jpg'
        ],
    ];

    return view('home', compact('products'));
})->name('home');


//Authentication
Route::get('/chooseRole', function () {
    return view('auth.chooseRole');
})->name('chooseRole');

/*
|-----------------------------------
| BUYER AUTH
|-----------------------------------
*/
Route::get('/buyer/login', function () {
    return view('auth.buyer.login');
})->name('buyer.login');

Route::get('/buyer/signup', function () {
    return view('auth.buyer.signup');
})->name('buyer.signup');



/*
|-----------------------------------
| SELLER AUTH
|-----------------------------------
*/
Route::get('/seller/login', function () {
    return view('auth.seller.login');
})->name('seller.login');

Route::get('/seller/signup', function () {
    return view('auth.seller.signup');
})->name('seller.signup');


//shop redirect
Route::get('/shop', function () {

    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('chooseRole');
})->name('shop');


//cuties sa navbar
Route::get('/shop', function () {
    return view('shop');
})->name('shop');

Route::get('/bestSeller', function () {
    return view('bestSeller');
})->name('bestSeller');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');