<?php

namespace App\Http\Controllers\User;

use App\Models\NguoiDung;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdatePhoneRequest;
use App\Mail\SendMailResetPassword;
use App\Models\DoiMatKhau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = NguoiDung::find(Auth::user()->id);
        if (!$user) return abort(404);

        return view('user.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = NguoiDung::find(Auth::user()->id);
        if (!$user) return abort(404);
        $user->ten = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($request->anhdaidien) {
            // dd($request->anhdaidien);
            $file = upload_image('anhdaidien');
            if (isset($file) && $file['code'] == 1) {
                $user->anhdaidien = $file['name'];
            }
        }

        $user->save();

        return  redirect()->route('get_user.profile.index');
    }

    public function updatePhone()
    {
        $user = NguoiDung::find(Auth::user()->id);
        if (!$user) return abort(404);

        return view('user.profile.update_phone', compact('user'));
    }

    public function processUpdatePhone(UserUpdatePhoneRequest $request)
    {
    }

    public function sendCode(Request $request)
    {
        $user = NguoiDung::find(Auth::user()->id);
        if (!$user) return abort(404);
    }

    public function forgotPassword()
    {
        return view('auth.forgot_password');
    }


    public function forgotPasswordReset(Request $request)
    {
        $data = $request->all();
        $mail = new SendMailResetPassword($data['email']);
        Mail::to($data['email'])->send($mail);
        return redirect(route('get.login'));
    }
}