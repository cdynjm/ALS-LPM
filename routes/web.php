<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword; 
use Illuminate\Support\Facades\Auth;          

Route::get('/storage', function () {
    Artisan::call('storage:link');
});

Route::get('/', [LoginController::class, 'show'])->middleware('guest')->name('login');

Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');

Route::group(['middleware' => 'guest'], function () {
	Route::group(['prefix' => 'get'], function () {
		Route::post('/municipal', [RegisterController::class, 'getMunicipal']);
		Route::post('/barangay', [RegisterController::class, 'getBarangay']);
	});
	Route::group(['prefix' => 'create'], function () {
		Route::post('/student', [RegisterController::class, 'createStudent']);
	});
});

Route::group(['middleware' => 'auth'], function () {

	Route::get('/students', [GlobalController::class, 'getStudents'])->name('students');
	Route::get('/student-profile/{id}', [GlobalController::class, 'getStudentProfile'])->name('student-profile'); 

	Route::group(['middleware' => 'admin'], function () {

		Route::get('/admin-dashboard', [HomeController::class, 'admin'])->name('admin-dashboard');
		Route::get('/teachers', [AdminController::class, 'getTeacher'])->name('teachers');
		Route::get('/programs', [AdminController::class, 'getProgram'])->name('programs');
		Route::get('/learning-strands', [AdminController::class, 'getSubjects'])->name('learning-strands');
		Route::get('/admin-profile', [AdminController::class, 'getProfile'])->name('admin-profile');
	});

	Route::group(['middleware' => 'teachers'], function () {

		Route::get('/teacher-dashboard', [HomeController::class, 'teachers'])->name('teacher-dashboard');
		Route::get('/exams', [TeacherController::class, 'getExam'])->name('exams');
		Route::get('/teacher-profile', [TeacherController::class, 'getProfile'])->name('teacher-profile');
		Route::get('/learning-materials', [TeacherController::class, 'getLearningMaterials'])->name('learning-materials');
		Route::get('/student-submissions/{id}', [TeacherController::class, 'getStudentSubmissions'])->name('student-submissions');
		Route::get('/student-activity/{id}', [TeacherController::class, 'getStudentActivity'])->name('student-activity');
		Route::get('/teacher-print-result/{id}', [StudentController::class, 'printResult'])->name('teacher-print-result');
		Route::get('/teacher-print-post-result/{id}', [StudentController::class, 'printPostResult'])->name('teacher-print-post-result');
	});

	Route::group(['middleware' => 'students'], function () {

		Route::get('/take-exams', [StudentController::class, 'getTakeExam'])->middleware('preexam')->name('take-exams');
		Route::get('/post-take-exams', [StudentController::class, 'getPostTakeExam'])->middleware('postexam')->name('post-take-exams');
		Route::get('/student-dashboard', [HomeController::class, 'students'])->middleware('redirect')->name('student-dashboard');
		Route::get('/exam-result', [StudentController::class, 'getExamResult'])->middleware('redirect')->name('exam-result');
		Route::get('/post-test-result', [StudentController::class, 'getPostExamResult'])->middleware('redirect')->name('post-test-result');
		Route::get('/account-profile', [StudentController::class, 'getProfile'])->middleware('redirect')->name('account-profile');
		Route::get('/my-learning-material/{id}', [StudentController::class, 'getMyLearningMaterial'])->middleware('redirect')->name('my-learning-material');
		Route::get('/print-result', [StudentController::class, 'printResult'])->middleware('redirect')->name('print-result');
		Route::get('/print-post-result', [StudentController::class, 'printPostResult'])->middleware('redirect')->name('print-post-result');
	});

	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});