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
        DB::statement('DROP PROCEDURE IF EXISTS sp_GetAvailableVehicles');
        DB::statement(<<<'SQL'
            CREATE PROCEDURE sp_GetAvailableVehicles()
            BEGIN
                SELECT
                    v.Id,
                    v.LicensePlate,
                    v.Model,
                    v.YearOfManufacture,
                    v.FuelType,
                    v.VehicleTypeId,
                    vt.VehicleType,
                    vt.LicenseCategory
                FROM Vehicle v
                INNER JOIN VehicleType vt ON v.VehicleTypeId = vt.Id
                LEFT JOIN VehicleInstructor vi ON v.Id = vi.VehicleId AND vi.IsActive = 1
                WHERE v.IsActive = 1
                    AND vt.IsActive = 1
                    AND vi.Id IS NULL
                ORDER BY vt.LicenseCategory ASC, v.Model ASC;
            END
        SQL
        );

        DB::statement('DROP PROCEDURE IF EXISTS sp_GetVehicleForEdit');
        DB::statement(<<<'SQL'
            CREATE PROCEDURE sp_GetVehicleForEdit(
                IN p_vehicleId INTEGER
            )
            BEGIN
                SELECT
                    v.Id,
                    v.LicensePlate,
                    v.Model,
                    v.YearOfManufacture,
                    v.FuelType,
                    v.VehicleTypeId,
                    v.IsActive,
                    v.Remark,
                    vi.Id AS VehicleInstructorId,
                    vi.InstructorId,
                    CONCAT_WS(' ', i.FirstName, i.MiddleName, i.LastName) AS InstructorName,
                    vt.VehicleType,
                    vt.LicenseCategory
                FROM Vehicle v
                INNER JOIN VehicleType vt ON v.VehicleTypeId = vt.Id
                LEFT JOIN VehicleInstructor vi ON v.Id = vi.VehicleId AND vi.IsActive = 1
                LEFT JOIN Instructor i ON vi.InstructorId = i.Id AND i.IsActive = 1
                WHERE v.Id = p_vehicleId
                LIMIT 1;
            END
        SQL
        );

        DB::statement('DROP PROCEDURE IF EXISTS sp_UpdateVehicleAndAssignment');
        DB::statement(<<<'SQL'
            CREATE PROCEDURE sp_UpdateVehicleAndAssignment(
                IN p_vehicleId INTEGER,
                IN p_licensePlate VARCHAR(20),
                IN p_model VARCHAR(100),
                IN p_year_of_manufacture DATE,
                IN p_fuel_type VARCHAR(50),
                IN p_vehicle_type_id INTEGER,
                IN p_remark VARCHAR(250),
                IN p_instructor_id INTEGER
            )
            BEGIN
                DECLARE vi_id INT DEFAULT NULL;
                DECLARE vi_instructor INT DEFAULT NULL;

                -- update vehicle
                UPDATE Vehicle
                SET LicensePlate = p_licensePlate,
                    Model = p_model,
                    YearOfManufacture = p_year_of_manufacture,
                    FuelType = p_fuel_type,
                    VehicleTypeId = p_vehicle_type_id,
                    Remark = p_remark,
                    ModifiedDate = NOW()
                WHERE Id = p_vehicleId;

                IF EXISTS (SELECT 1 FROM VehicleInstructor WHERE VehicleId = p_vehicleId AND IsActive = 1) THEN
                    SELECT Id, InstructorId INTO vi_id, vi_instructor
                    FROM VehicleInstructor
                    WHERE VehicleId = p_vehicleId AND IsActive = 1
                    LIMIT 1;
                END IF;

                IF p_instructor_id IS NULL THEN
                    IF vi_id IS NOT NULL THEN
                        UPDATE VehicleInstructor
                        SET IsActive = 0,
                            ModifiedDate = NOW()
                        WHERE Id = vi_id;
                    END IF;
                ELSE
                    IF vi_id IS NOT NULL THEN
                        IF vi_instructor != p_instructor_id THEN
                            UPDATE VehicleInstructor
                            SET InstructorId = p_instructor_id,
                                AssignmentDate = CURDATE(),
                                ModifiedDate = NOW()
                            WHERE Id = vi_id;
                        END IF;
                    ELSE
                        INSERT INTO VehicleInstructor (VehicleId, InstructorId, AssignmentDate, IsActive, Remark, CreatedDate, ModifiedDate)
                        VALUES (p_vehicleId, p_instructor_id, CURDATE(), 1, p_remark, NOW(), NOW());
                    END IF;
                END IF;
            END
        SQL
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP PROCEDURE IF EXISTS sp_GetAvailableVehicles');
        DB::statement('DROP PROCEDURE IF EXISTS sp_GetVehicleForEdit');
        DB::statement('DROP PROCEDURE IF EXISTS sp_UpdateVehicleAndAssignment');
    }
};
