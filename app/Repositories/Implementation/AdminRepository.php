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
use App\Repositories\Interface\AdminRepositoryInterface;

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
use App\Models\Competencies;

class AdminRepository implements AdminRepositoryInterface {

    protected $aes;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(AESCipher $aes) {
        $this->aes = $aes;
    }

    // TEACHERS REQUESTS: <-------------------------------------------------------> //

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getTeacher() {

        return Teachers::orderBy('name', 'ASC')->get();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createTeacher($request) {

        $teacherData = [
            'name' => $request->fullName,
            'position' => $request->position,
            'address' => $request->address,
            'contactNumber' => $request->contactNumber,
            'dateEmployed' => $request->dateEmployed
        ];

        $saveTeacher = Teachers::create($teacherData);

        $teacherUserData = [
            'teacherID' => $saveTeacher->id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2,
        ];

        try {
            User::create($teacherUserData);
            return 200;
        }
        catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                Teachers::where(['id' => $saveTeacher->id])->delete();
                return 500;
            }
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateTeacher($request) {

        $id = (isset($request->id)?$this->aes->decrypt($request->id):"");

        if(!empty($request->password)) {
            $teacherUserData = [
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];
        }
        else {
            $teacherUserData = ['email' => $request->email];
        }

        try {
            User::where(['teacherID' => $id])->update($teacherUserData);
        }
        catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return 500;
            }
        }

        $teacherData = [
            'name' => $request->fullName,
            'position' => $request->position,
            'address' => $request->address,
            'contactNumber' => $request->contactNumber,
            'dateEmployed' => $request->dateEmployed
        ];

        Teachers::where(['id' => $id])->update($teacherData);

        return 200;
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteTeacher($request) {

        $id = (isset($request->id)?$this->aes->decrypt($request->id):"");
        Teachers::where(['id' => $id])->delete();
        User::where(['teacherID' => $id])->delete();
    }


    // PROGRAM REQUESTS: <-------------------------------------------------------> //

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getProgram() {

        return Programs::orderBy('program', 'ASC')->get();
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createProgram($request) {

        $data = ['program' => $request->program];
        Programs::create($data);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateProgram($request) {

        $id = (isset($request->id)?$this->aes->decrypt($request->id):"");
        $data = ['program' => $request->program];
        Programs::where(['id' => $id])->update($data);
        $programs = Programs::orderBy('program', 'ASC')->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteProgram($request) {

        $id = (isset($request->id)?$this->aes->decrypt($request->id):"");
        Programs::where(['id' => $id])->delete();
        $programs = Programs::orderBy('program', 'ASC')->get();
    }


    // SUBJECT REQUESTS: <-------------------------------------------------------> //

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getSubject() {

        return Subjects::orderBy('subject', 'ASC')->get();
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createSubject($request) {

        $data = ['subject' => $request->subject];
        $subject = Subjects::create($data);

    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateSubject($request) {

        $id = (isset($request->id)?$this->aes->decrypt($request->id):"");
        $data = ['subject' => $request->subject];
        Subjects::where(['id' => $id])->update($data);

    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteSubject($request) {

        $id = (isset($request->id)?$this->aes->decrypt($request->id):"");
        Subjects::where(['id' => $id])->delete();
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getCompetency() {

       return Competencies::get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createCompetency($request) {

        $subjectID = (isset($request->subject)?$this->aes->decrypt($request->subject):"");
        $code = (isset($request->code)?$this->aes->decrypt($request->code):"");
        $data = [
            'subjectID' => $subjectID,
            'code' => $code,
            'description' => $request->competency
        ];
        Competencies::create($data);
     }
    

    // LEARNING LEVELS REQUESTS: <-------------------------------------------------------> //

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getLearningLevel() {

        return LearningLevels::get();
    }


     // PROFILE REQUESTS: <-------------------------------------------------------> //

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateProfile($request) {

        try {
            $data = [
                'email' => $request->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'address' => $request->address
            ];
            User::where(['id' => Auth::user()->id])
                ->update($data);
            
            if(!empty($request->password)) {
                User::where(['id' => Auth::user()->id])
                ->update(['password' => Hash::make($request->password)]);
            }
            return 200;
        }
        catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return 500;
            }
        }
    }

}
