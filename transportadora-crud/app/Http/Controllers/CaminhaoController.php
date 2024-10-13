<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCaminhaoRequest;
use App\Repositories\DTOs\CaminhaoDTO;
use App\Repositories\Interfaces\CaminhaoRepositoryInterface;
use Illuminate\Http\Request;

class CaminhaoController extends Controller
{

    protected $caminhaoRepository;

    public function __construct(CaminhaoRepositoryInterface $caminhaoRepository)
    {
        $this->caminhaoRepository = $caminhaoRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $caminhoes = $this->caminhaoRepository->findAll();

        return response()->json($caminhoes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCaminhaoRequest $request)
    {
        $caminhaoDTO = new CaminhaoDTO(
            $request->motorista_id,
            $request->modelo_id,
            $request->placa
        );

        $this->caminhaoRepository->save($caminhaoDTO);

        return response()->json('Caminhão cadastrado com sucesso.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $caminhao = $this->caminhaoRepository->findById($id);

        if (!$caminhao) {
            return response()->json(['message' => 'Caminhão não encontrado'], 404);
        }

        return response()->json($caminhao);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $caminhaoDTO = new CaminhaoDTO(
            $request->motorista_id,
            $request->modelo_id,
            $request->placa
        );

        $this->caminhaoRepository->update($caminhaoDTO, $id);

        return response()->json('Caminhão atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($this->caminhaoRepository->delete($id)) {
            return response()->json(['message' => 'Caminhão deletado com sucesso']);
        }

        return response()->json(['message' => 'Caminhão não encontrado'], 404);
    }
}
