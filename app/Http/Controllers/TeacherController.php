<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Students;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACE:
use App\Repositories\Interface\TeacherRepositoryInterface;  
use App\Repositories\Interface\AdminRepositoryInterface; 
use App\Repositories\Interface\StudentRepositoryInterface;  
use App\Repositories\Interface\GlobalRepositoryInterface;  

//REQUEST VALIDATIONS:
use App\Http\Requests\LearningMaterialsRequest;
use App\Http\Requests\ScoreRequest;

class TeacherController extends Controller
{
    protected $aes;
    protected $TeacherRepositoryInterface;
    protected $AdminRepositoryInterface;
    protected $StudentRepositoryInterface;
    protected $GlobalRepositoryInterface;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        AESCipher $aes,
        TeacherRepositoryInterface $TeacherRepositoryInterface,
        AdminRepositoryInterface $AdminRepositoryInterface,
        StudentRepositoryInterface $StudentRepositoryInterface,
        GlobalRepositoryInterface $GlobalRepositoryInterface
        ) {
        $this->aes = $aes;
        $this->AdminRepositoryInterface = $AdminRepositoryInterface;
        $this->TeacherRepositoryInterface = $TeacherRepositoryInterface;
        $this->StudentRepositoryInterface = $StudentRepositoryInterface;
        $this->GlobalRepositoryInterface = $GlobalRepositoryInterface;
    }


     // EXAMS REQUESTS: <-------------------------------------------------------> //

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getExam() {

        $subjects = $this->AdminRepositoryInterface->getSubject();
        $exams = $this->TeacherRepositoryInterface->getExam();
        $choices = $this->TeacherRepositoryInterface->getChoices();

        return view('pages.teachers.exams', compact('subjects', 'exams', 'choices'));
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createQuestion(Request $request) {
        $this->TeacherRepositoryInterface->createQuestion($request);
        $subjects = $this->AdminRepositoryInterface->getSubject();
        $exams = $this->TeacherRepositoryInterface->getExam();
        $choices = $this->TeacherRepositoryInterface->getChoices();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Question created successfully',
            'Exam' => view('data.exam-data', compact('subjects', 'exams', 'choices', 'aes'))->render()
        ], 200);
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteQuestion(Request $request) {

        $this->TeacherRepositoryInterface->deleteQuestion($request);
        $subjects = $this->AdminRepositoryInterface->getSubject();
        $exams = $this->TeacherRepositoryInterface->getExam();
        $choices = $this->TeacherRepositoryInterface->getChoices();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Question deleted successfully',
            'Exam' => view('data.exam-data', compact('subjects', 'exams', 'choices', 'aes'))->render()
        ], 200);
     }


    // PROFILE REQUESTS: <-------------------------------------------------------> //

    /**
    * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
    public function getProfile() {
        return view('pages.teachers.profile');
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateProfile(Request $request) {
        $status = $this->TeacherRepositoryInterface->updateTeacher($request);
        return response()->json([], $status);
     }


     // LEARNING MATERIALS REQUESTS: <-------------------------------------------------------> //

    /**
    * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
    public function getLearningMaterials() {
        $subjects = $this->AdminRepositoryInterface->getSubject();
        $learningMaterials = $this->TeacherRepositoryInterface->getFile();
        return view('pages.teachers.learning-materials', compact('subjects', 'learningMaterials'));
     }
     /**
    * Handle an incoming request.               
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
    public function createFile(LearningMaterialsRequest $request) {

        $this->TeacherRepositoryInterface->createFile($request);
        $subjects = $this->AdminRepositoryInterface->getSubject();
        $learningMaterials = $this->TeacherRepositoryInterface->getFile();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'File uploaded successfully',
            'LearningMaterials' => view('data.learning-materials-data', compact('subjects', 'learningMaterials', 'aes'))->render()
        ], 200);
     }
     /**
     * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
    public function deleteFile(Request $request) {

        $this->TeacherRepositoryInterface->deleteFile($request);
        $subjects = $this->AdminRepositoryInterface->getSubject();
        $learningMaterials = $this->TeacherRepositoryInterface->getFile();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'File deleted successfully',
            'LearningMaterials' => view('data.learning-materials-data', compact('subjects', 'learningMaterials', 'aes'))->render()
        ], 200);
     }


    // STUDENT SUBMISSIONS REQUESTS: <-------------------------------------------------------> //

    /**
     * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
     public function getStudentSubmissions(Request $request) {

        $learningMaterials = $this->TeacherRepositoryInterface->getFile();
        $subjectScore = $this->StudentRepositoryInterface->getSubjectScore($request);
        $exams = $this->StudentRepositoryInterface->getExamResult($request);
        $activities = $this->StudentRepositoryInterface->getActivities();
        $students = $this->GlobalRepositoryInterface->getStudents($request);
        $competencies = $this->AdminRepositoryInterface->getCompetency();

        $request->session()->put('studentID', $students->id);
        $id = $this->aes->decrypt($request->id);
        Students::where(['id' => $id])->update(['newSubmissions' => 0]);
        
        return view('pages.teachers.view-student-submission', compact('competencies','students', 'activities','exams', 'learningMaterials', 'subjectScore'));
     }
    /**
     * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
    public function updateScore(ScoreRequest $request) {

        $this->TeacherRepositoryInterface->updateScore($request);
        $learningMaterials = $this->TeacherRepositoryInterface->getFile();
        $subjectScore = $this->StudentRepositoryInterface->getSubjectScore($request);
        $exams = $this->StudentRepositoryInterface->getExamResult($request);
        $activities = $this->StudentRepositoryInterface->getActivities();
        $students = $this->GlobalRepositoryInterface->getStudents($request);
        $competencies = $this->AdminRepositoryInterface->getCompetency();
        $aes = $this->aes;

        return response()->json([
            'Message' => 'Activity score updated successfully',
            'StudentSubmissions' => view('data.student-submissions-data', compact('aes', 'competencies','students', 'activities','exams', 'learningMaterials', 'subjectScore'))->render()
        ], 200);
     }

     /**
     * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
    public function getStudentActivity(Request $request) {

        $activity = $this->TeacherRepositoryInterface->getStudentActivity($request);
        return view('pages.teachers.view-student-activity', compact('activity'));
     }
}

?>