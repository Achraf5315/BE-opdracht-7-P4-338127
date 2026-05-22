<?php

namespace Tests\Unit;

use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class VehicleUpdateTest extends TestCase
{
    public function test_update_calls_procedure_with_null_instructor_to_unassign(): void
    {
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
                'license_plate' => 'DRS-52-E',
                'model' => 'Vespa Piaggio',
                'year_of_manufacture' => '2022-03-21',
                'fuel_type' => 'Elektrisch',
                'vehicle_type_id' => 4,
                'remark' => 'test',
                'instructor_id' => null,
            ]);

        $controller = new VehicleController;
        $response = $controller->update($request, 1, 10);

        $this->assertNotNull($response);
    }
}
