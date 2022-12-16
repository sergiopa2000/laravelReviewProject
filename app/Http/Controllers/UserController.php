<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function __construct() {
        $this->middleware('auth', ['except' => ['index']]);
    }
    
    function index(User $user){
        $own = false;
        if(Auth::user()){
           $own = $user->id == Auth::user()->id; 
        }
        return view('user.index', ['user' => $user, 'ownProfile' => $own]);
    }
    
    function update(Request $request, User $user){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users,name,'.$user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'verified' => ['required', 'string', 'in:yes,no'],
        ]);
        if ($validator->fails()) {
            return back()
            ->withErrors($validator);
        }
        if($request->oldPassword && !Hash::check($request->oldPassword, $user->password)){
            return back()
            ->withErrors(['oldPassword' => 'The old password does not match.']);
        }
        $sendEmail = false;
        
        if($request->verified == "yes"){
            $user->email_verified_at = now();
        }else{
            $user->email_verified_at = null;
        }
        
        if($request->email != $user->email){
            $user->email = $request->email;
            $user->email_verified_at = null;
            $sendEmail = true;
        }
        if($request->password != null){
            $user->password = Hash::make($request->password);
        }
        
        if($request->file('profileImage')){
            $profileImage = $request->file('profileImage');
            $name = $request->name . '-profileImage.' .$profileImage->extension();
            $path = $profileImage->storeAs('public/profileImages', $name);
            $user->profileImage = $name;
        }
        $user->name = $request->name;
        try{
          $user->update();
          if($sendEmail){
              $user->sendEmailVerificationNotification();
                if($request->input('admin')){
                    return redirect('admin/user')->with('userUpdateSuccess', 'User ' . $user->name . ' has been successfully updated');
                }else{
                    Auth::logout();
                    return redirect('login')->with('emailChanged', 'Your email address must be verified before logging in, please check your mail');
                }
            }

        }catch(\Exception){
            return back()->withErrors('userUpdateError', 'An error occured updating user ' . $user->name);
        }
        if($request->input('admin')){
            return redirect('admin/user')->with('userUpdateSuccess', 'User ' . $user->name . ' has been successfully updated');
        }else{
            return redirect($user->name)->with('userUpdateSuccess', 'Your profile has been successfully updated');
        }
    }
    
    function destroy(User $user){
        try{
            $user->delete();
            return back()->with('userDeleteSuccess', 'User ' . $user->name .' has been successfully deleted');
        }catch(\Exception $e){
            return back()->withErrors(['userDeleteError' => 'An error occured deleting user ' . $user->name]);
        }
    }
}
