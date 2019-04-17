CREATE VIEW employee_delivery_report AS
SELECT ShiftSession, E.EmployeeID, E.FirstName, E.MiddleName, E.LastName, V.VIN, O.OfficeID, P.PackageID, P.dest_ZIP, P.Weight, T.Status FROM employee AS E, package AS P, vehicle AS V, office AS O, shift as S, status as T WHERE E.OfficeID = o.OfficeID AND E.EmployeeID = S.EmployeeID AND S.VehicleID = V.VIN AND P.Status = T.Code ORDER BY E.EmployeeID ASC


