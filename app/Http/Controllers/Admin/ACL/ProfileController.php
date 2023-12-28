<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateProfile;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    protected $repository;

    public function __construct(Profile $profile)
    {
        $this->repository = $profile;

        $this->middleware(['can:profiles']);
    }


    public function index()
    {
        $profiles = $this->repository->paginate(5);

        return view('admin.pages.profiles.index', compact('profiles'));
    }

    public function show($id)
    {
        if (!$profile = $this->repository->find($id)) {
            return back();
        }

        return view('admin.pages.profiles.show', compact('profile'));
    }

    public function create()
    {
        return view('admin.pages.profiles.create');
    }

    public function store(StoreUpdateProfile $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('profiles.index');
    }

    public function edit(string $id)
    {
        if (!$profile = $this->repository->find($id)) {
            return back()->with('error', 'Perfil não foi encontrado.');
        }

        return view('admin.pages.profiles.edit', compact('profile'));
    }

    public function update(StoreUpdateProfile $request, string $id)
    {
        if (!$profile = $this->repository->find($id)) {
            return back()->with('error', 'Perfil não foi encontrado.');
        }

        $profile->update($request->all());

        return redirect()->route('profiles.index')->with('message', 'Perfil atualizado com sucesso.');
    }

    public function destroy(string $id) {
        if(!$profile = $this->repository->find($id)) {
            return back()->with('error', 'Perfil não foi encontrado.');
        }

        $profile->delete();

        return redirect()->route('profiles.index')->with('message', 'Perfil apagado com sucesso.');
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');

        $profiles = $this->repository
                         ->where(function($query) use($request) {
                            if($request->filter) {
                                $query->where('name', 'LIKE', "%{$request->filter}%");
                                $query->orWhere('description', 'LIKE', "%{$request->filter}%");
                            }
                         })
                         ->paginate();

        return view('admin.pages.profiles.index', compact('profiles', 'filters'));
    }
}
