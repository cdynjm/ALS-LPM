<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACE:
use App\Repositories\Interface\AdminRepositoryInterface;  

//REQUEST VALIDATIONS:
use App\Http\Requests\TeacherRequest;
use App\Http\Requests\ProgramRequest;
use App\Http\Requests\LearningStrandRequest;
use App\Http\Requests\CompetencyRequest;

class AdminController extends Controller
{
    protected $aes;
    protected $AdminRepositoryInterface;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(AESCipher $aes, AdminRepositoryInterface $AdminRepositoryInterface) {
      $this->aes = $aes;
      $this->AdminRepositoryInterface = $AdminRepositoryInterface;
    }
    

    // TEACHERS REQUESTS: <-------------------------------------------------------> //

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getTeacher() {
       $teachers = $this->AdminRepositoryInterface->getTeacher();
       return view('pages.admin.teachers', ['teachers' => $teachers]);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createTeacher(TeacherRequest $request) {

        $status = $this->AdminRepositoryInterface->createTeacher($request);
        $teachers = $this->AdminRepositoryInterface->getTeacher();
        $aes = $this->aes;

        return response()->json([ 
            'Teacher' => view('data.teacher-data', compact('teachers', 'aes'))->render()
         ], $status);
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateTeacher(TeacherRequest $request) { 

        $status = $this->AdminRepositoryInterface->updateTeacher($request);
        $teachers = $this->AdminRepositoryInterface->getTeacher();
        $aes = $this->aes;

        return response()->json([
            'Teacher' => view('data.teacher-data', compact('teachers', 'aes'))->render()
         ], $status);
   }
   /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteTeacher(Request $request) {

      $this->AdminRepositoryInterface->deleteTeacher($request);
      $teachers = $this->AdminRepositoryInterface->getTeacher();
      $aes = $this->aes;

      return response()->json([
         'Message' => 'Teacher deleted successfully',
         'Teacher' => view('data.teacher-data', compact('teachers', 'aes'))->render()
      ], 200);
   }


   // PROGRAM REQUESTS: <-------------------------------------------------------> //

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getProgram() {
       $programs = $this->AdminRepositoryInterface->getProgram();
       return view('pages.admin.programs', ['programs' => $programs]);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createProgram(ProgramRequest $request) {

        $this->AdminRepositoryInterface->createProgram($request);
        $programs = $this->AdminRepositoryInterface->getProgram();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Program created successfully',
            'Program' => view('data.program-data', compact('programs', 'aes'))->render(),
         ], 200);
     }
      /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateProgram(ProgramRequest $request) {

        $this->AdminRepositoryInterface->updateProgram($request);
        $programs = $this->AdminRepositoryInterface->getProgram();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Program updated successfully',
            'Program' => view('data.program-data', compact('programs', 'aes'))->render()
         ], 200);
   }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteProgram(Request $request) {

      $this->AdminRepositoryInterface->deleteProgram($request);
      $programs = $this->AdminRepositoryInterface->getProgram();
      $aes = $this->aes;

      return response()->json([ 
         'Message' => 'Program deleted successfully',
         'Program' => view('data.program-data', compact('programs', 'aes'))->render()
      ], 200);
   }


    // SUBJECT REQUESTS: <-------------------------------------------------------> //

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getSubjects() {
      $subjects = $this->AdminRepositoryInterface->getSubject();
      $competencies = $this->AdminRepositoryInterface->getCompetency();
      return view('pages.admin.subjects', compact('subjects', 'competencies'));
   }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createSubject(LearningStrandRequest $request) {

      $this->AdminRepositoryInterface->createSubject($request);
      $subjects = $this->AdminRepositoryInterface->getSubject();
      $aes = $this->aes;

      return response()->json([
         'Message' => 'Learning Strand created successfully',
         'Subject' => view('data.subject-data', compact('subjects', 'aes'))->render()
      ], 200);

   }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateSubject(LearningStrandRequest $request) {

      $this->AdminRepositoryInterface->updateSubject($request);
      $subjects = $this->AdminRepositoryInterface->getSubject();
      $aes = $this->aes;

      return response()->json([
         'Message' => 'Subject updated successfully',
         'Subject' => view('data.subject-data', compact('subjects', 'aes'))->render()
      ], 200);
   }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteSubject(Request $request) {

      $this->AdminRepositoryInterface->deleteSubject($request);
      $subjects = $this->AdminRepositoryInterface->getSubject();
      $aes = $this->aes;

      return response()->json([
         'Message' => 'Subject deleted successfully',
         'Subject' => view('data.subject-data', compact('subjects', 'aes'))->render()
      ], 200);
   }
   /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createCompetency(CompetencyRequest $request) {

      $this->AdminRepositoryInterface->createCompetency($request);
      $competencies = $this->AdminRepositoryInterface->getCompetency();
      $subjects = $this->AdminRepositoryInterface->getSubject();
      $aes = $this->aes;

      return response()->json([
         'Message' => 'Competency created successfully',
         'Competency' => view('data.competency-data', compact('competencies','subjects', 'aes'))->render()
      ], 200);

   }


    // PROFILE REQUESTS: <-------------------------------------------------------> //

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getProfile() {
      return view('pages.admin.profile');
   }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateProfile(Request $request) {
      $status = $this->AdminRepositoryInterface->updateProfile($request);
      return response()->json([], $status);
   }
}

?>