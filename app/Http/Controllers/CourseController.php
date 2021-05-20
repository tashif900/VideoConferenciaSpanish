<?php

namespace App\Http\Controllers;

use Validator;
use App\Cclass;
use App\Course;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FileController;
use App\Http\Resources\CourseCollection;
use App\Http\Controllers\NotificationsController;

class CourseController extends Controller
{
    public $_file;

    public function __construct()
    {
        $this->_file = new FileController;
    }
    
    public function saveCourse(Request $request){
        $rules = [
            'name' => 'required|min:3|unique:courses',
            'description' => 'required|min:3',
            'type_course' => 'required',
            'thematic' => 'required',
            'number_class' => 'required',
            'price' => 'required',
            'date_start' => 'required',
            // 'photo' => 'required',
        ];

        $customMessages = [
            'unique' => 'El nombre del curso no esta disponible.'
        ];
    
        $validator = Validator::make($request->all(), $rules, $customMessages);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $user = 1;

        if (auth()->check()) {
            $user = auth()->id;
        }

        if ($request->has('user')) {
            $user = $request->user;
        }

        $photo = $this->_file->storeFile($request->file);

        if ($request->previewType == '2'){
            $preview = $this->_file->storeFile($request->filePreview);
        }else{
            $preview = $request->filePreview;
        }

        $slug = Str::slug($request->name, '-') . '-' . time();

        $course = new Course();
        $course->name = $request->name;
        $course->description = $request->description;
        $course->slug = $slug;
        $course->type_course = $request->type_course;
        $course->subtopic_id = $request->thematic;
        $course->number_class = $request->number_class;
        $course->price = $request->price;
        $course->discount = $request->discount;
        $course->date_start = $request->date_start;

        if ($request->url_presentation != 'null' && $request->url_presentation != null)
            $course->url_presentation = $request->url_presentation;
        // $course->photo = $request->photo;
        $course->photo = $photo;
        $course->preview_type = $request->previewType;
        $course->preview_file = $preview;
        $course->user_id = $user;
        $course->state = 1;
        $course->promotional_price = $request->promotional_price;
        $course->promotion_start = date('Y-m-d', strtotime($request->start_promotion));
        $course->promotion_end = date('Y-m-d', strtotime($request->end_promotion));
        $course->save();

        NotificationsController::sendNotificationToPusher(2);

        return response()->json($course,201);

    }

    public function updateCourse(Request $request){
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|min:3',
            'type_course' => 'required',
            'thematic' => 'required',
            'number_class' => 'required',
            'price' => 'required',
            'date_start' => 'required',
            // 'photo' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        // $slug = Str::slug($request->name, '-') . '-' . time();
        if ($request->file != 'null') {
            $photo = $this->_file->storeFile($request->file);
        }

        $course = Course::where('id',$request->courseId)->first();
        $course->name = $request->name;
        $course->description = $request->description;
        // $course->slug = $slug;
        $course->type_course = $request->type_course;
        $course->subtopic_id = $request->thematic;
        $course->number_class = $request->number_class;
        $course->price = $request->price;
        $course->discount = 00;
        $course->date_start = $request->date_start;
        if ($request->url_presentation != 'null' && $request->url_presentation != null)
            $course->url_presentation = $request->url_presentation;

        if ($request->file != 'null') {
            $course->photo = $photo;
        }

        $course->preview_type = $request->previewType;

        if ($request->filePreview != null && $request->filePreview != ""){
            if ($request->previewType == '2'){
                $preview = $this->_file->storeFile($request->filePreview);
            }else{
                $preview = $request->filePreview;
            }

            $course->preview_file = $preview;
        }


        $course->promotional_price = $request->promotionalPrice == null ? 0.00 : $request->promotionalPrice;
        $course->promotion_start = date('Y-m-d', strtotime($request->start_promotion));
        $course->promotion_end = date('Y-m-d', strtotime($request->end_promotion));
        $course->save();

        return response()->json($course,201);

    }

    public function getCourse(){
        $course = Course::with('user','thematic')->get();
        if(count($course) == 0){
            return response()->json(["message" => "Registros no encontrados!"],404);
        }
        return response()->json($course,200);
    }

    public function getCourseById($id){
        $course = Course::with('user','thematic')->where('id',$id)->get();
        if(count($course) == 0){
            return response()->json(["message" => "Registros no encontrados!"],404);
        }
        return response()->json($course,200);
    }

    public function getCourseByUser(){
        $course = Course::with('user','thematic')->where('user_id',Auth::id())->get();
        if(count($course) == 0){
            return response()->json(["message" => "Registros no encontrados!"],404);
        }
        return response()->json($course,200);
    }

    //

    public function getCourseUser($user)
    {
        $courses = Course::with('user','thematic','participantes')->where('user_id', $user)->get();

        return response()->json(new CourseCollection($courses));
    }

    public function getInformation(Request $request)
    {
        $course = Course::with('classes','user')->find($request->id);

        if (auth()->check()) {
            $hasCourse = auth()->user()->cursos->contains($request->id);

            return response()->json(['course' => $course, 'has' => $hasCourse]);
        } else {
            return response()->json(['course' => $course, 'has' => false]);
        }
    }

    public function myCourses(Request $request)
    {
        $course_students = $courses = auth()->user()->cursos;
        $course_teachers =[];
        if (auth()->user()->hasRole('Profesor')) {
            $course_teachers = Course::with(['user' => function($query){
                $query->select('id', 'name', 'photo');
            }, 'user.people' => function($query){
                $query->select('id', 'user_id', 'profession');
            }])->where('user_id', auth()->user()->id)
                ->get();
        }

        $courses = $course_students->merge($course_teachers);

        //return response()->json($courses);

        return response()->json(new CourseCollection($courses));
    }

    public function single(Request $request)
    {
        $course = Course::where('id', $request->course)->with('user:id,name','participantes','classes')->first();
        $classe = Cclass::where('course_id', $request->course)->find($request->clase);
        $server_jisti = env('JITSI_DOMAIN', 'https://meet.jit.si');

        if(auth()->user()->hasRole('Profesor')) {
            if ($course->user_id == auth()->user()->id) {
                return response()->json(array('status' => 0, 'item' => $classe, 'item2' => $course, 'server_jitsi' => $server_jisti ));
            }
            return response()->json(array('status' => 1 , 'item' => $classe, 'item2' => $course, 'server_jitsi' => $server_jisti));
        } else {
            $hasClass = auth()->user()->cursos->contains($course->id);
            if ($hasClass) {
                $curso = Course::with('classes','user:id,name')->find($request->course);
                $classe = Cclass::where('course_id', $request->course)->find($request->clase);

                return response()->json(array('status' => 1, 'item' => $classe, 'item2' => $curso, 'server_jitsi' => $server_jisti));
            } else {
                return response()->json(array('status' => -9, 'item' => $course->id, 'server_jitsi' => $server_jisti));
            }
        }
    }

    public function prepare(Request $request)
    {
        $course = Course::with('classes', 'classes.subtopic.thematic','user', 'subtopic', 'subtopic.thematic')->find($request->id);

        return response()->json($course);
    }
}
