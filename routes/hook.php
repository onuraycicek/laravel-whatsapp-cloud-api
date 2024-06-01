<?php

use Illuminate\Support\Facades\Route;
use WCA\WCA\Http\Controllers\WebhookController;

Route::get('/webhook', [WebhookController::class, 'webhook_register']);
Route::post('/webhook', [WebhookController::class, 'webhook']);