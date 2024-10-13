<?php

namespace App\Repositories\DTOs;

class StatusTransportadoraDTO
{
    public function __construct(
        public string $status
    )
    {
        
    }

    public function toArray(): array
    {
        return [
            'status_transportadora' => $this->status,
        ];
    }
}