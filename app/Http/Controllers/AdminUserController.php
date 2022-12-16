<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

use Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    function __construct() {
        $this->middleware('admin');
    }
    
    function index(){
        $users = User::all();
        return view('admin.user.index', ['users' => $users]);
    }
    
    public function create()
    {
        return view('admin.user.create');
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        
        if ($validator->fails()) {
            return back()
            ->withErrors($validator);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->verified == "yes"){
            $user->email_verified_at = now();
        }
        $password = Hash::make($request->password);
        $user->password = $password;
        if($request->isAdmin == "yes"){
            $user->isAdmin = 1;
        }
        try{
            $user->save();
            return redirect('admin/user')->with('userCreated', 'The user was successfully created');
        }catch(\Exception $e){
            return redirect('admin/user')->withErrors(['userCreateError' => 'An error ocurred creating your user']);
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        
    }
}
