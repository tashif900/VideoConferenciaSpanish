<?php

namespace App\Http\Controllers;

use App\CourseUser;
use App\Plan;
use App\Cclass;
use App\Course;
use App\Meeting;
use App\Thematic;
use App\ClassUser;
use App\User;
use Carbon\Carbon;
use Conekta\Order;
use App\MeetingUser;
use Conekta\Conekta;
use App\InputMovement;
use App\InstructorMovement;
use Conekta\ProcessingError;
use Illuminate\Http\Request;
use App\PricesAdvertisements;
use Illuminate\Support\Facades\Mail;
use Conekta\ParameterValidationError;
use App\Mail\ConfirmationPurchaseMail;

class CardPaymentController extends Controller
{
    private $apiKey;
    private $apiVersion;

    public function __construct()
    {
        $this->apiKey = env('CONEKTA_API_KEY');
        $this->apiVersion = '2.0.0';
    }

    protected function setApiKey() {
        Conekta::setApiKey($this->apiKey);
        Conekta::setApiVersion($this->apiVersion);
    }

    public function process(Request $request)
    {
        $this->setApiKey();
        
        if ($request->type == 1) {
            $plan = Plan::find($request->plan);
            $element = $request->plan;

            $description = "Plan - {$plan->name}";
        } else if ($request->type == 2) {
            $plan = Cclass::find($request->plan);
            $element = $request->plan;

            $description = "Clase Online - {$plan->name}";
        } else if ($request->type == 3) {
            $plan = Course::find($request->plan);
            $element = $request->plan;

            $description = "Curso Online - {$plan->name}";
        } else if ($request->type == 4) {
            $plan = Meeting::find($request->plan);
            $element = $request->plan;

            $description = "Reunion Online - {$plan->name}";
        } else if ($request->type == 5) {
            $plan = PricesAdvertisements::find($request->plan);
            $element = $request->plan;

            $description = "Plan Anúnciate - {$plan->description}";
        }

        if ($request->type != 5) {
            if ($plan->promotional_price != null && $plan->promotion_start <= date('Y-m-d') && date('Y-m-d') <= $plan->promotion_end) {
                $price = $plan->promotional_price;
            } else {
                $price = $plan->price;
            }
        } else {
            $price = $plan->mount;
        }

        try {
            $order = Order::create([
                'amount' => $price,
                'line_items' => [
                    [
                        'name' => $description,
                        'unit_price' => (float) $price * 100,
                        'quantity' => 1,
                    ],
                ],
                'currency' => 'MXN',
                'charges' => [
                    [
                        'payment_method' => [
                            'type' => 'card',
                            'token_id' => $request->token,
                        ]
                    ]
                ],
                'customer_info' => [
                    'name'  => $request->card,
                    'phone' => $request->phone,
                    'email' => auth()->user()->email,
                ]
            ]);

            //dd($order);

            $movement = new InputMovement;
            $movement->user_id = auth()->user()->id;
            $movement->amount = $price;
            $movement->description = $description;
            $movement->number_operation = $order->id;
            $movement->payment_gateway_id = 1;
            $movement->save();
            
            $now = Carbon::now();

            if ($request->type == 1) {
                $user = auth()->user()->plans()->attach($plan,[
                            'inscription_date' => date('Y-m-d'),
                            'expiration_date' => $now->addDays($plan->validity_day)->format('Y-m-d'),
                            'input_movement_id' => $movement->id,
                            'state' => 1
                        ]);
            } else if ($request->type == 2) {
                $user = new ClassUser;
                $user->class_id = $plan->id;
                $user->user_id = auth()->user()->id;
                $user->input_movement_id = $movement->id;
                $user->state = 1;
                $user->save();

                $moi = new InstructorMovement;
                $moi->user_id = $plan->user_id;
                $moi->period = date('m-Y');
                $moi->amount = floatval($order->amount) /100;
                $moi->platform_percentage = $this->getPlatformPercentage($plan->subtopic->thematic_id, $plan->user_id);
                $moi->class_id = $plan->id;
                $moi->state = 1;
                $moi->save();
            } else if ($request->type == 3) {
                $user = new CourseUser;
                $user->course_id = $plan->id;
                $user->user_id = auth()->user()->id;
                $user->input_movement_id = $movement->id;
                $user->state = 1;
                $user->save();

                $moi = new InstructorMovement;
                $moi->user_id = $plan->user_id;
                $moi->period = date('m-Y');
                $moi->amount = floatval($order->amount) /100;
                $moi->platform_percentage = $this->getPlatformPercentage($plan->subtopic->thematic_id, $plan->user_id);
                $moi->course_id = $plan->id;
                $moi->state = 1;
                $moi->save();
            } else if ($request->type == 4) {
                $user = new MeetingUser;
                $user->meeting_id = $plan->id;
                $user->user_id = auth()->user()->id;
                $user->input_movement_id = $movement->id;
                $user->state = 1;
                $user->save();

                $moi = new InstructorMovement;
                $moi->user_id = $plan->user_id;
                $moi->period = date('m-Y');
                $moi->amount = floatval($order->amount) /100;
                $moi->platform_percentage = $this->getPlatformPercentage($plan->thematic_id, $plan->user_id);
                $moi->meeting_id = $plan->id;
                $moi->state = 1;
                $moi->save();
            }


            Mail::to(auth()->user()->email)->send(new ConfirmationPurchaseMail($request->type, auth()->user(), $plan));

            return response()->json(true);

        } catch (ProcessingError $e){
            return response()->json($e->getMessage());
        } catch (ParameterValidationError $e){
            return response()->json($e->getMessage());
        } catch (Handler $e) {
            return response()->json($e->getMessage());
        }
    }

    public function getPlatformPercentage($element, $user_id)
    {
        $thematic = Thematic::find($element);
        if ($thematic != null) {
            $percentage = $thematic->percentage;
            $plan = $this->verifica($user_id);

            if ($plan != false){
                $percentage_plan = $plan->percentage;
                $percentage = (float) $percentage - (float) $percentage_plan;
                if ($percentage < 0) $percentage =0;
            }

            $p = 100 - (float) $percentage;
            $d = (float) $p / 100;

            return $d;
        }

        return 0.00;
    }

    private function verifica ($user_id){
        $user = User::with('plans_user.plan')->find($user_id);
        $resultado = false;

        if (!empty($user)){
            $plans = $user->plans_user;
            foreach ($plans as $plan_user){
                $fecha_vigencia = Carbon::parse($plan_user->expiration_date);
                $fecha_actual = Carbon::now();
                $state = $plan_user->state;
                if ($state == 1 && ($fecha_actual <= $fecha_vigencia )){
                    $resultado = $plan_user->plan;
                    break;
                }
            }
        }

        return $resultado;
    }
}
