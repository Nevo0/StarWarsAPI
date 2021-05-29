<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    private static $one;
    public static function people() {
        $peoples=Http::get('https://swapi.dev/api/people/')->json();
        $people=Http::get('https://swapi.dev/api/people/'. rand(1, $peoples['count']))->json();
       return self::$one =$people['name'];
       }


    public function index(){
        // $peoples=Http::get('https://swapi.dev/api/people/')->json();
        // $people=Http::get('https://swapi.dev/api/people/'. rand(1, $peoples['count']))->json();
        // dd($this->peopleName());
        return view('index');
    }



    public function peopleName(){
        return serialize($this->people()['name']);

}
}
