<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TruckRepositoryInterface;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    protected $truckRepository;

    public function __construct(TruckRepositoryInterface $truckRepository)
    {
        $this->truckRepository = $truckRepository;
    }

    public function index()
    {
        $truckers = $this->truckRepository->getAll();
        return response()->json($truckers);
    }

    public function getTruckDriversData()
    {
        $truckers = $this->truckRepository->getTruckDriversData();
        return response()->json($truckers);
    }

    public function getTruckAssociatedWithDriver($id)
    {
        $truckers = $this->truckRepository->getTruckAssociatedWithDriver($id);
        return response()->json($truckers);
    }

    public function show($id)
    {
        $truck = $this->truckRepository->find($id);
        if (!$truck) {
            return response()->json(['error' => 'Truck not found'], 404);
        }
        return response()->json($truck);
    }

    public function findTruckDriversData($id)
    {
        $truck = $this->truckRepository->findTruckDriversData($id);
        if (!$truck) {
            return response()->json(['error' => 'Driver not found'], 404);
        }
        return response()->json($truck);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'id_driver_tbt' => 'required|integer|exists:tb_driver,id_driver_tbd',
                'id_model_truck_tbt' => 'required|integer|exists:tb_model_truck,id_model_truck_tmt',
                'plate_truck_tbt' => 'required|string|max:7|unique:tb_truck',
            ]);

            $truck = $this->truckRepository->create($data);
            return response()->json($truck, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->validator->errors(),
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $truck = $this->truckRepository->find($id);

            if (!$truck) {
                return response()->json(['error' => 'Truck not found.'], 404);
            }

            $data = $request->validate([
                'id_driver_tbt' => 'sometimes|integer|exists:tb_driver,id_driver_tbd',
                'id_model_truck_tbt' => 'sometimes|integer|exists:tb_model_truck,id_model_truck_tmt',
                'plate_truck_tbt' => 'sometimes|string|max:7|unique:tb_truck',
            ]);

            $truck = $this->truckRepository->update($id, $data);
            return response()->json($truck);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->validator->errors(),
            ], 422);
        }
    }


    public function destroy($id)
    {
        $deleted = $this->truckRepository->delete($id);
        if (!$deleted) {
            return response()->json(['error' => 'Truck not found'], 404);
        }

        return response()->json(['message' => 'Truck deleted successfully']);
    }
}
