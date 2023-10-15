<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function create(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        return $role;
    }

    public function assign(Request $request)
    {
        $user = $request->user();   
        $role = Role::findByName($request->name,'web');  
        return $user->assignRole($role);       
    }

    public function userRole(Request $request){
        $user = $request->user()->with('roles');

    }
}
