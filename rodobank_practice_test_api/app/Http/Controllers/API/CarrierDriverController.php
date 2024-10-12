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
            $carrier_driver = $this->carrierDriverRepository->find($id);

            if (!$carrier_driver) {
                return response()->json(['error' => 'Relation Carrier Driver not found.'], 404);
            }

            $data = $request->validate([
                'id_carrier_rcd' => 'sometimes|integer|exists:tb_carrier,id_carrier_tbc',
                'id_driver_rcd' => 'sometimes|integer|exists:tb_driver,id_driver_tbd',
            ]);

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
