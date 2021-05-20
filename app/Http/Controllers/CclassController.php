<?php

namespace App\Http\Controllers;

use App\Cclass;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\NotificationsController;
use BoldBrush\Cloudflare\API;

class CclassController extends Controller
{
    public $_file;

    public function __construct()
    {
        $this->_file = new FileController;
    }

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

        //dd($request->class_id );

        if ($request->class_id == null || $request->class_id == 'null'){
            $course_class = new Cclass();
        } else{
            $course_class = Cclass::find($request->class_id);
        }

        $photo=null;

        $request->file != 'null' && $request->file != null ? $photo = $this->_file->storeFile($request->file) : "";

        $photo != null ? $course_class->photo = $photo : "";

        //dd($course_class->photo);

        $slug = Str::slug($request->name, '-') . '-' . time();


        //dd($request->hour_start);

        $course_class->name = $request->name;
        $course_class->description = $request->description;
        $course_class->slug = $slug;
        $course_class->price = $request->price;
        //$course_class->hour_start = $request->hour_start;
        $request->hour_start != 'null' && $request->hour_start  != 'Invalid date' ? $course_class->hour_start = $request->hour_start : "";


        //$course_class->hour_end = $request->hour_end;
        $request->hour_end != 'null' && $request->hour_end != 'Invalid date' ? $course_class->hour_end : "";

        if ($request->url_presentation != 'null' && $request->url_presentation != null)
            $course_class->url_presentation = $request->url_presentation;

        $course_class->url_video = $request->url_video;
        if ($request->url_room != 'null' && $request->url_room != null)
            $course_class->url_room = $request->url_room;

        $course_class->room_password = $request->room_password;
        $course_class->room_name = $request->room_name;

        if ($request->type_class == 2){
            $course_class->room_id = $this->roomNameGenerator();
        }

        $course_class->type_class = $request->type_class;
        $course_class->state = $request->state;
        $course_class->course_id = $request->course_id;
        $course_class->user_id = $request->user;
        $course_class->subtopic_id = $request->subTopic;
        $course_class->save();

