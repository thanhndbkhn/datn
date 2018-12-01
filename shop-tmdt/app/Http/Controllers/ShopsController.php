<?php
/**
 * Created by PhpStorm.
 * User: ThanhND
 * Date: 11/25/2018
 * Time: 2:57 PM
 */

namespace App\Http\Controllers;
use App\Shops;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Str;

class ShopsController extends Controller
{
    public function index() {
        return view('shop.resgister');

    }

    public function register(Request $request) {
        $this->validate($request,
            [
                'shop_name'                  => 'required|min:3|max:50',
                'id_bank'                    => 'required',
                'address'                    => 'required|min:3|max:50',
                'email'                      => 'required|email',
                'phone'                      => 'numeric|min:10',
                'password'                   => 'min:6',
                'password_confirmation'      => 'same:password|min:6'
            ],
            [
                'shop_name.max'              => 'Nhập tên shop quá dài',
                'shop_name.min'              => 'Nhập tên shop quá ngắn',
                'id_bank.required'           => 'Hãy nhập id tài khoản ngân lượng của bạn',
                'email.email'                => 'Hãy nhập đúng định dạng email',
                'password_confirmation.same' => 'Pass xác nhận không chính xác'

            ]);

        $data['shop_name'] = $request->input('shop_name');
        $data['id_bank']   = $request->input('id_bank');
        $data['address']   = $request->input('address');
        $data['email']     = $request->input('email');
        $data['phone']     = $request->input('phone');
        $data['password']  = $request->input('password');
        $data['name']      = $request->input('shop_name');
        $data['token']     = Str::random(60);

        Shops::create([
            'name'           => $data['shop_name'],
            'id_bank'        => $data['id_bank'],
            'email'          => $data['email'],
            'password'       => bcrypt($data['password']),
            'phone'          => $data['phone'],
            'remember_token' => $data['token'],
            'address'        => $data['address'],
            'status'         => '1',
        ]);

        // Create Session shop
        $_SESSION["shop"] = $data['shop_name'];
        return redirect('shops/login');
    }

    public function login() {
        return view('back-end.shop.home');
    }
}