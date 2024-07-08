<?php

namespace UserFrosting;
//require_once "Classes/PHPExcel.php";

use Illuminate\Support\Facades\Auth;

class ReservationController extends \UserFrosting\BaseController
{

    protected static $_table_id = "reservation";

    /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app)
    {
        $this->_app = $app;
    }

    public function createReservation()
    {
        // Fetch the POSTed data
        $post = $this->_app->request->post();
        // Load the request schema
        $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/reservation-create.json");

        // Get the alert message stream
        $ms = $this->_app->alerts;

        // Set up Fortress to process the request
        $rf = new \Fortress\HTTPRequestFortress($ms, $requestSchema, $post);

        // Sanitize
        $rf->sanitize();

        // Validate, and halt on validation errors.
//        if (!$rf->validate()) {
//            $this->_app->halt(400);
//        }

        // Get the filtered data
        $data = $rf->data();

        //create new reservation
        $new_reservation = new Reservation([
            "collected_fees" => $post['collected_fees'],
            "customer_type_of_id" => $post['customer_type_of_id'],
            "customer_id" => $post['customer_id'],
            "customer_name" => $post['customer_name'],
            "reservation_date" => $post['reservation_date'],
            "customer_address" => $post['customer_address'],
            "phone_number" => $post['phone_number'],
            "mobile" => $post['mobile'],
            "issued_by" => $post['issued_by'],
            "total_price" => $post['total_price'],
            "origin_price" => $post['origin_price'],
            "leadID" => $post['leadID'],
            "country" => $post['country'],
            "city" => $post['city'],
            "region" => $post['region'],
            "street" => $post['street'],
            "mailbox" => $post['mailbox'],
            "postalcode" => $post['postalcode'],
            "workphone" => $post['workphone'],
            "email_address" => $post['email'],
            "directInstallmentAdded" => $post["directInstallmentAdded"],
            "PaymentMethod_select"=>$post["PaymentMethod_select"],
            "currency"=>$post["currency"],
            "exchange_rate"=>$post["exchange_rate"],
            "reservation_email_note" => $post['reservation_email_note'],
            "addition_details" => $post['addition_details'],
            "discount_details" => $post['discount_details'],
            "user_did_action" => User::find($_SESSION["userfrosting"]["user_id"])->display_name
        ]);


        $unitsReserved = $new_reservation->getUnits($post['uid']);
        // return json_encode(sizeof($unitsReserved));
        if (sizeof($unitsReserved) > 0) {
            $this->_app->halt(451, $message = 'sorry this unit was reserved by another user');
        }
        $new_reservation->save();
        // create many to many table with reservation_unit
        $unit = Unit::find($post['uid']);
        $new_reservation->units()->attach($unit->id);
        // create many to many table with reservation_user
        $current_user_id = $_SESSION["userfrosting"]["user_id"];
        $new_reservation->users()->attach($current_user_id);
        return $new_reservation;


    }

    public function SaveTempReservation(){
        $post = $this->_app->request->post();


// Create connection
//$conn = mysqli_connect($servername, $username, $password);
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root","", $db_connection_string,"3306");
// Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully" . '<br/>';

        mysqli_set_charset($conn,"utf8");

        $uid = $post["reservationTemp"]["uid"];
        $query_uid = "SELECT * FROM `reservation_temp` WHERE `uid` = '".$uid."'";
        $result_uid = $conn->query($query_uid);
        if ($result_uid->num_rows > 0) {
            $query_update = "UPDATE `reservation_temp` SET `uid`='".$post["reservationTemp"]["uid"]."',`customer_id`='".$post["reservationTemp"]["customer_id"]."',`customer_name`='".$post["reservationTemp"]["customer_name"]."',`issued_by`='".$post["reservationTemp"]["issued_by"]."',`customer_type_of_id`='".$post["reservationTemp"]["customer_type_of_id"]."',
                            `leadID`='".$post["reservationTemp"]["leadID"]."',`country`='".$post["reservationTemp"]["country"]."',`city`='".$post["reservationTemp"]["city"]."',`region`='".$post["reservationTemp"]["region"]."',
                            `street`='".$post["reservationTemp"]["street"]."',`mailbox`='".$post["reservationTemp"]["Mailbox"]."',`postalcode`='".$post["reservationTemp"]["postalcode"]."',
                            `email_address`='".$post["reservationTemp"]["email"]."',`workphone`='".$post["reservationTemp"]["workphone"]."',`phone_number`='".$post["reservationTemp"]["phone_number"]."',
                            `mobile`='".$post["reservationTemp"]["mobile"]."',
                            `note`='".$post["reservationTemp"]["reservation_email_note"]."' WHERE `uid` = '".$post["reservationTemp"]["uid"]."'";

            echo $query_update;
            $result_update = $conn->query($query_update);
            echo "Updated Successfully";

        }
        else {
            $query = "INSERT INTO `reservation_temp`(`uid`, `customer_id`, `customer_name`, `issued_by`, `customer_type_of_id`,
                  `leadID`, `country`, `city`, `region`, `street`, `mailbox`, `postalcode`, `email_address`, `workphone`,
                   `phone_number`, `mobile`, `note`)
                     VALUES
                      ('".$post["reservationTemp"]["uid"]."','".$post["reservationTemp"]["customer_id"]."','".$post["reservationTemp"]["customer_name"]."',
                      '".$post["reservationTemp"]["issued_by"]."','".$post["reservationTemp"]["customer_type_of_id"]."','".$post["reservationTemp"]["leadID"]."',
                      '".$post["reservationTemp"]["country"]."','".$post["reservationTemp"]["city"]."','".$post["reservationTemp"]["region"]."',
                      '".$post["reservationTemp"]["street"]."','".$post["reservationTemp"]["Mailbox"]."','".$post["reservationTemp"]["postalcode"]."',
                      '".$post["reservationTemp"]["email"]."','".$post["reservationTemp"]["workphone"]."','".$post["reservationTemp"]["phone_number"]."',
                      '".$post["reservationTemp"]["mobile"]."','".$post["reservationTemp"]["reservation_email_note"]."')";



            $result = $conn->query($query);
            if($result) {
                echo "Added Successfully";
            }
            else {
                echo "Failed to register";
            }
        }
    }

    public function GetTempReservation($id){

// Create connection
//$conn = mysqli_connect($servername, $username, $password);
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root","", $db_connection_string,"3306");
// Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        //echo "Connected successfully" . '<br/>';

        mysqli_set_charset($conn,"utf8");

        $uid = $id;
        $query = "SELECT * FROM `reservation_temp` WHERE `uid` = '".$uid."'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $data = [];
            $row = $result->fetch_assoc();
                array_push($data,
                    [
                        "customer_id" => $row["customer_id"],
                        "customer_name" => $row["customer_name"],
                        "issued_by" => $row["issued_by"],
                        "customer_type_of_id" => $row["customer_type_of_id"],
                        "leadID" => $row["leadID"],
                        "country" => $row["country"],
                        "city" => $row["city"],
                        "region" => $row["region"],
                        "street" => $row["street"],
                        "mailbox" => $row["mailbox"],
                        "postalcode" => $row["postalcode"],
                        "email_address" => $row["email_address"],
                        "workphone" => $row["workphone"],
                        "phone_number" => $row["phone_number"],
                        "mobile" => $row["mobile"],
                        "note" => $row["note"],
                    ]);


            $data = json_decode(json_encode($data), true);
            echo json_encode($data);
        }
        else {
            echo "no data";
        }

    }

    public function GetCurrencyOfUnit($id)
    {
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root","", $db_connection_string,"3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn,"utf8");

        $query = "SELECT * FROM `uf_unit` WHERE `id` = '".$id."'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo $row['price_currency'];
        } else {
            echo '$';
        }

    }
    public function deleteReservation()
    {
        $delete = $this->_app->request->delete();

        $unitId = $delete['uid'];
        $reason = $delete['reason'];
        $user = $delete['user'];

        $unit = Unit::find($unitId);
        $reservation = $unit->reservations($unitId);
        $configController=new ConfigurationController($this->_app);

        if ( count($reservation) > 0) {
            $emailList = $configController->getCancellationEmailList();
            // Delete all related to the cancel
            $reservation_id = $reservation[0]['reservation_id'];
            $reservationInfo = Reservation::find($reservation_id);
            if ($reservationInfo) {
                $customerName = $reservationInfo['customer_name'];

                $reservation_user = $reservationInfo->users()->get();
                $user_name = $reservation_user[0]["user_name"];


                $new_reason = new CancelReason([
                    "user_id" => $_SESSION['userfrosting']['user_id'],
                    "unit_id" => $unitId,
                    "flag" => 0,
                    "date" => date("Y/m/d"),
                    "reason" => $reason,
                    "id"=>"0"
                ]);
                $new_reason->save();

                $email = new EmailTemplateController($this->_app);
                if ($user == "admin") {
                    // send email
                    $email->notifyingEmail($reservationInfo, $unit, $reservation_user, 'Cancel Reservation Unit Email', $emailList);
                } else {
                    $email->notifyingEmail($reservationInfo, $unit, $reservation_user, 'Unit Cancellation Request Approved', $emailList);
                }


                // delete many to many relationship
                $reservationInfo->units()->detach($unit);

                if ($reservation_user) {
                    $reservation_user_email = $reservation_user[0]["email"];
                    $reservationInfo->users()->detach($reservationInfo['user_id']);
                } else {
                    echo 'reservation user not exist';
                }

                // delete reservation
                $reservationInfo->delete();

                // save History
                $history = new UnitHistory([
                    "user_name" => $user_name,
                    "uid" => $unitId,
                    "action"=> 'Cancellation for Reason: '.$reason,
                    "date"=> date("Y/m/d"),
                    "customer_name"=>$customerName
                ]);
                $history->save();


            } else {
                echo 'reservation not exist';
            }

        }  else {
            echo 'reservation id not exist';

            $new_reason = new CancelReason([
                "user_id" => $_SESSION['userfrosting']['user_id'],
                "unit_id" => $unitId,
                "flag" => 0,
                "date" => date("Y/m/d"),
                "reason" => $reason,
                "id"=>"0"
            ]);
            $new_reason->save();
        }

        Unit::payments1Delete($unitId);
        $unit->available = 1;
        $unit->save();


    }

    public function getReservation($id)
    {
        $unit = Unit::find($id);
        if ($unit != null && sizeof($unit->reservations($id)) > 0) {

            $reservation_id = $unit->reservations($id)[0]['reservation_id'];

            $reservation = Reservation::find($reservation_id);

            $reservationUser = $reservation->users()->get()[0]['user_name'];

            $reservation->reservationUser = $reservationUser;

            $reservation->floorNum = $unit->floor;
            $reservation->buildingNum = $unit->building;

            $neighborhood = Neighborhoods::where('haiEnglishName',$unit->neighborhood)->first();

            $reservation->landNum = $neighborhood->land;
            $reservation->haiName = $neighborhood->haiArabicName;
            $reservation->unitnum = $unit->unit;

            return $reservation;
        }

        return null;
    }

    public function getReservationFromUnitId($id)
    {

        $unit = Unit::find($id);
        $reservation_id = $unit->reservations($id)[0]['reservation_id'];
        $reservation = Reservation::find($reservation_id);
        $reservationUser = $reservation->users()->get()[0];
        return $reservationUser;

    }

    public function getUserReservation($user_id)
    {
        $userReservations = array();
        $reservations = Reservation::get();
        /*check if reservation exist*/
        if (sizeof($reservations) > 0) {
            $reservations = $reservations[0]->getUsers($user_id);
            foreach ($reservations as $key => $reservation) {
                // check if reservation exist
                if (Reservation::find($reservation['reservation_id'])) {
                    $unit = Reservation::find($reservation['reservation_id'])->units()->get();
                    // check if unit exist
                    if ($unit && isset($unit[0])) {
                        for ($i = 0; $i < count($unit); $i++) {
                            $neighborhood = Neighborhoods::where('haiEnglishName', '=', $unit[$i]['neighborhood'])->get();
                            if (!isset($neighborhood[0]['haiArabicName'])) {
                                $neighborhood[0]['haiArabicName'] = $unit[$i]['neighborhood'];
                            }
                            $unit[$i]['neighborhood'] .= "-" . $neighborhood[0]['haiArabicName'];
                            $unit[$i]['ar_neighborhood'] = $neighborhood[0]['haiArabicName'];
                            $unit[$i]['user_group'] = 1;
                        }

                        array_push($userReservations, $unit[0]);
                    }
                }
            }
        }
        return $userReservations;
    }

    public function getPrice()
    {
        $post = $this->_app->request->post();
        $uid = $post['uid'];

        $unitData = Unit::find($uid);
        $unitBuilding = $unitData['building'];
        $unitApartment = $unitData['unit'];
        $unitfloor=$unitData['floor'];
        $unitNeighbrhoud = $unitData['neighborhood'];

        $str = $unitData['rawabi_code'];
        $str_f =  explode("(",$str);
        $str_s =  explode(")",$str_f[1]);
        $str_t =  explode("-",$str_s[0]);
        $rawabi_left_side  = intval($str_t[0]);
        $rawabi_right_side = intval($str_t[1]);

        switch ($unitNeighbrhoud) {
            case "Dulaim":
                $neighbourVal = "دليم";
                break;
            case "Makmata":
                $neighbourVal = "مكمتة";
                break;
            case "Warwar":
                $neighbourVal = "وروار";
                break;
            case "Suwan":
                $neighbourVal = "صوان";
                break;
            default:
                $neighbourVal = "دليم2";
        }
        // Edited by ahmad tome (mix floor number with unit number , because it is format in finishing system)
        $unit_number = $unitfloor.''.$unitApartment ;

        echo $unit_number;
    }

    public function reviewReservationEmail()
    {
        $post = $this->_app->request->post();
        $unitParams = Unit::find($post['uid']);
        $userParams = $this->_app->user;
        $reservedUnitParams = array(
            "reservation_date" => ($post['reservation_date']),
            "customer_name" => $post['customer_name'],
            "mobile" => $post['mobile'],
            "customer_address" => $post['customer_address'],
            "leadID" => $post['leadID'],
            "collected_fees" => $post['collected_fees'],
            "total_price" => $post['total_price'],
            "reservation_email_note" => $post['reservation_email_note'],
            "phone_number"=>$post['phone_number'],
            "customer_type_of_id"=>$post['customer_type_of_id'],
            "issued_by"=>$post['issued_by'],
            "customer_id"=>$post['customer_id'],
            "directInstallmentAdded"=>$post["directInstallmentAdded"],
            "PaymentMethod_select"=>$post["PaymentMethod_select"],
            "currency"=>$post["currency"]
        );
        $discountParams = Discount::find($post['discount_name']);
        $additionName = $post['addition_name'];

        // it was develpoped to get the of addition

        if ($additionName == '') {
            $additionParams = '0';
            $additionHintParam = 0;
        } else {
            $additionHintParam = 1;
            $additionParams = Addition::find($additionName);
        }

        /* if ($additionName == '0') {
            $additionParams = '0';
            $additionHintParam = 0;
        } else {
            $additionHintParam = 1;
            $additionParams = Addition::find($additionName);
        }
        */

        $templateParams = array('user' => $userParams, 'unit' => $unitParams, 'reservedUnit' => $reservedUnitParams,
            'discount' => $post['discount_name'], 'additionHint' => $additionHintParam, 'addition' => $additionName);

        /* $templateParams = array('user' => $userParams, 'unit' => $unitParams, 'reservedUnit' => $reservedUnitParams,
            'discount' => $discountParams, 'additionHint' => $additionHintParam, 'addition' => $additionParams); */
        $twig = $this->_app->view();

        $this->_app->render("mail/email-template.twig", $templateParams);
    }

    public function getReceiptTemplate(){
        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully" . '<br/>';

        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `receipt_content`";
        $result = $conn->query($query);



        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->_app->render('contract/receipt.twig', [
                "contractsections" => $row
            ]);

        } else {
            echo "0 results";
        }

    }

    function updateReceiptContent(){
        $post = $this->_app->request->post();

        $id = $post['id'];
        $content = $post['content'];
        //$content = 'frfrfrhi';

        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully" . '<br/>';

        mysqli_set_charset($conn, "utf8");

        $query = "UPDATE `receipt_content` SET `" . $id . "`='" . $content . "', `content2`='" . $content . "', `content3`='" . $content . "'";
        echo $query;
        if ($conn->query($query) === TRUE) {
            echo "Updated Successfully";
        } else {
            echo "Something went error";

        }
    }

    public function getcontenthtml(){
        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully" . '<br/>';

        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `receipt_content`";
        $result = $conn->query($query);



        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;

        } else {
            echo "0 results";
        }
    }

}
