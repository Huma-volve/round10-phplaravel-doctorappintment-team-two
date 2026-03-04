<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    protected $notificationService;

    /**
     * Constructor
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
        $this->middleware('auth');
    }

    /**ض    
     * Get all notifications
     * GET /api/notifications
     * 
     * Query Parameters:
     * - unread=true (get unread only)
     * - type=appointment_created (filter by type)
     * - per_page=15 (pagination)
     * - sort_by=created_at (sort field)
     * - sort_order=desc (asc/desc)
     */
    public function index(Request $request)
    {
        try {
            $user = auth()->user();

            $query = $user->notifications();

            // Filter by unread
            if ($request->has('unread') && $request->unread === 'true') {
                $query->where('is_read', false);
            }

            // Filter by type
            if ($request->has('type') && $request->type !== null) {
                $query->where('type', $request->type);
            }

            // Sort
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Paginate
            $perPage = $request->get('per_page', 15);
            $notifications = $query->paginate($perPage);

            return response()->json([
                'status' => 'success',
                'data' => $notifications->items(),
                'pagination' => [
                    'total' => $notifications->total(),
                    'per_page' => $notifications->perPage(),
                    'current_page' => $notifications->currentPage(),
                    'last_page' => $notifications->lastPage(),
                ],
                'meta' => [
                    'unread_count' => $user->unreadNotificationsCount(),
                    'total_count' => $user->notifications()->count(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a single notification
     * GET /api/notifications/{id}
     */
    public function show($id)
    {
        try {
            $notification = DB::table('notifications')
                ->where('id', $id)
                ->where('user_id', auth()->id())
                ->first();

            if (!$notification) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Notification not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $notification,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark notification as read
     * PUT /api/notifications/{id}/read
     */
    public function markAsRead($id)
    {
        try {
            $updated = DB::table('notifications')
                ->where('id', $id)
                ->where('user_id', auth()->id())
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                ]);

            if (!$updated) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Notification not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Notification marked as read',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to mark notification as read',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark all notifications as read
     * PUT /api/notifications/mark-all-as-read
     */
    public function markAllAsRead()
    {
        try {
            auth()->user()->markAllNotificationsAsRead();

            return response()->json([
                'status' => 'success',
                'message' => 'All notifications marked as read',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to mark all notifications as read',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a notification
     * DELETE /api/notifications/{id}
     */
    public function destroy($id)
    {
        try {
            $deleted = DB::table('notifications')
                ->where('id', $id)
                ->where('user_id', auth()->id())
                ->delete();

            if (!$deleted) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Notification not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Notification deleted',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete all read notifications
     * DELETE /api/notifications/clear-read
     */
    public function clearReadNotifications()
    {
        try {
            $count = DB::table('notifications')
                ->where('user_id', auth()->id())
                ->where('is_read', true)
                ->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Read notifications cleared',
                'deleted_count' => $count,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to clear notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get notification statistics
     * GET /api/notifications/stats
     */
    public function stats()
    {
        try {
            $user = auth()->user();

            $totalCount = $user->notifications()->count();
            $unreadCount = $user->unreadNotificationsCount();
            $readCount = $user->notifications()->where('is_read', true)->count();

            $byType = $user->notifications()
                ->groupBy('type')
                ->selectRaw('type, count(*) as count')
                ->pluck('count', 'type');

            return response()->json([
                'status' => 'success',
                'data' => [
                    'total' => $totalCount,
                    'unread' => $unreadCount,
                    'read' => $readCount,
                    'by_type' => $byType,
                    'unread_percentage' => $totalCount > 0 ? round(($unreadCount / $totalCount) * 100, 2) : 0,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get notifications by type
     * GET /api/notifications/type/{type}
     */
    public function getByType($type, Request $request)
    {
        try {
            $notifications = auth()->user()->notifications()
                ->where('type', $type)
                ->paginate($request->get('per_page', 15));

            return response()->json([
                'status' => 'success',
                'data' => $notifications->items(),
                'pagination' => [
                    'total' => $notifications->total(),
                    'per_page' => $notifications->perPage(),
                    'current_page' => $notifications->currentPage(),
                    'last_page' => $notifications->lastPage(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch notifications by type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get unread count
     * GET /api/notifications/unread-count
     */
    public function getUnreadCount()
    {
        try {
            $count = auth()->user()->unreadNotificationsCount();

            return response()->json([
                'status' => 'success',
                'unread_count' => $count,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch unread count',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk mark as read
     * POST /api/notifications/bulk-read
     */
    public function bulkMarkAsRead(Request $request)
    {
        try {
            $validated = $request->validate([
                'notification_ids' => 'required|array',
                'notification_ids.*' => 'integer',
            ]);

            $updated = DB::table('notifications')
                ->where('user_id', auth()->id())
                ->whereIn('id', $validated['notification_ids'])
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                ]);

            return response()->json([
                'status' => 'success',
                'message' => "Marked {$updated} notifications as read",
                'updated_count' => $updated,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to bulk mark notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete
     * POST /api/notifications/bulk-delete
     */
    public function bulkDelete(Request $request)
    {
        try {
            $validated = $request->validate([
                'notification_ids' => 'required|array',
                'notification_ids.*' => 'integer',
            ]);

            $deleted = DB::table('notifications')
                ->where('user_id', auth()->id())
                ->whereIn('id', $validated['notification_ids'])
                ->delete();

            return response()->json([
                'status' => 'success',
                'message' => "Deleted {$deleted} notifications",
                'deleted_count' => $deleted,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to bulk delete notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search notifications
     * POST /api/notifications/search
     */
    public function search(Request $request)
    {
        try {
            $validated = $request->validate([
                'keyword' => 'required|string|min:2',
                'type' => 'nullable|string',
                'is_read' => 'nullable|boolean',
            ]);

            $query = auth()->user()->notifications()
                ->where(function ($q) use ($validated) {
                    $q->where('title', 'LIKE', '%' . $validated['keyword'] . '%')
                        ->orWhere('body', 'LIKE', '%' . $validated['keyword'] . '%');
                });

            if ($request->has('type') && $request->type !== null) {
                $query->where('type', $request->type);
            }

            if ($request->has('is_read') && $request->is_read !== null) {
                $query->where('is_read', $request->is_read);
            }

            $notifications = $query->paginate($request->get('per_page', 15));

            return response()->json([
                'status' => 'success',
                'data' => $notifications->items(),
                'pagination' => [
                    'total' => $notifications->total(),
                    'per_page' => $notifications->perPage(),
                    'current_page' => $notifications->currentPage(),
                    'last_page' => $notifications->lastPage(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to search notifications',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
