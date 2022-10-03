<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->only([
            'email', 'name', 'phone', 'text'
        ]);

        $s = new Support();
        $s->email = $data['email'];
        $s->name = $data['name'];
        $s->phone = $data['phone'];
        $s->text = $data['text'];

        $u = auth()->guard()->user();
        if ($u) {
            $s->user_id = $u->id;
        }

        $s->save();

        return [
            'status' => 'success'
        ];
    }
}
