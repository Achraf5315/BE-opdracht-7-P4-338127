<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class VehicleController extends Controller
{
    private Vehicle $VehicleModel;

    private InstructorController $InstructorController;

    public function __construct()
    {
        $this->VehicleModel = new Vehicle;
        $this->InstructorController = new InstructorController;
    }

    public function index(int $instructorId)
    {
        $instructor = $this->InstructorController->InstructorInformation($instructorId);

        $allVehicles = $this->VehicleModel->GetAvailableVehicles();

        $perPage = 4;
        $page = (int) request()->get('page', 1);
        $offset = ($page - 1) * $perPage;
        $items = array_slice($allVehicles, $offset, $perPage);

        $vehicles = new LengthAwarePaginator(
            $items,
            count($allVehicles),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('vehicle.index', [
            'instructor' => $instructor,
            'vehicles' => $vehicles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $instructorId, int $vehicleId): View
    {
        $vehicle = $this->VehicleModel->GetVehicleForEdit($vehicleId);

        abort_if($vehicle === null, 404);

        return view('vehicle.edit', [
            'instructorId' => $instructorId,
            'vehicleId' => $vehicleId,
            'vehicle' => $vehicle,
            'instructors' => Instructor::query()
                ->select(['Id', 'FirstName', 'MiddleName', 'LastName'])
                ->where('IsActive', 1)
                ->orderBy('FirstName')
                ->orderBy('LastName')
                ->get(),
            'vehicleTypes' => VehicleType::query()
                ->select(['Id', 'VehicleType', 'LicenseCategory'])
                ->where('IsActive', 1)
                ->orderBy('LicenseCategory')
                ->get(),
            'fuelTypes' => ['Benzine', 'Diesel', 'Elektrisch'],
        ]);
    }

    public function update(Request $request, int $instructorId, int $vehicleId): RedirectResponse
    {
        $validated = $request->validate([
            'license_plate' => [
                'required',
                'string',
                'max:10',
                Rule::unique('Vehicle', 'LicensePlate')->ignore($vehicleId, 'Id'),
            ],
            'model' => ['required', 'string', 'max:50'],
            'year_of_manufacture' => ['required', 'date'],
            'fuel_type' => ['required', Rule::in(['Benzine', 'Diesel', 'Elektrisch'])],
            'vehicle_type_id' => ['required', 'integer', Rule::exists('VehicleType', 'Id')],
            'instructor_id' => ['nullable', 'integer', Rule::exists('Instructor', 'Id')],
            'remark' => ['nullable', 'string', 'max:250'],
        ]);

        DB::transaction(function () use ($validated, $vehicleId) {
            DB::statement('CALL sp_UpdateVehicleAndAssignment(?, ?, ?, ?, ?, ?, ?, ?)', [
                $vehicleId,
                $validated['license_plate'],
                $validated['model'],
                $validated['year_of_manufacture'],
                $validated['fuel_type'],
                $validated['vehicle_type_id'],
                $validated['remark'] ?? null,
                $validated['instructor_id'] ?? null,
            ]);
        });

        return redirect()
            ->route('instructor.details', ['instructorId' => $instructorId])
            ->with('success', 'Voertuiggegevens zijn gewijzigd.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
