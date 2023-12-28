<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfilePermissionController extends Controller
{
    protected $profile, $permission;

    public function __construct(Profile $profile, Permission $permission)
    {
        $this->profile = $profile;
        $this->permission = $permission;

        $this->middleware(['can:permissions']);

    }


    public function permissions(string $id)
    {
        if (!$profile =  $this->profile->find($id)) {
            return back()->with('error', 'O perfil requisitado não foi encontrado.');
        }

        $permissions = $profile->permissions()->paginate();

        return view('admin.pages.profiles.permissions.permissions', compact('profile', 'permissions'));
    }


    public function profiles(string $id)
    {
        if (!$permission =  $this->permission->find($id)) {
            return back()->with('error', 'A permissão requisitada não foi encontrada.');
        }

        $profiles = $permission->profiles()->paginate();

        return view('admin.pages.permissions.profiles.profiles', compact('profiles', 'permission'));
    }

    public function permissionsAvailable(Request $request, string $id)
    {
        if (!$profile =  $this->profile->find($id)) {
            return back()->with('error', 'O perfil requisitado não foi encontrado.');
        }

        $filters = $request->only('filter');

        $permissions = $profile->permissionsAvailable($filters);

        return view('admin.pages.profiles.permissions.available', compact('profile', 'permissions', 'filters'));
    }

    public function attachPermissionsProfile(Request $request, string $id)
    {
        if (!$profile =  $this->profile->find($id)) {
            return back()->with('error', 'O perfil requisitado não foi encontrado.');
        }

        if (!$request->permissions || count($request->permissions) <= 0) {
            return back()->with('info', 'Selecione uma opção de vinculação.');
        }

        $profile->permissions()->attach($request->permissions);

        return redirect()->route('profiles.permissions', $profile->id)->with('message', "Permissões vinculadas ao {$profile->name} com sucesso.");
    }

    public function detachPermissionsProfile(string $idProfile, string $idPermission)
    {

        $profile =  $this->profile->find($idProfile);
        $permission =  $this->permission->find($idPermission);

        if (!$profile || !$permission) {
            return back()->with('error', 'O perfil ou permissão requisitados não foram encontrados.');
        }

        $profile->permissions()->detach($permission);

        return redirect()->route('profiles.permissions', $profile->id)->with('message', "Permissões foram desvilculadas do {$profile->name} com sucesso.");
    }
}
