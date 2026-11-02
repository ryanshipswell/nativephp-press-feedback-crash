<?php

use App\NativeComponents\PressFeedbackCrash;
use Illuminate\Support\Facades\Route;

Route::native('/', PressFeedbackCrash::class);
