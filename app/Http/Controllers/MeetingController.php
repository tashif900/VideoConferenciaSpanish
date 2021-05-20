<?php

namespace App\Http\Controllers;

use App\MeetingSession;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Validator;
use App\Meeting;
use App\MeetingUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationsController;

class MeetingController extends Controller
{

    public function saveMeeting(Request $request){
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|min:3',
            'type_meeting' => 'required',
            'price' => 'required',
            'hour_start' => 'required',
            'hour_end' => 'required',
            'state' => 'required',
            'thematic_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $meeting = new Meeting();
        $meeting->name = $request->name;
        $meeting->description = $request->description;
        $meeting->type_meeting = $request->type_meeting;
        $meeting->number_participant = $request->number_participant;
        $meeting->price = $request->price;
        $meeting->hour_start = $request->hour_start;
        $meeting->hour_end = $request->hour_end;
        $meeting->url_room = $request->url_room;
        $meeting->room_password = $request->room_password;
        $meeting->room_name = $request->room_name;
        $meeting->room_id = $request->room_id;
        $meeting->state = $request->state;
        $meeting->thematic_id = $request->thematic_id;
        $meeting->user_id = Auth::id();
        $meeting->save();

        NotificationsController::sendNotificationToPusher(4);

        return response()->json($meeting,201);

    }

    public function updateMeeting(Request $request){
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|min:3',
            'type_meeting' => 'required',
            'price' => 'required',
            'hour_start' => 'required',
            'hour_end' => 'required',
            'state' => 'required',
            'thematic_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $meeting = Meeting::where('id',$request->meeting_id)->first();
        $meeting->name = $request->name;
        $meeting->description = $request->description;
        $meeting->type_meeting = $request->type_meeting;
        $meeting->number_participant = $request->number_participant;
        $meeting->price = $request->price;
        $meeting->hour_start = $request->hour_start;
        $meeting->hour_end = $request->hour_end;
        $meeting->url_room = $request->url_room;
        $meeting->room_password = $request->room_password;
        $meeting->room_name = $request->room_name;
        $meeting->room_id = $request->room_id;
        $meeting->state = $request->state;
        $meeting->thematic_id = $request->thematic_id;
        $meeting->save();

        return response()->json($meeting,201);

    }

    public function getMeeting(){
        $meeting = Meeting::with('user','thematic')->get();
        if(count($meeting) == 0){
            return response()->json(["message" => "Registros no encontrados!"],404);
        }
        return response()->json($meeting,200);
    }

    public function getMeetingById($id){
        $meeting = Meeting::with('user','thematic')->where('id',$id)->get();
        if(count($meeting) == 0){
            return response()->json(["message" => "Registros no encontrados!"],404);
        }
        return response()->json($meeting,200);
    }

    public function getMeetingByUser(){
        $meeting = Meeting::with('user','thematic')->where('user_id',Auth::id())->get();
        if(count($meeting) == 0){
            return response()->json(["message" => "Registros no encontrados!"],404);
        }
        return response()->json($meeting,200);
    }

    public function joinMeeting(Request $request){
        $meeting = Meeting::with('user','thematic')->where('url_room',$request->code)->get();
        if(count($meeting) == 0){
            return response()->json(["message" => "Cita no encontrada!"],404);
        }
        return response()->json($meeting,200);

    }

    public function searchMeeting(Request $request)
    {
        $meeting = Meeting::where('code', $request->code)->with('user:id,name')->select('room_id', 'name','id','description', 'hour_start','price', 'user_id', 'state')->first();

        if ($meeting == null) {
            
            return response()->json(false);
        }

        return response()->json($meeting);
    }

    public function searchMeetingSecure(Request $request)
    {
        $meeting = Meeting::where('code', $request->code)->with('user:id,name')
            ->select('room_id', 'name','type_meeting', 'hour_start','promotion_start', 'promotion_end', 'promotional_price','price', 'user_id','id','state')
            ->first();

        //dd($meeting->promotion_start);
        if ($meeting == null) {
            
            return response()->json(false);
        }

        if ($meeting->state == 5) {
            return response()->json(false);
        }

        $can = true;
        $haspurchase = false;

        /**
         * Calcular Validez de Precio Promocional
        **/
        $validate_promotional_price =false;
        $fecha_inicio = Carbon::parse($meeting->promotion_start);
        $fecha_fin = Carbon::parse($meeting->promotion_end);
        $fecha_actual = Carbon::now();

        if ($fecha_actual->gte($fecha_inicio) && $fecha_actual->lte($fecha_fin)){
            // Si la fecha actual es mayor o igual a fecha inicio y fecha actual es menor o igual a ficha fin
            $validate_promotional_price =true;
        }
        /**
         * Fin cálculo validez precio promocional
        */

       // dd($promotional_price);
        if (auth()->user()->hasRole('Profesor')) {
            if ($meeting->user_id != auth()->user()->id) {
                $can = false;
            }
        } else {
            $hasMeeting = MeetingUser::where('user_id', auth()->user()->id)->where('meeting_id', $meeting->id)->first();
    
            if ($hasMeeting == null) {
                $can = false;
                $haspurchase = true;
            } else {
                $can = true;
            }
        }        

        return response()->json(array('meeting' => $meeting, 'can' => $can, 'hasPurchase' => $haspurchase, 'meetingState' => $meeting->state,
            'val_promo_price' => $validate_promotional_price));
    }

    public function getInformation(Request $request)
    {
        $meeting = Meeting::select('id', 'name', 'description', 'price','promotion_start', 'promotion_end','room_id',
            'promotional_price', 'type_meeting', 'hour_start', 'state')
            ->find($request->id);

        return response()->json($meeting);
    }

    public function getMeetingSingle(Request $request)
    {
        //dd($request->type);
        if ($request->type == "1"){
            $meeting = Meeting::where('room_id', $request->uuid)->where('state', '!=', 5)->with('user')->first();
            $checkinstructor = $this->checkInstructorMeeting($meeting->user_id);

        } else{
            $meeting = MeetingSession::where ('room_id', $request->uuid)->where('state', '!=', 5)->with('meeting.user')->first();
            $checkinstructor = $this->checkInstructorMeeting($meeting->meeting['user_id']);
        }

        $server_jitsi = env("JITSI_DOMAIN", "https://meet.jit.si");

        return response()->json(array('item' => $meeting,
            'checkinstructor' => $checkinstructor,
            'server_jitsi' => $server_jitsi));
    }

    private function checkInstructorMeeting($instructor_id){
        $check =false;
        if ($instructor_id == auth()->id()){
            $check = true;
        }
        return $check;
    }

    public function finish(Request $request)
    {
        //dd($request->type);
        if ($request->type == '1'){
            $meeting = Meeting::find($request->meeting);
        }else{
            $meeting = MeetingSession::find($request->meeting);
        }
        $meeting->state = 5;
        $meeting->save();

        return response()->json(true);
    }

    public function checkSubscribeSession(Request $request) {
        $meeting = Meeting::where('room_id', $request->post('uuid'))->where('state', '!=', 5)->select('id', 'user_id')->first();


        if($meeting->user_id == Auth::id()) {
            return response()->json(array('check' =>1, 'meetingid' => $meeting->id ));
        }

        $checkMeetingUser = MeetingUser::where([
            ['meeting_id', $meeting->id],
            ['user_id', Auth::id()]
        ])->count();

        return response()->json(array('check' =>$checkMeetingUser, 'meetingid' => $meeting->id ));
    }
}
