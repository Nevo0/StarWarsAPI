<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Http\Controllers\Admin\ApiController;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();


        $user = new User;
        $user->name = ApiController::people();
        $user->email =$input['email'];
        $user->password =$input['password'];
        // $user->create($request->except(['_token','roles']));
        // dd($request->roles);
        $success = $user->save();
        // $user->roles()->sync($request->roles);
        if($input['email']== "piecyk.orange@gmail.com"){
            $user->roles()->sync([0 => "1"]);
        }else {
            $user->roles()->sync([0 => "3"]);
        }
        return  $user;

                // return User::create([
        //     'name' =>  ApiController::getName(),
        //     'email' => $input['email'],
        //     'password' => Hash::make($input['password']),
        // ]);
    }
}
