<?php

use App\Http\Controllers\CategoryApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::apiResource('/categories', CategoryApiController::class);

Route::post('/login', function() {
    $email = request()->email;
    $password = request()->password;

    if(!$email or !$password) {
        return response(['msg', 'email or password incorrect'], 403);
    }

    $user = \App\Models\User::where("email", $email)->first();
    if($user) {
        if(password_verify($password, $user->password)) {
            return $user->createToken('api')->plainTextToken;
        }
    }

    return response(['msg', 'email or password incorrect'], 403);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
