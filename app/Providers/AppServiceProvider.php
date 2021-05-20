<?php

namespace App\Providers;

use App\Services\SocialUserResolver;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        SocialUserResolverInterface::class => SocialUserResolver::class,
    ];
    /**
     * RegisterController any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        Schema::defaultStringLength(191);
    }

    public static function buildCredentials(array $args = [], $grantType = 'password', $provider = null, $access_token = null) {
        $args = collect($args);
        $credentials = $args->except('directive')->toArray();
        $credentials['client_id'] = $args->get('client_id', env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'));
        $credentials['client_secret'] = $args->get('client_secret', env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'));
        $credentials['grant_type'] = $grantType;
        if($access_token) {
            $credentials['access_token'] = $access_token;
        }
        if($provider) {
            $credentials['provider'] = $provider;
        }
        return $credentials;
    }

    public static function makeRequest(array $credentials) {
        $request = Request::create('oauth/token', 'POST', $credentials, [], [], [
            'HTTP_Accept' => 'application/json',
        ]);
        $response = app()->handle($request);
        $decodedResponse = json_decode($response->getContent(), true);

        //dd($decodedResponse);
        if ($response->getStatusCode() != 200) {
            return response()->json( [ 'success' => false, 'message' => 'Usuario o contraseña incorrecta' ] );
            //throw new AuthenticationException(__('Authentication exception'), __('Incorrect username or password'));
        }

        return $decodedResponse;
    }
}