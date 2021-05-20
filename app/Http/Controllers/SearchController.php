<?php

namespace App\Http\Controllers;

use App\SubTopic;
use App\Thematic;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $data = array();
        $cont = 0;
        $teachCont = 0;
        $classCont = 0;
        $courseCont = 0;
        $cont2 = 0;

        if ($request->has('promotion')) {
            $thematics = Thematic::with(['teachers' => function ($query) use ($request) {
                                        if ($request->input('query') != null) {
                                            $query
                                                ->where('users.state', "=", 1)
                                                ->where('users.name', 'like', '%' . $request->input('query') . '%')
                                                ->where('users.photo'. '!=', '/img/default.jpg');
                                        }
                                    }, 'courses' => function($query) use ($request) {
                                        if ($request->input('query') != null) {
                                            $query
                                                ->where('courses.state', "=", 1)
                                                ->where('courses.name', 'like', '%' . $request->input('query') . '%')
                                                ->whereNotNull('courses.promotional_price')
                                                ->whereNotNull('courses.promotion_start');
                                        }
                                    },'cclass' => function ($query) use ($request) {
                                        if ($request->input('query') != null) {
                                            $query  ->where('classes.state', "=",1)
                                                    ->where('classes.name', 'like', '%' . $request->input('query') . '%')
                                                    ->where('classes.course_id', "=", null)
                                                    ->whereNotNull('classes.promotional_price')
                                                    ->whereNotNull('classes.promotion_start');
                                        }
                                    }])
                                    ->get();



            foreach ($thematics as $thematic) {
                $courseCont=0;
                $classCont=0;
                if ($thematic->courses->count() > $courseCont) {
                        if ($thematic->courses[$courseCont]->state ==1){
                            $data['items'][$cont2]['photo'] = $thematic->courses[$courseCont]->photo;
                            $data['items'][$cont2]['name'] = $thematic->courses[$courseCont]->name;
                            $data['items'][$cont2]['thematic'] = $thematic->name;
                            $data['items'][$cont2]['price'] = $thematic->courses[$courseCont]->price;
                            $data['items'][$cont2]['promotion'] = $thematic->courses[$courseCont]->promotion_start != null && $thematic->courses[$courseCont]->promotion_start <= date('Y-m-d') && date('Y-m-d') <= $thematic->courses[$courseCont]->promotion_end ? $thematic->courses[$courseCont]->promotional_price : null;
                            $data['items'][$cont2]['id'] = $thematic->courses[$courseCont]->id;
                            $data['items'][$cont2]['user'] = $thematic->courses[$courseCont]->user->name;
                            $data['items'][$cont2]['description'] = $thematic->courses[$courseCont]->description;
                            $data['items'][$cont2]['type'] = 'item';
                            $data['items'][$cont2]['type2'] = 'course';
                            $data['items'][$cont2]['promotion'] = $thematic->courses[$courseCont]->discount;


                            $cont2++;
                        }
                        $courseCont++;

                }
        
                if ($thematic->cclass->count() > $classCont) {
                    if($thematic->cclass[$classCont]->state ==1 && $thematics->cclass[$classCont]->course_id == null){
                        $data['items'][$cont2]['photo'] = $thematic->cclass[$classCont]->photo;
                        $data['items'][$cont2]['name'] = $thematic->cclass[$classCont]->name;
                        $data['items'][$cont2]['thematic'] = $thematic->name;
                        $data['items'][$cont2]['price'] = $thematic->cclass[$classCont]->price;
                        $data['items'][$cont2]['promotion'] = $thematic->cclass[$classCont]->promotion_start != null && $thematic->cclass[$classCont]->promotion_start <= date('Y-m-d') && date('Y-m-d') <= $thematic->cclass[$classCont]->promotion_end ? $thematic->cclass[$classCont]->promotional_price : null;
                        $data['items'][$cont2]['id'] = $thematic->cclass[$classCont]->id;
                        $data['items'][$cont2]['user'] = $thematic->cclass[$classCont]->instructor->name;
                        $data['items'][$cont2]['type'] = 'item';
                        $data['items'][$cont2]['type2'] = 'class';
                        $data['items'][$cont2]['promotion'] = $thematic->cclass[$classCont]->discount;


                        $cont2++;
                    }
                    $classCont++;
                }
        
                if ($thematic->courses->count() > $courseCont) {
                    if($thematic->courses[$courseCont]->state ==1){
                        $data['items'][$cont2]['photo'] = $thematic->courses[$courseCont]->photo;
                        $data['items'][$cont2]['name'] = $thematic->courses[$courseCont]->name;
                        $data['items'][$cont2]['thematic'] = $thematic->name;
                        $data['items'][$cont2]['price'] = $thematic->courses[$courseCont]->price;
                        $data['items'][$cont2]['promotion'] = $thematic->courses[$courseCont]->promotion_start != null && $thematic->courses[$courseCont]->promotion_start <= date('Y-m-d') && date('Y-m-d') <= $thematic->courses[$courseCont]->promotion_end ? $thematic->courses[$courseCont]->promotional_price : null;
                        $data['items'][$cont2]['id'] = $thematic->courses[$courseCont]->id;
                        $data['items'][$cont2]['user'] = $thematic->courses[$courseCont]->user->name;
                        $data['items'][$cont2]['description'] = $thematic->courses[$courseCont]->description;
                        $data['items'][$cont2]['type'] = 'item';
                        $data['items'][$cont2]['type2'] = 'course';
                        $data['items'][$cont2]['promotion'] = $thematic->courses[$courseCont]->discount;

                        $courseCont++;
                        $cont2++;
                    }

                }   
            }
        }

        $thematics = Thematic::with(['teachers' => function ($query) use ($request) {
                                                if ($request->input('query') != null) {
                                                    $query
                                                        ->where('users.state', "=", 1)
                                                        ->where('users.name', 'like', '%' . $request->input('query') . '%');
                                                }
                                            }, 'courses' => function($query) use ($request) {
                                                if ($request->input('query') != null) {
                                                    $query
                                                        ->where('courses.state' , "=", 1)
                                                        ->where('courses.name', 'like', '%' . $request->input('query') . '%');
                                                }
                                            },'cclass' => function ($query) use ($request) {
                                                if ($request->input('query') != null) {
                                                    $query  ->where ('classes.state', "=",1)
                                                            ->where('classes.name', 'like', '%' . $request->input('query') . '%')
                                                            ->where('classes.course_id', "=",null);
                                                }
                                            }])
                            ->find($request->input('thematic'));


        if ($request->has('subtopic')) {
            $thematics = SubTopic::with('courses','cclass')->find($request->input('subtopic'));
        }

        if ($request->has('subtopic')) {
            $data['theme'] = $thematics->name;
            if ($thematics->courses->count() > $courseCont) {
                foreach ($thematics->courses as $thematic) {
                    if($thematics->courses[$courseCont]->state ==1){
                        $data['items'][$cont2]['photo'] = $thematics->courses[$courseCont]->photo;
                        $data['items'][$cont2]['name'] = $thematics->courses[$courseCont]->name;
                        $data['items'][$cont2]['thematic'] = $thematics->name;
                        $data['items'][$cont2]['price'] = $thematics->courses[$courseCont]->price;
                        $data['items'][$cont2]['promotion'] = $thematics->courses[$courseCont]->promotion_start != null && $thematics->courses[$courseCont]->promotion_start <= date('Y-m-d') && date('Y-m-d') <= $thematics->courses[$courseCont]->promotion_end ? $thematics->courses[$courseCont]->promotional_price : null;
                        $data['items'][$cont2]['id'] = $thematics->courses[$courseCont]->id;
                        $data['items'][$cont2]['user'] = $thematics->courses[$courseCont]->user->name;
                        $data['items'][$cont2]['description'] = $thematics->courses[$courseCont]->description;
                        $data['items'][$cont2]['type'] = 'item';
                        $data['items'][$cont2]['type2'] = 'course';
                        $data['items'][$cont2]['promotion'] = null;
                        $cont2++;
                    }
                    $courseCont++;
                }
            }
    
            if ($thematics->cclass->count() > $classCont) {
                foreach ($thematics->cclass as $thematic) {
                    if ($thematics->cclass[$classCont]->state ==1 && $thematics->cclass[$classCont]->course_id == null){
                        $data['items'][$cont2]['photo'] = $thematics->cclass[$classCont]->photo;
                        $data['items'][$cont2]['name'] = $thematics->cclass[$classCont]->name;
                        $data['items'][$cont2]['thematic'] = $thematics->name;
                        $data['items'][$cont2]['price'] = $thematics->cclass[$classCont]->price;
                        $data['items'][$cont2]['promotion'] = $thematics->cclass[$classCont]->promotion_start != null && $thematics->cclass[$classCont]->promotion_start <= date('Y-m-d') && date('Y-m-d') <= $thematics->cclass[$classCont]->promotion_end ? $thematics->cclass[$classCont]->promotional_price : null;
                        $data['items'][$cont2]['id'] = $thematics->cclass[$classCont]->id;
                        $data['items'][$cont2]['user'] = $thematics->cclass[$classCont]->instructor->name;
                        // $data['items'][$classCont]['description'] = $thematics->cclass[$classCont]->description;
                        $data['items'][$cont2]['type'] = 'item';
                        $data['items'][$cont2]['type2'] = 'class';
                        $data['items'][$cont2]['promotion'] = null;


                        $cont2++;
                    }
                    $classCont++;
                }
            }
    
            if ($thematics->courses->count() > $courseCont) {
                foreach ($thematics->courses as $thematics) {
                    if ($thematics->courses[$courseCont]->state ==1){
                        $data['items'][$cont2]['photo'] = $thematics->courses[$courseCont]->photo;
                        $data['items'][$cont2]['name'] = $thematics->courses[$courseCont]->name;
                        $data['items'][$cont2]['thematic'] = $thematics->name;
                        $data['items'][$cont2]['price'] = $thematics->courses[$courseCont]->price;
                        $data['items'][$cont2]['promotion'] = $thematics->courses[$courseCont]->promotion_start != null && $thematics->courses[$courseCont]->promotion_start <= date('Y-m-d') && date('Y-m-d') <= $thematics->courses[$courseCont]->promotion_end ? $thematics->courses[$courseCont]->promotional_price : null;
                        $data['items'][$cont2]['id'] = $thematics->courses[$courseCont]->id;
                        $data['items'][$cont2]['user'] = $thematics->courses[$courseCont]->user->name;
                        $data['items'][$cont2]['description'] = $thematics->courses[$courseCont]->description;
                        $data['items'][$cont2]['type'] = 'item';
                        $data['items'][$cont2]['type2'] = 'course';
                        $data['items'][$cont2]['promotion'] = null;

                        $cont2++;
                    }
                    $courseCont++;
                }
            }
        } else if ($request->has('thematic')) {
            $data['theme'] = $thematics->name;
            if ($thematics->courses->count() > $courseCont) {
                foreach ($thematics->courses as $thematic) {
                    if($thematics->courses[$courseCont]->state ==1){
                        $data['items'][$cont2]['photo'] = $thematics->courses[$courseCont]->photo;
                        $data['items'][$cont2]['name'] = $thematics->courses[$courseCont]->name;
                        $data['items'][$cont2]['thematic'] = $thematics->name;
                        $data['items'][$cont2]['price'] = $thematics->courses[$courseCont]->price;
                        $data['items'][$cont2]['promotion'] = $thematics->courses[$courseCont]->promotion_start != null && $thematics->courses[$courseCont]->promotion_start <= date('Y-m-d') && date('Y-m-d') <= $thematics->courses[$courseCont]->promotion_end ? $thematics->courses[$courseCont]->promotional_price : null;
                        $data['items'][$cont2]['id'] = $thematics->courses[$courseCont]->id;
                        $data['items'][$cont2]['user'] = $thematics->courses[$courseCont]->user->name;
                        $data['items'][$cont2]['description'] = $thematics->courses[$courseCont]->description;
                        $data['items'][$cont2]['type'] = 'item';
                        $data['items'][$cont2]['type2'] = 'course';
                        $data['items'][$cont2]['promotion'] = null;


                        $cont2++;
                    }
                    $courseCont++;
                }
            }
    
            if ($thematics->teachers->count() > $teachCont) {
                foreach ($thematics->teachers as $thematic) {
                    if ($thematics->teachers[$teachCont]->state ==1 && $thematics->teachers[$teachCont]->isOnline()){
                        $data['items'][$cont2]['photo'] = $thematics->teachers[$teachCont]->photo;
                        $data['items'][$cont2]['name'] = $thematics->teachers[$teachCont]->name;
                        $data['items'][$cont2]['thematic'] = $thematics->name;
                        $data['items'][$cont2]['price'] = null;
                        $data['items'][$cont2]['id'] = $thematics->teachers[$teachCont]->id;
                        $data['items'][$cont2]['type'] = 'teachers';
                        $data['items'][$cont2]['type2'] = 'teach';
                        $data['items'][$cont2]['promotion'] = null;


                        $cont2++;
                    }
                    $teachCont++;
                }
    
            }
    
            if ($thematics->cclass->count() > $classCont) {
                foreach ($thematics->cclass as $thematic) {
                    if($thematics->cclass[$classCont]->state ==1 && $thematics->cclass[$classCont]->course_id == null){
                        $data['items'][$cont2]['photo'] = $thematics->cclass[$classCont]->photo;
                        $data['items'][$cont2]['name'] = $thematics->cclass[$classCont]->name;
                        $data['items'][$cont2]['thematic'] = $thematics->name;
                        $data['items'][$cont2]['price'] = $thematics->cclass[$classCont]->price;
                        $data['items'][$cont2]['promotion'] = $thematics->cclass[$classCont]->promotion_start != null && $thematics->cclass[$classCont]->promotion_start <= date('Y-m-d') && date('Y-m-d') <= $thematics->cclass[$classCont]->promotion_end ? $thematics->cclass[$classCont]->promotional_price : null;
                        $data['items'][$cont2]['id'] = $thematics->cclass[$classCont]->id;
                        $data['items'][$cont2]['user'] = $thematics->cclass[$classCont]->instructor->name;
                        // $data['items'][$classCont]['description'] = $thematics->cclass[$classCont]->description;
                        $data['items'][$cont2]['type'] = 'item';
                        $data['items'][$cont2]['type2'] = 'class';
                        $data['items'][$cont2]['promotion'] = null;


                        $cont2++;
                    }
                    $classCont++;
                }
            }
    
            if ($thematics->teachers->count() > $teachCont) {
                foreach ($thematics->teachers as $thematic) {
                    if($thematics->teachers[$teachCont]->state ==1 && $thematics->teachers[$teachCont]->isOnline()){
                        $data['items'][$cont2]['photo'] = $thematics->teachers[$teachCont]->photo;
                        $data['items'][$cont2]['name'] = $thematics->teachers[$teachCont]->name;
                        $data['items'][$cont2]['thematic'] = $thematics->name;
                        $data['items'][$cont2]['price'] = null;
                        $data['items'][$cont2]['id'] = $thematics->teachers[$teachCont]->id;
                        $data['items'][$cont2]['type'] = 'teachers';
                        $data['items'][$cont2]['type2'] = 'teach';
                        $data['items'][$cont2]['promotion'] = null;


                        $cont2++;
                    }
                    $teachCont++;
                }
            }
    
            if ($thematics->courses->count() > $courseCont) {
                foreach ($thematics->courses as $thematic) {

                    if($thematics->courses[$courseCont]->state==1){
                        $data['items'][$cont2]['photo'] = $thematics->courses[$courseCont]->photo;
                        $data['items'][$cont2]['name'] = $thematics->courses[$courseCont]->name;
                        $data['items'][$cont2]['thematic'] = $thematics->name;
                        $data['items'][$cont2]['price'] = $thematics->courses[$courseCont]->price;
                        $data['items'][$cont2]['promotion'] = $thematics->courses[$courseCont]->promotion_start != null && $thematics->courses[$courseCont]->promotion_start <= date('Y-m-d') && date('Y-m-d') <= $thematics->courses[$courseCont]->promotion_end ? $thematics->courses[$courseCont]->promotional_price : null;
                        $data['items'][$cont2]['id'] = $thematics->courses[$courseCont]->id;
                        $data['items'][$cont2]['user'] = $thematics->courses[$courseCont]->user->name;
                        $data['items'][$cont2]['description'] = $thematics->courses[$courseCont]->description;
                        $data['items'][$cont2]['type'] = 'item';
                        $data['items'][$cont2]['type2'] = 'course';
                        $data['items'][$cont2]['promotion'] = null;


                        $cont2++;
                    }
                    $courseCont++;
                }
            }
        }
        //dd($thematics);
        return response()->json($data);
    }
}
