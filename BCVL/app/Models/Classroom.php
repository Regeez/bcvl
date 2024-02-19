<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'subject',
        'yearsec',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'classroom_user');
    }

}
