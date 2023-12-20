<?php

namespace App\Http\Controllers\ACL;

use App\Http\Controllers\Controller;
use App\Models\Profile;

class ProfileController extends Controller
{

    protected $repository;

    public function __construct(Profile $profile)
    {
        $this->repository = $profile;

        // $this->middleware('can:profiles'); Entender com o video
    }


    public function index()
    {
        $profiles = $this->repository->paginate();

        return view('admin.pages.profiles.index', compact('profiles'));
    }

    public function show($id) {
        if(!$profile = $this->repository->find($id)) {
            return back();
        }

        return view('admin.pages.profiles.show', compact('profile'));
    }
}
