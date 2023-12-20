<?php

namespace App\Http\Controllers\Admin;



use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{

    private $repository;

    public function __construct(Plan $plan)
    {
        $this->repository = $plan;
    }

    public function index()
    {
        $plans = $this->repository->oldest()->paginate();

        return view('admin.pages.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.pages.plans.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['url'] = Str::kebab($request->name);
        $this->repository->create($data);

        return redirect()->route('plans.index');
    }

    public function show(string $url)
    {
        $plan = $this->repository->where('url', $url)->first();

        if (!$plan) {
            return back();
        }

        return view('admin.pages.plans.show', compact('plan'));
    }

    public function edit(string $url)
    {
        $plan = $this->repository->where('url', $url)->first();

        if (!$plan) {
            return back();
        }

        return view('admin.pages.plans.edit', compact('plan'));
    }

    public function update(Request $request, string $url)
    {
        $plan = $this->repository->where('url', $url)->first();

        if (!$plan) {
            return back();
        }

        $plan->update($request->all());

        return redirect()->route('plans.index');
    }

    public function destroy(string $url)
    {
        $plan = $this->repository->where('url', $url)->first();

        if (!$plan) {
            return back();
        }

        $plan->delete();

        return redirect()->route('plans.index');
    }

    public function search(Request $request)
    {
        $filters = $request->except('_token');
        $plans = $this->repository->search($request->filter);

        return view('admin.pages.plans.index', compact('plans', 'filters'));
    }
}
