DROP PROCEDURE IF EXISTS sp_GetAllVehichles;

DELIMITER $$

CREATE PROCEDURE sp_GetAllVehichles()
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
        v.CreatedDate,
        v.ModifiedDate
    FROM Vehicle v;
END$$

DELIMITER ;

CALL sp_GetAllVehichles();