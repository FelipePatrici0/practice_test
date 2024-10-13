<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CarrierRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ValidateDocuments;



class CarrierController extends Controller
{
    use ValidateDocuments;

    protected $carrierRepository;

    public function __construct(CarrierRepositoryInterface $carrierRepository)
    {
        $this->carrierRepository = $carrierRepository;
    }

    public function index()
    {
        $carriers = $this->carrierRepository->getAll();
        return response()->json($carriers);
    }

    public function show($id)
    {
        $carrier = $this->carrierRepository->find($id);
        if (!$carrier) {
            return response()->json(['error' => 'Carrier not found'], 404);
        }
        return response()->json($carrier);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name_carrier_tbc' => 'required|string|max:100',
                'cnpj_carrier_tbc' => 'required|string|size:14|unique:tb_carrier',
            ]);

            if (!$this->isValidCNPJ($request['cnpj_carrier_tbc'])) {
                return response()->json(['error' => 'Invalid CNPJ please check and try again.'], 422);
            }

            $carrier = $this->carrierRepository->create($data);
            return response()->json($carrier, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->validator->errors(),
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $carrier = $this->carrierRepository->find($id);

            if (!$carrier) {
                return response()->json(['error' => 'Carrier not found.'], 404);
            }

            $data = $request->validate([
                'name_carrier_tbc' => 'sometimes|string|max:100',
                'cnpj_carrier_tbc' => 'sometimes|string|size:14|unique:tb_carrier'
            ]);

            if (isset($data['cnpj_carrier_tbc']) && !$this->isValidCNPJ($data['cnpj_carrier_tbc'])) {
                return response()->json(['error' => 'Invalid CNPJ, please check and try again.'], 422);
            }

            $carrier = $this->carrierRepository->update($id, $data);
            return response()->json($carrier);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->validator->errors(),
            ], 422);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->carrierRepository->delete($id);
        if (!$deleted) {
            return response()->json(['error' => 'Carrier not found'], 404);
        }

        return response()->json(['message' => 'Carrier deleted successfully']);
    }

    public function activate($id = null)
    {
        if (is_null($id)) {
            return response()->json(['error' => 'ID is required.'], 400);
        }

        $carrier = $this->carrierRepository->find($id);
        if (!$carrier) {
            return response()->json(['error' => 'Carrier not found.'], 404);
        }

        if ($carrier->is_active_tbc) {
            return response()->json(['message' => 'Carrier is already active.'], 422);
        }

        $this->carrierRepository->updateActiveStatus($id, true);
        return response()->json(['message' => 'Carrier activated successfully.']);
    }


    public function deactivate($id = null)
    {
        if (is_null($id)) {
            return response()->json(['error' => 'ID is required.'], 400);
        }

        $carrier = $this->carrierRepository->find($id);
        if (!$carrier) {
            return response()->json(['error' => 'Carrier not found.'], 404);
        }

        if (!$carrier->is_active_tbc) {
            return response()->json(['message' => 'Carrier is already inactive.'], 422);
        }

        $this->carrierRepository->updateActiveStatus($id, false);
        return response()->json(['message' => 'Carrier deactivated successfully.']);
    }



}
