<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwilioVoiceController;

Route::post('/twilio/voice/bridge', [TwilioVoiceController::class, 'bridge'])
    ->name('twilio.voice.bridge');

Route::post('/twilio/voice/status', [TwilioVoiceController::class, 'status'])
    ->name('twilio.voice.status');
