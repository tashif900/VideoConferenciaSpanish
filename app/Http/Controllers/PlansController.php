<?php

namespace App\Http\Controllers;

use App\Plan;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\PlanCollection;
use App\Http\Resources\Plan as PlanResource;
use Carbon\Carbon;

class PlansController extends Controller
{
    public function getPlans()
    {
        $plans = Plan::where('state', 1)->get();

        return response()->json(new PlanCollection($plans));
    }

    public function getPlanInformation(Request $request)
    {
        $plan = Plan::find($request->plan);

        return response()->json(new PlanResource($plan));
    }

    public function isPlanVigente (){
        $user = User::with('plans_user')->find(auth()->id());
        $verifica = 0;

        if (!empty($user)){
            $plans = $user->plans_user;
            foreach ($plans as $plan){
                $fecha_vigencia = Carbon::parse($plan->expiration_date);
                $fecha_actual = Carbon::now();
                $state = $plan->state;
                if ($state == 1 && ($fecha_actual <= $fecha_vigencia )){
                    $verifica = 1;
                    break;
                }
            }
        }
        return response()->json($verifica);
    }
}
