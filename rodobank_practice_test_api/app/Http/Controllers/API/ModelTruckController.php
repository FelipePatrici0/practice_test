<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ModelTruckRepositoryInterface;
use Illuminate\Http\Request;

class ModelTruckController extends Controller
{
    protected $modelTruckRepository;

    public function __construct(ModelTruckRepositoryInterface $modelTruckRepository)
    {
        $this->modelTruckRepository = $modelTruckRepository;
    }

    public function index()
    {
        $modelTruckers = $this->modelTruckRepository->getAll();
        return response()->json($modelTruckers);
    }

    public function show($id)
    {
        $modelTruck = $this->modelTruckRepository->find($id);
        if (!$modelTruck) {
            return response()->json(['error' => 'Model Truck not found'], 404);
        }
        return response()->json($modelTruck);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'model_truck_tmt' => 'required|string|max:100',
                'color_truck_tmt' => 'required|string|max:50'
            ]);

            $modelTruck = $this->modelTruckRepository->create($data);
            return response()->json($modelTruck, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->validator->errors(),
            ], 422);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $modelTruck = $this->modelTruckRepository->find($id);

            if (!$modelTruck) {
                return response()->json(['error' => 'Model Truck not found.'], 404);
            }

            $data = $request->validate([
                'model_truck_tmt' => 'sometimes|string|max:100',
                'color_truck_tmt' => 'sometimes|string|max:50'
            ]);

            $modelTruck = $this->modelTruckRepository->update($id, $data);
            return response()->json($modelTruck);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->validator->errors(),
            ], 422);
        }
    }


    public function destroy($id)
    {
        $deleted = $this->modelTruckRepository->delete($id);
        if (!$deleted) {
            return response()->json(['error' => 'Model Truck not found'], 404);
        }

        return response()->json(['message' => 'Model Truck deleted successfully']);
    }
}
