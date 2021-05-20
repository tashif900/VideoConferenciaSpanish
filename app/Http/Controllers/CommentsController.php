<?php

namespace App\Http\Controllers;

use App\Cclass;
use App\Course;
use App\Comment;
use App\Meeting;
use Illuminate\Http\Request;
use App\Http\Resources\CommentCollection;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        if ($request->has('meeting')) {
            $meeting = Meeting::find($request->meeting);
            $comment = new Comment;
            $comment->comment = $request->comment;
            $comment->user_id = auth()->user()->id;
            $comment->instructor_id = $meeting->user_id;
            $comment->meeting_id = $request->meeting;
            
        }
        if ($request->has('course')) {
            $meeting = Course::find($request->course);
            $comment = new Comment;
            $comment->comment = $request->comment;
            $comment->user_id = auth()->user()->id;
            $comment->instructor_id = $meeting->user_id;
            $comment->course_id = $request->course;
        }
        if ($request->has('clase')) {
            $meeting = Cclass::find($request->clase);
            $comment = new Comment;
            $comment->comment = $request->comment;
            $comment->user_id = auth()->user()->id;
            $comment->instructor_id = $meeting->user_id;
            $comment->class_id = $request->clase;
        }
        $comment->save();

        return response()->json(true);
    }

    public function getComments(Request $request)
    {
        if ($request->has('meeting')) {
            $comments = Comment::with('user')->where('meeting_id', $request->meeting)->orderBy('created_at', 'desc')->get();
        }
        if ($request->has('course')) {
            $comments = Comment::where('course_id', $request->course)->orderBy('created_at', 'desc')->get();
        }
        if ($request->has('clase')) {
            $comments = Comment::where('class_id', $request->clase)->orderBy('created_at', 'desc')->get();
        }

        return response()->json(new CommentCollection($comments));
    }

    public function getCommentsByInstructor(Request $request)
    {
        $comments = Comment::with('user')->where('instructor_id', $request->id)->orderBy('created_at', 'desc')->take(5)->get();

        return response()->json(new CommentCollection($comments));
    }
}
