<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;

class RolePermissionController extends Controller
{
    protected $role, $permission;

    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;

        $this->middleware(['can:permissions']);

    }


    public function permissions(string $id)
    {
        if (!$role =  $this->role->find($id)) {
            return back()->with('error', 'O cargo requisitado não foi encontrado.');
        }

        $permissions = $role->permissions()->paginate();

        return view('admin.pages.roles.permissions.permissions', compact('role', 'permissions'));
    }


    public function roles(string $id)
    {
        if (!$permission =  $this->permission->find($id)) {
            return back()->with('error', 'A permissão requisitada não foi encontrada.');
        }

        $roles = $permission->roles()->paginate();

        return view('admin.pages.permissions.roles.roles', compact('roles', 'permission'));
    }

    public function permissionsAvailable(Request $request, string $id)
    {
        if (!$role =  $this->role->find($id)) {
            return back()->with('error', 'O perfil requisitado não foi encontrado.');
        }

        $filters = $request->only('filter');

        $permissions = $role->permissionsAvailable($filters);

        return view('admin.pages.roles.permissions.available', compact('role', 'permissions', 'filters'));
    }

    public function attachPermissionsRole(Request $request, string $id)
    {
        if (!$role =  $this->role->find($id)) {
            return back()->with('error', 'O perfil requisitado não foi encontrado.');
        }

        if (!$request->permissions || count($request->permissions) <= 0) {
            return back()->with('info', 'Selecione uma opção de vinculação.');
        }

        $role->permissions()->attach($request->permissions);

        return redirect()->route('roles.permissions', $role->id)->with('message', "Permissões vinculadas ao {$role->name} com sucesso.");
    }

    public function detachPermissionsRole(string $idRole, string $idPermission)
    {

        $role =  $this->role->find($idRole);
        $permission =  $this->permission->find($idPermission);

        if (!$role || !$permission) {
            return back()->with('error', 'O perfil ou permissão requisitados não foram encontrados.');
        }

        $role->permissions()->detach($permission);

        return redirect()->route('roles.permissions', $role->id)->with('message', "Permissões foram desvilculadas do {$role->name} com sucesso.");
    }
}
