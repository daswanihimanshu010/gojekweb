<?php
Route::get('/service/{id}', function ($id = 0) {
    return view('service.user.service.home', compact('id'));
});
Route::view('/services/trips', 'service.user.service.trips');
