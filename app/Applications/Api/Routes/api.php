<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="MixPlay API",
 *      description="API da aplicação MixPlay, para pegar os dados.",
 *      @OA\Contact(
 *          email="rodrigo.pinheiroa@hotmail.com"
 *      )
 * )
 */
/**
 * @OA\SecurityScheme(
 *      securityScheme="Bearer",
 *      type="apiKey",
 *      in="header",
 *      name="Authorization"
 * )
 */
/**
 *  @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Default Server"
 *  )
 */

// auth endpoints
Route::prefix('auth')->group(function() {
    Route::post('signUp', 'AuthController@signUp');
    Route::post('signIn', 'AuthController@signIn');
    Route::post('recovery', 'AuthController@recovery');

    // authenticated
    Route::middleware('api.auth')->group(function() {
        Route::get('me', 'AuthController@me');
    });
});

Route::middleware([/*'api.auth', 'role:admin'*/])->group(function() {
    Route::apiResource('genre', 'GenreController')->except('show');
});
