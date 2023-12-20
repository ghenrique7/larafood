<?php

namespace App\Http\Controllers\Admin;



use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePlan;
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

    public function store(StoreUpdatePlan $request)
    {
        $this->repository->create($request->all());

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

    public function update(StoreUpdatePlan $request, string $url)
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
        $plan = $this->repository
                                ->with('details')
                                ->where('url', $url)
                                ->first();

        if (!$plan) {
            return back();
        }

        if($plan->details->count() > 0) {
            return back()->with('error', 'O plano possui detalhes atribuidos a ele. Não é possivel deletar o plano.');
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
