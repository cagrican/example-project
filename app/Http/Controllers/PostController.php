<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PostController extends Controller
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
        $result = array();
        $now = date("Y-m-d H:i:s");
        //30 tane post çekildi
        $posts = DB::table('post')->where("approved",1)->orderBy("id","desc")->skip(($page-1)*30)->take(30)->get(); 
        //en yeni üye olan 4 tane user çekildi
        $users = DB::table("user")->orderBy("id","desc")->skip(($page-1)*4)->take(4)->get();
       //tarihleri uyan 1 reklam
        $ads = DB::table("advertisement")->where("start_date",">=",$now)->where("end_date","<=",$now)->orderBy("id","desc")->skip($page-1)->take(1)->get();
        //cevap sayılarıyla bir anket
        $surveys = DB::table("survey")->select(DB::raw('*,count(*) as answer_count'))->join("survey_answer","question_id","id")->where("approved",1)->groupBy("survey.id")->skip($page-1)->take(1)->get();

        $result = array_slice($posts,0,10); // ilk 10 posts
        $result = array_merge($result,$users); // sonra 4 user
        $result = array_merge($result,array_slice($posts,10,10)); // sonra tekrar 10 post
        $result = array_merge($result,$ads); // sonra 1 reklam
        $result = array_merge($result,array_slice($posts,20,10)); // sonra tekrar 10 post
        $result = array_merge($result,$surveys); // sonra tekrar 10 post

        return $result;
    }

}
