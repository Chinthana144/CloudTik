<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $roles = Roles::all();

        return view('Users.users-list', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //data
        $username = $request->input('name');
        $email = $request->input('email');
        //check duplicates
        $exists = User::where('name', $username)
            ->orwhere('email', $email)
            ->exists();

        if ($exists) {
            return redirect()->route('users.index');
        } else {
            $password = Hash::make($request->input('password'));
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = $password;
            $user->role_id = $request->input('cmb_role');

            $user->save();

            return redirect()->route('users.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user_id = $request->input('hide_edit_user_id');

        $user = User::find($user_id);

        $user->name = $request->input('edit_name');
        $user->email = $request->input('edit_email');
        $user->role_id = $request->input('cmb_role');

        $user->save();

        return redirect()->route('users.index');
    }

    public function update_pwd(Request $request)
    {
        $user_id = $request->input('hide_user_id');

        $new_password = Hash::make($request->input('re_password'));

        $user = User::find($user_id);

        $user->password = $new_password;

        $user->save();

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //ajax methods
    public function getOneUser(Request $request)
    {
        $user_id = $request->input('user_id');

        $user = User::find($user_id);

        return response()->json($user);
    }
}
