<?php

namespace Tests\Unit;

use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class VehicleModelTest extends TestCase
{
    public function test_it_fetches_available_vehicles_with_the_expected_query(): void
    {
        DB::shouldReceive('select')
            ->once()
            ->with('CALL sp_GetAvailableVehicles()')
            ->andReturn([]);

        $vehicles = (new Vehicle)->GetAvailableVehicles();

        $this->assertSame([], $vehicles);
    }

    public function test_it_fetches_a_vehicle_for_edit_with_the_expected_query(): void
    {
        DB::shouldReceive('select')
            ->once()
            ->with('CALL sp_GetVehicleForEdit(?)', [9])
            ->andReturn([(object) [
                'Id' => 9,
                'Model' => 'Vespa',
            ]]);

        $vehicle = (new Vehicle)->GetVehicleForEdit(9);

        $this->assertSame(9, $vehicle->Id);
        $this->assertSame('Vespa', $vehicle->Model);
    }
}
