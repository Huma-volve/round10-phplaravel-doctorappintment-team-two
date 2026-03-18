<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ReiewController extends Controller
{
    public function create()
    {


        $Review =  Review::latest()->first();


        return view('Admin.Review', compact('Review'));
    }

    public function store(Request $request)
    {
        try {

            $validated = $request->validate(Review::rules());

            $Review = Review::create($validated);
            return Redirect::route("faqs.index")->with("success", "Review created successfully");
        } catch (ValidationException $e) {

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }
}
