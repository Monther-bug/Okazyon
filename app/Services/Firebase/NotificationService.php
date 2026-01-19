<?php

namespace App\Services\Firebase;
use App\Models\Notification;
use App\Models\User;
use App\Models\FcmToken;
use App\Models\Order;
use App\Utility\Enums\NotificationTypeEnum;
use App\Utility\Enums\NotificationStatusEnum;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected Messaging $messaging;
    public function __construct()
    {
        $this->initializeFirebase();
    }

    protected function initializeFirebase()
    {
        $credentialsPath = env('FIREBASE_CREDENTIALS');
        if (file_exists($credentialsPath)) {
            $this->messaging = (new \Kreait\Firebase\Factory())
                ->withServiceAccount($credentialsPath)
                ->createMessaging();
        } else {
            throw new \Exception("Firebase credentials file not found at: {$credentialsPath}");
        }
    }

    public function sendToUsers(array $userIds, Notification $notification)
    {
        $users = User::whereIn('id', $userIds)->with('fcmTokens')->get();

        $allTokens = $users->flatMap(function ($user) {
            return $user->fcmTokens;
        })->unique('token');

        $responses = [];

        if ($allTokens->isNotEmpty()) {
            foreach ($allTokens as $tokenModel) {
                if (empty($tokenModel->token)) {
                    Log::warning("Skipping notification due to empty token for user ID: {$tokenModel->user_id}");
                    continue;
                }
                try {
                    $message = CloudMessage::new()
                        ->withNotification([
                            'title' => $notification->title,
                            'body' => $notification->body,
                        ])
                        ->withDefaultSounds()
                        ->toToken($tokenModel->token);

                    Log::info("Attempting to send notification via FCM to token for user ID: {$tokenModel->user_id} (Device Type: {$tokenModel->device_type})");
                    $response = $this->messaging->send($message);
                    $responses[$tokenModel->device_type][] = $response;
                    Log::info("Successfully sent notification via FCM to user ID: {$tokenModel->user_id}");

                } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
                    Log::error("FCM token not found or unregistered for user ID {$tokenModel->user_id} (device type: {$tokenModel->device_type}): " . $e->getMessage());
                    $tokenModel->delete(); // Cleanup invalid tokens
                } catch (\Kreait\Firebase\Exception\Messaging\InvalidMessage $e) {
                    Log::error("Invalid FCM message for user ID {$tokenModel->user_id} (device type: {$tokenModel->device_type}): " . $e->getMessage());
                } catch (\Kreait\Firebase\Exception\MessagingException $e) {
                    Log::error("Firebase Messaging Exception for user ID {$tokenModel->user_id} (device type: {$tokenModel->device_type}): " . $e->getMessage());
                } catch (\Exception $e) {
                    Log::error("Generic error sending notification to user ID {$tokenModel->user_id} (device type: {$tokenModel->device_type}): " . $e->getMessage());
                }
            }
        }
        return $responses;
    }


    /**
     * Sends a notification to everyone subscribed to a specific topic.
     *
     * @param string $topic
     * @param string $title
     * @param string $body
     */
    public function sendToTopic(string $topic, Notification $notification)
    {
        $message = CloudMessage::new()
            ->withNotification([
                'title' => $notification->title,
                'body' => $notification->body,
            ])->toTopic($topic);

        $this->messaging->send($message);
    }


    public function subscribeUsersToTopic(array $userIds, string $topic)
    {
        $users = User::whereIn('id', $userIds)->with('fcmTokens')->get();

        $allTokens = $users->flatMap(function ($user) {
            return $user->fcmTokens->pluck('token');
        })->unique()->toArray();

        if (!empty($allTokens)) {
            $this->messaging->subscribeToTopic($topic, $allTokens);
        }
    }

    public function send(Notification $notification)
    {
        if ($notification->target_type === NotificationTypeEnum::ALL) {
            $this->sendToTopic('all', $notification);
        } elseif ($notification->target_type === NotificationTypeEnum::SPECIFIC_USER) {
            $this->sendToUsers([$notification->target_id], $notification);
        }
    }

    /**
     * Notify user about order status update.
     */
    public function notifyOrderStatusUpdate(Order $order)
    {
        $statusMessages = [
            'processing' => [
                'en' => "Your order #{$order->id} is being processed",
                'ar' => "طلبك رقم #{$order->id} قيد التنفيذ",
            ],
            'shipped' => [
                'en' => "Your order #{$order->id} has been shipped",
                'ar' => "تم شحن طلبك رقم #{$order->id}",
            ],
            'delivered' => [
                'en' => "Your order #{$order->id} has been delivered",
                'ar' => "تم توصيل طلبك رقم #{$order->id}",
            ],
            'cancelled' => [
                'en' => "Your order #{$order->id} has been cancelled",
                'ar' => "تم إلغاء طلبك رقم #{$order->id}",
            ],
        ];

        if (!isset($statusMessages[$order->status])) {
            return;
        }

        $notification = Notification::create([
            'target_id' => $order->buyer_id,
            'target_type' => NotificationTypeEnum::SPECIFIC_USER,
            'en_title' => 'Order Update',
            'ar_title' => 'تحديث الطلب',
            'en_body' => $statusMessages[$order->status]['en'],
            'ar_body' => $statusMessages[$order->status]['ar'],
            'status' => NotificationStatusEnum::SENT,
        ]);

        $this->send($notification);
    }

}