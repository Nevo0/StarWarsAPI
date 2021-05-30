<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PlanetController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $url='http://swapi.dev/api/planets/'.$id.'/';
        $cache = Cache::get($url);
        if (!$cache) {
            $cache= Http::get($url)->json();
            if( isset($cache['detail']) ){
                $request->session()->flash('error','Films Not found');
                return redirect()->route('panel');
            }
            Cache::put($url , $cache, $seconds = 60*60*24);
        }
        return view('user.planet.show')
            ->with([
                'planet'=> $cache,
            ]);
    }

}

