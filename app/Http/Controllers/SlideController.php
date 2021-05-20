<?php

namespace App\Http\Controllers;

use App\Cclass;

use App\Course;
use Carbon\Carbon;
use App\Advertisement;
use Illuminate\Http\Request;
use App\Http\Resources\SliderResourceCollection;

class SlideController extends Controller
{
    public function getItems()
    {
        $now = Carbon::now();
        $date = $now->format('Y-m-d');
        
        $items = Advertisement::with('Path')
            ->where('status', 1)->where('to', '>=', $date)
            ->orderByRaw('rand()')->take(10)->get();

        foreach ($items as $item ) {
            $items->filter(function($i) use ($date) {
                if (($date >= $i->from) && ($date <= $i->to)) {
                    return true;
                }
            });
        }

        return response()->json(new SliderResourceCollection($items));
    }

}
