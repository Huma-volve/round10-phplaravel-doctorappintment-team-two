<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Notifications\NotificationsReview as NotificationsNotificationsReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
    use TraitReview;
    public function index()
    {
        $review = Review::all();
        return $this->apiResponse($review, 'Categories fetched successfully', 200);
    }
    /**
     * Show single category
     */
    public function show($id)
    {
        $Review = Review::find($id);
        if ($Review) {
            return $this->apiresponse($Review, 'ok', 200);
        }
        return $this->apiresponse(null, 'not found', 401);
    }


    /**
     * Create a new category
     */
    public function store(Request $request)
    {

        try {
            $validated = $request->validate(Review::rules());



            $review = Review::create($validated);
            if ($review->doctor) {
                try {
                    $review->doctor->notify(new \App\Notifications\NotificationsReview($review->id));
                } catch (\Exception $e) {
                    // لو في خطأ في notify، هنعرضه بدل 500
                    return $this->apiresponse(null, "Notification error: " . $e->getMessage(), 500);
                }
            }

            return $this->apiresponse($review, "Review created successfully", 201);
        } catch (ValidationException $e) {
            return $this->apiresponse($e->errors(), 'Validation failed', 422);
        }
    }

    public function update(Request $request, $id)
    {
        $Review = Review::find($id);

        if (!$Review) {
            return $this->apiresponse(null, 'not found', 401);
        }

        try {
            $validated = $request->validate(Review::rules());



            $Review->update($validated);
            return $this->apiResponse($Review, 'Review updated successfully', 201);
        } catch (ValidationException $e) {


            return $this->apiResponse($e->errors(), 'Validation failed', 400);
        }
    }

    /**
     * Delete a category
     */
    public function destroy($id)
    {
        $Review = Review::find($id);

        if (!$Review) {
            return $this->apiresponse(null, 'Review not found', 401);
        }

        $Review->delete();
        return $this->apiresponse(null, 'Review deleted successfully', 200);
    }
}
