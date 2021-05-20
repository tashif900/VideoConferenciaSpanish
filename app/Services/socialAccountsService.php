<?php
namespace App\Services;
use App\User;
use App\SocialAccount;
use Laravel\Socialite\Two\User as ProviderUser;
class socialAccountsService
{
    /**
     * Find or create user instance by provider user instance and provider name.
     *
     * @param ProviderUser $providerUser
     * @param string $provider
     *
     * @return User
     */
    public function findOrCreate(ProviderUser $providerUser, string $provider): User
    {
        $linkedSocialAccount = \App\SocialAccount::where('provider', $provider)
            ->where('provider_user_id', $providerUser->getId())
            ->first();
        if ($linkedSocialAccount) {
            return $linkedSocialAccount->user;
        } else {
            $user = null;
            if ($email = $providerUser->getEmail()) {
                $user = User::where('email', $email)->with('people', 'roles', 'paymentAccount', 'payment_method_users')->first();
            }
            if (! $user) {
                $appUser = User::create([
                    'name' => $providerUser->getName(),
                    'email' => $providerUser->getEmail(),
                ]);

                $people = new People();
                $people->user_id = $appUser->id;
                $people->save();

                $appUser->with('people', 'roles', 'paymentAccount', 'payment_method_users')->first();
            }
            $appUser->socialAccounts()->create([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $provider,
            ]);
            return $appUser;
        }
    }
}
