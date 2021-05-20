<?php

namespace App\Http\Controllers;

use App\Frequent_Question;
use App\SiteSocialNetwork;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function getSocialSite()
    {
        $socials = SiteSocialNetwork::where('state', 1)->select('name', 'link')->get();
        
        return response()->json($socials);
    }

    public function getFaqs()
    {
        $faqs = Frequent_Question::where('state', 1)->select('question', 'response','id')->get();

        return response()->json($faqs);
    }
}
