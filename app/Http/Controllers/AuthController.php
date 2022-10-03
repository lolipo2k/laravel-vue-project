<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterFormRequest $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->save();
        return response([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Не верная пара логин / пароль'
            ], 400);
        }
        return response([
            'status' => 'success'
        ], 200, [
                'Authorization' => $token
            ]
        );
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function refresh()
    {
        return response([
            'status' => 'success'
        ]);
    }

    public function logout()
    {
        JWTAuth::invalidate();
        return response([
            'status' => 'success',
            'msg' => 'Выход из системы подтвержжен.'
        ], 200);
    }


    public function password(Request $request)
    {
        $newPass = $request->get('new_password', null);

        if (!$newPass) {
            abort(422, 'Пустой пароль');
        }

        \Auth::user()->password = Hash::make($newPass);
        \Auth::user()->save();

        return [
            'status' => 'success'
        ];
    }
}
