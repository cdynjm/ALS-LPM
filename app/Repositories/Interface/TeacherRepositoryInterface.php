<?php

namespace App\Repositories\Interface;
/**
 * Define a set of methods that a class must implement in order to satisfy a contract.
 *
 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
 */
interface TeacherRepositoryInterface
{
    //EXAMS:
    public function getExam();
    public function getChoices();
    public function createQuestion($request);
    public function deleteQuestion($request);

    //LEARNING MATERIALS:
    public function getFile();
    public function createFile($request);
    public function deleteFile($request);

    //UPDATE PROFILE:
    public function updateTeacher($request);

    //UPDATE SCORE:
    public function updateScore($request);

    public function getStudentActivity($request);
}
