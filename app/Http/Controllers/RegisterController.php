<?php

namespace App\Http\Controllers;

use App\User;
use App\People;
use App\PeriodUser;
use App\InterestUser;
use GuzzleHttp\Client;
use App\PaymentAccount;
use App\PaymentMethodUser;
use Illuminate\Support\Arr;
use App\DocumentAccountUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\AppServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class RegisterController extends Controller 
{
    use SendsPasswordResetEmails;

    public function login(Request $request) {
        //dd(User::where('email', $request['email'])->with('people', 'roles')->first());
        DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required'
            ]);

            if($validator->fails()) {
                return response()->json(["message" => "Credenciales Incorrectas!"],404);
            }


            if(Auth::attempt(['email' => $request->email,'password' => $request->password])) {

                $credentials = AppServiceProvider::buildCredentials([
                    'username' => $request['email'],
                    'password' => $request['password'],
                ]);

                $user_n = User::where('email', $request['email'])->with('people', 'roles', 'payment_method_users', 'paymentAccount', 'socialAccounts', 'interest_users')->first();

                if ($user_n->hasRole('Profesor')) {
                    $hasPeriod = PeriodUser::where('user_id', $user_n->id)->where('period', date('m-Y'))->first();

                    if ($hasPeriod == null) {
                        $currentPeriod = new PeriodUser;
                        $currentPeriod->user_id = $user_n->id;
                        $currentPeriod->period = date('m-Y');
                        $currentPeriod->save();
                    }
                }

                //dd($user_n);
                $response =  AppServiceProvider::makeRequest($credentials);

                //dd($response);
                //dd($response, env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'));

                $response['user'] = $user_n;
                
                

                event(new Registered($user_n));

                DB::commit();

                return response ()->json([
                    'tokens'    =>  $response,
                    'status'    =>  'SUCCESS',
                    'message'   =>  'ÉXITO',
                    'server_jitsi' => env('JITSI_DOMAIN', 'https://meet.jit.si')
                ]);

            } else {
                abort('403', "Credenciales incorrectas");
            }

        }catch (\Exception $e){
            return response()->json($e->getMessage(), 400);
        }
    }

    public function registerStudent(Request $request){
        DB::beginTransaction();
        $interests = Arr::pull($request, 'interests');

        try {

            $user = new User();
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->code = $this->getUserCode();
            $user->password = Hash::make($request['password']);
            $user->state = $request['state'];
            $user->save();

            $people = new People();
            $people->user_id = $user->id;
            $people->save();

            $user->interest_users()->sync($request->userInterestSelected);

            if(isset($interests)){
                for ($i = 0; $i < count($interests); $i++){
                    $interest_user = new InterestUser();
                    $interest_user->interest_id = $interests[$i]['interest_id'];
                    $interest_user->user_id = $user->id;
                    $interest_user->save();
                }
            }

            $user->assignRole('Alumno');

            $credentials = AppServiceProvider::buildCredentials([
                'username' => $request['email'],
                'password' => $request['password'],
            ]);

            $user_n = $user->where('email', $request['email'])->with('people', 'roles', 'paymentAccount', 'payment_method_users', 'socialAccounts', 'interest_users')->first();

            //dd($user_n);

            $response = AppServiceProvider::makeRequest($credentials);
            //dd($response, env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'));
            $response['user'] = $user_n;

            event(new Registered($user_n));

            //$user->assignRole($request['role']);

            DB::commit();

            return response()->json( [
                'tokens'    =>  $response,
                'status'    =>  'SUCCESS',
                'message'   =>  'ÉXITO',
                'server_jitsi' => env('JITSI_DOMAIN', 'https://meet.jit.si')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(array('mesage' => $e->getMessage(), 'code' => $e->getCode(), 'state' => false));
        }
    }

    public function registerTeacher(Request $request){
        DB::beginTransaction();
        $interests = Arr::pull($request, 'interests');
        //dd($interests);
        try {

            $user = new User();
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->code = $this->getUserCode();
            $user->password = Hash::make($request['password']);
            $user->thematic_id = $request['thematic_id'] !=0 ? $request['thematic_id'] : null ;
            $user->state = $request['state'];
            $user->save();

            $people = new People();
            $people->profession = $request['profession'];
            $people->user_id = $user->id;
            $people->save();

            $user->interest_users()->sync($request->userInterestSelected);

            // if(isset($interests)){
            //     for ($i = 0; $i < count($interests); $i++){
            //         $interest_user = new InterestUser();
            //         $interest_user->interest_id = $interests[$i]['interest_id'];
            //         $interest_user->user_id = $user->id;
            //         $interest_user->save();
            //     }
            // }

            $user->assignRole('Profesor');

            $paymentAccount = new PaymentAccount();
            $paymentAccount->user_id = $user->id;
            $paymentAccount->save();

            $credentials = AppServiceProvider::buildCredentials([
                'username' => $request['email'],
                'password' => $request['password'],
            ]);

            $user_n = $user->where('email', $request['email'])->with('people', 'roles', 'paymentAccount', 'payment_method_users', 'socialAccounts', 'interest_users')->first();

            //dd($user_n);

            //dd(env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'));

            $response = AppServiceProvider::makeRequest($credentials);

            //dd($response);
            $response['user'] = $user_n;

            event(new Registered($user_n));

            //$user->assignRole($request['role']);

            DB::commit();

            return response()->json([
                'tokens'    =>  $response,
                'status'    =>  'SUCCESS',
                'message'   =>  'ÉXITO',
                'server_jitsi' => env('JITSI_DOMAIN', 'https://meet.jit.si')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(array('mesage' => $e->getMessage(), 'code' => $e->getCode(), 'state' => false));
        }
    }

    public function logout()
    {
        try{
            auth()->user()->tokens->each(function ($token, $key) {
                $token->delete();
            });
            return response()->json('Se ha cerrado la sesion', 200);
        }catch (\Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function getUserCode()
    {
        $code = $this->userCodeGenerator();

        $existUserCode = User::where('code', $code)->first();

        if ($existUserCode != null) {
            $code = $this->userCodeGenerator();
        }

        return $code;
    }

    function userCodeGenerator() {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function sendPasswordResetLink(Request $request)
    {
        return $this->sendResetLinkEmail($request);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json([
            'message' => 'Correo electrónico de restablecimiento de contraseña enviado.',
            'data' => $response
        ]);
    }
    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['message' => 'No se pudo enviar el correo electrónico a esta dirección de correo electrónico.']);
    }
}
