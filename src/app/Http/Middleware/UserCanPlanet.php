<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class UserCanPlanet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $name = Auth::User()->name;
        if ( Gate::allows('is-admin')) {
            return $next($request);
        }
        $id=$request->route('id');
        $person = Cache::get( $name );

        $chunks = explode('/' ,$person['homeworld']);
        $idf= $chunks[count($chunks)-2];
            if( $id == $idf){
                return $next($request);
            }
        $request->session()->flash('error','Planet Not found');
        return redirect('/panel');
    }
}
