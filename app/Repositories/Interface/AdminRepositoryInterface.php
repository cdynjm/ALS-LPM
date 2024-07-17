<?php

namespace App\Repositories\Interface;
/**
 * Define a set of methods that a class must implement in order to satisfy a contract.
 *
 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
 */
interface AdminRepositoryInterface
{

    //TEACHERS:
    public function getTeacher();
    public function createTeacher($request);
    public function updateTeacher($request);
    public function deleteTeacher($request);

    //PROGRAMS:
    public function getProgram();
    public function createProgram($request);
    public function updateProgram($request);
    public function deleteProgram($request);

    //SUBJECTS:
    public function getSubject();
    public function createSubject($request);
    public function updateSubject($request);
    public function deleteSubject($request);

    //COMPETENCIES
    public function getCompetency();
    public function createCompetency($request);

    //PROFILE:
    public function updateProfile($request);

    //LEARNING LEVELS:
    public function getLearningLevel();

}
