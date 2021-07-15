<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nickname'  => 'required|string',
            'birthdate' => 'required|date|before:'.Carbon::now(),
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
