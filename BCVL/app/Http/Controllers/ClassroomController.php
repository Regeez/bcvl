<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classroom;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;


class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function insertStudent(Request $request, $classroomId, $studentId)
    {
        $classroom = Classroom::findOrFail($classroomId);
        $student = User::findOrFail($studentId);

        // Check if the student is already in the classroom
        if ($classroom->users->contains($student)) {
            return response()->json(['error' => 'The student is already in the classroom'], 400);
        }

        // Attach the student to the classroom
        $classroom->users()->attach($student);

        return response()->json(['message' => 'The student has been added to the classroom successfully']);
    }

    public function removeStudent(Request $request, $classroomId, $studentId)
    {
        $classroom = Classroom::findOrFail($classroomId);
        $student = User::findOrFail($studentId);

        // Check if the student is already in the classroom
        if (!$classroom->users->contains($student)) {
            return response()->json(['error' => 'The student is not in the classroom'], 400);
        }

        // Detach the student from the classroom
        $classroom->users()->detach($student);

        return response()->json(['message' => 'The student has been removed from the classroom successfully']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the form data
            $validatedData = $request->validate([
                'instructor_id' => 'required|integer',
                'subject' => 'required|string',
                'yearsec' => 'required|string',
            ]);

            // Create a new instance of your model and filter by user authenticated
            $class = new Classroom;

            // Fill the model with the validated data
            $class->fill($validatedData);

            // Save the model to the database
            $class->save();

            // Redirect or respond as needed
            return redirect()->route('home');
        } catch (\Exception $e) {
            // Log the exception for further investigation
            Log::error($e);

            // Redirect or respond as needed
            return redirect()->route('home');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
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
            $classAnnouncement = Announcement::where('classroom_id', $currentUrl)->orderByDesc('created_at')->get();

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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $classroom = Classroom::findOrFail($id);
        Announcement::where('classroom_id', $id)->delete();

        // Delete the classroom
        $classroom->delete();

        // Redirect back to the previous URL
        return redirect()->back()->with('success', 'Classroom deleted successfully.');
    }
}
