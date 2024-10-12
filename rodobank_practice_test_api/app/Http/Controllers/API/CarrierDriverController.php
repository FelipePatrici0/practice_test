<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CarrierDriverRepositoryInterface;
use Illuminate\Http\Request;

class CarrierDriverController extends Controller
{
    protected $carrierDriverRepository;

    public function __construct(CarrierDriverRepositoryInterface $carrierDriverRepository)
    {
        $this->carrierDriverRepository = $carrierDriverRepository;
    }

    public function index()
    {
        $carrierDrivers = $this->carrierDriverRepository->getAll();
        return response()->json($carrierDrivers);
    }

    public function show($id)
    {
        $carrier_driver = $this->carrierDriverRepository->find($id);
        if (!$carrier_driver) {
            return response()->json(['error' => 'Relation Carrier Driver not found'], 404);
        }
        return response()->json($carrier_driver);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'id_carrier_rcd' => 'required|integer|exists:tb_carrier,id_carrier_tbc',
                'id_driver_rcd' => 'required|integer|exists:tb_driver,id_driver_tbd',
            ]);

            if ($this->carrierDriverRepository->driverAlreadyRegistered($data['id_carrier_rcd'], $data['id_driver_rcd'])) {
                return response()->json([
                    'message' => 'This driver is already registered with this carrier.',
                ], 422);
            }

            $carrier_driver = $this->carrierDriverRepository->create($data);

            return response()->json($carrier_driver, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->validator->errors(),
            ], 422);
        }
    }



    public function update(Request $request, $id)
    {
        try {
            // Busca a relação atual pelo ID
            $carrier_driver = $this->carrierDriverRepository->find($id);

            if (!$carrier_driver) {
                return response()->json(['error' => 'Relation Carrier Driver not found.'], 404);
            }

            // Valida os dados de entrada
            $data = $request->validate([
                'id_carrier_rcd' => 'sometimes|integer|exists:tb_carrier,id_carrier_tbc',
                'id_driver_rcd' => 'sometimes|integer|exists:tb_driver,id_driver_tbd',
            ]);

            // Define valores padrão a partir dos dados existentes no banco se não foram passados
            $id_carrier = $data['id_carrier_rcd'] ?? $carrier_driver->id_carrier_rcd;
            $id_driver = $data['id_driver_rcd'] ?? $carrier_driver->id_driver_rcd;

            // Verifica se a combinação já existe em outro registro que não seja o atual
            if ($this->carrierDriverRepository->driverAlreadyRegisteredUpdate($id_carrier, $id_driver, $id)) {
                return response()->json([
                    'message' => 'This driver is already registered with this carrier.',
                ], 422);
            }

            // Atualiza a relação
            $carrier_driver = $this->carrierDriverRepository->update($id, $data);

            return response()->json($carrier_driver);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->validator->errors(),
            ], 422);
        }
    }

    


    public function destroy($id)
    {
        $deleted = $this->carrierDriverRepository->delete($id);
        if (!$deleted) {
            return response()->json(['error' => 'Relation Carrier Driver not found'], 404);
        }

        return response()->json(['message' => 'Relation Carrier Driver deleted successfully']);
    }
}
