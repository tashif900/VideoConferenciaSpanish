<?php

namespace App\Http\Controllers;

use App\User;
use App\UserReport;
use Illuminate\Http\Request;
use App\Http\Controllers\NotificationsController;

class ReportUserController extends Controller
{
    public function searchUser(Request $request)
    {
        $user = User::where('code', $request->user)->orWhere('email', $request->user)->select('id','name')->first();

        return response()->json($user);
    }

    public function store(Request $request)
    {
        $report = new UserReport;
        $report->comment = $request->comment;
        $report->reported_user = $request->reported_user;
        $report->user_report = $request->user_report;
        $report->state = 1;
        $report->save();

        NotificationsController::sendNotificationToPusher(7);

        return response()->json(true);
    }
}
