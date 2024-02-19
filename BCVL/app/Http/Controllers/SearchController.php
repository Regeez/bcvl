<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        $results = User::where('name', 'like', "%{$query}%")
            ->where('role', 'like', 'student')
            ->get();

        return response()->json($results);
    }
}
