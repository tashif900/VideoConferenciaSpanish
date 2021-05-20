<?php

use App\Jobs\SendMessageJob;
use App\Message;
use App\Plan;
use App\User;
use App\Cclass;
use App\PricesAdvertisements;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Mail\ConfirmationPurchaseMail;
use App\Notifications\AdminNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\NotificationsController;


Route::get('/home', function () {
    return redirect('/');
})->name('home');

Route::get('/politicas', function () {
    return view('policies');
});

Auth::routes(['register' => false]);

Route::middleware(['auth','admin.validate'])->prefix('admin')->group(function () {
    //Index
    Route::get('/', 'AdminController@index');
    // Profile
    Route::get('/profile', 'AdminController@profile');

    // User actions
    Route::get('users/',  'AdminController@users')->name('users');
    Route::get('dtusers/', 'AdminController@dtusers')->name('dtusers');
    Route::post('saveuser', 'AdminController@saveuser')->name('saveuser');
    Route::get('deleteuser/{id}', 'AdminController@deleteuser')->name('deleteuser');

    // Country actions
    Route::get('countries/',  'AdminController@countries')->name('countries');
    Route::get('dtcountries/', 'AdminController@dtcountries')->name('dtcountries');
    Route::post('savecountry', 'AdminController@savecountry')->name('savecountry');
    Route::get('deletecountry/{id}', 'AdminController@deletecountry')->name('deletecountry');

    // Payment gateway
    Route::get('paymentgateway/',  'AdminController@paymentgateway')->name('paymentgateway');
    Route::get('dtpaymentgateway/', 'AdminController@dtpaymentgateway')->name('dtpaymentgateway');
    Route::post('savepaymentgateway', 'AdminController@savepaymentgateway')->name('savepaymentgateway');
    Route::get('deletepaymentgateway/{id}', 'AdminController@deletepaymentgateway')->name('deletepaymentgateway');

    // withdrawal_policies
    Route::get('withdrawalpolicies/',  'AdminController@withdrawalpolicies')->name('withdrawalpolicies');
    Route::get('dtwithdrawalpolicies/', 'AdminController@dtwithdrawalpolicies')->name('dtwithdrawalpolicies');
    Route::post('savewithdrawalpolicies', 'AdminController@savewithdrawalpolicies')->name('savewithdrawalpolicies');
    Route::get('deletewithdrawalpolicies/{id}', 'AdminController@deletewithdrawalpolicies')->name('deletewithdrawalpolicies');

    // Courses
    Route::get('courses/', 'AdminController@courses')->name('courses');
    Route::get ('dtcourses/', 'AdminController@dtcourses')->name('dtcourses');
    Route::post('savecourse/', 'AdminController@savecourse')->name('savecourse');
    Route::get('deletecourse/{id}', 'AdminController@deletecourse')->name('deletecourse');
    Route::get('viewcourse/{id}','AdminController@viewcourse')->name('viewcourse');

    // Save Course Class
    Route::post('savecourseclass/', 'AdminController@savecourseclass')->name('savecourseclass');
    Route::get('deletecourseclass/', 'AdminController@deletecourseclass')->name('deletecourseclass');
    Route::get('dtcourseclass/{id}', 'AdminController@dtcourseclass')->name('dtcourseclass');

    // Meetings
    Route::get ('meetings/',  'AdminController@meetings')->name('meetings');
    Route::get ('dtmeetings/', 'AdminController@dtmeetings')->name('dtmeetings');
    Route::post('savemeeting', 'AdminController@savemeeting')->name('savemeeting');
    Route::get ('deletemeeting/{id}', 'AdminController@deletemeeting')->name('deletemeeting');

    // Reports
    Route::get ('incomeinstructor/',  'AdminController@incomeinstructor')->name('incomeinstructor');
    Route::get ('incomemeeting/',  'AdminController@incomemeeting')->name('incomemeeting');
    Route::get ('incomecourse/',  'AdminController@incomecourse')->name('incomecourse');
    Route::get ('incomeclass/',  'AdminController@incomeclass')->name('incomeclass');

    Route::get ('paymentinstructor/',  'AdminController@paymentinstructor')->name('paymentinstructor');
    Route::get ('paymentperiod/',  'AdminController@paymentperiod')->name('paymentperiod');

    //Documentos
    Route::get('documents', 'AdminController@documents')->name('documents');
    Route::get('dtDocuments', 'AdminController@dtDocuments')->name('dtDocuments');
    Route::get('getDocuments', 'AdminController@getDocuments')->name('getDocuments');
    Route::post('saveDocuments', 'AdminController@saveDocuments')->name('saveDocuments');
    Route::post('deleteDocuments', 'AdminController@deleteDocuments')->name('deleteDocuments');
    //Instituciones

    Route::get('institutions', 'AdminController@institutions')->name('institutions');
    Route::get('dtInstitutions', 'AdminController@dtInstitutions')->name('dtInstitutions');
    Route::get('getInstitutions', 'AdminController@getInstitutions')->name('getInstitutions');
    Route::post('saveInstitutions', 'AdminController@saveInstitutions')->name('saveInstitutions');
    Route::post('deleteInstitutions', 'AdminController@deleteInstitutions')->name('deleteInstitutions');
    //Intereses

    Route::get('interests', 'AdminController@interests')->name('interests');
    Route::get('dtInterests', 'AdminController@dtInterests')->name('dtInterests');
    Route::get('getInterests', 'AdminController@getInterests')->name('getInterests');
    Route::post('saveInterests', 'AdminController@saveInterests')->name('saveInterests');
    Route::post('deleteInterests', 'AdminController@deleteInterests')->name('deleteInterests');
    //Metodos de Pago

    Route::get('payment_methods', 'AdminController@payment_methods')->name('payment_methods');
    Route::get('dtPaymentMethods', 'AdminController@dtPaymentMethods')->name('dtPaymentMethods');
    Route::get('getPaymentMethods', 'AdminController@getPaymentMethods')->name('getPaymentMethods');
    Route::post('savePaymentMethods', 'AdminController@savePaymentMethods')->name('savePaymentMethods');
    Route::post('deletePaymentMethods', 'AdminController@deletePaymentMethods')->name('deletePaymentMethods');

    //Redes Sociales
    Route::get('social_networks', 'AdminController@social_networks')->name('social_networks');
    Route::get('dtSocialNetworks', 'AdminController@dtSocialNetworks')->name('dtSocialNetworks');
    Route::get('getSocialNetworks', 'AdminController@getSocialNetworks')->name('getSocialNetworks');
    Route::post('saveSocialNetworks', 'AdminController@saveSocialNetworks')->name('saveSocialNetworks');
    Route::post('deleteSocialNetworks', 'AdminController@deleteSocialNetworks')->name('deleteSocialNetworks');

    //Temas
    Route::get('themes', 'AdminController@themes')->name('themes');
    Route::get('dtThemes', 'AdminController@dtThemes')->name('dtThemes');
    Route::get('getThemes', 'AdminController@getThemes')->name('getThemes');
    Route::post('saveThemes', 'AdminController@saveThemes')->name('saveThemes');
    Route::post('deleteThemes', 'AdminController@deleteThemes')->name('deleteThemes');

    //Subtemas
    Route::get('subtopics', 'AdminController@subtopics')->name('subtopics');
    Route::get('dtSubtopics', 'AdminController@dtSubtopics')->name('dtSubtopics');
    Route::get('getSubtopics', 'AdminController@getSubtopics')->name('getSubtopics');
    Route::post('saveSubtopics', 'AdminController@saveSubtopics')->name('saveSubtopics');
    Route::post('deleteSubtopics', 'AdminController@deleteSubtopics')->name('deleteSubtopics');

    //Subtemas
    Route::get('plans', 'AdminController@plans')->name('plans');
    Route::get('dtPlans', 'AdminController@dtPlans')->name('dtPlans');
    Route::get('getPlans', 'AdminController@getPlans')->name('getPlans');
    Route::post('savePlans', 'AdminController@savePlans')->name('savePlans');
    Route::post('deletePlans', 'AdminController@deletePlans')->name('deletePlans');

    //Clases
    Route::get('cclasses', 'AdminController@cclasses')->name('cclasses');
    Route::get('dtCclasses', 'AdminController@dtCclasses')->name('dtCclasses');
    Route::get('getCclasses', 'AdminController@getCclasses')->name('getCclasses');
    Route::post('saveCclasses', 'AdminController@saveCclasses')->name('saveCclasses');
    Route::post('deleteCclasses', 'AdminController@deleteCclasses')->name('deleteCclasses');

    //Solicitudes
    Route::get('withdrawal_requests', 'AdminController@withdrawal_requests')->name('withdrawal_requests');
    Route::get('dtWithdrawalRequests', 'AdminController@dtWithdrawalRequests')->name('dtWithdrawalRequests');
    Route::get('getWithdrawalRequests', 'AdminController@getWithdrawalRequests')->name('getWithdrawalRequests');
    Route::post('saveWithdrawalRequests', 'AdminController@saveWithdrawalRequests')->name('saveWithdrawalRequests');

    // Frecency Questions
    Route::get('questions', 'AdminController@questions')->name('questions');
    Route::get('dtQuestions', 'AdminController@dtQuestions')->name('dtQuestions');
    Route::post('saveQuestion', 'AdminController@saveQuestion')->name('saveQuestion');
    Route::get('deleteQuestion/{id}', 'AdminController@deleteQuestion')->name('deleteQuestion');

    // Category Information
    Route::get('categoryinformation', 'AdminController@categoryinformation')->name('categoryinformation');
    Route::get('dtCategoryInformation', 'AdminController@dtCategoryInformation')->name('dtCategoryInformation');
    Route::post('saveCategoryInformation', 'AdminController@saveCategoryInformation')->name('saveCategoryInformation');
    Route::get('deleteCategoryInformation/{id}', 'AdminController@deleteCategoryInformation')->name('deleteCategoryInformation');
    
    //Redes Sociales Site
    Route::get('social_networks_media', 'AdminController@social_networks_media')->name('social_networks_media');
    Route::get('dtSocialNetworksMedia', 'AdminController@dtSocialNetworksMedia')->name('dtSocialNetworksMedia');
//    Route::get('getSocialNetworks', 'AdminController@getSocialNetworks')->name('getSocialNetworks');
    Route::post('saveSocialNetworksMedia', 'AdminController@saveSocialNetworksMedia')->name('saveSocialNetworksMedia');
    Route::post('deleteSocialNetworksMedia', 'AdminController@deleteSocialNetworksMedia')->name('deleteSocialNetworksMedia');
    
    // Advertisement advertisement
    Route::get('advertisement', 'AdminController@advertisement')->name('advertisement');
    Route::get('dtadvertisement', 'AdminController@dtadvertisement')->name('dtadvertisement');
    Route::post('saveadvertisement', 'AdminController@saveadvertisement')->name('saveadvertisement');
    // Route::get('deleteCategoryInformation/{id}', 'AdminController@deleteCategoryInformation')->name('deleteCategoryInformation');

    //Rutas aplicacion
    Route::get('paths', 'AdminController@paths')->name('paths');
    Route::get('dtpaths', 'AdminController@dtpaths')->name('dtpaths');
    Route::post('savepaths', 'AdminController@savepaths')->name('savepaths');
    Route::post('deletepaths', 'AdminController@deletepaths')->name('deletepaths');

    // PricesAdvertisements pricesadvertisements
    Route::get('pricesadvertisements', 'AdminController@pricesadvertisements')->name('pricesadvertisements');
    Route::get('dtpricesadvertisements', 'AdminController@dtpricesadvertisements')->name('dtpricesadvertisements');
    Route::post('savepricesadvertisements', 'AdminController@savepricesadvertisements')->name('savepricesadvertisements');
    Route::get('deletepricesadvertisements/{id}', 'AdminController@deletepricesadvertisements')->name('deletepricesadvertisements');

    // DocumentAccount document_accounts
    Route::get('document_accounts', 'AdminController@document_accounts')->name('document_accounts');
    Route::get('dtdocument_accounts', 'AdminController@dtdocument_accounts')->name('dtdocument_accounts');
    Route::post('savedocument_accounts', 'AdminController@savedocument_accounts')->name('savedocument_accounts');
    Route::get('deletedocument_accounts/{id}', 'AdminController@deletedocument_accounts')->name('deletedocument_accounts');    

    // HelpDesk help_desks
    Route::get('help_desks', 'AdminController@help_desks')->name('help_desks');
    Route::get('dthelp_desks', 'AdminController@dthelp_desks')->name('dthelp_desks');
    Route::post('savehelp_desks', 'AdminController@savehelp_desks')->name('savehelp_desks');
    Route::get('deletehelp_desks/{id}', 'AdminController@deletehelp_desks')->name('deletehelp_desks');    


    Route::post('getAnswers', 'AdminController@getAnswers')->name('getAnswers');
    Route::post('savehelp_desks', 'AdminController@savehelp_desks')->name('savehelp_desks');

    Route::get('notifications', 'AdminController@notifications')->name('admin.notifications');

    //  UserReport user_report
    Route::get('user_report', 'AdminController@user_report')->name('user_report');
    Route::get('dtuser_report', 'AdminController@dtuser_report')->name('dtuser_report');
    Route::post('saveuser_report', 'AdminController@saveuser_report')->name('saveuser_report');
    Route::get('deleteuser_report/{id}', 'AdminController@deleteuser_report')->name('deleteuser_report');   


    // Reports
    Route::get ('dtReportsIncomeInstructor', 'AdminController@dtReportsIncomeInstructor')->name('dtReportsIncomeInstructor');  /*  */
    Route::get ('dtReportsIncomeClass', 'AdminController@dtReportsIncomeClass')->name('dtReportsIncomeClass');
    Route::get ('dtReportsIncomeCourse', 'AdminController@dtReportsIncomeCourse')->name('dtReportsIncomeCourse');  /*  */
    Route::get ('dtReportsIncomeMeeting', 'AdminController@dtReportsIncomeMeeting')->name('dtReportsIncomeMeeting');

    Route::get ('dtReportsPaymentInstructor', 'AdminController@dtReportsPaymentInstructor')->name('dtReportsPaymentInstructor');  /*  */
    Route::get ('dtReportsPaymentPeriod', 'AdminController@dtReportsPaymentPeriod')->name('dtReportsPaymentPeriod');  /*  */
});


