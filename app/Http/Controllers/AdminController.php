<?php
namespace App\Http\Controllers;
use App\Page;
use App\Path;
use App\Plan;
use App\User;
use App\Cclass;
use App\Course;
use App\People;
use App\Country;
use App\Meeting;
use App\HelpDesk;
use App\Interest;
use App\SubTopic;
use App\Thematic;
use App\PeriodUser;
use App\UserReport;
use App\DocumentType;
use App\Notification;
use App\Advertisement;
use App\PaymentMethod;
use App\SocialNetwork;
use App\OutputMovement;
use App\PaymentGateway;
use App\PlataformPrice;
use App\DocumentAccount;
use App\InstitutionType;
use App\WithdrawalPolicy;
use App\Frequent_Question;
use App\SiteSocialNetwork;
use App\WithdrawalRequest;
use App\InstructorMovement;
use Illuminate\Http\Request;
use App\Mail\AdsApprovalMail;
use App\PricesAdvertisements;
use App\Mail\WithDrawalPayMail;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Mail\WithDrawalDeclineMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\NotificationResourceCollection;

class AdminController extends Controller
{
    public $_file;

    public function __construct()
    {
        $this->_file = new FileController;
    }
    //Raiz
    public function index (){
        return view('admin.index');
    }

    // Users
    public function users(){
        $role = Role::all();
        return view('admin.users', compact('role'));
    }
    public function dtusers(){
        $users = User::with('people.country', 'roles')->where('state', 1)->get();

        return datatables()->of(
            $users
        )->toJson();
    }
    public function saveuser(Request $request){
        try {
            if($request->id == null || $request->id == ''){
                $user = new User();
                $person = new People();
                $user->syncRoles($request->role);
            }else{
                $user = User::find($request->id);
                $person = People::where('user_id', $request->id)->first();
            }

            // User
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password != null && $request->password != ''){
                $user->password = Hash::make($request->password);
            }

            $user->social_network = $request->social_network;
            $user->security_question = $request->security_question;
            $user->security_answer = $request->security_answer;

            // People
            $person->country_id = $request->country_id;
            $person->institution_type_id = $request->institution_type_id;
            $person->document_type_id = $request->document_type_id;
            $person->birth_date = $request->birth_date;
            $person->phone = $request->phone;
            $person->grade = $request->grade;
            $person->profession = $request->profession;
            $person->description = $request->description;
            $person->grade_instruction = $request->grade_instruction;
            $person->name_institution = $request->name_institution;
            $person->document_number = $request->document_number;

            $user->state = 1;
            $user->save();
            $person->user_id = $user->id;
            $person->save();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json(false);
        }
    }

    public function deleteuser($id){
        $user = User::find($id);
        $user->state = 0;
        $user->save();
        return response()->json(true);
    }
    // Profile
    public function profile()
    {
        $user = User::find(Auth::id());
        $countries = Country::where('state', 1)->get();
        $institution_types = InstitutionType::where('state', 1)->get();
        $document_type = DocumentType::where('state', 1)->get();
        return view('admin.profile', compact('user', 'countries', 'institution_types', 'document_type'));
    }

    // Countries
    public function countries(){
        return view('admin.countries');
    }
    public function dtcountries(){
        $countries = Country::all();

        return datatables()->of(
            $countries
        )->toJson();
    }
    public function savecountry(Request $request){
        try {
            if($request->id == null || $request->id == ''){
                $country = new Country();
            }else{
                $country = Country::find($request->id);
            }

            $country->name = $request->name;
            $country->state = $request->state;
            $country->save();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json(false);
        }
    }
    public function deletecountry($id)
    {
        $country = Country::find($id);
        $country->state = 0;
        $country->save();
        return response()->json(true);
    }

    // Meetings
    public function meetings(){
        $teachers = User::role('Profesor')->orderBy('name', 'asc')->get();
        $thematics = Thematic::where('state', 1)->get();
        return view('admin.meetings', compact('teachers', 'thematics'));
    }
    public function dtmeetings(){
        $meetings = Meeting::with('thematic', 'user')->get();

        return datatables()->of(
            $meetings
        )->toJson();
    }
    public function savemeeting(Request $request){
        try {
            if($request->id == null || $request->id == ''){
                $meeting = new Meeting();
            }else{
                $meeting = Meeting::find($request->id);
            }

            $meeting->name = $request->name;
            $meeting->description = $request->description;
            $meeting->type_meeting = $request->type_meeting;
            $meeting->number_participant = $request->number_participant;
            $meeting->price = $request->price;
            $meeting->hour_start = date('Y-m-d H:i:s', strtotime($request->hour_start));
            $meeting->hour_end   = date('Y-m-d H:i:s', strtotime($request->hour_end));;
            $meeting->thematic_id = $request->thematic_id;
            $meeting->user_id = $request->user_id;
            if($request->state != null)
                $meeting->state = $request->state;
            $meeting->save();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json(false);
        }
    }
    public function deletemeeting($id)
    {
        $meeting = Meeting::find($id);
        $meeting->state = 0;
        $meeting->save();
        return response()->json(true);
    }


    // Payment gateway
    public function paymentgateway(){
        return view('admin.paymentgateway');
    }
    public function dtpaymentgateway(){
        $payment = PaymentGateway::all();
        return datatables()->of(
            $payment
        )->toJson();
    }
    public function savepaymentgateway(Request $request){
        try {
            if($request->id == null || $request->id == ''){
                $payment = new PaymentGateway();
            }else{
                $payment = PaymentGateway::find($request->id);
            }
            $payment->name =  $request->name;
            $payment->state = $request->state;
            $payment->save();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json(false);
        }
    }
    public function deletepaymentgateway($id)
    {
        $payment = PaymentGateway::find($id);
        $payment->state = 0;
        $payment->save();
        return response()->json(true);
    }
    // Withdrawal Policies
    public function withdrawalpolicies(){
        return view('admin.withdrawalpolicies');
    }
    public function dtwithdrawalpolicies(){
        $withdrawal = WithdrawalPolicy::where('state', 1)->get();
        return datatables()->of(
            $withdrawal
        )->toJson();
    }
    public function savewithdrawalpolicies(Request $request){
        try {
            if($request->id == null || $request->id == ''){
                $withdrawal = new WithdrawalPolicy();
                $withdrawal->user_create = Auth::id();
                $withdrawal->user_update = Auth::id();
            }else{
                $withdrawal = WithdrawalPolicy::find($request->id);
                $withdrawal->user_update = Auth::id();
            }
            $withdrawal->description = $request->description;
            $withdrawal->start_day = $request->start_day;
            $withdrawal->amount_max = $request->amount;
            $withdrawal->state = 1;
            $withdrawal->save();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json(false);
        }
    }
    public function deletewithdrawalpolicies($id)
    {
        $withdrawal = withdrawalpolicies::find($id);
        $withdrawal->state = 0;
        $withdrawal->save();
        return response()->json(true);
    }

    // Courses
    public function courses()
    {
        $teachers = User::role('Profesor')->orderBy('name', 'asc')->get();
        $subtopics = SubTopic::where('state', 1)->get();
        return view('admin.courses', compact('subtopics', 'teachers'));
    }
    public function dtcourses()
    {
        $courses = Course::with('user', 'subtopic')->get();
        return datatables()->of(
            $courses
        )->toJson();
    }
    public function savecourse(Request $request)
    {
        try {
            if ($request->id != null && $request->id != '') {
                $course = Course::find($request->id);
            } else {
                $course = new Course();
            }

            $course->name = $request->name;
            $course->description = $request->description;
            $course->type_course = $request->type_course;
            $course->number_class = $request->number_class;
            $course->price = $request->price;

            //dd($request->file('photo'));
            if($request->file('photo') != null && $request->file('photo') != '')
            {
                $photo = $this->_file->storeFile($request->file('photo'));
                $course->photo = $photo;
            }

            $course->date_start = date('Y-m-d', strtotime($request->date_start));
            $course->url_presentation = $request->url_presentation;
            $course->user_id = $request->user_id;
            $course->subtopic_id = $request->subtopic_id;
            $course->state = $request->state;
            $course->save();
            return response()->json(true);

        }catch (Exception $e){
           return response()->json(false);
        }
    }

    public function deletecourse($id)
    {
        try
        {
            $course = Course::find($id);
            $course->state = 0;
            $course->save();
            return response()->json(true);
        }catch(Exception $e)
        {
            return response()->json(false);
        }
    }

    // dt course class 
    public function viewcourse($id)
    {
        $subtopics = SubTopic::where('state', 1)->get();
        $course = Course::with('subtopic', 'user')->find($id);
        return view('admin.viewcourse', compact('course', 'subtopics'));
    }

    public function dtcourseclass($id)
    {
        $classes = Cclass::where('state', 1)->where('course_id', $id)->get();
        return datatables()->of(
            $classes
        )->toJson();
    }
    public function savecourseclass(Request $request)
    {
        try {
            if ($request->id != null && $request->id != '') {
                $class = Cclass::find($request->id);
            } else {
                $class = new Cclass();
            }


            $class->name = $request->name;
            $class->description = $request->description;
            $class->hour_start = date('Y-m-d H:i:s', strtotime($request->hour_start));
            $class->hour_end = date('Y-m-d H:i:s', strtotime($request->hour_end));
            if($request->file('photo') != null || $request->file('photo') == ''){
                $cover_photo       =   Storage::disk('s3')->put('company_cover', $request->file('photo'), 'public');
                $path_photo        =   Storage::disk('s3')->url($cover_photo);
                $class->photo     =    $path_photo;
            }
            $class->url_presentation = $request->url_presentation;
            $class->type_class = $request->type_class;
            $class->subtopic_id = $request->subtopic_id;
            $class->user_id = $request->user_id;
            $class->course_id = $request->course_id;
            $class->state = 1;
            $class->save();

            return response()->json(true);
        }catch (Exception $e){
           return response()->json(false);
        }
    }           /* delete interests */

    public function deletecourseclass($id)
    {
        try
        {
            $class = Cclass::find($id);
            $class->state = 0;
            $class->save();
            return response()->json(true);
        }catch(Exception $e)
        {
            return response()->json(false);
        }
    }


    //Documentos
    public function documents()
    {
        return view('admin.documents');
    }

    public function dtDocuments()
    {
        $document = DocumentType::all();

        return datatables()->of($document)->toJSON();
    }

    public function getDocuments(Request $request)
    {
        $document = DocumentType::find($request->id);

        return response()->json($document);
    }

    public function saveDocuments(Request $request)
    {
        try{
            if ($request->id === '' || $request->id === null) {
                $document = new DocumentType();
            }
            else {
                $document = DocumentType::find($request->id);
            }

            $document->description = $request->description;
            $document->state = $request->state;
            $document->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    public function deleteDocuments(Request $request)
    {
        try{
            $document = DocumentType::find($request->id);
            $document->state = 0;
            $document->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    //Instituciones
    public function institutions()
    {
        return view('admin.institutions');
    }

    public function dtInstitutions()
    {
        $institution = InstitutionType::all();

        return datatables()->of($institution)->toJSON();
    }

    public function getInstitutions(Request $request)
    {
        $institution = InstitutionType::find($request->id);

        return response()->json($institution);
    }

    public function saveInstitutions(Request $request)
    {
        try{
            if ($request->id === '' || $request->id === null) {
                $institution = new InstitutionType();
            }
            else {
                $institution = InstitutionType::find($request->id);
            }

            $institution->description = $request->description;
            $institution->state = 1;
            $institution->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    public function deleteInstitutions(Request $request)
    {
        try{
            $institution = InstitutionType::find($request->id);
            $institution->state = 0;
            $institution->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    //Intereses
    public function interests()
    {
        return view('admin.interests');
    }

    public function dtInterests()
    {
        $interest = Interest::all();

        return datatables()->of($interest)->toJSON();
    }

    public function getInterests(Request $request)
    {
        $interest = Interest::find($request->id);

        return response()->json($interest);
    }

    public function saveInterests(Request $request)
    {
        try{
            if ($request->id === '' || $request->id === null) {
                $interest = new Interest();
            }
            else {
                $interest = Interest::find($request->id);
            }

            $interest->name = $request->name;
            $interest->state = $request->state;
            $interest->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    public function deleteInterests(Request $request)
    {
        try{
            $interest = Interest::find($request->id);
            $interest->state = 0;
            $interest->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    //Metodos de Pago
    public function payment_methods()
    {
        return view('admin.payment_methods');
    }

    public function dtPaymentMethods()
    {
        $paymentmethod = PaymentMethod::all();

        return datatables()->of($paymentmethod)->toJSON();
    }

    public function getPaymentMethods(Request $request)
    {
        $paymentmethod = PaymentMethod::find($request->id);

        return response()->json($paymentmethod);
    }

    public function savePaymentMethods(Request $request)
    {
        try{
            if ($request->id === '' || $request->id === null) {
                $paymentmethod = new PaymentMethod();
            }
            else {
                $paymentmethod = PaymentMethod::find($request->id);
            }

            $paymentmethod->name = $request->name;
            $paymentmethod->state = $request->state;
            $paymentmethod->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    public function deletePaymentMethods(Request $request)
    {
        try{
            $paymentmethod = PaymentMethod::find($request->id);
            $paymentmethod->state = 0;
            $paymentmethod->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    //Redes Sociales
    public function social_networks()
    {
        return view('admin.social_networks');
    }

    public function dtSocialNetworks()
    {
        $socialnetwork = SocialNetwork::all();

        return datatables()->of($socialnetwork)->toJSON();
    }

    public function getSocialNetworks(Request $request)
    {
        $socialnetwork = SocialNetwork::find($request->id);

        return response()->json($socialnetwork);
    }

    public function saveSocialNetworks(Request $request)
    {
        try{
            if ($request->id === '' || $request->id === null) {
                $socialnetwork = new SocialNetwork();
            }
            else {
                $socialnetwork = SocialNetwork::find($request->id);
            }

            $socialnetwork->name = $request->name;
            $socialnetwork->state = $request->state;
            $socialnetwork->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    public function deleteSocialNetworks(Request $request)
    {
        try{
            $socialnetwork = SocialNetwork::find($request->id);
            $socialnetwork->state = 0;
            $socialnetwork->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    //Temas
    public function themes()
    {
        return view('admin.themes');
    }

    public function dtThemes()
    {
        $themes = Thematic::with('plataform_price')->get();
        return datatables()->of($themes)->toJSON();
    }

    public function getThemes(Request $request)
    {
        $theme = Thematic::with('plataform_price')->find($request->id);

        return response()->json($theme);
    }

    public function saveThemes(Request $request)
    {
        try{
            if ($request->id === '' || $request->id === null) {
                $theme = new Thematic();
                // $plataform_price = new PlataformPrice();
            }
            else {
                $theme = Thematic::find($request->id);
                // $plataform_price = PlataformPrice::where('thematic_id',$request->id)->first();
                //dd($plataform_price);
            }

            $theme->name = $request->name;
            $theme->state = $request->state;
            $theme->percentage = $request->percentage;
            $theme->save();

            // $plataform_price->thematic_id = $theme->id;
            // $plataform_price->percentage = 0;
            // $plataform_price->state = 1;
            // $plataform_price->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    public function deleteThemes(Request $request)
    {
        try{
            $theme = Thematic::find($request->id);
            $theme->state = 0;
            $theme->save();

            // $plataform_price = PlataformPrice::where('thematic_id',$request->id)->first();
            // $plataform_price->state = 0;
            // $plataform_price->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    //Subtemas
    public function subtopics()
    {
        $themes = Thematic::where('state', 1)->get();

        return view('admin.subtopic',compact('themes'));
    }

    public function dtSubtopics()
    {
        $subtopics = SubTopic::with('thematic')->get();

        return datatables()->of($subtopics)->toJSON();
    }

    public function getSubtopics(Request $request)
    {
        $subtopic = SubTopic::find($request->id);

        return response()->json($subtopic);
    }

    public function saveSubtopics(Request $request)
    {
        try{
            if ($request->id === '' || $request->id === null) {
                $subtopic = new SubTopic();
            }
            else {
                $subtopic = SubTopic::find($request->id);
            }

            $subtopic->name = $request->name;
            $subtopic->thematic_id = $request->theme_id;
            $subtopic->state = $request->state;
            $subtopic->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    public function deleteSubtopics(Request $request)
    {
        try{
            $subtopic = SubTopic::find($request->id);
            $subtopic->state = 0;
            $subtopic->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    //Planes
    public function plans()
    {
        return view('admin.plans');
    }

    public function dtPlans()
    {
        $plans = Plan::all();

        return datatables()->of($plans)->toJSON();
    }

    public function getPlans(Request $request)
    {
        $plan = Plan::find($request->id);

        return response()->json($plan);
    }

    public function savePlans(Request $request)
    {
        try{
            if ($request->id === '' || $request->id === null) {
                $plan = new Plan();
            }
            else {
                $plan = Plan::find($request->id);
            }

            $plan->name = $request->name;
            $plan->description = $request->description;
            $plan->price = $request->price;
            $plan->percentage = $request->percentage;
            $plan->validity_day = $request->validity_day;
            $plan->user_updated = auth()->id();
            $plan->user_created = auth()->id();

            $plan->state = 1;
            $plan->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    public function deletePlans(Request $request)
    {
        try{
            //dd($request->state);
            $plan = Plan::find($request->id);
            $plan->state = $request->state;
            $plan->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    //Clases - Sin Curso
    public function cclasses()
    {
        $subtopics = SubTopic::where('state', 1)->get();

        return view('admin.cclasses',compact('subtopics'));
    }

    public function dtCclasses()
    {
        $cclasses = Cclass::all();

        return datatables()->of($cclasses)->toJSON();
    }

    public function getCclasses(Request $request)
    {
        $cclass = Cclass::find($request->id);

        return response()->json($cclass);
    }

    public function saveCclasses(Request $request)
    {
        try{
            if ($request->id === '' || $request->id === null) {
                $cclass = new Cclass();
            }
            else {
                $cclass = Cclass::find($request->id);
            }

            $cclass->name = $request->name;
            $cclass->description = $request->description;
            $cclass->price = $request->price;
            $cclass->hour_start = $request->hour_start;
            $cclass->hour_end = $request->hour_end;
            $cclass->subtopic_id = $request->subtopic_id;
            $cclass->type_class = $request->type_class;
            $cclass->user_id = 1;
            $cclass->state = $request->state;

            $cclass->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    public function deleteCclasses(Request $request)
    {
        try{
            $cclass = Cclass::find($request->id);
            $cclass->state = 0;
            $cclass->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }
    public function incomeinstructor(){
        return view('admin.reports.incomeinstructor');
    }

    public function incomemeeting(){
        return view('admin.reports.incomemeeting');
    }
    public function incomecourse(){
        return view('admin.reports.incomecourse');
    }
    public function incomeclass(){
        return view('admin.reports.incomeclass');
    }
    
    public function paymentinstructor(){
        return view('admin.reports.paymentinstructor');
    }
    public function paymentperiod(){
        return view('admin.reports.paymentperiod');
    }
    //Solicitudes

    public function withdrawal_requests() {
        //dd($users);
        return view('admin.withdrawalrequests');
    }

    public function dtWithdrawalRequests() {
        return datatables()->of(
            WithdrawalRequest::with('output', 'user')->get()
        )->toJson();
    }

    public function getWithdrawalRequests(Request $request)
    {
        $req = WithdrawalRequest::with('output', 'user.payment_method_users')->find($request->id);
        //dd($req);
        return response()->json($req);
    }

    public function saveWithdrawalRequests(Request $request)
    {
        DB::beginTransaction();
        try {
            $req = WithdrawalRequest::find($request->request_id);
            $req->payment_date = $request->payment_date;
            $req->comment = $request->observation;
            $req->operation_number = $request->operation_number;
            $req->state = $request->state;
            $req->save();

            $user = User::with('payment_method_users')->find($request->user_id);
            //dd($user);
            if ($request->state == 2) {
                $with = OutputMovement::where('withdrawal_request_id', $req->id)->pluck('period');

                for ($i=0; $i < count($with); $i++) {
                    $p = PeriodUser::where('user_id', $request->user_id)->where('period', $with[$i])->first();
                    $p->state = 2;
                    $p->save();
                }

                Mail::to($user->email)->send(new WithDrawalPayMail($user, $request->total,$request->operation_number));
            } else if($request->state == 3) {
                Mail::to($user->email)->send(new WithDrawalDeclineMail($user, $req->request_date));
            }

            DB::commit();

            return response()->json(true);

        }catch (Exception $e){
            DB::rollback();
           return response()->json($e->getMessage());
        }
    }
    // Frequest questions
    public function questions()
    {
        return view('admin.questions');
    }

    public function dtQuestions()
    {
        return datatables()->of(
            Frequent_Question::where('state','1')->get()
        )->toJson();
    }
    public function saveQuestion(Request $request)
    {
        try {
            if ($request->id != null && $request->id != '') {
                $question = Frequent_Question::find($request->id);
            } else {
                $question  = new Frequent_Question();
            }

            $question->question = $request->question;
            $question->response = $request->resp;
            $question->state = $request->state;
            $question->save();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json($e->getMessage());
        }
    }
    public function deleteQuestion($id)
    {
        try
        {
            $question = Frequent_Question::find($id);
            //$question->state = false;
            $question->delete();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json($e->getMessage());
        }
    }
    // Category information
    public function categoryinformation()
    {
        return view('admin.categoryinformation');
    }
    public function dtCategoryInformation()
    {
        return datatables()->of(
            Page::all()
        )->toJson();

    }
    public function saveCategoryInformation(Request $request)
    {
        try {
            // if ($request->id != null && $request->id != '') {
            //     $information = CategoryInformation::find($request->id);
            // } else {
            //     $information  = new CategoryInformation();
            // }
            //dd($request->cuerpo);
            $information = Page::find($request->id);

            $information->name         = $request->title;
            $information->body        = $request->cuerpo;
            $information->save();

            //dd($information);
            return response()->json(true);

        }catch (Exception $e){
            return response()->json($e->getMessage());
        }
    }

    //Redes Sociales site
    public function social_networks_media()
    {
        return view('admin.site_social_networks');
    }

    public function dtSocialNetworksMedia()
    {
        $socialnetwork = SiteSocialNetwork::where('state',1)->get();

        return datatables()->of($socialnetwork)->toJSON();
    }

    public function saveSocialNetworksMedia(Request $request)
    {
        try{
            if ($request->id === '' || $request->id === null) {
                $socialnetwork = new SiteSocialNetwork();
            }
            else {
                $socialnetwork = SiteSocialNetwork::find($request->id);
            }

            $socialnetwork->name = $request->name;
            $socialnetwork->link = $request->link;
            $socialnetwork->state = 1;
            $socialnetwork->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    public function deleteSocialNetworksMedia(Request $request)
    {
        try{
            $socialnetwork = SiteSocialNetwork::find($request->id);
            $socialnetwork->state = 0;
            $socialnetwork->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }
    // Advertisement advertisement

    public function advertisement()
    {
        //$advertisement = Advertisement::all();
        $users = User::where('state',1)->get();
        $paths = Path::where('state',1)->get();

        return view('admin.advertisement',compact( 'users', 'paths'));
    }

    public function dtadvertisement()
    {
        $advertisement = Advertisement::with('Path')->get();

        return datatables()->of($advertisement)->toJSON();
    }

    public function saveadvertisement(Request $request)
    {
        try{
            $_file = new FileController();

            //dd($request->image);
            if ($request->id === '' || $request->id === null) {
                $advertisement = new Advertisement();
                $advertisement->from = $request->from;
                $advertisement->type = $request->type;
                $advertisement->user_id = auth()->id();
      //          $advertisement->state = 1;

            }
            else {
                $advertisement = Advertisement::with('user')->find($request->id);
            }

            if ($request->image != null && $request->image != "undefined"){
                $photo = $_file->storeFile($request->image);
                $advertisement->image = $photo;
            }

            if ($request->image_movil != null && $request->image_movil != "undefined"){
                $photo_movil = $_file->storeFile($request->image_movil);
                $advertisement->image_movil = $photo_movil;
            }

            $advertisement->to = $request->to;
            $advertisement->title = $request->title;
            $advertisement->description = $request->description;
            $advertisement->path_id = $request->path;
            $advertisement->status = $request->status;

            $advertisement->save();

            if ($request->status == 1) {
                Mail::to($advertisement->user->email)->send(new AdsApprovalMail);
            }

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }
    //Rutas de la aplicación

    public function paths (){
        return view('admin.paths');
    }

    public function dtpaths()
    {
        $paths = Path::all();

        return datatables()->of($paths)->toJSON();
    }

    public function savepaths(Request $request)
    {
        try{
            //dd($request->path);
            if ($request->id === '' || $request->id === null) {
                $paths = new Path();
                $paths->state = 1;
            }
            else {
                $paths = Path::find($request->id);
            }
            $paths->name = $request->path;
            $paths->description = $request->description;

            $paths->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    public function deletepaths (Request $request){
        try{
            //dd($request->state);
            $path = Path::find($request->id);
            $path->state = $request->state;
            $path->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    //Fin Rutas
    // PricesAdvertisements pricesadvertisements
    public function pricesadvertisements()
    {
        return view('admin.pricesadvertisements');
    }

    public function dtpricesadvertisements()
    {
        return datatables()->of(
            PricesAdvertisements::where('state','1')->get()
        )->toJson();
    }
    public function savepricesadvertisements(Request $request)
    {
        try {
            if ($request->id != null && $request->id != '') {
                $pricesadvertisements = PricesAdvertisements::find($request->id);
            } else {
                $pricesadvertisements  = new PricesAdvertisements();
            }

            $pricesadvertisements->description = $request->description;
            $pricesadvertisements->time = $request->time;
            $pricesadvertisements->mount = $request->mount;
            $pricesadvertisements->state = 1;

            $pricesadvertisements->save();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json($e->getMessage());
        }
    }
    public function deletepricesadvertisements($id)
    {
        try
        {
            $pricesadvertisements = PricesAdvertisements::find($id);
            $pricesadvertisements->state = false;
            $pricesadvertisements->save();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json($e->getMessage());
        }
    }
 
    // DocumentAccount document_accounts
    public function document_accounts()
    {
        return view('admin.document_accounts');
    }

    public function dtdocument_accounts()
    {
        return datatables()->of(
            DocumentAccount::all()
        )->toJson();
    }
    public function savedocument_accounts(Request $request)
    {
        try {
            if ($request->id != null && $request->id != '') {
                $document = DocumentAccount::find($request->id);
            } else {
                $document  = new DocumentAccount();
            }

            $document->name = $request->name;
            $document->state = $request->state;
            $document->save();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json($e->getMessage());
        }
    }
    public function deletedocument_accounts($id)
    {
        try
        {
            $document = DocumentAccount::find($id);
            $document->state = false;
            $document->save();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json($e->getMessage());
        }
    }

    // HelpDesk help_desks
    public function help_desks()
    {
        return view('admin.help_desks');
    }

    public function dthelp_desks()
    {
        return datatables()->of(
            HelpDesk::with('user')->where('parent_id', null)->get()
        )->toJson();
    }
    public function savehelp_desks(Request $request)
    {
        try {
            if ($request->id != null && $request->id != '') {
                $help = HelpDesk::find($request->id);
            } else {
                $help  = new HelpDesk();
            }

            $help->user_id = Auth::id();
            $help->title = $request->title;
            $help->description = $request->message;
            $help->state = 1;
            $help->parent_id = $request->parent_id;
            $help->save();

            return response()->json(true);

        }catch (Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function getAnswers(Request $request){
        $answers =  HelpDesk::with('helpdesks')->find($request->id);
        return response()->json($answers);
    }

    public function notifications()
    {
        $updateNotifications = Notification::whereNull('read_at')->get();

        foreach ($updateNotifications as $notification) {
            $not = Notification::find($notification->id);
            $not->read_at = date('Y-m-d H:i:s');
            $not->save();
        }

        $notifications = Notification::orderBy('created_at','desc')->take(20)->get();

        return view('admin.notifications', compact('notifications'));
    }
    //  UserReport user_report

    public function user_report()
    {
        return view('admin.user_report');
    }

    public function dtuser_report()
    {
        $report = UserReport::with('u_reported_user', 'u_user_report')->where('state',1)->get();

        return datatables()->of($report)->toJSON();
    }

    public function saveuser_report(Request $request)
    {
        try{
            if ($request->id === '' || $request->id === null) {
                $report = new UserReport();
            }
            else {
                $report = UserReport::find($request->id);
            }

            $report->comment = $request->comment;
            $report->reported_user = $request->reported_user;
            $report->user_report = $request->user_report;
            $report->state = 1;
            $report->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    public function deleteuser_report(Request $request)
    {
        try{
            $report = UserReport::find($request->id);
            $report->state = 0;
            $report->save();

            return response()->json(true);
        }
        catch(exception $e){
            return $e->getMessage();
        }
    }

    // Reports
    public function dtReportsIncomeInstructor()
    {
        $movements = InstructorMovement::with('user')
            ->select(DB::raw("user_id, period, SUM(amount) as 'Monto Bruto' , SUM(amount * (1- platform_percentage)) as 'Monto Plataforma',
                                    COUNT(DISTINCT class_id) AS '#Clases'"))
            //->sum('amount')
            ->groupBy('user_id', 'period')
            ->orderBy('period')
            ->get();

        return datatables()->of(
            $movements
        )->toJson();
    }

    public function dtReportsIncomeClass()
    {
        $movements_class = InstructorMovement::with( 'cclass.participants')
            ->select(DB::raw("class_id, period, SUM(amount) as 'Monto Bruto' , SUM(amount * (1- platform_percentage)) as 'Monto Plataforma',
                                    COUNT(DISTINCT class_id) AS '#Alumnos'"))
            ->groupBy('class_id', 'period')
            ->orderBy('period')
            ->where('class_id', '!=', null)->get();
        //dd($movements_courses);
        return datatables()->of(
            $movements_class
        )->toJson();
    }

    public function dtReportsIncomeCourse()
    {
        $movements_courses = InstructorMovement::with( 'course.participants')
            ->select(DB::raw("course_id, period, SUM(amount) as 'Monto Bruto' , SUM(amount * (1- platform_percentage)) as 'Monto Plataforma',
                                    COUNT(DISTINCT course_id) AS '#Alumnos'"))
            ->groupBy('course_id', 'period')
            ->orderBy('period')
            ->where('course_id', '!=', null)->get();
        //dd($movements_courses);
        return datatables()->of(
            $movements_courses
        )->toJson();
    }

    public function dtReportsIncomeMeeting()
    {
        $movements_courses = InstructorMovement::with( 'meeting.participants')
            ->select(DB::raw("meeting_id, period, SUM(amount) as 'Monto Bruto' , SUM(amount * (1- platform_percentage)) as 'Monto Plataforma',
                                    COUNT(DISTINCT meeting_id) AS '#Alumnos'"))
            ->groupBy('meeting_id', 'period')
            ->orderBy('period')
            ->where('meeting_id', '!=', null)->get();
        //dd($movements_courses);
        return datatables()->of(
            $movements_courses
        )->toJson();
    }

    public function dtReportsPaymentInstructor()
    {
        $movements = InstructorMovement::with('user')
            ->select(DB::raw("user_id, period, SUM(amount * platform_percentage) as 'Monto Bruto' , SUM(amount * (1 - platform_percentage)) as 'Monto Plataforma',
                                    COUNT(DISTINCT class_id) AS '#Clases'"))
            //->sum('amount')
            ->groupBy('user_id', 'period')
            ->orderBy('period')
            ->get();

        return datatables()->of(
            $movements
        )->toJson();
    }

    public function dtReportsPaymentPeriod()
    {
        $movements = InstructorMovement::with('user')
            ->select(DB::raw("period, COUNT(DISTINCT user_id) as instructores,SUM(amount * platform_percentage) as 'Monto Bruto' , SUM(amount * (1 - platform_percentage)) as 'Monto Plataforma'"))
            //->sum('amount')
            ->groupBy('period')
            ->get();
        return datatables()->of(
            $movements
        )->toJson();
    }
}
