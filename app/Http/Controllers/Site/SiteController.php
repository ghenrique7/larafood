<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index() {

        $plans = Plan::with('details')->orderby('price', 'asc')->get();

        return view('site.pages.home.index', compact('plans'));
    }

    public function plan(string $url) {
        if(!$plan = Plan::where('url', $url)->first()) {
            return back()->with('error', 'A url passada não corresponde com nossos registros.');
        }

        session()->put('plan', $plan);

        return redirect()->route('register');
    }
}
