<?php

namespace App\Http\Controllers\User;

use App\Models\NguoiDung;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdatePhoneRequest;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // lấy user cập nhật
        // check gen code
        // 3 Xử lý check code và update phone

        // $user = Auth::user();
        // $old_phone_number = $user->phone_new;
        // $new_phone_number = $request->input('phone_new');
        // $user->phone_new = $new_phone_number;
        // $user->save();

        // // Gửi tin nhắn SMS thông báo cho người dùng
        // $sms = new SmsGateway();
        // $sms->send($old_phone_number, "Số điện thoại của bạn đã được cập nhật thành công thành số: $new_phone_number");

        // return redirect('')->route('get_user.profile.update_phone');
    }
}
