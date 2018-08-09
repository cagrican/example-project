<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function index($page = 1){
        $result = DB::table("user_location")->join("user","user_id","id")->orderBy("user_location.updated_at","desc");
        return $result;
    }

}
