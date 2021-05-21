<?php

use App\InstructorMovement;
use App\Thematic;
use App\User;
use App\WithdrawalPolicy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/', function () {
    $page = "Documentacion de AppZurviz";
    return $page;
});
Route::group(['middleware' => ['auth:api']], function(){
    Route::post('updatePersonalData', 'UserController@updatePersonalData');
    Route::post ('updateWithdrawall', 'UserController@updateWithdrawall');
    Route::post('updateInstructor', 'UserController@updateInstructor');
    Route::post('updatePaymentAccount', 'UserController@updatePaymentAccount');
    Route::post('updateUserApp', 'UserController@updateUserapp');

    Route::get('getDataUser', 'UserController@getDataUser');
    Route::get('getPolicies', 'UserController@getWithdrawalPolicies');
    Route::get('getDataUserById/{id}', 'UserController@getDataUserById');


    Route::post('saveCourse', 'CourseController@saveCourse');

    Route::post('updateCourse', 'CourseController@updateCourse');
    Route::get('getCourse', 'CourseController@getCourse');
    Route::get('getCourseById/{id}', 'CourseController@getCourseById');
    Route::get('getCourseByUser', 'CourseController@getCourseByUser');
    Route::post('saveCourseClass', 'CourseClassController@saveCourseClass');
    Route::post('updateCourseClass', 'CourseClassController@updateCourseClass');
    Route::get('getCourseClass', 'CourseClassController@getCourseClass');
    Route::get('getCourseClassById/{id}', 'CourseClassController@getCourseClassById');
    Route::get('getCourseClassByUser', 'CourseClassController@getCourseClassByUser');
    Route::post('saveMeeting', 'MeetingController@saveMeeting');
    Route::post('updateMeeting', 'MeetingController@updateMeeting');
    Route::get('getMeeting', 'MeetingController@getMeeting');
    Route::get('getMeetingById/{id}', 'MeetingController@getMeetingById');
    Route::get('getMeetingByUser', 'MeetingController@getMeetingByUser');
    Route::get('joinMeeting', 'MeetingController@joinMeeting');
    Route::post('logout', 'RegisterController@logout');

    Route::get('getHelpDeksUser', 'Helpdesk@getHelpDeksUser');
    Route::get('editHelpDesk', 'Helpdesk@editHelpDesk');
    Route::post('saveHelpDesk', 'Helpdesk@saveHelpDesk');

    Route::post('get-last-payment-methods','UserController@getLastThreePaymentMethods');
    Route::post('get-paypal-payment-method','UserController@getPaypalAccount');
    Route::post('get-paypal-payment-method-store','UserController@storePaypalAccount');

    Route::post('/store-class', 'CclassController@saveClass');
    Route::post('/update-class', 'CclassController@UpdateClass');
    Route::post('/update-course', 'CourseController@updateCourse');

    Route::post('/get-plan-information','PlansController@getPlanInformation');

    Route::post('/get-movements', 'PaymentController@getMovements');

    Route::post('/get-my-courses', 'CourseController@myCourses');
    Route::post('/get-my-classes', 'CclassController@getMyClasses');

    Route::post('/search-meeting-secure','MeetingController@searchMeetingSecure');

    Route::post('/get-todays-meeting','DateController@getTodaysMeetings');
    Route::post('/get-upcoming-meeting','DateController@getUpcomingMeetings');
    Route::post('/get-pasts-meeting','DateController@getPastsMeetings');

    Route::post('/get-calendar-meeting', 'DateController@calendarMeetings');

    Route::post('/get-class-single', 'CclassController@single');
    Route::post('/get-course-single', 'CourseController@single');
    Route::post('/get-comments', 'CommentsController@getComments');
    Route::post('/store-comments', 'CommentsController@store');
    Route::post('/store-rating', 'RatingController@store');

    Route::post('/store-resources', 'ResourcesController@store');
    Route::post('/get-resources', 'ResourcesController@getResources');

    Route::post('/get-to-publish','AdController@getData');
    Route::post('/store-advertisement', 'AdController@store');
    Route::post('/updateDate-avertisement', 'AdController@updateDate');
    Route::post('/get-my-ads', 'AdController@getMyAds');

    Route::post('/get-user-interest', 'UserController@getUserInterest');
    Route::post('/get-class-information-l', 'CclassController@getInformation');

    Route::post('/get-course-information-l', 'CourseController@getInformation');
    
    Route::post('/prepare-class', 'CclassController@prepare');
    Route::post('/prepare-course', 'CourseController@prepare');

    Route::post('/get-user-periods', 'RetreatsController@getUserPeriods');
    Route::post('/can-withdraw', 'RetreatsController@canWithdraw');
    Route::post('/get-withdraw-requests', 'RetreatsController@getResquest');
    Route::post('/get-activity-instructor', 'RetreatsController@getActivity');
    Route::post('/get-request-period', 'RetreatsController@getRequestPeriod');
    Route::post('/store-payment-request', 'RetreatsController@store');
    Route::post('/get-last-request', 'RetreatsController@getLastRequest');

    Route::post('/upload-doc-user-instructor', 'DocumentsController@uploadInstructorDocuments');
    Route::post('/get-user-documents', 'DocumentsController@getUserDocuments');

    Route::post('/get-meeting-single', 'MeetingController@getMeetingSingle');
    Route::post('/get-vigencies', 'AdController@getVigencies');
    Route::post('/get-advertisement', 'AdController@getAdvertisement');
    Route::post('/get-current-income', 'RetreatsController@getCurrentIncome');

    // Chat
    Route::post('/message/start-conversation', 'MessageController@startConversation');
    Route::post('/message/list-chat', 'MessageController@listChats');
    Route::post('/message/list-chat-message', 'MessageController@listMessages');
    Route::post('/message/new-message', 'MessageController@newMessage');

    Route::post('/store-course-class', 'CclassController@saveCourseClass');
    Route::post('/update-course-class', 'CclassController@updateCourseClass');

    Route::post('/payment-card-process', 'CardPaymentController@process');

    Route::post('finish-session', 'MeetingController@finish');

    Route::post('checkSubscribeSession', 'MeetingController@checkSubscribeSession');

    Route::get('checkPlanUser', 'PlansController@isPlanVigente');
    Route::post('/upload-avatar', 'FileController@uploadAvatar');

});

