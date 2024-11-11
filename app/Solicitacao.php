<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// use \App\solicitacao;

class Solicitacao extends Model
{

  protected $table = "vehiclerequests";
  protected $fillable = ['solicitante'];
}
