<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function updateUsername(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->username = $request->input('username');
        $user->save();
    
        return response()->json(['message' => 'Username updated successfully'], 200);
    }
}
