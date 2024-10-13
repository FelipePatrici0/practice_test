<?php

namespace App\Repositories\DTOs;

class ModeloDTO
{
    public function __construct(
        public string $modelo,
        public string $cor,
    )
    {
        
    }

    public function toArray(): array
    {
        return [
            'modelo' => $this->modelo,
            'cor' => $this->cor,
        ];
    }
}