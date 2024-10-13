<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMotoristaRequest;
use App\Repositories\DTOs\MotoristaDTO;
use App\Repositories\Interfaces\MotoristaRepositoryInterface;
use Illuminate\Http\Request;

class MotoristaController extends Controller
{

    protected $motoristaRepository;

    public function __construct(MotoristaRepositoryInterface $motoristaRepository)
    {
        $this->motoristaRepository = $motoristaRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motoristas = $this->motoristaRepository->findAll(); 
        return response()->json($motoristas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMotoristaRequest $request)
    {
        $motoristaDTO = new MotoristaDTO(
            $request->nome_motorista,
            $request->cpf_motorista,
            $request->data_nascimento_motorista,
            $request->email_motorista
        );

        $motorista = $this->motoristaRepository->save($motoristaDTO);

        return response()->json($motorista->toArray(), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $motorista = $this->motoristaRepository->findById($id);
        
        if (!$motorista) {
            return response()->json(['message' => 'Motorista não encontrado'], 404);
        }

        return response()->json($motorista->toArray());
    }

    public function showWithCaminhoes(string $id)
    {
        $motorista = $this->motoristaRepository->findByIdWithCaminhoes($id);
        
        if (!$motorista) {
            return response()->json(['message' => 'Motorista não encontrado'], 404);
        }

        return response()->json($motorista->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $motoristaDTO = new MotoristaDTO(
            $request->nome_motorista,
            $request->cpf_motorista,
            $request->data_nascimento_motorista,
            $request->email_motorista
        );

        $this->motoristaRepository->update($motoristaDTO, $id);

        return response()->json(['message' => 'Motorista atualizado com sucesso'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($this->motoristaRepository->delete($id)){
            return response()->json(['message' => 'Motorista deletado com sucesso'], 200);
        }

        return response()->json(['message' => 'Motorista não encontrado'], 404);
    }
}
