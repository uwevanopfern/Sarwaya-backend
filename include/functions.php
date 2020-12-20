<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/25/2019
 * Time: 9:56 AM
 */
class Functions
{

    public $db;

    //Object properties of registering customers
    public $customer_name;
    public $customer_phone;
    public $customer_email;
    public $customer_password;
    public $agencyID;
    public $locationID;
    public $customerID;
    public $bookingID;
    public $scheduleID;
    public $bookingDate;
    public $bookingTime;
    public $bookingUUID;
    public $preBookedDate;
    public $customerTime;

    //Object properties of making new booking

    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=sarwaya;charset=utf8', 'root', '');
            // echo "Success";
        } catch (Exception $e) {
            // echo $e->getMessage();
            echo "Oops";
        }
    }

    public function login($email, $password, $agency)
    {

        $password = sha1($password);

        $login = $this->db->prepare("SELECT * FROM admin WHERE admin_email=:admin_email 
          && admin_password=:admin_password && agency_id=:agency_id");
        $login->bindValue(':admin_email', $email, PDO::PARAM_STR);
        $login->bindValue(':admin_password', $password, PDO::PARAM_STR);
        $login->bindValue(':agency_id', $agency, PDO::PARAM_INT);
        $login->execute();

        $count = $login->rowCount();
        if ($count == 1) {
            $data = $login->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
    }

    public function logout()
    {

        session_destroy();
        unset($_SESSION['user']);
        header("Location: index.php");
    }

    public function getAllAgencies()
    {

        $allAgencies = $this->db->prepare("SELECT * FROM agency ORDER BY agency_id DESC");
        $allAgencies->execute();

        return $allAgencies;
    }

    public function selectAgencyNameByAgencyID($agencyID)
    {

        $agencyName = $this->db->prepare("SELECT * FROM agency WHERE agency_id=:agency_id");
        $agencyName->bindValue(':agency_id', $agencyID, PDO::PARAM_STR);
        $agencyName->execute();
        $data = $agencyName->fetch(PDO::FETCH_ASSOC);

        return $data['agency_name'];
    }

    public function getAgencyIDByBookingUUID($bookingUUID)
    {
        $getAgencyAgencyByBookingUUID = $this->db->prepare("SELECT * FROM booking WHERE booking_uuid=:booking_uuid");
        $getAgencyAgencyByBookingUUID->bindValue(':booking_uuid', $bookingUUID, PDO::PARAM_STR);
        $getAgencyAgencyByBookingUUID->execute();
        $data = $getAgencyAgencyByBookingUUID->fetch(PDO::FETCH_ASSOC);

        return $data['agency_id'];
    }

    public function getAgencyPhoneByAgencyID($agencyID)
    {

        $getAgencyPhoneByAgencyID = $this->db->prepare("SELECT * FROM agency WHERE agency_id=:agency_id");
        $getAgencyPhoneByAgencyID->bindValue(':agency_id', $agencyID, PDO::PARAM_STR);
        $getAgencyPhoneByAgencyID->execute();
        $data = $getAgencyPhoneByAgencyID->fetch(PDO::FETCH_ASSOC);

        return $data['agency_phone'];
    }

    public function checkCarExistance($plate)
    {

        $checkPlateNumber = $this->db->prepare("SELECT * FROM cars WHERE car_plate_number=:car_plate_number");
        $checkPlateNumber->bindValue(':car_plate_number', $plate, PDO::PARAM_STR);
        $checkPlateNumber->execute();
        $count = $checkPlateNumber->rowCount();

        return $count;
    }

    public function addCar($agency, $plateNo, $description)
    {

        $addCar = $this->db->prepare("INSERT INTO cars (agency_id, car_plate_number, car_desc) 
                                    VALUES (:agency_id, :car_plate_number, :car_desc)");

        $addCar->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $addCar->bindValue(':car_plate_number', $plateNo, PDO::PARAM_STR);
        $addCar->bindValue(':car_desc', $description, PDO::PARAM_STR);

        $addCar->execute();

        return $addCar;
    }

    public function getAgencyCars($agency)
    {

        $allAgencyCars = $this->db->prepare("SELECT * FROM cars WHERE agency_id=:agency_id  ORDER BY car_id DESC");
        $allAgencyCars->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $allAgencyCars->execute();

        return $allAgencyCars;
    }

    public function getCarDetails($car)
    {

        $carDetails = $this->db->prepare("SELECT * FROM cars WHERE car_id=:car_id");
        $carDetails->bindValue(':car_id', $car, PDO::PARAM_STR);
        $carDetails->execute();

        return $carDetails;
    }

    public function updateCar($car, $plateNo, $description)
    {

        $updateCar = $this->db->prepare("UPDATE cars SET car_plate_number=:car_plate_number, car_desc=:car_desc WHERE car_id=:car_id");
        $updateCar->bindValue(':car_plate_number', $plateNo, PDO::PARAM_STR);
        $updateCar->bindValue(':car_desc', $description, PDO::PARAM_STR);
        $updateCar->bindValue(':car_id', $car, PDO::PARAM_STR);
        $updateCar->execute();

        return $updateCar;
    }

    public function deleteCar($car)
    {

        $deleteCar = $this->db->prepare("DELETE FROM cars WHERE car_id=:car_id");
        $deleteCar->bindValue(':car_id', $car, PDO::PARAM_STR);
        $deleteCar->execute();

        return $deleteCar;
    }

    public function checkAgencyExistance($agencyName)
    {

        $checkAgencyName = $this->db->prepare("SELECT * FROM agency WHERE agency_name=:agency_name");
        $checkAgencyName->bindValue(':agency_name', $agencyName, PDO::PARAM_STR);
        $checkAgencyName->execute();
        $count = $checkAgencyName->rowCount();

        return $count;
    }

    public function addAgency($agency, $description, $location, $phone)
    {

        $addAgency = $this->db->prepare("INSERT INTO agency (agency_name, agency_description, agency_location, agency_phone) 
                                    VALUES (:agency_name, :agency_description, :agency_location, :agency_phone)");

        $addAgency->bindValue(':agency_name', $agency, PDO::PARAM_STR);
        $addAgency->bindValue(':agency_description', $description, PDO::PARAM_STR);
        $addAgency->bindValue(':agency_location', $location, PDO::PARAM_STR);
        $addAgency->bindValue(':agency_phone', $phone, PDO::PARAM_STR);
        $addAgency->execute();

        return $addAgency;
    }

    public function addAgencyTime($agency, $time)
    {

        $addAgencyTime = $this->db->prepare("INSERT INTO agency_timetable (agency_id, time) 
                                    VALUES (:agency_id, :time)");

        $addAgencyTime->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $addAgencyTime->bindValue(':time', $time, PDO::PARAM_STR);
        $addAgencyTime->execute();

        return $addAgencyTime;
    }

    public function getAgencyTime()
    {

        $getAgencyTime = $this->db->prepare("SELECT * FROM agency_timetable");
        $getAgencyTime->execute();

        return $getAgencyTime;
    }

    public function getAgencyTimeByID($agencyTimeID)
    {

        $getAgencyTimeByID = $this->db->prepare("SELECT * FROM agency_timetable WHERE id=:id");
        $getAgencyTimeByID->bindValue(':id', $agencyTimeID, PDO::PARAM_STR);
        $getAgencyTimeByID->execute();

        return $getAgencyTimeByID;
    }

    public function getAgencyTimeByAgencyID($agencyID)
    {

        $getAgencyTimeByAgencyID = $this->db->prepare("SELECT * FROM agency_timetable WHERE agency_id=:agency_id");
        $getAgencyTimeByAgencyID->bindValue(':agency_id', $agencyID, PDO::PARAM_STR);
        $getAgencyTimeByAgencyID->execute();

        return $getAgencyTimeByAgencyID;
    }

    public function updateAgencyTime($agencyTimeID, $agencyTime)
    {

        $updateAgencyTime = $this->db->prepare("UPDATE agency_timetable SET time=:time WHERE id=:id");
        $updateAgencyTime->bindValue(':id', $agencyTimeID, PDO::PARAM_STR);
        $updateAgencyTime->bindValue(':time', $agencyTime, PDO::PARAM_STR);
        $updateAgencyTime->execute();

        return $updateAgencyTime;
    }

    public function deleteAgencyTime($agencyTimeID)
    {

        $deleteAgencyTime = $this->db->prepare("DELETE FROM agency_timetable WHERE id=:id");
        $deleteAgencyTime->bindValue(':id', $agencyTimeID, PDO::PARAM_STR);
        $deleteAgencyTime->execute();

        return $deleteAgencyTime;
    }

    public function getAgencyDetails($agency)
    {

        $agencyDetails = $this->db->prepare("SELECT * FROM agency WHERE agency_id=:agency_id");
        $agencyDetails->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $agencyDetails->execute();

        return $agencyDetails;
    }

    public function updateAgency($agencyID, $agencyName, $description)
    {

        $updateAgency = $this->db->prepare("UPDATE agency SET agency_name=:agency_name, agency_description=:agency_description 
        WHERE agency_id=:agency_id");
        $updateAgency->bindValue(':agency_name', $agencyName, PDO::PARAM_STR);
        $updateAgency->bindValue(':agency_description', $description, PDO::PARAM_STR);
        $updateAgency->bindValue(':agency_id', $agencyID, PDO::PARAM_STR);
        $updateAgency->execute();

        return $updateAgency;
    }

    public function deleteAgency($car)
    {

        $deleteAgency = $this->db->prepare("DELETE FROM agency WHERE agency_id=:agency_id");
        $deleteAgency->bindValue(':agency_id', $car, PDO::PARAM_STR);
        $deleteAgency->execute();

        return $deleteAgency;
    }

    public function getAllStaff($agency)
    {

        $getAllStaff = $this->db->prepare("SELECT * FROM admin WHERE agency_id=:agency_id && role <> :role ORDER BY admin_id DESC");
        $getAllStaff->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $getAllStaff->bindValue(':role', 1, PDO::PARAM_STR);
        $getAllStaff->execute();

        return $getAllStaff;
    }

    public function addStaff($agency, $name, $phone, $email, $password)
    {

        $password = sha1($password);

        $addStaff = $this->db->prepare("INSERT INTO admin (agency_id, admin_name, admin_phone, admin_email, admin_password, role) 
                                    VALUES (:agency_id, :admin_name, :admin_phone, :admin_email, :admin_password, :role)");

        $addStaff->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $addStaff->bindValue(':admin_name', $name, PDO::PARAM_STR);
        $addStaff->bindValue(':admin_phone', $phone, PDO::PARAM_STR);
        $addStaff->bindValue(':admin_email', $email, PDO::PARAM_STR);
        $addStaff->bindValue(':admin_password', $password, PDO::PARAM_STR);
        $addStaff->bindValue(':role', 3, PDO::PARAM_STR);

        $addStaff->execute();

        return $addStaff;
    }

    public function updateStaff($staff, $name, $phone, $email, $password)
    {

        $password = sha1($password);

        $updateStaff = $this->db->prepare("UPDATE admin SET admin_name=:admin_name, admin_phone=:admin_phone, 
                admin_email=:admin_email, admin_password=:admin_password WHERE admin_id=:admin_id");
        $updateStaff->bindValue(':admin_name', $name, PDO::PARAM_STR);
        $updateStaff->bindValue(':admin_phone', $phone, PDO::PARAM_STR);
        $updateStaff->bindValue(':admin_email', $email, PDO::PARAM_STR);
        $updateStaff->bindValue(':admin_password', $password, PDO::PARAM_STR);
        $updateStaff->bindValue(':admin_id', $staff, PDO::PARAM_STR);
        $updateStaff->execute();

        return $updateStaff;
    }

    public function deleteStaff($staff)
    {

        $deleteStaff = $this->db->prepare("DELETE FROM admin WHERE admin_id=:admin_id");
        $deleteStaff->bindValue(':admin_id', $staff, PDO::PARAM_STR);
        $deleteStaff->execute();

        return $deleteStaff;
    }

    public function getStaffDetails($admin)
    {

        $getStaff = $this->db->prepare("SELECT * FROM admin WHERE admin_id=:admin_id");
        $getStaff->bindValue(':admin_id', $admin, PDO::PARAM_STR);
        $getStaff->execute();

        return $getStaff;
    }

    public function getAdminRole($admin, $role)
    {

        $getRole = $this->db->prepare("SELECT * FROM admin WHERE admin_id=:admin_id && role=:role");
        $getRole->bindValue(':admin_id', $admin, PDO::PARAM_STR);
        $getRole->bindValue(':role', $role, PDO::PARAM_STR);
        $getRole->execute();

        return $getRole;
    }

    public function checkLocationExistance($from, $to, $agency)
    {

        $checkLocationName = $this->db->prepare("SELECT * FROM locations WHERE from_location=:from_location && to_location=:to_location
        && agency_id=:agency_id");
        $checkLocationName->bindValue(':from_location', $from, PDO::PARAM_STR);
        $checkLocationName->bindValue(':to_location', $to, PDO::PARAM_STR);
        $checkLocationName->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $checkLocationName->execute();
        $count = $checkLocationName->rowCount();

        return $count;
    }

    public function addLocation($from, $to, $agency, $cost)
    {

        $addLocation = $this->db->prepare("INSERT INTO locations (from_location, to_location, agency_id, location_cost) 
                                    VALUES (:from_location, :to_location, :agency_id, :location_cost)");

        $addLocation->bindValue(':from_location', $from, PDO::PARAM_STR);
        $addLocation->bindValue(':to_location', $to, PDO::PARAM_STR);
        $addLocation->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $addLocation->bindValue(':location_cost', $cost, PDO::PARAM_STR);

        $addLocation->execute();

        return $addLocation;
    }

    public function getAllLocations($agency)
    {

        $getAllLocations = $this->db->prepare("SELECT * FROM locations WHERE agency_id=:agency_id ORDER BY loc_id DESC");
        $getAllLocations->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $getAllLocations->execute();

        return $getAllLocations;
    }

    public function updateLocation($location, $from, $to, $cost)
    {

        $updateLocation = $this->db->prepare("UPDATE locations SET from_location=:from_location, to_location=:to_location, location_cost=:location_cost 
        WHERE loc_id=:loc_id");
        $updateLocation->bindValue(':loc_id', $location, PDO::PARAM_STR);
        $updateLocation->bindValue(':from_location', $from, PDO::PARAM_STR);
        $updateLocation->bindValue(':to_location', $to, PDO::PARAM_STR);
        $updateLocation->bindValue(':location_cost', $cost, PDO::PARAM_STR);
        $updateLocation->execute();

        return $updateLocation;
    }

    public function deleteLocation($location)
    {

        $deleteLocation = $this->db->prepare("DELETE FROM locations WHERE loc_id=:loc_id");
        $deleteLocation->bindValue(':loc_id', $location, PDO::PARAM_STR);
        $deleteLocation->execute();

        return $deleteLocation;
    }

    public function getLocationDetails($location)
    {

        $getLocation = $this->db->prepare("SELECT * FROM locations WHERE loc_id=:loc_id");
        $getLocation->bindValue(':loc_id', $location, PDO::PARAM_STR);
        $getLocation->execute();

        return $getLocation;
    }

    public function getAllPendingBookings($agency)
    {

        $getAllPending = $this->db->prepare("SELECT * FROM booking WHERE is_confirmed=:is_confirmed && agency_id=:agency_id ORDER BY id DESC");
        $getAllPending->bindValue(':is_confirmed', false, PDO::PARAM_STR);
        $getAllPending->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $getAllPending->execute();

        return $getAllPending;
    }

    public function getAllAnonymousPendingBookings($agency)
    {

        $getAllAnonymousPendingBookings = $this->db->prepare("SELECT * FROM booking WHERE is_confirmed=:is_confirmed && agency_id=:agency_id && pre_booked_date<>:pre_booked_date ORDER BY id DESC");
        $getAllAnonymousPendingBookings->bindValue(':is_confirmed', false, PDO::PARAM_STR);
        $getAllAnonymousPendingBookings->bindValue(':pre_booked_date', 0, PDO::PARAM_STR);
        $getAllAnonymousPendingBookings->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $getAllAnonymousPendingBookings->execute();

        return $getAllAnonymousPendingBookings;
    }

    public function getCustomerName($customer)
    {

        $getCustomerName = $this->db->prepare("SELECT * FROM customer WHERE customer_id=:customer_id");
        $getCustomerName->bindValue(':customer_id', $customer, PDO::PARAM_STR);
        $getCustomerName->execute();

        $data = $getCustomerName->fetch(PDO::FETCH_ASSOC);
        return $data['customer_name'];
    }

    public function getCarName($car)
    {

        $carDetails = $this->db->prepare("SELECT * FROM cars WHERE car_id=:car_id");
        $carDetails->bindValue(':car_id', $car, PDO::PARAM_STR);
        $carDetails->execute();

        $data = $carDetails->fetch(PDO::FETCH_ASSOC);
        return $data['car_plate_number'];
    }

    public function getFromLocationName($location)
    {

        $locationName = $this->db->prepare("SELECT * FROM locations WHERE loc_id=:loc_id");
        $locationName->bindValue(':loc_id', $location, PDO::PARAM_STR);
        $locationName->execute();

        $data = $locationName->fetch(PDO::FETCH_ASSOC);
        return $data['from_location'];
    }

    public function getToLocationName($location)
    {

        $locationName = $this->db->prepare("SELECT * FROM locations WHERE loc_id=:loc_id");
        $locationName->bindValue(':loc_id', $location, PDO::PARAM_STR);
        $locationName->execute();

        $data = $locationName->fetch(PDO::FETCH_ASSOC);
        return $data['to_location'];
    }

    public function getLocationCost($location)
    {

        $locationName = $this->db->prepare("SELECT * FROM locations WHERE loc_id=:loc_id");
        $locationName->bindValue(':loc_id', $location, PDO::PARAM_STR);
        $locationName->execute();

        $data = $locationName->fetch(PDO::FETCH_ASSOC);
        return $data['location_cost'];
    }

    public function confirmBooking($booking)
    {

        $confirmBooking = $this->db->prepare("UPDATE booking SET is_confirmed=:is_confirmed WHERE id=:id");
        $confirmBooking->bindValue(':id', $booking, PDO::PARAM_STR);
        $confirmBooking->bindValue(':is_confirmed', true, PDO::PARAM_STR);
        $confirmBooking->execute();

        return $confirmBooking;
    }

    public function getBookingDetails($booking)
    {

        $getBookingDetails = $this->db->prepare("SELECT * FROM booking WHERE id=:id");
        $getBookingDetails->bindValue(':id', $booking, PDO::PARAM_STR);
        $getBookingDetails->execute();

        return $getBookingDetails;
    }

    public function reScheduleBooking($schedule, $car)
    {

        $updateSchedule = $this->db->prepare("UPDATE schedule SET car_id=:car_id WHERE id=:id");

        $updateSchedule->bindValue(':car_id', $car, PDO::PARAM_STR);
        $updateSchedule->bindValue(':id', $schedule, PDO::PARAM_STR);

        $updateSchedule->execute();

        return $updateSchedule;
    }

    public function setScheduleBooking($bookingID, $schedule)
    {

        $setScheduleBooking = $this->db->prepare("UPDATE booking SET schedule_id=:schedule_id, pre_booked_date=:pre_booked_date, is_confirmed=:is_confirmed WHERE id=:id");

        $setScheduleBooking->bindValue(':id', $bookingID, PDO::PARAM_STR);
        $setScheduleBooking->bindValue(':pre_booked_date', 0, PDO::PARAM_STR);
        $setScheduleBooking->bindValue(':is_confirmed', true, PDO::PARAM_STR);
        $setScheduleBooking->bindValue(':schedule_id', $schedule, PDO::PARAM_STR);

        $setScheduleBooking->execute();

        return $setScheduleBooking;
    }

    public function countTotalAgencyCars($agency)
    {

        $totalCars = $this->db->prepare("SELECT * FROM locations WHERE agency_id=:agency_id");
        $totalCars->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $totalCars->execute();
        $count = $totalCars->rowCount();

        return $count;
    }

    public function countTotalAgencyLocations($agency)
    {

        $totalLocations = $this->db->prepare("SELECT * FROM locations WHERE agency_id=:agency_id");
        $totalLocations->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $totalLocations->execute();
        $count = $totalLocations->rowCount();

        return $count;
    }

    public function getAgencyLocations($agency)
    {

        $getAgencyLocations = $this->db->prepare("SELECT * FROM locations WHERE agency_id=:agency_id");
        $getAgencyLocations->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $getAgencyLocations->execute();

        return $getAgencyLocations;
    }

    public function countTotalAgencyBooking($agency)
    {

        $totalBookings = $this->db->prepare("SELECT * FROM booking WHERE agency_id=:agency_id");
        $totalBookings->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $totalBookings->execute();
        $count = $totalBookings->rowCount();

        return $count;
    }

    public function getTotalPaidAgencyBooking($agency)
    {

        $totalBookings = $this->db->prepare("SELECT * FROM booking WHERE agency_id=:agency_id && is_paid=:is_paid 
        && is_money_taken=:is_money_taken && transaction_status=:transaction_status &&
        MONTH(booking_date) = MONTH(CURRENT_DATE())");
        $totalBookings->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $totalBookings->bindValue(':is_paid', true, PDO::PARAM_STR);
        $totalBookings->bindValue(':transaction_status', "Success", PDO::PARAM_STR);
        $totalBookings->bindValue(':is_money_taken', false, PDO::PARAM_STR);
        $totalBookings->execute();

        return $totalBookings;
    }

    public function updateWithdrawStatus($bookingID)
    {

        $updateWithdrawStatus = $this->db->prepare("UPDATE booking SET is_money_taken=:is_money_taken WHERE id=:id");
        $updateWithdrawStatus->bindValue(':id', $bookingID, PDO::PARAM_STR);
        $updateWithdrawStatus->bindValue(':is_money_taken', true, PDO::PARAM_STR);
        $updateWithdrawStatus->execute();

        return $updateWithdrawStatus;
    }


    public function updateCustomerBookingTime($bookingID, $customerTime)
    {

        $updateCustomerBookingTime = $this->db->prepare("UPDATE booking SET customer_time=:customer_time, is_confirmed=:is_confirmed WHERE id=:id");
        $updateCustomerBookingTime->bindValue(':id', $bookingID, PDO::PARAM_STR);
        $updateCustomerBookingTime->bindValue(':is_confirmed', true, PDO::PARAM_STR);
        $updateCustomerBookingTime->bindValue(':customer_time', $customerTime, PDO::PARAM_STR);
        $updateCustomerBookingTime->execute();

        return $updateCustomerBookingTime;
    }

    public function addTransactionLog($agencyID, $type, $perfomer, $amount, $receiver)
    {

        $addTransactionLog = $this->db->prepare("INSERT INTO transaction_logs (agency_id, trans_type, performer, amount, receiver, period_time) 
                                    VALUES (:agency_id, :trans_type, :performer, :amount, :receiver, :period_time)");

        $addTransactionLog->bindValue(':agency_id', $agencyID, PDO::PARAM_STR);
        $addTransactionLog->bindValue(':trans_type', $type, PDO::PARAM_STR);
        $addTransactionLog->bindValue(':performer', $perfomer, PDO::PARAM_STR);
        $addTransactionLog->bindValue(':amount', $amount, PDO::PARAM_STR);
        $addTransactionLog->bindValue(':receiver', $receiver, PDO::PARAM_STR);
        $addTransactionLog->bindValue(':period_time', date('Y-m-d H:i:s', '1299762201428'), PDO::PARAM_STR);
        $addTransactionLog->execute();

        return $addTransactionLog;
    }

    public function getAgencyTransactionLogs($agency)
    {

        $getAgencyTransactionLogs = $this->db->prepare("SELECT * FROM transaction_logs WHERE agency_id=:agency_id");
        $getAgencyTransactionLogs->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $getAgencyTransactionLogs->execute();

        return $getAgencyTransactionLogs;
    }

    public function countTotalSuccessTransactionBooking($agency)
    {

        $totalBookings = $this->db->prepare("SELECT * FROM booking WHERE agency_id=:agency_id && is_paid=:is_paid
        && transaction_status=:transaction_status && MONTH(booking_date) = MONTH(CURRENT_DATE())");
        $totalBookings->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $totalBookings->bindValue(':is_paid', true, PDO::PARAM_STR);
        $totalBookings->bindValue(':transaction_status', 'Success', PDO::PARAM_STR);
        $totalBookings->execute();

        $count = $totalBookings->rowCount();

        return $count;
    }

    public function countTotalPendingTransactionBooking($agency)
    {

        $totalBookings = $this->db->prepare("SELECT * FROM booking WHERE agency_id=:agency_id && is_paid=:is_paid
        && transaction_status=:transaction_status && MONTH(booking_date) = MONTH(CURRENT_DATE())");
        $totalBookings->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $totalBookings->bindValue(':is_paid', false, PDO::PARAM_STR);
        $totalBookings->bindValue(':transaction_status', 'Pending', PDO::PARAM_STR);
        $totalBookings->execute();

        $count = $totalBookings->rowCount();

        return $count;
    }

    public function countTotalPendingBooking($agency)
    {

        $totalBookings = $this->db->prepare("SELECT * FROM booking WHERE agency_id=:agency_id && is_confirmed=:is_confirmed &&
        MONTH(booking_date) = MONTH(CURRENT_DATE())");
        $totalBookings->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $totalBookings->bindValue(':is_confirmed', false, PDO::PARAM_STR);
        $totalBookings->execute();

        $count = $totalBookings->rowCount();

        return $count;
    }

    public function countTotalConfirmedBooking($agency)
    {

        $totalBookings = $this->db->prepare("SELECT * FROM booking WHERE agency_id=:agency_id && is_confirmed=:is_confirmed &&
        MONTH(booking_date) = MONTH(CURRENT_DATE())");
        $totalBookings->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $totalBookings->bindValue(':is_confirmed', true, PDO::PARAM_STR);
        $totalBookings->execute();

        $count = $totalBookings->rowCount();

        return $count;
    }

    public function getAllConfirmedPaidBookings($agency)
    {

        $getAllPending = $this->db->prepare("SELECT * FROM booking WHERE is_confirmed=:is_confirmed && 
        is_paid=:is_paid && agency_id=:agency_id ORDER BY id DESC");
        $getAllPending->bindValue(':is_confirmed', true, PDO::PARAM_STR);
        $getAllPending->bindValue(':is_paid', true, PDO::PARAM_STR);
        $getAllPending->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $getAllPending->execute();

        return $getAllPending;
    }

    public function searchCustomerName($customerName)
    {

        $getCustomerName = $this->db->prepare("SELECT * FROM customer WHERE customer_name LIKE :customer_name");
        $getCustomerName->bindValue(':customer_name', '%' . $customerName . '%', PDO::PARAM_STR);
        $getCustomerName->execute();

        $data = $getCustomerName->fetch(PDO::FETCH_ASSOC);
        return $data['customer_id'];
    }

    public function getBookingOfCustomer($customerID)
    {

        $getAllPending = $this->db->prepare("SELECT * FROM booking WHERE customer_id=:customer_id");
        $getAllPending->bindValue(':customer_id', $customerID, PDO::PARAM_STR);
        $getAllPending->execute();

        return $getAllPending;
    }

    public function addSchedule($car, $agency, $location, $departTime, $departDate)
    {

        $addSchedule = $this->db->prepare("INSERT INTO schedule (car_id, agency_id,location_id, car_depart_time, car_depart_date) 
                                    VALUES (:car_id ,:agency_id,:location_id, :car_depart_time, :car_depart_date)");

        $addSchedule->bindValue(':car_id', $car, PDO::PARAM_STR);
        $addSchedule->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $addSchedule->bindValue(':location_id', $location, PDO::PARAM_STR);
        $addSchedule->bindValue(':car_depart_time', $departTime, PDO::PARAM_STR);
        $addSchedule->bindValue(':car_depart_date', $departDate, PDO::PARAM_STR);
        $addSchedule->execute();

        return $addSchedule;
    }

    public function updateSchedule($id, $car, $location, $departTime, $departDate)
    {

        $updateSchedule = $this->db->prepare("UPDATE schedule SET car_id=:car_id, location_id=:location_id,
        car_depart_time=:car_depart_time, car_depart_date=:car_depart_date WHERE id=:id");

        $updateSchedule->bindValue(':car_id', $car, PDO::PARAM_STR);
        $updateSchedule->bindValue(':location_id', $location, PDO::PARAM_STR);
        $updateSchedule->bindValue(':car_depart_time', $departTime, PDO::PARAM_STR);
        $updateSchedule->bindValue(':car_depart_date', $departDate, PDO::PARAM_STR);
        $updateSchedule->bindValue(':id', $id, PDO::PARAM_STR);

        $updateSchedule->execute();

        return $updateSchedule;
    }

    public function deleteSchedule($schedule)
    {

        $deleteSchedule = $this->db->prepare("DELETE FROM schedule WHERE id=:id");
        $deleteSchedule->bindValue(':id', $schedule, PDO::PARAM_STR);
        $deleteSchedule->execute();

        return $deleteSchedule;
    }

    public function getAgencySchedule($agency)
    {

        $getAgencySchedule = $this->db->prepare("SELECT * FROM schedule WHERE agency_id=:agency_id  ORDER BY car_id DESC");
        $getAgencySchedule->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $getAgencySchedule->execute();

        return $getAgencySchedule;
    }

    public function getAllAgencyBooking($agency)
    {

        $totalBookings = $this->db->prepare("SELECT * FROM booking WHERE agency_id=:agency_id");
        $totalBookings->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $totalBookings->execute();

        return $totalBookings;
    }

    public function getScheduleDetails($schedule)
    {

        $getScheduleDetails = $this->db->prepare("SELECT * FROM schedule WHERE id=:id");
        $getScheduleDetails->bindValue(':id', $schedule, PDO::PARAM_STR);
        $getScheduleDetails->execute();

        return $getScheduleDetails;
    }

    public function searchBookingsByDates($agency, $startDate, $endDate)
    {

        $searchBookingsByDates = $this->db->prepare("SELECT * FROM booking WHERE `booking_date` BETWEEN :startDate AND :endDate && agency_id=:agency_id");
        $searchBookingsByDates->bindValue(':startDate', $startDate, PDO::PARAM_STR);
        $searchBookingsByDates->bindValue(':endDate', $endDate, PDO::PARAM_STR);
        $searchBookingsByDates->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $searchBookingsByDates->execute();

        return $searchBookingsByDates;
    }

    //API FUNCTIONS
    public function checkCustomerPhoneExistance($phone)
    {

        $checkCustomerPhoneExistance = $this->db->prepare("SELECT * FROM customer WHERE customer_phone=:customer_phone");
        $checkCustomerPhoneExistance->bindValue(':customer_phone', $phone, PDO::PARAM_STR);
        $checkCustomerPhoneExistance->execute();
        $count = $checkCustomerPhoneExistance->rowCount();

        return $count;
    }

    public function checkCustomerEmailExistance($email)
    {

        $checkCustomerEmailExistance = $this->db->prepare("SELECT * FROM customer WHERE customer_email=:customer_email");
        $checkCustomerEmailExistance->bindValue(':customer_email', $email, PDO::PARAM_STR);
        $checkCustomerEmailExistance->execute();
        $count = $checkCustomerEmailExistance->rowCount();

        return $count;
    }

    public function registerCustomer()
    {

        $this->customer_name = htmlspecialchars(strip_tags($this->customer_name));
        $this->customer_email = htmlspecialchars(strip_tags($this->customer_email));
        $this->customer_phone = htmlspecialchars(strip_tags($this->customer_phone));
        $this->customer_password = htmlspecialchars(strip_tags($this->customer_password));

        $registerCustomer = $this->db->prepare("INSERT INTO customer (customer_name, customer_phone, customer_email, customer_password) 
                                    VALUES (:customer_name, :customer_phone, :customer_email, :customer_password)");

        $registerCustomer->bindValue(':customer_name', $this->customer_name, PDO::PARAM_STR);
        $registerCustomer->bindValue(':customer_phone', $this->customer_phone, PDO::PARAM_STR);
        $registerCustomer->bindValue(':customer_email', $this->customer_email, PDO::PARAM_STR);
        $registerCustomer->bindValue(':customer_password', sha1($this->customer_password), PDO::PARAM_STR);

        $registerCustomer->execute();

        return $registerCustomer;
    }

    public function loginCustomer($phone, $password)
    {

        $loginCustomer = $this->db->prepare("SELECT * FROM customer WHERE customer_phone=:customer_phone 
        && customer_password=:customer_password");
        $loginCustomer->bindValue(':customer_phone', $phone, PDO::PARAM_STR);
        $loginCustomer->bindValue(':customer_password', sha1($password), PDO::PARAM_STR);
        $loginCustomer->execute();

        return $loginCustomer;
    }

    public function getScheduleByAgencyLocation($agency, $location)
    {
        $getScheduleByAgencyLocation = $this->db->prepare("SELECT * FROM schedule WHERE agency_id=:agency_id
        &&location_id=:location_id");
        $getScheduleByAgencyLocation->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $getScheduleByAgencyLocation->bindValue(':location_id', $location, PDO::PARAM_STR);
        $getScheduleByAgencyLocation->execute();

        return $getScheduleByAgencyLocation;
    }

    public function addNewBooking()
    {

        $this->bookingUUID = htmlspecialchars(strip_tags($this->bookingUUID));
        $this->agencyID = htmlspecialchars(strip_tags($this->agencyID));
        $this->scheduleID = htmlspecialchars(strip_tags($this->scheduleID));
        $this->customerID = htmlspecialchars(strip_tags($this->customerID));
        $this->bookingDate = htmlspecialchars(strip_tags($this->bookingDate));
        $this->bookingTime = htmlspecialchars(strip_tags($this->bookingTime));

        $addNewBooking = $this->db->prepare("INSERT INTO booking (booking_uuid, agency_id, schedule_id, customer_id, booking_date, booking_time) 
                                    VALUES (:booking_uuid, :agency_id, :schedule_id, :customer_id, :booking_date, :booking_time)");

        $addNewBooking->bindValue(':booking_uuid', $this->bookingUUID, PDO::PARAM_STR);
        $addNewBooking->bindValue(':agency_id', $this->agencyID, PDO::PARAM_STR);
        $addNewBooking->bindValue(':schedule_id', $this->scheduleID, PDO::PARAM_STR);
        $addNewBooking->bindValue(':customer_id', $this->customerID, PDO::PARAM_STR);
        $addNewBooking->bindValue(':booking_date', $this->bookingDate, PDO::PARAM_STR);
        $addNewBooking->bindValue(':booking_time', $this->bookingTime, PDO::PARAM_STR);

        $addNewBooking->execute();

        return $addNewBooking;
    }

    public function addAnonymousBooking()
    {

        $this->bookingUUID = htmlspecialchars(strip_tags($this->bookingUUID));
        $this->agencyID = htmlspecialchars(strip_tags($this->agencyID));
        $this->customerID = htmlspecialchars(strip_tags($this->customerID));
        $this->bookingDate = htmlspecialchars(strip_tags($this->bookingDate));
        $this->bookingTime = htmlspecialchars(strip_tags($this->bookingTime));
        $this->preBookedDate = htmlspecialchars(strip_tags($this->preBookedDate));
        $this->customerTime = htmlspecialchars(strip_tags($this->customerTime));
        $this->locationID = htmlspecialchars(strip_tags($this->locationID));

        $addAnonymousBooking = $this->db->prepare("INSERT INTO booking (booking_uuid, agency_id, customer_id, booking_date, booking_time, customer_time, pre_booked_date, anonymous_location) 
                                    VALUES (:booking_uuid, :agency_id, :customer_id, :booking_date, :booking_time, :customer_time, :pre_booked_date, :anonymous_location)");

        $addAnonymousBooking->bindValue(':booking_uuid', $this->bookingUUID, PDO::PARAM_STR);
        $addAnonymousBooking->bindValue(':agency_id', $this->agencyID, PDO::PARAM_STR);
        $addAnonymousBooking->bindValue(':customer_id', $this->customerID, PDO::PARAM_STR);
        $addAnonymousBooking->bindValue(':booking_date', $this->bookingDate, PDO::PARAM_STR);
        $addAnonymousBooking->bindValue(':booking_time', $this->bookingTime, PDO::PARAM_STR);
        $addAnonymousBooking->bindValue(':customer_time', $this->customerTime, PDO::PARAM_STR);
        $addAnonymousBooking->bindValue(':pre_booked_date', $this->preBookedDate, PDO::PARAM_STR);
        $addAnonymousBooking->bindValue(':anonymous_location', $this->locationID, PDO::PARAM_STR);

        $addAnonymousBooking->execute();

        return $addAnonymousBooking;
    }

    public function updateCustomer()
    {

        $this->customer_name = htmlspecialchars(strip_tags($this->customer_name));
        $this->customer_email = htmlspecialchars(strip_tags($this->customer_email));
        $this->customer_phone = htmlspecialchars(strip_tags($this->customer_phone));

        $updateCustomer = $this->db->prepare("UPDATE customer SET customer_name=:customer_name, customer_phone=:customer_phone,
        customer_email=:customer_email WHERE customer_id=:customer_id");

        $updateCustomer->bindValue(':customer_name', $this->customer_name, PDO::PARAM_STR);
        $updateCustomer->bindValue(':customer_phone', $this->customer_phone, PDO::PARAM_STR);
        $updateCustomer->bindValue(':customer_email', $this->customer_email, PDO::PARAM_STR);
        $updateCustomer->bindValue(':customer_id', $this->customerID, PDO::PARAM_STR);

        $updateCustomer->execute();

        return $updateCustomer;
    }

    public function getCustomerID()
    {

        $getCustomerID = $this->db->prepare("SELECT * FROM customer WHERE customer_id=:customer_id");
        $getCustomerID->bindValue(':customer_id', $this->customerID, PDO::PARAM_STR);
        $getCustomerID->execute();

        $data = $getCustomerID->fetch(PDO::FETCH_ASSOC);
        return $data['customer_id'];
    }

    public function changeCustomerPassword()
    {

        $this->customer_password = htmlspecialchars(strip_tags($this->customer_password));

        $changePassword = $this->db->prepare("UPDATE customer SET customer_password=:customer_password WHERE customer_id=:customer_id");

        $changePassword->bindValue(':customer_password', sha1($this->customer_password), PDO::PARAM_STR);
        $changePassword->bindValue(':customer_id', $this->customerID, PDO::PARAM_STR);

        $changePassword->execute();

        return $changePassword;
    }

    public function getCustomerExistingPassword()
    {

        $getExistingPassword = $this->db->prepare("SELECT * FROM customer WHERE customer_id=:customer_id");
        $getExistingPassword->bindValue(':customer_id', $this->customerID, PDO::PARAM_STR);
        $getExistingPassword->execute();

        $data = $getExistingPassword->fetch(PDO::FETCH_ASSOC);
        return $data['customer_password'];
    }

    public function getExistingCustomerEmail()
    {

        $getExistingCustomerEmail = $this->db->prepare("SELECT * FROM customer WHERE customer_id=:customer_id");
        $getExistingCustomerEmail->bindValue(':customer_id', $this->customerID, PDO::PARAM_STR);
        $getExistingCustomerEmail->execute();

        $data = $getExistingCustomerEmail->fetch(PDO::FETCH_ASSOC);
        return $data['customer_email'];
    }

    public function sendRecoveryToCustomer($email)
    {

        $url = "http://159.203.176.243/change_password.php?email=$email";

        $from = 'From: Sarwaya Server<info@sarwaya.com>' . "\r\n" .
            'Reply-To: info@sarwaya.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $send = mail($email, "RESET YOUR PASSWORD", " Check link sent on this email to reset your password  please visit : $url", $from);
        if ($send) {
            return true;
        } else {
            return false;
        }
    }

    public function checkCustomerDuplicateBooking($agency, $schedule, $customer)
    {

        $checkCustomerDuplicateBooking = $this->db->prepare("SELECT * FROM booking WHERE agency_id=:agency_id 
        && schedule_id=:schedule_id && customer_id=:customer_id");
        $checkCustomerDuplicateBooking->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $checkCustomerDuplicateBooking->bindValue(':schedule_id', $schedule, PDO::PARAM_STR);
        $checkCustomerDuplicateBooking->bindValue(':customer_id', $customer, PDO::PARAM_STR);
        $checkCustomerDuplicateBooking->execute();

        return $checkCustomerDuplicateBooking;
    }

    public function checkCustomerDuplicateAnonymousBooking($customerTime, $customerDate, $customerID, $locationID)
    {

        $checkCustomerDuplicateAnonymousBooking = $this->db->prepare("SELECT * FROM booking WHERE customer_time=:customer_time 
        && pre_booked_date=:pre_booked_date && customer_id=:customer_id && anonymous_location=:anonymous_location");
        $checkCustomerDuplicateAnonymousBooking->bindValue(':customer_time', $customerTime, PDO::PARAM_STR);
        $checkCustomerDuplicateAnonymousBooking->bindValue(':pre_booked_date', $customerDate, PDO::PARAM_STR);
        $checkCustomerDuplicateAnonymousBooking->bindValue(':customer_id', $customerID, PDO::PARAM_STR);
        $checkCustomerDuplicateAnonymousBooking->bindValue(':anonymous_location', $locationID, PDO::PARAM_STR);
        $checkCustomerDuplicateAnonymousBooking->execute();

        return $checkCustomerDuplicateAnonymousBooking;
    }

    public function getCustomerDetails()
    {

        $getCustomerDetails = $this->db->prepare("SELECT * FROM customer WHERE customer_id=:customer_id");
        $getCustomerDetails->bindValue(':customer_id', $this->customerID, PDO::PARAM_STR);
        $getCustomerDetails->execute();

        return $getCustomerDetails;
    }

    public function buyTicket($bookingID, $paymentPhone, $paymentCost, $transactionID)
    {

        $buyTicket = $this->db->prepare("UPDATE booking SET payment_phone=:payment_phone, payment_cost=:payment_cost, is_paid=:is_paid, transactionID=:transactionID WHERE id=:id");

        $buyTicket->bindValue(':payment_phone', $paymentPhone, PDO::PARAM_STR);
        $buyTicket->bindValue(':payment_cost', $paymentCost, PDO::PARAM_STR);
        $buyTicket->bindValue(':is_paid', true, PDO::PARAM_STR);
        $buyTicket->bindValue(':id', $bookingID, PDO::PARAM_STR);
        $buyTicket->bindValue(':transactionID', $transactionID, PDO::PARAM_STR);

        $buyTicket->execute();

        return $buyTicket;
    }

    public function getBookingCustomerIDModel($booking)
    {

        $getCustomerIDinBookingModel = $this->db->prepare("SELECT * FROM booking WHERE id=:id");
        $getCustomerIDinBookingModel->bindValue(':id', $booking, PDO::PARAM_STR);
        $getCustomerIDinBookingModel->execute();

        $data = $getCustomerIDinBookingModel->fetch(PDO::FETCH_ASSOC);
        return $data['customer_id'];
    }

    public function getCustomerIdByTransactionID($transactionID)
    {

        $getCustomerIdByTransactionID = $this->db->prepare("SELECT * FROM booking WHERE transactionID=:transactionID");
        $getCustomerIdByTransactionID->bindValue(':transactionID', $transactionID, PDO::PARAM_STR);
        $getCustomerIdByTransactionID->execute();

        $data = $getCustomerIdByTransactionID->fetch(PDO::FETCH_ASSOC);
        return $data['customer_id'];
    }

    public function getBookingUUIDByTransactionID($transactionID)
    {

        $getBookingUUIDByTransactionID = $this->db->prepare("SELECT * FROM booking WHERE transactionID=:transactionID");
        $getBookingUUIDByTransactionID->bindValue(':transactionID', $transactionID, PDO::PARAM_STR);
        $getBookingUUIDByTransactionID->execute();

        $data = $getBookingUUIDByTransactionID->fetch(PDO::FETCH_ASSOC);
        return $data['booking_uuid'];
    }

    public function getBookingUUID($booking)
    {

        $getBookingUUID = $this->db->prepare("SELECT * FROM booking WHERE id=:id");
        $getBookingUUID->bindValue(':id', $booking, PDO::PARAM_STR);
        $getBookingUUID->execute();

        $data = $getBookingUUID->fetch(PDO::FETCH_ASSOC);
        return $data['booking_uuid'];
    }

    public function getCustomerPhoneNumber($customer)
    {

        $getCustomerPhoneNumber = $this->db->prepare("SELECT * FROM customer WHERE customer_id=:customer_id");
        $getCustomerPhoneNumber->bindValue(':customer_id', $customer, PDO::PARAM_STR);
        $getCustomerPhoneNumber->execute();

        $data = $getCustomerPhoneNumber->fetch(PDO::FETCH_ASSOC);
        return $data['customer_phone'];
    }

    public function getTotalFailedAgencyBooking($agency)
    {

        $totalBookings = $this->db->prepare("SELECT * FROM booking WHERE agency_id=:agency_id && is_paid=:is_paid && transaction_status=:transaction_status");
        $totalBookings->bindValue(':agency_id', $agency, PDO::PARAM_STR);
        $totalBookings->bindValue(':is_paid', false, PDO::PARAM_STR);
        $totalBookings->bindValue(':transaction_status', "Failed", PDO::PARAM_STR);
        $totalBookings->execute();

        $count = $totalBookings->rowCount();

        return $count;
    }

    public function sendSMS($recipients, $message)
    {

        $data
            =
            array(
                "sender" => 'Get All Ltd',
                "recipients" => $recipients,
                "message" => $message,
            );
        $url = "https://www.intouchsms.co.rw/api/sendsms/.json";
        $data = http_build_query($data);
        $username = "username";
        $password = "password";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, "Van" . ":" . "uweaime@123");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,
            CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        echo
        $result;
        echo
        $httpcode;
    }

    public function paymentAPI($phone, $amount, $transactionID)
    {

        $curl = curl_init();

        $password = "45d0e747b78d79f09751ade7e0ad3b9a6d938e23c9261197c020992bc8d2db07";

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.intouchpay.co.rw/api/requestpayment/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "username=getall.group&password=$password&timestamp=20161231115242&mobilephone=$phone&requesttransactionid=$transactionID&amount=$amount",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            $json = json_decode($response, true);
            return $json['message'];
        }
    }

    public function refundCustomer($phone, $amount)
    {

        $curl = curl_init();

        $password = "45d0e747b78d79f09751ade7e0ad3b9a6d938e23c9261197c020992bc8d2db07";
        $transactionID = rand();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.intouchpay.co.rw/api/requestdeposit/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "username=getall.group&password=$password&timestamp=20161231115242&mobilephone=$phone&requesttransactionid=$transactionID&amount=$amount&reason=reason&sid=1&withdrawcharge=120",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            $json = json_decode($response, true);
            return $json['message'];
        }
    }

    public function updateTransactionStatus($transactionID, $status)
    {

        $updateTransactionStatus = $this->db->prepare("UPDATE booking SET transaction_status=:transaction_status WHERE transactionID=:transactionID");
        $updateTransactionStatus->bindValue(':transactionID', $transactionID, PDO::PARAM_STR);
        $updateTransactionStatus->bindValue(':transaction_status', $status, PDO::PARAM_STR);
        $updateTransactionStatus->execute();

        return $updateTransactionStatus;
    }

    public function addNewCustomerPassword($customer_email, $customer_password)
    {

        $this->customer_password = htmlspecialchars(strip_tags($this->customer_password));

        $changePassword = $this->db->prepare("UPDATE customer SET customer_password=:customer_password WHERE customer_email=:customer_email");

        $changePassword->bindValue(':customer_password', sha1($customer_password), PDO::PARAM_STR);
        $changePassword->bindValue(':customer_email', $customer_email, PDO::PARAM_STR);

        $changePassword->execute();

        return $changePassword;
    }

    public function saveIntouchJson($statusdesc, $requestid, $status, $requestcode)
    {

        $saveIntouchJson = $this->db->prepare("INSERT INTO intouch_data (statusdesc, requestid, status, requestcode)
        VALUES (:statusdesc, :requestid, :status, :requestcode)");
        $saveIntouchJson->bindValue(':statusdesc', $statusdesc, PDO::PARAM_STR);
        $saveIntouchJson->bindValue(':requestid', $requestid, PDO::PARAM_STR);
        $saveIntouchJson->bindValue(':status', $status, PDO::PARAM_STR);
        $saveIntouchJson->bindValue(':requestcode', $requestcode, PDO::PARAM_STR);
        $saveIntouchJson->execute();

        return $saveIntouchJson;
    }
}