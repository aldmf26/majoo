<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(Request $r)
    {
        $id_lokasi = $r->id_lokasi;
        if($id_lokasi == 1) {
            $title = 'Login Takemori';
            $id_lokasi = 1;
            $img = "/ptagafood/logo/takemori.jpg";
        } elseif($id_lokasi == 2) {
            $title = 'Login Soondobu';
            $id_lokasi = 2;
            $img = "/ptagafood/logo/soondobu.jpg";
        } else {
            $title = 'Login Admin';
            $id_lokasi = 3;
            $img = "/ptagafood/logo/boxes.png";
        }

        $data = [
            'title' => $title,
            'id_lokasi' => $id_lokasi,
            'img' => $img,
        ];

        return view('login.login',$data);
    }
}
