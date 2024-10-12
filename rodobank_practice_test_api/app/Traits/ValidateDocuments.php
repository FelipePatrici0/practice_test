<?php

namespace App\Traits;

trait ValidateDocuments
{
    private function isValidCNPJ($cnpj)
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);
        
        if (strlen($cnpj) != 14) {
            return false;
        }

        if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
            return false;
        }

        $calculatedCNPJ = substr($cnpj, 0, 12);
        $digits = substr($cnpj, 12, 2);
        
        $sum = 0;
        for ($i = 0, $weight = 5; $i < 12; $i++, $weight--) {
            if ($weight < 2) {
                $weight = 9;
            }
            $sum += $cnpj[$i] * $weight;
        }
        $firstDigit = 0;
        if ($sum % 11 >= 2) {
            $firstDigit = 11 - ($sum % 11);
        }

        $sum = 0;
        for ($i = 0, $weight = 6; $i < 13; $i++, $weight--) {
            if ($weight < 2) {
                $weight = 9;
            }
            $sum += $cnpj[$i] * $weight;
        }
        $secondDigit = 0;
        if ($sum % 11 >= 2) {
            $secondDigit = 11 - ($sum % 11);
        }

        return $digits === $firstDigit . $secondDigit;
    }


    public function isValidCPF($cpf)
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) !== 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += (int)$cpf[$i] * ($i + 1);
        }
        $resto = $soma % 11;
        $digito1 = ($resto < 2) ? 0 : 11 - $resto;

        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += (int)$cpf[$i] * $i;
        }
        $resto = $soma % 11;
        $digito2 = ($resto < 2) ? 0 : 11 - $resto;

        return ($cpf[9] == $digito1 && $cpf[10] == $digito2);
    }
}
