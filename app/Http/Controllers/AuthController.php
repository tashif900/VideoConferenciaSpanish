<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\People;
use App\PeriodUser;
use App\SocialAccount;
use App\PaymentAccount;
use App\PaymentMethodUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Providers\AppServiceProvider;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function handleProviderCallback(Request $request)
    {
        $providerUser = null;

        //dd ($request->all());
        try {
            $providerUser = Socialite::driver($request->post('provider'))->userFromToken($request->post('access_token'));
        } catch (Exception $exception) {

        }

        $response = null;
        if ($providerUser) {
            $linkedSocialAccount = SocialAccount::with('user', 'user.people','user.roles', 'user.paymentAccount', 'user.payment_method_users')->where([
                ['provider', $request['provider']],
                ['provider_user_id', $providerUser->getId()]
            ])->first();


            if($linkedSocialAccount) {
                /*
                $credentials = AppServiceProvider::buildCredentials([],
                    $request->post('grant_type'),
                    $request->post('provider'),
                    $request->post('access_token')
                );*/

                $user_n = $linkedSocialAccount->user;
                //dd($user_n);
                // $response = AppServiceProvider::makeRequest($credentials);
                $token = $user_n->createToken('access_token')->accessToken;

                $response['access_token'] = $token;
                $response['user'] = $user_n;

            } else {
                if ($providerUser->email != null)
                    $appUser = User::where('email', $providerUser->email)->with('people', 'roles', 'paymentAccount', 'payment_method_users')->first();
                else
                    $appUser=null;

                if($appUser == null) {
                    if ($request->has('type')) {
                        if ($request->type == 3) {
                            return response()->json(['status' => 'REGISTER']);
                        }
                    }

                    $appUser = new User;
                    $appUser->name  = $providerUser->name;
                    $appUser->email = $providerUser->email;
                    $appUser->password = Str::random(7);
                    $appUser->code = $this->getUserCode();
                    $appUser->state = 1;
                    $appUser->social_network=1;

                    $appUser->save();

                    $people = new People();
                    $people->user_id = $appUser->id;
                    $appUser->people()->save($people);

                    $paymentAccount = new PaymentAccount;
                    $appUser->paymentAccount()->save($paymentAccount);


                    if ($request->has('type')) {
                        if ($request->type == 1) {
                            $appUser->assignRole('Alumno');
                        } else if($request->type == 2) {
                            $appUser->assignRole('Profesor');
                        }
                    }
                }

                $user_n = User::with('people', 'roles', 'paymentAccount', 'payment_method_users', 'socialAccounts')->find($appUser->id);

                $token = $user_n->createToken('access_token')->accessToken;

                $response['access_token'] = $token;
                $response['user'] = $user_n;

                $socialAccount = $appUser->socialAccounts()->where('provider', $request->post('provider'))->first();

                if (! $socialAccount) {
                    $socialAccount = new SocialAccount;
                    $socialAccount->user_id = $appUser->id;
                    $socialAccount->provider_user_id = $providerUser->id;
                    $socialAccount->provider = $request->post('provider');
                    $socialAccount->save();
                }

                event(new Registered($user_n));
            }
        }

        DB::commit();

        return response()->json( [
            'tokens'    =>  $response,
            'status'    =>  'SUCCESS',
            'message'   =>  'ÉXITO'
        ]);

    }

    public function loginRedes(Request $request){
        try {
            $providerUser = null;
            $providerUser = Socialite::driver($request->post('provider'))->userFromToken($request->post('access_token'));

            $response = null;

            if ($providerUser) {
                $linkedSocialAccount = SocialAccount::with('user', 'user.people','user.roles', 'user.paymentAccount', 'user.payment_method_users', 'user.interest_users')->where([
                    ['provider', $request['provider']],
                    ['provider_user_id', $providerUser->getId()]
                ])->first();

                if($linkedSocialAccount) {
                    $credentials = AppServiceProvider::buildCredentials([],
                        $request->post('grant_type'),
                        $request->post('provider'),
                        $request->post('access_token')
                    );

                    $user_n = $linkedSocialAccount->user;

                    // $response = AppServiceProvider::makeRequest($credentials);
                    $token = $user_n->createToken('access_token')->accessToken;

                    $response['access_token'] = $token;
                    $response['user'] = $user_n;

                } else {
                    if ($providerUser->email != null)
                        $appUser = User::where('email', $providerUser->email)->with('people', 'roles', 'paymentAccount', 'payment_method_users')->first();
                    else
                        $appUser=null;

                    if($appUser == null) {
                        if ($request->has('type')) {
                            if ($request->type == 3) {
                                return response()->json(['status' => 'REGISTER']);
                            }
                        }

                        $appUser = new User;
                        $appUser->name  = $providerUser->name;
                        $appUser->email = $providerUser->email;
                        $appUser->password = Str::random(7);
                        $appUser->code = $this->getUserCode();
                        $appUser->state = 1;
                        $appUser->social_network=1;

                        $appUser->save();

                        $people = new People();
                        $people->user_id = $appUser->id;
                        $appUser->people()->save($people);

                        $paymentAccount = new PaymentAccount;
                        $appUser->paymentAccount()->save($paymentAccount);


                        if ($request->has('type')) {
                            if ($request->type == 1) {
                                $appUser->assignRole('Alumno');
                            } else if($request->type == 2) {
                                $appUser->assignRole('Profesor');
                            }
                        }
                    }

                    $credentials = AppServiceProvider::buildCredentials([],
                        $request->post('grant_type'),
                        $request->post('provider'),
                        $request->post('access_token')
                    );

                    $user_n = User::with('people', 'roles', 'paymentAccount', 'payment_method_users', 'socialAccounts','interest_users')->find($appUser->id);

                    $token = $user_n->createToken('access_token')->accessToken;

                    // $response = AppServiceProvider::makeRequest($credentials);
                    $response['access_token'] = $token;
                    $response['user'] = $user_n;

                    $socialAccount = $appUser->socialAccounts()->where('provider', $request->post('provider'))->first();

                    if (! $socialAccount) {
                        $socialAccount = new SocialAccount;
                        $socialAccount->user_id = $appUser->id;
                        $socialAccount->provider_user_id = $providerUser->id;
                        $socialAccount->provider = $request->post('provider');
                        $socialAccount->save();
                    }

                    event(new Registered($user_n));
                }
            }

            return response()->json( [
                'tokens'    =>  $response,
                'status'    =>  'SUCCESS',
                'message'   =>  'ÉXITO'
            ]);
        }catch (Exception $e){
            return response()->json( [
                'tokens'    =>  null,
                'status'    =>  'ERROR',
                'message'   =>  $e->getMessage()
            ]);
        }
    }

    public function loginFacebookApp(Request $request){

        $token = null;
        try {
            $user = User::where('email', $request->email)->with('people', 'roles', 'paymentAccount', 'payment_method_users','interest_users')
                ->first();

            if ($user != null){
                $token = $user->createToken('access_token')->accessToken;
                $status  = "SUCCESS";
                $message = "EXITO";
            }else{
                $status = "REGISTER";
                $message ="Usuario no registrado";
            }
            $response['access_token'] = $token;
            $response['user'] = $user;

            return response()->json( [
                'tokens'    =>  $response,
                'status'    =>  $status,
                'message'   =>  $message,
                'server_jitsi' => env('JITSI_DOMAIN', 'https://meet.jit.si')
            ]);
        }catch (Exception $e){
            return response()->json( [
                'tokens'    =>  null,
                'status'    =>  "ERROR",
                'message'   =>  $e->getMessage()
            ]);
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
}
