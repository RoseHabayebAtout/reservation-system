<?php

namespace UserFrosting;


use http\Client\Response;
use Slim\Http\Request;
use UserFrosting\Unit;
use UserFrosting\UnitHistory;
use UserFrosting\ReservationUser;
use UserFrosting\ReservationUnit;

class UnitController extends \UserFrosting\BaseController
{

    protected static $_table_id = "unit";

    /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app)
    {
        $this->_app = $app;
    }

    public function createUnit()
    {
        $new_unit = new Unit([
            "unit" => "1",
            "building" => "2",
            "neighborhood" => "Neighborhood 2",
            "size" => "175 m",
            "floor" => "3",
            "price" => "180000",
            "currency" => "$",
            "available" => "0",
            "Rawabi_code" => "02-01",
            "Building_type" => "Ballour",
            "unitDescription" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid eaque nostrum sint suscipit! Dicta, in!",
            "price" => "120000",
            "tabo_area" => "150"
        ]);
        $new_unit->save();


    }

    public function getUnitFromId($uid)
    {
        $unit = Unit::find($uid);
        return $unit;
    }

    public function checkUnitToPurchaseEnable($uid)
    {

        $payments = Payment::Where('unit_id', $uid)->get();
        $contracts = Contract::Where('unit_id', $uid)->where('status', 'ACTIVE')->get();

        if (count($payments) > 0 && count($contracts) > 0) {
            return 'success';
        }

        return 'failed';

    }

    public function updateUnitFlag()
    {
        // Fetch the POSTed data
        $post = $this->_app->request->post();

        // Load the request schema
        $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/update-unit-available.json");

        // Get the alert message stream
        $ms = $this->_app->alerts;

        // Set up Fortress to process the request
        $rf = new \Fortress\HTTPRequestFortress($ms, $requestSchema, $post);

        // Sanitize
        $rf->sanitize();

        // Validate, and halt on validation errors.
        if (!$rf->validate()) {
            $this->_app->halt(400);
        }

        // Get the filtered data
        $data = $rf->data();
        $unit = Unit::find($post['uid']);

        $unit->available = $post['available'];
        $unit->contract_type = $post['contract_type'];
        $unit->save();

    }

    public function updatepdfPrintFlag()
    {
        // Fetch the POSTed data
        $post = $this->_app->request->post();
        if (isset($post['uid'])) {
            $unit = Unit::find($post['uid']);
            $unit['pdf-print-flag'] = $post['flag'];
            $unit->save();
        } else {
            echo 'Unit Not Exist';
        }
    }

    public function getUnit()
    {
        // Fetch all units
        $unit = Unit::get();
        /*
check primary_group flag if 1 is user if 2 is admin
*/
        $this->_app->render('unit/index.twig', [
            "unit" => $unit,
            "primary_group" => $this->_app->user->__get("primary_group")['id']
        ]);

    }

    public function getUnitDataSales()
    {

        // Fetch all Units
        $unit = Unit::get();
        for ($i = 0; $i < count($unit); $i++) {
            $neighborhood = Neighborhoods::where('haiEnglishName', '=', $unit[$i]['neighborhood'])->get();
            if (!isset($neighborhood[0]['haiArabicName'])) {
                $neighborhood[0]['haiArabicName'] = $unit[$i]['neighborhood'];
            }
            $unit[$i]['neighborhood'] .= "-" . $neighborhood[0]['haiArabicName'];
            $unit[$i]['ar_neighborhood'] = $neighborhood[0]['haiArabicName'];
        }


        // in previous contract they asked just available unit but the new version they asked the sales can see all unints and i edit it in above query
        /*
          // Fetch  all available units
          //$unit =Unit::where('available', '=', 1)->orWhere('available', '=', 2)->get();
          $unit =Unit::where('available', '=', 1)->get();
          for ($i=0; $i < count($unit) ; $i++) {
            $neighborhood = Neighborhoods::where('haiEnglishName', '=', $unit[$i]['neighborhood'])->get();
            if(!isset($neighborhood[0]['haiArabicName'])){
                $neighborhood[0]['haiArabicName'] = $unit[$i]['neighborhood'];
            }
            $unit[$i]['neighborhood'] .= "-".$neighborhood[0]['haiArabicName'];
            $unit[$i]['ar_neighborhood'] = $neighborhood[0]['haiArabicName'];
          }
*/
        return $unit;

    }

    public function getUnitDataAdmin()
    {
        $get = $this->_app->request->get();

        $length = isset($get['length']) ? $get['length'] : 15;
        $start = isset($get['start']) ? $get['start'] : 0;
        $order = isset($get['order']) ? $get['order'] : null;

        $statusFilter = isset($get['statusFilter']) ? $get['statusFilter'] : 'all';
        $neighborhoodFilter = isset($get['neigimageshborhoodFilter']) ? $get['neigimageshborhoodFilter'] : 'all';
        $buildingTypeFilter = isset($get['buildingTypeFilter']) ? $get['buildingTypeFilter'] : 'all';
        $searchText = isset($get['searchText']) ? $get['searchText'] : '';

        $db_connection_string = $this->_app->environment()["db_connection"];

        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `uf_unit` u ";
        $query_count = "SELECT count(u.id) as total FROM `uf_unit` u ";
        $status_query = null;
        $neighborhood_query = null;
        $building_type_query = null;

        if ($statusFilter != 'all' && $statusFilter != "") {
            $status_query = "" . " u.available= '" . $statusFilter . "'";
        }

        if ($neighborhoodFilter != 'all' && $neighborhoodFilter != "") {
            $neighborhood_query = "" . " u.neighborhood= '" . $neighborhoodFilter . "'";
        }
        if ($buildingTypeFilter != 'all' && $buildingTypeFilter != "") {
            $building_type_query = "" . " u.building_type= '" . $buildingTypeFilter . "'";
        }

        $query_appender = " where ";
        if ($searchText != null && $searchText != "") {
            $query = $query . $query_appender . " u.neighborhood like '%" . $searchText . "%'" .
                " OR u.tapu_code like '%" . $searchText . "%'"
                . " OR u.building_type like '%" . $searchText . "%'"
                . " OR u.rawabi_code like '%" . $searchText . "%'";

            $query_count = $query_count . $query_appender . " u.neighborhood like '%" . $searchText . "%'" .
                " OR u.tapu_code like '%" . $searchText . "%'"
                . " OR u.building_type like '%" . $searchText . "%'"
                . " OR u.rawabi_code like '%" . $searchText . "%'";
            $query_appender = "and";
        }

        if ($status_query != null || $neighborhood_query != null || $building_type_query != null) {
            if ($status_query != null) {
                $query = $query . $query_appender . $status_query;
                $query_count = $query_count . $query_appender . $status_query;

                $query_appender = " and ";
            }

            if ($neighborhood_query != null) {
                $query = $query . $query_appender . $neighborhood_query;
                $query_count = $query_count . $query_appender . $neighborhood_query;
                $query_appender = " and ";
            }

            if ($building_type_query != null) {
                $query = $query . $query_appender . $building_type_query;
                $query_count = $query_count . $query_appender . $building_type_query;
            }
        }

        if ($order != null) {
            $order_by_field = "u.neighborhood";
            $column = $order[0]['column'];
            if ($column == 1) {
                $order_by_field = "u.neighborhood";
            } else if ($column == 2) {
                $order_by_field = "u.rawabi_code";
            } else if ($column == 3) {
                $order_by_field = "u.tapu_code";
            } else if ($column == 4) {
                $order_by_field = "u.size";
            } else if ($column == 5) {
                $order_by_field = "u.available";
            } else if ($column == 6) {
                $order_by_field = "u.building_type";
            }
            $dir = $order[0]['dir'];
            $query = $query . " order by " . $order_by_field . " " . $dir;
        }

        $query = $query . " LIMIT " . $start . "," . $length;

        $result = $conn->query($query);
        $result_count_statement = $conn->query($query_count);
        $total_records = $result_count_statement->fetch_assoc()['total'];

        $unit = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($unit, [
                    'id' => $row['id'],
                    'available' => $row['available'],
                    'neighborhood' => $row['neighborhood'],
                    'contract_type' => $row['contract_type'],
                    'building_type' => $row['building_type'],
                    'building' => $row['building'],
                    'rawabi_code' => $row['rawabi_code'],
                    'tapu_code' => $row['tapu_code'],
                    'size' => $row['size'],
                    'price' => $row['price']
                ]);
            }
        }

        for ($i = 0; $i < count($unit); $i++) {
            $unit_id_info = Unit::find($unit[$i]["id"]);

            $db_connection_string = $this->_app->environment()["db_connection"];
            $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            mysqli_set_charset($conn, "utf8");

            $query = "SELECT * FROM `parking_storage_reservation` WHERE `uid` = " . $unit_id_info['id'];
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['type'] == "storage") {
                        $unit[$i]["storageId"] = $row['parking_storage_id'];
                    } else if ($row['type'] == "parking") {
                        $unit[$i]["parkingId"] = $row['parking_storage_id'];
                    }
                }
            }

            if ($unit[$i]["available"] == 0 || $unit[$i]["available"] == 3) {

                $reservation_id = $unit_id_info->reservations($unit_id_info['id']);
                if ($reservation_id != null && sizeof($reservation_id) > 0) {
                    $reservation_id = $reservation_id[0]['reservation_id'];
                } else {
                    $reservation_id = 0;
                }
                $reservation = Reservation::find($reservation_id);

                if ($reservation != null) {

                    $reservation_user = $reservation->users()->get();

                    $reservation_user_name = count($reservation_user) ? $reservation_user[0]["user_name"] : ' ';
                    // add new attributes for the reservation json
                    $unit[$i]["Reservation_price"] = $reservation['total_price'];
                    $unit[$i]["customer_name"] = $reservation['customer_name'];
                    $unit[$i]["reservation_date"] = $reservation['reservation_date'];
                    $unit[$i]["user_name"] = $reservation_user_name;

                }


                if ($unit[$i]["available"] == 3) {
                    switch (true) {
                        case $unit_id_info['contract_type'] == 1 :
                            $contract_id = $unit_id_info->contracts1($unit_id_info['id']);
                            if ($contract_id != null) {
                                $contract_id = $contract_id[0]['contract1_id'];
                            } else {
                                $contract_id = 0;
                            }


                            $contract = Contract1::find($contract_id);
                            if ($contract != null) {
                                $unit[$i]["contract_price"] = $contract['priceTotal'];
                                $unit[$i]["contractDate"] = $contract['contractDate'];
                                $unit[$i]["finishing_price"] = $contract['pricePart3'];

                            };

                            break;

                        case $unit_id_info['contract_type'] == 2 :
                            $contract_id = $unit_id_info->contracts2($unit_id_info['id']);

                            if ($contract_id != null) {
                                $contract_id = $contract_id[0]['contract2_id'];
                            } else {
                                $contract_id = 0;
                            }


                            $contract = Contract2::find($contract_id);
                            if ($contract != null) {
                                $unit[$i]["contract_price"] = $contract['r_totalPrice'];
                                $unit[$i]["contractDate"] = $contract['contract2Date'];
                                $unit[$i]["finishing_price"] = $contract['extraAdditions'];


                            };

                            break;


                        case $unit_id_info['contract_type'] == 3 :

                            $contract_id = $unit_id_info->contracts3($unit_id_info['id']);
                            if ($contract_id != null) {
                                $contract_id = $contract_id[0]['contract3_id'];
                            } else {
                                $contract_id = 0;
                            }


                            $contract = Contract3::find($contract_id);
                            if ($contract != null) {
                                $unit[$i]["contract_price"] = $contract['price'];
                                $unit[$i]["contractDate"] = $contract['contractDate'];
                                $unit[$i]["finishing_price"] = $contract['extraAdditions'];

                            };

                            break;
                    }
                }


            }
            $neighborhood = Neighborhoods::where('haiEnglishName', '=', $unit[$i]['neighborhood'])->get();
            if (!isset($neighborhood[0]['haiArabicName'])) {
                $neighborhood[0]['haiArabicName'] = $unit[$i]['neighborhood'];
            }
            $unit[$i]['neighborhood'] .= "-" . $neighborhood[0]['haiArabicName'];
            $unit[$i]['ar_neighborhood'] = $neighborhood[0]['haiArabicName'];

            $history = UnitHistory::where('uid', $unit[$i]["id"])->orderBy('date', 'DESC')->orderBy('id', 'DESC')->first();
            if (isset($history)) {
                $unit[$i]['last_modified_user'] = $history->user_name;
            } else {
                $unit[$i]['last_modified_user'] = '';
            }

            $unit[$i]['reservation_user'] = '';

            $reservationUnit = ReservationUnit::Where('unit_id', $unit[$i]["id"])->first();

            if (isset($reservationUnit)) {

                $reservationUser = ReservationUser::Where('reservation_id', $reservationUnit->reservation_id)->first();

                if (isset($reservationUser)) {

                    $user = User::Where('id', $reservationUser->user_id)->first();

                    if (isset($user)) {

                        $unit[$i]['reservation_user'] = $user->user_name;
                    }
                }
            }
        }

        $itemItem = [
            "iTotalRecords" => $total_records,
            "iTotalDisplayRecords" => $total_records,
            "data" => $unit,
        ];

        return $itemItem;

    }

    public function getReservedAppartmentsId()
    {

        if (isset($_REQUEST['dashboard']) && $_REQUEST['dashboard'] == true) {
            $db_connection_string = $this->_app->environment()["db_connection"];

            $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            mysqli_set_charset($conn, "utf8");


            $query = "SELECT u.*, r.reservation_date, r.customer_name, ru.id as reservation_id  FROM uf_unit u left JOIN uf_reservation_unit ru on u.id = ru.unit_id left join uf_reservation r on ru.reservation_id = r.id where u.available = 0 and
                            DATE(r.reservation_date) < DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                $recentReserved = [];
                while ($row = $result->fetch_assoc()) {
                    array_push($recentReserved, [
                        'id' => $row['id'],
                        'reservation_id' => $row['reservation_id'],
                        'neighborhood' => $row['neighborhood'],
                        'company_code' => $row['rawabi_code'],
                        'building_type' => $row['building_type'],
                        'customer_name' => $row['customer_name'],
                        'reservation_date' => $row['reservation_date'],
                    ]);
                }

                for ($i = 0; $i < count($recentReserved); $i++) {

                    $recentReserved[$i]['last_modified_user'] = $recentReserved[$i]['id'];

                    $history = UnitHistory::where('uid', $recentReserved[$i]['id'])->orderBy('date', 'DESC')->orderBy('id', 'DESC')->first();

                    if (isset($history)) {
                        $recentReserved[$i]['last_modified_user'] = $history->user_name;
                    } else {
                        $recentReserved[$i]['last_modified_user'] = '';
                    }

                    $reservationUser = ReservationUser::Where('reservation_id', $recentReserved[$i]['reservation_id'])->first();

                    if (isset($reservationUser)) {

                        $user = User::Where('id', $reservationUser->user_id)->first();

                        if (isset($user)) {

                            $recentReserved[$i]['reservation_user'] = $user->user_name;
                        }
                    }
                }


                echo json_encode($recentReserved);
                return;
            } else {
                echo json_encode([]);
            }

        }

