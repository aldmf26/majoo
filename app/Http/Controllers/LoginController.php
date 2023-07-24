<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function prosesLogin(Request $r)
    {
        $username = $r->username;
        $password = $r->password;
        $id_lokasi = $r->id_lokasi;

        

        $valid = $r->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        $user = User::where('username', $username)->first();
        
        $data_permission = DB::table('tb_permission')->join('tb_sub_menu', 'tb_permission.permission', 'tb_sub_menu.id_sub_menu')->where('tb_permission.id_user', $user['id_user'])->get();
        $permission = [];
        foreach ($data_permission as $d) {
            $permission[] = $d->permission;
			$dt_menu[] = $d->id_menu;
        }

        if(Auth::attempt($valid)){
            if($id_lokasi == 1) {
                $title = 'Login Takemori';
                $id_lokasi = $r->session()->put('id_lokasi', 1);
                $img = "/ptagafood/logo/takemori.jpg";
                $r->session()->put('permission', $permission);
                $r->session()->put('dt_menu', $dt_menu);
            } elseif($id_lokasi == 2) {
                $title = 'Login Soondobu';
                $id_lokasi = $r->session()->put('id_lokasi', 2);
                $img = "/ptagafood/logo/soondobu.jpg";
                $r->session()->put('permission', $permission);
                $r->session()->put('dt_menu', $dt_menu);
            } else {
                $title = 'Login Admin';
                $id_lokasi = $r->session()->put('id_lokasi', 3);
                $img = "/ptagafood/logo/boxes.jpg";
                $r->session()->put('permission', $permission);
                $r->session()->put('dt_menu', $dt_menu);
            }
            $r->session()->regenerate();
            $r->session()->put('nama', strtoupper($username));
            return redirect()->intended('penjualan');
        } else {
            return redirect()->route('auth', ['id_lokasi' => $id_lokasi])->with('error', 'Username / password salah!');
        }
     
    }

    public function logout(Request $r)
    {
        Auth::logout();
 
        request()->session()->invalidate();
 
        request()->session()->regenerateToken();
 
        return redirect()->route('welcome');
    }
}
