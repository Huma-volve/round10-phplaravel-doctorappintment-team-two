<?php

namespace App\Http\Controllers\Admin;

use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class PolicyController
{
    public function index()
    {
        $policies = Policy::all();

        return view('Admin.listPolicy', compact('policies'));
    }

    public function create()
    {
        return view('Admin.AddPolicy');
    }

    public function store(Request $request)
    {
        try {

            $validated = $request->validate(Policy::rules());

            Policy::create($validated);

            return redirect()->route("policies.index")
                ->with("success", "Policy created successfully");
        } catch (ValidationException $e) {

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $policy = Policy::findOrFail($id);

        try {

            $validated = $request->validate(Policy::rules());

            $policy->update($validated);

            return redirect()->back()
                ->with('success', 'Policy updated successfully');
        } catch (ValidationException $e) {

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $policy = Policy::findOrFail($id);

        $policy->delete();

        return redirect()->back()
            ->with('success', 'Policy deleted successfully');
    }
}
