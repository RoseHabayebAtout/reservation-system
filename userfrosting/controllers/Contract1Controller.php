<?php

namespace UserFrosting;


use Carbon\Carbon;
use Cassandra\Date;
use DateTime;
use DOMDocument;
use DOMXPath;
use I18N_Arabic;
use Illuminate\Support\Str;
use Slim\Http\Response;
use UserFrosting\Contract;

require('I18N/Arabic.php');

class Contract1Controller extends \UserFrosting\BaseController
{

    protected static $_table_id = "contract1";
    public static $Arabic;
    public $reservationEditable = [
        'customer_name',
//        'customer_type_of_id',
        'customer_id',
        'issued_by',
        'customer_address',
        'phone_number',
        'mobile',
        'country',
        'city',
        'region',
        'street',
        'mailbox',
        'postalcode',
        'workphone',
        'email_address',
        'unitDescription',
        'tabo_area',


    ];


    public $arabicNumberInWordForPayment = [
        '',
        'الأولى',
        'الثانية',
        'الثالثة',
        'الرابعة',
        'الخامسة',
        'السادسة',
        'السابعة',
        'الثامنة',
        'التاسعة',
        'العاشرة',
        'الحادية عشر',
        'الثانية عشر',
        'الثالثة عشر',
        'الرابعة عشر',
        'الخامسة عشر',
        'السادسة عشر',
        'السابعة عشر',
        'الثامنة عشر',
        'التاسمعة عشر',
        'العشرون',
        'واحد و العشرون',
        'اثنان و العشرون',
        'ثلاث و العشرون',
        'رابعة و العشرون',
        'خمسة و العشرون',
        'ستة و العشرون',
        'سبعة و العشرون',
        'ثمانة و العشرون',
        'تسعة و العشرون',
        'ثلاثون',
        'واحد و ثلاثون',
        'اثنان و ثلاثون',
        'ثلاث و ثلاثون',
        'رابعة و ثلاثون',
        'خمسة و ثلاثون',
        'ستة و ثلاثون',
        'سبعة و ثلاثون',
        'ثمانة و ثلاثون',
        'تسعة و ثلاثون',
        'أربعون',
        'واحد و أربعون',
        'اثنان و أربعون',
        'ثلاث و أربعون',
        'رابعة و أربعون',
        'خمسة و أربعون',
        'ستة و أربعون',
        'سبعة و أربعون',
        'ثمانة و أربعون',
        'تسعة و أربعون',
        'خمسون',
        'واحد و خمسون',
        'اثنان و خمسون',
        'ثلاث و خمسون',
        'رابعة و خمسون',
        'خمسة و خمسون',
        'ستة و خمسون',
        'سبعة و خمسون',
        'ثمانة و خمسون',
        'تسعة و خمسون',
        'ستون',
        'واحد و ستون',
        'اثنان و ستون',
        'ثلاث و ستون',
        'رابعة و ستون',
        'خمسة و ستون',
        'ستة و ستون',
        'سبعة و ستون',
        'ثمانة و ستون',
        'تسعة و ستون',
        'سبعون',
        'واحد و سبعون',
        'اثنان و سبعون',
        'ثلاث و سبعون',
        'رابعة و سبعون',
        'خمسة و سبعون',
        'ستة و سبعون',
        'سبعة و سبعون',
        'ثمانة و سبعون',
        'تسعة و سبعون',
        'ثمانون',
        'واحد و ثمانون',
        'اثنان و ثمانون',
        'ثلاث و ثمانون',
        'رابعة و ثمانون',
        'خمسة و ثمانون',
        'ستة و ثمانون',
        'سبعة و ثمانون',
        'ثمانة و ثمانون',
        'تسعة و ثمانون',
        'تسعون',
        'واحد و تسعون',
        'اثنان و تسعون',
        'ثلاث و تسعون',
        'رابعة و تسعون',
        'خمسة و تسعون',
        'ستة و تسعون',
        'سبعة و تسعون',
        'ثمانة و تسعون',
        'تسعة و تسعون',
        'مئة',
    ];

    /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app)
    {
        $this->_app = $app;
    }

    public function createContract1()
    {
        // Fetch the POSTed data
        $post = $this->_app->request->post();

        /*if ($post['isGet']) {
            echo 'Heya';
            return;
        }*/

        $new_contract1 = new Contract1([

            "contractDate" => $post['contractDate'],
            "companyNum" => $post['companyNum'],
            "systemUser" => $post['systemUser'],
            "purchaser1" => $post['purchaser1'],
            "idNum1" => $post['idNum1'],
            "idType1" => $post['idType1'],
            "idPlace1" => $post['idPlace1'] . ' ',
            "idProDate1" => $post['idProDate1'],
            "idExpDate1" => $post['idExpDate1'],
            "regNo1" => $post['regNo1'],
            "registered1" => $post['registered1'],
            "country1" => $post['country1'],
            "city1" => $post['city1'],
            "regionName1" => $post['regionName1'],
            "streetName1" => $post['streetName1'],
            "homePhone1" => $post['homePhone1'],
            "workPhone1" => $post['workPhone1'],
            "mobileNum1" => $post['mobileNum1'],
            "faxNum1" => $post['faxNum1'],
            "mailBox1" => $post['mailBox1'],
            "postalCode1" => $post['postalCode1'],
            "eMail1" => $post['eMail1'],
            "purchaser2" => $post['purchaser2'],
            "idNum2" => $post['idNum2'],
            "idType2" => $post['idType2'],
            "idPlace2" => $post['idPlace2'] . ' ',
            "idProDate2" => $post['idProDate2'],
            "idExpDate2" => $post['idExpDate2'],
            "regNo2" => $post['regNo2'],
            "registered2" => $post['registered2'],
            "country2" => $post['country2'],
            "city2" => $post['city2'],
            "regionName2" => $post['regionName2'],
            "streetName2" => $post['streetName2'],
            "homePhone2" => $post['homePhone2'],
            "workPhone2" => $post['workPhone2'],
            "mobileNum2" => $post['mobileNum2'],
            "faxNum2" => $post['faxNum2'],
            "mailBox2" => $post['mailBox2'],
            "postalCode2" => $post['postalCode2'],
            "eMail2" => $post['eMail2'],
            "unitNum" => $post['unitNum'],
            "unitArea" => $post['unitArea'],
            "haiName" => $post['haiName'],
            "floorNum" => $post['floorNum'],
            "landNum" => $post['landNum'],
            "hawdNum" => $post['hawdNum'],
            "hawdName" => $post['hawdName'],
            "buildingNum" => $post['buildingNum'],
            "buildingsNum" => $post['buildingsNum'],
            "unitDesc" => $post['unitDesc'],
            "damageFine" => $post['damageFine'],
            "releaseDate" => $post['releaseDate'],
            "priceTotal" => $post['priceTotal'],
            "pricePart1" => $post['pricePart1'],
            "pricePart2" => $post['pricePart2'],
            "pricePart3" => $post['pricePart3'],
            "delayPeriod" => $post['delayPeriod'],
            "penaltyClause" => $post['penaltyClause'],
            "companyName" => $post['companyName'],
            "companyFor" => $post['companyFor'],
            "haiArea" => $post['haiArea'],
            "checksNum" => $post['checksNum'],
            "arabon" => $post['arabon'],
            "remainingAmountDelay" => $post['remainingAmountDelay'],
            "penefitCompensation" => $post['penefitCompensation'],
            "addPart6" => $post['addPart6'],
            "addPartB" => $post['addPartB'],
            "ownersUnionNum" => $post['ownersUnionNum'],
            "ownersUnionProDate" => $post['ownersUnionProDate'],
            "addSafqa" => $post['addSafqa'],
            "annexes" => $post['annexes'],
            "safqaDate" => $post['safqaDate'],
            "companyNum_reg" => $post['companyNum_reg']
        ]);

        $new_contract1->save();
        //create many to many table with contract1_unit
        $unit = Unit::find($post['uid']);
        echo $post['uid'];
        $new_contract1->units()->attach($unit->id);
    }

    public function getAllContracts()
    {
        echo 'got all of them';
    }

    public function getContract1($id)
    {

        $unit = Unit::find($id);
        $contract1_id = $unit->contracts1($id)[0]['contract1_id'];
        $contract1 = Contract1::find($contract1_id);
        $haiName = $contract1['haiName'];
        $Neighborhood = Neighborhoods::where('haiArabicName', $haiName)->first();
        $contract1['estContrNum'] = $Neighborhood['estContrNum'];
        $contract1['estContrNum2'] = $Neighborhood['estContrNum2'];
        $contract1['estContrDate'] = $Neighborhood['estContrDate'];
        $contract1['estContrDate2'] = $Neighborhood['estContrDate2'];

        return $contract1;

    }

    public function updateContract1()
    {
        $post = $this->_app->request->post();
        // Fetch UNIT id to modify it in specific manner
        // print_r($post);
        // exit();
        // $contract1_id=$post['uid'];
        // $contract1=Contract1::find($contract1_id);
        // $contract1['purchaser1'] =$post['purchaser1'];
        // $contract1['idType1'] =$post['idType1'];
        // $contract1['idNum1'] =$post['idNum1'];
        // $contract1['idPlace1'] =$post['idPlace1'];
        // $contract1['idProDate1'] =$post['idProDate1'];
        // $contract1['idExpDate1']=$post['idExpDate1'];
        // $contract1['regNo1'] =$post['regNo1'];
        // $contract1['registered1'] =$post['registered1'];
        // $contract1['country1'] =$post['country1'];
        // $contract1['city1'] =$post['city1'];
        // $contract1['regionName1'] =$post['regionName1'];
        // $contract1['streetName1'] =$post['streetName1'];
        // $contract1['homePhone1'] =$post['homePhone1'];
        // $contract1['workPhone1'] =$post['workPhone1'];
        // $contract1['mobileNum1'] =$post['mobileNum1'];
        // $contract1['faxNum1'] =$post['faxNum1'];
        // $contract1['mailBox1'] =$post['mailBox1'];
        // $contract1['postalCode1'] =$post['postalCode1'];
        // $contract1['eMail1'] =$post['eMail1'];
        // $contract1['purchaser2'] =$post['purchaser2'];
        // $contract1['idType2'] =$post['idType2'];
        // $contract1['idNum2'] =$post['idNum2'];
        // $contract1['idPlace2'] =$post['idPlace2'];
        // $contract1['idProDate2'] =$post['idProDate2'];
        // $contract1['idExpDate2'] =$post['idExpDate2'];
        // $contract1['regNo2'] =$post['regNo2'];
        // $contract1['registered2'] =$post['registered2'];
        // $contract1['country2'] =$post['country2'];
        // $contract1['city2'] =$post['city2'];
        // $contract1['regionName2'] =$post['regionName2'];
        // $contract1['streetName2'] =$post['streetName2'];
        // $contract1['homePhone2'] =$post['homePhone2'];
        // $contract1['workPhone2'] =$post['workPhone2'];
        // $contract1['mobileNum2'] =$post['mobileNum2'];
        // $contract1['faxNum2'] =$post['faxNum2'];
        // $contract1['mailBox2'] =$post['mailBox2'];
        // $contract1['postalCode2'] =$post['postalCode2'];
        // $contract1['eMail2'] =$post['eMail2'];
        // $contract1['damageFine']=$post['damageFine'];
        // $contract1['releaseDate'] =$post['releaseDate'];
        // $contract1['delayPeriod'] =$post['delayPeriod'];
        // $contract1['penaltyClause'] =$post['penaltyClause'];
        // $contract1['companyName'] =$post['companyName'];
        // $contract1['companyFor'] =$post['companyFor'];
        // $contract1['arabon'] =$post['arabon'];
        // $contract1['remainingAmountDelay'] =$post['remainingAmountDelay'];

        // $contract1['companyNum'] =$post['companyNum'];
        // $contract1['checksNum'] =$post['checksNum'];
        // $contract1['addSafqa'] =$post['addSafqa'];

        $contract3_id = $post['uid'];
        $contract1 = Contract1::find($contract3_id);
        unset($post['csrf_token']);
        unset($post['uid']);
        foreach ($post as $key => $value) {
            $contract1[$key] = $post[$key];
        }
        $contract1->save();

        $contract1->save();

    }


    public function checkneighborhood($neigborhood)
    {
        $post = $this->_app->request->post();

        $neigborhood_table = Neighborhoods::where('haiEnglishName', $neigborhood)->first();
        if ($neigborhood_table->estContrNum2 == "" || $neigborhood_table->estContrNum2 == null) {
            return 0;
        }
        return 1;

    }


    public function getcontract1Template()
    {
        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully" . '<br/>';

        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contract1_content`";
        $result = $conn->query($query);


        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->_app->render('contract/contract1.twig', [
                "contractsections" => $row
            ]);

        } else {
            echo "0 results";
        }


    }

    public function getcontenthtml()
    {
        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully" . '<br/>';

        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contract1_content`";
        $result = $conn->query($query);


        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;


        } else {
            echo "0 results";
        }
    }


    public function updateContract1Content()
    {
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

        $query = "UPDATE `contract1_content` SET `" . $id . "`='" . $content . "'";
        echo $query;
        if ($conn->query($query) === TRUE) {
            echo "Updated Successfully";
        } else {
            echo "Something went error";

        }

    }

    public function printContract1()
    {
        header("Location: ../test.php");
    }

