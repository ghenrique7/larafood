<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateTenant;

class TenantController extends Controller
{
    private $repository;

    public function __construct(Tenant $tenant)
    {
        $this->repository = $tenant;

        $this->middleware(['can:tenants']);
    }

    public function index()
    {
        $tenants = $this->repository->latest()->paginate();

        return view('admin.pages.tenants.index', compact('tenants'));
    }

    public function show(string $id)
    {
        if (!$tenant = $this->repository->find($id)) {
            return back();
        }

        return view('admin.pages.tenants.show', compact('tenant'));
    }

    public function edit(string $id)
    {
        if (!$tenant = $this->repository->find($id)) {
            return back();
        }

        return view('admin.pages.tenants.edit', compact('tenant'));
    }

    public function update(UpdateTenant $request, string $id)
    {
        if (!$tenant = $this->repository->find($id)) {
            return back();
        }

        $data = $request->all();

        if ($request->hasFile('logo') && $request->logo->isValid()) {

            if ($tenant->logo) {
                Storage::delete($tenant->logo);
            }

            $data['logo'] = $request->logo->store("tenants/{$tenant->uuid}");
        }

        $tenant->update($data);

        return redirect()->route('tenants.index');
    }

    public function destroy(string $id)
    {
        if (!$tenant = $this->repository->find($id)) {
            return back();
        }

        if (Storage::exists($tenant->logo)) {
            Storage::delete($tenant->logo);
        }


        $tenant->delete();

        return redirect()->route('tenants.index');
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');

        $tenants = $this->repository
            ->where(function ($query) use ($request) {
                if ($request->filter) {
                    $query->where('name', 'LIKE', "%{$request->filter}%");
                    $query->orWhere('email', 'LIKE', "%{$request->filter}%");
                }
            })
            ->latest()
            ->paginate();

        return view('admin.pages.tenants.index', compact('tenants', 'filters'));
    }
}
