<?php

namespace App\Http\Controllers;

use App\Plan;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function getHomepage()
    {
        $plan = Plan::all();
        $user = User::all();
        $id   = Auth::id();
//        var_dump(Auth::id());
        return view('home/all', ['user' => $user], ['plan' => $plan])->with('user_id', $id);
    }

    public function getHomeNew()
    {
        $plan = Plan::where('id', '>', 0)->orderBy('created_at', 'desc')->get();
        $user = User::all();
        $id   = Auth::id();
//        var_dump(Auth::id());
        return view('home/new', ['user' => $user], ['plan' => $plan])->with('user_id', $id);
    }

    public function getHomeAttention()
    {
        // $plan  = Plan::where('id', '>', 0)->orderBy('id', 'desc')->get();
        $plans = Plan::all();
        $list  = array();
        foreach ($plans as $plan) {
            $count = 0;
            $count += count($plan->follows);
            $count += count($plan->comments);
            $list[$plan->id]=$count;
        }     
        arsort($list);   
               
       // $list= array_slice($list, 0, 10);
        $plan=array();  
        $i=0;     
        foreach ($list as $key=>$value) {
            $i++;
            if($i>10)break;
            array_push($plan, Plan::find($key));
        }  

      
        $user = User::all();
        $id = Auth::id();
//        var_dump(Auth::id());
        return view('home/attention', ['user' => $user], ['plan' => $plan])->with('user_id', $id);
    }

    public function getNumber()
    {
        $user = User::where('id', '>', 0)->orderBy('id', 'desc')->take(2)->get();

        return view('home/number', ['user' => $user]);
    }

    public function getRight()
    {
        $user = User::all();
        return view('right', ['user' => $user]);
    }

}
