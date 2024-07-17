<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RegisterRequest;
use App\Models\User;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACE:
use App\Repositories\Interface\StudentRepositoryInterface;
use App\Repositories\Interface\AdminRepositoryInterface;

class RegisterController extends Controller
{
    protected $aes;
    protected $StudentRepositoryInterface;
    protected $AdminRepositoryInterface;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(
        AESCipher $aes,
        StudentRepositoryInterface $StudentRepositoryInterface,
        AdminRepositoryInterface $AdminRepositoryInterface
        ) {
        $this->aes = $aes;
        $this->StudentRepositoryInterface = $StudentRepositoryInterface;
        $this->AdminRepositoryInterface = $AdminRepositoryInterface;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function create()
    {
        $province = $this->StudentRepositoryInterface->getProvince();
        $programs = $this->AdminRepositoryInterface->getProgram();
        $teachers = $this->AdminRepositoryInterface->getTeacher();

        return view('auth.register', compact('province', 'programs', 'teachers'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getMunicipal(Request $request)
    {
        $municipal = $this->StudentRepositoryInterface->getMunicipal($request);
        return response()->json(['Data' => view('auth.address.municipal', ['municipal' => $municipal])->render()], 200);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getBarangay(Request $request)
    {
        $barangay = $this->StudentRepositoryInterface->getBarangay($request);
        return response()->json(['Data' => view('auth.address.barangay', ['barangay' => $barangay])->render()], 200);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createStudent(Request $request) {
        $status = $this->StudentRepositoryInterface->createStudent($request);
        return response()->json([], $status);
     }
}
