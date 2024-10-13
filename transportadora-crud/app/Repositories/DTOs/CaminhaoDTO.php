<?php

namespace App\Repositories\DTOs;

class CaminhaoDTO
{
    public function __construct(
        public string $motorista_id,
        public string $modelo_id,
        public string $placa,
    )
    {
        
    }

    public function toArray(): array
    {
        return [
            'motorista_id' => $this->motorista_id,
            'modelo_id' => $this->modelo_id,
            'placa_caminhao' => $this->placa,
        ];
    }
}