<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AssigneeController;
use Illuminate\Support\Facades\Route;

Route::post('/users', [UserController::class, 'register']);
Route::post('/users/login', [UserController::class, 'login']);

Route::middleware(\App\Http\Middleware\ApiAuthMiddleware::class)->group(function () {

    // Users
    Route::get('/users/current', [UserController::class, 'get']);
    Route::patch('/users/current', [UserController::class, 'update']);
    Route::delete('/users/logout', [UserController::class, 'logout']);

    // Contacts
    Route::post('/contacts', [\App\Http\Controllers\ContactController::class, 'create']);
    Route::get('/contacts', [\App\Http\Controllers\ContactController::class, 'search']);
    Route::get('/contacts/{id}', [\App\Http\Controllers\ContactController::class, 'get'])->where('id', '[0-9]+');
    Route::put('/contacts/{id}', [\App\Http\Controllers\ContactController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('/contacts/{id}', [\App\Http\Controllers\ContactController::class, 'delete'])->where('id', '[0-9]+');

    // Addresses
    Route::post('/contacts/{idContact}/addresses', [\App\Http\Controllers\AddressController::class, 'create'])->where('idContact', '[0-9]+');
    Route::get('/contacts/{idContact}/addresses', [\App\Http\Controllers\AddressController::class, 'list'])->where('idContact', '[0-9]+');
    Route::get('/contacts/{idContact}/addresses/{idAddress}', [\App\Http\Controllers\AddressController::class, 'get'])->where('idContact', '[0-9]+')->where('idAddress', '[0-9]+');
    Route::put('/contacts/{idContact}/addresses/{idAddress}', [\App\Http\Controllers\AddressController::class, 'update'])->where('idContact', '[0-9]+')->where('idAddress', '[0-9]+');
    Route::delete('/contacts/{idContact}/addresses/{idAddress}', [\App\Http\Controllers\AddressController::class, 'delete'])->where('idContact', '[0-9]+')->where('idAddress', '[0-9]+');

    // Tasks
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->where('task', '[0-9]+');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->where('idTask', '[0-9]+');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->where('idTask', '[0-9]+');

    // Comments
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->where('idTask', '[0-9]+');
    Route::delete('/tasks/{task}/comments/{comment}', [CommentController::class, 'destroy'])->where('idTask', '[0-9]+')->where('idComment', '[0-9]+');

    // Tags
    Route::post('/tasks/{task}/tags', [TagController::class, 'store'])->where('task', '[0-9]+');
    Route::delete('/tasks/{task}/tags/{tag}', [TagController::class, 'destroy'])->where('task', '[0-9]+')->where('tag', '[0-9]+');

    // Assignees
    Route::post('/tasks/{task}/assignees', [AssigneeController::class, 'store'])->where('task', '[0-9]+');
    Route::delete('/tasks/{task}/assignees/{user}', [AssigneeController::class, 'destroy'])->where('task', '[0-9]+')->where('user', '[0-9]+');
});