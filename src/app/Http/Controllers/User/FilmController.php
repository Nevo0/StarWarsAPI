<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function show(Request $request, $id )
    {

        $url='http://swapi.dev/api/films/'.$id.'/';
        $film = Cache::get($url);
        $cache = Cache::get($url);
        if (!$cache) {
            $cache= Http::get($url)->json();
            if( isset($cache['detail']) ){
                $request->session()->flash('error','Films Not found');
                return redirect()->route('panel');
            }
            Cache::put($url , $cache, $seconds = 60*60*24);
        }
        return view('user.film.show')
            ->with([
                'film'=> $film,
            ]);
    }

}
