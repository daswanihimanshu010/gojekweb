<?php

Route::view('/', 'common/web/home'); 
Route::view('/home', 'common/web/home');
Route::view('/services', 'common/web/services');

Route::get('/pages/{type}', function ($type) {
    return view('common/web/cmspage', compact('type'));
});




Route::get('/track/{id}', function ($id) {
    return view('common.admin.track', compact('id'));
});