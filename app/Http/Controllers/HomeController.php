<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as HTTPRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class HomeController extends Controller
{
    public function index(HTTPRequest $request)
    {
        if (Auth::check()) {
            $user = [
                'name' => $request->user()->name,
                'email' => $request->user()->email,
            ];
        } else {
            $user = null;
        }

        if (Cache::has('users')) {
            $users = Cache::get('users');
            $cache = 'HIT';
        } else {
            $users = User::all();
            Cache::put('users', $users, 60);
            // $users = Cache::remember('users', 60, function () {
            //     return User::all();
            // });
            $cache = 'No-HIT';
        }

        return response()->json(['user' => $user, 'data' => $users, 'cache' => $cache]);
    }
}
