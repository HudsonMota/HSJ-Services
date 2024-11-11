<?php

namespace App\Http\Controllers;

use App\Driver;
use App\Rules\CpfValidation;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    private $driver;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
        $this->middleware('auth');
    }

    //-------------------- Adicionar Motorista--------------------//
    public function get_add_driver(Request $field)
    {
        return view('driver/add_driver');
    }

    public function post_add_driver(Request $info)
    {
        $this->validate($info, [
            'name_driver' => 'required|string|max:50',
            'cpf' => [
                'required',
                'string',
                'max:14',
                new CpfValidation,
                function ($attribute, $value, $fail) {
                    if ($this->driver->isCpfExists($value)) {
                        $fail('O CPF já está cadastrado.');
                    }
                }
            ],
        ]);

        if ($this->driver->addDriver($info)) {
            return redirect()->route('drivers')->with('success', 'Cadastro de Técnico realizado com sucesso!');
        } else {
            return redirect()->back()->withErrors(['cpf' => 'CPF inválido'])->withInput();
        }
    }
    //------------------------------------------------------------//

    //---------------- Listar Motorista Específica -----------------//
    public function get_list_driver()
    {
        return view('driver/list_driver');
    }

    public function post_list_driver(Request $field)
    {
        if (is_null($field['name_driver'])) {
            $drivers = $this->driver->getDrivers();
        } else {
            $drivers = $this->driver->getDriver($field);
        }

        return view('driver/list_driver', compact('drivers'));
    }

    //--------------------- Listar Motoristas ----------------------//
    public function list_drivers()
    {
        $drivers = $this->driver->orderBy('created_at', 'desc')->get();
        return view('driver/list_driver', compact('drivers'));
    }

    //-------------------- Editar Motorista --------------------//
    public function get_edit_driver($id)
    {
        $driver = $this->driver->find($id);
        return view('driver/edit_driver', compact('driver'));
    }

    public function post_edit_driver(Request $info, $id)
    {
        $this->validate($info, [
            'name_driver' => 'required|string|max:50',
            'cpf' => [
                'required',
                'string',
                'max:14',
                new CpfValidation,
                function ($attribute, $value, $fail) use ($id) {
                    if ($this->driver->isCpfExists($value) && $this->driver->where('cpf', $value)->where('id', '!=', $id)->exists()) {
                        $fail('O CPF já está cadastrado.');
                    }
                }
            ],
        ]);

        if ($this->driver->updateDriver($id, $info)) {
            return redirect()->route('drivers')->with('success', 'Alteração de Técnico realizada com sucesso!');
        } else {
            return redirect()->back()->withErrors(['cpf' => 'CPF inválido'])->withInput();
        }
    }


    //-------------------- Deletar Motorista --------------------//
    public function delete_driver($id)
    {
        // Lógica para excluir o motorista
        $driver = Driver::find($id);
        if ($driver) {
            $driver->delete();
            return redirect()->route('drivers')->with('success', 'Exclusão de Técnico realizada com sucesso!');
        }
        return redirect()->route('drivers')->with('error', 'Técnico não encontrado.');
    }
}
