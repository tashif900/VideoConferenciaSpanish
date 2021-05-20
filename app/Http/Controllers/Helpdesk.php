<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationsController;

class Helpdesk extends Controller
{
    public function getHelpDeksUser(){
        try {
            $help_desks = \App\HelpDesk::where('user_id', Auth::id())->where('parent_id', null)->get();
            return response()->json($help_desks, 201);
        }catch (\Exception $e){
            return response()->json($e->getTrace(), 400);
        }

    }

    public function saveHelpDesk(Request $request){
        try {
            DB::beginTransaction();
            ///dd($request->title);
            $help_desk = new \App\HelpDesk();
            $help_desk->title = $request->title;
            $help_desk->description = $request->description;
            $help_desk->user_id = Auth::id();
            $help_desk->state = 1;
            $help_desk->parent_id= $request->parent_id;
            $help_desk->save();
            
            NotificationsController::sendNotificationToPusher(6);

            DB::commit();
            return response()->json(true, 201);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json($e->getTrace(), 400);
        }
    }

    public function editHelpDesk(Request $request){
        try {
            $helpDesk = \App\HelpDesk::with('helpdesks', 'parent')->find($request->id);
            //dd($helpDesk);
            return response()->json($helpDesk, 201);
        }catch (\Exception $e){
            return response()->json($e->getTrace(), 400);
        }
    }
}
