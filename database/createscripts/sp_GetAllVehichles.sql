DROP PROCEDURE IF EXISTS sp_GetAllVehicles;

DELIMITER $$

CREATE PROCEDURE sp_GetAllVehicles(
    IN p_InstructorId INT
)
BEGIN
    SELECT
        v.Id,
        i.Id AS InstructorId, 
        v.LicensePlate,
        v.Model,
        v.YearOfManufacture,
        v.FuelType,
        v.VehicleTypeId,
        v.IsActive,
        v.Remark,
        v.CreatedDate,
        v.ModifiedDate
    FROM Vehicle v
    LEFT JOIN VehicleInstructor vi ON v.Id = vi.VehicleId
    LEFT JOIN Instructor i ON vi.InstructorId = i.Id
    WHERE i.Id = p_InstructorId;
END $$

DELIMITER ;

CALL sp_GetAllVehicles(5);

