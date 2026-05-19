USE assignment_7;

DROP PROCEDURE IF EXISTS sp_GetAllInstructorVehicles;

DELIMITER $$

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
            CONCAT_WS(' ', FirstName, MiddleName, LastName) AS FullName,
            StartDate,
            NumberOfStars
        FROM Instructor
        WHERE IsActive = 1
    ) AS i
    LEFT JOIN VehicleInstructor vi ON i.Id = vi.InstructorId AND vi.IsActive = 1
    LEFT JOIN Vehicle v ON vi.VehicleId = v.Id AND v.IsActive = 1
    LEFT JOIN VehicleType vt ON v.VehicleTypeId = vt.Id AND vt.IsActive = 1
    WHERE i.Id = p_InstructorId;
END $$

DELIMITER ;

CALL sp_GetAllInstructorVehicles(4);