<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;

use App\Models\Role;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        return RoleResource::collection(Role::all());
    }

    public function store(Request $request)
    {
        $role = new Role;
        $role->role = $request->role;
        $role->description = $request->description;
        $role->save();
        return response()->json(['success' => 'New Role has been added!']);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->role = $request->role;
        $role->description = $request->description;
        $role->save();
        return response()->json(['success' => 'Role successfully Updated!']);

    }

    public function destroy(Request $request, Role $role)
    {
        $role->delete();
        return response()->json(['success' => 'Role successfully deleted!']);
    }
}
