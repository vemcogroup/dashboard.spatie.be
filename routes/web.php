<?php

use App\Http\Middleware\AccessToken;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GitHubWebhookController;
use App\Http\Controllers\UpdateTemperatureController;
use App\Http\Controllers\UpdateIndoorAirQualityController;

Route::group(['middleware' => AccessToken::class], function () {
    Route::get('/', [DashboardController::class, 'overview']);
    Route::get('/development', [DashboardController::class, 'development']);
    Route::get('/support', [DashboardController::class, 'support']);
    Route::post('/services/restart', [ServiceController::class, 'restart']);


    //Route::post('temperature', UpdateTemperatureController::class);

    //Route::post('indoor-air-quality', UpdateIndoorAirQualityController::class);
});

//Route::post('/webhook/github', [GitHubWebhookController::class, 'gitRepoReceivedPush']);

//Route::ohDearWebhooks('/oh-dear-webhooks');
