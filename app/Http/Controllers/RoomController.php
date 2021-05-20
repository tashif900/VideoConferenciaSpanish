<?php

namespace App\Http\Controllers;

use App\Meeting;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index($roomId)
    {
        // if ($roomId == '') {
        //     return abort(404);
        // }

        $meeting = Meeting::with('comments.user')->where('room_id', $roomId)->firstOrFail();

        if ($meeting == null) {
            
        }

        $jitsi_domain = env('JITSI_DOMAIN');
        $teacher = false;
        $toolBar = [
            'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
            'fodeviceselection', 'hangup', 'profile', 'chat', 'etherpad', 'settings', 'raisehand',
            'videoquality', 'filmstrip', 'shortcuts',
            'tileview', 'videobackgroundblur', 'download'];
        // if (auth()->user()->role_id == '2' || auth()->user()->role_id == '1') {
        //     $teacher = true;
        //     $toolBar = [
        //         'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
        //         'fodeviceselection', 'hangup', 'profile', 'info', 'chat', 'recording', 'etherpad', 'settings', 'raisehand',
        //         'videoquality', 'filmstrip', 'invite', 'feedback', 'stats', 'shortcuts',
        //         'tileview', 'videobackgroundblur', 'download', 'help', 'mute-everyone'];
        // }
        $header = json_encode([
            "kid" => "jitsi/custom_key_name",
            "typ" => "JWT",
            "alg" => "HS256"
        ], JSON_UNESCAPED_SLASHES);
        $base64urlheader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $avatar = '';
        $payload  = json_encode([
            "context" => [
            "user" => [
                "avatar" => $avatar,
                "name" => 'nombre',
                "email" => "",
                "id" => ""
            ],
            "group" => ""
            ],
            "aud" => "jitsi",
            "iss" => '',
            "sub" => $jitsi_domain,
            "room" => urlencode($meeting->room_id),
            "exp" => time() + 24 * 3600,
            "moderator" => $teacher
        
        ], JSON_UNESCAPED_SLASHES);
        $base64urlpayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        $secret = '';
        $signature = hash_hmac('sha256', $base64urlheader . "." . $base64urlpayload, $secret, true);
        $base64urlsignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        $jwt = $base64urlheader . "." . $base64urlpayload . "." . $base64urlsignature;
        $channelLastCam = -1;
        $domain = $jitsi_domain;
        $roomName = urlencode($meeting->name);

        return view('templates.room', compact('meeting', 'domain','channelLastCam','roomName', 'jwt','toolBar'));
    }
}
