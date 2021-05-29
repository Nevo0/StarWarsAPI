<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{
    private static $one;
    public static function people() {
        $peoples=Http::get('https://swapi.dev/api/people/')->json();
        $index = rand(1, $peoples['count']);
        $people=Http::get('https://swapi.dev/api/people/'. $index)->json();
        Cache::put('people/'.$index , $people, $seconds = 60*60*24);
       return self::$one =$people['name'];
       }

    public function index(){

        return view('index');
    }

}