Route::get('get-user-data','UserController@getUserData');
Route::get('get-courses-data','CourseController@getCourseData');
Route::get('filter-by-category','CourseController@filterByCategory');
Route::get('filter-by-subtopic','CourseController@filterBySubtopic');

Route::post('/store-course', 'CourseController@saveCourse');
Route::get('get-deals', 'DealsController@getDeals');
Route::get('getThematics', 'UtilsController@getThematics');
Route::get('getCountries', 'UtilsController@getCountries');
Route::get('getTypeDocuments', 'UtilsController@getTypeDocuments');
Route::get('getInstitutionTypes', 'UtilsController@getInstitutionTypes');

Route::post('login', 'RegisterController@login');
Route::post('registerTeacher', 'RegisterController@registerTeacher');
Route::post('registerStudent', 'RegisterController@registerStudent');

Route::post('welcome', 'WelcomeController@index');

//Route::post('/store-class', 'CourseController@saveCourse');

Route::get('/get-thematics', 'ThematicController@getThematic');
Route::get('/get-sub-thematics', 'ThematicController@getSubThematic');
Route::post('/get-course/{user}', 'CourseController@getCourseUser');
Route::post('/get-documents-types','DocumentsController@getDocumentType');
Route::post('/store/files', 'FileController@store');
Route::post('/store-date', 'DateController@store');
Route::post('/store-meeting', 'DateController@storeMeeting');
Route::post('/store-meeting-sessions', 'DateController@storeMeetingSession');
Route::get('/get-interests', 'InterstController@getInterests');

Route::post('/report-user-store', 'ReportUserController@store');
Route::post('/search-meeting','MeetingController@searchMeeting');
Route::post('/search-user','ReportUserController@searchUser');
Route::post('/search', 'SearchController@search');

