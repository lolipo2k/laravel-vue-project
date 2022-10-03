<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\NotificationText;
use App\Models\Payments\Withdraw;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use TheSeer\Tokenizer\Exception;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function profile()
    {
        Auth::user()->load([
            'fields',
            'fieldCategories',
            'workExperience',
            'region',
            'moderator']);
        return new UserResource(Auth::user());
    }

    public function putProfile(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required'],
            'last_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable'],
        ]);

        Auth::user()->fill($data);

        if ($request->get('region_id')) {
            Auth::user()->region_id = $request->get('region_id');
        }

        Auth::user()->save();

        $fields = $request->get('selectedTags', []);

        $fields = $fields ? collect($fields) : collect();

        $fields = $fields->map(function ($field) {
            return $field['id'];
        });

        $fieldsCategories = $request->get('field_categories', []);

        $fieldsCategories = $fieldsCategories ? collect($fieldsCategories) : collect();

        $fieldsCategories = $fieldsCategories->map(function ($category) {
            return $category['id'];
        });

        $workExperience = $request->get('workExperience', []);

        $workExperience = $workExperience ? collect($workExperience) : collect();

        $workExperience = $workExperience->map(function ($field) {
            return $field['id'];
        });

        Auth::user()->fields()->sync($fields);
        Auth::user()->fieldCategories()->sync($fieldsCategories);
        Auth::user()->workExperience()->sync($workExperience);

        return ['success' => true];
    }

    public function putAvatar(Request $request)
    {
        $file = $request->file('file');

        $fileName =
            sha1(Auth::user()->id . Str::random(20))
            . '.'
            . $file->getClientOriginalExtension();

        $file->move(public_path('images/uploads/'), $fileName);

        try {
            if (Auth::user()->avatar
                && file_exists(public_path(Auth::user()->avatar))) {
                unlink(public_path(Auth::user()->avatar));
            }
        } catch (Exception $ex) {

        }

        Auth::user()->update(['avatar' => 'images/uploads/' . $fileName]);

        return ['name' => 'images/uploads/' . $fileName];
    }

    public function withdraw(Request $request)
    {
        $amount = $request->get('amount', 0);

        if (!$amount) {
            abort(422, 'Не верная сумма для выводы');
        }
        DB::beginTransaction();
        $user = Auth::user();
        if ($user->balance < $amount) {
            DB::rollBack();
            abort(422, 'Сумма для вывода не может быть больше баланса');
        }

        $w = new Withdraw();
        $w->amount = $amount;
        $w->employee_id = $user->id;
        $w->status = 0;
        $w->save();

        User::where('id', $user->id)->decrement('balance', $amount);
        DB::commit();

        foreach (User::where('role', 'admin') as $admin) {
            NotificationText::notifiUser($admin, NotificationText::EVENT_ADMIN_NEW_WITHDRAW, [
                'user_id' => $user->id,
                'amount' => $amount
            ]);
        }

        return $w;
    }

    public function getWithdraw()
    {
        return Withdraw::where('employee_id', Auth::user()->id)->get();
    }
}
