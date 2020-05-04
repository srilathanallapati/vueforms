<?php

namespace App\Http\Controllers;

use App\Course;
use App\Tags;

class CoursesController extends Controller
{
    public function index()
    {       
        $courses = Course::with('tags')->get();                 
        return view('courses.index', compact('courses'));
    }
    
    public function create()
    {    
        $tags = Tags::all();
        return view('courses.create',[
            'tags'=> $tags
        ]);
    }    
    public function store()
    {           
        $attributes = $this->validate(request(), [
            'name' => 'required',
            'description' => 'required',
            'catalog_image' => ['required', 'image'],
            'tags' => ['required']
        ]);
        $courseAttributes = [
            'name' => $attributes['name'],
            'description' => $attributes['description'],
        ];      
        if (request('catalog_image')) {            
           $courseAttributes['catalog_image'] = request('catalog_image')->store('catalog_images');
        }       
        $course = new Course($courseAttributes);
        $course->save();

        if(request()->has('tags') && request('tags')!==null){            
            $selectedTags = json_decode(request('tags'));            
            $selectedTagsIds = [];
            foreach ($selectedTags as $tag) {                
                $tagObj = Tags::firstOrCreate(['name' => $tag->name]);                             
                $selectedTagsIds[] = $tagObj->id;
            }                     
            $course->tags()->attach($selectedTagsIds);
        }
        
        return ['message' => 'Course Created'];
        //return redirect('/courses');
    }
    public function edit(Course $course)
    {                  
        $tags = Tags::all();
        
        return view('courses.create', [                    
            'course_tags' => $course->tags(),
        ]);
    }

    public function update(Course $course)
    {
        if (request('avatar')) {
            $attributes['avatar'] = request('avatar')->store('avatars');
        }
        
        $user->update($attributes);

    }
    public function fileupload()
    {        
        $attributes = $this->validate(request(), [
            'file' => ['required', 'image']           
        ]);         
        if (request('file')) {                        
           $attr = request('file')->store('catalog_images');           
        }
        return ['message' => 'Image uploaded'];
    }

}
