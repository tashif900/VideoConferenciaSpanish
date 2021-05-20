<?php

namespace App\Http\Controllers;

use App\Interest;
use Illuminate\Http\Request;
use App\Http\Resources\InterestCollection;

class InterstController extends Controller
{
    public function getInterests()
    {
        $interests = Interest::where('state', 1)->get();

        return response()->json(new InterestCollection($interests));
    }
}
