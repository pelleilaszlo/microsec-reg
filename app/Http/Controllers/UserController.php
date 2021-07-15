<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function show()
    {
        if (rand(0,1) && file_exists(storage_path('users')))
        {
            $users = collect(json_decode(Storage::get('users'), true));
            return $users->where('email', Auth::user()->email)->first();
        }
        return Auth::user();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nickname'  => 'required|string',
            'birthdate' => 'required|date|before:'.Carbon::today()->toDateString(),
            'password'  => 'nullable|string',
        ], [
            'birthdate.before' => __('validation.before', ['attribute' => 'birthdate', 'date' => Carbon::today()->toDateString()]),
        ]);
        if ($validator->fails()) {
            return Response($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $user = User::where('id', auth()->user()->id)->firstOrFail();

        $user->nickname = $request->nickname;
        $user->birthdate = $request->birthdate;

        if ($request->has('password') && !empty($request->password))
        {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        User::fileStorage();

        return 'Update successful';

    }
}
