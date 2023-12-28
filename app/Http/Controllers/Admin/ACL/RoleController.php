<?php

namespace App\Http\Controllers\Admin\ACL;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateRole;
use App\Models\Role;

class RoleController extends Controller
{
    protected $repository;

    public function __construct(Role $role)
    {
        $this->repository = $role;

        $this->middleware(['can:roles']);
    }


    public function index()
    {
        $roles = $this->repository->paginate(5);

        return view('admin.pages.roles.index', compact('roles'));
    }

    public function show($id)
    {
        if (!$role = $this->repository->find($id)) {
            return back();
        }

        return view('admin.pages.roles.show', compact('role'));
    }

    public function create()
    {
        return view('admin.pages.roles.create');
    }

    public function store(StoreUpdateRole $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('roles.index');
    }

    public function edit(string $id)
    {
        if (!$role = $this->repository->find($id)) {
            return back()->with('error', 'Perfil não foi encontrado.');
        }

        return view('admin.pages.roles.edit', compact('role'));
    }

    public function update(StoreUpdateRole $request, string $id)
    {
        if (!$role = $this->repository->find($id)) {
            return back()->with('error', 'Perfil não foi encontrado.');
        }

        $role->update($request->all());

        return redirect()->route('roles.index')->with('message', 'Perfil atualizado com sucesso.');
    }

    public function destroy(string $id)
    {
        if (!$role = $this->repository->find($id)) {
            return back()->with('error', 'Perfil não foi encontrado.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('message', 'Perfil apagado com sucesso.');
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');

        $roles = $this->repository
            ->where(function ($query) use ($request) {
                if ($request->filter) {
                    $query->where('name', 'LIKE', "%{$request->filter}%");
                    $query->orWhere('description', 'LIKE', "%{$request->filter}%");
                }
            })
            ->paginate();

        return view('admin.pages.roles.index', compact('roles', 'filters'));
    }
}