//    public function getPaymentsForContract1(){
//
//
//        $data = Unit::with('payments', 'reservationsRel', 'contract')->where('available', 3)->get();
//
//        $dataFiltered = $data->map(function ($item) {
//
//            return [
//                "customer_name" => $item["reservationsRel"][0]['customer_name'] ?? '',
//                "company_code" => $item["rawabi_code"]?? '',
//                "neighborhood" => $item["neighborhood"]?? '',
//                "tapu_code" =>  $item["tapu_code"]?? '',
//                "date_of_signed" => $item["contract"]["created_at"] ?? '',
//                "priceTotal" => $item["reservationsRel"][0]['total_price'] ?? '',
//                "paid_amount" => '',
//                "last_payment_date" => '',
//                "first_payment_date" => '',
//                "arabon" => '',
//                "payments" => $item["payments"] ?? [],
//                "uid" => $item["id"],
//                "contract_type" => $item["contract"]["templateName"] ?? [],
//            ];
//        });
//
//
//        $dataFiltered = $dataFiltered->map( function ($item) {
//            $payments = $item['payments'];
//            $currentYear = new \DateTime(date("Y")."-01-01");
//            $currentYearFormatted = $currentYear->format("Y-m-d");
//            $sum = 0;
//
//            $lastPaymentDate = (new \DateTime("1970-01-01"))->format("Y-m-d");
//            $lastPaymentAmount = 0;
//            $firstPaymentDate = (new \DateTime(date("Y-m-d")))->format("Y-m-d");
//            $firstPaymentAmount = 0;
//
//            $currentDate = (new \DateTime(date("Y-m-d")))->format("Y-m-d");
//            $paidAmount = 0;
//
//            foreach ($payments as $payment) {
//                if (strtotime($payment['payment_date']) < strtotime($currentYearFormatted)) {
//                    $sum =  $sum + (float)$payment['amount'];
//                }
//
//                if (strtotime($lastPaymentDate) < strtotime($payment['payment_date'])) {
//                    $lastPaymentDate = $payment['payment_date'];
//                    $lastPaymentAmount = $payment['amount'];
//                }
//
//                if (strtotime($firstPaymentDate) > strtotime($payment['payment_date'])) {
//                    $firstPaymentDate = $payment['payment_date'];
//                    $firstPaymentAmount = $payment['amount'];
//                }
//
//                if (strtotime($currentDate) > strtotime($payment['payment_date'])) {
//                    $paidAmount = $paidAmount + (float)$payment['amount'];
//                }
//            }
//
//            $item['paid_amount'] =  $paidAmount;
//            $item['first_payment_date'] =  $firstPaymentDate;
//            $item['first_payment_amount'] =  $firstPaymentAmount;
//            $item['last_payment_date'] =  $lastPaymentDate;
//            $item['last_payment_amount'] =  $lastPaymentAmount;
//            $item['paymentsBeforeCurrentYear'] =  $sum;
//            return $item;
//        });
//
//
//        $result = json_decode(json_encode($dataFiltered), true);
//        echo json_encode($result);
//
//
//
//
//    }

    public function getPaymentsReport()
    {

        $get = $this->_app->request->get();


        if ($get['type'] == "parking") {
            $data = parking_storage_reservation::with('unit', 'payments', 'parking')->where('type', $get['type'])->get();
        } else if ($get['type'] == "storage") {
            $data = parking_storage_reservation::with('unit', 'payments', 'storage')->where('type', $get['type'])->get();
        } else if ($get['type'] == "contract") {
            $data = Unit::with('payments', 'reservationsRel', 'contract', 'contract1', 'contract2')->where('available', 3)->get();
        } else {
            return [];
        }


        if ($get['type'] == "contract") {
            $dataFiltered = $data->map(function ($item) {
                if($item['contract_type'] == 1){
                    $contractName = 'اتفاقية بيع وشراء وحدة سكنية';
                    $priceTotal = $item['contract1'][0]['priceTotal'] ?? $item["reservationsRel"][0]['total_price'] ?? '';

                    if (isset($item['contract']['json'])) {
                        $json_decoded = json_decode($item['contract']['json'], true);

                        if (json_last_error() === JSON_ERROR_NONE) {
                            $customerName = $json_decoded['customer_name'] ?? $json_decoded['_name'] ?? $item['contract1'][0]['purchaser1'] ??  $item["reservationsRel"][0]['customer_name'] ?? '';
                        }
                    } else {
                        $customerName = $item['contract1'][0]['purchaser1'] ??  $item["reservationsRel"][0]['customer_name'] ?? '';
                    }

                } else if($item['contract_type'] == 2) {
                    $contractName = 'عقد إيجار منتهي بالتملك';
                    $priceTotal = $item['contract2'][0]['r_totalPrice'] ?? $item["reservationsRel"][0]['total_price'] ?? '';

                    if (isset($item['contract']['json'])) {
                        $json_decoded = json_decode($item['contract']['json'], true);

                        if (json_last_error() === JSON_ERROR_NONE) {
                            $customerName = $json_decoded['customer_name'] ?? $json_decoded['_name'] ?? $item['contract2'][0]['renter1'] ??  $item["reservationsRel"][0]['customer_name'] ?? '';
                        }
                    } else {
                        $customerName = $item['contract2'][0]['renter1'] ??  $item["reservationsRel"][0]['customer_name'] ?? '';
                    }
                } else {
                    $priceTotal = $item["reservationsRel"][0]['total_price'] ?? '';
                    if (isset($item['contract']['json'])) {
                        $json_decoded = json_decode($item['contract']['json'], true);

                        if (json_last_error() === JSON_ERROR_NONE) {
                            $customerName = $json_decoded['customer_name'] ?? $json_decoded['_name'] ?? $item['contract1'][0]['purchaser1'] ??  $item["reservationsRel"][0]['customer_name'] ?? '';
                        }
                    } else {
                        $customerName = $item['contract1'][0]['purchaser1'] ??  $item["reservationsRel"][0]['customer_name'] ?? '';
                    }
                }

                if (isset($item['contract']['json'])) {
                    $json_decoded = json_decode($item['contract']['json'], true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        if (isset($json_decoded['_contractDate']) && strtotime($json_decoded['_contractDate']) !== false) {
                            $date_of_signed = new DateTime($json_decoded['_contractDate'], new \DateTimeZone('Asia/Jerusalem'));
                        } else if (isset($item["contract"]["created_at"])) {
                            $date_of_signed = $item["contract"]["created_at"];
                        } else {
                            $date_of_signed = ''; // Handle the case when neither key exists
                        }
                    }
                } else {
                    if (isset($item["contract"]["created_at"])) {
                        $date_of_signed = $item["contract"]["created_at"];
                    } else {
                        $date_of_signed = ''; // Handle the case when neither key exists
                    }
                }


                return [
                    "customer_name" => $customerName,
                    "company_code" => $item["neighborhood"] . ' ' . $item["rawabi_code"] ?? '',
                    "neighborhood" => $item["neighborhood"] ?? '',
                    "tapu_code" => $item["tapu_code"] ?? '',
                    "date_of_signed" => $date_of_signed,
                    "priceTotal" => $priceTotal,
                    "paid_amount" => '',
                    "last_payment_date" => '',
                    "first_payment_date" => '',
                    "arabon" => '',
                    "payments" => $item["payments"] ?? [],
                    "uid" => $item["id"],
                    "contract_type" => $contractName ?? $item["contract"]["templateName"],
                ];
            });
        } else {
            $dataFiltered = $data->map(function ($item) use ($get) {
                $price = '-';
                if (isset($item["storage"]['price']) && is_numeric($item["storage"]['price'])) {
                    $price = $item["storage"]['price'] * $item['exchange_rate'];
                } else if (isset($item["parking"]['price']) && is_numeric($item["parking"]['price'])) {
                    $price = $item["parking"]['price'] * $item['exchange_rate'];
                }


                return [
                    "customer_name" => $item['unit']["reservationsRel"][0]['customer_name'] ?? '',
                    "company_code" => $item['unit']["rawabi_code"] ?? '',
                    "neighborhood" => $item['unit']["neighborhood"] ?? '',
                    "tapu_code" => $item['unit']["tapu_code"] ?? '',
                    "date_of_signed" => $item["reservation_date"] ?? '',
                    "priceTotal" => $price,
                    "paid_amount" => '',
                    "last_payment_date" => '',
                    "first_payment_date" => '',
                    "arabon" => '',
                    "payments" => $item["payments"] ?? [],
                    "uid" => 1111,
                    "contract_type" => $get['type'] . ' ' . $this->getParkingStorageCode($item),
                ];
            });
        }


        $dataFiltered = $dataFiltered->map(function ($item) {
            $payments = $item['payments'];
            $currentYear = new \DateTime(date("Y") . "-01-01");
            $currentYearFormatted = $currentYear->format("Y-m-d");
            $sum = 0;

            $lastPaymentDate = (new \DateTime("1970-01-01"))->format("Y-m-d");
            $lastPaymentAmount = 0;
            $firstPaymentDate = (new \DateTime(date("Y-m-d")))->format("Y-m-d");
            $firstPaymentAmount = 0;

            $currentDate = (new \DateTime(date("Y-m-d")))->format("Y-m-d");
            $paidAmount = 0;

            foreach ($payments as $index => $payment) {
//                if ($index > 0 && (strtotime($payment['payment_date']) < strtotime($currentYearFormatted))) {
                if ((strtotime($payment['payment_date']) < strtotime($currentYearFormatted))) {
                    $sum = $sum + (float)$payment['amount'];
                }

                if (strtotime($lastPaymentDate) < strtotime($payment['payment_date'])) {
                    $lastPaymentDate = $payment['payment_date'];
                    $lastPaymentAmount = $payment['amount'];
                }

                if (strtotime($firstPaymentDate) > strtotime($payment['payment_date'])) {
                    $firstPaymentDate = $payment['payment_date'];
                    $firstPaymentAmount = $payment['amount'];
                }

                if (strtotime($currentDate) > strtotime($payment['payment_date'])) {
                    $paidAmount = $paidAmount + (float)$payment['amount'];
                }
            }

//            $item['paid_amount'] =  $paidAmount;
            $item['paid_amount'] = '';
            $item['first_payment_date'] = $firstPaymentDate;
            $item['first_payment_amount'] = $firstPaymentAmount;
            $item['last_payment_date'] = $lastPaymentDate;
            $item['last_payment_amount'] = $lastPaymentAmount;
            $item['paymentsBeforeCurrentYear'] = $sum;
            return $item;
        });


        $result = json_decode(json_encode($dataFiltered), true);
        echo json_encode($result);


    }

    public function getContract1Attributes()
    {
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contract_attributes` where `type` = 'purchase_contract'";

        $result = mysqli_query($conn, $query);

        if ($result->num_rows > 0) {

            $columns = [];
            while ($row = $result->fetch_assoc()) {
                array_push($columns,
                    [
                        "name" => $row["name"],
                        "represent_name" => $row["represent_name"]
                    ]
                );
            }

            return $columns;
        }
    }

    public function getAttributes()
    {
        $get = $this->_app->request->get();
        $contract_type = $get['contract_type'];
        $arr = "'" . implode("', '", $contract_type) . "'";

        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contract_attributes` where `type` in (" . $arr . ")";
        $result = mysqli_query($conn, $query);

        if ($result && $result->num_rows > 0) {

            $columns = [];
            while ($row = $result->fetch_assoc()) {
                array_push($columns,
                    [
                        "name" => $row["name"],
                        "represent_name" => $row["represent_name"],
                        "data_type" => $row["data_type"]
                    ]
                );
            }
            echo json_encode(json_decode(json_encode($columns), true));
        } else {
            echo json_encode([]);
        }
    }

    public function createContractTemplate()
    {
        $post = $this->_app->request->post();

        $header = $post['header'];
        $content = $post['content'];
        $footer = $post['footer'];
        $templateName = $post['templateName'];


        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }


        $contractUpdateNotInsert = [
            'Appendix/Storage',
            'Appendix/Parking',
            'Reservation Receipt',
        ];
        mysqli_set_charset($conn, "utf8");

        if (in_array($templateName, $contractUpdateNotInsert)) {
            $queryId = "SELECT * FROM `contracts_templates` WHERE `templateName` ='" . $templateName . "'";
            $exist = $conn->query($queryId);
            if ($exist && $exist->num_rows > 0) {
                $query = "UPDATE `contracts_templates` SET `content`='" . $content . "',`user_id`= '" . $_SESSION['userfrosting']['user_id'] . "', `header` = '" . $header . "', `footer` = '" . $footer . "' WHERE `templateName` = '" . $templateName . "'";
            } else {
                $query = "INSERT INTO `contracts_templates`( `content`,`templateName`, `user_id`, `status`, `created_at`, `header`, `footer`) VALUES ('" . $content . "', '" . $templateName . "', '" . $_SESSION['userfrosting']['user_id'] . "', '" . 'ACTIVE' . "', '" . date("Y/m/d h:i:s") . "', '" . $header . "', '" . $footer . "')";
            }


            if ($conn->query($query) === TRUE) {
                echo "created Successfully";
            } else {
                echo "Something went error";
            }
        } else {


            if (isset($_FILES["cover"])) {

                $name = $_FILES["cover"]["name"];
                $location = 'uploads/' . $name;
                move_uploaded_file($_FILES["cover"]["tmp_name"], $location);


                $query = "INSERT INTO `contracts_templates`( `content`,`templateName`, `user_id`, `status`, `created_at`, `header`, `footer`, `cover`) VALUES ('" . $content . "', '" . $templateName . "', '" . $_SESSION['userfrosting']['user_id'] . "', '" . 'ACTIVE' . "', '" . date("Y/m/d h:i:s") . "', '" . $header . "', '" . $footer . "', '" . $_POST['coverName'] . "')";

            } else {
                $query = "INSERT INTO `contracts_templates`( `content`,`templateName`, `user_id`, `status`, `created_at`, `header`, `footer`) VALUES ('" . $content . "', '" . $templateName . "', '" . $_SESSION['userfrosting']['user_id'] . "', '" . 'ACTIVE' . "', '" . date("Y/m/d h:i:s") . "', '" . $header . "', '" . $footer . "')";
            }


            if ($conn->query($query) === TRUE) {
                echo $conn->insert_id;

            } else {
                echo "Something went error";
            }
        }
    }

    public function getcontractTemplates()
    {
        $create = isset($this->_app->request->get()['create']) ? $this->_app->request->get()['create'] : false;
        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $contractUpdateNotInsert = [
            'Appendix/Storage',
            'Appendix/Parking',
            'Reservation Receipt',
        ];
        if ($create) {
            $arr = "'" . implode("', '", []) . "'";
        } else {
            $arr = "'" . implode("', '", $contractUpdateNotInsert) . "'";
        }

        mysqli_set_charset($conn, "utf8");

        $query = "select contracts_templates.*,uf_user.user_name  from contracts_templates left join uf_user on contracts_templates.user_id = uf_user.id WHERE status = 'ACTIVE' and templateName not in (" . $arr . ")";
        $result = mysqli_query($conn, $query);

        if ($result->num_rows > 0) {

            $templates = [];
            while ($row = $result->fetch_assoc()) {
                array_push($templates,
                    [
                        "id" => $row["id"],
                        "user_id" => $row["user_id"],
                        "status" => $row["status"],
                        "created_at" => $row["created_at"],
                        "templateName" => $row["templateName"],
                        "user_name" => $row["user_name"],
                        "content" => $row["content"],
                        "header" => $row["header"],
                        "footer" => $row["footer"],
                    ]
                );
            }
            $result = json_decode(json_encode($templates), true);
            echo json_encode($result);
        } else {
            echo json_encode([]);
        }
    }

    public function ChangeStatusTemplate($id)
    {

        $get = $this->_app->request->get();

        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($conn, "utf8");

        $query = "UPDATE `contracts_templates` SET `status`= '" . $get['status'] . "' WHERE id = " . $id;
        if ($conn->query($query) === TRUE) {
            echo "Status Changed";
        } else {
            echo "Something went error";
        }


        $contractTemplate = ContractTemplate::where('id', $id)->first();
        $cover = null;
        if ($contractTemplate) {
            $cover = $contractTemplate->cover;

            $newContractTemplate = ContractTemplate::where('templateName', $contractTemplate->templateName)
                ->where('status', 'ACTIVE')
                ->first();
            if ($newContractTemplate) {
                $newContractTemplate->cover = $cover;
                $newContractTemplate->save();
            }
        }

    }

    public function archiveContract($id, $type)
    {

        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($conn, "utf8");

        $query = "UPDATE `contracts` SET `status`= 'ARCHIVED' WHERE unit_id = " . $id . " and `type` = '" . $type . "'";
        if ($conn->query($query) === TRUE) {
            echo "Status Changed";
        } else {
            echo "Something went error";

        }
    }

    public function getTemplate($id)
    {
        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contracts_templates` WHERE id = " . $id;
        $result = mysqli_query($conn, $query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data['id'] = $row['id'];
            $data['content'] = $row['content'];
            $data['status'] = $row['status'];
            $data['created_at'] = $row['created_at'];
            $data['templateName'] = $row['templateName'];
            $data['header'] = $row['header'];
            $data['footer'] = $row['footer'];

            $columns = $this->getContract1Attributes();

            $this->_app->render('unit/contractTemplate/updateContractTemplate.twig', [
                'data' => $data,
                'columns' => $columns,
            ]);
        } else {
            $this->_app->render('unit/contractTemplate/updateContractTemplate.twig', []);
        }
    }

    public function getTemplateAPI($id)
    {
        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contracts_templates` WHERE id = " . $id;
        $result = mysqli_query($conn, $query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data['id'] = $row['id'];
            $data['content'] = $row['content'];
            $data['status'] = $row['status'];
            $data['created_at'] = $row['created_at'];
            $data['templateName'] = $row['templateName'];
            $data['header'] = $row['header'];
            $data['footer'] = $row['footer'];
            $data['cover'] = $row['cover'];

            return $data;
        } else {
            return [];
        }
    }

    public function listContractActiveTemplates()
    {
        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * from `contracts_templates` ct";

        $arr = array();

        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($arr,
                    array(
                        "name" => $row["id"],
                        "value" => $row["id"]// $row["status"]
                    ));
            }

            return $arr;
        } else {
            echo "0 results";
        }
    }

    public function renderContractTemplate($templateId, $unitID, $include_payment = false)
    {

        if (Contract1Controller::$Arabic == null) {
            Contract1Controller::$Arabic = new I18N_Arabic("Numbers");
        }

        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * from `contracts_templates` ct where ct.id = " . $templateId . "";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $contents = $row["content"];
        }

        // add payment contract
        if ($include_payment == "true") {

            $query2 = "SELECT * from `contracts_templates` ct where ct.templateName = 'Appendix/Payment' order by ct.id desc";

            $result2 = $conn->query($query2);
            if ($result2->num_rows > 0) {
                $row = $result2->fetch_assoc();
                $contents = $contents . $row["content"];
            }
        }


        $contract = Contract::Where('template_id', $templateId)->where('unit_id', $unitID)->where('status', 'ACTIVE')->first();


        if ($contract !== null) {


            $contents = $contract->content;


            $pattern = '/<a id=\"(\d+)_div_+(type_date|type_text|type_number)\" .*?>.*?<\/a>/';
            //  $pattern = '/<span class=\"attrr\" ?.*>(.*)<\/span>/';
            if (preg_match_all($pattern, $contents, $output_array)) {
                for ($x = 0; $x <= sizeof($output_array[0]) - 1; $x++) {
                    $output_array[0][$x] = $this->filteration($output_array[0][$x]);
                    $value = $this->getTextOfHtml($output_array[0][$x]);

                    $id = $x . '_div_type_text';

                    $attributes = $this->parseTag($output_array[0][$x], 'a');

                    $attributeName = $attributes['name'];


                    $exploded = explode('_', $attributeName);
                    $attributeNameFiltered = "";
                    for ($a = 1; $a < count($exploded); $a++) {
                        $attributeNameFiltered = $attributeNameFiltered . '_' . $exploded[$a];
                    }

                    if ($attributeNameFiltered == "_contract_count") {
                        $to_replace_string_with = "<a>" . $this->getContractCount('purchase_contract') . "</a>";
                    } else if ($output_array[2][$x] === 'type_date') {
                        $to_replace_string_with = $this->getInput('date', $attributeNameFiltered, $value);
//                        $to_replace_string_with = "<a id='$id' class='attrr' style='display: inline; color: inherit;'><input class='' name='$attributeNameFiltered' type='date' id='$id' value='$value' /></a>";

                    } else if ($output_array[2][$x] === 'type_text') {
                        $to_replace_string_with = $this->getInput('text', $attributeNameFiltered, $value);

//                        $to_replace_string_with = "<a id='$id' class='attrr' style='display: inline; color: inherit;'><input type='text' class='' name='$attributeNameFiltered' id='$id' value='$value' size='". strlen($value) ."' /></a>";

                    } else if ($output_array[2][$x] === 'type_number') {
                        $to_replace_string_with = $this->getInput('number', $attributeNameFiltered, $value);

//                        $to_replace_string_with = "<a id='$id' class='attrr' style='display: inline; color: inherit;'><input class='' name='$attributeNameFiltered' type='number' value='$value' /></a>";

                    } else {

                        $to_replace_string_with = "<a id='$id' class='attrr' style='display: inline; color: inherit;'>
                                                                                                    <select><option>----------</option>
                                                                                                    <option value='بطاقة هوية فلسطينية'>بطاقة هوية فلسطينية</option>
                                                                                                    <option value='بطاقة هوية 48'>بطاقة هوية 48</option>
                                                                                                    <option value='بطاقة هوية مقدسية'>بطاقة هوية مقدسية</option>
                                                                                                    <option value='بطاقة هوية'>بطاقة هوية</option>
                                                                                                    <option value='رخصة قيادة'>رخصة قيادة</option>
                                                                                                    <option value='جواز سفر'>جواز سفر</option>
                                                                                                    </select>
</a>";

                    }

                    $contents = str_replace($output_array[0][$x], $to_replace_string_with, $contents);

                }

            }


            preg_match("'<p id=\"payments\" (.*?)>(.*?)</p>'si", $contents, $match);
            if ($match) {

                $to_replace_string_with = $this->getPayments($unitID);

                $contents = str_replace($match[0], $to_replace_string_with, $contents);

            }


            preg_match("'<span id=\"price_without_first_payment_in_word\">(.*?)</span>'", $contents, $match);
            if ($match) {
                $total_price = $this->getTotalPrice($unitID);

                $firstPayment = Payment::where('unit_id', $unitID)->orderBy('id')->first();
                if ($firstPayment) {
                    $firstPayment = $firstPayment->amount;
                } else {
                    $firstPayment = 0;
                }


                $price_without_first_payment = $total_price - $firstPayment;
                $to_replace_string_with = '<span id="price_without_first_payment_in_word">' . Contract1Controller::$Arabic->int2str($price_without_first_payment) . '</span>';

                $contents = preg_replace("'<span id=\"price_without_first_payment_in_word\">(.*?)</span>'", $to_replace_string_with, $contents);

            }

            preg_match("'<span id=\"price_without_first_payment\">(.*?)</span>'", $contents, $match);
            if ($match) {
                $total_price = $this->getTotalPrice($unitID);

                $firstPayment = Payment::where('unit_id', $unitID)->orderBy('id')->first();
                if ($firstPayment) {
                    $firstPayment = $firstPayment->amount;
                } else {
                    $firstPayment = 0;
                }


                $price_without_first_payment = number_format($total_price - $firstPayment);
                $to_replace_string_with = '<span id="price_without_first_payment">' . $price_without_first_payment . '</span>';

                $contents = preg_replace("'<span id=\"price_without_first_payment\">(.*?)</span>'", $to_replace_string_with, $contents);

            }


            preg_match("'<span id=\"first_payment_in_word\">(.*?)</span>'", $contents, $match);
            if ($match) {
                $payment = Payment::where('unit_id', $unitID)->orderBy('id')->first();

                $first_payment = isset($payment['amount']) ? $payment['amount'] : 0;
                $to_replace_string_with = '<span id="first_payment_in_word">' . Contract1Controller::$Arabic->int2str($first_payment) . '</span>';

                $contents = preg_replace("'<span id=\"first_payment_in_word\">(.*?)</span>'", $to_replace_string_with, $contents);
            }


            preg_match("'<span id=\"first_payment\">(.*?)</span>'", $contents, $match);
            if ($match) {
                $payment = Payment::where('unit_id', $unitID)->orderBy('id')->first();

                $first_payment = isset($payment['amount']) ? number_format($payment['amount']) : 0;
                $to_replace_string_with = '<span id="first_payment">' . $first_payment . '</span>';

                $contents = preg_replace("'<span id=\"first_payment\">(.*?)</span>'", $to_replace_string_with, $contents);
            }


            preg_match("'<span id=\"payment_period\">(.*?)</span>'", $contents, $match);
            if ($match) {
                $payment_period = unitPaymentPeriod::where('unit_id', $unitID)->first();

                $period = $payment_period->period;
                $to_replace_string_with = '<span id="payment_period">' . $period . '</span>';

                $contents = preg_replace("'<span id=\"payment_period\">(.*?)</span>'", $to_replace_string_with, $contents);
            }

            preg_match("'<span id=\"damage_cost\">(.*?)</span>'", $contents, $match);
            if ($match) {
                $total_price = $this->getTotalPrice($unitID);
                $damageCost = ceil($total_price * 0.25) ?? 0;

                $to_replace_string_with = '<span id="damage_cost">' . number_format($damageCost) . '</span>';

                $contents = preg_replace("'<span id=\"damage_cost\">(.*?)</span>'", $to_replace_string_with, $contents);
            }


            preg_match("'<span id=\"damage_cost_in_word\">(.*?)</span>'", $contents, $match);
            if ($match) {
                $total_price = $this->getTotalPrice($unitID);
                $damageCost = ceil($total_price * 0.25) ?? 0;

                $to_replace_string_with = '<span id="damage_cost_in_word">' . Contract1Controller::$Arabic->int2str($damageCost) . '</span>';

                $contents = preg_replace("'<span id=\"damage_cost_in_word\">(.*?)</span>'", $to_replace_string_with, $contents);
            }


            preg_match("'<span id=\"total_price\">(.*?)</span>'", $contents, $matches);
            if ($matches) {
                $total_price = $this->getTotalPrice($unitID);
                $to_replace_string_with = '<span id="total_price">' . number_format($total_price) . '</span>';

                $contents = preg_replace("'<span id=\"total_price\">(.*?)</span>'", $to_replace_string_with, $contents);
            }

            preg_match("'<span id=\"total_price_in_word\">(.*?)</span>'", $contents, $matches);
            if ($matches) {
                $total_price = $this->getTotalPrice($unitID);
                $to_replace_string_with = '<span id="total_price_in_word">' . Contract1Controller::$Arabic->int2str($total_price) . '</span>';

                $contents = preg_replace("'<span id=\"total_price_in_word\">(.*?)</span>'", $to_replace_string_with, $contents);
            }

            preg_match("'<span id=\"total_price_land\">(.*?)</span>'", $contents, $matches);
            if ($matches) {
                $total_price = $this->getTotalPrice($unitID);
                $total_price_land = $total_price * 0.3;
                $to_replace_string_with = '<span id="total_price_land">' . number_format($total_price_land) . '</span>';

                $contents = preg_replace("'<span id=\"total_price_land\">(.*?)</span>'", $to_replace_string_with, $contents);
            }

            preg_match("'<span id=\"total_price_land_in_word\">(.*?)</span>'", $contents, $matches);
            if ($matches) {
                $total_price = $this->getTotalPrice($unitID);
                $total_price_land = $total_price * 0.3;

                $to_replace_string_with = '<span id="total_price_land_in_word">' . Contract1Controller::$Arabic->int2str($total_price_land) . '</span>';

                $contents = preg_replace("'<span id=\"total_price_land_in_word\">(.*?)</span>'", $to_replace_string_with, $contents);
            }


            preg_match("'<span id=\"total_price_apartment\">(.*?)</span>'", $contents, $matches);
            if ($matches) {
                $total_price = $this->getTotalPrice($unitID);
                $total_price_apartment = $total_price * 0.7;
                $to_replace_string_with = '<span id="total_price_apartment">' . number_format($total_price_apartment) . '</span>';

                $contents = preg_replace("'<span id=\"total_price_apartment\">(.*?)</span>'", $to_replace_string_with, $contents);
            }

            preg_match("'<span id=\"total_price_apartment_in_word\">(.*?)</span>'", $contents, $matches);
            if ($matches) {
                $total_price = $this->getTotalPrice($unitID);
                $total_price_apartment = $total_price * 0.7;

                $to_replace_string_with = '<span id="total_price_apartment_in_word">' . Contract1Controller::$Arabic->int2str($total_price_apartment) . '</span>';

                $contents = preg_replace("'<span id=\"total_price_apartment_in_word\">(.*?)</span>'", $to_replace_string_with, $contents);
            }


            return $contents;
        }

        if ($contents === null) {
            return null;
        }


        if ($contents != null) {


            $contents = $this->previewExistingData($contents, $unitID);

            $contents = $this->previewFunctionInContract($contents, $unitID);

//                $pattern = "/sys_var(.*)/i";
            $pattern = "/sys_var[^\s]+/i";

            $found_matches = [];
            if (preg_match_all($pattern, $contents, $matches)) {
                $found_matches = $matches[0];
            }


            for ($x = 0; $x <= sizeof($found_matches) - 1; $x++) {
                $found_matches[$x] = str_replace(array('&nbsp;', "<p>", "</p>", ""), '', $found_matches[$x]);
                $resStr = str_replace(array("\n", "\t", "\r", ""), '', $found_matches[$x]);
                $strpos = stripos($resStr, ' ');
                if ($strpos > 0)
                    $resStr = substr($resStr, 0, $strpos);

                $to_replace_string_with = "";
                $uniqueId = "" . $x;
                $uniqueDivId = $x . "_div";

                if (Str::endsWith($resStr, "_type_date")) {
                    $uniqueDivId = $uniqueDivId . "_type_date";
                    $attribute_name = str_replace("_type_date", "", $resStr);
                    $attribute_name = str_replace("sys_var", "", $attribute_name);
                    if ($attribute_name == "_contract_count") {
                        $to_replace_string_with = "<span/>" . $this->getContractCount('purchase_contract') . "</span>";
                    } else {
                        $to_replace_string_with = $this->getInput('date', $attribute_name);
//                        $to_replace_string_with = "<a id='$uniqueDivId' class='attrr' style='display: inline; color: inherit;'><input type='date' name='$attribute_name' id='$uniqueId' /></a>";
                    }
                } else if (Str::endsWith($resStr, "_type_number")) {
                    $uniqueDivId = $uniqueDivId . "_type_number";
                    $attribute_name = str_replace("_type_number", "", $resStr);
                    $attribute_name = str_replace("sys_var", "", $attribute_name);
                    if ($attribute_name == "_contract_count") {
                        $to_replace_string_with = "<span/>" . $this->getContractCount('purchase_contract') . "</span>";
                    } else {
                        $to_replace_string_with = $this->getInput('number', $attribute_name);

//                        $to_replace_string_with = "<a id='$uniqueDivId' class='attrr' style='display: inline; color: inherit;'><input type='number' name='$attribute_name' id='$uniqueId'/></a>";
                    }
                } else if (Str::endsWith($resStr, "_type_text")) {
                    $uniqueDivId = $uniqueDivId . "_type_text";
                    $attribute_name = str_replace("_type_text", "", $resStr);
                    $attribute_name = str_replace("sys_var", "", $attribute_name);
                    if ($attribute_name == "_contract_count") {
                        $to_replace_string_with = "<span/>" . $this->getContractCount('purchase_contract') . "</span>";
                    } else {
                        $to_replace_string_with = $this->getInput('text', $attribute_name);

//                        $to_replace_string_with = "<a id='$uniqueDivId' class='attrr' style='display: inline; color: inherit;'><input type='text' name='$attribute_name' id='$uniqueId' /></a>";
                    }
                } else {
                    $uniqueDivId = $uniqueDivId . "_type_text";
                    $attribute_name = str_replace("_type_text", "", $resStr);
                    $attribute_name = str_replace("sys_var", "", $attribute_name);

                    $to_replace_string_with = "<a id='$uniqueDivId' class='attrr' style='display: inline; color: inherit;'><select><option>----------</option>
                                                                                                    <option value='بطاقة هوية فلسطينية'>بطاقة هوية فلسطينية</option>
                                                                                                    <option value='بطاقة هوية 48'>بطاقة هوية 48</option>
                                                                                                    <option value='بطاقة هوية مقدسية'>بطاقة هوية مقدسية</option>
                                                                                                    <option value='بطاقة هوية'>بطاقة هوية</option>
                                                                                                    <option value='رخصة قيادة'>رخصة قيادة</option>
                                                                                                    <option value='جواز سفر'>جواز سفر</option>
                                                                                                    </select></a>";

                }
                $contents = str_replace($resStr, $to_replace_string_with, $contents);
            }


            return htmlspecialchars_decode($contents);
        }
    }

    /**
     * Parsing the template and create a new report...
     * @return mixed
     */
    public function parseAndSaveContractTemplate()
    {

        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($conn, "utf8");

        $post = $this->_app->request->post();
        $contents = $post['parsedText'];
        $template_id = $post['template_id'];
        $unit_id = $post['unit_id'];
        $json = $post['json'];

        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contracts` WHERE unit_id = " . $unit_id . " and status = 'ACTIVE' and `type` = 'purchase_contract'";

        $result = mysqli_query($conn, $query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // We will just archive this unit and add another entry.
            $update_query = "UPDATE `contracts` set status = 'ARCHIVED' WHERE `type` = 'purchase_contract' and unit_id = " . $unit_id;
            $update_result = mysqli_query($conn, $update_query);
        }
        $query = "INSERT INTO `contracts`( `content`, `user_id`, `template_id`, `unit_id`, `status`, `created_at`, `json`, `type`, `count`) VALUES ('" . $contents . "', '" . $_SESSION['userfrosting']['user_id'] . "', '" . $template_id . "', " . $unit_id . ", '" . 'ACTIVE' . "', '" . date("Y/m/d h:i:s") . "', '" . $json . "', 'purchase_contract' , " . $this->getContractCount('purchase_contract') . ")";
        if ($conn->query($query) === TRUE) {
            return "Contract saved successfully";
        } else {
            return "Error happened";
        }
    }

    function testForRawabiContract1()
    {
        $db_connection_string = $this->_app->environment()["db_connection"];

        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contracts_templates` where `templateName` = 'اتفاقية بيع وشراء وحدة سكنية' and `status` = 'ACTIVE'";
        $result = mysqli_query($conn, $query);
        $template_id = 0;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $contentCopy = $row['content'];
            $content = $row['content'];
            $template_id = $row['id'];
            $pattern = "/sys_var[^\s]+/i";
            $found_matches = [];
            if (preg_match_all($pattern, $content, $matches)) {
                $found_matches = $matches[0];
            }


            $contracts1_unit = contract1_unit::all();

            foreach ($contracts1_unit as $contract1) {
                $unit_id = $contract1->unit_id;
                $contract_id = $contract1->contract1_id;
                $contract1 = Contract1::find($contract_id);
                $unit = Unit::find($unit_id);

                if ($contract1) {
                    $content = $contentCopy;
                    for ($x = 0; $x < sizeof($found_matches); $x++) {
                        $found_matches[$x] = str_replace(array('&nbsp;', "<p>", "</p>", ""), '', $found_matches[$x]);
                        $resStr = str_replace(array("\n", "\t", "\r", ""), '', $found_matches[$x]);
                        $strpos = stripos($resStr, ' ');
                        if ($strpos > 0)
                            $resStr = substr($resStr, 0, $strpos);

                        $attribute_name = str_replace("sys_var_", "", $resStr);
                        $attribute_name = explode('_type', $attribute_name)[0];

                        if (str_contains($attribute_name, 'unit_')) {
                            $attribute_name = str_replace("unit_", "", $attribute_name);
                        }

                        $To = '';

                        if (isset($contract1[$attribute_name])) {
                            $To = $contract1[$attribute_name];
                        }
                        if (isset($unit[$attribute_name])) {
                            $To = $unit[$attribute_name];
                        }

                        $content = $this->str_replace_first($found_matches[$x], $To, $content);
                    }


                    $content = $this->ApplyFunctions($content);


                    $query = "INSERT INTO `contracts`( `content`, `user_id`, `template_id`, `unit_id`, `status`, `created_at`, `type`, `json`, `count`) VALUES ('" . htmlspecialchars_decode($content) . "', '" . $_SESSION['userfrosting']['user_id'] . "', '" . $template_id . "', " . $unit_id . ", '" . 'ACTIVE' . "', '" . date("Y/m/d h:i:s") . "', 'purchase_contract', '', " . $this->getContractCount('purchase_contract') . " )";
                    $conn->query($query);
                }
            }

        } else {
            echo 'no data';
        }
    }

    public function getContractDetails()
    {
        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($conn, "utf8");

        $post = $this->_app->request->post();
        $id = $post['id'];

        $query = "SELECT * FROM `contracts` WHERE unit_id = " . $id . " and status = 'ACTIVE'";
        $result = mysqli_query($conn, $query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $data['id'] = $row['id'];
            $data['content'] = $row['content'];
            $data['status'] = $row['status'];
            $data['created_at'] = $row['created_at'];

            return $data;
        } else {
            $this->_app->render('unit/updateContractTemplate.twig', []);
        }
    }

    function parseTag($content, $tg)
    {

//
//        $index1 = strpos($content, "<a");
//        $index2 = strpos($content, "</a>");
//        $content = substr($content, $index1, $index2+7);

        $dom = new DOMDocument;
        $dom->loadHTML($content);
        $attr = array();
        foreach ($dom->getElementsByTagName($tg) as $tag) {
            foreach ($tag->attributes as $attribName => $attribNodeVal) {
                $attr[$attribName] = $tag->getAttribute($attribName);
            }
        }
        return $attr;
    }

    function reservationContent($reservation, $unit, $unit_id, $reservsation_arr)
    {

        $db_connection_string = $this->_app->environment()["db_connection"];

        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contracts_templates` where `templateName` = 'Reservation Receipt' and `status` = 'ACTIVE'";
        $result = mysqli_query($conn, $query);
        $template_id = 0;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $content = $row['content'];
            $template_id = $row['id'];
            $pattern = "/sys_var[^\s]+/i";
            $found_matches = [];
            if (preg_match_all($pattern, $content, $matches)) {
                $found_matches = $matches[0];
            }


            for ($x = 0; $x < sizeof($found_matches); $x++) {
                $found_matches[$x] = str_replace(array('&nbsp;', "<p>", "</p>", ""), '', $found_matches[$x]);
                $resStr = str_replace(array("\n", "\t", "\r", ""), '', $found_matches[$x]);
                $strpos = stripos($resStr, ' ');
                if ($strpos > 0)
                    $resStr = substr($resStr, 0, $strpos);

                $attribute_name = str_replace("sys_var_reservation_", "", $resStr);
                $prefix = "reservation_";
                if (str_contains($attribute_name, 'sys_var_unit_')) {
                    $attribute_name = str_replace("sys_var_unit_", "", $resStr);
                    $prefix = "unit_";
                }

                // echo $attribute_name;
                if (str_contains($attribute_name, 'customer_type_of_id')) {
                    $attribute_name = 'customer_type_of_id';
                } else {
                    $attribute_name = explode('_type', $attribute_name)[0];
                }
//                echo $x.' ';


                $To = '';

                if ($attribute_name == "sys_var_contract_count") {
                    $To = (int)$this->getContractCount('reservation_receipt');
                } else if ($prefix == "reservation_" && isset($reservation[$attribute_name])) {
                    $To = $reservation[$attribute_name];
                } else if ($prefix == "unit_" && isset($unit[$attribute_name])) {
                    $To = $unit[$attribute_name];
                }

                $content = $this->str_replace_first($found_matches[$x], $To, $content);
            }

            $content = $this->ApplyFunctions($content);

            $query = "SELECT * FROM `contracts` WHERE unit_id = " . $unit_id . " and status = 'ACTIVE' and `type` = 'reservation_receipt'";

            $result = mysqli_query($conn, $query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // We will just archive this unit and add another entry.
                $update_query = "UPDATE `contracts` set status = 'ARCHIVED' WHERE `type` = 'reservation_receipt' and unit_id = " . $unit_id;
                $update_result = mysqli_query($conn, $update_query);
            }
            $query = "INSERT INTO `contracts`( `content`, `user_id`, `template_id`, `unit_id`, `status`, `created_at`, `type`, `json`, `count`) VALUES ('" . htmlspecialchars_decode($content) . "', '" . $_SESSION['userfrosting']['user_id'] . "', '" . $template_id . "', " . $unit_id . ", '" . 'ACTIVE' . "', '" . date("Y/m/d h:i:s") . "', 'reservation_receipt', '" . $reservsation_arr . "', " . $this->getContractCount('reservation_receipt') . " )";

            if ($conn->query($query) === TRUE) {
                return "Contract saved successfully";
            } else {
                return "Error happened";
            }
        } else {
            return 'no data';
        }
    }

    function getReservationContent($unit_id)
    {
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contracts` WHERE unit_id = " . $unit_id . " and status = 'ACTIVE' and `type` = 'reservation_receipt'";
        $result = mysqli_query($conn, $query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return 0;
        }
    }

    function storageContent($reservation, $storage, $unit, $unit_id)
    {

        $storageId = $storage['id'];
        $storagePrice = $storage['price'];
        $storage['price'] = $this->calculateParkingStoragePrice((int)$storageId, $storagePrice, "storage");
        $neighborhood = Neighborhoods::where('haiEnglishName', $unit->neighborhood)->first();


        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contracts_templates` where `templateName` = 'Appendix/Storage' and `status` = 'ACTIVE'";
        $result = mysqli_query($conn, $query);
        $template_id = 0;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $content = $row['content'];
            $template_id = $row['id'];

            $pattern = "/sys_var[^\s]+/i";
            $found_matches = [];
            if (preg_match_all($pattern, $content, $matches)) {
                $found_matches = $matches[0];
            }


            for ($x = 0; $x < sizeof($found_matches); $x++) {
                $found_matches[$x] = str_replace(array('&nbsp;', "<p>", "</p>", ""), '', $found_matches[$x]);
                $resStr = str_replace(array("\n", "\t", "\r", ""), '', $found_matches[$x]);
                $strpos = stripos($resStr, ' ');
                if ($strpos > 0)
                    $resStr = substr($resStr, 0, $strpos);

                $attribute_name = str_replace("sys_var_reservation_", "", $resStr);
                $prefix = "reservation_";
                if (str_contains($attribute_name, 'sys_var_storage_')) {
                    $attribute_name = str_replace("sys_var_storage_", "", $resStr);
                    $prefix = "storage_";
                } else if (str_contains($attribute_name, 'sys_var_unit_')) {
                    $attribute_name = str_replace("sys_var_unit_", "", $resStr);
                    $prefix = "unit_";
                }
//                echo $prefix.' ';
//                echo $attribute_name.' ';
                $attribute_name = explode('_type', $attribute_name)[0];
//                echo $x.' ';


                $To = '';
                if ($attribute_name == "sys_var_contract_count") {
                    $To = (int)$this->getContractCount('Appendix/Storage');
                } else if (str_contains($attribute_name, 'contractDate')) {
                    $contract = Contract::where('unit_id', $unit_id)->where('type', 'purchase_contract')->first();
                    if ($contract) {
                        $To = substr($contract->created_at, 0, 10);
                    } else {
                        $To = $reservation['reservation_date'] ?? '';
                    }
                } else if ($prefix == "storage_" && str_contains($attribute_name, "reservation_date")) {

                    $parkingStorageReservation = parking_storage_reservation::where('type', "storage")->where('parking_storage_id', $storageId)->first();

                    if($parkingStorageReservation) {
                        $input = $parkingStorageReservation->reservation_date;
                        $format = 'Y-m-d';
                        $date = Carbon::createFromFormat($format, $input);


                        $To = '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>'
                            . $date->day .
                            '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>'
                            . 'من شهر' .
                            '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>'
                            . $date->month .
                            '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>'
                            . 'لعام' .
                            '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>'
                            . $date->year .
                            '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span> .';

                    }




                } else if (str_contains($attribute_name, "annex_count")) {


                    $unitParkingStorageReservation = parking_storage_reservation::where('uid', $unit_id)->get();

                    if (count($unitParkingStorageReservation) > 0) {
                        $flag = false;

                        foreach ($unitParkingStorageReservation as $item) {
                            if ($item->type == "parking") {
                                $flag = true;
                            }
                        }
                        if ($flag) {
                            $To = 7;
                        } else {
                            $To = 6;
                        }

                    } else {
                        $To = 6;
                    }
                } else if ($prefix == "reservation_" && str_contains($attribute_name, 'total_price')) {

                    $total_price = $reservation['total_price'];
                    $unitParkingStorageReservation = parking_storage_reservation::where('uid', $unit_id)->get();
                    $count = count($unitParkingStorageReservation);

                    foreach ($unitParkingStorageReservation as $item) {
                        if (--$count <= 0) {
                            break;
                        }

                        if ($item->type == "parking") {
                            $parking = Parking::where('id', $item->parking_storage_id)->first();
                            if ($parking) {
                                $total_price = (float)$total_price + (float)$parking->price;
                            }
                        } else if ($item->type == "storage") {
                            $storage = Storage::where('id', $item->parking_storage_id)->first();
                            if ($storage) {
                                $total_price = (float)$total_price + (float)$storage->price;
                            }
                        }
                    }

                    $To = $total_price;
                } else if ($prefix == "reservation_" && isset($reservation[$attribute_name])) {
                    $To = $reservation[$attribute_name];
                } else if ($prefix == "storage_" && isset($storage[$attribute_name])) {
                    $To = $storage[$attribute_name];
                } else if ($prefix == "unit_" && isset($unit[$attribute_name])) {
                    $To = $unit[$attribute_name];
                } else if (str_contains($attribute_name, 'land')) {
                    $To = $neighborhood['land'];
                }


                $content = $this->str_replace_first($found_matches[$x], $To, $content);
            }


            if (preg_match_all($pattern, $content, $matches)) {
                $found_matches = $matches[0];
                $content = $this->retryParsingStorage($found_matches, $reservation, $storage, $unit, $content);
            }


            $content = $this->ApplyFunctions($content, $storageId);


//            $query = "SELECT * FROM `contracts` WHERE unit_id = ". $unit_id . " and status = 'ACTIVE' and `type` = 'Appendix/Storage'";
//
//            $result = mysqli_query($conn,$query);
//
//            if ($result && $result->num_rows > 0) {
//                $row = $result->fetch_assoc();
//                // We will just archive this unit and add another entry.
//                $update_query = "UPDATE `contracts` set status = 'ARCHIVED' WHERE `type` = 'Appendix/Storage' and unit_id = ". $unit_id;
//                $update_result = mysqli_query($conn, $update_query);
//            }

            $query = "INSERT INTO `contracts`( `content`, `user_id`, `template_id`, `unit_id`, `status`, `created_at`, `type`, `json`, `count`) VALUES ('" . htmlspecialchars_decode($content) . "', '" . $_SESSION['userfrosting']['user_id'] . "', '" . $template_id . "', " . $unit_id . ", '" . 'ACTIVE' . "', '" . date("Y/m/d h:i:s") . "', 'Appendix/Storage', '" . json_encode($storage) . "' , " . $this->getContractCount('Appendix/Storage') . ")";

            if ($conn->query($query) === TRUE) {
                return "Contract saved successfully";
            } else {
                return "Error happened";
            }

        } else {
            return 'no data';
        }
    }

    function parkingContent($reservation, $parking, $unit, $unit_id)
    {
        $parkingId = $parking['id'];
        $parkingPrice = $parking['price'];
        $parking['price'] = $this->calculateParkingStoragePrice((int)$parkingId, $parkingPrice, "parking");
        $db_connection_string = $this->_app->environment()["db_connection"];
        $neighborhood = Neighborhoods::where('haiEnglishName', $unit->neighborhood)->first();


        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contracts_templates` where `templateName` = 'Appendix/Parking' and `status` = 'ACTIVE'";

        $result = mysqli_query($conn, $query);
        $template_id = 0;


        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $content = $row['content'];
            $template_id = $row['id'];

            $pattern = "/sys_var[^\s]+/i";
            $found_matches = [];
            if (preg_match_all($pattern, $content, $matches)) {
                $found_matches = $matches[0];
            }

            for ($x = 0; $x < sizeof($found_matches); $x++) {
                $found_matches[$x] = strip_tags($found_matches[$x]);
                $found_matches[$x] = str_replace(array('&nbsp;', "<p>", "</p>", ""), '', $found_matches[$x]);
                $resStr = str_replace(array("\n", "\t", "\r", ""), '', $found_matches[$x]);
                $strpos = stripos($resStr, ' ');
                if ($strpos > 0)
                    $resStr = substr($resStr, 0, $strpos);

                $attribute_name = str_replace("sys_var_reservation_", "", $resStr);
                $prefix = "reservation_";
                if (str_contains($attribute_name, 'sys_var_parking_')) {
                    $attribute_name = str_replace("sys_var_parking_", "", $resStr);
                    $prefix = "parking_";
                } else if (str_contains($attribute_name, 'sys_var_unit_')) {
                    $attribute_name = str_replace("sys_var_unit_", "", $resStr);
                    $prefix = "unit_";
                }
                // echo $attribute_name;
                $attribute_name = explode('_type', $attribute_name)[0];
//                echo $x.' ';

                $To = '';
                if ($attribute_name == "sys_var_contract_count") {
                    $To = (int)$this->getContractCount('Appendix/Parking');
                } else if ($prefix == "parking_" && str_contains($attribute_name, "reservation_date")) {

                    $parkingStorageReservation = parking_storage_reservation::where('type', "parking")->where('parking_storage_id', $parkingId)->first();

                    if($parkingStorageReservation) {
                        $input = $parkingStorageReservation->reservation_date;
                        $format = 'Y-m-d';
                        $date = Carbon::createFromFormat($format, $input);


                        $To = '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>'
                            . $date->day .
                            '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>'
                            . 'من شهر' .
                            '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>'
                            . $date->month .
                            '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>'
                            . 'لعام' .
                            '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>'
                            . $date->year .
                            '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span> .';

                    }


                } else if (str_contains($attribute_name, "annex_count")) {
                    $unitParkingStorageReservation = parking_storage_reservation::where('uid', $unit_id)->get();

                    if (count($unitParkingStorageReservation) > 0) {
                        $flag = false;

                        foreach ($unitParkingStorageReservation as $item) {
                            if ($item->type == "storage") {
                                $flag = true;
                            }
                        }
                        if ($flag) {
                            $To = 7;
                        } else {
                            $To = 6;
                        }

                    } else {
                        $To = 6;
                    }


                } else if ($prefix == "reservation_" && str_contains($attribute_name, 'total_price')) {

                    $total_price = $reservation['total_price'];
                    $unitParkingStorageReservation = parking_storage_reservation::where('uid', $unit_id)->get();
                    $count = count($unitParkingStorageReservation);

                    foreach ($unitParkingStorageReservation as $item) {
                        if (--$count <= 0) {
                            break;
                        }

                        if ($item->type == "parking") {
                            $parking = Parking::where('id', $item->parking_storage_id)->first();
                            if ($parking) {
                                $total_price = (float)$total_price + (float)$parking->price;
                            }
                        } else if ($item->type == "storage") {
                            $storage = Storage::where('id', $item->parking_storage_id)->first();
                            if ($storage) {
                                $total_price = (float)$total_price + (float)$storage->price;
                            }
                        }
                    }

                    $To = $total_price;
                } else if ($prefix == "reservation_" && isset($reservation[$attribute_name])) {
                    $To = $reservation[$attribute_name];
                } else if ($prefix == "parking_" && isset($parking[$attribute_name])) {
                    $To = $parking[$attribute_name];
                } else if ($prefix == "unit_" && isset($unit[$attribute_name])) {
                    $To = $unit[$attribute_name];
                } else if (str_contains($attribute_name, 'land')) {
                    $To = $neighborhood['land'];
                }



                $content = $this->str_replace_first($found_matches[$x], $To, $content);
            }


            if (preg_match_all($pattern, $content, $matches)) {
                $found_matches = $matches[0];
                $content = $this->retryParsingParking($found_matches, $reservation, $parking, $unit, $content);
            }
            $content = $this->ApplyFunctions($content, $parkingId);


//            $query = "SELECT * FROM `contracts` WHERE unit_id = ". $unit_id . " and status = 'ACTIVE' and `type` = 'Appendix/Parking'";
//
//            $result = mysqli_query($conn,$query);
//
//            if ($result && $result->num_rows > 0) {
//                $row = $result->fetch_assoc();
//                // We will just archive this unit and add another entry.
//                $update_query = "UPDATE `contracts` set status = 'ARCHIVED' WHERE `type` = 'Appendix/Parking' and unit_id = ". $unit_id;
//                $update_result = mysqli_query($conn, $update_query);
//            }

            $query = "INSERT INTO `contracts`( `content`, `user_id`, `template_id`, `unit_id`, `status`, `created_at`, `type`, `json`, `count`) VALUES ('" . htmlspecialchars_decode($content) . "', '" . $_SESSION['userfrosting']['user_id'] . "', '" . $template_id . "', " . $unit_id . ", '" . 'ACTIVE' . "', '" . date("Y/m/d h:i:s") . "', 'Appendix/Parking', '" . json_encode($parking) . "', " . $this->getContractCount('Appendix/Parking') . ")";

            if ($conn->query($query) === TRUE) {
                return "Contract saved successfully";
            } else {
                return "Error happened";
            }

        } else {
            return 'no data';
        }
    }


    public function previewExistingData($contents, $unitID)
    {
        $unit = Unit::find($unitID);
        $neighborhood = Neighborhoods::where('haiEnglishName', $unit->neighborhood)->first();
        $payment = Payment::where('unit_id', $unitID)->orderBy('id')->first();
        $payment_period = unitPaymentPeriod::where('unit_id', $unitID)->first();

        if (Contract1Controller::$Arabic == null) {
            Contract1Controller::$Arabic = new I18N_Arabic("Numbers");
        }

        $reservation_relation = $unit->reservations($unitID);
        if (count($reservation_relation)) {
            $reservation_id = $reservation_relation[0]['reservation_id'];

            $reservedUnit = Reservation::find($reservation_id);
        }

        $parking = $this->getParkingInformationforUnit($unitID);
        if (count($parking) > 0) {
            $parkingPrice = $parking['price'];
            $parking['price'] = $this->calculateParkingStoragePrice($parking['id'], $parkingPrice, "parking");
        }


        $storage = $this->getStorageInformationforUnit($unitID);
        if (count($storage) > 0) {
            $storagePrice = $storage['price'];
            $storage['price'] = $this->calculateParkingStoragePrice($storage['id'], $storagePrice, "storage");
        }
        $content = $contents;
        $pattern = "/sys_var[^\s]+/i";
        $found_matches = [];
        if (preg_match_all($pattern, $content, $matches)) {
            $found_matches = $matches[0];
        }


        for ($x = 0; $x < sizeof($found_matches); $x++) {
            $found_matches[$x] = str_replace(array('&nbsp;', "<p>", "</p>", ""), '', $found_matches[$x]);
            $resStr = str_replace(array("\n", "\t", "\r", ""), '', $found_matches[$x]);
            $strpos = stripos($resStr, ' ');
            if ($strpos > 0)
                $resStr = substr($resStr, 0, $strpos);

            $attribute_name = str_replace("sys_var_reservation_", "", $resStr);
            $prefix = "reservation_";
            if (str_contains($attribute_name, 'sys_var_unit_')) {
                $attribute_name = str_replace("sys_var_unit_", "", $resStr);
                $prefix = "unit_";
            } else if (str_contains($attribute_name, 'sys_var_parking_')) {
                $attribute_name = str_replace("sys_var_parking_", "", $resStr);
                $prefix = "parking_";
            } else if (str_contains($attribute_name, 'sys_var_storage_')) {
                $attribute_name = str_replace("sys_var_storage_", "", $resStr);
                $prefix = "storage_";
            }

            if (str_contains($attribute_name, 'customer_type_of_id')) {
                $attribute_name = 'customer_type_of_id';
            } else {
                $attribute_name = explode('_type', $attribute_name)[0];
            }


            $To = '';

            if ($attribute_name == "sys_var_contract_count") {
                $To = (int)$this->getContractCount('reservation_receipt');
            } else if (str_contains($attribute_name, 'purchaser1')) {
                $To = $this->getInput('text', '_person_signed', 'الحارث يوسف محمد اطميزه');
            } else if (str_contains($attribute_name, 'customer_type_of_id')) {

                $id_48 = $reservedUnit[$attribute_name] == "بطاقة هوية 48" ? "selected" : "";
                $id_pal = $reservedUnit[$attribute_name] == "بطاقة هوية فلسطينية" ? "selected" : "";
                $id_jerusalem = $reservedUnit[$attribute_name] == "بطاقة هوية مقدسية" ? "selected" : "";


                $To = "<a id='" . rand() . "_div_type_text' style='display: inline; color: inherit;' name='" . $attribute_name . "'>
                        <select name='" . $attribute_name . "'>
                            <option>----------</option>
                            <option " . $id_pal . " value='بطاقة هوية فلسطينية'>بطاقة هوية فلسطينية</option>
                            <option " . $id_48 . " value='بطاقة هوية 48'>بطاقة هوية 48</option>
                            <option " . $id_jerusalem . " value='بطاقة هوية مقدسية'>بطاقة هوية مقدسية</option>
                            <option value='بطاقة هوية'>بطاقة هوية</option>
                            <option value='رخصة قيادة'>رخصة قيادة</option>
                            <option value='جواز سفر'>جواز سفر</option>
                        </select></a>";
            } else if (str_contains($attribute_name, 'total_price_land_in_word')) {

                $total_price = $reservedUnit['total_price'];

                $total_price_land = $total_price * 0.3;

                $To = '<span id="total_price_land_in_word">' . Contract1Controller::$Arabic->int2str($total_price_land) . '</span>';

            } else if (str_contains($attribute_name, 'total_price_land')) {

                $total_price = $reservedUnit['total_price'];

                $total_price_land = $total_price * 0.3;

                $To = '<span id="total_price_land">' . number_format($total_price_land) . '</span>';

            } else if (str_contains($attribute_name, 'total_price_apartment_in_word')) {

                $total_price = $reservedUnit['total_price'];

                $total_price_apartment = $total_price * 0.7;

                $To = '<span id="total_price_apartment_in_word">' . Contract1Controller::$Arabic->int2str($total_price_apartment) . '</span>';

            } else if (str_contains($attribute_name, 'total_price_apartment')) {

                $total_price = $reservedUnit['total_price'];

                $total_price_apartment = $total_price * 0.7;

                $To = '<span id="total_price_apartment">' . number_format($total_price_apartment) . '</span>';

            } else if (str_contains($attribute_name, 'land')) {
                $To = $neighborhood['land'];
            } else if (str_contains($attribute_name, 'buildingsNum')) {
                $To = $neighborhood['haiBuildingsNum'];
            } else if (str_contains($attribute_name, 'estContrNum')) {
                $To = $neighborhood['estContrNum'];
            } else if (str_contains($attribute_name, 'estContrDate')) {
                $To = $neighborhood['estContrDate'];
            } else if (str_contains($attribute_name, 'estContrNum2')) {
                $To = $neighborhood['estContrNum2'];
            } else if (str_contains($attribute_name, 'estContrDate2')) {
                $To = $neighborhood['estContrDate2'];
            } else if (str_contains($attribute_name, 'haiArea')) {
                $To = $neighborhood['haiArea'];
            } else if (str_contains($attribute_name, 'neighborhood')) {
                $To = $neighborhood['haiArabicName'];
            } else if (str_contains($attribute_name, 'number_of_payments')) {

                if ($payment_period) {
                    $To = '<span id="payment_period">' . $payment_period->period . '</span>';

//                    $To = $payment_period->period;
                } else {
                    $To = '<span id="payment_period"></span>';;
                }


            } else if (str_contains($attribute_name, 'price_without_first_payment_in_word')) {
                $total_price = $reservedUnit['total_price'];
                $first_payment = isset($payment['amount']) ? $payment['amount'] : 0;


                $price_without_first_payment = $total_price - $first_payment;
                $To = '<span id="price_without_first_payment_in_word">' . Contract1Controller::$Arabic->int2str($price_without_first_payment) . '</span>';

            } else if (str_contains($attribute_name, 'first_payment_in_word')) {
                $first_payment = isset($payment['amount']) ? $payment['amount'] : 0;
                $first_payment = $first_payment;

                $To = '<span id="first_payment_in_word">' . Contract1Controller::$Arabic->int2str($first_payment) . '</span>';

            } else if (str_contains($attribute_name, 'price_without_first_payment')) {
                $total_price = $reservedUnit['total_price'];
                $first_payment = isset($payment['amount']) ? $payment['amount'] : 0;


                $price_without_first_payment = number_format($total_price - $first_payment);

                $To = '<span id="price_without_first_payment">' . $price_without_first_payment . '</span>';

            } else if (str_contains($attribute_name, 'first_payment')) {

                $first_payment = isset($payment['amount']) ? number_format($payment['amount']) : 0;
                $To = '<span id="first_payment">' . $first_payment . '</span>';

//                $To = isset($payment['amount']) ? number_format($payment['amount']) : 0;
            } else if (str_contains($attribute_name, 'damage_cost_in_word')) {

                $total_price = $reservedUnit['total_price'];

                $damageCost = ceil($total_price * 0.25) ?? 0;

                $To = '<span id="damage_cost_in_word">' . Contract1Controller::$Arabic->int2str($damageCost) . '</span>';
            } else if (str_contains($attribute_name, 'damage_cost')) {

                $total_price = $reservedUnit['total_price'];

                $damageCost = ceil($total_price * 0.25) ?? 0;

                $To = '<span id="damage_cost">' . $damageCost . '</span>';

            } else if (str_contains($attribute_name, 'total_price_in_word')) {

                $total_price = $reservedUnit['total_price'];

                $To = '<span id="total_price_in_word">' . Contract1Controller::$Arabic->int2str($total_price) . '</span>';

            } else if ($prefix == "reservation_" && isset($reservedUnit[$attribute_name])) {
//                $To = "<input type='text' value= '".$reservedUnit[$attribute_name]."' name='".$attribute_name."' />";
                if ($attribute_name == "total_price") {
                    $To = '<span id="total_price">' . number_format($reservedUnit[$attribute_name]) . '</span>';
                } else {
                    $To = $reservedUnit[$attribute_name];
                }

            } else if ($prefix == "unit_" && isset($unit[$attribute_name])) {
                $To = $unit[$attribute_name];
            } else if ($prefix == "parking_" && isset($parking[$attribute_name])) {
                $To = $parking[$attribute_name];
            } else if ($prefix == "storage_" && isset($storage[$attribute_name])) {
                $To = $storage[$attribute_name];
            } else {
                continue;
            }

            if (in_array($attribute_name, $this->reservationEditable)) {


                if ($attribute_name == "unitDescription") {
                    $To = $this->getInput('text', $attribute_name, $To, 55);
//                    $To = '<a id="0_div_type_text" style="display: inline; color: inherit;" name="'. $attribute_name .'"><input name="'. $attribute_name .'" type="text" value="' . $To . '"  size="55"/></a>';

                } else {
                    $To = $this->getInput('text', $attribute_name, $To);

//                    $To = '<a id="0_div_type_text" style="display: inline; color: inherit;" name="'. $attribute_name .'"><input name="'. $attribute_name .'" type="text" value="' . $To . '" /></a>';

                }


            } else {
                $To = '<span  class="underline">' . $To . '</span>';
            }

            $content = $this->str_replace_first($found_matches[$x], $To, $content);
        }

        return $content;
    }

    public function calculateParkingStoragePrice($parkingStorageId, $price, $type)
    {
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = 'SELECT * FROM `parking_storage_reservation` WHERE `parking_storage_id` = ' . $parkingStorageId . ' and `type` =  "' . $type . '"';

        $result = mysqli_query($conn, $query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return ((float)$row['exchange_rate']) * ((float)$price);
        } else {
            return ((float)$price);
        }
    }

    public function getStorageContent($unit_id)
    {
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contracts` WHERE unit_id = " . $unit_id . " and status = 'ACTIVE' and `type` = 'Appendix/Storage'";
        $result = mysqli_query($conn, $query);
        if ($result && $result->num_rows > 0) {
            $contract = [];
            while ($row = $result->fetch_assoc()) {
                array_push($contract, $row);
            }
            return $contract;
        } else {
            return [];
        }
    }

    public function getParkingContent($unit_id)
    {
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contracts` WHERE unit_id = " . $unit_id . " and status = 'ACTIVE' and `type` = 'Appendix/Parking'";
        $result = mysqli_query($conn, $query);
        if ($result && $result->num_rows > 0) {
            $contract = [];
            while ($row = $result->fetch_assoc()) {
                array_push($contract, $row);
            }
            return $contract;
        } else {
            return [];
        }
    }


    function str_replace_first($from, $to, $content)
    {
        $from = '/' . preg_quote($from, '/') . '/';

        return preg_replace($from, $to, $content, 1);
    }


    function convertPriceToWord($num)
    {
        $num = (float)trim($num);
        $ones = array(
            0 => "ZERO",
            1 => "ONE",
            2 => "TWO",
            3 => "THREE",
            4 => "FOUR",
            5 => "FIVE",
            6 => "SIX",
            7 => "SEVEN",
            8 => "EIGHT",
            9 => "NINE",
            10 => "TEN",
            11 => "ELEVEN",
            12 => "TWELVE",
            13 => "THIRTEEN",
            14 => "FOURTEEN",
            15 => "FIFTEEN",
            16 => "SIXTEEN",
            17 => "SEVENTEEN",
            18 => "EIGHTEEN",
            19 => "NINETEEN",
            "014" => "FOURTEEN"
        );
        $tens = array(
            0 => "ZERO",
            1 => "TEN",
            2 => "TWENTY",
            3 => "THIRTY",
            4 => "FORTY",
            5 => "FIFTY",
            6 => "SIXTY",
            7 => "SEVENTY",
            8 => "EIGHTY",
            9 => "NINETY"
        );
        $hundreds = array(
            "مائة",
            "الآف",
            "ملايين",
            "بلايين",
            "TRILLION",
            "QUARDRILLION"
        ); /*limit t quadrillion */
        $num = number_format($num, 2, ".", ",");
        $num_arr = explode(".", $num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(",", $wholenum));
        krsort($whole_arr, 1);
        $rettxt = "";
        foreach ($whole_arr as $key => $i) {

            while (substr($i, 0, 1) == "0")
                $i = substr($i, 1, 5);
            if ($i < 20) {
                /* echo "getting:".$i; */
                $rettxt .= $ones[$i];
            } elseif ($i < 100) {
                if (substr($i, 0, 1) != "0") $rettxt .= $tens[substr($i, 0, 1)];
                if (substr($i, 1, 1) != "0") $rettxt .= " " . $ones[substr($i, 1, 1)];
            } else {
                if (substr($i, 0, 1) != "0") $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
                if (substr($i, 1, 1) != "0") $rettxt .= " " . $tens[substr($i, 1, 1)];
                if (substr($i, 2, 1) != "0") $rettxt .= " " . $ones[substr($i, 2, 1)];
            }
            if ($key > 0) {
                $rettxt .= " " . $hundreds[$key] . " ";
            }
        }
        if ($decnum > 0) {
            $rettxt .= " and ";
            if ($decnum < 20) {
                $rettxt .= $ones[$decnum];
            } elseif ($decnum < 100) {
                $rettxt .= $tens[substr($decnum, 0, 1)];
                $rettxt .= " " . $ones[substr($decnum, 1, 1)];
            }
        }
        return $rettxt;
    }


    public function ApplyFunctions($content, $id = 0)
    {

        $test = true;
        if (Contract1Controller::$Arabic == null) {
            $test = false;
            Contract1Controller::$Arabic = new I18N_Arabic("Numbers");
        }
        $pattern2 = "/sys_func[^!]+/i";
        $found_matches2 = [];

        if (preg_match_all($pattern2, $content, $matches2)) {
            $found_matches2 = $matches2[0];
        }


        $flag = false;
        for ($x = 0; $x < sizeof($found_matches2); $x++) {

            $found_matches2ToReplace[$x] = $found_matches2[$x];
            $found_matches2[$x] = strip_tags($found_matches2[$x]);
            $found_matches2[$x] = str_replace(array('&nbsp;', "<p>", "</p>", ""), '', $found_matches2[$x]);
            $resStr = str_replace(array("\n", "\t", "\r", ""), '', $found_matches2[$x]);
            $strpos = stripos($resStr, ' ');
            if ($strpos > 0 && !str_contains($found_matches2[$x], "sys_func_cal")) {
                $resStr = substr($resStr, 0, $strpos);
                $found_matches2[$x] = substr($found_matches2[$x], 0, $strpos);
            }


            $fun_name = str_replace("sys_func_", "", $resStr);
            $fun_value = explode('(', $fun_name);


            $To = '';
            if (count($fun_value)) {
                if ($fun_value[0] == "number_to_alpha") {


                    if ($fun_value[1] == "cal") {
                        $flag = true;
                        $val = str_replace(")", "", $fun_value[2]);
                        $val = trim($val);
                        $To = eval('return ' . $val . ';');
                        //continue;
                    } else if (isset($fun_value[2]) && $fun_value[2] == "cal") {
                        $flag = true;
                        $val = str_replace(")", "", $fun_value[3]);
                        $val = trim($val);
                        $To = eval('return ' . $val . ';');
                        //continue;
                    } else {

                        $summation = ((float)$fun_value[1] || (float)$fun_value[1] == 0) ? (float)$fun_value[1] : (float)$fun_value[2];
                        $val = $this->str_replace_first('!', '', $summation);
                        //    $val = str_replace(',', '', $val);
                        $val = (float)trim($val);
                        // Contract1Controller::$Arabic->setFeminine(1);
                        // Contract1Controller::$Arabic->setFormat(1);


                        $To = Contract1Controller::$Arabic->int2str($val);

                    }

                } else if ($fun_value[0] == "current_date") {
                    $To = date("Y-m-d");
                } else if ($fun_value[0] == "selected_currency") {
                    $val = trim($fun_value[1]);
                    $To = $this->getCurrentCurrency($val);
                } else if ($fun_value[0] == "selected_currency_symbol") {
                    $val = trim($fun_value[1]);
                    $To = $this->getCurrentCurrencySymbol($val);
                } else if ($fun_value[0] == "cal") {
                    $val = trim($fun_value[1]);
                    $val = str_replace(")", "", $val);


                    $To = eval('return ' . $val . ';');

                } else if ($fun_value[0] == "parking_payment") {
                    $payments = ParkingStoragePayment::where('target', 'parking')->where('target_id', $id)->get();

                    if (count($payments) > 0) {
                        $lastContent = "تفاصيل الدفعات للموقف هي :";
                        for ($i = 0; $i < count($payments); $i++) {
                            $lastContent = $lastContent . '</br>';
                            $lastContent = $lastContent . ($i + 1) . "- " . number_format($payments[$i]->amount) . " في تاريخ  " . $payments[$i]->payment_date . " , ش.ج. </br>";
                        }


                        $To = $lastContent;

                    } else {
                        $To = 'لا يوجد دفعات';
                    }
                } else if ($fun_value[0] == "storage_payment") {
                    $payments = ParkingStoragePayment::where('target', 'storage')->where('target_id', $id)->get();

                    if (count($payments) > 0) {
                        $lastContent = "تفاصيل الدفعات للموقف هي :";
                        for ($i = 0; $i < count($payments); $i++) {
                            $lastContent = $lastContent . '</br>';
                            $lastContent = $lastContent . ($i + 1) . "- " . number_format($payments[$i]->amount) . " في تاريخ  " . $payments[$i]->payment_date . " , ش.ج. </br>";
                        }


                        $To = $lastContent;

                    } else {
                        $To = 'لا يوجد دفعات';
                    }
                }

            }


            $content = $this->str_replace_first($found_matches2ToReplace[$x] . '!', $To, $content);
            $content = $this->str_replace_first($found_matches2ToReplace[$x] . '!)', $To, $content);
            $content = $this->str_replace_first($found_matches2ToReplace[$x], $To, $content);
        }

        if ($flag) {
            $content = $this->ApplyFunctions($content);
        }

        $content = str_replace('!', '', $content);
        return $content;
    }

    public function previewFunctionInContract($content, $unitID)
    {
        if (Contract1Controller::$Arabic == null) {
            Contract1Controller::$Arabic = new I18N_Arabic("Numbers");
        }

        $pattern2 = "/sys_func[^!]+/i";
        $found_matches2 = [];
        if (preg_match_all($pattern2, $content, $matches2)) {
            $found_matches2 = $matches2[0];
        }


        for ($x = 0; $x < sizeof($found_matches2); $x++) {
            $found_matches2ToReplace[$x] = $found_matches2[$x];
            $found_matches2[$x] = strip_tags($found_matches2[$x]);
            $found_matches2[$x] = str_replace(array('&nbsp;', "<p>", "</p>", " "), '', $found_matches2[$x]);


            $resStr = str_replace(array("\n", "\t", "\r", ""), '', $found_matches2[$x]);
            $strpos = stripos($resStr, ' ');
//            if ($strpos > 0 && !str_contains($found_matches2[$x], "sys_func_cal")) {
//                $resStr = substr($resStr, 0, $strpos);
//                $found_matches2[$x] = substr($found_matches2[$x], 0, $strpos);
//            }


            $ele = '<span data-attr="' . $resStr . '"></span>';

            $fun_name = str_replace("sys_func_", "", $resStr);
            $fun_value = explode('(', $fun_name);

            $To = '';
            if (count($fun_value)) {

                if ($fun_value[0] == "number_to_alpha") {

                    if (trim($fun_value[1]) == "cal") {

                        $exp = str_replace('(', '', $fun_value[2]);
                        $exp = str_replace(')', '', $exp);
                        $exp = str_replace(',', '', $exp);

                        $val = eval('return ' . $exp . ';');

                        $To = '<span class="translatePrices underline" data-attr="' . $val . '">القيمة بالكلمات</span>';

                    } else {

                        $attrName = str_replace("sys_var", "", $fun_value[1]);
                        $attrName = str_replace(")", "", $attrName);

                        if ($attrName == 0) {
                            $To = '<span>صفر</span>';
                        } else {
                            $To = '<span class="translatePrices" data-attr="' . $attrName . '">القيمة بالكلمات</span>';
                        }

                    }


                } else if ($fun_value[0] == "current_date") {
                    $To = date("Y/m/d");
                } else if ($fun_value[0] == "selected_currency") {
                    $val = $this->getCurrencyOfUnit($unitID);
                    $To = $this->getCurrentCurrency($val);
                    // $To = '<span class="selected_currency">العملة المختارة</span>';
                } else if ($fun_value[0] == "selected_currency_symbol") {
                    $val = $this->getCurrencyOfUnit($unitID);
                    $To = $this->getCurrentCurrencySymbol($val);
                    // $To = '<span class="selected_currency">العملة المختارة</span>';
                } else if ($fun_value[0] == "cal") {

                    $attrsName = str_replace("sys_var", "", $fun_value[1]);

                    $attrsName = str_replace('(', '', $attrsName);
                    $attrsName = str_replace(')', '', $attrsName);
                    $attrsName = str_replace(',', '', $attrsName);


                    $To = number_format(eval('return ' . $attrsName . ';'));


                    //$To = '<span class="cal" data-attr="' . $attrsName . '">عمليه حسابيه</span>';
                } else if ($fun_value[0] == "payments") {
                    $paymentController = new Payments1Controller($this->_app);
                    $payments = json_decode($paymentController->getPayment($unitID));

                    if (count($payments) > 0) {
                        $lastContent = "";
                        for ($i = 0; $i < count($payments); $i++) {
                            $lastContent = $lastContent . '</br>';

                            if ($i == 0) {
                                $lastContent = $lastContent . ($i + 1) . "- " . "يتم دفع مبلغ كدفعة أولى وقدره " . number_format($payments[$i]->amount) . " ش.ج., في تاريخ " . $payments[$i]->payment_date . ", حتى 7 أيام من تاريخ توقيع هذه الاتفاقية." . "</br>";
                                //document.getElementById('payment_details').innerHTML = msg;

                            } else if ($i == count($payments) - 1) {
                                $lastContent = $lastContent . ($i + 1) . "- " . "يتم دفع مبلغ وقدره " . number_format($payments[$i]->amount) . " ش.ج., في تاريخ " . $payments[$i]->payment_date . ", حتى 7 أيام قبل تاريخ التسليم المتفق المتوقع." . "</br></br>";
                                //document.getElementById('payment_details').innerHTML = msg;
                            } else {
                                $lastContent = $lastContent . ($i + 1) . "- " . "يتم دفع مبلغ وقدره " . number_format($payments[$i]->amount) . " ش.ج., في تاريخ " . $payments[$i]->payment_date . "</br>";
                                //document.getElementById('payment_details').innerHTML = msg;
                            }
                        }


                        $To = $lastContent;

                    } else {
                        $To = 'لا يوجد دفعات';

                    }
                } else if ($fun_value[0] == "payments2") {
                    $To = $this->getPayments($unitID);
                }

            }

            //echo $found_matches2ToReplace[$x].'    ';

            $content = $this->str_replace_first($found_matches2ToReplace[$x] . '!', $To, $content);
        }

        $content = str_replace(')!', '', $content);

        return $content;

    }

    public function getCurrentCurrency($currency)
    {
        if ($currency == "$") {
            return 'دولار';
        } else if ($currency == "Nis") {
            return 'شيكل';
        }

        return '';
    }

    public function getCurrentCurrencySymbol($currency)
    {
        if ($currency == "$") {
            return '$';
        } else if ($currency == "Nis") {
            return 'ILS';
        }

        return '';
    }

    public function getCurrencyOfUnit($unitId)
    {
        $unit = Unit::find($unitId);
        $reservation = $unit->reservations($unitId);
        if (count($reservation)) {
            $reservation_id = $reservation[0]['reservation_id'];
            $reservedUnit = Reservation::find($reservation_id);
            return $reservedUnit['currency'];
        }
        return '';
    }

    public function getContractCount($type)
    {
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contracts` where `type` = '" . $type . "' order by `id` desc limit 1";
        $result = mysqli_query($conn, $query);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return (int)$row['count'] + 1;
        } else {
            return 1;
        }
    }


//    public function applyFuncOnContract($content, $json)
//    {
//        $dom = new DOMDocument;
//        $dom->loadHTML($content);
//        $selector = new DOMXPath($dom);
//        $result = $selector->query('//span[@class="translatePrices"]');
//        foreach($result as $node) {
//            echo $node->getAttribute('data-attr');
//        }
//    }
    public function retryParsingStorage($found_matches, $reservation, $storage, $unit, $content)
    {

        for ($x = 0; $x < sizeof($found_matches); $x++) {
            $found_matches[$x] = str_replace(array('&nbsp;', "<p>", "</p>", ""), '', $found_matches[$x]);
            $resStr = str_replace(array("\n", "\t", "\r", ""), '', $found_matches[$x]);
            $strpos = stripos($resStr, ' ');
            if ($strpos > 0)
                $resStr = substr($resStr, 0, $strpos);

            $attribute_name = str_replace("sys_var_reservation_", "", $resStr);
            $prefix = "reservation_";
            if (str_contains($attribute_name, 'sys_var_storage_')) {
                $attribute_name = str_replace("sys_var_storage_", "", $resStr);
                $prefix = "storage_";
            } else if (str_contains($attribute_name, 'sys_var_unit_')) {
                $attribute_name = str_replace("sys_var_unit_", "", $resStr);
                $prefix = "unit_";
            }
//                echo $prefix.' ';
//                echo $attribute_name.' ';
            $attribute_name = explode('_type', $attribute_name)[0];
//                echo $x.' ';

            $To = '';
            if ($attribute_name == "sys_var_contract_count") {
                $To = (int)$this->getContractCount('Appendix/Storage');
            } else if ($prefix == "reservation_" && isset($reservation[$attribute_name])) {
                $To = $reservation[$attribute_name];
            } else if ($prefix == "storage_" && isset($storage[$attribute_name])) {
                //  echo $attribute_name.'  /  ';
                $To = $storage[$attribute_name];
                //  echo $To.'   //  ';
                //   echo $found_matches[$x].'   ///  ';

            } else if ($prefix == "unit_" && isset($unit[$attribute_name])) {
                $To = $unit[$attribute_name];
            }

            $content = $this->str_replace_first($found_matches[$x], $To, $content);
        }
        //   echo $content;

        return $content;
    }

    public function retryParsingParking($found_matches, $reservation, $parking, $unit, array $content)
    {
        for ($x = 0; $x < sizeof($found_matches); $x++) {
            $found_matches[$x] = str_replace(array('&nbsp;', "<p>", "</p>", ""), '', $found_matches[$x]);
            $resStr = str_replace(array("\n", "\t", "\r", ""), '', $found_matches[$x]);
            $strpos = stripos($resStr, ' ');
            if ($strpos > 0)
                $resStr = substr($resStr, 0, $strpos);

            $attribute_name = str_replace("sys_var_reservation_", "", $resStr);
            $prefix = "reservation_";
            if (str_contains($attribute_name, 'sys_var_parking_')) {
                $attribute_name = str_replace("sys_var_parking_", "", $resStr);
                $prefix = "parking_";
            } else if (str_contains($attribute_name, 'sys_var_unit_')) {
                $attribute_name = str_replace("sys_var_unit_", "", $resStr);
                $prefix = "unit_";
            }
            // echo $attribute_name;
            $attribute_name = explode('_type', $attribute_name)[0];
//                echo $x.' ';

            $To = '';
            if ($attribute_name == "sys_var_contract_count") {
                $To = (int)$this->getContractCount('Appendix/Parking');
            } else if ($prefix == "reservation_" && isset($reservation[$attribute_name])) {
                $To = $reservation[$attribute_name];
            } else if ($prefix == "parking_" && isset($parking[$attribute_name])) {
                $To = $parking[$attribute_name];
            } else if ($prefix == "unit_" && isset($unit[$attribute_name])) {
                $To = $unit[$attribute_name];
            }

            $content = $this->str_replace_first($found_matches[$x], $To, $content);
        }

        return $content;
    }

    public function getParkingInformationforUnit($unitId)
    {
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");
        $parking = [];

        $query = "SELECT * FROM `parking_storage_reservation` where `uid` = " . $unitId . " and `type` = 'parking' order by `reservation_date` desc";

        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $parkingId = $row['parking_storage_id'];

            $query = " SELECT * FROM `parking` WHERE `id` = " . $parkingId;
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $parking['rawabi_code'] = $row["rawabi_code"];
                $parking['parking_number'] = $row["parking_number"];
                $parking['neighporhood'] = $row["neighporhood"];
                $parking['price'] = $row["price"];
                $parking['available'] = $row["available"];
                $parking['building'] = $row["building"];
                $parking['description'] = $row["description"];
                $parking['floor'] = $row["floor"];
                $parking['id'] = $row["id"];
            }
        }


        return $parking;

    }

    public function getStorageInformationforUnit($unitId)
    {
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");
        $storage = [];

        $query = "SELECT * FROM `parking_storage_reservation` where `uid` = " . $unitId . " and `type` = 'storage' order by `reservation_date` desc";

        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $storageId = $row['parking_storage_id'];

            $query = " SELECT * FROM `storages` WHERE `id` = " . $storageId;
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $storage['rawabi_code'] = $row["rawabi_code"];
                $storage['storage_number'] = $row["storage_number"];
                $storage['neighporhood'] = $row["neighporhood"];
                $storage['price'] = $row["price"];
                $storage['available'] = $row["available"];
                $storage['building'] = $row["building"];
                $storage['tabu_description'] = $row["tabu_description"];
                $storage['floor'] = $row["floor"];
                $storage['id'] = $row["id"];

            }
        }

        return $storage;

    }

    function getTextOfHtml($html)
    {
        $index1 = strpos($html, '<span');
        $index2 = strpos($html, "</span>");

        return strip_tags(substr($html, $index1, $index2));
    }

    function filteration($html)
    {
        $index1 = strpos($html, '<a');
        $index2 = strpos($html, "</a>");

        return substr($html, $index1, $index2 + 4);
    }


    function testForRawabiContract2()
    {
        $db_connection_string = $this->_app->environment()["db_connection"];

        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contracts_templates` where `templateName` = 'عقد إيجار منتهي بخيار التملك' and `status` = 'ACTIVE'";
        $result = mysqli_query($conn, $query);
        $template_id = 0;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $contentCopy = $row['content'];
            $content = $row['content'];
            $template_id = $row['id'];
            $pattern = "/sys_var[^\s]+/i";
            $found_matches = [];
            if (preg_match_all($pattern, $content, $matches)) {
                $found_matches = $matches[0];
            }


            $contracts2_unit = contract2_unit::all();

            foreach ($contracts2_unit as $contract) {
                $unit_id = $contract->unit_id;
                $contract_id = $contract->contract2_id;
                $contract2 = Contract2::find($contract_id);
                $unit = Unit::find($unit_id);
                $haiName = $contract2['r_haiName'];
                $Neighborhood = Neighborhoods::where('haiArabicName', $haiName)->first();


                if ($contract2['renter2'] == "") {
                    $contract2['renter'] = $contract2['renter1'];
                    $contract2['r_idNum'] = $contract2['renter1'];
                } else {
                    $contract2['renter'] = $contract2['renter1'] . ' , ' . $contract2['renter2'];
                    if ($contract2['r_idNum2'] == "") {
                        $contract2['r_idNum'] = $contract2['r_idNum1'] . ' , ' . $contract2['r_idNum2'];
                    } else {
                        $contract2['r_idNum'] = $contract2['r_idNum1'];
                    }
                }


                if ($contract2) {

                    $content = $contentCopy;

                    for ($x = 0; $x < sizeof($found_matches); $x++) {
                        $found_matches[$x] = str_replace(array('&nbsp;', "<p>", "</p>", ""), '', $found_matches[$x]);
                        $resStr = str_replace(array("\n", "\t", "\r", ""), '', $found_matches[$x]);
                        $strpos = stripos($resStr, ' ');
                        if ($strpos > 0)
                            $resStr = substr($resStr, 0, $strpos);

                        $attribute_name = str_replace("sys_var_", "", $resStr);
                        $attribute_name = explode('_type', $attribute_name)[0];

                        if (str_contains($attribute_name, 'unit_')) {
                            $attribute_name = str_replace("unit_", "", $attribute_name);
                        }

                        $To = '';

                        if (isset($contract2[$attribute_name])) {
                            $To = $contract2[$attribute_name];
                        }
                        if (isset($unit[$attribute_name])) {
                            $To = $unit[$attribute_name];
                        }
                        if (isset($Neighborhood[$attribute_name])) {
                            $To = $Neighborhood[$attribute_name];
                        }

                        $content = $this->str_replace_first($found_matches[$x], $To, $content);
                    }


                    $content = $this->ApplyFunctions($content);

                    $query = "UPDATE `contracts` SET `status`='ARCHIVED' WHERE unit_id = " . $unit_id;
                    $conn->query($query);
                    $query = "INSERT INTO `contracts`( `content`, `user_id`, `template_id`, `unit_id`, `status`, `created_at`, `type`, `json`, `count`) VALUES ('" . htmlspecialchars_decode($content) . "', '" . $_SESSION['userfrosting']['user_id'] . "', '" . $template_id . "', " . $unit_id . ", '" . 'ACTIVE' . "', '" . date("Y/m/d h:i:s") . "', 'purchase_contract', '', " . $this->getContractCount('purchase_contract') . " )";
                    $conn->query($query);

                }
            }

        } else {
            echo 'no data';
        }
    }

    function testForRawabiReceipt()
    {
        $db_connection_string = $this->_app->environment()["db_connection"];

        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contracts_templates` where `templateName` = 'نسخ من الإيصال' and `status` = 'ACTIVE'";
        $result = mysqli_query($conn, $query);
        $template_id = 0;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $contentCopy = $row['content'];
            $content = $row['content'];
            $template_id = $row['id'];
            $pattern = "/sys_var[^\s]+/i";
            $found_matches = [];
            if (preg_match_all($pattern, $content, $matches)) {
                $found_matches = $matches[0];
            }


            $reservation_unit = ReservationUnit::all();

            foreach ($reservation_unit as $reservation) {
                $unit_id = $reservation->unit_id;
                $reservation_id = $reservation->reservation_id;
                $data = Reservation::find($reservation_id);
                $unit = Unit::find($unit_id);


                if ($data) {

                    $content = $contentCopy;

                    for ($x = 0; $x < sizeof($found_matches); $x++) {
                        $found_matches[$x] = str_replace(array('&nbsp;', "<p>", "</p>", ""), '', $found_matches[$x]);
                        $resStr = str_replace(array("\n", "\t", "\r", ""), '', $found_matches[$x]);
                        $strpos = stripos($resStr, ' ');
                        if ($strpos > 0)
                            $resStr = substr($resStr, 0, $strpos);

                        $attribute_name = str_replace("sys_var_", "", $resStr);
                        $attribute_name = explode('_type', $attribute_name)[0];

                        if (str_contains($attribute_name, 'unit_')) {
                            $attribute_name = str_replace("unit_", "", $attribute_name);
                        }

                        $To = '';

                        if (isset($data[$attribute_name])) {
                            $To = $data[$attribute_name];
                        }
                        if (isset($unit[$attribute_name])) {
                            $To = $unit[$attribute_name];
                        }

                        $content = $this->str_replace_first($found_matches[$x], $To, $content);
                    }


                    $content = $this->ApplyFunctions($content);


                    $query = "UPDATE `contracts` SET `status`='ARCHIVED' WHERE unit_id = " . $unit_id;
                    $conn->query($query);
                    $query = "INSERT INTO `contracts`( `content`, `user_id`, `template_id`, `unit_id`, `status`, `created_at`, `type`, `json`, `count`) VALUES ('" . htmlspecialchars_decode($content) . "', '" . $_SESSION['userfrosting']['user_id'] . "', '" . $template_id . "', " . $unit_id . ", '" . 'ACTIVE' . "', '" . date("Y/m/d h:i:s") . "', 'reservation_receipt', '', " . $this->getContractCount('reservation_receipt') . " )";
                    $conn->query($query);

                }
            }

        } else {
            echo 'no data';
        }
    }

    public function getParkingStorageCode($item)
    {
        if (isset($item["storage"]['id'])) {
            $storage = Storage::where('id', $item["storage"]['id'])->first();
            if (!$storage) {
                return "";
            }
            return $storage->rawabi_code;
        } else if (isset($item["parking"]['id'])) {
            $parking = Parking::where('id', $item["parking"]['id'])->first();
            if (!$parking) {
                return "";
            }
            return $parking->rawabi_code;
        }

        return "";
    }

    public function getInput($type, $attribute_name, $value = '', $size = 20)
    {
        if ($type == "text") {
            return '<a id="0_div_type_text" class="attrr" style="display: inline; color: inherit;" name="' . $attribute_name . '"><input name="' . $attribute_name . '" type="text" value="' . $value . '" size="' . $size . '"/></a>';
        } else if ($type == "date") {
            return '<a id="0_div_type_date" class="attrr" style="display: inline; color: inherit;" name="' . $attribute_name . '"><input name="' . $attribute_name . '" type="date" value="' . $value . '" size="' . $size . '"/></a>';
        } else if ($type == "number") {
            return '<a id="0_div_type_number" class="attrr" style="display: inline; color: inherit;" name="' . $attribute_name . '"><input name="' . $attribute_name . '" type="number" value="' . $value . '" size="' . $size . '"/></a>';
        }

        return '';
    }

    public function getPayments($unitID)
    {
        if (Contract1Controller::$Arabic == null) {
            Contract1Controller::$Arabic = new I18N_Arabic("Numbers");
        }

        $paymentController = new Payments1Controller($this->_app);
        $payments = json_decode($paymentController->getPayment($unitID));

        if (count($payments) > 0) {
            $lastContent = "<p id='payments' style='font-family: Yakout Linotype Light, sans-serif; color: #44546a;'>";


            for ($i = 1; $i < count($payments); $i++) {
                $lastContent = $lastContent . '</br>';


                $lastContent = $lastContent . ($i) . ") " . "يدفع الفرق الثاني للفريق الأول الدفعة " .


                    '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>'
                    . $this->arabicNumberInWordForPayment[$i] .
                    '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span> ،' .
                    'والبالغة ' .
                    '( <span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>'
                    . number_format($payments[$i]->amount) .
                    '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span> $)' .
                    '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>' .
                    Contract1Controller::$Arabic->int2str($payments[$i]->amount) .
                    '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>' .
                    " دولار أمريكي فقط, وذلك بتاريخ" .
                    '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>' .
                    $payments[$i]->payment_date .
                    '<span lang="AR-SA" style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;" data-mce-style="font-family: Yakout Linotype Light, sans-serif; color: #92d050;">&nbsp;----</span>' .
                    "</br>";
            }

            if ($i == 11 || $i == 29 || $i == 47 || $i == 65 || $i == 83 || $i == 101 || $i == 119 ) {
                $lastContent = $lastContent . '<p class="pagebreak"><br></p>';
            }

            $To = $lastContent;

        } else {
            $To = 'لا يوجد دفعات';
        }

        return $To;
    }

    public function getTotalPrice($unit_id)
    {
        $reservation_unit = ReservationUnit::where('unit_id', $unit_id)->first();
        if ($reservation_unit) {
            $reservation = Reservation::where('id', $reservation_unit->reservation_id)->first();
            if ($reservation) {
                $totalPrice = $reservation->total_price;
                return $totalPrice;
            }
        }
        return 0;
    }

}
