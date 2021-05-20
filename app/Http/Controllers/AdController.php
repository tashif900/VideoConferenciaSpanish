<?php

namespace App\Http\Controllers;

use App\Cclass;
use App\Course;
use App\Meeting;
use App\Advertisement;
use Illuminate\Http\Request;
use App\PricesAdvertisements;
use App\Http\Controllers\FileController;
use App\Http\Resources\AdResourceCollection;
use App\Http\Controllers\NotificationsController;
use App\Http\Resources\AdvertisementResourceCollection;

class AdController extends Controller
{
    public $_file;

    public function __construct()
    {
        $this->_file = new FileController;
    }
    
    public function getData(Request $request)
    {
        $response=null;
        switch ($request->type) {
            case '1':
                $data = null;
                break;
            case '2':
                $data = Course::where('user_id', auth()->user()->id)->get();
                break;
            case '3':
                $data = Cclass::where('user_id', auth()->user()->id)->whereNull('course_id')->get();
                break;
            case '4':
                $data = Meeting::where('user_id', auth()->user()->id)->get();
                break;
            
            default:
                $data = false;
                break;
        }

        if ($data != null) $response = new AdResourceCollection($data);

        //dd($response);
        return response()->json($response);
    }

    public function store(Request $request)
    {
       if ($request->id == null || $request->id == 'null'){
            $ad = new Advertisement;
            $ad->type = $request->type;
            $ad->vigency = $request->vigency;
            $ad->prices_advertisement_id = $request->prices_advertisement_id;
            $ad->price = $request->price;
            if ($request->type == 2) {
                $ad->course_id = $request->item;
            } else if ($request->type == 3) {
                $ad->class_id = $request->item;
            } else if ($request->type == 4) {
                $ad->meeting_id = $request->item;
            }
            $ad->status = 4;
        }else{
            $ad = Advertisement::find($request->id);
            $ad->status =0;
        }

        if ($request->file != 'edit'){
            $photo = $this->_file->storeFile($request->file);
            $photo_movil = $this->_file->storeFile($request->file_photo);
            $ad->image = $photo;
            $ad->image_movil = $photo_movil;
        }

        $ad->from = date('Y-m-d', strtotime($request->from));
        $ad->to = date('Y-m-d', strtotime($request->to));
        $ad->title = $request->title;
        $ad->description = $request->description;
        $ad->user_id = auth()->user()->id;
        $ad->save();

        NotificationsController::sendNotificationToPusher(5);

        return response()->json(array('state' => true, 'status' => $ad->status));
    }

    public function updateDate(Request $request){
       $ad = Advertisement::find($request->id);
       $ad->from = date('Y-m-d', strtotime($request->from));
       $ad->to = date('Y-m-d', strtotime($request->to));
       $ad->save();
       return response()->json(true);
    }

    public function getMyAds(Request $request)
    {
        $ads = Advertisement::where('user_id', auth()->user()->id)->get();

        return response()->json(new AdvertisementResourceCollection($ads));
    }

    public function getVigencies(Request $request)
    {
        $vigencies = PricesAdvertisements::where('state', 1)->get();

        return response()->json($vigencies);
    }

    public function getVigencyInformation(Request $request)
    {
        $vigencies = PricesAdvertisements::where('state', 1)->where('id', $request->id)->first();

        return response()->json($vigencies);
    }

    public function getAdvertisement (Request $request){
        //dd($request->id);
        $Advertisement = Advertisement::with('PricesAdvertisements')->find($request->id);
        return response()->json($Advertisement);
    }
}
