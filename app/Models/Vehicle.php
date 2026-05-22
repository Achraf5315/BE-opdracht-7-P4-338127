<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vehicle extends Model
{
    protected $table = 'Vehicle';

    protected $primaryKey = 'Id';

    protected $fillable = [
        'LicensePlate',
        'Model',
        'YearOfManufacture',
        'FuelType',
        'VehicleTypeId',
        'IsActive',
        'Remark',
        'CreatedDate',
        'ModifiedDate',
    ];

    public function GetAllVehicles(int $InstructorId): array
    {
        return DB::select('CALL sp_GetAllVehicles(?)', [$InstructorId]);
    }

    public function GetAvailableVehicles(): array
    {
        return DB::select('CALL sp_GetAvailableVehicles()');
    }

    public function GetVehicleForEdit(int $vehicleId): ?object
    {
        $rows = DB::select('CALL sp_GetVehicleForEdit(?)', [$vehicleId]);
        if (empty($rows)) {
            return null;
        }

        return $rows[0];
    }
}
