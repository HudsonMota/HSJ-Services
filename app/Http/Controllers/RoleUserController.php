<?php

namespace App\Http\Controllers;

use App\RoleUser;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    private $role_user;
    public function __construct(RoleUser $role_user)
    {
        $this->role_user = $role_user;
        $this->role_users = $role_user;
        $this->middleware('auth');
    }


    //-------------------- Adicionar Custo --------------------//
    // Cadastrar custo livre
    public function get_add_role_user(Request $field)
    {
        $users = \App\User::orderBy('name')->get(['id', 'name']);
        $roles = \App\Role::all(['id', 'name', 'label']);
        $read = \App\User::orderBy('id', 'desc')->get();
        return view('role_user/add_role_user', compact('read', 'users', 'roles'));
    }

    public function post_add_role_user(Request $request)
    {
        $role_user = $this->role_user->addRoleUser($request);
        return redirect()->route('roleusers')->with('message', 'Papel adicionado com sucesso!');;
    }

    //--------------------- Listar Papel de Usuário ----------------------//
    public function list_role_users()
    {
        $users = \App\User::all(['id', 'name']);
        $roles = \App\Role::all(['id', 'name', 'label']);
        $role_users = $this->role_users->orderBy('created_at', 'desc')->get();
        return view('role_user/list_role_user', compact('role_users', 'roles', 'users'));
    }

    //-------------------- Deletar Papel de Usuário --------------------//
    public function delete_role($id)
    {
        $role_user = $this->role_user->find($id);
        $role_user->delete();
        return redirect()->route('roleusers')->with('message', 'Veiculo excluído com sucesso!');
    }

    //-------------------- Editar Papel --------------------//
    public function get_edit_role_use($id)
    {
        $users = \App\User::all(['id', 'name']);
        $roles = \App\Role::all(['id', 'name', 'label']);
        $role_user = $this->role_user->find($id);
        return view('role_user/edit_role_user', compact('role_user', 'users', 'roles'));
    }

    public function post_edit_role_use(Request $info, $id)
    {
        $role_user = $this->role_user->find($id);
        $role_user->user_id  = $info['user_id'];
        $role_user->role_id  = $info['role_id'];
        $role_user->save();
        return redirect()->route('roleusers')->with('message', 'Veiculo alterado com sucesso!');;
    }
}
