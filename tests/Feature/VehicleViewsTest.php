<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

class VehicleViewsTest extends TestCase
{
    public function test_vehicle_routes_are_registered(): void
    {
        $this->assertTrue(Route::has('vehicle.index'));
        $this->assertTrue(Route::has('vehicle.edit'));
        $this->assertTrue(Route::has('vehicle.update'));
    }

    public function test_vehicle_edit_view_renders(): void
    {
        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn((object) [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $html = view('vehicle.edit', [
            'instructorId' => 1,
            'vehicleId' => 9,
            'vehicle' => (object) [
                'Id' => 9,
                'LicensePlate' => 'DRS-52-P',
                'Model' => 'Vespa',
                'YearOfManufacture' => '2022-03-21',
                'FuelType' => 'Benzine',
                'VehicleTypeId' => 4,
                'Remark' => null,
                'InstructorId' => 5,
                'InstructorName' => 'Mohammed El Yassidi',
            ],
            'instructors' => collect([
                (object) [
                    'Id' => 5,
                    'FirstName' => 'Mohammed',
                    'MiddleName' => 'El',
                    'LastName' => 'Yassidi',
                ],
            ]),
            'vehicleTypes' => collect([
                (object) [
                    'Id' => 4,
                    'VehicleType' => 'Bromfiets',
                    'LicenseCategory' => 'AM',
                ],
            ]),
            'fuelTypes' => ['Benzine', 'Diesel', 'Elektrisch'],
            'errors' => new ViewErrorBag,
        ])->render();

        $this->assertStringContainsString('Voertuig wijzigen', $html);
        $this->assertStringContainsString('name="instructor_id"', $html);
        $this->assertStringContainsString('name="year_of_manufacture"', $html);
        $this->assertStringContainsString('readonly', $html);
    }
}