Route::post('/get-page/{page}', 'PageController@getPage');

Route::post('/get-plans','PlansController@getPlans');

Route::post('/get-class-information', 'CclassController@getInformation');
Route::post('/get-course-information', 'CourseController@getInformation');
Route::post('/get-user-information', 'UserController@getInformation');
Route::post('/get-user-course-information', 'UserController@getUserInformationCourse');
Route::post('/get-meeting-information', 'MeetingController@getInformation');
Route::post('/get-user-comments', 'CommentsController@getCommentsByInstructor');

Route::post('/get-site-social-footer', 'SiteController@getSocialSite');
Route::post('/get-faqs', 'SiteController@getFaqs');

Route::get("/get-type-user-documents", 'DocumentsController@getTypeUserDocuments');
Route::post('/get-ad-information', 'AdController@getVigencyInformation');


Route::post('/get-slider-item', 'SlideController@getItems');
Route::post('/course-class-featured', 'WelcomeController@getClassCourseFeaturedAll');
Route::post('/course-class-featured-category', 'WelcomeController@getClassCourseFeaturedCategory');
Route::post('/course-class-featured-subcategory', 'WelcomeController@getClassCourseFeaturedSubCategory');

Route::post('/getClassCourseAll', 'WelcomeController@getClassCourseAll');
Route::post('/getClassCourseCategory', 'WelcomeController@getClassCourseCategory');
Route::post('/getClassCourseSubCategory', 'WelcomeController@getClassCourseSubCategory');
Route::post('/getInstructorsFeatured', 'WelcomeController@getInstructorsFeatured');
Route::post('/getInstructorsFeaturedCategory', 'WelcomeController@getInstructorsFeaturedCategory');
Route::post('/getInstructorsAll', 'WelcomeController@getInstructorsAll');

Route::post('reset-password', 'RegisterController@sendPasswordResetLink');
Route::post('reset/password', 'ResetPassworFrontController@callResetPassword');

/*Route::get('test-user', function () {

    $user = User::with('plans_user.plan')->find(3);
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
});*/
Route::post('sociallogin', 'AuthController@loginRedes');
Route::post('loginfacebook', 'AuthController@loginFacebookApp');


Route::get('test-date', function (){
    //$dia_actual = ucfirst (Carbon::now()->dayName);
    //$hora = Carbon::now()->format('h:m');

    $policie = WithdrawalPolicy::all()->last();
    $dia_policie = $policie->start_day;
    $dia_actual = ucfirst (Carbon::now()->dayName);
    $valor = $dia_policie == $dia_actual;

    $result = array('dia actual' => $dia_actual, 'respuesta' => $valor);
    return $result;
    /*
    $users = User::role('Profesor')->where('state', 1)->where('enable_withdrawal',1)->get();
    $policie = WithdrawalPolicy::all()->last();
    //dd($users);
    foreach ($users as $user){
            $movements = InstructorMovement::where('user_id', $user->id)->where('state', 1)->get();
            $amount_week =0.00;
            //dd($movements);
            foreach ($movements as $movement){
                $amount = (float) $movement->amount * (float) $movement->platform_percentage;
                $amount_week = $amount_week + $amount;
            }
            //dd($amount_week);
            if ($amount_week >= $policie->amount_max){
                $withdrawal_requests = new  \App\WithdrawalRequest();

                $amount_week =0.00;
                foreach ($movements as $movement){
                    $amount = (float) $movement->amount * (float) $movement->platform_percentage;
                    $amount_week = $amount_week + $amount;
                    $mov = InstructorMovement::find($movement->id);
                    $mov->state =3; //Pendiente
                    $mov->save();
                }

                $withdrawal_requests->request_date = Carbon::now();
                $withdrawal_requests->user_id = $user->id;
                $withdrawal_requests->amount = $amount_week;
                $withdrawal_requests->comment = "Solicitud de pago generada automáticamente";
                $withdrawal_requests->state = 1;
                $withdrawal_requests->save();
            }
    }*/

    //dd($users);
});