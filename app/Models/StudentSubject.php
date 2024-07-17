<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSubject extends Model
{
    use HasFactory;

    protected $table = 'student_subject';

    protected $fillable = [
       'id',
       'studentID',
       'type',
       'subjectID',
       'score',
       'item',
       'rating'
    ];

    public function Subjects() {
        return $this->hasOne(Subjects::class, 'id', 'subjectID');
    }
}
