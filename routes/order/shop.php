<?php

Route::redirect('/', '/shop/login');
Route::view('/dashboard', 'order.shop.dashboard');
Route::view('/password', 'order.shop.account.change-password');
Route::view('/wallet', 'order.shop.account.wallet');

Route::get('/dashboard/{id}', function ($id) {
     Session::put('shop_id', $id);
    return view('order.shop.dashboard', compact('id'));
});

Route::get('/addonindex/{id}/', function ($id) {
    $id=base64_decode($id);
    return view('order.shop.addon.index', compact('id'));
});

Route::get('/addon/{store_id}/create', function ($store_id) {
    return view('order.shop.addon.form', compact('store_id')); 
});

Route::get('/addon/{id}/edit', function ($id) {
    return view('order.shop.addon.form', compact('id')); 
});

Route::get('/categoryindex/{id}/', function ($id) {
    $id=base64_decode($id);
    return view('order.shop.category.index', compact('id'));
});

Route::get('/category/{store_id}/create', function ($store_id) {
    return view('order.shop.category.form', compact('store_id'));
});

Route::get('/category/{id}/edit', function ($id) {
    return view('order.shop.category.form', compact('id'));
});

Route::get('/itemsindex/{id}/', function ($id) {
    $id=base64_decode($id);
    return view('order.shop.item.index', compact('id'));
});

Route::get('/items/{store_id}/create', function ($store_id) {
    return view('order.shop.item.form', compact('store_id'));
});

Route::get('/items/{id}/{store_id}/edit', function ($id,$store_id) {
    return view('order.shop.item.form', compact('id','store_id'));
});

Route::get('view/{id}', function ($id) {
    $Days = [
        'ALL' => 'Everyday',
        'SUN' => 'Sunday',
        'MON' => 'Monday',
        'TUE' => 'Tuesday',
        'WED' => 'Wednesday',
        'THU' => 'Thursday',
        'FRI' => 'Friday',
        'SAT' => 'Saturday'
    ];
    $id=base64_decode($id);
   return view('order.shop.shop', compact('id','Days'));
});

Route::get('/login', function () {

    $base_url = \App\Helpers\Helper::getBaseUrl();

    $services = json_decode(\App\Helpers\Helper::getServiceBaseUrl(), true);

    $settings = json_encode(\App\Helpers\Helper::getSettings());

    $base = [];

    foreach ($services as $key => $service) {
        $base[$key] = $service;
    }

    $base = json_encode($base); 

    return view('order.shop.auth.login', compact('base', 'base_url', 'settings'));
});

Route::get('/logout', function () {

    return view('order.shop.auth.logout'); 
});

Route::get('/forgotPassword', function () {
    $base_url = \App\Helpers\Helper::getBaseUrl();
    $services = json_decode(\App\Helpers\Helper::getServiceBaseUrl(), true);
    $settings = json_encode(\App\Helpers\Helper::getSettings());
    $base = [];
    foreach ($services as $key => $service) {
        $base[$key] = $service;
    }
    $base = json_encode($base); 
    return view('order.shop.auth.forgot', compact('base', 'base_url', 'settings'));
}); 


Route::get('/resetPassword', function () {
    $base_url = \App\Helpers\Helper::getBaseUrl();
    $services = json_decode(\App\Helpers\Helper::getServiceBaseUrl(), true);
    $settings = json_encode(\App\Helpers\Helper::getSettings());
    $base = [];
    foreach ($services as $key => $service) {
        $base[$key] = $service;
    }
    $base = json_encode($base); 
    return view('order.shop.auth.reset', compact('base', 'base_url', 'settings'));
});


Route::get('/dispatcher-panel/{id}/', function ($id) {
    $id=base64_decode($id);
    return view('order.shop.dispatcherpanel.index', compact('id'));
});


Route::get('/bankdetail', function () {
    return view('order.shop.account.bankdetails'); 
});



