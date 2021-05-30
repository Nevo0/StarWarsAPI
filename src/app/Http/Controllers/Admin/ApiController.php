<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Role;

use App\Models\User;



class ApiController extends Controller
{
    private static $one;
    public static function people() {
        $peoples=Http::get('https://swapi.dev/api/people/')->json();
        $index = rand(1, $peoples['count']);
        $people=Http::get('https://swapi.dev/api/people/'. $index)->json();
        $ceche['value'] = Cache::get($people['name']);
            if(!$ceche['value']){
                Cache::forever( $people['name'], $people);
            }
       return self::$one =$people['name'];
       }

    public function index(){
        if (Auth::User()) {
            return redirect('/panel');
        }
        return view('index');
    }
    public function search($peoples, $name){

        ;
        foreach ($peoples['results'] as &$people) {
            if ($people['name'] ==  $name) {
                Cache::forever( $people['name'], $people);
                return $people;
            }
        }
        $peoples = $this-> searchNext($peoples );
        $peoples = $this-> search($peoples, $name);
    }


    public function searchNext ($people){
        if ($people['next']) {
            $chunks = explode('=' ,$people['next']);
            $ceche = Cache::get('people/?page='.$chunks[1]);
            if (!$ceche) {
                $ceche = Http::get($people['next'])->json();
                Cache::put('people/?page='.$chunks[1], $ceche, $seconds = 60*60*24);
            }
            return $ceche;

        }
    }
    public function indexUser()
    {
        $userStatus = Auth::User()?Auth::User()->name:null;

        if($userStatus) {
            $person = Cache::get($userStatus);
            if (!$person) {
                $ceche['people'] = Cache::get('people');
                if ($ceche['people']) {
                    $person= $this-> search($ceche['people'], $userStatus);
                }
                else {
                    $respond['people']= Http::get('https://swapi.dev/api/people/')->json();
                    Cache::put('people', $respond['people'], $seconds = 60*60*24);
                    $person= $this-> search($respond['people'], $userStatus);
                }
            }

            $person['filmsAll']=[];
            $person['filmsAllid']=[];
            foreach ($person['films'] as &$film) {
                $filmCache = Cache::get($film);
                    if (!$filmCache) {
                        $respond= Http::get($film)->json();
                        $chunks = explode('/' ,$respond['url']);
                        $id= $chunks[count($chunks)-2];
                        $respond['id']=$id;
                        Cache::put($film , $respond, $seconds = 60*60*24);
                        array_push($person['filmsAll'], $respond);
                        array_push($person['filmsAllid'], $id);
                    }
                    else{
                        $chunks = explode('/' ,$filmCache['url']);
                        $id= $chunks[count($chunks)-2];
                        $filmCache['id']=$id;
                        array_push($person['filmsAll'], $filmCache);
                        array_push($person['filmsAllid'], $id);

                    }
                }

            $person['planets']=[];
            $person['planets'] = Cache::get($person['homeworld']);


            if (!$person['planets']) {
                $person['planets']= Http::get($person['homeworld'])->json();
                Cache::put($person['homeworld'] , $person['planets'], $seconds = 60*60*24);
                $chunks = explode('/' ,$person['planets']['url']);
                $id= $chunks[count($chunks)-2];
                $person['planetsid']=$id;
                // array_push($person['filmsAll'], $respond);
            }
            else{
                $chunks = explode('/' ,$person['planets']['url']);
                $id= $chunks[count($chunks)-2];
                $person['planetsid']=$id;
                // dd($person);
            }


            return view('user.film.index')
            ->with([
                'films'=> $person['filmsAll'],
                'planets'=> $person['planets'],
                'planetsid'=> $person['planetsid'],
            ]);
        }else{
           return redirect('/');
        }
    }

    public function edit($id)
    {
        // dd($id);
        return view('user.edit')
        ->with([
            'roles'=> Role::all(),
            'user'=> User::find($id),
        ]);
    }

    public function update($id, Request $request )
    {
        // dd($id);
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

}
