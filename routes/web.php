<?php

use App\Exceptions\ValidationException;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/rnd', function () {
    return 'Hello Randi Febriadi';
});

Route::redirect('/youtube', '/rnd');

Route::fallback(function() {
    return '404 by Randi Febriadi';
});

// Route::view('/hello', 'hello', ['name' => 'Randi']);

Route::get('/hello', function() {
    return view('hello', ['name' => 'Randi Febriadi']);
});

Route::get('/world', function() {
    return view('hello.world', ['name' => 'Randi Programmer']);
});

Route::get('/products/{id}', function($productId) {
    return "Product : $productId";
})->name('product.detail');

Route::get('/products/{product}/items/{item}', function($productId, $itemId) {
    return "Product : $productId, Item : $itemId";
})->name('product.item.detail');

Route::get('/categories/{id}', function($categoryId){
    return "Category $categoryId";
})->where('id', '[0-9]+')->name('category.detail');

Route::get('/users/{id?}', function(string $userId = '404'){
    return "User : $userId";
})->name('user.detail');

Route::get('/conflict/randi', function() {
    return "Conflict Randi Febriadi";
});

Route::get('/conflict/{name}', function($name) {
    return "Conflict $name";
});

Route::get('/produk/{id}', function($id) {
    $link = route('product.detail', ['id' => $id]);

    return "Link $link";
});

Route::get('/produk-redirect/{id}', function($id) {
    return redirect()->route('product.detail', ['id' => $id]);
});

Route::get('/controller/hello/request', [HelloController::class, 'request']);

Route::get('/controller/hello/{name}', [HelloController::class, 'hello']);

Route::get('/input/hello', [InputController::class, 'hello']);
Route::post('/input/hello', [InputController::class, 'hello']);

Route::post('/input/hello/first', [InputController::class, 'helloFirstName']);
Route::post('/input/hello/input', [InputController::class, 'helloInput']);
Route::post('/input/hello/array', [InputController::class, 'helloArray']);

Route::post('/input/type', [InputController::class, 'inputType']);

Route::post('/input/filter/only', [InputController::class, 'filterOnly']);
Route::post('/input/filter/except', [InputController::class, 'filterExcept']);
Route::post('/input/filter/merge', [InputController::class, 'filterMerge']);

Route::post('/file/upload', [FileController::class, 'upload'])->withoutMiddleware([VerifyCsrfToken::class]);

Route::get('/response/hello', [ResponseController::class, 'response']);
Route::get('/response/header', [ResponseController::class, 'header']);

Route::prefix('/response/type')->group(function() {
    Route::get('/view', [ResponseController::class, 'responseView']);
    Route::get('/json', [ResponseController::class, 'responseJson']);
    Route::get('/file', [ResponseController::class, 'responseFile']);
    Route::get('/download', [ResponseController::class, 'responseDownload']);
});

Route::controller(CookieController::class)->prefix('/cookie')->group(function() {
    Route::get('/set','createCookie');
    Route::get('/get','getCookie');
    Route::get('/clear','clearCookie');
});

Route::controller(RedirectController::class)->prefix('/redirect')->group(function(){
    Route::get('/from','redirectFrom');
    Route::get('/to','redirectTo');
    Route::get('/name','redirectName');
    Route::get('/name/{name}','redirectHello')->name('redirect-hello');
    Route::get('/action','redirectAction');
    Route::get('/away','redirectAway');
});

Route::middleware(['contoh:PZN, 401'])->prefix('/middleware')->group(function() {
    Route::get('/api', function() {
        return "OK";
    });
    
    Route::get('/group', function() {
        return "GROUP";
    });
});

Route::get('/form', [FormController::class, 'form']);
Route::post('/form', [FormController::class, 'submitForm']);

Route::prefix('/url')->group(function(){
    Route::get('/current', function(){
        return URL::full();
    });
    Route::get('/named', function(){
        return route('redirect-hello', ['name' => 'Randi']);
    });
    Route::get('/action', function(){
        return action([FormController::class, 'form'], []);
        // return url()->action([FormController::class, 'form'], []);
    });
});

Route::prefix('/session')->controller(SessionController::class)->group(function(){
    Route::get('/create', 'createSession');
    Route::get('/get', 'getSession');
});

Route::prefix('/error')->group(function(){
    Route::get('/sample', function() {
        throw new Exception('Sample Error');
    });
    Route::get('/manual', function() {
        report(new Exception('Sample Error'));
        return 'OK';
    });
    Route::get('/validation', function() {
        throw new ValidationException('Validation Error');
    });
});

Route::prefix('/abort')->group(function(){
    Route::get('/400', function(){
        abort(400, 'Ups Validation Error');
    });
    Route::get('/401', function(){
        abort(401);
    });
    Route::get('/500', function(){
        abort(500);
    });
});