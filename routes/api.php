<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StoryController;



Route::post('/story', [StoryController::class, 'story']);
