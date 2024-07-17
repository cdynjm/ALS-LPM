<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExam extends Model
{
    use HasFactory;

    protected $table = 'studentexam';

    protected $fillable = [
       'id',
       'studentID',
       'type',
       'question',
       'questionID',
       'answerID',
       'subjectID',
       'competency'
    ];

    public function Questions() {
        return $this->hasOne(Questions::class, 'id', 'questionID');
    }
    public function Answers() {
        return $this->hasOne(Answers::class, 'id', 'answerID');
    }
    public function Subjects() {
        return $this->hasOne(Subjects::class, 'id', 'subjectID');
    }
    public function Students() {
        return $this->hasOne(Students::class, 'id', 'studentID');
    }
    public function Files() {
        return $this->hasOne(Files::class, 'questionID', 'questionID');
    }
}

