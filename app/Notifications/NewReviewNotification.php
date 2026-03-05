<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Review;

class NewReviewNotification extends Notification
{
    protected $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'new_review',
            'title' => 'New review received',
            'body' => "{$this->review->patient->user->name}: {$this->review->rating}/5 stars",
            'rating' => $this->review->rating,
            'comment' => $this->review->comment,
            'patient_name' => $this->review->patient->user->name,
            'related_id' => $this->review->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'type' => 'new_review',
            'review_id' => $this->review->id,
            'rating' => $this->review->rating,
        ];
    }
}
