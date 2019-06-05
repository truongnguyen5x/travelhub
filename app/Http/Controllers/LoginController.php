<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Rules\BeforeNow;
use App\User;
use Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class LoginController extends Controller
{
    public function getLogin()
    {
        return view('login');
    }
//kiểm tra đăng nhập, cho qua hay không
    public function postLogin(Request $request)
    {
        $identity = $request->username;
        $data     = [
            filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'username' => $identity,
            'password'                                                          => $request->password,
        ];
        if (Auth::attempt($data)) {
            $user = Auth::user();
            if ($user->username == 'admin') {
                return redirect('header');
            } else {
                return redirect('/trang-chu/ke-hoach-moi-nhat');
            }
        } else {
            return redirect('login')->with('notify', 'Tên đăng nhập, email hoặc mật khẩu không đúng');
        }
    }
//đăng xuất
    public function getLogout()
    {
        Auth::logout();
        return redirect('login');
    }
    public function getRegister()
    {
        return view('register');
    }
//kiểm tra đăng ký
    public function postRegister(Request $request)
    {
        $request->validate([
            'username'         => 'required|min:3|unique:users,username|alpha_num',
            'email'            => 'required|email|unique:users,email',
            'name'             => 'required|min:3',
            'phone_number'     => 'numeric|nullable',
            'password'         => 'required|min:3|max:60|alpha_num',
            'password_confirm' => 'required|same:password',
            'date_of_birth'    => ['required', new BeforeNow],
            'avatar'           => 'required|image|dimensions:min_width=200,min_height=200',
        ], [
            'username.required'         => 'Bạn cần nhập tên đăng nhập',
            'username.min'              => 'Tên đăng nhập cần lớn hơn 3 kí tự',
            'username.unique'           => 'Tên đăng nhập đã tồn tại',
            'username.alpha_num'        => 'Tên đăng nhập chỉ được chứa chữ và số',
            'email.required'            => 'Bạn cần nhập email',
            'email.email'               => 'Bạn cần nhập email',
            'email.unique'              => 'Địa chỉ email đã tồn tại',
            'phone_number.numeric'      => 'Bạn phải nhập đúng số điện thoại',
            'name.required'             => 'Bạn cần nhập tên của bạn',
            'name.min'                  => 'Tên của bạn quá ngắn, cần dài hơn 2 kí tự',
            'password.required'         => 'Bạn cần nhập mật khẩu',
            'password.alpha_num'        => 'Mật khẩu chỉ được chứa chữ và số',
            'password.min'              => 'Mật khẩu phải có độ dài từ 3 đến 60 kí tự',
            'password.max'              => 'Mật khẩu phải có độ dài từ 3 đến 60 kí tự',
            'password_confirm.required' => 'Bạn phải nhập lại mật khẩu',
            'password_confirm.same'     => 'Bạn nhập lại mật khẩu không khớp',
            'date_of_birth.required'    => 'Bạn cần điền ngày sinh',
            'date_of_birth.date'        => 'Bạn cần điền ngày sinh',
            'avatar.required'           => 'Bạn cần chọn 1 ảnh',
            'avatar.image'              => 'Bạn cần chọn 1 ảnh',
            'avatar.dimensions'         => 'Ảnh đại diện quá nhỏ',
        ]);
        $user                                     = new User;
        $user->username                           = $request->username;
        $user->email                              = $request->email;
        $user->full_name                          = $request->name;
        $user->phone_number                       = $request->phone_number;
        $user->password                           = Hash::make($request->password);
        $request->gender == 'nam' ? $user->gender = 1 : $user->gender = 0;
        $user->date_of_birth                      = Carbon::createFromFormat('d-m-Y', $request->date_of_birth);
//crop image avatar
        $scale = getimagesize($request->avatar)[0] / 300;
        $rectX = round($scale * $request->rectX);
        $rectY = round($scale * $request->rectY);
        $size  = round($scale * $request->size);
//create name for file image
        $extension = $request->avatar->getClientOriginalName();
        $fileName  = str_random(5) . $extension;
        while (file_exists('image/avatar/' . $fileName)) {
            $fileName = str_random(5) . $extension;
        }
        Image::make($request->avatar)->crop($size, $size, $rectX, $rectY)->save('image/avatar/' . $fileName);
        $user->avatar = 'image/avatar/' . $fileName;

        $user->save();
        return redirect('login')->with('notify', 'Bạn đã đăng ký tài khoản thành công, hãy đăng nhập để tiếp tục');
    }
}
