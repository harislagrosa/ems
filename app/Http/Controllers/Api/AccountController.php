<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\User;

class AccountController extends Controller
{
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (password_verify($request->old_password, $user->password)) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8|max:255|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->getMessageBag()->toArray()]);
            }

            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json(['success' => 'Password successfully changed!']);
        }

        return response()->json(['error' => 'Your old password is incorrect!']);
    }
}
