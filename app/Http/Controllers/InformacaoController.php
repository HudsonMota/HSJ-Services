<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use \App\Informacao;

class InformacaoController extends Controller
{


  public function get_add_informacao(Request $field)
  {
    return view('informacao/add_informacao');
  }

  public function get_tutorial_informacao(Request $field)
  {
    return view('informacao/tutorial_informacao');
  }


  // TUTORIAL

  public function get_tutorial_cad(Request $field)
  {
    return view('informacao/cad');
  }

  public function get_tutorial_access(Request $field)
  {
    return view('informacao/access');
  }

  public function get_tutorial_resetpassword(Request $field)
  {
    return view('informacao/resetpassword');
  }

  public function get_tutorial_vehiclerequest(Request $field)
  {
    return view('informacao/vehiclerequest');
  }

  public function get_tutorial_verifyrequest(Request $field)
  {
    return view('informacao/verifyrequest');
  }

  public function get_tutorial_newsolicity(Request $field)
  {
    return view('informacao/newsolicity');
  }
}
