<?php

namespace App\Repositories\Implementation;

use Hash;
use Session;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use TCPDF;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACE:
use App\Repositories\Interface\StudentRepositoryInterface;

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
use App\Models\Activities;
use App\Models\Drafts;

class StudentRepository implements StudentRepositoryInterface {

    protected $aes;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(AESCipher $aes) {
        $this->aes = $aes;
    }


    // GET REGISTRATION REQUESTS: <-------------------------------------------------------> //

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getProvince() {

        return Province::orderBy('provDesc', 'ASC')->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getMunicipal($request) {

        $province = (isset($request->province)?$this->aes->decrypt($request->province):"");
        return Municipal::where(['provCode' => $province])
                ->orderBy('citymunDesc', 'ASC')
                ->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getBarangay($request) {

        $municipal = (isset($request->municipal)?$this->aes->decrypt($request->municipal):"");
        return Barangay::where(['citymunCode' => $municipal])
                ->orderBy('brgyDESC', 'ASC')
                ->get();
    }


    // REGISTER STUDENT REQUESTS: <-------------------------------------------------------> //

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createStudent($request) {

        $province = (isset($request->province)?$this->aes->decrypt($request->province):"");
        $municipal = (isset($request->municipal)?$this->aes->decrypt($request->municipal):"");
        $barangay = (isset($request->barangay)?$this->aes->decrypt($request->barangay):"");
        $education = (isset($request->education)?$this->aes->decrypt($request->education):"");
        $program = (isset($request->program)?$this->aes->decrypt($request->program):"");
        $teacher = (isset($request->teacher)?$this->aes->decrypt($request->teacher):"");

        foreach(User::get() as $get) {
            if($get->email == $request->email) {
                return 500;
            }
        }

        $studentData = [
            'lastname' => ucwords($request->lastname),
            'firstname' => ucwords($request->firstname),
            'middlename' => ucwords($request->middlename),
            'birthdate' => $request->birthdate,
            'birthplace' => $request->birthplace,
            'education' => $education,
            'street' => $request->street,
            'province' => $province,
            'municipality' => $municipal,
            'barangay' => $barangay,
            'clc' => $request->clc,
            'division' => $request->division,
            'district' => $request->district,
            'program' => $program,
            'teacher' => $teacher,
            'progress' => 0,
            'learningMaterials' => 0,
            'submissions' => 0,
            'newSubmissions' => 0,
            'status' => 0,
            'status' => 1
        ];

        $saveStudent = Students::create($studentData);

        $studentUserData = [
            'studentID' => $saveStudent->id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 3,
        ];

        $user = User::create($studentUserData);

        auth()->login($user);

        return 200;
    }


     // UPDATE STUDENT REQUESTS: <-------------------------------------------------------> //

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateProfile($request) {

        $province = (isset($request->province)?$this->aes->decrypt($request->province):"");
        $municipal = (isset($request->municipal)?$this->aes->decrypt($request->municipal):"");
        $barangay = (isset($request->barangay)?$this->aes->decrypt($request->barangay):"");
        $education = (isset($request->education)?$this->aes->decrypt($request->education):"");
        $program = (isset($request->program)?$this->aes->decrypt($request->program):"");
        $teacher = (isset($request->teacher)?$this->aes->decrypt($request->teacher):"");

        try {
           
            User::where(['studentID' => Auth::user()->Students->id])
                ->update(['email' => $request->email]);

            if(!empty($request->password)) {
                User::where(['studentID' => Auth::user()->Students->id])
                ->update(['password' => Hash::make($request->password)]);
            }

            if(empty($request->address)) {

                $studentData = [
                    'lastname' => ucwords($request->lastname),
                    'firstname' => ucwords($request->firstname),
                    'middlename' => ucwords($request->middlename),
                    'birthdate' => $request->birthdate,
                    'birthplace' => $request->birthplace,
                    'education' => $education,
                    'clc' => $request->clc,
                    'division' => $request->division,
                    'district' => $request->district,
                    'program' => $program,
                    'teacher' => $teacher,
                ];
            }
            else {
                $studentData = [
                    'lastname' => $request->lastname,
                    'firstname' => $request->firstname,
                    'middlename' => $request->middlename,
                    'birthdate' => $request->birthdate,
                    'birthplace' => $request->birthplace,
                    'education' => $education,
                    'street' => $request->street,
                    'province' => $province,
                    'municipality' => $municipal,
                    'barangay' => $barangay,
                    'clc' => $request->clc,
                    'division' => $request->division,
                    'district' => $request->district,
                    'program' => $program,
                    'teacher' => $teacher,
                ];
            }

            Students::where(['id' => Auth::user()->Students->id])->update($studentData);
            return 200;
        }
        catch (QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return 500;
            }
        }
    }


    // TAKE EXAM REQUESTS: <-------------------------------------------------------> //

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createSubmitExam($request) {

        $score = 0;
        $item = 0;
        $rating = 0;

        foreach(Subjects::get() as $get) {
            StudentSubject::create([
                'studentID' => Auth::user()->Students->id,
                'type' => 1,
                'subjectID' => $get->id,
                'score' => 0,
                'item' => 0,
                'rating' => 0
            ]);
        }

        foreach($request->questionID as $key => $value) {

            $item += 1;
            $questionID = (isset($value)?$this->aes->decrypt($value):"");
            $answerID = (isset($request->answer[$questionID])?$this->aes->decrypt($request->answer[$questionID]):"");
            
            $answers = Answers::where(['id' => $answerID])->first();
            $subject = StudentSubject::where(['type' => 1])->where(['studentID' => Auth::user()->Students->id])->where(['subjectID' => $answers->Questions->subjectID])->first();

            if($answers->correctAnswer == 1) {
                $score += 1;
            }
            
            if($answers->subjectID == $subject->subjectID) {
                $subject->item += 1;
                if($answers->correctAnswer == 1) {
                    $subject->score += 1;
                }
                $subject->rating = ($subject->score / $subject->item) * 100;
                StudentSubject::where(['studentID' => Auth::user()->Students->id])
                                ->where(['subjectID' => $answers->Questions->subjectID])
                                ->where(['type' => 1])
                                ->update([
                                    'score' => $subject->score,
                                    'item' => $subject->item,
                                    'rating' => $subject->rating
                                ]);
            }

            $data = [
                'studentID' => Auth::user()->Students->id,
                'type' => 1,
                'question' => $answers->Questions->question,
                'questionID' => $questionID,
                'answerID' => $answerID,
                'subjectID' => $answers->Questions->subjectID,
                'competency' => $answers->Questions->competency,
            ];

            StudentExam::create($data);
        }

        $rating = ($score / $item) * 100;

        StudentExamAttempts::create([
            'studentID' => Auth::user()->Students->id,
            'type' => 1,
            'score' => $score,
            'item' => $item,
            'rating' => $rating
        ]);

        $learningMaterialsCount = 0;
        $learningMaterialCollectTotal = collect();
        
        foreach(LearningMaterials::get() as $lm) {
            foreach(StudentExam::where(['type' => 1])->where(['studentID' => Auth::user()->Students->id])->get() as $ex) {
                if($ex->subjectID == $lm->subjectID) {
                    if($lm->competency == $ex->competency) {
                        if(!$learningMaterialCollectTotal->contains($lm->id)) {
                            if($ex->Answers->correctAnswer == 0) {
                                $learningMaterialsCount += 1;
                                $learningMaterialCollectTotal->push($lm->id);
                            }
                        }
                    }
                }
            }
        }

        Students::where(['id' =>  Auth::user()->Students->id])->update([
            'learningMaterials' => $learningMaterialsCount,
            'status' => 0
        ]);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createSubmitPostExam($request) {

        $score = 0;
        $item = 0;
        $rating = 0;

        foreach(Subjects::get() as $get) {
            StudentSubject::create([
                'studentID' => Auth::user()->Students->id,
                'type' => 2,
                'subjectID' => $get->id,
                'score' => 0,
                'item' => 0,
                'rating' => 0
            ]);
        }

        foreach($request->questionID as $key => $value) {

            $item += 1;
            $questionID = (isset($value)?$this->aes->decrypt($value):"");
            $answerID = (isset($request->answer[$questionID])?$this->aes->decrypt($request->answer[$questionID]):"");
            
            $answers = Answers::where(['id' => $answerID])->first();
            $subject = StudentSubject::where(['type' => 2])->where(['studentID' => Auth::user()->Students->id])->where(['subjectID' => $answers->Questions->subjectID])->first();

            if($answers->correctAnswer == 1) {
                $score += 1;
            }
            
            if($answers->subjectID == $subject->subjectID) {
                $subject->item += 1;
                if($answers->correctAnswer == 1) {
                    $subject->score += 1;
                }
                $subject->rating = ($subject->score / $subject->item) * 100;
                StudentSubject::where(['studentID' => Auth::user()->Students->id])
                                ->where(['subjectID' => $answers->Questions->subjectID])
                                ->where(['type' => 2])
                                ->update([
                                    'score' => $subject->score,
                                    'item' => $subject->item,
                                    'rating' => $subject->rating
                                ]);
            }

            $data = [
                'studentID' => Auth::user()->Students->id,
                'type' => 2,
                'question' => $answers->Questions->question,
                'questionID' => $questionID,
                'answerID' => $answerID,
                'subjectID' => $answers->Questions->subjectID,
                'competency' => $answers->Questions->competency,
            ];

            StudentExam::create($data);
        }

        $rating = ($score / $item) * 100;

        StudentExamAttempts::create([
            'studentID' => Auth::user()->Students->id,
            'type' => 2,
            'score' => $score,
            'item' => $item,
            'rating' => $rating
        ]);
        
        Students::where(['id' =>  Auth::user()->Students->id])->update(['status' => 0]);
    }


    // GET EXAM RESULT REQUESTS: <-------------------------------------------------------> //

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getStudentName($request) {
        if(Auth::user()->role == 1 || Auth::user()->role == 2) {
            $id = (isset($request->id)?$this->aes->decrypt($request->id):"");
            return Students::where(['id' => $id])->first();
        }
        else {
            return null;
        }
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getExamResult($request) {

        if(Auth::user()->role == 1 || Auth::user()->role == 2) {
            if(\Str::contains(\Request::path(), 'teacher-dashboard'))
                return StudentExam::where(['type' => 1])->get();
            else {
                $id = (isset($request->id)?$this->aes->decrypt($request->id):"");
                return StudentExam::where(['studentID' => $id])->where(['type' => 1])->get();
            }
       }
        else
            return StudentExam::where(['studentID' => Auth::user()->Students->id])->where(['type' => 1])->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getOverallScore($request) {

        if(Auth::user()->role == 1 || Auth::user()->role == 2) {
            $id = $request->id ? $this->aes->decrypt($request->id) : "";
            return StudentExamAttempts::where(['type' => 1])->where(['studentID' => $id])->first();
        }
        else
            return StudentExamAttempts::where(['type' => 1])->where(['studentID' => Auth::user()->Students->id])->first();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getSubjectScore($request) {

        if(Auth::user()->role == 1 || Auth::user()->role == 2) {
            if(\Str::contains(\Request::path(), 'teacher-dashboard'))
                return StudentSubject::where(['type' => 1])->get();
            else {
                $id = (isset($request->id)?$this->aes->decrypt($request->id):"");
                return StudentSubject::where(['type' => 1])->where(['studentID' => $id])->get();
            }
        }
       else
            return StudentSubject::where(['type' => 1])->where(['studentID' => Auth::user()->Students->id])->get();
    }

    // 2:
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getPostExamResult($request) {

        if(Auth::user()->role == 1 || Auth::user()->role == 2) {
            if(\Str::contains(\Request::path(), 'teacher-dashboard'))
                return StudentExam::where(['type' => 2])->get();
            else {
                $id = (isset($request->id)?$this->aes->decrypt($request->id):"");
                return StudentExam::where(['studentID' => $id])->where(['type' => 2])->get();
            }
       }
        else
            return StudentExam::where(['studentID' => Auth::user()->Students->id])->where(['type' => 2])->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getPostOverallScore($request) {

        if(Auth::user()->role == 1 || Auth::user()->role == 2) {
            $id = $request->id ? $this->aes->decrypt($request->id) : "";
            return StudentExamAttempts::where(['type' => 2])->where(['studentID' => $id])->first();
        }
        else
            return StudentExamAttempts::where(['type' => 2])->where(['studentID' => Auth::user()->Students->id])->first();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getPostSubjectScore($request) {

        if(Auth::user()->role == 1 || Auth::user()->role == 2) {
            if(\Str::contains(\Request::path(), 'teacher-dashboard'))
                return StudentSubject::where(['type' => 2])->get();
            else {
                $id = (isset($request->id)?$this->aes->decrypt($request->id):"");
                return StudentSubject::where(['type' => 2])->where(['studentID' => $id])->get();
            }
        }
       else
            return StudentSubject::where(['type' => 2])->where(['studentID' => Auth::user()->Students->id])->get();
    }


     // GET MY LEARNING MATERIAL REQUESTS: <-------------------------------------------------------> //

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getMyLearningMaterial($request) {

        $learningMaterialID = $request->id ? $this->aes->decrypt($request->id) : "";
        return LearningMaterials::where(['id' => $learningMaterialID])->first();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getActivities() {

         return Activities::get();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createUploadActivities($request) {
        $count = 0;
        foreach ($request->file('files') as $file) {
            $id = $request->id ? $this->aes->decrypt($request->id) : "";
            $timestamp = Carbon::now();
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $customFileName = \Str::slug($originalName.'-'.$timestamp).'.'.$extension;
            $transferfile = $file->storeAs('public/activities/', $customFileName);    
            $data = [
                'studentID' => Auth::user()->studentID,
                'learningMaterialID' => $id,
                'filename' => $customFileName,
                'score' => 0,
                'items' => 0
            ];
            Activities::create($data);
            $count += 1;
        }

        $student = Students::where(['id' => Auth::user()->Students->id])->first();
        $student->submissions += $count;
        $student->newSubmissions += $count;
        Students::where(['id' => Auth::user()->Students->id])->update([
            'submissions' => $student->submissions,
            'newSubmissions' => $student->newSubmissions
        ]);

        $submissions = Activities::where(['studentID' => Auth::user()->Students->id])->distinct('learningMaterialID')->count();
        $learningMaterials = Students::where(['id' => Auth::user()->Students->id])->first();

        Students::where(['id' => Auth::user()->Students->id])->update([
            'progress' => ($submissions / $learningMaterials->learningMaterials) * 100
        ]);
     }
      /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteActivity($request) {

        $activityID = $request->activityID ? $this->aes->decrypt($request->activityID) : "";
        $get = Activities::where(['id' => $activityID])->first();
        File::delete(public_path("storage/activities/{$get->filename}"));
        Activities::where(['id' => $activityID])->delete();

        $student = Students::where(['id' => Auth::user()->Students->id])->first();
       
        $student->submissions -= 1;
        if($student->newSubmissions != 0) {
            $student->newSubmissions -= 1;
        }
        Students::where(['id' => Auth::user()->Students->id])->update([
            'submissions' => $student->submissions,
            'newSubmissions' => $student->newSubmissions
        ]);
    
        $submissions = Activities::where(['studentID' => Auth::user()->Students->id])->distinct('learningMaterialID')->count();
        $learningMaterials = Students::where(['id' => Auth::user()->Students->id])->first();

        Students::where(['id' => Auth::user()->Students->id])->update([
            'progress' => ($submissions / $learningMaterials->learningMaterials) * 100
        ]);
     }

     public function createActivity($request) {

        $id = $request->id ? $this->aes->decrypt($request->id) : "";
        $student = Students::where(['id' => Auth::user()->Students->id])->first();

        $filename = \Str::slug($student->firstname."-".$student->lastname."-".Carbon::now()).".pdf"; // Make sure to use .pdf extension
        $content = $request->input('documentContent');
        
        // Initialize TCPDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        
        // Assuming $content holds your HTML content
        $pdf->writeHTML($content, true, false, true, false, '');
        
        // Capture the PDF output as a string
        $pdfContent = $pdf->Output($filename, 'S');
        
        // Define the path within the public disk
        $path = 'activities/' . $filename; // Adjust the path where you want to save inside public
        
        // Save the PDF to a file in the public storage
        Storage::disk('public')->put($path, $pdfContent);

        $data = [
            'studentID' => Auth::user()->studentID,
            'learningMaterialID' => $id,
            'filename' => $filename,
            'score' => 0,
            'items' => 0
        ];
        Activities::create($data);

        $student = Students::where(['id' => Auth::user()->Students->id])->first();
        $student->submissions += 1;
        $student->newSubmissions += 1;
        Students::where(['id' => Auth::user()->Students->id])->update([
            'submissions' => $student->submissions,
            'newSubmissions' => $student->newSubmissions
        ]);

        $submissions = Activities::where(['studentID' => Auth::user()->Students->id])->distinct('learningMaterialID')->count();
        $learningMaterials = Students::where(['id' => Auth::user()->Students->id])->first();

        Students::where(['id' => Auth::user()->Students->id])->update([
            'progress' => ($submissions / $learningMaterials->learningMaterials) * 100
        ]);
     }
      /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getDraft() {

        return Drafts::get();
     }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createDraft($request) {

        $id = $request->id ? $this->aes->decrypt($request->id) : "";
        $student = Students::where(['id' => Auth::user()->Students->id])->first();
        $content = $request->input('content');

        if($request->draftID == 0) {
            Drafts::create([
                'studentID' => Auth::user()->Students->id,
                'learningMaterialID' => $id,
                'filename' => \Str::slug('Drafts-'.$student->lastname.'-'.Carbon::now()),
                'content' => $content
            ]);
        }
        else {
            $draftID = $request->draftID ? $this->aes->decrypt($request->draftID) : "";
            Drafts::where(['id' => $draftID])->update([
                'content' => $content,
                'filename' => \Str::slug('Drafts-'.$student->lastname.'-'.Carbon::now()),
            ]);
        }
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function loadDraft($request) {

        $id = $request->id ? $this->aes->decrypt($request->id) : "";
        return Drafts::where(['id' => $id])->first();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteDraft($request) {

        $draftID = $request->draftID ? $this->aes->decrypt($request->draftID) : "";
        Drafts::where(['id' => $draftID])->delete();
     }
    
}