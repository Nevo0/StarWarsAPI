<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Admin\ApiController;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users= User::paginate(5);

        return view('admin.users.index')
        ->with([
            'users'=> $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create')
        ->with([
            'roles'=> Role::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData =$request->validate([
            'email'=> 'required|max:255|unique:users',
            'password'=> 'required|min:5|max:255'
        ]);
        $user = new User;
        $user->name = ApiController::getName();
        $user->email =$request->email;
        $user->password =$request->password;
        // $user->create($request->except(['_token','roles']));

        $success = $user->save();
        $user->roles()->sync($request->roles);

        return redirect( route('admin.users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.users.edit')
        ->with([
            'roles'=> Role::all(),
            'user'=> User::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user= User::find($id);
        if(!$user){
            return redirect( route('admin.users.index'));
        }
        $user->update($request->except(['_token', 'roles']));
        $user->roles()->sync($request->roles);
        return redirect( route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect( route('admin.users.index'));
    }
}
