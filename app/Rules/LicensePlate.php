<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LicensePlate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        //PLACA COMUM ABC-1234
        return preg_match('/^[A-Z]{3}\-?[0-9][0-9A-Z][0-9]{2}$/', $value);

    }

    // public function validatePlacaDeVeiculoMercosul($attribute, $value)
    // {

    //     //PLACA MERCOSUL ABC1D23
    //     return preg_match('[A-Z]{3}[0-9][A-Z][0-9]{2}', $value);

    // }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Formato de :attribute incorreto. Use o formato AAA0000 ou AAA0A00(Mercosul)';
    }
}
