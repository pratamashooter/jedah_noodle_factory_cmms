<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use App\Message;
use App\Activitylog;
use App\Improvement;
use App\Annualschedule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountManagement extends Controller
{
	// Open AccountManagement View
	public function AccountManagement()
	{
        $accounts = User::select('users.*')
        ->orderBy('role', 'ASC')
        ->get();
		return view('account_management.account_management', compact('accounts'));
	}

    // Open AddAccount View
    public function AddAccount(){
        return view('account_management.add_account');
    }

    // Create New Account
    public function CreateAccount(Request $request)
    {
        $username_count = User::where('username', $request->username)->count();
        if($username_count == 0)
        {
            if($request->avatar != ""){
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

                $log = new Activitylog;
                $log->id_user = $request->user()->id;
                $log->user = $request->user()->name;
                $log->description = $request->user()->name." added a new account: ".$request->name;
                $log->remember_token = Str::random(40);
                $log->save();

                Session::flash('added', 'Account successfully added!');
                return redirect('/account_management');
            }else{
                $user = new User;
                $user->name = $request->name;
                $user->role = $request->role;
                $user->username = $request->username;
                $user->password= Hash::make($request->password);
                $user->remember_token = Str::random(40);
                $user->avatar = "user.png";
                $user->save();

                $log = new Activitylog;
                $log->id_user = $request->user()->id;
                $log->user = $request->user()->name;
                $log->description = $request->user()->name." added a new account: ".$request->name;
                $log->remember_token = Str::random(40);
                $log->save();
                Session::flash('added', 'Account successfully added!');
                return redirect('/account_management');
            }
        }else if($username_count == 1){
            Session::flash('false', 'Username has been used');
            return redirect('/add_account');
        }
    }

    // Edit Account
    public function EditAccount($id)
    {
        $user = User::find($id);

        return response()->json($user);
    }

    // Update Account
    public function UpdateAccount(Request $request, $id){
        $username_count = User::where('username', $request->username)->count();
        $user = User::find($id);
        if($request->username == $user->username || $username_count == 0){
            $avatar = $request->avatar;
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
                $log->description = $request->user()->name." changes account ".$user->name;
                $log->remember_token = Str::random(40);
                $log->save();

                $user->update([
                    'name' => $request->name,
                    'username' => $request->username,
                    'role' => $request->role,
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
                $log->description = $request->user()->name." changes account ".$user->name;
                $log->remember_token = Str::random(40);
                $log->save();

                $user->update([
                    'name' => $request->name,
                    'username' => $request->username,
                    'role' => $request->role,
                ]);
            }
            Session::flash('updated', 'Account successfully updated!');
            echo "success";
        }else{
            echo "failed";
        }

        
    }

    // Delete Account
    public function DeleteAccount($id)
    {
        $user = User::find($id);

        $log = new Activitylog;
        $log->id_user = Auth::id();
        $log->user = Auth::user()->name;
        $log->description = Auth::user()->name." deletes account ".$user->name;
        $log->remember_token = Str::random(40);
        $log->save();

        $user->delete();

        Session::flash('deleted', 'Account successfully deleted!');
        return redirect('/account_management');
    }
    
}
