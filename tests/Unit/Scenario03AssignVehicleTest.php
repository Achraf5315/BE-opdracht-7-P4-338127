<?php

namespace Tests\Unit;

use App\Http\Controllers\InstructorController;
use App\Http\Controllers\VehicleController;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class Scenario03AssignVehicleTest extends TestCase
{
    public function test_assigns_unassigned_vehicle_and_updates_fields(): void
    {
        // Vehicle is initially unassigned
        $vehicleRow = (object) [
            'Id' => 11,
            'LicensePlate' => 'STP-12-U',
            'Model' => 'Kymco',
            'YearOfManufacture' => '2022-07-02',
            'FuelType' => 'Benzine',
            'VehicleTypeId' => 4,
            'InstructorId' => null,
        ];

        // Mock Vehicle model call
        $vehicleModelMock = Mockery::mock(Vehicle::class)->shouldAllowMockingProtectedMethods();
        $vehicleModelMock->shouldReceive('GetVehicleForEdit')->with(11)->andReturn($vehicleRow);

        // create controller with injected vehicle mock
        $controller = new VehicleController($vehicleModelMock, new InstructorController);

        DB::shouldReceive('transaction')
            ->once()
            ->andReturnUsing(function ($closure) {
                return $closure();
            });

        DB::shouldReceive('statement')
            ->once()
            ->with('CALL sp_UpdateVehicleAndAssignment(?, ?, ?, ?, ?, ?, ?, ?)', Mockery::any())
            ->andReturnTrue();

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')
            ->once()
            ->andReturn([
                'license_plate' => 'STP-12-U',
                'model' => 'Kymco',
                'year_of_manufacture' => '2022-07-02',
                'fuel_type' => 'Elektrisch',
                'vehicle_type_id' => 4,
                'remark' => null,
                'instructor_id' => 5,
            ]);

        $response = $controller->update($request, 5, 11);

        $this->assertNotNull($response);
    }
}
