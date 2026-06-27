<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::withCount('products')
            ->ordered()->paginate(20);

        return view('admin.features.index', compact('features'));
    }

    public function create()
    {
        return view('admin.features.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'slug'       => 'nullable|string|max:255|unique:features,slug',
            'type'       => 'required|in:text,boolean,select,multi_select',
            'options'    => 'nullable|json',
            'sort_order' => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);

        $data['slug'] ??= Str::slug($data['name']);
        $data['sort_order'] ??= 0;
        $data['is_active'] ??= true;

        if (in_array($data['type'], ['select', 'multi_select']) && empty($data['options'])) {
            return back()->withInput()->with('error', 'Options are required for Select and Multi-select feature types.');
        }

        Feature::create($data);

        return redirect()->route('admin.features.index')
            ->with('success', 'Feature created successfully.');
    }

    public function edit(Feature $feature)
    {
        return view('admin.features.form', compact('feature'));
    }

    public function update(Request $request, Feature $feature)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'slug'       => 'nullable|string|max:255|unique:features,slug,' . $feature->id,
            'type'       => 'required|in:text,boolean,select,multi_select',
            'options'    => 'nullable|json',
            'sort_order' => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);

        $data['slug'] ??= Str::slug($data['name']);
        $data['is_active'] ??= false;

        if (in_array($data['type'], ['select', 'multi_select']) && empty($data['options'])) {
            return back()->withInput()->with('error', 'Options are required for Select and Multi-select feature types.');
        }

        $feature->update($data);

        return redirect()->route('admin.features.index')
            ->with('success', 'Feature updated successfully.');
    }

    public function destroy(Feature $feature)
    {
        if ($feature->products()->count() > 0) {
            return back()->with('error', 'Cannot delete feature used by ' . $feature->products()->count() . ' product(s).');
        }

        $feature->delete();

        return redirect()->route('admin.features.index')
            ->with('success', 'Feature deleted successfully.');
    }
}
