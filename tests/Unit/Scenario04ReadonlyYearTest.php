<?php

namespace Tests\Unit;

use App\Http\Controllers\InstructorController;
use App\Http\Controllers\VehicleController;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class Scenario04ReadonlyYearTest extends TestCase
{
    public function test_cannot_change_year_of_assigned_vehicle(): void
    {
        // Vehicle is assigned to an instructor
        $vehicleRow = (object) [
            'Id' => 2,
            'LicensePlate' => 'TR-24-OP',
            'Model' => 'DAF',
            'YearOfManufacture' => '2019-05-23',
            'FuelType' => 'Diesel',
            'VehicleTypeId' => 2,
            'InstructorId' => 1,
        ];

        // Mock Vehicle model call
        $vehicleModelMock = Mockery::mock(Vehicle::class)->shouldAllowMockingProtectedMethods();
        $vehicleModelMock->shouldReceive('GetVehicleForEdit')->with(2)->andReturn($vehicleRow);

        // create controller with injected vehicle mock
        $controller = new VehicleController($vehicleModelMock, new InstructorController);

        DB::shouldReceive('transaction')
            ->once()
            ->andReturnUsing(function ($closure) {
                return $closure();
            });

        // Expect statement called with the original year (2019-05-23)
        DB::shouldReceive('statement')
            ->once()
            ->withArgs(function ($query, $bindings) {
                if (stripos($query, 'sp_UpdateVehicleAndAssignment') === false) {
                    return false;
                }

                // bindings[3] corresponds to year_of_manufacture param
                return isset($bindings[3]) && $bindings[3] === '2019-05-23';
            })
            ->andReturnTrue();

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('validate')
            ->once()
            ->andReturn([
                'license_plate' => 'TR-24-OP',
                'model' => 'DAF',
                // user tries to change year but UI is readonly
                'year_of_manufacture' => '2020-01-01',
                'fuel_type' => 'Diesel',
                'vehicle_type_id' => 2,
                'remark' => null,
                'instructor_id' => 1,
            ]);

        $response = $controller->update($request, 1, 2);

        $this->assertNotNull($response);
    }
}
