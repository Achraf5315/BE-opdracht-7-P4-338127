<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP PROCEDURE IF EXISTS sp_InstructorsCount');
        DB::statement('
            CREATE PROCEDURE sp_InstructorsCount()
            BEGIN
                SELECT COUNT(*) AS InstructorsCount
                FROM Instructor;
            END 
        ');

        DB::statement('DROP PROCEDURE IF EXISTS sp_GetAllInstructors');
        DB::statement('
            CREATE PROCEDURE sp_GetAllInstructors()
            BEGIN
                SELECT 
                    Id,
                    CONCAT_WS(\' \', FirstName, MiddleName, LastName) AS FullName,
                    Mobile,
                    StartDate,
                    NumberOfStars
                FROM Instructor
                WHERE IsActive = 1
                GROUP BY Id, FirstName, MiddleName, LastName, Mobile, StartDate, NumberOfStars
                ORDER BY NumberOfStars DESC;
            END 
        ');

        DB::statement('DROP PROCEDURE IF EXISTS sp_GetAllInstructorVehicles');
        DB::statement('
            CREATE PROCEDURE sp_GetAllInstructorVehicles(
                IN p_InstructorId INTEGER
            )
            BEGIN
                SELECT
                    i.Id AS InstructorId,
                    i.FullName,
                    i.StartDate,
                    i.NumberOfStars,
                    v.Id AS VehicleId,
                    v.LicensePlate,
                    v.Model,
                    v.YearOfManufacture,
                    v.FuelType,
                    vt.VehicleType,
                    vt.LicenseCategory
                FROM (
                    SELECT 
                        Id,
                        CONCAT_WS(\' \', FirstName, MiddleName, LastName) AS FullName,
                        StartDate,
                        NumberOfStars
                    FROM Instructor
                    WHERE IsActive = 1
                ) AS i
                LEFT JOIN VehicleInstructor vi ON i.Id = vi.InstructorId AND vi.IsActive = 1
                LEFT JOIN Vehicle v ON vi.VehicleId = v.Id AND v.IsActive = 1
                LEFT JOIN VehicleType vt ON v.VehicleTypeId = vt.Id AND vt.IsActive = 1
                WHERE i.Id = p_InstructorId;
            END 
        ');
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
