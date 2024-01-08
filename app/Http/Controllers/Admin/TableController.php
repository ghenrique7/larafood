<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTable;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    private $repository;

    public function __construct(Table $table)
    {
        $this->repository = $table;

        $this->middleware(['can:tables']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = $this->repository->latest()->paginate();

        return view('admin.pages.tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.tables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateTable $request)
    {
        $this->repository->create($request->all());

        return redirect()->route('tables.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$table = $this->repository->find($id)) {
            return back();
        }

        return view('admin.pages.tables.show', compact('table'));
    }

    /**
     * Display the specified resource.
     */
    public function qrcode(string $identify)
    {
        if (!$table = $this->repository->where('identify', $identify)->first()) {
            return back();
        }

        $tenant = auth()->user()->tenant;

        $uri = env('URI_CLIENT') . "/{$tenant->uuid}/{$table->uuid}";

        return view('admin.pages.tables.qrcode', compact('table', 'uri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!$table = $this->repository->find($id)) {
            return back();
        }

        return view('admin.pages.tables.edit', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateTable $request, string $id)
    {
        if (!$table = $this->repository->find($id)) {
            return back();
        }

        $table->update($request->all());

        return redirect()->route('tables.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$table = $this->repository->find($id)) {
            return back();
        }

        $table->delete();

        return redirect()->route('tables.index');
    }

    public function search(Request $request)
    {
        $filters = $request->only('filter');

        $tables = $this->repository
            ->where(function ($query) use ($request) {
                if ($request->filter) {
                    $query->where('name', 'LIKE', "%{$request->filter}%");
                    $query->orWhere('description', 'LIKE', "%{$request->filter}%");
                }
            })
            ->latest()
            ->paginate();

        return view('admin.pages.tables.index', compact('tables', 'filters'));
    }
}
