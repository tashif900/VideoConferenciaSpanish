<?php

namespace App\Http\Controllers;

use App\PeriodUser;
use App\OutputMovement;
use Jenssegers\Date\Date;
use App\WithdrawalRequest;
use App\InstructorMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\AdminNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Resources\RequestWithdrawResource;
use App\Http\Controllers\NotificationsController;
use App\Http\Resources\ActivityResourceCollection;
use App\Http\Resources\RequestWithdrawResourceCollection;

class RetreatsController extends Controller
{
    public function getUserPeriods(Request $request)
    {
        $periods = PeriodUser::where('user_id', auth()->user()->id)->where('state','!=', 2)->get(['period']);

        $allPeriods = PeriodUser::where('user_id', auth()->user()->id)->get(['period']);

        $periodos = array();
        $periodosTodos = array();

        $cont = 0;

        Date::setLocale('es');
        setlocale(LC_TIME,"es_ES");

        foreach ($periods as $period) {
            $periodos[$cont]['period'] = $period->period;
            $periodos[$cont]['label'] = Date::createFromFormat('m-Y', $period->period)->format('F Y');

            $cont++;
        }

        $cont2 = 0;
        foreach ($allPeriods as $periodo) {
            $periodosTodos[$cont2]['period'] = $periodo->period;
            $periodosTodos[$cont2]['label'] = Date::createFromFormat('m-Y', $periodo->period)->format('F Y');
            $MovementInstructor = InstructorMovement::where('user_id',auth()->id())
                ->where('period', $periodo->period)
                ->select(DB::raw('sum(amount*platform_percentage) as total'))
                ->first();
            $periodosTodos[$cont2]['total'] = $MovementInstructor->total;
            $cont2++;
        }
        
        return response()->json(array('all' => $periodosTodos, 'periods' => $periodos));
    }

    public function canWithdraw(Request $request)
    {
        $hasRequest = WithdrawalRequest::where('user_id', auth()->user()->id)->where('state', 1)->first();

        $cantRequest = $hasRequest == null ? true : false;

        return response()->json($cantRequest);
    }

    public function getResquest(Request $request)
    {
        $petitions = WithdrawalRequest::with('output')->where('user_id', auth()->user()->id)->get();

        return response()->json(new RequestWithdrawResourceCollection($petitions));
    }

    public function getActivity(Request $request)
    {
        $movementsCclass = InstructorMovement::with('cclass:id,name', 'cclass.participantes')
                                            ->where('user_id', auth()->id())
                                            ->select(DB::raw('sum(amount * platform_percentage) as total, period, class_id'))
                                            ->whereNotNull('class_id')
                                            ->where('period', $request->period)
                                            ->groupBy('period','class_id')
                                            ->orderBy('period', 'ASC')
                                            ->get();

        $movementsCourse = InstructorMovement::with('course:id,name', 'course.participantes')
                                            ->where('user_id', auth()->id())
                                            ->select(DB::raw('sum(amount * platform_percentage) as total, period, course_id'))
                                            ->whereNotNull('course_id')
                                            ->where('period', $request->period)
                                            ->groupBy('period','course_id')
                                            ->orderBy('period', 'ASC')
                                            ->get();
        $movementsMeeeting = InstructorMovement::with('meeting:id,name', 'meeting.participants')
                                            ->where('user_id', auth()->id())
                                            ->select(DB::raw('sum(amount * platform_percentage) as total, period, meeting_id'))
                                            ->whereNotNull('meeting_id')
                                            ->where('period', $request->period)
                                            ->groupBy('period','meeting_id')
                                            ->orderBy('period', 'ASC')
                                            ->get();

        return response()->json(array('clases' => new ActivityResourceCollection($movementsCclass), 'course' => new ActivityResourceCollection($movementsCourse), 'meeting' => new ActivityResourceCollection($movementsMeeeting)));
    }

    public function getRequestPeriod(Request $request)
    {
        $payments = InstructorMovement::where('user_id',auth()->id())
                            ->select(DB::raw('sum(amount * platform_percentage) as total, period'))
                            ->where('period', $request->period)
                            ->groupBy('period')
                            ->orderBy('period', 'ASC')
                            ->get();

        return response()->json($payments);
    }

    public function getLastRequest(Request $request)
    {
        $getLastRequest = WithdrawalRequest::where('user_id', auth()->user()->id)->where('state', 2)->select('amount')->latest()->first();
        $lastRequest = $getLastRequest == null ? 0.00 : $getLastRequest->amount;

        return response()->json($lastRequest);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $hasRequest = WithdrawalRequest::where('user_id', auth()->user()->id)->where('state', 1)->first();

            if ($hasRequest != null) {
                return redirect()->back()->with('error', 'Oops. Ya tienes una solicitud en curso. Espera a que sea completada para hacer una nueva solicitud.');
            }

            for ($i=0; $i < count($request->periods); $i++) { 
                $p = InstructorMovement::where('user_id',auth()->id())
                            ->select(DB::raw('sum(amount * platform_percentage) as total, period'))
                            ->where('period', $request->periods[$i])
                            ->groupBy('period')
                            ->orderBy('period', 'ASC')
                            ->first();

                $petition = new WithdrawalRequest;
                $petition->request_date = date('Y-m-d');
                $petition->user_id = auth()->user()->id;
                $petition->amount = $p->total;
                $petition->state = 1;
                $petition->save();

                $ouput = new OutputMovement;
                $ouput->withdrawal_request_id = $petition->id;
                $ouput->amount = $p->total;
                $ouput->period = $request->periods[$i];
                $ouput->save();

            }
        
            NotificationsController::sendNotificationToPusher(1);

            DB::commit();

            return response()->json(true);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function getCurrentIncome(Request $request)
    {
        $movements = InstructorMovement::where('user_id', auth()->user()->id)
                                    ->where('period', $request->period)
                                    ->get();

        $current = 0.00;

        foreach ($movements as $movement) {
            $current = (float) $current + (float) ((float) $movement->amount * (float) $movement->platform_percentage);
        }

        return response()->json(number_format($current, 2, '.', ','));
    }
}
