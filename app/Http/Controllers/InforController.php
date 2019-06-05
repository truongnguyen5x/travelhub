<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

class InforController extends Controller
{
    // public function getInformation($id){
    //     $user=User::find($id);
    //     if($user != null){
    //         $plan=$user->plans;

    //         return view('information/myplan',['user'=>$user,'plan'=>$plan])->with('user_id',$id);
    //     }else
    //         dd("error");

    // }
    // public function getInforfriend($id){
    //     $user=User::find($id);
    //     $plan=$user->plans;
    //     return view('information/inforFriend',['user'=>$user,'plan'=>$plan])->with('user_id',$id);
    // }

    public function getInformation($id)
    {
        $user = User::find($id);
        if ($user != null) {
            $plan = $user->plans;
            if ($user->id == Auth::user()->id) {
                return view('information/myplan', ['user' => $user, 'plan' => $plan])->with('user_id', $id);
            } else {
                return view('information/inforFriend', ['user' => $user, 'plan' => $plan])->with('user_id', $id);
            }

        } else {
            dd("error");
        }

    }

    public function getInfor_Accede($id)
    {
        $user = User::find($id);
        if ($user != null) {
            $participants = $user->participants;
            if ($participants->isEmpty()) {
                $plan = null;
                return view('information/accede', ['user' => $user, 'plan' => $plan])->with('user_id', $id);
            } else {
                foreach ($participants as $key => $participants) {
                    $plan[$key] = $participants->plan;
                }

            }

            return view('information/accede', ['user' => $user, 'plan' => $plan])->with('user_id', $id);
        } else {
            dd("error");
        }

    }

    public function getInfor_Follow($id)
    {
        $user = User::find($id);
        if ($user != null) {
            $follows = $user->follows;
            if ($follows->isEmpty()) {
                $plan = null;
            } else {
                foreach ($follows as $key => $follow) {
                    $plan[$key] = $follow->plan;
                }

            }

            return view('information/follow', ['user' => $user, 'plan' => $plan])->with('user_id', $id);
        } else {
            dd("error");
        }

    }
}
