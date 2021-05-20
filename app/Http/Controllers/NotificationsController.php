<?php

namespace App\Http\Controllers;

use App\Cclass;
use App\Course;
use App\Meeting;
use Carbon\Carbon;
use Pusher\Pusher;
use App\Notification;
use App\Advertisement;
use Illuminate\Http\Request;
use App\Jobs\SedNotificationsInstructorDayly;
use App\Jobs\SedNotificationsParticipantsDayly;
use App\Http\Controllers\NotificationsController;
use App\Jobs\SedNotificationsInstructorEveryMinutes;
use App\Jobs\SendNotificationsParticipantsEveryFiveMinutes;

class NotificationsController extends Controller
{
    private static function set($time)
    {
        $date = Carbon::now()->addMinutes($time);
        $hour = $date->format('Y-m-d H:i');

        echo $hour;

        $classes = Cclass::with('participantes', 'instructor')->where('hour_start', $hour)->get();
        $meetings = Meeting::with('participants', 'user')->where('hour_start', $hour)->get();

        foreach ($classes as $clase) {
            dispatch(new SedNotificationsInstructorEveryMinutes($clase, $clase->instructor, 1, $time));
            foreach ($clase->participantes as $participant) {
                dispatch(new SendNotificationsParticipantsEveryFiveMinutes($clase, $participant, 1, $time));
            }
        }

        foreach ($meetings as $meeting) {
            dispatch(new SedNotificationsInstructorEveryMinutes($clase, $clase->user, 1, $time));
            foreach ($meeting->participants as $participant) {
                dispatch(new SendNotificationsParticipantsEveryFiveMinutes($meeting, $participant, 2, $time));
            }
        }
        return true;
    }

    public static function participantsEveryFiveMinutes ()
    {
        return self::set(5);
    }

    public static function participantsEveryThirtyMinutes()
    {
        return self::set(30);
    }

    public static function participantsHourly()
    {
        return self::set(60);
    }

    public static function participantsDayly()
    {
        $date = Carbon::now();
        $hour = $date->addDays(1)->format('Y-m-d H:i');

        $dateC = Carbon::now()->addDays(1);
        $dateF = $dateC->format('Y-m-d');

        $classes = Cclass::with('participantes', 'instructor')->where('hour_start', $hour)->get();
        $meetings = Meeting::with('participants', 'user')->where('hour_start', $hour)->get();
        $courses = Course::with('participantes', 'user')->where('date_start', $dateF)->get();

        // dd($hour, $classes, $meetings, $dateF,$courses);

        foreach ($classes as $clase) {
            dispatch(new SedNotificationsInstructorDayly($clase, $clase->instructor, 1));
            foreach ($clase->participantes as $participant) {
                dispatch(new SedNotificationsParticipantsDayly($clase, $participant, 1));
            }
        }

        foreach ($meetings as $meeting) {
            dispatch(new SedNotificationsInstructorDayly($meeting, $meeting->user, 1));
            foreach ($meeting->participants as $participant) {
                dispatch(new SedNotificationsParticipantsDayly($meeting, $participant, 2, 1));
            }
        }

        foreach ($courses as $course) {
            dispatch(new SedNotificationsInstructorDayly($course, $course->user, 1));
            foreach ($course->participantes as $particpant) {
                dispatch(new SedNotificationsParticipantsDayly($course, $participant, 3, 1));
            }
        }

        return true;
    }

    public static function changeStatetoAdvertisement()
    {
        $date = date('Y-m-d');

        $ads = Advertisement::where('to', $date)->where('state', 1)->get();

        foreach ($ads as $ad) {
            $adss = Advertisement::find($ad->id);
            $adss->status = 2;
            $adss->save();

            NotificationsController::sendNotificationToPusher(8);
        }


        return true;
    }

    public static function sendNotificationToPusher($type)
    {
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );

        //Remember to set your credentials below.
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'), $options
        );

        switch ($type) {
            case '1':
                $message= "Nueva Solicitud de Retiro";
                break;
            case '2':
                $message= "Nuevo Curso creado";
                break;
            case '3':
                $message= "Nueva Clase creada";
                break;
            case '4':
                $message= "Nueva Sesión creada";
                break;
            case '5':
                $message= "Nuevo Anuncio creado";
                break;
            case '6':
                $message= "Nuevo Mensaje de Centro de Ayuda";
                break;
            case '7':
                $message= "Nuevo Reporte de Usuario";
                break;
            case '8':
                $message= "Finalizo un anuncio";
                break;
            
            default:
                # code...
                break;
        }

        $data = [
            'type' => $type,
            'message' => $message
        ];

        $notification = new Notification;
        $notification->type = $type;
        $notification->message = $message;
        $notification->save();

        $pusher->trigger('my-channel', 'my-event', json_encode($data));

        return true;
    }
}
