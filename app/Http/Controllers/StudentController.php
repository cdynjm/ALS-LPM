<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACE:
use App\Repositories\Interface\StudentRepositoryInterface;  
use App\Repositories\Interface\AdminRepositoryInterface;  
use App\Repositories\Interface\TeacherRepositoryInterface;  

//REQUEST VALIDATIONS:
use App\Http\Requests\ActivitiesRequest;
use App\Models\Students;

class StudentController extends Controller
{
    protected $aes;
    protected $StudentRepositoryInterface;
    protected $AdminRepositoryInterface;
    protected $TeacherRepositoryInterface;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        AESCipher $aes,
        StudentRepositoryInterface $StudentRepositoryInterface,
        AdminRepositoryInterface $AdminRepositoryInterface,
        TeacherRepositoryInterface $TeacherRepositoryInterface
        ) {
        $this->aes = $aes;
        $this->StudentRepositoryInterface = $StudentRepositoryInterface;
        $this->AdminRepositoryInterface = $AdminRepositoryInterface;
        $this->TeacherRepositoryInterface = $TeacherRepositoryInterface;
    }


    // TAKE EXAM REQUESTS: <-------------------------------------------------------> //


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getTakeExam() {

        $subjects = $this->AdminRepositoryInterface->getSubject();
        $exams = $this->TeacherRepositoryInterface->getExam();
        $choices = $this->TeacherRepositoryInterface->getChoices();

        return view('pages.students.take-exam', compact('exams', 'choices', 'subjects'));
     }
       /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateStatus() {
        Students::where(['id' =>  Auth::user()->Students->id])->update(['status' => 2]);
        return response()->json(['Message' => 'OK'], 200);
     }
      /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getPostTakeExam() {

        $subjects = $this->AdminRepositoryInterface->getSubject();
        $exams = $this->TeacherRepositoryInterface->getExam();
        $choices = $this->TeacherRepositoryInterface->getChoices();
    
        return view('pages.students.post-take-exam', compact('exams', 'choices', 'subjects'));
     }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function createSubmitExam(Request $request) {
        
        $this->StudentRepositoryInterface->createSubmitExam($request);
        return response()->json(['Message' => 'You have successfully submitted your exam'], 200);
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createSubmitPostExam(Request $request) {
        
        $this->StudentRepositoryInterface->createSubmitPostExam($request);
        return response()->json(['Message' => 'You have successfully submitted your exam'], 200);
     }


     // GET EXAM RESULT REQUESTS: <-------------------------------------------------------> //


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getExamResult(Request $request) {

        $exams = $this->StudentRepositoryInterface->getExamResult($request);
        $choices = $this->TeacherRepositoryInterface->getChoices();
        $overallScore = $this->StudentRepositoryInterface->getOverallScore($request);
        $subjectScore = $this->StudentRepositoryInterface->getSubjectScore($request);
        $subjects = $this->AdminRepositoryInterface->getSubject();
        return view('pages.students.exam-result', compact('subjects', 'exams', 'choices', 'overallScore', 'subjectScore'));
     }

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getPostExamResult(Request $request) {

        $exams = $this->StudentRepositoryInterface->getPostExamResult($request);
        $choices = $this->TeacherRepositoryInterface->getChoices();
        $overallScore = $this->StudentRepositoryInterface->getPostOverallScore($request);
        $subjectScore = $this->StudentRepositoryInterface->getPostSubjectScore($request);
        $subjects = $this->AdminRepositoryInterface->getSubject();

        return view('pages.students.post-exam-result', compact('subjects', 'exams', 'choices', 'overallScore', 'subjectScore'));
     }

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function printResult(Request $request) {

        $exams = $this->StudentRepositoryInterface->getExamResult($request);
        $choices = $this->TeacherRepositoryInterface->getChoices();
        $overallScore = $this->StudentRepositoryInterface->getOverallScore($request);
        $subjectScore = $this->StudentRepositoryInterface->getSubjectScore($request);
        $subjects = $this->AdminRepositoryInterface->getSubject();
        $student = $this->StudentRepositoryInterface->getStudentName($request);
        return view('pages.students.print-result', compact('student','subjects', 'exams', 'choices', 'overallScore', 'subjectScore'));
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function printPostResult(Request $request) {

        $exams = $this->StudentRepositoryInterface->getPostExamResult($request);
        $choices = $this->TeacherRepositoryInterface->getChoices();
        $overallScore = $this->StudentRepositoryInterface->getPostOverallScore($request);
        $subjectScore = $this->StudentRepositoryInterface->getPostSubjectScore($request);
        $subjects = $this->AdminRepositoryInterface->getSubject();
        $student = $this->StudentRepositoryInterface->getStudentName($request);
        return view('pages.students.print-post-result', compact('student','subjects', 'exams', 'choices', 'overallScore', 'subjectScore'));
     }

     // PROFILE REQUESTS: <-------------------------------------------------------> //

    /**
    * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
    public function getProfile() {

        $province = $this->StudentRepositoryInterface->getProvince();
        $programs = $this->AdminRepositoryInterface->getProgram();
        $teachers = $this->AdminRepositoryInterface->getTeacher();

        return view('pages.students.profile', compact('province', 'programs', 'teachers'));
     }
      /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateProfile(Request $request) {
        $status =  $this->StudentRepositoryInterface->updateProfile($request);
        return response()->json([], $status);
     }


    // MY LEARNING MATERIAL REQUESTS: <-------------------------------------------------------> //

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getMyLearningMaterial(Request $request) {
        $learningMaterial = $this->StudentRepositoryInterface->getMyLearningMaterial($request);
        $activities = $this->StudentRepositoryInterface->getActivities();
        $drafts = $this->StudentRepositoryInterface->getDraft();
        return view('pages.students.view-learning-material', compact('drafts','learningMaterial', 'activities'));
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function createUploadActivities(ActivitiesRequest $request) {

        $this->StudentRepositoryInterface->createUploadActivities($request);
        $learningMaterial = $this->StudentRepositoryInterface->getMyLearningMaterial($request);
        $activities = $this->StudentRepositoryInterface->getActivities();
        $aes = $this->aes;
        return response()->json([
         'Message' => 'File submitted successfully',
         'Activities' => view('data.activities-data', compact('aes','activities', 'learningMaterial'))->render()
         ], 200);
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function deleteActivity(Request $request) {

        $this->StudentRepositoryInterface->deleteActivity($request);
        $learningMaterial = $this->StudentRepositoryInterface->getMyLearningMaterial($request);
        $activities = $this->StudentRepositoryInterface->getActivities();
        $aes = $this->aes;
        return response()->json([
         'Message' => 'Submission removed successfully',
         'Activities' => view('data.activities-data', compact('aes','activities', 'learningMaterial'))->render()
         ], 200);
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createUploadActivity(Request $request) {

        $this->StudentRepositoryInterface->createActivity($request);
        $learningMaterial = $this->StudentRepositoryInterface->getMyLearningMaterial($request);
        $activities = $this->StudentRepositoryInterface->getActivities();
        $aes = $this->aes;
        return response()->json([
         'Message' => 'Your activity have submitted successfully',
         'Activities' => view('data.activities-data', compact('aes','activities', 'learningMaterial'))->render()
         ], 200);       
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createDraft(Request $request) {

        $this->StudentRepositoryInterface->createDraft($request);
        $drafts = $this->StudentRepositoryInterface->getDraft();
        $learningMaterial = $this->StudentRepositoryInterface->getMyLearningMaterial($request);
        $aes = $this->aes;
        return response()->json([
         'Message' => 'Your drafts have been saved successfully',
         'Drafts' => view('data.drafts-data', compact('aes','drafts', 'learningMaterial'))->render()
        ], 200);       
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function loadDraft(Request $request) {

        $drafts = $this->StudentRepositoryInterface->loadDraft($request);
        return response()->json([
         'Content' => $drafts->content,
         'DraftID' => $this->aes->encrypt($drafts->id)
        ], 200);       
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteDraft(Request $request) {

        $this->StudentRepositoryInterface->deleteDraft($request);
        $drafts = $this->StudentRepositoryInterface->getDraft();
        $learningMaterial = $this->StudentRepositoryInterface->getMyLearningMaterial($request);
        $aes = $this->aes;
        return response()->json([
         'Message' => 'Your draft have been deleted successfully',
         'Drafts' => view('data.drafts-data', compact('aes','drafts', 'learningMaterial'))->render()
        ], 200);       
     }

}

?>