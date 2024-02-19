<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            // Get the authenticated user
            $user = Auth::user();
            $url = URL::current();
            $currentUrl = basename($url);

            // Access user data
            $userId = $user->id;

            $classes = Classroom::where('instructor_id', '=', $userId)
                ->orderByDesc('created_at')
                ->get();

            if ($user->role !== 'Instructor')
                $classes = auth()->user()->classrooms;


            $selectedClass = Classroom::where('id', '=', $currentUrl)->get();
            $classAnnouncement = Announcement::where('classroom_id', '=', $selectedClass);

            $results = [];
            return view(
                'home',
                compact(
                    'classes',
                    'currentUrl',
                    'selectedClass',
                    'userId',
                    'classAnnouncement',
                    'results'
                )
            );
        }
        return view('home');

    }
}
