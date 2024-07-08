<?php

namespace UserFrosting;

use DateInterval;
use DateTime;
use DateTimeZone;
use Traversable;
use UserFrosting\Payment;
use UserFrosting\Unit;
use Zend\Stdlib\ArrayUtils;
use UserFrosting\ReservationUser;
use UserFrosting\ReservationUnit;

class Payments1Controller extends \UserFrosting\BaseController
{

    protected static $_table_id = "payments";

    /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app)
    {
        $this->_app = $app;
    }

    public function createPayment1()
    {

        // Fetch the POSTed data
        $post = $this->_app->request->post();


        $paymentPeriod = $post['paymentPeriod'];


        $unitPeriod = unitPaymentPeriod::where('unit_id', $post['uid'])->first();

        if ($unitPeriod) {
            $unitPeriod->period = $paymentPeriod;
            $unitPeriod->save();
        } else {
            $unitPeriod = new unitPaymentPeriod();
            $unitPeriod->period = $paymentPeriod;
            $unitPeriod->unit_id = $post['uid'];
            $unitPeriod->save();
        }


        foreach ($post['payments_array'] as $index => $item) {

            $new_payment = new Payment([
                "unit_id" => $post['uid'],
                "payment_date" => $item['paymentDate'],
                "amount" => $item['paymentAmount'],
                "payment_number" => $item['payment']
            ]);
            $new_payment->save();
        }


        return true;
    }

    public function createStorageParkingPayment()
    {

        // Fetch the POSTed data
        $post = $this->_app->request->post();

        ParkingStoragePayment::where('target', $post['target'])->where('target_id', $post['target_id'])->delete();


        foreach ($post['payments_array'] as $index => $item) {

            $new_payment = new ParkingStoragePayment([
                "target" => $post['target'],
                "target_id" => $post['target_id'],
                "payment_date" => $item['paymentDate'],
                "amount" => $item['paymentAmount'],
                "payment_number" => $item['payment']
            ]);
            $new_payment->save();
        }


        return true;
    }

    public function editPayment1()
    {
        $post = $this->_app->request->post();
        $unit = new Unit();
        $unit->payments1Delete($post['uid']);
        return true;
    }

    public function getPayment($id)
    {

        $payments = Payment::where('unit_id', $id)->orderBy('payment_date')->get();
        return json_encode($payments);

    }

    public function getParkingStoragePayment($id)
    {
        $get = $this->_app->request->get();

        $payments = ParkingStoragePayment::where('target', $get['target'])->where('target_id', $id)->get();
        return json_encode($payments);

    }

    public function getPaymentsForContract($fromDate, $toDate)
    {
        $data = [];

        $unitIds = [];
        $units = Unit::where('available', 3)->get();
        foreach ($units as $unit) {
            array_push($unitIds, $unit->id);
        }
        $payments = Payment::whereIn('unit_id', $unitIds)->Where('payment_date', '>=', $fromDate)->where('payment_date', '<=', $toDate)->with('unit')->get();

        $parkingStoragePayments = ParkingStoragePayment::where('payment_date', '>=', $fromDate)->where('payment_date', '<=', $toDate)->get();
        foreach ($parkingStoragePayments as $parkingStoragePayment) {
            $result = $this->getCustomerNameByPayment($parkingStoragePayment);
            if ($result == "-") {
                continue;
            }
            $parkingStoragePayment['customer_name'] = $result['customer_name'] ?? '';
            $parkingStoragePayment['unit'] = $result['unit'] ?? '';
            $parkingStoragePayment['contract_type'] = $parkingStoragePayment->target . ' ' . $this->getParkingStorageCode($parkingStoragePayment->target, $parkingStoragePayment->target_id);
            $parkingStoragePayment['currency'] = $result['currency'] ?? '';
            array_push($data, $parkingStoragePayment);
        }


        foreach ($payments as $payment) {
            $payment['customer_name'] = $payment->unit->reservationsRel->first()->customer_name ?? '';
            $payment['currency'] = $payment->unit->reservationsRel->first()->currency ?? '';
            $payment['contract_type'] = $this->getContractTypeByUnitId($payment->unit_id);
            array_push($data, $payment);

        }

        echo json_encode($data);

//        $db_connection_string = $this->_app->environment()["db_connection"];
//        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
//        if (!$conn) {
//            die("Connection failed: " . mysqli_connect_error());
//        }
//        mysqli_set_charset($conn, "utf8");
//
//        $query = "SELECT u.id as Repo_unit_id, u.*, cu1.*, c1.*, pu1.*, p1.*
//                    FROM `uf_unit` u Inner JOIN uf_contract1_unit cu1 on u.id = cu1.unit_id
//                    left JOIN uf_contract1 c1 on cu1.contract1_id = c1.id
//                    left join uf_payments1_unit pu1 on u.id = pu1.unit_id
//                    left join uf_payments1 p1 on pu1.payments1_id = p1.id
//                    where p1.paymentDate between DATE('$fromDate') and DATE('$toDate')
//                    order by pu1.unit_id , p1.paymentDate;";
//
//
//        $result = mysqli_query($conn,$query);
//
//        if($result->num_rows > 0) {
//
//            $data = [];
//            while ($row = $result->fetch_assoc()) {
//                array_push($data,
//                    ["customer_name" => $row["purchaser1"] == null ? '-' : $row["purchaser1"],
//                        "city_code" => $row["rawabi_code"] == null ? '-' : $row["rawabi_code"],
//                        "neighborhood" => $row["neighborhood"] == null ? '-' : $row["neighborhood"],
//                        "tapu_code" => $row["tapu_code"] == null ? '-' : $row["tapu_code"],
//                        "contract_type" => $row["contract_type"] == null ? '-' : $row["contract_type"],
//                        "priceTotal" => $row["priceTotal"] == null ? '-' : $row["priceTotal"],
//                        "last_payment_date" => $row["paymentDate"] == null ? '-' : $row["paymentDate"],
//                        "paymentNum" => $row["paymentNum"] == null ? '-' : $row["paymentNum"],
//                        "paymentAmount" => $row["paymentAmount"] == null ? '-' : $row["paymentAmount"],
//                        "paymentDate" => $row["paymentDate"] == null ? '-' : $row["paymentDate"],
//                        "uid" => $row["Repo_unit_id"] == null ? '-' : $row["Repo_unit_id"],
//                    ]);
//            }
//            echo json_encode($data);
//        }

    }

    function getCustomerNameByPayment($payment)
    {
        $target = $payment->target;
        $target_id = $payment->target_id;
        $parkingStorageReservation = parking_storage_reservation::where('type', $target)->where('parking_storage_id', $target_id)->first();
        if (!$parkingStorageReservation) {
            return '-';
        }

        $unitId = $parkingStorageReservation->uid;


        $unit = Unit::where('id', $unitId)->first();

        $currency = $unit->reservationsRel->first()->currency ?? '';

        $customerName = $unit->reservationsRel->first()->customer_name ?? '';


        $data['unit'] = $unit;
        $data['customer_name'] = $customerName;
        $data['currency'] = $currency;

        return $data;
    }

    public function getContractTypeByUnitId($unitId)
    {
        $unit = Unit::with('contract')->where('id', $unitId)->first();
        if (!$unitId) {
            return '';
        }
        return $unit["contract"]["templateName"] ?? 'اتفاقية بيع وشراء وحدة سكنية';
    }

    public function getParkingStorageCode($type, $typeId)
    {
        if ($type == "parking") {
            $parking = Parking::where('id', $typeId)->first();
            if (!$parking) {
                return "";
            }
            return $parking->rawabi_code;
        } else if ($type == "storage") {
            $storage = Storage::where('id', $typeId)->first();
            if (!$storage) {
                return "";
            }
            return $storage->rawabi_code;
        }


        return "";
    }

}
