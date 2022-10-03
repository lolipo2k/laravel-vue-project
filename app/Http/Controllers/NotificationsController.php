<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function get(Request $request)
    {
        return Notification::where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->paginate($request->get('per_page', 20));
    }

    public function hasNew(Request $request)
    {
        return ['exists' => Notification::where('user_id', Auth::user()->id)
            ->where('created_at', '>=', $request->get('date'))
            ->exists()];
    }
}
