<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function changeLogo(Request $request)
    {
        $request->validate([
            'image' => 'required|file',
        ]);

        $path = Storage::disk('public')->putFile('logos', $request->image);

        $user = auth()->user();
        $user->logo = $path;
        $user->save();
    }
}