//          // Fetch all Units
//          $units = Unit::where('available', '=', 0)->get()->map(function ($unit) {
//            return $unit->id;
//          });
//          echo json_encode($units);

    }

    public function changeBuildingType()
    {

        $post = $this->_app->request->post();
        $uId = $post['uid'];
        $type = $post['type'];
        $unit = Unit::find($uId);
        echo $unit['available'];
        $unit['available'] = $type;
        $unit->save();
        echo $unit['available'];
    }

    public function getAvailableUnits()
    {
        // Fetch all the available,Rented Units
        $units = Unit::where('available', '=', 1)->get();
        // $units['rented'] = Unit::where('available', '=', 4)->get();
        echo json_encode($units);
    }

    public function getRentedUnits()
    {
        // Fetch all the available,Rented Units
        $units = Unit::where('available', '=', 4)->get();
        echo json_encode($units);
    }

    /***To be used when cancellation method is invoked***/
    public function getCertainUnit()
    {

        $post = $this->_app->request->post();
        $unit = Unit::find($post['uid']);
        return $unit;
    }

    /*********************to be used when filter is used via neighbrhood**********************************/
    public function getUnitsFromNeighbrhood()
    {

        $post = $this->_app->request->post();
        $neighborhood = $post['neighborhood'];

        /*$collection=Unit::where('neighborhood', $neighborhood)->exclude(['building','price','unit','floor','unitDescription','available','size','contract_type','Building_type','pdf-print-flag'])->get();*/
        $collection = Unit::where('neighborhood', '=', $neighborhood, 'and')->get();
        $sorted_groupedBy = $collection->sortBy('rawabi_code', SORT_NATURAL, false)->groupBy('rawabi_code');
        $myarray = json_encode($sorted_groupedBy);
        $dataArray = array();

//Remove the duplicates from the returned array
        foreach ($sorted_groupedBy as $key => $value) {
            $mykey = $key;
            $dataObj['rawabi_code'] = $key;
            $dataObj['id'] = $value[0]['id'];
            array_push($dataArray, $dataObj);

        }
        echo json_encode($dataArray);

    }


    public function getStoragesOrParkingsFromNeighbrhood()
    {

        $post = $this->_app->request->post();

//        echo '<pre>';
//        print_r($post);
//        echo '</pre>';
//        die();
//        return;


        $neighborhood = $post['neighborhood'];
        $db_connection_string = $this->_app->environment()["db_connection"];

        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
// Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($conn, "utf8");

        if ($post['type'] == "Storages") {
            $query = "SELECT * FROM `storages` WHERE `neighporhood`= '" . $neighborhood . "'";
        } else if ($post['type'] == "Parkings") {
            $query = "SELECT * FROM `parking` WHERE `neighporhood`= '" . $neighborhood . "'";
        } else {
            $query = "SELECT * FROM `uf_unit` WHERE `neighborhood`= '" . $neighborhood . "'";
        }

        $result = $conn->query($query);
//        echo '<pre>';
//        print_r(['$query'=>$query,'$result' => $result]);
//        echo '</pre>';
//        die();
        if ($result->num_rows > 0) {
            $collection = [];
            while ($row = $result->fetch_assoc()) {
                array_push($collection, ['rawabi_code' => $row['rawabi_code'], 'id' => $row['id']]);
            }
        } else {
            return [];
        }

        //$collection=Unit::where('neighborhood', '=',$neighborhood,'and')->get();
//$sorted_groupedBy = $collection->sortBy('rawabi_code', SORT_NATURAL, false)->groupBy('rawabi_code');
//$myarray=json_encode($sorted_groupedBy);
        $dataArray = array();


//Remove the duplicates from the returned array
        for ($i = 0; $i < count($collection); $i++) {

            $dataObj['rawabi_code'] = $collection[$i]['rawabi_code'];
            $dataObj['id'] = $collection[$i]['id'];
            array_push($dataArray, $dataObj);

        }
        echo json_encode($dataArray);

    }

    public function deleteUnit()
    {
        $post = $this->_app->request->post();

        $unit = Unit::find($post['unitID']);
        if ($unit == '')
            echo "False";
        else {
            $unit->delete();
            echo "Success";
        }


    }


