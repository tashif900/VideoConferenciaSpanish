<?php

namespace App\Http\Controllers;

use App\Deal;
use Illuminate\Http\Request;

class DealsController extends Controller
{
    public function getDeals()
    {
        $deals = Deal::all();

        return response()->json($deals);
    }
}