        return response()->json($course_class,201);
    }

    public function updateCourseClass(Request $request){
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

        if ($request->file != 'null') {
            $photo = $this->_file->storeFile($request->file);
        }
        //
        if ($request->claseid == 'null' || $request->claseid == null) {
            $slug = Str::slug($request->name, '-') . '-' . time();
            $course_class = new Cclass;
            $course_class->course_id = $request->course_id;
            $course_class->user_id = auth()->user()->id;
            $course_class->slug = $slug;
            //dd($course_class, 'Estoy dentro');
        } else {
            $course_class = Cclass::find($request->claseid);
        }
        //dd($request->claseid, 'Clase ID');

        $course_class->name = $request->name;
        $course_class->description = $request->description;
        $course_class->price = $request->price;
        $course_class->hour_start = $request->hour_start;
        $course_class->hour_end = $request->hour_end;
        if ($request->file != 'null') {
            $course_class->photo = $photo;
        }
        if ($request->url_presentation != 'null' && $request->url_presentation != null)
            $course_class->url_presentation = $request->url_presentation;

        if($request->url_video !== null && $request->url_video !== 'null') {
            if($request->url_video !== $course_class->url_video) {
                $api = API\Factory::make(
                    env('CLOUDFLARE_ACCOUNT'),
                    env('CLOUDFLARE_KEY'),
                    env('CLOUDFLARE_EMAIL')
                );
                $api->delete($course_class->url_video);
                $course_class->url_video = $request->url_video;
            }
        }

        $course_class->url_room = $request->url_room;
        $course_class->room_password = $request->room_password;
        $course_class->room_name = $request->room_name;
        $course_class->room_id = $request->room_id;
        $course_class->type_class = $request->type_class;
        $course_class->state = $request->state;
        $course_class->subtopic_id = $request->subTopic;
        $course_class->save();

        return response()->json($course_class,201);

    }

    public function saveClass(Request $request)
    {
        $rules = [
            'name' => 'required|min:3|unique:classes',
            'description' => 'required|min:3',
            'hour_start' => 'required',
            'hour_end' => 'required',
            'type_class' => 'required',
            'state' => 'required',
        ];

        $customMessages = [
            'unique' => 'El nombre de la clase no esta disponible.'
        ];
    
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $photo = $this->_file->storeFile($request->file);
        if ($request->previewType == 2){
            $preview = $this->_file->storeFile($request->filePreview);
        }else{
            $preview = $request->filePreview;
        }

        $slug = Str::slug($request->name, '-') . '-' . time();

        $roomId = null;
        if ($request->type_class == 2) {
            $roomId = $this->roomNameGenerator();
        }

        $class = new Cclass;
        $class->name = $request->name;
        $class->description = $request->description;
        $class->slug = $slug;
        $class->price = $request->price;
        $class->discount = $request->discount;
        $request->hour_start != 'null' ?  $class->hour_start = $request->hour_start : "";
        $request->hour_end != 'null' ? $class->hour_end = $request->hour_end : "";
        $class->photo = $photo;
        $class->preview_type = $request->previewType;
        $class->preview_file = $preview;
        $class->url_presentation = $request->url_presentation;
        $class->url_video = $request->url_video;
        if ($request->type_class == 2) {
            $class->room_id = $this->roomNameGenerator();
        }
        $class->url_room = $request->url_room;
        $class->room_password = $request->room_password;
        $class->room_name = $request->room_name;

        $class->type_class = $request->type_class;
        $class->state = $request->state;
        $class->user_id = $request->user;
        $class->subtopic_id = $request->thematic;
        $class->promotional_price = $request->promotional_price;
        $class->promotion_start = $request->start_promotion == null ? null : date('Y-m-d', strtotime($request->start_promotion));
        $class->promotion_end = $request->end_promotion == null ? null :  date('Y-m-d', strtotime($request->end_promotion));
        $class->difficulty= $request->difficulty;
        $class->save();

        NotificationsController::sendNotificationToPusher(3);

        return response()->json($class,201);
    }

    public function UpdateClass(Request $request)
    {
        $rules = [
            'name' => 'required|min:3|unique:classes,id,' . $request->classId,
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

        //dd();

        if ($request->file != 'null') {
            $photo = $this->_file->storeFile($request->file);
        }
        // $slug = Str::slug($request->name, '-') . '-' . time();

        $roomId = null;
        if ($request->type_class == 2) {
            $roomId = $this->roomNameGenerator();
        }

        $class = Cclass::find($request->classId);
        $class->name = $request->name;
        $class->description = $request->description;
        $class->price = $request->price;
        $class->discount = $request->discount;
        $class->hour_start = $request->hour_start;
        $class->hour_end = $request->hour_end;
        if ($request->file != 'null') {
            $class->photo = $photo;
        }
        if ($request->url_presentation != 'null' && $request->url_presentation != null)
            $class->url_presentation = $request->url_presentation;

        if ($request->url_video != null) {
            $class->url_video = $request->url_video;
        }
        if ($request->url_room != 'null' && $request->url_room != null)
            $class->url_room = $request->url_room;

        $class->room_password = $request->room_password;
        $class->room_name = $request->room_name;
        $class->room_id = $roomId;
        $class->type_class = $request->type_class;
        $class->state = $request->state;
        $class->user_id = $request->user;
        $class->subtopic_id = $request->thematic;
        $class->promotional_price = $request->promotional_price;
        $class->promotion_start = date('Y-m-d', strtotime($request->start_promotion));
        $class->promotion_end = date('Y-m-d', strtotime($request->end_promotion));
        $class->save();

        return response()->json($class,201);
    }

    public function getInformation(Request $request)
    {
        $class = Cclass::with('instructor')->whereNull('course_id')->find($request->id);

        if (auth()->check()) {
            $hasClass = auth()->user()->clases->contains($request->id);

            return response()->json(['clase' => $class, 'has' => $hasClass]);
        } else {
            return response()->json(['clase' => $class, 'has' => false]);
        }

    }

    public function getMyClasses()
    {
        $classes_students = auth()->user()->clases;
        $classes_instructor=[];
        if (auth()->user()->hasRole('Profesor')) {
            $classes_instructor = Cclass::with(['instructor' => function($query){
                $query->select('id', 'name', 'photo');
            }, 'instructor.people' => function($query){
                $query->select('id', 'user_id', 'profession');
            }])
                ->whereNull('course_id')
                ->where('user_id', auth()->user()->id)
                ->get();
        }

        $classes = $classes_students->merge($classes_instructor);

        return response()->json($classes);
    }

    public function single(Request $request)
    {
        $class = Cclass::where('slug', $request->slug)->with('instructor:id,name','participantes')->first();
        $server_jisti = env('JITSI_DOMAIN', 'https://meet.jit.si');
        if(auth()->user()->hasRole('Profesor')) {
            if ($class->user_id == auth()->user()->id) {
                return response()->json(array('status' => 0, 'item' => $class, 'server_jitsi' => $server_jisti));
            }
            return response()->json(array('status' => 1 , 'item' => $class, 'server_jitsi' => $server_jisti));
        } else {
            $hasClass = auth()->user()->clases->contains($class->id);
            if ($hasClass) {
                return response()->json(array('status' => 1, 'item' => $class, 'server_jitsi' => $server_jisti));
            } else {
                return response()->json(array('status' => -9, 'item' => $class->id, 'server_jitsi' => $server_jisti));
            }
        }
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

        $existUuid = Cclass::where('room_id', $uuid)->first();

        if ($existUuid != null) {
            $uuid = sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
                mt_rand( 0, 0xffff ),
                mt_rand( 0, 0x0fff ) | 0x4000,
                mt_rand( 0, 0x3fff ) | 0x8000,
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
            );
        }

        return $uuid;

        return $uuid;
    }

    public function prepare(Request $request)
    {
        $class = Cclass::with('subtopic', 'subtopic.thematic')->whereNull('course_id')->find($request->id);

        return response()->json($class);
    }
}
