<?php

namespace App\Http\Controllers;

use App\User;
use App\Course;
use App\People;
use App\InterestUser;
use App\PaymentAccount;
use App\PaymentMethodUser;
use App\WithdrawalPolicy;
use Illuminate\Support\Arr;
use App\DocumentAccountUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUserData(){
        $users = DB::table('users')
                    ->select('users.name as user_name','users.photo as user_photo')
                    ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                    ->join('roles','model_has_roles.role_id','=','roles.id')
                    ->where('roles.name','Profesor')
                    ->paginate(6);
        return $users;
    }

    public function getDataUser(){
        $user = User::with('people','interest_users','payment_method_users','document_account_users')
            ->where('id',Auth::id())->first();
        return response()->json($user,200);
    }

    public function getDataUserById($id){
        $user = User::with('people','interest_users','payment_method_users','document_account_users')
            ->where('id',$id)->first();
        return response()->json($user,200);
    }

    public function updatePersonalData(Request $request){
        DB::beginTransaction();
        $interests = Arr::pull($request, 'interest_users');
        try {
            //$user = User::where('id',Auth::id())->with('people', 'roles', 'payment_method_users')->first();
            $user = User::find(Auth::id());
            $user->email = $request->email;

            //Validacion Contraseña
            if ($request->password != null){
                if (Hash::check($request->password,$user->password)){
                    $user->password = Hash::make($request->newpassword);
                }else{
                    DB::rollBack();
                    return response()->json(array([
                        "error" => "20",
                        "mensaje" => "La contraseña actual no coincide"
                    ]), 400);
                }
            }

            $user->name = $request->name;
            $user->photo = $request->photo;
            $user->save();

            $people = People::where('user_id',Auth::id())->first();
            $people->birth_date = $request->people['birth_date'];

            if ($request->people ['country_id'] != null && $request->people ['country_id'] !=0)
                $people->country_id = $request->people ['country_id'];

            $people->profession = $request->people ['profession'];
            $people->phone = $request->people ['phone'];
            $people->grade = $request->people ['grade'];
            $people->deal_id = $request->people['deal_id'];
            $people->description = $request->people['description'];
            $people->save();

            if(isset($interests)){
                $interest_user = InterestUser::where('user_id',$user->id)->delete();

                for ($i = 0; $i < count($interests); $i++){
                    $interest_user = new InterestUser();
                    $interest_user->interest_id = $interests[$i]['id'];
                    $interest_user->user_id = $user->id;
                    $interest_user->save();
                }
            }

            DB::commit();
            //dd($interests);


            $user_update = User::where('id',Auth::id())->with('people', 'roles', 'payment_method_users')->first();
            return response()->json($user_update,201);

        } catch (\Exception $e) {
            DB::rollBack();
            //dd($e->getMessage());
            return response()->json($e->getMessage(), 400);
        }
    }

    public function updateUserapp (Request $request){
        DB::beginTransaction();
        $interests = Arr::pull($request, 'interest_users');
        try {
            //$user = User::where('id',Auth::id())->with('people', 'roles', 'payment_method_users')->first();
            $user = User::find(Auth::id());
            $user->email = $request->email;

            //Validacion Contraseña
            if ($request->password != null){
                if (Hash::check($request->password,$user->password)){
                    $user->password = Hash::make($request->newpassword);
                }else{
                    DB::rollBack();
                    return response()->json(array([
                        "error" => "20",
                        "mensaje" => "La contraseña actual no coincide"
                    ]), 400);
                }
            }

            $user->name = $request->name;
            $user->save();

            $people = People::where('user_id',Auth::id())->first();
            $people->birth_date = $request->people['birth_date'];

            if ($request->people ['country_id'] != null && $request->people ['country_id'] !=0)
                $people->country_id = $request->people ['country_id'];

            $people->profession = $request->people ['profession'];
            $people->phone = $request->people ['phone'];
            $people->save();

            if(isset($interests)){
                $interest_user = InterestUser::where('user_id',$user->id)->delete();

                for ($i = 0; $i < count($interests); $i++){
                    $interest_user = new InterestUser();
                    $interest_user->interest_id = $interests[$i]['id'];
                    $interest_user->user_id = $user->id;
                    $interest_user->save();
                }
            }

            DB::commit();
            //dd($interests);

            $user_update = User::where('id',Auth::id())->with('people', 'roles', 'payment_method_users', 'interest_users')->first();
            return response()->json($user_update,201);

        } catch (\Exception $e) {
            DB::rollBack();
            //dd($e->getMessage());
            return response()->json($e->getMessage(), 400);
        }
    }

    public function updateWithdrawall(Request $request){
        $user = User::with('people', 'roles', 'payment_method_users', 'paymentAccount')->find($request->id);
        //dd($request->enable_withdrawal);
        $user->enable_withdrawal = $request->enable_withdrawal;
        $user->save();

        return response()->json($user, 200);
    }

    public function updateInstructor(Request $request){

        DB::beginTransaction();
        $documents = Arr::pull($request, 'documents');
        //$payment_methods = Arr::pull($request, 'payment_method_users');
        //dd($request->people ['grade_instruction']);

        try {

            $user = User::find(Auth::id());
            $user->thematic_id = $request->thematic_id;
            $user->save();

            $people = People::where('user_id',Auth::id())->first();
            $people->grade_instruction = $request->people ['grade_instruction'];

            if($request->people ['institution_type_id'] !=null  &&  $request->people ['institution_type_id'] !=0)
                $people->institution_type_id = $request->people ['institution_type_id'];

            $people->name_institution = $request->people ['name_institution'];

            if($request->people ['document_type_id'] !=null && $request->people ['institution_type_id'] !=0)
                $people->document_type_id = $request->people ['document_type_id'];

            $people->document_number = $request->people ['document_number'];
            $people->user_update = Auth::id();
            $people->fb_link = $request->people['fb_link'];
            $people->tw_link = $request->people['tw_link'];
            $people->ln_link = $request->people['ln_link'];
            $people->ig_link = $request->people['ig_link'];
            $people->save();

            /*if(isset($payment_methods)){
                for ($i = 0; $i < count($payment_methods); $i++){
                    $payment_method_user = PaymentMethodUser::find($payment_methods[$i]['id']);

                    if ($payment_method_user ==null)
                        $payment_method_user = new PaymentMethodUser();

                    $payment_method_user->value = $payment_methods[$i]['value'];
                    $payment_method_user->user_id = Auth::id();
                    $payment_method_user->payment_method_id = $payment_methods[$i]['payment_method_id'];
                    $payment_method_user->state=1;
                    $payment_method_user->save();
                }
            }*/

            if(isset($documents)){
                for ($i = 0; $i < count($documents); $i++){
                    $document_account_user = DocumentAccountUser::find($documents[$i]['id']);

                    if ($document_account_user ==null)
                        $document_account_user = new DocumentAccountUser();

                    $document_account_user->document_account_id = $documents[$i]['document_account_id'];
                    $document_account_user->user_id = Auth::id();
                    $document_account_user->url_document = $documents[$i]['url_document'];
                    $document_account_user->save();
                }
            }

            DB::commit();
            $user = User::where('id',Auth::id())->with('people', 'roles', 'payment_method_users', 'paymentAccount')->first();

            return response()->json($user,201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 400);
        }
    }

    public function updatePaymentAccount(Request $request){
        try {
            DB::beginTransaction();

            $Payment_account = PaymentAccount::where('user_id', Auth::id())->first();
            $Payment_account->bank = $request->bank;
            $Payment_account->clabe = $request->clabe;
            $Payment_account->number_account = $request->number_account;
            $Payment_account->holder_name = $request->holder_name;
            $Payment_account->holder_last_name = $request->holder_last_name;
            $Payment_account->save();

            DB::commit();

            return response()->json($Payment_account, 201);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json($e->getTrace(), 400);
        }
    }

    public function getLastThreePaymentMethods(Request $request)
    {
        $methods = PaymentMethodUser::with('payment_method:id,image,type')->whereHas('payment_method', function ($q) {
            $q->where('type', '!=', 1);
        })->where('user_id', $request->user)->orderBy('id', 'DESC')
                                    ->take(3)
                                    ->get(['name','payment_method_id','value']);

        return response()->json($methods);
    }

    public function getPaypalAccount(Request $request)
    {
        $account = PaymentMethodUser::where("user_id", $request->user)->where('payment_method_id', 1)->select('value')->first();

        return response()->json($account);
    }

    public function storePaypalAccount(Request $request)
    {
        $account = PaymentMethodUser::where("user_id", $request->user)->where('payment_method_id', 1)->first();

        if ($account == null) {
            $account = new PaymentMethodUser;
            $account->user_id = $request->user;
            $account->payment_method_id = 1;
            $account->name = 'Paypal';
            $account->state = 1;
        }
        $account->value = $request->account;
        $account->save();

        return response()->json(true);
    }

    public function getInformation(Request $request)
    {
        $user = User::with('people', 'people.deal')->find($request->id);
        $countCourses = User::join('courses', 'users.id', 'courses.user_id')
                            ->join('course_user', 'courses.id', 'course_user.course_id')
                            ->where('users.id', $request->id)
                            ->count('course_user.course_id');

        $countClasses = User::join('classes', 'users.id', 'classes.user_id')
                            ->join('class_user', 'classes.id', 'class_user.class_id')
                            ->where('users.id', $request->id)
                            ->whereNull('classes.course_id')
                            ->count('class_user.class_id');

        $countMeetings = User::join('meetings', 'users.id', 'meetings.user_id')
                            ->join('meeting_user', 'meetings.id', 'meeting_user.meeting_id')
                            ->where('users.id', $request->id)
                            ->count('meeting_user.meeting_id');


        $totalStudents = (int) $countCourses + (int) $countClasses + (int) $countMeetings;

        return response()->json(array('user' => $user, 'totalStudents' => $totalStudents));
    }

    public function getUserInformationCourse(Request $request)
    {
        $courses = Course::with('user:id,name')->where('user_id', $request->id)->orderBy('id', 'asc')->paginate(6);

        return  [
            'pagination' => [
                'total'         => $courses->total(),
                'current_page'  => $courses->currentPage(),
                'per_page'      => $courses->perPage(),
                'last_page'     => $courses->lastPage(),
                'from'          => $courses->firstItem(),
                'to'            => $courses->lastItem(),
            ],
            'courses' => $courses
        ];
    }

    public function getUserInterest(Request $request)
    {
        $getInterest = auth()->user()->interest_users()->get();

        return response()->json($getInterest);
    }

    public function getWithdrawalPolicies(Request $request){
        $policies = WithdrawalPolicy::all()->last();

        return response()->json($policies);
    }
}
