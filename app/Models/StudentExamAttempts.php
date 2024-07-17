<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExamAttempts extends Model
{
    use HasFactory;

    protected $table = 'studentexam_attempts';

    protected $fillable = [
       'id',
       'studentID',
       'type',
       'studentExamID',
       'score',
       'item',
       'rating'
    ];
    public function Students() {
        return $this->hasOne(Students::class, 'id', 'studentID');
    }
}
