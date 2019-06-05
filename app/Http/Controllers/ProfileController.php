<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\User;
use App\Rules\BeforeNow2;

class ProfileController extends Controller
{
	public function getEditProfile()
	{
		return view('user.editProfile');
	}

	public function postEditProfile(Request $request)
	{
		$request->validate([
			'email'=>'required|email', 
			'name'=>'required|min:5',
			'phone_number'=>'numeric|nullable', 
			'date_of_birth'=>['required','date',new BeforeNow2],
		],[
			'email.required'=>'Bạn cần nhập email',
			'email.email'=>'Bạn cần nhập email',
			'phone_number.numeric'=>'Bạn phải nhập đúng số điện thoại',
			'name.required'=>'Bạn cần nhập tên của bạn',
			'name.min'=>'Tên của bạn quá ngắn, cần dài hơn 5 kí tự',
			'date_of_birth.required'=>'Bạn cần điền ngày sinh',
			'date_of_birth.date'=>'Bạn cần điền ngày sinh',
		]);

		$user= User::find(Auth::user()->id);
		$user->email=$request->email;
		$user->full_name=$request->name;
		$user->phone_number=$request->phone_number;
		$request->gender=='nam'?$user->gender=1 : $user->gender=0;
		$user->date_of_birth=$request->date_of_birth;
		if($request->hasFile('image'))
		{
			$image = $request->image;
			$imageName = Auth::user()->id.'-'.$image->getClientOriginalName();
			$image->move('image/avatar', $imageName);
			$path = 'image/avatar/'.$imageName;
			$user->avatar = $path;
		}
		$user->save();
		return redirect()->back()->with('success', 'Bạn đã cập nhật thông tin cá nhân');
	}
}
