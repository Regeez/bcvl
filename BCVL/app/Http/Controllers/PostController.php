<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $classroomId = $request->classroom_id;
        $content = $request->announcement;

        // Generate a random string for the file name
        $randomName = Str::random(10);

        // Get the file extension (if a file has been uploaded)
        $extension = '';
        $originalName = '';
        $filePath = '';
        if ($request->hasFile('file_input')) {
            // Get the file extension
            $extension = $request->file('file_input')->getClientOriginalExtension();

            $originalName = $request->file('file_input')->getClientOriginalName();

            // Combine the random string and file extension to get the final file name
            $fileName = $randomName . '.' . $extension;

            // Save the file to the public disk with the random name
            $path = Storage::disk('public')->put('uploads/' . $fileName, file_get_contents($request->file('file_input')));

            // Get the file path
            $filePath = asset('storage/uploads/' . $fileName);
        }

        // Save the file name, file type, and file path to the announcements table
        $announcement = new Announcement();
        $announcement->user_id = Auth::id();
        $announcement->classroom_id = $classroomId;
        $announcement->content = $content;
        $announcement->file_name = $originalName;
        $announcement->file_type = $extension ? $request->file('file_input')->getClientMimeType() : null;
        $announcement->file_path = $filePath;
        $announcement->save();

        // Flash a success message to the session
        session()->flash('success', 'Announcement created successfully');

        // Pass a new title to the view
        $title = "Created!";

        // Display the SweetAlert confirmation message
        session(['swalTitle' => $title]);

        // Redirect back to the previous URL
        return redirect()->back();

    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($request->input('announcementId'));

        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $announcement->update([
            'content' => $request->input('content'),
        ]);

        // Flash a success message to the session
        session()->flash('success', 'Announcement updated successfully');

        // Redirect back to the previous URL
        return redirect()->back()->with('title', "Updated!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $announcement = Announcement::findOrFail($id);

        if ($announcement->file_path) {
            // Extract the file path from the announcement file_path property
            $filePath = parse_url($announcement->file_path);
            $filePath = '/' . ltrim($filePath['path'], '/');

            // Delete the file associated with the announcement
            if (file_exists(public_path($filePath))) {
                try {
                    unlink(public_path($filePath));
                    echo "File deleted!";
                } catch (\Exception $e) {
                    echo "Error deleting file: " . $e->getMessage();
                    return redirect()->back()->with('error', 'Error deleting file.');
                }
            } else {
                echo "File does not exist.";
            }
        }

        // Delete the announcement
        if ($announcement->delete()) {
            echo "Announcement deleted!";
            session()->flash('success', 'Announcement deleted successfully');
            return redirect()->back()->with('title', "Deleted!");
        } else {
            echo "Error deleting announcement.";
            return redirect()->back()->with('error', 'Error deleting announcement.');
        }
    }
}
