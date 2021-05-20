<?php

namespace App\Http\Controllers;

use App\UserRating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        if ($request->has('meeting')) {
            $rating = new UserRating;
            $rating->rating = $request->rating;
            $rating->user_id = $request->user;
            $rating->meeting_id = $request->meeting;
            $rating->save();
        }
        if ($request->has('course')) {
            $rating = new UserRating;
            $rating->rating = $request->rating;
            $rating->user_id = $request->user;
            $rating->course_id = $request->course;
            $rating->save();
        }
        if ($request->has('clase')) {
            $rating = new UserRating;
            $rating->rating = $request->rating;
            $rating->user_id = $request->user;
            $rating->class_id = $request->clase;
            $rating->save();
        }

        return response()->json(true);
    }
}
