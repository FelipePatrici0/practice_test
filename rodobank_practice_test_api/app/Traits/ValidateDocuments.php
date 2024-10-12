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

    private function isValidCPF($cpf) 
    {
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

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





}
