<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    protected $table = "students";

    protected $fillable = [
        'id',
        'lastname',
        'firstname',
        'middlename',
        'birthdate',
        'birthplace',
        'education',
        'street',
        'province',
        'municipality',
        'barangay',
        'clc',
        'division',
        'district',
        'program',
        'teacher',
        'progress',
        'learningMaterials',
        'submissions',
        'newSubmissions',
        'status'
    ];

    public function Province() {
        return $this->hasOne(Province::class, 'provCode', 'province');
    }
    public function Municipal() {
        return $this->hasOne(Municipal::class, 'citymunCode', 'municipality');
    }
    public function Barangay() {
        return $this->hasOne(Barangay::class, 'brgyCode', 'barangay');
    }
    public function Programs() {
        return $this->hasOne(Programs::class, 'id', 'program');
    }
    public function Teachers() {
        return $this->hasOne(Teachers::class, 'id', 'teacher');
    }
    public function User() {
        return $this->hasOne(User::class, 'studentID', 'id');
    }
}
