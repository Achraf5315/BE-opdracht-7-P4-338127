<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\InstructorController;

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

        $vehicles = $this->VehicleModel->GetAllVehicles();

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
    public function edit(Vehicle $vehicle) {

        return view('vehicle.edit', [
            'vehicle' => $vehicle,
        ]);
        
    }
    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
