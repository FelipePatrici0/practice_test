<?php

namespace App\Repositories\DTOs;

use DateTime;

class MotoristaDTO
{
    public function __construct(
        public string $nome,
        public int $cpf,
        public DateTime $date,
        public string $email,
    )
    {
        
    }

    public function toArray(): array
    {
        return [
            'nome_motorista' => $this->nome,
            'cpf_motorista' => $this->cpf,
            'data_nascimento_motorista' => $this->date,
            'email_motorista' => $this->email,
        ];
    }
}