// Route::get('/meeting/{roomId}', 'RoomController@index')->name('meeting.room');

/***
 * COURSE
 */
    // STORE

/*
Route::view('perfil-agenda-cita', 'templates.profile-agenda-date');
Route::view('perfil-agenda-reunion', 'templates.profile-agenda-meet');
Route::view('perfil-agenda-find', 'templates.profile-agenda-find-date');
Route::view('perfil-agenda-mis-citas', 'templates.profile-agenda-mydates');*/

// Route::view('my-class', 'templates.my-class');
// Route::view('public-profile', 'templates.public-profile');


Route::get('/paypal/pay', 'PaypalController@payWithPayPal');
Route::get('/paypal/status', 'PaypalController@payPalStatus')->name('paypal.status');
Route::get('/paypal/failed', 'PaypalController@paypalFailed')->name('paypal.failed');
Route::get('/payment/state/result', 'PaypalController@paypalResult')->name('payment.result');

Route::post('sociallogin', 'AuthController@handleProviderCallback');
Route::get('auth/{provider}/callback', 'OutController@index')->where('provider', '.*');

Route::get('test-notifications', 'NotificationsController@participantsEveryFiveMinutes');

Route::get('/test-notification-2', function () {
    NotificationsController::sendNotificationToPusher(1);
});

