<?php

namespace App\Http\Controllers\ACL;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePermission;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $repository;

    public function __construct(Permission $permission)
    {
        $this->repository = $permission;
    }

    public function index()
    {
        $permissions = $this->repository->latest()->paginate(5);
        return view('admin.pages.permissions.index', compact('permissions'));
    }

    public function show(string $id)
    {
        if (!$permission = $this->repository->find($id)) {
            return back()->with('error', 'Não foi possivel encontrar a permissão requerida.');
        }

        return view('admin.pages.permissions.show', compact('permission'));
    }

    public function create()
    {
        return view('admin.pages.permissions.create');
    }

    public function store(StoreUpdatePermission $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('permissions.index')->with('message', 'Permissão cadastrada com sucesso.');
    }

    public function edit(string $id)
    {
        if (!$permission = $this->repository->find($id)) {
            return back()->with('error', 'Permissão não encontrada');
        }

        return view('admin.pages.permissions.edit', compact('permission'));
    }

    public function update(StoreUpdatePermission $request, string $id)
    {
        if (!$permission = $this->repository->find($id)) {
            return back()->with('error', 'Permissão não encontrada');
        }

        $permission->update($request->all());

        return redirect()->route('permissions.index')->with('message', 'Permissão alterada com sucesso.');
    }

    public function destroy(string $id)
    {
        if (!$permission = $this->repository->find($id)) {
            return back()->with('error', 'Permissão não encontrada');
        }

        $permission->delete();

        return redirect()->route('permissions.index')->with('message', 'Permissão deletada com sucesso.');
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');

        $permissions = $this->repository
            ->where(function ($query) use ($request) {
                if ($request->filter) {
                    $query->where('name', 'LIKE', "%{$request->filter}%");
                    $query->orWhere('description', 'LIKE', "%{$request->filter}%");
                }
            })
            ->paginate();

        return view('admin.pages.permissions.index', compact('permissions', 'filters'));
    }
}
