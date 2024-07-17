<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
       'id',
       'subjectID',
       'question',
       'competency'
    ];

    public function Subjects() {
        return $this->hasOne(Subjects::class, 'id', 'subjectID');
    }
    public function Files() {
        return $this->hasOne(Files::class, 'questionID', 'id');
    }
}
