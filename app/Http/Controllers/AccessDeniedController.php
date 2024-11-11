<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccessDeniedController extends Controller
{
  public function index()
  {
    return view('accessdenied/index');
  }
}