//function to change the status of purchased unit to available

    public function changeToAvailable()
    {

        $post = $this->_app->request->post();
        $unitId = $post['unitId'];
        $unit = Unit::find($unitId);
        $unit['available'] = 1;
        $unit->save();

        $reservations = $unit->reservations($unitId);

        if (count($reservations)) {

            $reservation_id = $reservations[0]['reservation_id'];
            $reservation = Reservation::find($reservation_id);
            $reservation_user = $reservation->users()->get();

            if (count($reservation_user)) {

                $reservation_user_email = $reservation_user[0]["email"];
                // delete many to many relationship
                $reservation->units()->detach($unit);
                $reservation->users()->detach($reservation['user_id']);
                echo $reservation_user_email;

            }

            // delete reservation
            $reservation->delete();
        }

        Unit::payments1Delete($post['unitId']);
        Unit::contractsDelete($post['unitId']);

    }

    public function changeSignedToAvailable()
    {

        $post = $this->_app->request->post();
        $unitId = $post['unitId'];
        $unit = Unit::find($unitId);

        if ($this->_app->user->primary_group_id == 2) {

            $unit['available'] = 1;
            $unit->save();

            $reservations = $unit->reservations($unitId);

            if (count($reservations)) {

                $reservation_id = $reservations[0]['reservation_id'];
                $reservation = Reservation::find($reservation_id);
                $reservation_user = $reservation->users()->get();

                if (count($reservation_user)) {

                    $reservation_user_email = $reservation_user[0]["email"];
                    // delete many to many relationship
                    $reservation->units()->detach($unit);
                    $reservation->users()->detach($reservation['user_id']);
                    echo $reservation_user_email;

                }

                // delete reservation
                $reservation->delete();
            }


            Unit::payments1Delete($post['unitId']);
            Unit::contractsDelete($post['unitId']);
            echo "Success";

        } else {

            $unit['available'] = 6;
            $unit->save();
        }
    }


    public function getStorages()
    {
        $get = $this->_app->request->get();
        $neighborhood = $get['neighborhood'];
        $building = $get['building'];

        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `storages` WHERE `neighporhood` = '" . $neighborhood . "' and `building` = '". $building ."' ORDER By `rawabi_code`";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $storages = [];
            while ($row = $result->fetch_assoc()) {
                array_push($storages, ["rawabi_code" => $row["rawabi_code"], "storage_number" => $row["storage_number"],
                    "area" => $row["area"], "price" => $row["price"], "available" => $row["available"],
                    "tabu_description" => $row["tabu_description"], "floor" => $row["floor"], "tabu_code" => $row["tabu_code"], "id" => $row["id"]
                ]);
            }
            $storages = json_decode(json_encode($storages), true);
            echo json_encode($storages);
        } else {
            return [];
        }
    }


    public function getParkings()
    {

        $get = $this->_app->request->get();
        $neighborhood = $get['neighborhood'];
        $building = $get['building'];

        $db_connection_string = $this->_app->environment()["db_connection"];

        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `parking` WHERE `neighporhood` = '" . $neighborhood . "' and `building` = '". $building ."' ORDER By `rawabi_code`";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $parkings = [];
            while ($row = $result->fetch_assoc()) {
                array_push($parkings, ["rawabi_code" => $row["rawabi_code"], "parking_number" => $row["parking_number"],
                    "price" => $row["price"], "available" => $row["available"], "building" => $row["building"],
                    "description" => $row["description"], "floor" => $row["floor"], "id" => $row["id"]
                ]);
            }
            $parkings = json_decode(json_encode($parkings), true);
            echo json_encode($parkings);
        } else {
            return [];
        }
    }


    function getStorageInfo()
    {
        if ($this->_app->request->isGet()) {
            $get = $this->_app->request->get();
        } else {
            $get = $this->_app->request->post();
        }

        $db_connection_string = $this->_app->environment()["db_connection"];

        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = " SELECT * FROM `storages` WHERE `id` = " . $get['id'];
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $storage = [];
            $row = $result->fetch_assoc();
            array_push($storage, ["rawabi_code" => $row["rawabi_code"], "storage_number" => $row["storage_number"],
                "area" => $row["area"], "price" => $row["price"], "available" => $row["available"], "building" => $row["building"], "neighporhood" => $row["neighporhood"],
                "tabu_description" => $row["tabu_description"], "floor" => $row["floor"], "tabu_code" => $row["tabu_code"], "id" => $row["id"]
            ]);


            $query2 = " SELECT * FROM `storage_plans` WHERE `storage_id` =  " . $get['id'];
            $result2 = $conn->query($query2);
            if ($result2->num_rows > 0) {
                $imgArray = array();
                while ($row = $result2->fetch_assoc()) {
                    array_push($imgArray, ["id" => $row['id'], "filename" => $row['filename'], "filesize" => $row['filesize'], "filepath" => $row['filepath']]);
                }
                array_push($storage, $imgArray);
            }


            $storage = json_decode(json_encode($storage), true);
            echo json_encode($storage);
            return $storage;
        } else {
            return [];
        }
    }


    function getParkingInfo()
    {

        if ($this->_app->request->isGet()) {
            $get = $this->_app->request->get();
        } else {
            $get = $this->_app->request->post();

        }

        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = " SELECT * FROM `parking` WHERE `id` = " . $get['id'];
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $parking = [];
            $row = $result->fetch_assoc();
            array_push($parking, ["rawabi_code" => $row["rawabi_code"], "parking_number" => $row["parking_number"], "neighporhood" => $row["neighporhood"],
                "price" => $row["price"], "available" => $row["available"], "building" => $row["building"],
                "description" => $row["description"], "floor" => $row["floor"], "id" => $row["id"]
            ]);


            $query2 = " SELECT * FROM `parking_plans` WHERE `parking_id` =  " . $get['id'];
            $result2 = $conn->query($query2);
            if ($result2->num_rows > 0) {
                $imgArray = array();
                while ($row = $result2->fetch_assoc()) {
                    array_push($imgArray, ["id" => $row['id'], "filename" => $row['filename'], "filesize" => $row['filesize'], "filepath" => $row['filepath']]);
                }
                array_push($parking, $imgArray);
            }


            $parking = json_decode(json_encode($parking), true);
            echo json_encode($parking);
            mysqli_close($conn);

            return $parking;
        } else {
            mysqli_close($conn);

            return "[]";
        }
    }

    function getReservationDate($uid, $type, $id)
    {
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `parking_storage_reservation` WHERE `uid` = " . $uid . " and `type` = '" . $type . "' and `parking_storage_id` = " . $id . ";";

        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["reservation_date"];
        } else {
            return "no reservation date";
        }
    }

    function Reserve()
    {
        $post = $this->_app->request->post();


        parking_storage_reservation::where('parking_storage_id', $post['id'])->where('type', $post['type'])->delete();


        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $currency = $post['currency_exchange_parking'] == 1 ? "$" : "Nis";

        $query = "INSERT INTO `parking_storage_reservation`( `uid`, `parking_storage_id`, `type`, `reservation_date`, `currency`, `exchange_rate`) VALUES (" . $post['uid'] . " , " . $post['id'] . " , '" . $post['type'] . "' , '" . date("Y/m/d") . "', '" . $currency . "', '" . $post['currency_exchange_parking'] . "')";
        $conn->query($query);

        if ($post['type'] == "parking") {
            $query2 = "UPDATE `parking` SET `available`='1' WHERE `id`= " . $post['id'];
        } else {
            $query2 = "UPDATE `storages` SET `available`='1' WHERE `id`= " . $post['id'];
        }

        $conn->query($query2);

    }

    function deletePlan()
    {
        $post = $this->_app->request->post();
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");


        if ($post['type'] == "storage") {
            $query = "DELETE FROM `storage_plans` WHERE `id` = " . $post['id'];

        } else {
            $query = "DELETE FROM `parking_plans` WHERE `id` = " . $post['id'];

        }

        $conn->query($query);
    }

    function DeleteReservation()
    {

        $post = $this->_app->request->post();

        parking_storage_reservation::where('parking_storage_id', $post['id'])->where('type', $post['type'])->delete();

        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");


        if ($post['type'] == "parking") {
            $query2 = "UPDATE `parking` SET `available`='0' WHERE `id`= " . $post['id'];
        } else {
            $query2 = "UPDATE `storages` SET `available`='0' WHERE `id`= " . $post['id'];
        }

        $conn->query($query2);


        ParkingStoragePayment::where('target', $post['type'])->where('target_id', $post['id'])->delete();

        $contract = Contract::where('unit_id', $post['uid'])->where('status', 'ACTIVE');
        if ($post['type'] == "parking") {
            $contract = $contract->where('type', 'Appendix/Parking');
        } else if ($post['type'] == "storage") {
            $contract = $contract->where('type', 'Appendix/Storage');
        }

        $contractRow = $contract->first();
        if($contractRow) {
            $contractRow->status = 'ARCHIVED';
            $contractRow->save();
        }


    }


    function getReservationInfo()
    {

        $post = $this->_app->request->get();

        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `parking_storage_reservation` WHERE `uid` = " . $post['unitId'] . " and `parking_storage_id` = " . $post['parkingStorageId'] . ";";

        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $reservationInfo = [];
            $row = $result->fetch_assoc();
            array_push($reservationInfo,
                [
                    "reservation_date" => $row["reservation_date"],
                    "currency" => $row["currency"],
                    "exchange_rate" => $row["exchange_rate"],
                ]);


            $reservationInfo = json_decode(json_encode($reservationInfo), true);
            echo json_encode($reservationInfo);
        } else {
            echo "[]";
        }
    }


    function getReservationInfoByUnitId()
    {
        $post = $this->_app->request->get();

        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `parking_storage_reservation` WHERE `uid` = " . $post['unitId'] . " ;";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $reservationInfo = [];
            while ($row = $result->fetch_assoc()) {
                array_push($reservationInfo,
                    ["reservation_date" => $row["reservation_date"], "parking_storage_id" => $row["parking_storage_id"], "type" => $row["type"]
                    ]);
            }

            $reservationInfo = json_decode(json_encode($reservationInfo), true);
            echo json_encode($reservationInfo);
        } else {
            echo "";
        }
    }

    function purchaseUnit()
    {

        $post = $this->_app->request->post();
        $unitID = $post['unitId'];
        $unit = Unit::find($unitID);
        $unit->available = 3;
        $unit->save();

        return $unit;
    }

    function addCashReceipt()
    {

        $post = $this->_app->request->post();

        $cash_receipt = new CashReceipt([
            "unit_id" => $post['unit_id'],
            "receiptDate" => $post['receiptDate'],
            "signature" => $post['signature'],
            "note" => $post['note'],
            "additional_note" => $post['additional_note'],
            "related_to" => $post['related_cash_select'] != 0 ? $post['related_cash_select'] : NULL,
            "user_id" => $_SESSION['userfrosting']['user_id'],
            "customer_name" => $post['customer_name'],
            "region" => $post['region'],
            "phone_number" => $post['phone_number'],
            "email_address" => $post['email_address'],
            "customer_id" => $post['customer_id'],
        ]);
        $cash_receipt->save();

        $cash_receipt_id = $cash_receipt->id;

        $prices = json_decode($post['prices'], true);
        foreach ($prices as $price) {
            $dbObject [] = [
                'units_cash_receipts_id' => $cash_receipt_id,
                'description' => $price['description'],
                'payment_way' => $price['payment_way'],
                'total' => $price['total'],
                'currency' => $price['currency'],
            ];
        }

        CashReceiptPricing::insert($dbObject);

        $this->insertFiles($post, $cash_receipt_id);

        $emailController = new EmailTemplateController($this->_app);
        $configController = new ConfigurationController($this->_app);

        $emailTemplateParams = $emailController->getReservationEmailInfo($post['unit_id']);

        if ($emailTemplateParams == "0" || $emailTemplateParams == 0) {
            return "There is no reservation for this unit";
        }

        $unit = Unit::find($post['unit_id']);
        $emailList = $configController->getCashReceiptEmailList();
        $emailTemplateParams['reservedUnit']['user_did_action'] = User::find($_SESSION['userfrosting']['user_id'])->display_name;

        $emailController->notifyingEmail($emailTemplateParams['reservedUnit'], $unit, $emailTemplateParams['user'], 'Cash Receipt Email', $emailList);


       // return true;
    }

    public function insertFiles($post, $cash_receipt_id)
    {

        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (isset($_FILES['images']['name'])) {
            $photoCount = count($_FILES['images']['name']);


            if ($photoCount > 0) {

                for ($i = 0; $i < $photoCount; $i++) {
                    // Getting name of each file
                    $fileName = time() . '-' . $i;
                    $fileSplited = explode('.', $_FILES['images']['name'][$i]);
                    $fileExt = $fileSplited[count($fileSplited) - 1];


                    $tempName = $_FILES['images']['tmp_name'][$i];


                    $uploadPath = "uploads/" . $fileName . "." . $fileExt;

                    move_uploaded_file($tempName, $uploadPath);

                    $file = new CashReceiptFiles();
                    $file->units_cash_receipts_id = $cash_receipt_id;
                    $file->file_name = $fileName ;
                    $file->upload_path = $uploadPath;
                    $file->save();

                }
            }
        }

    }

    public function move()
    {
        $post = $this->_app->request->get();

        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "select cash.id, r.customer_name, r.region, r.phone_number, r.email_address, r.customer_id from units_cash_receipts cash left join uf_reservation_unit r_u on cash.unit_id = r_u.unit_id
inner join uf_reservation r on r_u.reservation_id = r.id";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cash = CashReceipt::where('id', $row['id'])->first();
                $cash->customer_name = $row['customer_name'];
                $cash->region = $row['region'];
                $cash->phone_number = $row['phone_number'];
                $cash->email_address = $row['email_address'];
                $cash->customer_id = $row['customer_id'];
                $cash->save();
            }

        }


    }

}
