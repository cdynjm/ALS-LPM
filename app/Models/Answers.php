<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    use HasFactory;

    protected $table = 'answers';

    protected $fillable = [
       'id',
       'questionID',
       'subjectID',
       'choices',
       'correctAnswer'
    ];

    public function Questions() {
        return $this->hasOne(Questions::class, 'id', 'questionID');
    }
}
