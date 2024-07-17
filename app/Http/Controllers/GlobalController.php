<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACE:
use App\Repositories\Interface\GlobalRepositoryInterface; 
use App\Repositories\Interface\AdminRepositoryInterface;  
use App\Repositories\Interface\TeacherRepositoryInterface;  
use App\Repositories\Interface\StudentRepositoryInterface; 

class GlobalController extends Controller
{
    protected $aes;
    protected $GlobalRepositoryInterface;
    protected $AdminRepositoryInterface;
    protected $StudentRepositoryInterface;
    protected $TeacherRepositoryInterface;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        AESCipher $aes, 
        GlobalRepositoryInterface $GlobalRepositoryInterface,
        TeacherRepositoryInterface $TeacherRepositoryInterface,
        StudentRepositoryInterface $StudentRepositoryInterface,
        AdminRepositoryInterface $AdminRepositoryInterface
        ) {
        $this->aes = $aes;
        $this->GlobalRepositoryInterface = $GlobalRepositoryInterface;
        $this->TeacherRepositoryInterface = $TeacherRepositoryInterface;
        $this->AdminRepositoryInterface = $AdminRepositoryInterface;
        $this->StudentRepositoryInterface = $StudentRepositoryInterface;
    }


    // GET STUDENTS REQUESTS: <-------------------------------------------------------> //

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getStudents(Request $request) {
       
        $students = $this->GlobalRepositoryInterface->getStudents($request);
        $fltResult = $this->GlobalRepositoryInterface->getFLTResult();
        return view('pages.global.students', compact('students', 'fltResult'));
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getStudentProfile(Request $request) {
       
        $exams = $this->StudentRepositoryInterface->getExamResult($request);
        $overallScore = $this->StudentRepositoryInterface->getOverallScore($request);
        $subjectScore = $this->StudentRepositoryInterface->getSubjectScore($request);

        $postExams = $this->StudentRepositoryInterface->getPostExamResult($request);
        $postOverallScore = $this->StudentRepositoryInterface->getPostOverallScore($request);
        $postSubjectScore = $this->StudentRepositoryInterface->getPostSubjectScore($request);

        $choices = $this->TeacherRepositoryInterface->getChoices();
        $subjects = $this->AdminRepositoryInterface->getSubject();

        $student = $this->GlobalRepositoryInterface->getStudentProfile($request);
        return view('pages.global.student-profile', compact('postExams','postOverallScore','postSubjectScore','student','subjects', 'exams', 'choices', 'overallScore', 'subjectScore'));
    }
}

?>