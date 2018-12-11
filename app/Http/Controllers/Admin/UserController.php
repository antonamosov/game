<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(User $user)
    {
        return view('admin.users.index', [
            'users' => $user->players()->get()
        ]);
    }
}
