<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateDetailPlan;
use App\Models\DetailPlan;
use App\Models\Plan;

class DetailPlanController extends Controller
{

    protected $repository, $plan;

    public function __construct(DetailPlan $detailPlan, Plan $plan)

    {
        $this->repository = $detailPlan;
        $this->plan = $plan;
    }

    public function index(string $urlPlan)
    {

        if (!$plan = $this->plan->where('url', $urlPlan)->first()) {
            return back();
        }

        $details = $plan->details()->paginate(5);

        return view('admin.pages.plans.details.index', compact('plan', 'details'));
    }

    public function show(string $urlPlan, string $idDetail)
    {
        $plan = $this->plan->where('url', $urlPlan)->first();
        $detail = $this->repository->find($idDetail);

        if (!$plan || !$detail) {
            return back();
        }

        return view('admin.pages.plans.details.show', compact('plan', 'detail'));
    }

    public function create(string $urlPlan)
    {

        if (!$plan = $this->plan->where('url', $urlPlan)->first()) {
            return back();
        }

        return view('admin.pages.plans.details.create', compact('plan'));
    }

    public function store(StoreUpdateDetailPlan $request, string $urlPlan)
    {
        if (!$plan = $this->plan->where('url', $urlPlan)->first()) {
            return back();
        }

        $plan->details()->create($request->all());

        return redirect()->route('details.plans.index', $plan->url)->with('message', 'Registro adicionado com sucesso.');
    }

    public function edit(string $urlPlan, string $idDetail)
    {
        $plan = $this->plan->where('url', $urlPlan)->first();
        $detail = $this->repository->find($idDetail);

        if (!$plan || !$detail) {
            return back();
        }

        return view('admin.pages.plans.details.edit', compact('plan', 'detail'));
    }

    public function update(StoreUpdateDetailPlan $request, string $urlPlan, string $idDetail)
    {
        $plan = $this->plan->where('url', $urlPlan)->first();
        $detail = $this->repository->find($idDetail);


        if (!$plan || !$detail) {
            return back();
        }


        $detail->update($request->all());

        return redirect()->route('details.plans.index', $plan->url);
    }

    public function destroy(string $urlPlan, string $idDetail)
    {
        $plan = $this->plan->where('url', $urlPlan)->first();
        $detail = $this->repository->find($idDetail);

        if (!$plan || !$detail) {
            return back();
        }

        $detail->delete();

        return redirect()->route('details.plans.index', $plan->url)
            ->with('message', 'Registro deletado com sucesso!');
    }
}
