<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    protected $user, $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;

        $this->middleware(['can:users']);
    }


    public function roles(string $id)
    {
        if (!$user =  $this->user->find($id)) {
            return back()->with('error', 'O cargo requisitado não foi encontrado.');
        }

        $roles = $user->roles()->paginate();

        return view('admin.pages.users.roles.roles', compact('user', 'roles'));
    }


    public function users(string $id)
    {
        if (!$role =  $this->role->find($id)) {
            return back()->with('error', 'O usuario requisitado não foi encontrado.');
        }

        $users = $role->users()->paginate();

        return view('admin.pages.roles.users.users', compact('users', 'role'));
    }

    public function rolesAvailable(Request $request, string $id)
    {
        if (!$user =  $this->user->find($id)) {
            return back()->with('error', 'O usuario requisitado não foi encontrado.');
        }

        $filters = $request->only('filter');

        $roles = $user->rolesAvailable($filters);

        return view('admin.pages.users.roles.available', compact('user', 'roles', 'filters'));
    }

    public function attachRolesUser(Request $request, string $id)
    {
        if (!$user =  $this->user->find($id)) {
            return back()->with('error', 'O perfil requisitado não foi encontrado.');
        }

        if (!$request->roles || count($request->roles) <= 0) {
            return back()->with('info', 'Selecione uma opção de vinculação.');
        }

        $user->roles()->attach($request->roles);

        return redirect()->route('users.roles', $user->id)->with('message', "Permissões vinculadas ao {$user->name} com sucesso.");
    }

    public function detachRolesUser(string $idUser, string $idRole,)
    {

        $user =  $this->user->find($idUser);
        $role =  $this->role->find($idRole);

        if (!$user || !$role) {
            return back()->with('error', 'O usuario ou cargo requisitados não foram encontrados.');
        }

        $user->roles()->detach($role);

        return redirect()->route('users.roles', $user->id)->with('message', "Cargos foram desvilculadas do {$user->name} com sucesso.");
    }
}
