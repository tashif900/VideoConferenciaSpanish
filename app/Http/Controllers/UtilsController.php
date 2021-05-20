<?php

namespace App\Http\Controllers;

use App\Country;
use App\DocumentType;
use App\InstitutionType;
use App\Thematic;
use Illuminate\Http\Request;

class UtilsController extends Controller
{
    public function getThematics (){
        //dd(Thematic::with('teachers', 'meetings', 'subtopics.courses', 'subtopics.cclass')->where('state', 1)->get());
        return response()
            ->json(Thematic::with('teachers', 'meetings', 'subtopics.courses', 'subtopics.cclass')
                ->where('state', 1)->get());
    }

    public function getCountries (){

        return response()
            ->json(Country::where('state',1)->get());
    }

    public function getTypeDocuments(){
        return response ()
            ->json(DocumentType::where('state',1)->get());
    }

    public function getInstitutionTypes(){
        return response ()
            ->json(InstitutionType::where('state',1)->get());
    }

}
