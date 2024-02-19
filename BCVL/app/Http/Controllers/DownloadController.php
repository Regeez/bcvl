<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Announcement;

class DownloadController extends Controller
{
    public function download($id)
    {
        // Get the announcement by its ID
        $announcement = Announcement::findOrFail($id);

        // Get the file path from the announcement
        $filePath = parse_url($announcement->file_path);
        $filePath = '/' . ltrim($filePath['path'], '/');

        // Get the file name from the announcement
        $fileName = $announcement->file_name;

        // Return the download response
        return response()->download(public_path($filePath), $fileName);
    }
}
