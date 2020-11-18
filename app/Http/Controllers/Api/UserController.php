<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::get());
    }

    public function store(Request $request)
    {
        $user = new User;
        $user->role_id = $request->role;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = bcrypt($request->email);
        $user->save();
        return response()->json(['success' => 'New User has been added!']);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role_id = $request->role;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->save();
        return response()->json(['success' => 'User successfully Updated!']);
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();
        return response()->json(['success' => 'User successfully deleted!']);
    }
}
