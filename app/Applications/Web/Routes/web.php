<?php
use Illuminate\Support\Facades\Auth;

Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('/routes', function () {
    dd(Route::getRoutes());
});

Route::get('admin{any}', 'Controller@adminIndex')->where('any', '.*');
Route::get('{any}', 'Controller@index')->where('any', '.*');
