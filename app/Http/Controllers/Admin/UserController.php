<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUser;
use Stringable;

class UserController extends Controller
{
    protected $repository;

    public function __construct(User $user)
    {
        $this->repository = $user;

        // $this->middleware('can:users'); Entender com o video
    }


    public function index()
    {
        $users = $this->repository->tenant()->paginate(5);

        return view('admin.pages.users.index', compact('users'));
    }

    public function show($id)
    {
        if (!$user = $this->repository->find($id)) {
            return back();
        }

        return view('admin.pages.users.show', compact('user'));
    }

    public function create()
    {
        return view('admin.pages.users.create');
    }

    public function store(StoreUpdateUser $request)
    {
        $data = $request->all();
        $data['tenant_id'] = auth()->user()->tenant_id;
        $data['password'] = bcrypt($data['password']);

        $this->repository->create($data);

        return redirect()->route('users.index');
    }

    public function edit(string $id)
    {
        if (!$user = $this->repository->find($id)) {
            return back()->with('error', 'Perfil não foi encontrado.');
        }

        return view('admin.pages.users.edit', compact('user'));
    }

    public function update(StoreUpdateUser $request, string $id)
    {
        if (!$user = $this->repository->find($id)) {
            return back()->with('error', 'Perfil não foi encontrado.');
        }

        $data = $request->only(['name', 'email']);

        if($request->has('password')) {
            $user->password = bcrypt($request['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('message', 'Perfil atualizado com sucesso.');
    }

    public function destroy(string $id)
    {
        if (!$user = $this->repository->find($id)) {
            return back()->with('error', 'Perfil não foi encontrado.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('message', 'Perfil apagado com sucesso.');
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');
        $users = $this->repository
            ->where(function ($query) use ($request) {
                if ($request->filter) {
                    $query->where('name', 'LIKE', "%{$request->filter}%");
                    $query->orWhere('email', 'LIKE', "%{$request->filter}%");
                }
            })
            ->paginate();

        return view('admin.pages.users.index', compact('users', 'filters'));
    }
}
