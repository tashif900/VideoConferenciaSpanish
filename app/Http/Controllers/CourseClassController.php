<?php

namespace App\Http\Controllers;

use Validator;
use App\Course;
use App\CourseClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseClassController extends Controller
{

    public function saveCourseClass(Request $request){
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|min:3',
            'hour_start' => 'required',
            'hour_end' => 'required',
            'type_class' => 'required',
            'state' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $course = Course::find($request->course_id);

        $roomId = null;
        if ($course->type_course == 2) {
            $roomId = $this->roomNameGenerator();
        }

        $course_class = new CourseClass();
        $course_class->name = $request->name;
        $course_class->description = $request->description;
        $course_class->price = $request->price;
        $course_class->hour_start = $request->hour_start;
        $course_class->hour_end = $request->hour_end;
        $course_class->photo = $request->photo;
        $course_class->url_presentation = $request->url_presentation;
        $course_class->url_video = $request->url_video;
        $course_class->url_room = $request->url_room;
        $course_class->room_password = $request->room_password;
        $course_class->room_name = $request->room_name;
        $course_class->room_id = $roomId;
        $course_class->type_class = $request->type_class;
        $course_class->state = $request->state;
        $course_class->course_id = $request->course_id;
        $course_class->thematic_id = $request->thematic_id;
        $course_class->user_id = Auth::id();
        $course_class->save();

        return response()->json($course_class,201);

    }

    public function updateCourseClass(Request $request){
        $rules = [
            'course_clase_id' => 'required',
            'name' => 'required|min:3',
            'description' => 'required|min:3',
            'hour_start' => 'required',
            'hour_end' => 'required',
            'type_class' => 'required',
            'state' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $slug = Str::slug($request->name, '-') . '-' . time();

        $course = Course::find($request->course_id);

        $roomId = null;
        if ($course->type_course == 2) {
            $roomId = $this->roomNameGenerator();
        }

        $course_class = CourseClass::where('id',$request->course_clase_id)->first();
        $course_class->name = $request->name;
        $course_class->description = $request->description;
        $course_class->slug = $slug;
        $course_class->price = $request->price;
        $course_class->hour_start = $request->hour_start;
        $course_class->hour_end = $request->hour_end;
        $course_class->photo = $request->photo;
        $course_class->url_presentation = $request->url_presentation;
        $course_class->url_video = $request->url_video;
        $course_class->url_room = $request->url_room;
        $course_class->room_password = $request->room_password;
        $course_class->room_name = $request->room_name;
        $course_class->room_id = $roomId;
        $course_class->type_class = $request->type_class;
        $course_class->state = $request->state;
        $course_class->course_id = $request->course_id;
        $course_class->thematic_id = $request->thematic_id;
        $course_class->save();

        return response()->json($course_class,201);

    }

    public function getCourseClass(){
        $course_class = CourseClass::with('user','thematic','course_class')->get();
        if(count($course_class) == 0){
            return response()->json(["message" => "Registros no encontrados!"],404);
        }
        return response()->json($course_class,200);
    }

    public function getCourseClassById($id){
        $course_class = CourseClass::with('user','thematic','course_class')->where('id',$id)->get();
        if(count($course_class) == 0){
            return response()->json(["message" => "Registros no encontrados!"],404);
        }
        return response()->json($course_class,200);
    }

    public function getCourseClassByUser(){
        $course_class = CourseClass::with('user','thematic','course_class')->where('user_id',Auth::id())->get();
        if(count($course_class) == 0){
            return response()->json(["message" => "Registros no encontrados!"],404);
        }
        return response()->json($course_class,200);
    }

    function roomNameGenerator()
    {
        $uuid = sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );

        return $uuid;
    }
}
