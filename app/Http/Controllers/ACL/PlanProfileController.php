<?php

namespace App\Http\Controllers\ACL;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Profile;
use Illuminate\Http\Request;

class PlanProfileController extends Controller
{
    protected $plan, $profile;

    public function __construct(Plan $plan, Profile $profile)
    {
        $this->plan = $plan;
        $this->profile = $profile;
    }

    public function profiles(string $id)
    {
        if (!$plan = $this->plan->find($id)) {
            return back()->with('error', 'O plano não foi encontrado.');
        }

        $profiles = $plan->profiles()->paginate();

        return view('admin.pages.plans.profiles.profiles', compact('profiles', 'plan'));
    }

    public function plans(string $id)
    {
        if (!$profile = $this->profile->find($id)) {
            return back()->with('error', 'O plano não foi encontrado.');
        }

        $plans = $profile->plans()->paginate();

        return view('admin.pages.profiles.plans.plans', compact('profile', 'plans'));
    }

    public function profilesAvailable(Request $request, string $id)
    {
        if (!$plan =  $this->plan->find($id)) {
            return back()->with('error', 'O plano requisitado não foi encontrado.');
        }

        $filters = $request->only('filter');

        $profiles = $plan->profilesAvailable($filters);

        return view('admin.pages.plans.profiles.available', compact('profiles', 'plan', 'filters'));
    }

    public function attachProfilesPlan(Request $request, string $idPlan)
    {
        if (!$plan = $this->plan->find($idPlan)) {
            return back()->with('error', 'O plano requisitado não foi encontrado.');
        }

        if (!$request->profiles || count($request->profiles) <= 0) {
            return back()->with('info', 'Selecione uma opção de vinculação.');
        }

        $plan->profiles()->attach($request->profiles);

        return redirect()->route('plans.profiles', $plan->id)->with('message', "Perfis vinculados ao {$plan->name} com sucesso.");
    }

    public function detachProfilesPlan(Request $request, string $idPlan, string $idProfile)
    {
        $plan = $this->plan->find($idPlan);
        $profile = $this->profile->find($idProfile);

        if (!$plan || !$profile) {
            return back()->with('error', 'O plano ou perfil requisitados não foram encontrados.');
        }

        $plan->profiles()->detach($profile);

        return redirect()->route('plans.profiles', $plan->id)->with('message', "Perfil {$profile->name} desvinculado com sucesso.");
    }
}
