DROP DATABASE IF EXISTS assignment_7;

CREATE DATABASE assignment_7;

USE assignment_7;

CREATE TABLE VehicleType (
    Id                 INT      NOT NULL PRIMARY KEY AUTO_INCREMENT
    ,VehicleType        VARCHAR(50)  NOT NULL
    ,LicenseCategory    CHAR(3)      NOT NULL
    ,IsActive           BOOLEAN      NOT NULL DEFAULT 1
    ,Remark             VARCHAR(255)
    ,CreatedDate        DATETIME(6)  NOT NULL DEFAULT NOW(6)
    ,ModifiedDate       DATETIME(6)  NOT NULL DEFAULT NOW(6)
    );

CREATE TABLE Vehicle (
    Id               INT      NOT NULL PRIMARY KEY AUTO_INCREMENT
    ,LicensePlate     VARCHAR(10)  NOT NULL UNIQUE
    ,Model            VARCHAR(50)  NOT NULL
    ,YearOfManufacture DATE        NOT NULL
    ,FuelType         VARCHAR(20)  NOT NULL 
    ,VehicleTypeId    INT      NOT NULL
    ,IsActive         BOOLEAN      NOT NULL DEFAULT 1
    ,Remark           VARCHAR(255)
    ,CreatedDate      DATETIME(6)  NOT NULL DEFAULT NOW(6)
    ,ModifiedDate     DATETIME(6)  NOT NULL DEFAULT NOW(6)
    ,CONSTRAINT fk_vehicle_vehicletype FOREIGN KEY (VehicleTypeId) REFERENCES VehicleType(Id)
);

CREATE TABLE Instructor (
    Id              INT      NOT NULL PRIMARY KEY AUTO_INCREMENT
    ,FirstName       VARCHAR(50)  NOT NULL
    ,MiddleName      VARCHAR(20)
    ,LastName        VARCHAR(100) NOT NULL
    ,Mobile          VARCHAR(15)  NOT NULL UNIQUE
    ,StartDate       DATE         NOT NULL
    ,NumberOfStars   INT      NOT NULL DEFAULT 1 CHECK (NumberOfStars BETWEEN 1 AND 5)
    ,IsActive        BOOLEAN      NOT NULL DEFAULT 1
    ,Remark          VARCHAR(255)
    ,CreatedDate     DATETIME(6)  NOT NULL DEFAULT NOW(6)
    ,ModifiedDate    DATETIME(6)  NOT NULL DEFAULT NOW(6)
);

CREATE TABLE VehicleInstructor (
    Id              INT NOT NULL PRIMARY KEY AUTO_INCREMENT
    ,VehicleId       INT NOT NULL
    ,InstructorId    INT NOT NULL
    ,AssignmentDate  DATE    NOT NULL
    ,IsActive        BOOLEAN NOT NULL DEFAULT 1
    ,Remark          VARCHAR(255)
    ,CreatedDate     DATETIME(6)  NOT NULL DEFAULT NOW(6)
    ,ModifiedDate    DATETIME(6)  NOT NULL DEFAULT NOW(6)
    ,CONSTRAINT fk_vi_vehicle FOREIGN KEY (VehicleId) REFERENCES Vehicle(Id)
    ,CONSTRAINT fk_vi_instructor FOREIGN KEY (InstructorId) REFERENCES Instructor(Id)
    ,CONSTRAINT uq_vehicle_instructor_date UNIQUE (VehicleId, InstructorId, AssignmentDate)
);

INSERT INTO VehicleType (Id, VehicleType, LicenseCategory, CreatedDate, ModifiedDate)
VALUES
    (1, 'Personenauto', 'B', NOW(6), NOW(6))
    ,(2, 'Vrachtwagen', 'C', NOW(6), NOW(6))
    ,(3, 'Bus', 'D', NOW(6), NOW(6))
    ,(4, 'Bromfiets', 'AM', NOW(6), NOW(6));

INSERT INTO Vehicle (Id, LicensePlate, Model, YearOfManufacture, FuelType, VehicleTypeId, CreatedDate, ModifiedDate)
VALUES
    (1, 'AU-67-IO', 'Golf', '2017-06-12', 'Diesel', 1, NOW(6), NOW(6))
    ,(2, 'TR-24-OP', 'DAF', '2019-05-23', 'Diesel', 2, NOW(6), NOW(6))
    ,(3, 'TH-78-KL', 'Mercedes', '2023-01-01', 'Benzine', 1, NOW(6), NOW(6))
    ,(4, '90-KL-TR', 'Fiat 500', '2021-09-12', 'Benzine', 1, NOW(6), NOW(6))
    ,(5, '34-TK-LP', 'Scania', '2015-03-13', 'Diesel', 2, NOW(6), NOW(6))
    ,(6, 'YY-OP-78', 'BMW M5', '2022-05-13', 'Diesel', 1, NOW(6), NOW(6))
    ,(7, 'UU-HH-JK', 'M.A.N', '2017-12-03', 'Diesel', 2, NOW(6), NOW(6))
    ,(8, 'ST-FZ-28', 'Citroën', '2018-01-20', 'Elektrisch', 1, NOW(6), NOW(6))
    ,(9, '123-FR-T', 'Piaggio ZIP', '2021-02-01', 'Benzine', 4, NOW(6), NOW(6))
    ,(10, 'DRS-52-P', 'Vespa', '2022-03-21', 'Benzine', 4, NOW(6), NOW(6))
    ,(11, 'STP-12-U', 'Kymco', '2022-07-02', 'Benzine', 4, NOW(6), NOW(6))
    ,(12, '45-SD-23', 'Renault', '2023-01-01', 'Diesel', 3, NOW(6), NOW(6));

INSERT INTO Instructor (Id, FirstName, MiddleName, LastName, Mobile, StartDate, NumberOfStars, CreatedDate, ModifiedDate)
VALUES
    (1, 'Li', NULL, 'Zhan', '06-28493827', '2015-04-17', '***', NOW(6), NOW(6))
    ,(2, 'Leroy', NULL, 'Boerhaven', '06-39398734', '2018-06-25', '*', NOW(6), NOW(6))
    ,(3, 'Yoeri', 'Van', 'Veen', '06-24383291', '2010-05-12', '***', NOW(6), NOW(6))
    ,(4, 'Bert', 'Van', 'Sali', '06-48293823', '2023-01-10', '****', NOW(6), NOW(6))
    ,(5, 'Mohammed', 'El', 'Yassidi', '06-34291234', '2010-06-14', '*****', NOW(6), NOW(6));

INSERT INTO VehicleInstructor (Id, VehicleId, InstructorId, AssignmentDate, CreatedDate, ModifiedDate)
VALUES
    (1, 1, 5, '2017-06-18', NOW(6), NOW(6))
    ,(2, 3, 1, '2021-09-26', NOW(6), NOW(6))
    ,(3, 9, 1, '2021-09-27', NOW(6), NOW(6))
    ,(4, 4, 4, '2022-08-01', NOW(6), NOW(6))
    ,(5, 5, 1, '2019-08-30', NOW(6), NOW(6))
    ,(6, 10, 5, '2020-02-02', NOW(6), NOW(6));
