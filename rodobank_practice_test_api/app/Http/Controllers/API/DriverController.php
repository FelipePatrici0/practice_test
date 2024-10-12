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
            return response()->json(['error' => 'Driver not found'], 404);
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
                'email_driver_tbd'     => 'sometimes|string|email',
            ]);

            if (!$this->isValidCPF($request['cpf_driver_tbd'])) {
                return response()->json(['error' => 'Invalid CPF please check and try again.'], 422);
            }

            $birthdate = \Carbon\Carbon::parse($request['birthdate_driver_tbd']);
            $age = $birthdate->diffInYears(now());

            if ($age < 18) {
                return response()->json(['error' => 'Driver must be at least 18 years old.'], 422);
            }

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
            $driver = $this->driverRepository->find($id);

            if (!$driver) {
                return response()->json(['error' => 'Driver not found.'], 404);
            }

            $data = $request->validate([
                'name_driver_tbd'      => 'sometimes|string|max:100',
                'cpf_driver_tbd'       => 'sometimes|string|size:11|unique:tb_driver',
                'birthdate_driver_tbd' => 'sometimes|date',
                'email_driver_tbd'     => 'sometimes|string|email',
            ]);

            if (isset($data['cpf_driver_tbd']) && !$this->isValidCPF($data['cpf_driver_tbd'])) {
                return response()->json(['error' => 'Invalid CPF please check and try again.'], 422);
            }

            if (isset($data['birthdate_driver_tbd'])) {
                $birthdate = \Carbon\Carbon::parse($data['birthdate_driver_tbd']);
                $age = $birthdate->diffInYears(now());

                if ($age < 18) {
                    return response()->json(['error' => 'Driver must be at least 18 years old.'], 422);
                }
            }

            $driver = $this->driverRepository->update($id, $data);
            return response()->json($driver);
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
            return response()->json(['error' => 'Driver not found'], 404);
        }

        return response()->json(['message' => 'Driver deleted successfully']);
    }
}
