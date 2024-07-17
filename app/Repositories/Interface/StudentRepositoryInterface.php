<?php

namespace App\Repositories\Interface;
/**
 * Define a set of methods that a class must implement in order to satisfy a contract.
 *
 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
 */
interface StudentRepositoryInterface
{
    //REGISTRATION:
    public function getProvince();
    public function getMunicipal($request);
    public function getBarangay($request);
    public function createStudent($request);

    //EXAMINATION:
    public function createSubmitExam($request);
    public function createSubmitPostExam($request);

    //GET EXAM RESULTS:
    public function getExamResult($request);
    public function getOverallScore($request);
    public function getSubjectScore($request);
    public function getPostExamResult($request);
    public function getPostOverallScore($request);
    public function getPostSubjectScore($request);
    public function getStudentName($request);

    //PROFILE:
    public function updateProfile($request);

    //MY LEARNING MATERIAL:
    public function getMyLearningMaterial($request);
    public function createUploadActivities($request);
    public function getActivities();
    public function deleteActivity($request);
    public function createActivity($request);
    public function getDraft();
    public function createDraft($request);
    public function loadDraft($request);
    public function deleteDraft($request);
}
