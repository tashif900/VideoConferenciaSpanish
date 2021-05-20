<?php

namespace App\Http\Controllers;

use App\SubTopic;
use App\Thematic;
use Illuminate\Http\Request;
use App\Http\Resources\SubTopicCollection;
use App\Http\Resources\ThematicCollection;
use App\Http\Resources\Thematic as ThematicResource;

class ThematicController extends Controller
{
    public function getThematic()
    {
        $thematics = Thematic::where('state', 1)->orderBy('name', 'ASC')->get();

        return response()->json(new ThematicCollection($thematics));
    }

    public function getSubThematic(Request $request)
    {
        $thematics = SubTopic::where('state', 1)->where('thematic_id', $request->thematic)->orderBy('name', 'ASC')->get();

        return response()->json(new SubTopicCollection($thematics));
    }
}
