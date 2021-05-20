<?php

namespace App\Http\Controllers;

use App\InputMovement;
use Illuminate\Http\Request;
use App\Http\Resources\InputMovementCollection;

class PaymentController extends Controller
{
    public function getMovements(Request $request)
    {
        $movements  = InputMovement::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->get();

        return response()->json(new InputMovementCollection($movements));
    }
}
