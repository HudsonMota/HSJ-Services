<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateUserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->users = $user;
        $this->middleware('auth');
    }



    //--------------------- Listar Usuários----------------------//
    public function list_users()
    {
        $users = $this->users->get()->sortByDesc("id");
        return view('auth/list_user', compact('users'));
    }
    //------------------------------------------------------------//

    //-------------------- Editar Usuários --------------------//
    public function get_edit_user($id)
    {
        $user = $this->user->find($id);
        return view('auth/edit_register', compact('user'));
    }

    public function post_edit_user(Request $info, $id)
    {
        $user = $this->user->find($id);
        $user->name  = $info['name'];
        $user->email  = $info['email'];
        $user->sector_id = $info['sector_id'];
        // $user->password = Hash::make($info['password']);
        $user->save();
        return redirect()->route('users')->with('message', 'Usuário atualizado com sucesso!');;
    }

    //-------------------- Deletar Usuário --------------------//

    public function delete_user($id)
    {
        $user = $this->user->find($id);

        // Deleta papel de usuário ao deletar usuário
        DB::table('role_user')
        ->where('user_id', $id)->delete();

        $user->delete();
        return redirect()->route('users')->with('message', 'Usuário excluído com sucesso!');
    }
}
