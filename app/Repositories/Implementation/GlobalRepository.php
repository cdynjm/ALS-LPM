<?php

namespace App\Repositories\Implementation;

use Hash;
use Session;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACE:
use App\Repositories\Interface\GlobalRepositoryInterface;

//MODELS:
use App\Models\User;
use App\Models\Province;
use App\Models\Municipal;
use App\Models\Barangay;
use App\Models\Teachers;
use App\Models\Programs;
use App\Models\Students;
use App\Models\Answers;
use App\Models\Questions;
use App\Models\Subjects;
use App\Models\StudentExam;
use App\Models\StudentExamAttempts;
use App\Models\StudentSubject;
use App\Models\LearningMaterials;

class GlobalRepository implements GlobalRepositoryInterface {

    protected $aes;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(AESCipher $aes) {
        $this->aes = $aes;
    }


    // GET STUDENTS REQUESTS: <-------------------------------------------------------> //

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getStudents($request) {

        if(Auth::user()->role == 1)
            return Students::orderBy('lastname', 'ASC')->get();
        if(Auth::user()->role == 2) {
            if(\Str::contains(\Request::path(), 'student-submissions') || \Str::contains(\Request::path(), 'score')) {
                $id = (isset($request->id)?$this->aes->decrypt($request->id):"");
                return Students::where(['id' => $id])->first();
            }
            else
                return Students::where(['teacher' => Auth::user()->Teachers->id])->orderBy('lastname', 'ASC')->get();
        }
        else
            return abort(404);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getFLTResult() {
        
         return StudentExamAttempts::get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getStudentProfile($request) {

        if(Auth::user()->role == 1 || Auth::user()->role == 2) {
            $id = $this->aes->decrypt($request->id);
            return Students::where(['id' => $id])->get();
        }
        else {
            return abort(404);
        }
    }
}