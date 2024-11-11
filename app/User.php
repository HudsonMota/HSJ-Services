<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword;
use App\Role;
use App\Sector;
use App\Permission;




class User extends Authenticatable
{

    use Notifiable;

    // Enviar email traduziado
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'sector_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relação com tabela ROLES
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // Um usuário pertence a um setor
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }


    // Papéis de usuário
    public function hasPermission(Permission $permission)
    {
        return $this->hasAnyRoles($permission->roles);
    }

    public function hasAnyRoles($roles)
    {
        if (is_array($roles) || is_object($roles)) {
            foreach ($roles as $role) {
                return !!$roles->intersect($this->roles)->count();
            }
        }

        return $this->roles->contains('name', $roles);
    }
    // Papéis de usuário

    public function getUsers()
    {
        $users = User::all();
        return $users;
    }
}
