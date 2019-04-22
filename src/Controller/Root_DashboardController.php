<?php

namespace App\Controller;

use App\Entity\Tracking;
use App\Entity\Package;
use App\Entity\Delivery;
use App\Form\CustomerPackageForm;
use App\Form\TrackingForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\DBAL\Driver\Connection;

class Root_DashboardController extends AbstractController {

    //
    public function requestPage($expectedUserType, $defaultRoute) {
        
        $session = $this->get('session');
        if ($session->has('user') && $session->get('user')['type'] == $expectedUserType)  
        {
            return null;
            
        } 
        elseif ($session->has('user') && $session->get('user')['type'] != $expectedUserType){
            $session->clear();
            return $this->redirectToRoute($defaultRoute);
        }
        else {
            // not authenticated
            return $this->redirectToRoute($defaultRoute);
        }
    }

    //
    public function logout() {

        $tracking = new Tracking();
        $trackingForm = $this->createFormBuilder($tracking)
            ->add('Submit', SubmitType::class, [ 'label' => 'Logout', 'attr'=>['class'=>'button is-dark is-fullWidth']] )
            ->getForm();
        return $trackingForm;
    }

    //
    protected function do_logout(Request $request, $form) {
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $session = $this->get('session');
            $session->clear();
            return $this->redirectToRoute('app-main-page');
        }
        return null;
    }

    //
    public function tracking($new_tracking_found=null) {
        if ($new_tracking_found) {
            $tracking = $new_tracking_found;
        } else {
            $tracking = new Tracking();
        }

        $trackingForm = $this->createForm(TrackingForm::class, $tracking);
        return Array($tracking, $trackingForm);
    }

    public function handleTracking(Request $request, $trackingForm, $tracking, $type){
        
        $trackingForm->handleRequest($request);
        if ($trackingForm->isSubmitted() && $trackingForm->isValid()) {
            $tracking = $trackingForm->getData();


            $route = "";
            switch ($type) {
                case "Tracking":
                    $this->get('session')->getFlashBag()->add('trackID', $tracking);
                    $route = "app-customer-tracking-id";
                    break;
                case "Invoice":
                    $this->get('session')->getFlashBag()->add('invoiceID', $tracking);
                    $route = "app-customer-invoice-id";
                    break;
            }
            return $this->redirectToRoute($route, ['id'=>$tracking->getPackageID()]);
        }
        return null;
    }

    //
    protected function createPackage($data = null) {
        $package = new Package();
        if ($data) {
            $package->setEmail($data);
        }
        $packageForm = $this->createForm(CustomerPackageForm::class, $package);
        return Array($package, $packageForm);
    }

    
    protected function getTotal($weight, $limit, $multiplier, $baseprice) {
        $overLimitPenalty = 0;

        if($weight > $limit) {
            $overLimitPenalty = ($weight-$limit) * $multiplier;
        }
        return Array($baseprice, $overLimitPenalty);
    }

    /*******************************************************************************
     * All Dashboard Queries
    *******************************************************************************/
    protected function CustomerDetailsQuery(Connection $connection, $identity) {
        try{
            $sql = "SELECT FName, LName FROM customer WHERE customer.Email = :email;";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':email', $identity);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function EmployeesDetailsQuery(Connection $connection, $identity) {
        try{
            $sql = "SELECT FirstName, LastName, OfficeID FROM  employee WHERE employee.EmployeeID = :id;";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $identity);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function ReportEmployeeDeliveryQuery(Connection $connection) {
        try{
            //$sql = "SELECT * FROM employee_delivery_report";
            $sql = "SELECT  DISTINCT E.EmployeeID, E.FirstName, E.MiddleName, E.LastName, E.OfficeID, St.Status, S.VehicleID, P.PackageID, P.dest_ZIP, P.Weight
                    FROM employee AS E, package AS P, vehicle AS V, office AS O, shift as S, status as St, Tracking AS T
                    WHERE S.VehicleID = V.VIN 
                        AND E.OfficeID = O.OfficeID 
                        AND E.EmployeeID = S.EmployeeID 
                        AND P.Status = St.Code 
                        AND P.PackageID = T.Package_ID 
                        AND T.OfficeID = E.OfficeID
                    ORDER BY P.PackageID ASC";

            $stmt = $connection->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function ReportEmployeeStats(Connection $connection) {
        try{
            //Requires trigger: when a shift is inserted into the shift table
            //get the shift id, use shift vehicle to link with package vehicle and assign shift id to that package
            //get each shift, the employee associated with the shift, the number of packages handled and delivered, and datetime information about the shift
            $sql = "SELECT S.ShiftSession, E.EmployeeID, E.FirstName, E.MiddleName, E.LastName,S.Clock_in_dateTime, S.Hours_Worked, S.VehicleID, COUNT(DISTINCT T.Package_ID) AS Delivered, E.OfficeID
                    FROM shift AS S, employee AS E, package AS P, tracking AS T
                    WHERE S.EmployeeID = E.EmployeeID AND S.ShiftSession = T.ShiftID
                    GROUP BY S.ShiftSession
                    ORDER BY E.EmployeeID
            ";

            $stmt = $connection->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function ReportLast30Days(Connection $connection) {
        try{
            //Requires trigger: when a shift is inserted into the shift table
            //get the shift id, use shift vehicle to link with package vehicle and assign shift id to that package
            //get each shift, the employee associated with the shift, the number of packages handled and delivered, and datetime information about the shift


            $sql = "SELECT E.EmployeeID, E.FirstName, E.MiddleName, E.LastName, SUM(S.Hours_Worked) AS TotalHours, E.OfficeID, COUNT(DISTINCT T.Package_ID) AS Delivered
            FROM employee AS E, shift AS S, tracking AS T
            WHERE S.EmployeeID = E.EmployeeID AND S.Clock_in_dateTime < DATE_ADD(NOW(), INTERVAL +1 MONTH) AND S.ShiftSession = T.ShiftID
            GROUP BY S.EmployeeID
            ORDER BY E.OfficeID";

            $stmt = $connection->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function ReportOfficeStats(Connection $connection) {
        //get data number of packages shipped by an office and the total amount of revenue
        try{
            $sql = "SELECT P.return_office, COUNT(P.PackageID) AS TotalPackages, SUM(T.TransactionTotal) AS TotalRev, EE.TotalEmployees
            FROM (package AS P, transaction AS T) LEFT OUTER JOIN (SELECT O.OfficeID, COUNT(DISTINCT E.EmployeeID) AS TotalEmployees FROM employee AS E, office AS O WHERE E.OfficeID = O.OfficeID GROUP BY O.OfficeID) AS EE
            ON EE.OfficeID = P.return_office
            WHERE P.PackageID = T.PackageID
            GROUP BY P.return_office
            ";

            $stmt = $connection->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }


    protected function ReportRegionalOfficeStatistics(Connection $connection) {
        try{
            $sql = "SELECT * FROM get_office_location_statistics";

            $stmt = $connection->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    
    protected function CustomerDashOrdersQuery(Connection $connection, $identity) {
        try{
            $sql = "SELECT p.PackageID as id, t.last_update as date, t.TrackingNote as note, s.Status as status FROM package as p, status as s, (SELECT Tracking_Index, Update_Date, updated_id, last_update, TrackingNote FROM tracking RIGHT JOIN (SELECT tracking.Package_ID as updated_id, max(tracking.Update_Date) as last_update FROM tracking group by tracking.Package_ID) as updated ON tracking.Package_ID = updated.updated_id AND tracking.Update_Date = updated.last_update) as t WHERE p.PackageID = t.updated_id AND p.Email = :email AND p.Status = s.Code ORDER BY t.Update_Date DESC LIMIT 5 ";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':email', $identity);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function CustomerOrdersQuery(Connection $connection, $identity) {
        try{
            $sql = "SELECT p.PackageID as ID, s.Status as Status, p.send_date as Date, t.TransactionID as InvoiceID FROM  package as p, transaction as t, status as s WHERE p.Email = :email AND p.Status = s.Code AND p.PackageID = t.PackageID";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':email', $identity);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function getInvoiceQuery(Connection $connection, $identity, $invoice) {
        try{
            $sql = "SELECT t.TransactionID, p.PackageID as pid, t.TransactionTotal, t.TransactionDate, RecipientName, Email, Weight, Width, Length, Height, v.ServiceName, s.StateName, dest_ApartmentNo, dest_Street, dest_ZIP, dest_City FROM transaction as t, package as p, state as s, service as v where t.PackageID = p.PackageID and t.TransactionID = :iid and p.Email = :email and p.dest_State = s.StateID and v.ServiceID = p.Service";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':email', $identity);
            $stmt->bindValue(':iid', $invoice);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }


    protected function getReturnAddressQuery(Connection $connection, $invoice) {
        try{
            $sql = "SELECT s.StateName, return_ZIP, return_City, return_Street, return_ApartmentNo FROM transaction as t, package as p, state as s where t.TransactionID = :iid and t.PackageID = p.PackageID and p.return_State = s.StateID";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':iid', $invoice);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function getOfficeQuery(Connection $connection, $state) {
        try{
            $sql = "SELECT o.OfficeID, o.Street, o.City, s.StateAbbreviation, o.ZIP FROM office as o, state as s WHERE o.State = :state AND o.State = s.StateID";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':state', $state);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function GetOfficePackages(Connection $connection, $office) {
        try{
            $sql = "SELECT p.VehicleID as VID, p.PackageID as ID, p.Service, s.ServiceName, t.StateAbbreviation as State, p.dest_City as City, p.dest_ZIP as ZIP, p.dest_ApartmentNo as ApartmentNo, p.dest_street as Street FROM package as p, service as s, state as t WHERE p.OfficeID = :office AND p.Service = s.ServiceID AND p.dest_State = t.StateID ORDER BY p.Service DESC";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':office', $office);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function isHomeDeliveryPossibleQuery(Connection $connection, $location, $state) {
        try{
            $sql = "SELECT office.OfficeID FROM office WHERE office.officeID = :office AND office.State = :state";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':office', $location);
            $stmt->bindValue(':state', $state);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function getPackagesForVehicle(Connection $connection, $vehicle) {
        try{
            $sql = "SELECT p.PackageID as ID, Weight, Length, Width, Height, isFragile, p.Service, s.ServiceName, t.StateID, t.StateAbbreviation as State, p.dest_City as City, p.dest_ZIP as ZIP, p.dest_ApartmentNo as ApartmentNo, p.dest_street as Street FROM package as p, service as s, state as t WHERE p.VehicleID = :vehicle AND p.Service = s.ServiceID AND p.dest_State = t.StateID ORDER BY p.Service DESC";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':vehicle', $vehicle);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function GetVehiclesQuery(Connection $connection, $office) {
        try{
            $sql = "SELECT * FROM vehicle WHERE vehicle.officeID = :office";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':office', $office);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }


    protected function LoadPackageToVehicleQuery(Connection $connection, Delivery $delivery) {
        try{
            $sql = "UPDATE package SET package.VehicleID = :vehicle WHERE package.packageID = :pid";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':vehicle', $delivery->getVehicle());
            $stmt->bindValue(':pid', $delivery->getPackageID());
            $stmt->execute();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function deliverQuery(Connection $connection, Package $delivery) {
        try{
            $sql = "UPDATE package SET package.OfficeID = :office, package.VehicleID = null WHERE package.packageID = :pid";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':office', $delivery->getLocation());
            $stmt->bindValue(':pid', $delivery->getPackageID());
            $stmt->execute();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function completeDeliverQuery(Connection $connection, Package $delivery) {
        try{
            $sql = "UPDATE package SET package.VehicleID = null, package.Status = 5 WHERE package.packageID = :pid";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':pid', $delivery->getPackageID());
            $stmt->execute();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function CustomerAddressQuery(Connection $connection, $identity) {
        try{
            $sql = "SELECT c.Street, c.ApartmentNo, c.City, s.StateName, s.StateID as StateID, c.ZIP FROM customer as c, state as s WHERE c.Email = :email AND s.StateID = c.State";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':email', $identity);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function startShift(Connection $connection, $id, $vehicle) {
        try{
            $sql = "INSERT INTO shift (`EmployeeID`, `VehicleID`) VALUES (:id, :vehicle)";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':vehicle', $vehicle);
            $stmt->execute();
        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }
    protected function insertShiftToPackage(Connection $connection) {
        try{
            $sql = "UPDATE package, shift SET package.ShiftID = shift.ShiftSession WHERE shift.VehicleID = package.VehicleID AND shift.Clock_out_dateTime IS NULL";

            $stmt = $connection->prepare($sql);
            $stmt->execute();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function endShift(Connection $connection, $session) {
        try{
            $sql = "UPDATE shift SET shift.Clock_out_dateTime = NOW(), 
                    shift.Hours_Worked = TIMESTAMPDIFF(minute, shift.Clock_in_dateTime, NOW())/60
            WHERE shift.ShiftSession = :sessionID";


            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':sessionID', $session);
            $stmt->execute();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }

    }

    protected function getShiftDetailsQuery(Connection $connection, $session) {
        try{
            $sql = "SELECT shift.VehicleID, shift.Clock_in_dateTime as checkin FROM shift where shift.ShiftSession = :session";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':session', $session);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }
///////////////////////////////////////////////
    protected function trackingQuery(Connection $connection, Tracking $tracking): array {
        
        try{
            $sql = "SELECT DISTINCT t.Update_Date as Date, t.TrackingNote as Note FROM tracking as t, package as p WHERE t.Package_ID = :pID ORDER BY t.Tracking_Index ASC";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':pID', strval($tracking->getPackageID()));
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function statusQuery(Connection $connection, Tracking $tracking) {
        try{
            $sql = "SELECT DISTINCT s.Status as Status FROM package as p, status as s WHERE p.PackageID = :pID AND p.Status = s.Code";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':pID', strval($tracking->getPackageID()));
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function getShippingOfficesQuery(Connection $connection, $office) {


        try{
            $sql = "select office.OfficeID, state.StateID, state.StateAbbreviation, office.City, office.ZIP, office.Street, office.isRegional from state, office, (select office.State from office where office.OfficeID = :office) as m where m.State = office.State and office.state = state.StateID union select office.OfficeID, state.StateID, state.StateAbbreviation, office.City, office.ZIP, office.Street, office.isRegional from state, office, (select office.isRegional as d from office where office.OfficeID = :office) as m where m.d = 1 and office.isRegional = 1 and office.State = state.StateID";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':office', $office);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function CostQuery(Connection $connection, $serviceID){
        try{
            $sql = "SELECT * FROM service as s WHERE s.ServiceID = :service";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':service', $serviceID);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function OfficesQuery(Connection $connection, $officeState) {
        try{
            $sql = "SELECT * FROM office as o, state as s WHERE s.StateName = :state AND s.StateID = o.State";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':state', $officeState);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function getShiftQuery(Connection $connection, $id) {
        try{
            $sql = "SELECT s.ShiftSession as session FROM shift as s WHERE s.EmployeeID = :id AND s.Clock_out_dateTime is NULL ";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }
    }

    protected function CustomerPackageSubmitQuery(Connection $connection, $package) {
        try{
            $sql = "INSERT INTO package (RecipientName, Email, Weight, Length, Width, Height, 
            dest_State, dest_City, dest_ZIP, dest_Street, dest_ApartmentNo,
            return_State, return_City, return_ZIP, return_Street, return_ApartmentNo,
            isFragile, send_date, Service, Status, OfficeID, return_office) VALUES (
                :Recipient,
                :Email,
                :Weight,
                :Length,
                :Width,
                :Height,
                :State,
                :City,
                :ZIP,
                :Street,
                :ApartmentNo,
                :rState,
                :rCity,
                :ZIP,
                :rStreet,
                :rApartmentNo,
                :isFragile,
                :sendDate,
                :service,
                :status,
                :OfficeID,
                :OfficeID
            )";

            $transaction = "INSERT INTO transaction (PackageID, TransactionTotal) VALUES ((SELECT LAST_INSERT_ID()), :total)";
            $getidsql = "SELECT LAST_INSERT_ID() as id";

            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':Recipient', $package->getRecipient());
            $stmt->bindValue(':Email', $package->getEmail());
            $stmt->bindValue(':Weight', $package->getWeight());
            $stmt->bindValue(':Length', $package->getLength());
            $stmt->bindValue(':Width', $package->getWidth());
            $stmt->bindValue(':Height', $package->getHeight());

            $stmt->bindValue(':State', $package->getState());
            $stmt->bindValue(':City', $package->getCity());
            $stmt->bindValue(':ZIP', $package->getZIP());
            $stmt->bindValue(':Street', $package->getStreet());
            $stmt->bindValue(':ApartmentNo', $package->getApartmentNo());

            $stmt->bindValue(':rState', $package->getrState());
            $stmt->bindValue(':rCity', $package->getrCity());
            $stmt->bindValue(':rZIP', $package->getrZIP());
            $stmt->bindValue(':rStreet', $package->getrStreet());
            $stmt->bindValue(':rApartmentNo', $package->getrApartmentNo());

            $stmt->bindValue(':isFragile', (int)$package->getIsFragile());
            $stmt->bindValue(':sendDate', date_format($package->getSendDate(), 'Y-m-d'));
            $stmt->bindValue(':service', $package->getService());
            $stmt->bindValue(':status', $package->getStatus());
            $stmt->bindValue(':OfficeID', $package->getLocation());
            $stmt->execute();

            $stmt = $connection->prepare($transaction);
            $stmt->bindValue(':total', $package->getTotal());
            $stmt->execute();

            $stmt = $connection->prepare($getidsql);
            $stmt->execute();
            return $stmt->fetchAll();

        } catch (PODException $e){ 
            echo "Error " . $e->getMessage();
        }

    }
}