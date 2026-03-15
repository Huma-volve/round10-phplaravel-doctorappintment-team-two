<?php

namespace App\Http\Controllers\Admin;

use App\Models\FAQs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class FaqController
{

    public function index()
    {
        $faqs = FAQs::all();

        return view('Admin.list', compact('faqs'));
    }
    public function create()
    {


        $faqs =  FAQs::get();


        return view('Admin.Add', compact('faqs'));
    }

    public function store(Request $request)
    {
        try {

            $validated = $request->validate(FAQs::rules());

            $faq = FAQs::create($validated);
            return Redirect::route("faqs.index")->with("success", "FAQ created successfully");
        } catch (ValidationException $e) {

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    /**
     * تحديث FAQ
     */
    public function update(Request $request, $id)
    {
        $faq = FAQs::findOrFail($id);

        try {

            $validated = $request->validate(FAQs::rules());

            $faq->update($validated);

            return redirect()->back()->with('success', 'FAQ updated successfully');
        } catch (ValidationException $e) {

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }

   
    public function destroy($id)
    {
        $faq = FAQs::findOrFail($id);

        $faq->delete();

        return redirect()->back()->with('success', 'FAQ deleted successfully');
    }
}
