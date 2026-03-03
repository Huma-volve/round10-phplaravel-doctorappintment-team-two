<?php

namespace App\Services;

use App\Models\User;
use App\Models\Appointment;
use App\Models\Review;
use App\Models\Message;
use App\Models\Payment;
use App\Notifications\AppointmentCreatedNotification;
use App\Notifications\AppointmentCancelledNotification;
use App\Notifications\AppointmentRescheduledNotification;
use App\Notifications\NewBookingNotification;
use App\Notifications\NewReviewNotification;
use App\Notifications\NewChatMessageNotification;
use App\Notifications\PaymentReceivedNotification;
use App\Notifications\AdminSystemAlertNotification;
use App\Notifications\BroadcastNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    /**
     *  send appointment created notification to patient
     * @param Appointment $appointment
     */
    public function sendAppointmentCreatedNotification(Appointment $appointment)
    {
        try {
            $patient = $appointment->patient->user;
            $notification = new AppointmentCreatedNotification($appointment);
            $patient->notify($notification);

            Log::info("Appointment created notification sent to patient {$patient->id}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send appointment notification: " . $e->getMessage());
            return false;
        }
    }

    /**
     *  send appointment cancelled notification to patient
     * @param Appointment $appointment
     */
    public function sendAppointmentCancelledNotification(Appointment $appointment)
    {
        try {
            $patient = $appointment->patient->user;
            $notification = new AppointmentCancelledNotification($appointment);
            $patient->notify($notification);

            Log::info("Appointment cancelled notification sent to patient {$patient->id}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send cancellation notification: " . $e->getMessage());
            return false;
        }
    }

    /**
     *  send appointment rescheduled notification to patient
     * @param Appointment $appointment
     * @param $oldTime
     */
    public function sendAppointmentRescheduledNotification(Appointment $appointment, $oldTime)
    {
        try {
            $patient = $appointment->patient->user;
            $notification = new AppointmentRescheduledNotification($appointment, $oldTime);
            $patient->notify($notification);

            Log::info("Appointment rescheduled notification sent to patient {$patient->id}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send reschedule notification: " . $e->getMessage());
            return false;
        }
    }

    /**
     *  send new booking notification to doctor
     * @param Appointment $appointment
     */
    public function sendNewBookingNotification(Appointment $appointment)
    {
        try {
            $doctor = $appointment->doctor->user;
            $notification = new NewBookingNotification($appointment);
            $doctor->notify($notification);

            Log::info("New booking notification sent to doctor {$doctor->id}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send booking notification: " . $e->getMessage());
            return false;
        }
    }

    /**
     *  send new review notification to doctor
     * @param Review $review
     */
    public function sendNewReviewNotification(Review $review)
    {
        try {
            $doctor = $review->doctor->user;
            $notification = new NewReviewNotification($review);
            $doctor->notify($notification);

            Log::info("New review notification sent to doctor {$doctor->id}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send review notification: " . $e->getMessage());
            return false;
        }
    }

    /**
     *  send new chat message notification
     * @param Message $message
     */
    public function sendChatMessageNotification(Message $message)
    {
        try {
            $chat = $message->chat;

            $currentUserId = Auth::id();
            if ($currentUserId && $currentUserId === $chat->patient->user_id) {
                $recipient = $chat->doctor->user;
            } else {
                $recipient = $chat->patient->user;
            }

            $notification = new NewChatMessageNotification($message);
            $recipient->notify($notification);

            Log::info("Chat message notification sent to user {$recipient->id}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send chat notification: " . $e->getMessage());
            return false;
        }
    }

    /**
     *  send payment received notification to doctor
     * @param Payment $payment
     */
    public function sendPaymentReceivedNotification(Payment $payment)
    {
        try {
            $doctor = $payment->appointment->doctor->user;
            $notification = new PaymentReceivedNotification($payment);
            $doctor->notify($notification);

            Log::info("Payment notification sent to doctor {$doctor->id}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send payment notification: " . $e->getMessage());
            return false;
        }
    }

    /**
     *  send system alert to admin
     * @param $title
     * @param $message
     * @param string $severity
     */
    public function sendAdminAlert($title, $message, $severity = 'info')
    {
        try {
            $admins = User::where('role', 'admin')->get();

            foreach ($admins as $admin) {
                $notification = new AdminSystemAlertNotification($title, $message, $severity);
                $admin->notify($notification);
            }

            Log::info("Admin alert sent: {$title} | Severity: {$severity}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send admin alert: " . $e->getMessage());
            return false;
        }
    }

    /**
     *  send broadcast notification from admin
     * @param $title
     * @param $message
     * @param array $targetRoles
     */
    public function sendBroadcastNotification($title, $message, $targetRoles = ['all'])
    {
        try {
            $query = User::query();

            if (!in_array('all', $targetRoles)) {
                $query->whereIn('role', $targetRoles);
            }

            $users = $query->get();

            foreach ($users as $user) {
                $notification = new BroadcastNotification($title, $message, $targetRoles);
                $user->notify($notification);
            }

            Log::info("Broadcast notification sent to " . count($users) . " users: {$title}");
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to send broadcast notification: " . $e->getMessage());
            return false;
        }
    }

    /**
     * delete old notifications that are older than specified days
     * @param int $days
     */
    public function deleteOldNotifications($days = 30)
    {
        try {
            $deleted = DB::table('notifications')
                ->where('created_at', '<', now()->subDays($days))
                ->delete();

            Log::info("Deleted {$deleted} old notifications");
            return $deleted;
        } catch (\Exception $e) {
            Log::error("Failed to delete old notifications: " . $e->getMessage());
            return false;
        }
    }

    /**
     * get notification statistics for admin dashboard
     */
    public function getNotificationStats()
    {
        try {
            return [
                'total' => DB::table('notifications')->count(),
                'today' => DB::table('notifications')->whereDate('created_at', today())->count(),
                'this_month' => DB::table('notifications')->whereMonth('created_at', now()->month)->count(),
                'unread_count' => DB::table('notifications')->where('is_read', false)->count(),
                'by_type' => DB::table('notifications')
                    ->groupBy('type')
                    ->selectRaw('type, count(*) as count')
                    ->get(),
            ];
        } catch (\Exception $e) {
            Log::error("Failed to get notification stats: " . $e->getMessage());
            return [];
        }
    }
}
