<?php

namespace App\Http\Controllers;

use App\DocumentAccount;
use App\DocumentAccountUser;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function getTypeUserDocuments()
    {
        $documents = DocumentAccount::where('state', 1)->orderBy('id', 'asc')->get();

        return response()->json($documents);
    }

    public function getUserDocuments(Request $request)
    {
        $userDocs = DocumentAccountUser::where('user_id', auth()->user()->id)->orderBy('document_account_id', 'asc')->get();

        return response()->json($userDocs);
    }

    public function uploadInstructorDocuments(Request $request)
    {
        $fileName = $this->gen_uuid().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('files'), $fileName);

        $doc = DocumentAccountUser::where('user_id', auth()->user()->id)->where('document_account_id', $request->type)->first();

        if ($doc == null) {
            $doc = new DocumentAccountUser;
        }

        $doc->url_document = $fileName;
        $doc->document_account_id = $request->type;
        $doc->user_id = auth()->user()->id;
        $doc->save();

        return response()->json(['success'=> true, 'file' => $fileName]);
    }

    function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}
