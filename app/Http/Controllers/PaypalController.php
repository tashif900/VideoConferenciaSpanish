<?php

namespace App\Http\Controllers;

use App\Plan;
use App\User;
use App\Cclass;
use App\Course;
use App\Meeting;
use App\Thematic;
use App\ClassUser;
use Carbon\Carbon;
use App\CourseUser;
use App\MeetingUser;
use PayPal\Api\Payer;
use App\InputMovement;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use App\InstructorMovement;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use Illuminate\Http\Request;
use PayPal\Api\RedirectUrls;
use App\PricesAdvertisements;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PayPal\Auth\OAuthTokenCredential;
use App\Mail\ConfirmationPurchaseMail;
use Illuminate\Support\Facades\Config;
use PayPal\Exception\PayPalConnectionException;

class PaypalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $paypalConfig = Config::get('paypal');
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConfig['client_id'],     // ClientID
                $paypalConfig['secret']      // ClientSecret
            )
        );
        $this->apiContext->setConfig(
            array(
                'mode'  =>  env('PAYPAL_MODE')
            )
        );
        //
    }

    public function payWithPaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        if ($request->type == 1) {
            $plan = Plan::find($request->item);
            $element = $request->item;

            $description = "Plan - {$plan->name}";
        } else if ($request->type == 2) {
            $plan = Cclass::find($request->item);
            $element = $request->item;

            $description = "Clase Online - {$plan->name}";
        } else if ($request->type == 3) {
            $plan = Course::find($request->item);
            $element = $request->item;

            $description = "Curso Online - {$plan->name}";
        } else if ($request->type == 4) {
            $plan = Meeting::find($request->item);
            $element = $request->item;

            $description = "Reunion Online - {$plan->name}";
        } else if ($request->type == 5) {
            $plan = PricesAdvertisements::find($request->item);
            $element = $request->item;

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

        $user = User::find($request->id);

        Auth::login($user);

        session(['ppel' => $element,'tepp' => $request->type]);

        $amount = new Amount();
        $amount->setTotal($price);
        $amount->setCurrency('MXN');

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription($description);

        $callbackUrl = url('/paypal/status');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($callbackUrl)
            ->setCancelUrl($callbackUrl);

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            return redirect()->away($payment->getApprovalLink());
        } catch (PayPalConnectionException $ex) {
            echo $ex->getData();
        }
    }

    public function payPalStatus(Request $request)
    {
        $paymentId = $request->input('paymentId');
        $payerId = $request->input('PayerID');
        $token = $request->input('token');

        $type = session()->get('tepp');

        $planId = session()->get('ppel');

        if ($type == 1) {
            $plan = Plan::find($planId);
        } else if ($type == 2) {
            $plan = Cclass::with('subtopic.thematic')->find($planId);
        } else if ($type == 3) {
            $plan = Course::with('subtopic.thematic')->find($planId);
        } else if ($type == 4) {
            $plan = Meeting::with('meeting_session')->find($planId);
        } else if ($type == 5) {
            $plan = PricesAdvertisements::find($planId);
        }
        
        if (!$paymentId || !$payerId || !$token) {
            $status = 'Lo sentimos! El pago a través de PayPal no se pudo realizar.';
            
            session()->forget('tepp');
            session()->forget('ppel');

            if ($type == 1) {
                return redirect("/dashboard-payment?status=failed&plan={$planId}");
            } else {
                return redirect("/dashboard-payment?status=failed&course={$planId}");
            }
        }

        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        /** Execute the payment **/
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() === 'approved') {
            if ($type == 1) {
                $description = "Plan - {$plan->name}";
            } else if ($type == 2) {
                $description = "Clase - {$plan->name}";
            } else if ($type == 3) {
                $description = "Curso - {$plan->name}";
            } else if ($type == 4) {
                $description = "Reunión - {$plan->name}";
            } else if ($type == 5) {
                $description = "Plan Anúnciate - {$plan->description}";
            }

            if ($type != 5) {
                if ($plan->promotional_price != null && $plan->promotion_start <= date('Y-m-d') && date('Y-m-d') <= $plan->promotion_end) {
                    $price = $plan->promotional_price;
                } else {
                    $price = $plan->price;
                }
            } else {
                $price = $plan->mount;
            }


            $movement = new InputMovement;
            $movement->user_id = auth()->user()->id;
            $movement->amount = $result->transactions[0]->amount->total;
            $movement->description = $description;
            $movement->number_operation = $result->id;
            $movement->payment_gateway_id = 2;
            $movement->save();
            
            $now = Carbon::now();

            if ($type == 1) {
                $user = auth()->user()->plans()->attach($plan,[
                            'inscription_date' => date('Y-m-d'),
                            'expiration_date' => $now->addDays($plan->validity_day)->format('Y-m-d'),
                            'input_movement_id' => $movement->id,
                            'state' => 1
                        ]);
            } else if ($type == 2) {
                $user = new ClassUser;
                $user->class_id = $plan->id;
                $user->user_id = auth()->user()->id;
                $user->input_movement_id = $movement->id;
                $user->state = 1;
                $user->save();

                $moi = new InstructorMovement;
                $moi->user_id = $plan->user_id;
                $moi->period = date('m-Y');
                $moi->amount = $result->transactions[0]->amount->total;
                $moi->platform_percentage = $this->getPlatformPercentage($plan->subtopic->thematic_id, $plan->user_id);
                $moi->class_id = $plan->id;
                $moi->state = 1;
                $moi->save();
            } else if ($type == 3) {
                $user = new CourseUser;
                $user->course_id = $plan->id;
                $user->user_id = auth()->user()->id;
                $user->input_movement_id = $movement->id;
                $user->state = 1;
                $user->save();

                $moi = new InstructorMovement;
                $moi->user_id = $plan->user_id;
                $moi->period = date('m-Y');
                $moi->amount = $result->transactions[0]->amount->total;
                $moi->platform_percentage = $this->getPlatformPercentage($plan->subtopic->thematic_id, $plan->user_id);
                $moi->course_id = $plan->id;
                $moi->state = 1;
                $moi->save();
            } else if ($type == 4) {
                $user = new MeetingUser;
                $user->meeting_id = $plan->id;
                $user->user_id = auth()->user()->id;
                $user->input_movement_id = $movement->id;
                $user->state = 1;
                $user->save();

                $moi = new InstructorMovement;
                $moi->user_id = $plan->user_id;
                $moi->period = date('m-Y');
                $moi->amount = $result->transactions[0]->amount->total;
                $moi->platform_percentage = $this->getPlatformPercentage($plan->thematic_id, $plan->user_id);
                $moi->meeting_id = $plan->id;
                $moi->state = 1;
                $moi->save();
            }


            Mail::to(auth()->user()->email)->send(new ConfirmationPurchaseMail($type, auth()->user(), $plan));

            if ($type == 1) {
                $status = "Gracias! La compra del Plan - {$plan->name}.";
    
                return redirect("/dashboard-payment?payment=1&status=success&type=1&plan={$planId}");
            } else if ($type == 2) {
                $status = "Gracias! La compra de la Clase - {$plan->name}.";
    
                return redirect("/mis-clases?payment=1&status=success&type=2&plan={$planId}");
            } else if ($type == 3) {
                $status = "Gracias! La compra del Curso - {$plan->name}.";
    
                return redirect("/mis-cursos?payment=1&status=success&type=3&plan={$planId}");
            } else if ($type == 4) {
                $status = "Gracias! La compra de la Reunion - {$plan->name}.";

                /*
                if ($plan->type_meeting == 1){
                    $hour_start = Carbon::parse($plan->hour_start)->subSecond(10);
                    $hora_actual = Carbon::now();
                    $state = $plan->state;

                    if ($state == 1 && ($hour_start < $hora_actual)){
                        return redirect("/meeting/$plan->room_id/1");
                    }
                }*/

                return redirect("/dashboard-schedule?payment=1&status=success&type=4&plan={$planId}");
            } else if ($type == 5){
                $status = "Gracias! La compra de la Plan anúnciate - {$plan->name}.";
    
                return redirect("/dashboard-payment?payment=1&status=success&type=5&plan={$planId}");
            }
        }

        if ($type == 1) {
            return redirect("/paid?plan={$plan->id}&type=1&status=error");
        } else if ($type == 2) {
            return redirect("/paid?item={$plan->id}&type=2&status=error");
        } else if ($type == 3) {
            return redirect("/paid?item={$plan->id}&type=3&status=error");
        } else if ($type == 4) {
            return redirect("/paid?item={$plan->id}&type=4&status=error");
        } else if ($type == 5) {
            return redirect("/paid?item={$plan->id}&type=5&status=error");
        }

    }

    public function paypalFailed(Request $request)
    {
        if ($request->has('plan')) {
            $plan = Plan::find($request->plan);
    
            $url =  URL::signedRoute('payment.index', ['plan' => $plan->id]);
        } else {
            $course = Course::find($request->course);
    
            $url =  URL::signedRoute('payment.index', ['curso' => $course->id]);
        }

        return redirect($url)->with('status', 'Lo sentimos! El pago a través de PayPal no se pudo realizar. Intentalo nuevamente o utiliza otro medio de pago.');
    }

    public function paypalResult(Request $request)
    {
        if ($request->has('plan')) {
            $plan = Plan::find($request->plan);

            return view('templates.example-plan', compact('plan'));
        } else {
            $course = Course::with('cclass')->find($request->course);
    
            return view('templates.example', compact('course'));
        }
    }

    public function getPlatformPercentage($element, $user_id)
    {
        $thematic = Thematic::find($element);
        if ($thematic != null) {
            $percentage = $thematic->percentage;

            $plan = $this->verifica($user_id);
            //dd($plan);
            if ($plan != false){
                //dd($plan);
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
        //dd($user);
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
