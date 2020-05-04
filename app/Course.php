<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tags;

class Course extends Model
{
    protected $guarded = [];

    public function tags()
    {
        return $this->belongsToMany(Tags::Class, 'courses_tags', 'course_id', 'tag_id' )
        ->withTimestamps();
    }

}
