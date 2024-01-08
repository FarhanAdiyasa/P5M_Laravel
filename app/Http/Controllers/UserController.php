<?php

namespace App\Http\Controllers;

use App\Models\User; // Import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreUserRequest; // Adjust based on your form requests
use App\Http\Requests\UpdateUserRequest; // Adjust based on your form requests

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan jenis pengurutan dari query string, defaultnya adalah asc
        $sortType = $request->query('sort', 'asc');

        // Validasi jenis pengurutan untuk memastikan hanya menerima 'asc' atau 'desc'
        if (!in_array($sortType, ['asc', 'desc'])) {
            abort(400, 'Invalid sort type. Use "asc" or "desc".');
        }

        // Melakukan query users dengan pengurutan berdasarkan ID
        $users = User::orderBy('id', $sortType)->get();

        // Mengirimkan data ke view
        return view('users.index', ['users' => $users, 'sortType' => $sortType]);
    }

 
}
