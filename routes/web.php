<?php

use Illuminate\Support\Facades\Route;

Route::view('/{vue_capture?}', 'welcome')->where('vue_capture', '[\/\w\.-]*');
