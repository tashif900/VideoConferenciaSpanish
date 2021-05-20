<?php

namespace App\Http\Controllers;

use App\Resource;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    public function getResources(Request $request)
    {
        if ($request->has('meeting')) {
            $resources = Resource::where('meeting_id', $request->meeting)->orderBy('created_at', 'desc')->get(['id', 'name','file', 'meeting_id']);
        }
        if ($request->has('course')) {
            $resources = Resource::where('course_id', $request->course)->orderBy('created_at', 'desc')->get(['id', 'name','file', 'course_id']);
        }
        if ($request->has('clase')) {
            $resources = Resource::where('class_id', $request->clase)->orderBy('created_at', 'desc')->get(['id', 'name','file', 'class_id']);
        }

        return response()->json($resources);
    }

    public function store(Request $request)
    {
        if ($request->has('meeting')) {
            $resource = new Resource;
            $resource->name = $request->name;
            $resource->file = '/files/' . $request->file;
            $resource->meeting_id = $request->meeting;
            $resource->user_id = auth()->user()->id;
            $resource->save();
            
        }
        if ($request->has('course')) {
            $resource = new Resource;
            $resource->name = $request->name;
            $resource->file = '/files/' . $request->file;
            $resource->course_id = $request->course;
            $resource->user_id = auth()->user()->id;
            $resource->save();
        }

        if ($request->has('clase')) {
            $resource = new Resource;
            $resource->name = $request->name;
            $resource->file = '/files/' . $request->file;
            $resource->class_id = $request->clase;
            $resource->user_id = auth()->user()->id;
            $resource->save();
        }
        return response()->json(true);
    }
}
