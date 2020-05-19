<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $courseAttributes = $this->ValidateCourse();
        if (request('catalog_image')) {            
           $courseAttributes['catalog_image'] = request('catalog_image')->store('catalog_images');
        }
        $course = new Course($courseAttributes);
        $course->save();

        if(request()->has('tags') && request('tags')!==null){
            $selectedTags = json_decode(request('tags'));
            $tag = new Tags();
            $selectedTagsIds = $tag->createTags($selectedTags);
            $course->tags()->attach($selectedTagsIds);
        }

        return ['message' => 'Course Created'];        
        
    }
    public function edit(Course $course)
    {    
        $tags = Tags::all();  
        $course->tags;

        return view('courses.edit',[
            'course'=>$course,            
            'tags'=> $tags
        ]);

    }
    public function update(Course $course)
    {        
        $courseAttributes = $this->ValidateCourse();
        if (request('catalog_image')) {
           $courseAttributes['catalog_image'] = request('catalog_image')->store('catalog_images');
        }
        $course->update($courseAttributes);

        if(request()->has('tags') && request('tags')!==null){
            $selectedTags = json_decode(request('tags'));
            $tag = new Tags();
            $selectedTagsIds = $tag->createTags($selectedTags);
            $course->tags()->sync($selectedTagsIds);            
        }

        return ['message' => 'Course Updated'];
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
    protected function ValidateCourse()
    {        
        $attributes = $this->validate(request(),[
            'name' => 'required',
            'description' => 'required',
            'catalog_image' => ['required', 'image'],
            'tags' => ['required']
        ]);
        $courseAttributes = [
            'name' => $attributes['name'],
            'description' => $attributes['description'],
        ];                 
        return $courseAttributes;
    }

}
