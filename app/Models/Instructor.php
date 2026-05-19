<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Instructor extends Model
{
    protected $table = 'Instructor';
    protected $primaryKey = 'Id';
    protected $fillable = [
        'FirstName',
        'MiddleName',
        'LastName',
        'Mobile',
        'StartDate',
        'NumberOfStars',
        'IsActive',
        'Remark',
        'CreatedDate',
        'ModifiedDate'
    ];

    public static function instructorCount(): mixed
    {
        return DB::selectOne('CALL sp_InstructorsCount()');
    }

    public static function getAllInstructors(): array
    {
        return DB::select('CALL sp_GetAllInstructors()');
    }

    public function GetAllInstructorVehicles(int $instructorId): mixed
    {
        return DB::select('CALL sp_GetAllInstructorVehicles(?)', [$instructorId]);
    }
}
