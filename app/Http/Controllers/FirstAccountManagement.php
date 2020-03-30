<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FirstAccountManagement extends Controller
{
	// Open Create First Account
	public function OpenCreate()
	{
		$user = User::all();
		return view('first', compact('user'));
	}

    // Make First Account
    public function FirstAccount(Request $request)
    {
        if($request->avatar != "")
        {
            $user = new User;
            $user->name = $request->name;
            $user->role = $request->role;
            $user->username = $request->username;
            $user->password= Hash::make($request->password);
            $user->remember_token = Str::random(40);
            $avatar = $request->file('avatar');
            $user->avatar = $avatar->getClientOriginalName();
            $avatar->move(public_path('picture/'),$avatar->getClientOriginalName());
            $user->save();
            return redirect('/');
        }else{
            $user = new User;
            $user->name = $request->name;
            $user->role = $request->role;
            $user->username = $request->username;
            $user->password= Hash::make($request->password);
            $user->remember_token = Str::random(40);
            $user->avatar = "user.png";
            $user->save();
            return redirect('/');
        }
    }
}
