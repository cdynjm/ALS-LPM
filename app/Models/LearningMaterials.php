<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningMaterials extends Model
{
    use HasFactory;

    protected $table = 'learning_materials';

    protected $fillable = [
       'id',
       'subjectID',
       'files',
       'filename',
       'competency'
    ];

    public function Subjects() {
        return $this->hasOne(Subjects::class, 'id', 'subjectID');
    }
}
