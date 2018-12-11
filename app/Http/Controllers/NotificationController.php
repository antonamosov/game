<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends BaseApiController
{
    public function index()
    {
        return $this->respond([
            'data' => NotificationResource::collection(\Auth::user()->notifications)
        ]);
    }

    public function accept(Notification $notification)
    {
        $notification->accept();

        return $this->respond([]);
    }

    public function reject(Notification $notification)
    {
        $notification->reject();

        return $this->respond([]);
    }

    public function destroyAll()
    {
        foreach (\Auth::user()->notifications as $notification) {
            $notification->delete();
        }

        return $this->respond([]);
    }
}
