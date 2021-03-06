<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Course;

class Tags extends Model
{
    protected $guarded = [];
    
    protected $visible = ['id', 'name'];    

    public function courses()
    {
        return $this->belongsToMany(Course::Class, 'courses_tags', 'tag_id', 'course_id' )
        ->withTimestamps();
    }
    public function createTags($tags)
    {
        $tagsIds = [];
        foreach ($tags as $tag) {
            $tagObj = Tags::firstOrCreate(['name' => $tag->name]);
            $tagsIds[] = $tagObj->id;
        }
        return $tagsIds;
    }
}
