<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use BoldBrush\Cloudflare\API;
use Illuminate\Support\Facades\File;

class FileController extends Controller
{
    public function store(Request $request)
    {
        try {
            $api = API\Factory::make(
                env('CLOUDFLARE_ACCOUNT'),
                env('CLOUDFLARE_KEY'),
                env('CLOUDFLARE_EMAIL')
            );
            //dd(time());
            $fileName = time() . '.' . $request->file->getClientOriginalExtension();

            $request->file->move(public_path('files'), $fileName);

            $url = env('APP_URL') . '/files/' . $fileName;

            $stream = $api->copy($url);

            /*
            if ($stream->preview){
                $file_d = public_path('files/' . $fileName);
                $delete_file =File::delete($file_d);
            }*/

            //dd($stream);
            //dd($delete_file, $file_d);
            return response()->json(['file' => $stream, 'filename' => $fileName]);

        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function uploadAvatar(Request $request)
    {
        //dd($request->all());
        $upload_path = public_path('files/avatar');
        $file_name = $request->file->getClientOriginalName();
        $generated_new_name = time() . '.' . $request->file->getClientOriginalExtension();

        $path = '/files/avatar/'.$generated_new_name;

        $user = User::find(auth()->id());
        //dd(auth()->id());
        $user->photo = $path;
        $user->save();

        $request->file->move($upload_path, $generated_new_name);

        return response()->json(['response' => true, 'path' => $path]);
    }


    public function storeFile($file)
    {
        $fileName = time() . Str::random(5) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('files'), $fileName);

        return '/files/' . $fileName;
    }
}
