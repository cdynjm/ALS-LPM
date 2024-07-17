<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACE:
use App\Repositories\Interface\AdminRepositoryInterface;  
use App\Repositories\Interface\TeacherRepositoryInterface;  
use App\Repositories\Interface\StudentRepositoryInterface;
use App\Repositories\Interface\GlobalRepositoryInterface; 

class HomeController extends Controller
{
    protected $aes;
    protected $AdminRepositoryInterface;
    protected $StudentRepositoryInterface;
    protected $TeacherRepositoryInterface;
    protected $GlobalRepositoryInterface;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        AESCipher $aes,
        TeacherRepositoryInterface $TeacherRepositoryInterface,
        StudentRepositoryInterface $StudentRepositoryInterface,
        AdminRepositoryInterface $AdminRepositoryInterface,
        GlobalRepositoryInterface $GlobalRepositoryInterface
        ) {
        $this->aes = $aes;
        $this->TeacherRepositoryInterface = $TeacherRepositoryInterface;
        $this->AdminRepositoryInterface = $AdminRepositoryInterface;
        $this->StudentRepositoryInterface = $StudentRepositoryInterface;
        $this->GlobalRepositoryInterface = $GlobalRepositoryInterface;
    }
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function admin()
    {
        return view('pages.admin.dashboard');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function teachers(Request $request)
    {

        $students = $this->GlobalRepositoryInterface->getStudents($request);
        $learningMaterials = $this->TeacherRepositoryInterface->getFile();
        $exams = $this->StudentRepositoryInterface->getExamResult($request); 
        $activities = $this->StudentRepositoryInterface->getActivities();
        
        return view('pages.teachers.dashboard', compact('activities', 'exams', 'learningMaterials', 'students'));
        
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function students(Request $request)
    {
        $learningMaterials = $this->TeacherRepositoryInterface->getFile();
        $subjectScore = $this->StudentRepositoryInterface->getSubjectScore($request);
        $overallScore = $this->StudentRepositoryInterface->getOverallScore($request);
        $postOverallScore = $this->StudentRepositoryInterface->getPostOverallScore($request);
        $exams = $this->StudentRepositoryInterface->getExamResult($request);
        $activities = $this->StudentRepositoryInterface->getActivities();
        $competencies = $this->AdminRepositoryInterface->getCompetency();

        return view('pages.students.dashboard', compact('postOverallScore', 'competencies','activities','exams', 'learningMaterials', 'subjectScore', 'overallScore'));
    }
}
