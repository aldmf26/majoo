<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $r)
    {
        $data = [
            'title' => 'Data User',
            'user' => User::orderBy('id_user', 'desc')->get(),
        ];
        return view('user.user', $data);
    }

    public function tambah(Request $r)
    {
        $data = [
            'username' => $r->username,
            'nama' => $r->nama,
            'password' => bcrypt($r->password),
            'role_id' => $r->role_id,
            'is_active' => 1,
        ];
        User::create($data);
        return redirect()->route('user')->with('sukses', 'Berhasil tambah user');
    }

    public function edit(Request $r)
    {
        $data = [
            'nama' => $r->nama,
            'role_id' => $r->role_id,
            'is_active' => $r->is_active,
        ];

        User::where('id_user', $r->id_user)->update($data);
        return redirect()->route('user')->with('sukses', 'Berhasil ubah user');
    }

    public function hapus(Request $r)
    {
        User::where('id_user', $r->id_user)->delete();
        return redirect()->route('user')->with('sukses', 'Berhasil hapus user');
    }

    public function updatePermission(Request $r)
    {
        $id_user = $r->id_user;
        $permission =  $r->permission;

        Permission::where('id_user', $id_user)->delete();


        for ($count = 0; $count < count($permission); $count++) {
            $data = [
                'id_user' => $id_user,
                'permission' => $permission[$count]
            ];

            Permission::create($data);
        }
        return redirect()->route('user')->with('sukses', 'Berhasil tambah permission');
    }

    public function get_permission(Request $r)
    {
        $id_user = $r->id_user;

        $data_permission = Permission::where('id_user', $id_user)->get();
        $menu = DB::table('tb_menu')->get();
        $sub_menu = DB::table('tb_sub_menu')->get();

        $permission = [];
        foreach ($data_permission as $d) {
            $permission[] = $d['permission'];
        }

        foreach ($menu as $mn) {
            echo '
      <div class="form-group col-md-12">
      <label class="form-check-label"><strong>' . $mn->menu . '</strong></label>
      </div>
    ';
            foreach ($sub_menu as $smn) {
                if ($mn->id_menu == $smn->id_menu) {
                    echo '<div class="form-group col-md-4">
              <div class="form-check">';
                    if (in_array($smn->id_sub_menu, $permission)) {
                        echo '<input class="form-check-input" type="checkbox" name="permission[]" value="' . $smn->id_sub_menu . '" checked>';
                    } else {
                        echo '<input class="form-check-input" type="checkbox" name="permission[]" value="' . $smn->id_sub_menu . '">';
                    }
                    echo '<label class="form-check-label">' . $smn->sub_menu . '</label>
              </div>
              </div>';
                }
            }
            echo '<br><br><br>';
        }
    }
}
