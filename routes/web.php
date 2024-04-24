<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthorizationController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BasketController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index'])->name('home');
Route::get('/books-by-genre/{genre}', [BookController::class, 'booksByGenre'])->name('books-by-genre');

Route::get('/book/{id}', [BookController::class, 'showCard'])->name('showCard');

Route::get('/catalog', [CatalogController::class, 'showCatalog'])->name('showCatalog');
Route::get('/catalog/filters', [CatalogController::class, 'showCatalogWithFilters'])->name('showCatalogWithFilters');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/authorization', [AuthorizationController::class, 'showAuthorizationForm'])->name('authorization');
    Route::post('/authorization', [AuthorizationController::class, 'authorization']);
});

Route::get('/register-success', function () {
    return view('/auth.register-success');
})->name('register-success');
Route::get('/authorization-success', function () {
    return view('/auth.authorization-success');
})->name('authorization-success');

Route::middleware(['authenticated'])->group(function () {

    Route::post('/book/{id}', [BookController::class, 'addFeedback'])->name('addFeedback');

    Route::get('/basket', [BasketController::class, 'showBasketPage'])->name('showBasketPage');
    Route::post('/basket/add', [BasketController::class, 'addToBasket'])->name('addToBasket');
    Route::delete('/basket/delete/{basketItem}', [BasketController::class, 'deleteFromBasket'])->name('deleteFromBasket');
    Route::put('/basket/update/{itemId}', [BasketController::class, 'updateBasketItem'])->name('updateBasketItem');
    Route::get('/basket/summary', [BasketController::class, 'summary'])->name('summary');
    Route::post('/basket/order', [BasketController::class, 'acceptOrder'])->name('acceptOrder');

    Route::get('/user', [UserController::class, 'showUserPage'])->name('showUserPage');
    Route::put('/user/update/info', [UserController::class, 'updateUserInfo'])->name('updateUserInfo');
    Route::post('/user/delete/order', [UserController::class, 'deleteUserOrder'])->name('deleteUserOrder');
    Route::post('/user/delete/bookmark', [UserController::class, 'deleteUserBookmarks'])->name('deleteUserBookmarks');
    Route::post('/user/add/bookmark', [UserController::class, 'addUserBookmarks'])->name('addUserBookmarks');
    Route::get('/logout', [UserController::class, 'destroy'])->name('logout');
});

Route::middleware(['admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'showAdminPanel'])->name('showAdminPanel');
    Route::put('/admin', [AdminController::class, 'updateOrderStatus'])->name('updateOrderStatus');

    Route::get('/admin/new-book', [AdminController::class, 'showAdminNewBook'])->name('showAdminNewBook');
    Route::post('/admin/new-book/', [AdminController::class, 'createBook'])->name('createBook');

    Route::get('/admin/catalog-update', [AdminController::class, 'showAdminCatalog'])->name('showAdminCatalog');
    Route::post('/admin/catalog-update/delete', [AdminController::class, 'deleteBook'])->name('deleteBook');

    Route::get('/admin/update-book/{id}', [AdminController::class, 'showUpdateBook'])->name('showUpdateBook');
    Route::put('/admin/update-book/{id}', [AdminController::class, 'updateBook'])->name('updateBook');

    Route::get('/admin/publisher/', [AdminController::class, 'showPublisher'])->name('showPublisher');
    Route::get('/admin/publisher/{publisherToUpdateId}', [AdminController::class, 'showPublisher'])->name('showPublisherToUpdate');
    Route::post('/admin/publisher/update', [AdminController::class, 'updatePublisher'])->name('updatePublisher');
    Route::post('/admin/publisher/add', [AdminController::class, 'addPublisher'])->name('addPublisher');
    Route::post('/admin/publisher/delete', [AdminController::class, 'deletePublisher'])->name('deletePublisher');

    Route::get('/admin/author/', [AdminController::class, 'showAuthor'])->name('showAuthor');
    Route::get('/admin/author/{authorToUpdateId}', [AdminController::class, 'showAuthor'])->name('showAuthorToUpdate');
    Route::post('/admin/author/update', [AdminController::class, 'updateAuthor'])->name('updateAuthor');
    Route::post('/admin/author/add', [AdminController::class, 'addAuthor'])->name('addAuthor');
    Route::post('/admin/author/delete', [AdminController::class, 'deleteAuthor'])->name('deleteAuthor');

});
