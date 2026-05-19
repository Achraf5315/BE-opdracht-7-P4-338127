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
        'ModifiedDate'
    ];

    public function GetAllVehicles(): array 
    {
        return DB::select('CALL sp_GetAllVehicles()');
    }
}