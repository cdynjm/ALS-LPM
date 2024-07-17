<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teachers extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $fillable = [
       'id',
       'name',
       'position',
       'address',
       'contactNumber',
       'dateEmployed'
    ];

    public function User() {
        return $this->hasOne(User::class, 'teacherID', 'id');
    }
}
