<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
        // if ( Gate::denies('logged-in')) {
        //     dd("noaccess");
        //     abort(403);
        // }

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
            'roles'=> Role::all(),
            'superAdmin' => false
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
        // dd($request->roles);
        $success = $user->save();
        $user->roles()->sync($request->roles);
        // $user->roles()->sync([1]);
        $request->session()->flash('success','You have created the user');
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
            $request->session()->flash('error','You can not edit this user');
            return redirect( route('admin.users.index'));
        }
        $user->update($request->except(['_token', 'roles']));
        $user->roles()->sync($request->roles);
        $request->session()->flash('success','You have edited the user');
        return redirect( route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        User::destroy($id);
        $request->session()->flash('success','You have deleted the user');
        return redirect( route('admin.users.index'));
    }
}
