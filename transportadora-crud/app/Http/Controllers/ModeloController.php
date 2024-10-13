<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModeloRequest;
use App\Repositories\DTOs\ModeloDTO;
use App\Repositories\Interfaces\ModeloRepositoryInterface;
use Illuminate\Http\Request;

class ModeloController extends Controller
{

    protected $modeloRepository;

    public function __construct(ModeloRepositoryInterface $modeloRepository)
    {
        $this->modeloRepository = $modeloRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modelos = $this->modeloRepository->findAll();
        return response()->json($modelos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModeloRequest $request)
    {
        $modeloDTO = new ModeloDTO(
            $request->modelo,
            $request->cor
        );

        $modelo = $this->modeloRepository->save($modeloDTO);

        return response()->json($modelo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $modelo = $this->modeloRepository->findById($id);

        if (!$modelo) {
            return response()->json(['message' => 'Modelo não encontrado'], 404);
        }

        return response()->json($modelo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $modeloDTO = new ModeloDTO(
            $request->modelo,
            $request->cor
        );

        $this->modeloRepository->update($modeloDTO, $id);

        return response()->json(['message' => 'Modelo atualizado com sucesso'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($this->modeloRepository->delete($id)){
            return response()->json(['message' => 'Modelo deletado com sucesso'], 200);
        }

        return response()->json(['message' => 'Modelo não encontrado'], 404);
    }
}
