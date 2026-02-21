<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'description',
        'created_by',
    ];
    public function enrollments()
    {
        return $this->hasMany(\App\Models\Enrollment::class);
    }
}
