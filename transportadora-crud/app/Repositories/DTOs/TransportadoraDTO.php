<?php

namespace App\Repositories\DTOs;

class TransportadoraDTO
{
    public function __construct(
        public string $nome,
        public string $cnpj,
    )
    {
        
    }

    public function toArray(): array
    {
        return [
            'nome_transportadora' => $this->nome,
            'cnpj_transportadora' => $this->cnpj,
        ];
    }
}