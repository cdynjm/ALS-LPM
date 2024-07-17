<?php

namespace App\Repositories\Interface;
/**
 * Define a set of methods that a class must implement in order to satisfy a contract.
 *
 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
 */
interface GlobalRepositoryInterface
{
    //GET STUDENTS:
    public function getFLTResult();
    public function getStudents($request);
    public function getStudentProfile($request);

}
