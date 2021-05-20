<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function getPage($page)
    {
        $page = Page::where('slug', $page)->first();

        return response()->json($page);
    }
}
