<?php

namespace App\Policies;

use App\Solicitacao;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class SolicitacaoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function updateSolicitacao(User $user, Solicitacao $solicitacao){
        return $user->id === $solicitacao->user_id;
    }
}
