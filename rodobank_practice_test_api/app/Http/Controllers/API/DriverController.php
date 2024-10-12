<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\DriverRepositoryInterface;
use App\Traits\ValidateDocuments;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    use ValidateDocuments;

    protected $driverRepository;

    public function __construct(DriverRepositoryInterface $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    public function index()
    {
        $carriers = $this->driverRepository->getAll();
        return response()->json($carriers);
    }

    public function show($id)
    {
        $carrier = $this->driverRepository->find($id);
        if (!$carrier) {
            return response()->json(['error' => 'Carrier not found'], 404);
        }
        return response()->json($carrier);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name_driver_tbd'      => 'required|string|max:100',
                'cpf_driver_tbd'       => 'required|string|size:11|unique:tb_driver',
                'birthdate_driver_tbd' => 'required|date',
                'email_driver_tbd'     => 'string|email',
            ]);

            // Valida o CPF
            if (!$this->isValidCPF($request['cpf_driver_tbd'])) {
                return response()->json(['error' => 'Invalid CPF please check and try again.'], 422);
            }

            // Cria o registro
            $driver = $this->driverRepository->create($data);
            return response()->json($driver, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->validator->errors(),
            ], 422);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $carrier = $this->driverRepository->find($id);

            if (!$carrier) {
                return response()->json(['error' => 'Carrier not found.'], 404);
            }

            $data = $request->validate([
                'name_driver_tbd'      => 'sometimes|string|max:100',
                'cpf_driver_tbd'       => 'sometimes|string|size:11|unique:tb_driver', // Ignora o CPF atual
                'birthdate_driver_tbd' => 'sometimes|date',
                'email_driver_tbd'     => 'sometimes|string|email', // Adiciona sometimes para email
            ]);

            // Verifica se o CPF foi enviado e, se sim, valida
            if (isset($data['cpf_driver_tbd']) && !$this->isValidCPF($data['cpf_driver_tbd'])) {
                return response()->json(['error' => 'Invalid CPF please check and try again.'], 422);
            }

            $carrier = $this->driverRepository->update($id, $data);
            return response()->json($carrier);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->validator->errors(),
            ], 422);
        }
    }


    public function destroy($id)
    {
        $deleted = $this->driverRepository->delete($id);
        if (!$deleted) {
            return response()->json(['error' => 'Carrier not found'], 404);
        }

        return response()->json(['message' => 'Carrier deleted successfully']);
    }
}
