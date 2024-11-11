<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['name_driver', 'cpf'];

    public function getDriver($field)
    {
        if (!is_null($field['name_driver'])) {
            return Driver::where('name_driver', 'LIKE', '%' . $field['name_driver'] . '%')->get();
        }
        return null;
    }

    public function getDrivers()
    {
        return Driver::all();
    }

    public function addDriver($field)
    {
        if ($this->isValidCpf($field['cpf']) && !$this->isCpfExists($field['cpf'])) {
            $driver = new Driver();
            $driver->name_driver = $field['name_driver'];
            $driver->cpf = $field['cpf'];
            $driver->save();
            return true;
        }
        return false;
    }

    public function updateDriver($id, $field)
    {
        if ($this->isValidCpf($field['cpf'])) {
            $driver = Driver::find($id);
            $driver->name_driver = $field['name_driver'];
            $driver->cpf = $field['cpf'];
            $driver->save();
            return true;
        }
        return false;
    }

    public function isValidCpf($cpf)
    {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se o CPF possui 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/^(\d)\1+$/', $cpf)) {
            return false;
        }

        // Calcula e valida os dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    public function isCpfExists($cpf)
    {
        return Driver::where('cpf', $cpf)->exists();
    }
}
