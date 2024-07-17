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
use App\Repositories\Interface\TeacherRepositoryInterface;

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
use App\Models\Files;
use App\Models\Activities;

class TeacherRepository implements TeacherRepositoryInterface {

    protected $aes;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(AESCipher $aes) {
        $this->aes = $aes;
    }


    // EXAMS  REQUESTS: <-------------------------------------------------------> //

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getExam() {

        return Questions::orderBy('created_at', 'ASC')->get();
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getChoices() {

        return Answers::get();
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createQuestion($request) {

        $subjectID = (isset($request->subject)?$this->aes->decrypt($request->subject):"");
        $competency = (isset($request->competency)?$this->aes->decrypt($request->competency):"");

        $dataQuestion = [
            'subjectID' => $subjectID,
            'question' => $request->question,
            'competency' => $competency
        ];

        $question = Questions::create($dataQuestion);

        if($request->file != '') {
            $filename = \Str::slug(\Str::random(6)."-".Carbon::now()).'.'.$request->file->extension(); 
            $transferfile = $request->file('file')->storeAs('public/files/', $filename);
            
            $dataFile = [
                'questionID' => $question->id,
                'file' => $filename
            ];

            Files::create($dataFile);
        }

        foreach($request->choices as $key => $value) {

            if($request->answer == $key) {
                $dataAnswers = [
                    'questionID' => $question->id,
                    'subjectID' => $subjectID,
                    'choices' => $value,
                    'correctAnswer' => 1
                ];
            }
            else {
                $dataAnswers = [
                    'questionID' => $question->id,
                    'subjectID' => $subjectID,
                    'choices' => $value,
                    'correctAnswer' => 0
                ];
            }
            Answers::create($dataAnswers);
        }
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteQuestion($request) {

        $questionID = (isset($request->id)?$this->aes->decrypt($request->id):"");
        Questions::where(['id' => $questionID])->delete();
    }


     // LEARNING MATERIALS  REQUESTS: <-------------------------------------------------------> //

      /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getFile() {

        return LearningMaterials::orderBy('created_at', 'DESC')->get();
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createFile($request) {

      //  $rating = (isset($request->rating)?$this->aes->decrypt($request->rating):"");
        $subjectID = (isset($request->subject)?$this->aes->decrypt($request->subject):"");
        $competency = (isset($request->competency)?$this->aes->decrypt($request->competency):"");

        $filename = \Str::slug($request->filename.'-'.Carbon::now()).'.'.$request->file->extension(); 
        $transferfile = $request->file('file')->storeAs('public/learning-materials/', $filename);

      //  $learningLevels = LearningLevels::where(['subjectID' => $subjectID])->where(['level' => $rating])->first();

        $data = [
            'subjectID' => $subjectID,
            'files' => $filename,
            'filename' => $request->filename,
            'competency' => $competency
        ];

        LearningMaterials::create($data);

        foreach(Students::get() as $st) {
            $learningMaterialsCount = 0;
            $learningMaterialCollectTotal = collect();
            
            foreach(LearningMaterials::get() as $lm) {
                foreach(StudentExam::where(['type' => 1])->where(['studentID' => $st->id])->get() as $ex) {
                    if($ex->studentID == $st->id && $ex->subjectID == $lm->subjectID) {
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

            Students::where(['id' =>  $st->id])->update([
                'learningMaterials' => $learningMaterialsCount
            ]);

            $submissions = Activities::where(['studentID' => $st->id])->distinct('learningMaterialID')->count();
            $learningMaterials = Students::where(['id' => $st->id])->first();

            Students::where(['id' =>  $st->id])->update([
                'progress' => ($submissions / $learningMaterials->learningMaterials) * 100
            ]);
        }
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteFile($request) {

        $id = (isset($request->id)?$this->aes->decrypt($request->id):"");
        $get = LearningMaterials::where(['id' => $id])->first();
        File::delete(public_path("storage/learning-materials/{$get->files}"));
        LearningMaterials::where(['id' => $id])->delete();

        foreach(Students::get() as $st) {
            $learningMaterialsCount = 0;
            $learningMaterialCollectTotal = collect();
            
            foreach(LearningMaterials::get() as $lm) {
                foreach(StudentExam::where(['type' => 1])->where(['studentID' => $st->id])->get() as $ex) {
                    if($ex->studentID == $st->id && $ex->subjectID == $lm->subjectID) {
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

            Students::where(['id' =>  $st->id])->update([
                'learningMaterials' => $learningMaterialsCount
            ]);

            $submissions = Activities::where(['studentID' => $st->id])->distinct('learningMaterialID')->count();
            $learningMaterials = Students::where(['id' => $st->id])->first();

            Students::where(['id' =>  $st->id])->update([
                'progress' => ($submissions / $learningMaterials->learningMaterials) * 100
            ]);
        }
    }


     // UPDATE TEACHER REQUESTS: <-------------------------------------------------------> //

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateTeacher($request) {

        $id = Auth::user()->Teachers->id;

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
    

    // UPDATE TEACHER REQUESTS: <-------------------------------------------------------> //

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateScore($request) {

        $id = (isset($request->scoreID)?$this->aes->decrypt($request->scoreID):"");
        Activities::where(['id' => $id])->update([
            'score' => $request->score,
            'items' => $request->items,
            'status' => 1
        ]);
       
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getStudentActivity($request) {

        $id = (isset($request->id)?$this->aes->decrypt($request->id):"");
        return Activities::where(['id' => $id])->first();
       
    }
}
