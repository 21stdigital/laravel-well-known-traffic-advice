<?php

use Illuminate\Support\Facades\Route;
use TFD\WellKnownTrafficAdvice\Http\Controllers\WellKnownTrafficAdviceController;

Route::get('.well-known/traffic-advice', WellKnownTrafficAdviceController::class);
