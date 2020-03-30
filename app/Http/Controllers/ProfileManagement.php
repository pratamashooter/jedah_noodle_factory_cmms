<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use App\Message;
use App\Activitylog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileManagement extends Controller
{
    //Show Setting Profile
    public function ShowProfile()
    {
    	return view('profile_management.setting_profile');
    }

    //Update Profile
    public function UpdateProfile(Request $request, $id)
    {
        $username_count = User::where('username', $request->username)->count();
    	$user = User::find($id);
        $avatar = $request->avatar;
        if($request->username == $user->username || $username_count == 0){
            if($avatar != ''){
                Message::where('name', $user->name)->update([
                    'name' => $request->name,
                    'avatar' => $request->file('avatar')->getClientOriginalName(),
                ]);
                DB::table('annualschedules')->where('id_user', $id)->update(['user' => $request->name]);
                DB::table('improvements')->where('id_user', $id)->update(['user' => $request->name]);
                DB::table('activitylogs')->where('id_user', $id)->update(['user' => $request->name]);

                $log = new Activitylog;
                $log->id_user = $request->user()->id;
                $log->user = $request->user()->name;
                $log->description = $request->user()->name." changes the profile";
                $log->remember_token = Str::random(40);
                $log->save();

                $user->update([
                    'name' => $request->name,
                    'username' => $request->username,
                    'avatar' => $request->avatar,
                ]);
                if($request->hasFile('avatar')){
                    $request->file('avatar')->move('picture/', $request->file('avatar')->getClientOriginalName());
                    $user->avatar = $request->file('avatar')->getClientOriginalName();
                    $user->save();
                }
            }else{
                Message::where('name', $user->name)->update([
                    'name' => $request->name,
                ]);
                DB::table('annualschedules')->where('id_user', $id)->update(['user' => $request->name]);
                DB::table('improvements')->where('id_user', $id)->update(['user' => $request->name]);
                DB::table('activitylogs')->where('id_user', $id)->update(['user' => $request->name]);

                $log = new Activitylog;
                $log->id_user = $request->user()->id;
                $log->user = $request->user()->name;
                $log->description = $request->user()->name." changes the profile";
                $log->remember_token = Str::random(40);
                $log->save();

                $user->update([
                    'name' => $request->name,
                    'username' => $request->username,
                ]);
            }
            Session::flash('changed','Account successfully changed!');
            return redirect('/setting_profile');
        }else{
            Session::flash('failed','Username has been used');
            return redirect('/setting_profile');
        }
    }

    // Delete Picture Profile
    public function DeletePictProfile()
    {
        $id = Auth::id();
        $user = User::find($id);
        $user->avatar = "user.png";
        $user->save();
        return redirect('/setting_profile');
    }

    //Change Password
    public function ChangePass(Request $request, $id){
        $user = User::find($id);
        if(Hash::check($request->old_password, $user->password)){
        	$user->password = Hash::make($request->new_password);
        	$user->save();
            Session::flash('changed_pass','Password successfully changed!');
            return redirect('/setting_profile');
        }else{
        	Session::flash('failed_pass','Old Password Wrong!');
            return redirect('/setting_profile');
        }
    }
}
