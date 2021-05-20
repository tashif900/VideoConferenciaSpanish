<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\Cclass;
use App\ClassUser;
use App\Course;
use App\CourseUser;
use App\Thematic;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class WelcomeController extends Controller
{
    public function index()
    {
        $thematics = Thematic::with(['teachers' => function ($query) {
            $query->where('photo', '!=', '/img/default.jpg');
        },'teachers.people.deal', 'courses', 'courses.user.people.deal', 'cclass.instructor', 'cclass.instructor.people','cclass.instructor.people.deal', 'cclass' => function ($query) {
                                    $query->whereNull('course_id');
                                }])->where('state',1)
                                ->get();
        $data = array();
        //dd($thematics [8]);
        foreach ($thematics as $thematic) {
            $bodyData['theme']  =   $thematic->name;
            $bodyData['items']  =   array();
            $teachCont = 0;
            $classCont = 0;
            $courseCont = 0;

            for ($x = 0; $x < 15; $x++) {
                if ($thematic->courses->count() > 0) {
                    if ($courseCont < $thematic->courses->count()) {
                        if($thematic->courses[$courseCont]->state ==1){
                            array_push($bodyData['items'], $this->constructBodyCourse($thematic, $courseCont));
                        }
                        $courseCont++;
                    }
                }

                if ($thematic->teachers->count() > 0) {
                    if ($teachCont < $thematic->teachers->count()) {
                        if ($teachCont < $thematic->teachers->count()) {
                            if ($thematic->teachers[$teachCont]->isOnline() && $thematic->teachers[$teachCont]->state ==1 ) {
                                array_push($bodyData['items'], $this->constructBodyTeacher($thematic, $teachCont));
                            }
                            $teachCont++;
                        }
                    }
                }

                if ($thematic->cclass->count() > 0) {
                    if ($classCont < $thematic->cclass->count()) {
                        if ($thematic->cclass[$classCont]->state ==1){
                            array_push($bodyData['items'], $this->constructBodyClass($thematic, $classCont));
                        }
                        $classCont++;
                    }
                }
            }

            array_push($data, $bodyData);
        }

        return response()->json($data);
    }

    private function constructBodyClass($thematic, $classCont) {
        $bodyItem = array();
        $bodyItem['photo'] = $thematic->cclass[$classCont]->photo;
        $bodyItem['name'] = $thematic->cclass[$classCont]->name;
        $bodyItem['thematic'] = $thematic->name;
        $bodyItem['price'] = $thematic->cclass[$classCont]->price;
        $bodyItem['promotion'] = $thematic->cclass[$classCont]->promotion_start != null && $thematic->cclass[$classCont]->promotion_start <= date('Y-m-d') && date('Y-m-d') <= $thematic->cclass[$classCont]->promotion_end ? $thematic->cclass[$classCont]->promotional_price : null;
        $bodyItem['id'] = $thematic->cclass[$classCont]->id;
        $bodyItem['user'] = $thematic->cclass[$classCont]->instructor->people->deal_id != null ? $thematic->cclass[$classCont]->instructor->people->deal->deal . ' ' . $thematic->cclass[$classCont]->instructor->name : $thematic->cclass[$classCont]->instructor->name ;
        $bodyItem['rating'] = $thematic->cclass[$classCont]->averageRating;
        $bodyItem['type'] = 'item';
        $bodyItem['type2'] = 'class';
        return $bodyItem;
    }

    private function constructBodyTeacher($thematic, $teachCont) {
        $bodyItem = array();
        $bodyItem['photo'] = $thematic->teachers[$teachCont]->photo;
        $bodyItem['name'] =  $thematic->teachers[$teachCont]->people->deal_id != null ? $thematic->teachers[$teachCont]->people->deal->deal . ' ' . $thematic->teachers[$teachCont]->name : $thematic->teachers[$teachCont]->name;
        $bodyItem['thematic'] = $thematic->name;
        $bodyItem['price'] = null;
        $bodyItem['promotion'] = null;
        $bodyItem['id'] = $thematic->teachers[$teachCont]->id;
        $bodyItem['rating'] = $thematic->teachers[$teachCont]->averageRating;
        $bodyItem['type'] = 'teachers';
        return $bodyItem;
    }

    private function constructBodyCourse($thematic, $courseCont) {
        $bodyItem = array();
        $bodyItem['photo'] = $thematic->courses[$courseCont]->photo;
        $bodyItem['name'] = $thematic->courses[$courseCont]->name;
        $bodyItem['thematic'] = $thematic->name;
        $bodyItem['price'] = $thematic->courses[$courseCont]->price;
        $bodyItem['promotion'] = $thematic->courses[$courseCont]->promotion_start != null && $thematic->courses[$courseCont]->promotion_start <= date('Y-m-d') && date('Y-m-d') <= $thematic->courses[$courseCont]->promotion_end ? $thematic->courses[$courseCont]->promotional_price : null;
        $bodyItem['id'] = $thematic->courses[$courseCont]->id;
        $bodyItem['user'] = $thematic->courses[$courseCont]->user->people->deal_id != null ? $thematic->courses[$courseCont]->user->people->deal->deal . ' ' . $thematic->courses[$courseCont]->user->name : $thematic->courses[$courseCont]->user->name;
        $bodyItem['description'] = $thematic->courses[$courseCont]->description;
        $bodyItem['rating'] = $thematic->courses[$courseCont]->averageRating;
        $bodyItem['type'] = 'item';
        $bodyItem['type2'] = 'course';
        return $bodyItem;
    }

    private function getAnuncios(){
        $now = Carbon::now();
        $date = $now->format('Y-m-d');

        $anuncios = Advertisement::with('cclass.instructor', 'cclass.subtopic', 'course.user', 'course.subtopic', 'course.classes')
            ->where('to', '>=', $date)
            ->where (function ($query){
                $query->where('type', 2)->orwhere('type',3);
            })
            ->where ('status',1)
            ->get();
        return $anuncios;
    }

    private function constructAnuncio($anuncio, $user_id){
        if ($anuncio->type ==2){
            $item = array();
            $item['id_anuncio'] = $anuncio->id;
            $item['title'] = $anuncio->title;
            $item['description'] = $anuncio->description;
            $item['image'] = $anuncio->image;
            $item['image_movil'] = $anuncio->image_movil;
            $item['course_id'] = $anuncio->course_id;
            $item['type'] = "course";
            $item  ['course']['id'] = $anuncio['course']['id'];
            $item  ['course']['name'] = $anuncio['course']['name'];
            $item  ['course']['description'] = $anuncio['course']['description'];
            $item ['course']['photo'] = $anuncio['course']['photo'];
            $item ['course']['instructor_id'] = $anuncio['course']['user_id'];
            $item ['course']['instructor'] = $anuncio['course']['user']['name'];
            $item ['course']['price'] = $anuncio['course']['price'];
            $item ['course']['promotional_price'] = $anuncio['course']['promotional_price'];
            $item ['course']['promotion_start'] = $anuncio['course']['promotion_start'];
            $item ['course']['promotion_end'] = $anuncio['course']['promotion_end'];
            $item ['course']['averageRating'] = $anuncio['course']['averageRating'];
            $item ['course']['slug'] = $anuncio['course']['slug'];
            $item ['course']['preview_type'] = $anuncio['course'] ['preview_type'];
            $item ['course']['preview_file'] = $anuncio['course'] ['preview_file'];
            $item ['course']['owner'] = false;
            if ($anuncio['course'] ['user_id'] == $user_id){
                $item ['course']['owner'] ="instructor";
            }else {
                $student = CourseUser::where("course_id",$anuncio['course']['id'])
                    ->where("user_id", $user_id)->get()->count();
                if ($student>0){
                    $item ['course']['owner'] ="student";
                }
            }
            $item['course'] ['class'] = $anuncio['course']['classes'];

        }else{
            $item = array();
            $item['id_anuncio'] = $anuncio->id;
            $item['title'] = $anuncio->title;
            $item['description'] = $anuncio->description;
            $item['image'] = $anuncio->image;
            $item['image_movil'] = $anuncio->image_movil;
            $item['class_id'] = $anuncio->class_id;
            $item['type'] = "class";
            $item  ['class']['id'] = $anuncio['cclass']['id'];
            $item  ['class']['name'] = $anuncio['cclass']['name'];
            $item  ['class']['description'] = $anuncio['cclass']['description'];
            $item ['class']['photo'] = $anuncio['cclass']['photo'];
            $item ['class']['instructor_id'] = $anuncio['cclass']['user_id'];
            $item ['class']['instructor'] = $anuncio['cclass']['instructor']['name'];
            $item ['class']['price'] = $anuncio['cclass']['price'];
            $item ['class']['promotional_price'] = $anuncio['cclass']['promotional_price'];
            $item ['class']['promotion_start'] = $anuncio['cclass']['promotion_start'];
            $item ['class']['promotion_end'] = $anuncio['cclass']['promotion_end'];
            $item ['class']['averageRating'] = $anuncio['cclass']['averageRating'];
            $item['class'] ['type_class'] = $anuncio['cclass']['type_class'];
            $item['class'] ['url_video'] = $anuncio['cclass']['url_video'];
            $item ['class']['slug'] = $anuncio['cclass']['slug'];
            $item ['class']['preview_type'] = $anuncio['cclass'] ['preview_type'];
            $item ['class']['preview_file'] = $anuncio['cclass'] ['preview_file'];
            $item ['class']['owner'] = false;
            if ($anuncio['cclass']['user_id'] == $user_id){
                $item ['class']['owner'] ="instructor";
            }else {
                $student = ClassUser::where("class_id",$anuncio['cclass']['id'])
                    ->where("user_id", $user_id)->get()->count();
                if ($student>0){
                    $item ['class']['owner'] ="student";
                }
            }
        }
        return $item;
    }

    public function getClassCourseFeaturedAll(){

        $anuncios = $this->getAnuncios();
        $items = array();
        $cont =0;
        $user_id = auth()->id();
        foreach ($anuncios as $anuncio){
            $item = $this->constructAnuncio($anuncio, $user_id);
            $items[$cont] = $item;
            $cont++;
        }
        return response()->json($items);
    }

    public function getClassCourseFeaturedCategory(Request $request){
        $anuncios = $this->getAnuncios();
        $items = array();
        $cont =0;
        foreach ($anuncios as $anuncio){
            $validate = false;
            $user_id = auth()->id();
            //Es un curso y pertenece a la categoría?
            if ($anuncio->type ==2){
                if ($anuncio['course']['subtopic']['thematic_id'] ==$request->thematic_id){
                    $validate =true;
                }
            }

            //Es una clase y pertenece a la categoria?
            if ($anuncio->type ==3){
                if ($anuncio['cclass']['subtopic']['thematic_id'] ==$request->thematic_id){
                    $validate =true;
                }
            }
            if ($validate){
                $item = $this->constructAnuncio($anuncio, $user_id);
                $items[$cont] = $item;
                $cont++;
            }

        }
        return response()->json($items);
    }

    public function getClassCourseFeaturedSubCategory(Request $request){
        $anuncios = $this->getAnuncios();
        $items = array();
        $cont =0;
        foreach ($anuncios as $anuncio){
            $validate = false;
            $user_id = auth()->id();
            //Es un curso y pertenece a la subcategoría?
            if ($anuncio->type ==2){
                if ($anuncio['course']['subtopic']['id'] ==$request->subtopic_id){
                    $validate =true;
                }
            }

            //Es una clase y pertenece a la subcategoria?
            if ($anuncio->type ==3){
                if ($anuncio['cclass']['subtopic']['id'] ==$request->subtopic_id){
                    $validate =true;
                }
            }
            if ($validate){
                $item = $this->constructAnuncio($anuncio, $user_id);
                $items[$cont] = $item;
                $cont++;
            }

        }
        return response()->json($items);
    }

//

    public function getClassCourseAll(){
        $classes = Cclass::with('instructor')->where('state', 1)->where('course_id', null)
            ->get();

        $courses = Course::with('user','classes')->where('state', 1)->get();

        $items = $this->constructCourseClase($classes, $courses);

        return response()->json($items);
    }

    public function getClassCourseCategory(Request $request){
        $classes = Cclass::with('instructor', 'subtopic')
            ->whereHas('subtopic', function ($query) use($request) {
                return $query->where('thematic_id', $request->thematic_id);
            })
            ->where('state', 1)->where('course_id', null)
            ->get();


        $courses = Course::with('user', 'subtopic', 'classes')
            ->whereHas('subtopic', function ($query) use($request) {
                return $query->where('thematic_id', $request->thematic_id);
            })
            ->where('state', 1)->get();

        $items = $this->constructCourseClase($classes, $courses);
        return response()->json($items);

    }

    public function getClassCourseSubCategory (Request $request){
        $classes = Cclass::with('instructor', 'subtopic')
            ->whereHas('subtopic', function ($query) use($request) {
                return $query->where('id', $request->subtopic_id);
            })
            ->where('state', 1)->where('course_id', null)
            ->get();


        $courses = Course::with('user', 'subtopic', 'classes')
            ->whereHas('subtopic', function ($query) use($request) {
                return $query->where('id', $request->subtopic_id);
            })
            ->where('state', 1)->get();

        $items = $this->constructCourseClase($classes, $courses);
        return response()->json($items);
    }

    private function constructCourseClase($classes, $courses){
        $items = array();
        $cont =0;
        foreach ($classes as $class){
            $item = array();
            $item ['id'] = $class->id;
            $item ['name'] = $class->name;
            $item ['description'] = $class->description;
            $item['photo'] = $class->photo;
            $item['instructor_id'] = $class->user_id;
            $item['instructor'] = $class->instructor['name'];
            $item['price'] = $class->price;
            $item['promotional_price'] = $class->promotional_price;
            $item['promotion_start'] = $class->promotion_start;
            $item['promotion_end'] = $class->promotion_end;
            $item['averageRating'] = $class->averageRating;
            $item['type_class'] = $class->type_class;
            $item['url_video'] = $class->url_video;
            $item ['slug'] = $class->slug;
            $item ['preview_type'] = $class->preview_type;
            $item ['preview_file'] = $class->preview_file;
            $item ['owner'] = false;
            if ($class->user_id== auth()->id()){
                $item ['owner'] ="instructor";
            }else {
                $student = ClassUser::where("class_id",$class->id)
                    ->where("user_id", auth()->id())->get()->count();
                if ($student>0){
                    $item ['owner'] ="student";
                }
            }
            $item['type'] = "class";
            $items[$cont] = $item;
            $cont++;
        }
        foreach ($courses as $course){
            $item = array();
            $item ['id'] = $course->id;
            $item ['name'] = $course->name;
            $item ['description'] = $course->description;
            $item['photo'] = $course->photo;
            $item['instructor_id'] = $course->user_id;
            $item['instructor'] = $course->user['name'];
            $item['price'] = $course->price;
            $item['promotional_price'] = $course->promotional_price;
            $item['promotion_start'] =$course->promotion_start;
            $item['promotion_end'] = $course->promotion_end;
            $item['averageRating'] = $course->averageRating;
            $item['type_course'] = $course->type_course;
            $item ['slug'] = $course->slug;
            $item ['preview_type'] = $course->preview_type;
            $item ['preview_file'] = $course->preview_file;
            $item ['owner'] = false;
            //$item ['class'] =
            if ($course->user_id== auth()->id()){
                $item ['owner'] ="instructor";
            }else {
                $student = CourseUser::where("course_id",$course->id)
                    ->where("user_id", auth()->id())->get()->count();
                if ($student>0){
                    $item ['owner'] ="student";
                }
            }
            $item['type'] = "course";
            $items[$cont] = $item;
            $cont++;
        }

        return $items;
    }

    public function getInstructorsFeatured (){

        $now = Carbon::now();
        $date = $now->format('Y-m-d');

        $anuncios = Advertisement::with('user.people')
            ->where('to', '>=', $date)
            ->where ('type',1)
            ->where ('status',1)
            ->get();

        $user_online = array();
        $user_offline = array();
        $cont =0;
        foreach ($anuncios as $anuncio){
            $user = $anuncio['user'];
            if ($user->isOnline()){
                $user->online = true;
                array_push($user_online, $user);
                $cont++;
            }else{
                $user->online = false;
                array_push($user_offline, $user);
                $cont++;
            }
        }
        $items = array_merge($user_online, $user_offline);
        return response()->json($items);
    }

    public function getInstructorsFeaturedCategory (Request $request){

        $now = Carbon::now();
        $date = $now->format('Y-m-d');

        $anuncios = Advertisement::with('user.people')
            ->where('to', '>=', $date)
            ->where ('type',1)
            ->where ('status',1)
            ->get();

        $user_online = array();
        $user_offline = array();
        $cont =0;
        foreach ($anuncios as $anuncio){
            if ($anuncio['user']['thematic_id'] == $request->thematic_id){
                $user = $anuncio['user'];
                if ($user->isOnline()){
                    $user->online = true;
                    array_push($user_online, $user);
                    $cont++;
                }else{
                    $user->online = false;
                    array_push($user_offline, $user);
                    $cont++;
                }
            }
        }
        $items = array_merge($user_online, $user_offline);
        return response()->json($items);
    }


    public function getInstructorsAll(){
        $users = User::with( 'people')->role(['Profesor'])->get();
        $items = $this->constructInstructors($users, $users->count());
        return response()->json($items);
    }

    private function constructInstructors($users, $limit){
        $user_online = array();
        $user_offline = array();
        $cont =0;
        foreach ($users as $user){
            if ($cont<$limit){
                if ($user->isOnline()){
                    $user->online = true;
                    array_push($user_online, $user);
                    $cont++;
                }else{
                    $user->online = false;
                    array_push($user_offline, $user);
                    $cont++;
                }
            }else{
                break;
            }
        }

        $items = array_merge($user_online, $user_offline);

        return $items;
    }


}
