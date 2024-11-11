<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    public function getSectors()
    {
        // Ordena os setores em ordem alfabética
        return Sector::orderBy('sector', 'asc')->get();
    }

    // Um setor tem muitos usuários
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
