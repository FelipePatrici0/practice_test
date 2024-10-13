<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransportadoraRequest;
use App\Http\Requests\UpdateTransportadoraMotoristasRequest;
use App\Http\Requests\UpdateTransportadoraStatusRequest;
use App\Repositories\DTOs\StatusTransportadoraDTO;
use App\Repositories\DTOs\TransportadoraDTO;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\TransportadoraRepositoryInterface;


class TransportadoraController extends Controller
{


    protected $transportadoraRepository;

    public function __construct(TransportadoraRepositoryInterface $transportadoraRepository)
    {
        $this->transportadoraRepository = $transportadoraRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $transportadoras = $this->transportadoraRepository->findAll(); 
        return response()->json($transportadoras);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransportadoraRequest $request)
    {
        $transportadoraDTO = new TransportadoraDTO(
            $request->nome,
            $request->cnpj
        );

        $transportadora = $this->transportadoraRepository->save($transportadoraDTO);

        return response()->json($transportadora->toArray(), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transportadora = $this->transportadoraRepository->findById($id);
        
        if (!$transportadora) {
            return response()->json(['message' => 'Transportadora não encontrada'], 404);
        }

        return response()->json($transportadora->toArray());
    }

    public function showWithMotoristas(string $id)
    {
        $transportadora = $this->transportadoraRepository->findByIdWithMotoristas($id);
        
        if (!$transportadora) {
            return response()->json(['message' => 'Transportadora não encontrada'], 404);
        }

        return response()->json($transportadora->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transportadoraDTO = new TransportadoraDTO(
            $request->nome,
            $request->cnpj
        );

        $this->transportadoraRepository->update($transportadoraDTO, $id);

        return response()->json(['message' => 'Transportadora atualizada com sucesso']);
    }

    public function updateStatus(UpdateTransportadoraStatusRequest $request, string $id)
    {
        $statusTransportadoraDTO = new StatusTransportadoraDTO(
            $request->status
        );

        if ($this->transportadoraRepository->updateStatus($statusTransportadoraDTO, $id))
        {
            return response()->json(['message' => 'Transportadora atualizada com sucesso']);
        }
        return response()->json(['message' => 'Erro ao atualizar o status'], 500);
    }

    public function updateMotoristas(UpdateTransportadoraMotoristasRequest $request, string $id)
    {
        try {
            $this->transportadoraRepository->updateMotoristas($request->motoristas, $id);

            return response()->json(['message' => 'Transportadora atualizada com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Houve erro ao cadastrar motoristas'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($this->transportadoraRepository->delete($id)) {
            return response()->json(['message' => 'Transportadora deletada com sucesso']);
        }

        return response()->json(['message' => 'Transportadora não encontrada'], 404);
    }
}
