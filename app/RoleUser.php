<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot
{

    public function getRoleUsers()
    {
        $role_users = RoleUser::all();
        return $role_users;
    }

    public function addRoleUser($field){
        $role_user = new RoleUser();
        $role_user->user_id = $field['user_id'];
        $role_user->role_id = $field['role_id'];

        $role_user->save();
    }

}
