<?php

namespace App\Http\Controllers;

use App\Http\Controllers\NotificationsController;
use App\Meeting;
use App\MeetingSession;
use App\MeetingInvitation;
use Illuminate\Http\Request;
use App\Mail\MeetingInvitationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendInivitationEmailJob;
use App\Http\Resources\MeetingCollection;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendInivitationMultipleSessionEmailJob;

class DateController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|min:3',
            'category' => 'required',
            'type' => 'required',
            'participants' => 'required',
            'price' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $date = new Meeting();
        $date->name = $request->name;
        $date->description = $request->description;
        $date->price = $request->price;
        $date->discount = $request->discount;
        $date->thematic_id = $request->category;
        $date->type_meeting = $request->type;
        $date->state = $request->state;
        $date->hour_start = date('Y-m-d H:m', strtotime($request->start_hour));
        $date->hour_end = date('Y-m-d H:m', strtotime($request->end_hour));
        $date->user_id = $request->user;
        $date->room_id = $this->roomNameGenerator();
        $date->code = $this->roomCodeGenerator();
        $date->promotional_price = $request->promotional_price;
        $date->promotion_start = date('Y-m-d', strtotime($request->start_promotion));
        $date->promotion_end = date('Y-m-d', strtotime($request->end_promotion));
        $date->save();

        NotificationsController::sendNotificationToPusher(4);

        return response()->json($date,201);
    }

    private function saveMeetingSingle (Request $request){
        $date = new Meeting();
        $date->name = $request->name;
        $date->description = $request->description;
        $date->price = $request->price;
        $date->discount = $request->discount;
        $date->thematic_id = $request->category;
        $date->type_meeting = $request->type;
        $date->state = $request->state;
        $date->hour_start = date('Y-m-d H:m', strtotime($request->start_hour));
        $date->hour_end = date('Y-m-d H:m', strtotime($request->end_hour));
        $date->user_id = $request->user;
        $date->room_id = $this->roomNameGenerator();
        $date->code = $this->roomCodeGenerator();
        $date->promotional_price = $request->promotional_price;
        $date->promotion_start = date('Y-m-d', strtotime($request->start_promotion));
        $date->promotion_end = date('Y-m-d', strtotime($request->end_promotion));
        $date->save();

        NotificationsController::sendNotificationToPusher(4);

        $linkInvitation = env('APP_URL') . "/meeting/$date->room_id/1";

        if (count($request->invitations) > 0) {
            for ($i=0; $i < count($request->invitations); $i++) {
                $invitation = new MeetingInvitation;
                $invitation->name = $request->invitations[$i]['name'];
                $invitation->email = $request->invitations[$i]['email'];
                $invitation->meeting_id = $date->id;
                $invitation->save();

                dispatch(new SendInivitationEmailJob($request->invitations[$i]['name'], $linkInvitation, $request->invitations[$i]['email'], $date->code));
            }
        }
        return $date;
    }

    public function storeMeeting(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            //'description' => 'required|min:3',
            'category' => 'required',
            'type' => 'required',
            // 'participants' => 'required',
            'price' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $date = $this->saveMeetingSingle($request);
        //dd($date);
        return response()->json($date,201);
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

        $existUuid = Meeting::where('room_id', $uuid)->first();

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
    }

    function roomCodeGenerator() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    private function getMeetings($meetings1, $state){

        $real_meeting = array();
        //1. Sesiones Individuales
        foreach ($meetings1 as $meeting){
            $meeting_test=null;
            $meeting_test = new Meeting();
            $meeting_test->id = $meeting->id;
            $meeting_test->name = $meeting->name;
            $meeting_test->type_meeting = $meeting->type_meeting;
            $meeting_test->code = $meeting->code;
            $meeting_test->room_id = $meeting->room_id;
            $meeting_test->hour_start = $meeting->hour_start;
            $meeting_test->hour_end = $meeting->hour_end;
            $meeting_test->user_id = $meeting->user_id;
            $meeting_test->state = $meeting->state;
            $meeting_test->state_type = $state;
            array_push($real_meeting, $meeting_test);
        }

        //2. Sesiones Múltiples según estado
        $meeting_mult = Meeting::where('user_id', auth()->id())->where('type_meeting',2)->get();
        $meeting_mult2 = auth()->user()->meetings()->where('meetings.type_meeting', 2)->get();

        //dd($meeting_mult2);
        $meeting_multiple = $meeting_mult->merge($meeting_mult2);

        //dd($meeting_multiple);

        foreach($meeting_multiple as $meet_m){
            $meetings_session = null;
            if ($state == 1){ //Today
                $meetings_session = MeetingSession::where('meeting_id', $meet_m->id)
                    ->whereDate('hour_start', date('Y-m-d'))->where('state', 1)->orderBy('hour_start', 'ASC')
                    ->get();
            }else if ($state == 2){
                $meetings_session = MeetingSession::where('meeting_id', $meet_m->id)
                    ->whereDate('hour_start', '>', date('Y-m-d'))->orderBy('hour_start', 'ASC')
                    ->get();
            }else if ($state == 3) {
                $meetings_session = MeetingSession::where('meeting_id', $meet_m->id)
                    ->where (function ($query){
                        $query->whereDate('hour_start', '<', date('Y-m-d'))->orWhere('state', 5);
                    })
                ->orderBy('hour_start', 'ASC')
                ->get();
            }

            //dd($meetings_session);
            foreach ($meetings_session as $meetsession){
                $meeting_test = new Meeting();
                $meeting_test->id = $meetsession->id;
                $meeting_test->name = $meet_m->name . ' - ' . $meetsession->name;
                $meeting_test->type_meeting= $meet_m->type_meeting;
                $meeting_test->code= $meet_m->code;
                $meeting_test->room_id = $meetsession->room_id;
                $meeting_test->hour_start = $meetsession->hour_start;
                $meeting_test->state = $meetsession->state;
                $meeting_test->user_id = $meet_m->user_id;
                $meeting_test->state_type = $state;
                array_push($real_meeting, $meeting_test);
            }
        }
        /*
        foreach ($meetings1 as $meeting){
            $meeting_test=null;
            if ($meeting->type_meeting ==2 ){
                $meetings_session = MeetingSession::where('meeting_id', $meeting->id)->get();
                foreach ($meetings_session as $meetsession){
                    $meeting_test = new Meeting();
                    $meeting_test->id = $meetsession->id;
                    $meeting_test->name = $meeting->name . ' - ' . $meetsession->name;
                    $meeting_test->type_meeting= $meeting->type_meeting;
                    $meeting_test->code= $meeting->code;
                    $meeting_test->room_id = $meetsession->room_id;
                    $meeting_test->hour_start = $meeting->hour_start;
                    $meeting_test->state = $meetsession->state;
                    array_push($real_meeting, $meeting_test);
                }
            }else{
                $meeting_test = new Meeting();
                $meeting_test->id = $meeting->id;
                $meeting_test->name = $meeting->name;
                $meeting_test->type_meeting = $meeting->type_meeting;
                $meeting_test->code = $meeting->code;
                $meeting_test->room_id = $meeting->room_id;
                $meeting_test->hour_start = $meeting->hour_start;
                $meeting_test->hour_end = $meeting->hour_end;
                $meeting_test->user_id = $meeting->user_id;
                $meeting_test->state = $meeting->state;
                array_push($real_meeting, $meeting_test);
            }

        }*/
        return $real_meeting;
    }

    private function TodayMeetings (){
        $meetings1 = Meeting::where('user_id', auth()->id())->where('type_meeting', 1)
            ->whereDate('hour_start', date('Y-m-d'))->where('state', 1)->orderBy('hour_start', 'ASC')->get();

        $meetings2 = auth()->user()->meetings()->whereDate('hour_start', date('Y-m-d'))->where('meetings.type_meeting', 1)
            ->where('meetings.state', 1)->orderBy('hour_start', 'ASC')->get();


        if (auth()->user()->hasRole('Profesor')) {
            $meetings= $meetings1->merge($meetings2);
        } else {
            $meetings = $meetings2;
        }

        $real_meeting = $this->getMeetings($meetings, 1);

        return $real_meeting;
    }

    public function getTodaysMeetings(Request $request)
    {
        $real_meeting = $this->TodayMeetings();
        return response()->json(new MeetingCollection($real_meeting));
    }

    private function UpcomingMeetings (){
        $meetings1 = Meeting::where('user_id', auth()->id())->where('type_meeting', 1)
            ->whereDate('hour_start', '>', date('Y-m-d'))->orderBy('hour_start', 'ASC')->get();

        $meetings2 = auth()->user()->meetings()->whereDate('hour_start', '>', date('Y-m-d'))->where('meetings.type_meeting', 1)
            ->orderBy('hour_start', 'ASC')->get();


        if (auth()->user()->hasRole('Profesor')) {
            $meetings= $meetings1->merge($meetings2);
        } else {
            $meetings = $meetings2;
        }
        $real_meetings = $this->getMeetings($meetings, 2);

        return $real_meetings;
    }
    public function getUpcomingMeetings(Request $request)
    {
        $real_meetings = $this->UpcomingMeetings();

        return response()->json(new MeetingCollection($real_meetings));
    }

    public function PastMeeting (){
        $meetings1 = Meeting::where('user_id', auth()->id())->where('type_meeting', 1)
            ->where (function ($query){
                $query->whereDate('hour_start', '<', date('Y-m-d'))->orWhere('state', 5);
            })
            ->orderBy('hour_start', 'ASC')->get();

        $meetings2 = auth()->user()->meetings()->where('meetings.type_meeting', 1)
            ->where (function ($query){
                $query->whereDate('hour_start', '<', date('Y-m-d'))->orWhere('meetings.state', 5);
            })
            ->orderBy('hour_start', 'ASC')->get();


        if (auth()->user()->hasRole('Profesor')) {
            $meetings= $meetings1->merge($meetings2);
        } else {
            $meetings = $meetings2;
        }
        //dd($meetings);

        $real_meetings = $this->getMeetings($meetings, 3);

        return $real_meetings;

    }

    public function getPastsMeetings(Request $request)
    {
        //dd($real_meetings);
        $real_meetings = $this->PastMeeting();
        return response()->json(new MeetingCollection($real_meetings));
    }

    public function calendarMeetings (){
        $calendar_meetings = array();
        array_push($calendar_meetings, $this->TodayMeetings());
        array_push($calendar_meetings, $this->PastMeeting());
        array_push($calendar_meetings, $this->UpcomingMeetings());


        return response()->json($calendar_meetings);
    }


    public function storeMeetingSession(Request $request)
    {
        //dd($request->dates);

        $rules = [
            'name' => 'required|min:3',
            //'description' => 'required|min:3',
            'category' => 'required',
            'type' => 'required',
            // 'participants' => 'required',
            'price' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        if ($request->type_meeting == 1){
            $date = $this->saveMeetingSingle($request);
            $session=null;
        }else{
            $date = new Meeting();
            $date->name = $request->name;
            $date->description = $request->description;
            $date->price = $request->price;
            $date->discount = $request->discount;
            $date->thematic_id = $request->category;
            $date->type_meeting = $request->type;
            $date->state = $request->state;
            $date->hour_start = date('Y-m-d H:m', strtotime($request->start_hour));
            $date->hour_end = date('Y-m-d H:m', strtotime($request->start_hour));
            $date->user_id = $request->user;
            $date->room_id = $this->roomNameGenerator();
            $date->session_number = $request->sessions;
            $date->code = $this->roomCodeGenerator();
            $date->promotional_price = $request->promotional_price;
            $date->promotion_start = date('Y-m-d', strtotime($request->start_promotion));
            $date->promotion_end = date('Y-m-d', strtotime($request->end_promotion));
            $date->save();

            NotificationsController::sendNotificationToPusher(4);

            //Agregar Sesiones con Fecha
            $sessions = array();

            //dd($request->dates[0]['session']);
            foreach ($request->dates as $item){
                $room = $this->roomNameGenerator();

                $session = new MeetingSession;
                $session->name = $item['session'];
                $session->room_id = $room;
                $session->meeting_id = $date->id;
                $session->hour_start = date('Y-m-d H:m', strtotime($item['date']));
                $session->state=1;
                $session->save();

                $sessions[] = [
                    'room' => env('APP_URL') . '/meeting/'.$room . '/2', 'name' => $item['session']
                ];
            }

            /*$sessions = array();
            for ($i=0; $i < $request->sessions; $i++) {
                $room = $this->roomNameGenerator();
                $name = 'Sesión N°' . ($i + 1);

                $session = new MeetingSession;
                $session->name = $name;
                $session->room_id = $room;
                $session->meeting_id = $date->id;
                //Prueba
                $session->hour_start = date('Y-m-d H:m', strtotime($request->start_hour));
                $session->state=1;
                $session->save();

                $sessions[$i] = [
                    'room' => env('APP_URL') . '/meeting/'.$room, 'name' => $name
                ];
            }*/



            $linkInvitation = env('APP_URL') . "/meeting/$date->room_id/1";

            if (count($request->invitations) > 0) {
                for ($i=0; $i < count($request->invitations); $i++) {
                    $invitation = new MeetingInvitation;
                    $invitation->name = $request->invitations[$i]['name'];
                    $invitation->email = $request->invitations[$i]['email'];
                    $invitation->meeting_id = $date->id;
                    $invitation->save();
                    dispatch(new SendInivitationMultipleSessionEmailJob($request->invitations[$i]['name'], $sessions, $request->invitations[$i]['email'], $date->code, $linkInvitation));
                }
            }
        }
        return response()->json(array('date' => $date, 'sessions' => $sessions),201);
    }
}