Route::get('/mail-test', function() {
    /*$type = 1;
    $user = User::find(4);
    $plan = Plan::find(2);
    
    return new ConfirmationPurchaseMail($type, $user, $plan);*/
    /*
    $message = "Hola amigos quiero ser el quinto teletubie";
    $msg_mail = Message::where('chat_id',1)->where('send_mail','!=' ,null)->get()->last();
    //dd($msg_mail);
    $send_ = false;
    if ($msg_mail != null){
        $fecha_actual = Carbon::now();
        $fecha_msg = Carbon::parse($msg_mail->send_mail)->addSecond(10);
        //dd($fecha_actual);
        if ($fecha_actual > $fecha_msg){
            $send_ = true;
        }
    }else{
        $send_ = true;
    }
    if ($send_){
        $alumno = User::find(3);
        $instructor = User::find(4);
        //dd($instructor->email);
        dispatch(new SendMessageJob($alumno->name, $message, $instructor->email, $instructor->name));
    }*/


    return $send_;
});

Route::get('/{view?}', 'SpaController@index')->where('view', '.*');

/*
Route::view('welcome', 'templates.welcome');
Route::view('crear-curso', 'templates.add-course');
Route::view('crear-clase', 'templates.add-class');
Route::view('crear-cita', 'templates.add-date');
Route::view('pasarela', 'templates.paid');
Route::view('register-profesor', 'templates.registro-profesor');

Route::view('datos-personales', 'templates.personal-data');
Route::view('perfil', 'templates.profile');
Route::view('sala', 'templates.room');
Route::view('perfil-agenda-cita', 'templates.profile-agenda-date');
Route::view('perfil-agenda-reunion', 'templates.profile-agenda-meet');
Route::view('perfil-agenda-find', 'templates.profile-agenda-find-date');
Route::view('perfil-agenda-mis-citas', 'templates.profile-agenda-mydates');
Route::view('perfil-planes', 'templates.profile-agenda-plans');
Route::view('perfil-anuncio', 'templates.profile-anuncio');
Route::view('preview', 'templates.preview'); dffded*/
