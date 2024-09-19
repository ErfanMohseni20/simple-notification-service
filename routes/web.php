<?php

// use App\Mail\notification;

use App\Http\Controllers\NotificationController;
use App\Mail\topiccreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Services\Notification\Notification;
use App\Models\User;
Route::get('/',function(){
    return view('home');
})->name('home');
Route::prefix('notification')->group(function(){
    Route::get('/sendemail',[NotificationController::class , 'email'])->name('notification.form.email');
    Route::post('/sendemail',[NotificationController::class , 'sendemail'])->name('notification.send.email');
    Route::get('/sendsms',[NotificationController::class , 'sms'])->name('notification.form.sms');
    Route::post('/sendsms',[NotificationController::class  , 'sendsms'])->name('notification.send.sms');
}); 