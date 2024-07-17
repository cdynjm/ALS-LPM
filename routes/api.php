<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\RegisterController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    
    Route::group(['middleware' => 'admin'], function () {

        Route::group(['prefix' => 'create'], function () {
            Route::post('/teacher', [AdminController::class, 'createTeacher']);
            Route::post('/program', [AdminController::class, 'createProgram']);
            Route::post('/subject', [AdminController::class, 'createSubject']);
            Route::post('/competency', [AdminController::class, 'createCompetency']);
        }); 
        
        Route::group(['prefix' => 'update'], function () {
            Route::patch('/teacher', [AdminController::class, 'updateTeacher']);
            Route::patch('/program', [AdminController::class, 'updateProgram']);
            Route::patch('/subject', [AdminController::class, 'updateSubject']);
            Route::patch('/admin-profile', [AdminController::class, 'updateProfile']);
        });
        
        Route::group(['prefix' => 'delete'], function () {
            Route::delete('/teacher', [AdminController::class, 'deleteTeacher']);
            Route::delete('/program', [AdminController::class, 'deleteProgram']);
            Route::delete('/subject', [AdminController::class, 'deleteSubject']);
        });

    });

    Route::group(['middleware' => 'teachers'], function () {

        Route::group(['prefix' => 'create'], function () {
            Route::post('/question', [TeacherController::class, 'createQuestion']);
            Route::post('/file', [TeacherController::class, 'createFile']);

        });

        Route::group(['prefix' => 'update'], function () {
            Route::patch('/teacher-profile', [TeacherController::class, 'updateProfile']);
            Route::patch('/score', [TeacherController::class, 'updateScore']);
        });

        Route::group(['prefix' => 'delete'], function () {
            Route::delete('/question', [TeacherController::class, 'deleteQuestion']);
            Route::delete('/file', [TeacherController::class, 'deleteFile']);
        });

    });

    Route::group(['middleware' => 'students'], function () {

		Route::group(['prefix' => 'profile'], function () {
			Route::post('/municipal', [RegisterController::class, 'getMunicipal'])->middleware('redirect');
			Route::post('/barangay', [RegisterController::class, 'getBarangay'])->middleware('redirect');
		});

		Route::group(['prefix' => 'create'], function () {
			Route::post('/submit-exam', [StudentController::class, 'createSubmitExam']);
            Route::post('/submit-post-exam', [StudentController::class, 'createSubmitPostExam'])->middleware('postexam');
            Route::post('/upload-activities', [StudentController::class, 'createUploadActivities'])->middleware('redirect');
            Route::post('/upload-activity', [StudentController::class, 'createUploadActivity'])->middleware('redirect');
            Route::post('/draft', [StudentController::class, 'createDraft'])->middleware('redirect');
        });

		Route::group(['prefix' => 'update'], function () {
            Route::post('/load-draft', [StudentController::class, 'loadDraft'])->middleware('redirect');
			Route::patch('/account-profile', [StudentController::class, 'updateProfile'])->middleware('redirect');
            Route::patch('/post-take-exams', [StudentController::class, 'updateStatus']);
        });

		Route::group(['prefix' => 'delete'], function () {
            Route::delete('/draft', [StudentController::class, 'deleteDraft'])->middleware('redirect');
            Route::delete('/activity', [StudentController::class, 'deleteActivity'])->middleware('redirect');
		});
	});
});


    

