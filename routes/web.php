<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Route::get('/', function () {
//     return view('welcome');
// });

// User
Volt::route('/', 'frontend.respondent-profile')->name('respondent-profile');
Volt::route('/family-profile', 'frontend.family-profile')->name('family-profile');
Volt::route('/q1/housing-water-and-sanitation', 'frontend.housing-water-sanitation')->name('housing-water-sanitation');
Volt::route('/q2/health-and-nutrition', 'frontend.health-and-nutrition')->name('health-and-nutrition');
Volt::route('/q3/mental-health-and-wellbeing', 'frontend.mental-health-and-wellbeing')->name('mental-health-and-wellbeing');
Volt::route('/q4/education', 'frontend.education')->name('education');
Volt::route('/q5/political-participation', 'frontend.political-participation')->name('political-participation');
Volt::route('/q6/social-relationship-and-engagement', 'frontend.social-relationship-and-engagement')->name('social-relationship-and-engagement');
Volt::route('/q7/environmental-impacts', 'frontend.environmental-impacts')->name('environmental-impacts');
Volt::route('/q8/economical-productivity', 'frontend.economical-productivity')->name('economical-productivity');

// Admin
Volt::route('admin-login', 'backend.login')->name('login');

Route::middleware(['auth'])->group(function () {
    Volt::route('admin-dashboard', 'backend.dashboard')->name('admin-dashboard');
    Volt::route('profiling-list', 'backend.profiling-list')->name('admin-profiling-list');
    Volt::route('form-builder', 'backend.form-builder')->name('admin-form-builder');
    Volt::route('add-section', 'backend.add-section')->name('admin-add-section');
    Volt::route('edit-section/{id}', 'backend.edit-section')->name('admin-edit-section');
    Volt::route('edit-section/question/edit/{id}', 'backend.question-option')->name('admin-question-option');
});


