<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\MailResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'averageRating',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function people(){
        return $this->hasOne('App\People');
    }

    public function interest_users(){
        return $this->belongsToMany('App\Interest','interest_users','user_id','interest_id');
    }


    public function payment_method_users(){
        return $this->hasMany('App\PaymentMethodUser');
    }

    public function document_account_users(){
        return $this->hasMany('App\DocumentAccountUser');
    }

    public function social_network_users(){
        return $this->hasMany('App\SocialNetworkUser');
    }

    public function courses(){
        return $this->hasMany('App\Course');
    }

    public function sessions()
    {
        return $this->hasMany('App\Meetings');
    }

    public function ccclasses()
    {
        return $this->hasMany('App\Cclass');
    }

    public function course_classes(){
        return $this->hasMany('App\Classes');
    }

    public function withdrawalRequest()
    {
        return $this->hasMany('App\WithdrawalRequest');
    }

    public function paymentAccount()
    {
        return $this->hasOne(PaymentAccount::class);
    }

    public function plans()
    {
        return $this->belongsToMany('App\Plan');
    }

    public function  plans_user(){
        return $this->hasMany(PlanUser::class);
    }
    public function cursos()
    {
        return $this->belongsToMany('App\Course','course_user')->with(['user' => function($query){
            $query->select('id', 'name', 'photo');
        }, 'user.people' => function($query){
            $query->select('id', 'user_id', 'profession');
        }]);
    }

    public function clases()
    {
        return $this->belongsToMany('App\Cclass','class_user','user_id','class_id')
            ->with(['instructor' => function($query){
                $query->select('id', 'name', 'photo');
            }, 'instructor.people' => function($query){
                $query->select('id', 'user_id', 'profession');
            }]);
    }

    public function meetings()
    {
        return $this->belongsToMany('App\Meeting', 'meeting_user', 'user_id','meeting_id');
    }

    public function rating()
    {
        return $this->hasMany('App\UserRating');
    }

    function getAverageRatingAttribute(){
        return round($this->rating()->avg('rating'),1);
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'instructor_id', 'id');
    }

    public function socialAccounts()
    {
        return $this->hasMany('App\SocialAccount');
    }

    public function periods()
    {
        return $this->hasMany('App\PeriodUser');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }
    public function isOnline()
    {
        return Cache::has('online' . $this->id);
    }
}
