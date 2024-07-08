<?php

namespace UserFrosting;

class Contract2Controller extends \UserFrosting\BaseController {

    protected static $_table_id = "contract2";

    /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }

    public function createContract2()
    {
        // Fetch the POSTed data
        $post = $this->_app->request->post();
        // Load the request schema
        // $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/reservation-create.json");

        //  // Get the alert message stream
        //  $ms = $this->_app->alerts;

        //  // Set up Fortress to process the request
        //  $rf = new \Fortress\HTTPRequestFortress($ms, $requestSchema, $post);

        //  // Sanitize
        //  $rf->sanitize();

        // Validate, and halt on validation errors.
        // if (!$rf->validate()) {
        //     $this->_app->halt(400);
        // }

        // Get the filtered data
        // $data = $rf->data();

        //create new reservation
        $new_contract2 = new Contract2([
            "contract2Date" => $post['contract2Date'],
            "baytiCompanyNumber" => $post['baytiCompanyNumber'],
            "systemUser2" => $post['systemUser2'],
            "renter1" => $post['renter1'],
            "r_idType1" => $post['r_idType1'],
            "r_idNum1" => $post['r_idNum1'],
            "r_idPlace1" => ' '.$post['r_idPlace1'].' ',
            "r_idProDate1" => $post['r_idProDate1'],
            "r_idExpDate1" => $post['r_idExpDate1'],
            "r_country1" => $post['r_country1'],
            "r_city1" => $post['r_city1'],
            "r_regionName1" => $post['r_regionName1'],
            "r_streetName1" => $post['r_streetName1'],
            "r_homePhone1" => $post['r_homePhone1'],
            "r_workPhone1" => $post['r_workPhone1'],
            "r_mobileNum1" => $post['r_mobileNum1'],
            "r_faxNum1" => $post['r_faxNum1'],
            "r_mailBox1" => $post['r_mailBox1'],
            "r_postalCode1" => $post['r_postalCode1'],
            "r_eMail1" => $post['r_eMail1'],
            "renter2" => $post['renter2'],
            "r_idNum2" => $post['r_idNum2'],
            "r_idType2" => $post['r_idType2'],
            "r_idPlace2" => ' '.$post['r_idPlace2'].' ',
            "r_idProDate2" => $post['r_idProDate2'],
            "r_idExpDate2" => $post['r_idExpDate2'],
            "r_country2" => $post['r_country2'],
            "r_city2" => $post['r_city2'],
            "r_regionName2" => $post['r_regionName2'],
            "r_streetName2" => $post['r_streetName2'],
            "r_homePhone2" => $post['r_homePhone2'],
            "r_workPhone2" => $post['r_workPhone2'],
            "r_mobileNum2" => $post['r_mobileNum2'],
            "r_faxNum2" => $post['r_faxNum2'],
            "r_mailBox2" => $post['r_mailBox2'],
            "r_postalCode2" => $post['r_postalCode2'],
            "r_eMail2" => $post['r_eMail2'],
            "r_unitNum" => $post['r_unitNum'],
            "r_unitArea" => $post['r_unitArea'],
            "r_haiName" => $post['r_haiName'],
            "r_floorNum" => $post['r_floorNum'],
            "r_landNum" => $post['r_landNum'],
            "r_hawdNum" => $post['r_hawdNum'],
            "r_hawdName" => $post['r_hawdName'],
            "r_buildingNum" => $post['r_buildingNum'],
            "r_buildingsNum" => $post['r_buildingsNum'],
            "r_unitDesc" => $post['r_unitDesc'],
            "rentPeriod" => $post['rentPeriod'],
            "rentPrice" => $post['rentPrice'],
            "releasePeriod" => $post['releasePeriod'],
            "startRentDate" => $post['startRentDate'],
            "endRentDate" => $post['endRentDate'],
            "r_totalPrice" => $post['r_totalPrice'],
            "yy" => $post['yy'],
            "paymentAPeriod" => $post['paymentAPeriod'],
            "paymentA" => $post['paymentA'],
            "fromDateA" => $post['fromDateA'],
            "toDateA" => $post['toDateA'],
            "paymentBPeriod" => $post['paymentBPeriod'],
            "paymentB" => $post['paymentB'],
            "fromDateB" => $post['fromDateB'],
            "toDateB" => $post['toDateB'],
            "paymentCPeriod" => $post['paymentCPeriod'],
            "paymentC" => $post['paymentC'],
            "fromDateC" => $post['fromDateC'],
            "toDateC" => $post['toDateC'],
            "checksNum" => $post['checksNum'],
            "sponsorName" => $post['sponsorName'],
            "sponsorIdNum" => $post['sponsorIdNum'],
            "sponsorMobile" => $post['sponsorMobile'],
            "sponsorAddress" => $post['sponsorAddress'],
            "r_HAO_num" => $post['r_HAO_num'],
            "r_HAO_date" => $post['r_HAO_date'],
            "r_companyName" => $post['r_companyName'],
            "r_companyFor" => $post['r_companyFor'],
            "r_companyNum" => $post['r_companyNum'],
            "r_haiArea" => $post['r_haiArea'],
            "extraAdditions" => $post['extraAdditions'],
            "r_showContract3Dates" => $post['r_showContract3Dates']
        ]);

        $new_contract2->save();
        //create many to many table with contract2_unit
        $unit = Unit::find($post['uid']);
        $new_contract2->units()->attach($unit->id);
    }

    public function  getContract2($id){
      $unit = Unit::find($id);
      $contract2_id=$unit->contracts2($id)[0]['contract2_id'];
      $contract2=Contract2::find($contract2_id);

      $haiName =  $contract2['r_haiName'];
      $Neighborhood = Neighborhoods::where('haiArabicName',$haiName)->first();
      $contract2['estContrNum'] = $Neighborhood['estContrNum'];
      $contract2['estContrNum2'] = $Neighborhood['estContrNum2'];
      $contract2['estContrDate'] = $Neighborhood['estContrDate'];
      $contract2['estContrDate2'] = $Neighborhood['estContrDate2'];

      return $contract2;

    }
  public function  getfinalserial($previd){
//      $unit = Unit::find($previd);
//      $contract2_id=$unit->contracts2($previd)[0]['contract2_id'];
      $contract2=Contract2::find($previd);
      return $contract2;
    }


      public function updateserial(){
        $post = $this->_app->request->post();

      //  $contract2_id=$post['uid'];
        $contract2=Contract2::find($post['uid']);

        $contract2["serialNumberFinal"]= $post['final'];
		$contract2["serialNumberInit"] = $post['init'];
        $contract2->save();
      }


    public function updateContract2(){
        $post = $this->_app->request->post();

        $contract2_id=$post['uid'];
        $contract2=Contract2::find($contract2_id);
        echo($contract2);
        $contract2["baytiCompanyNumber"]= $post['baytiCompanyNumber'];
		$contract2["systemUser2"] = $post['systemUser2'];
		$contract2["renter1"] = $post['renter1'];
        $contract2["r_idType1"] = $post['r_idType1'];
		$contract2["r_idNum1"] = $post['r_idNum1'];
		$contract2["r_idPlace1"] = $post['r_idPlace1'];
		$contract2["r_idProDate1"]= $post['r_idProDate1'];
        $contract2["r_idExpDate1"]= $post['r_idExpDate1'];
        $contract2["r_country1"] = $post['r_country1'];
        $contract2["r_city1"] = $post['r_city1'];
        $contract2["r_regionName1"] = $post['r_regionName1'];
        $contract2["r_streetName1"] = $post['r_streetName1'];
        $contract2["r_homePhone1"] = $post['r_homePhone1'];
        $contract2["r_workPhone1"] = $post['r_workPhone1'];
        $contract2["r_mobileNum1"] = $post['r_mobileNum1'];
        $contract2["r_faxNum1"] = $post['r_faxNum1'];
        $contract2["r_mailBox1"] = $post['r_mailBox1'];
        $contract2["r_postalCode1"] = $post['r_postalCode1'];
        $contract2["r_eMail1"] = $post['r_eMail1'];
        $contract2["renter2"] = $post['purchaser2'];
        $contract2["r_idNum2"] = $post['r_idNum2'];
        $contract2["r_idType2"] = $post['r_idType2'];
        $contract2["r_idPlace2"] = $post['r_idPlace2'];
        $contract2["r_idProDate2"] = $post['r_idProDate2'];
        $contract2["r_idExpDate2"] = $post['r_idExpDate2'];
        $contract2["r_country2"] = $post['r_country2'];
        $contract2["r_city2"] = $post['r_city2'];
        $contract2["r_regionName2"] = $post['r_regionName2'];
        $contract2["r_streetName2"] = $post['r_streetName2'];
        $contract2["r_homePhone2"] = $post['r_homePhone2'];
        $contract2["r_workPhone2"] = $post['r_workPhone2'];
        $contract2["r_mobileNum2"] = $post['r_mobileNum2'];
        $contract2["r_faxNum2"] = $post['r_faxNum2'];
        $contract2["r_mailBox2"] = $post['r_mailBox2'];
        $contract2["r_postalCode2"] = $post['r_postalCode2'];
        $contract2["r_eMail2"] = $post['r_eMail2'];
        $contract2["rentPeriod"] = $post['rentPeriod'];
        $contract2["rentPrice"] = $post['rentPrice'];
        $contract2["releasePeriod"] = $post['releasePeriod'];
        $contract2["startRentDate"] = $post['startRentDate'];
        $contract2["endRentDate"] = $post['endRentDate'];
        $contract2["r_totalPrice"] = $post['r_totalPrice'];
        $contract2["yy"] = $post['yy'];
        $contract2["paymentAPeriod"] = $post['paymentAPeriod'];
        $contract2["paymentA"] = $post['paymentA'];
        $contract2["fromDateA" ]= $post['fromDateA'];
        $contract2["toDateA"] = $post['toDateA'];
        $contract2["paymentBPeriod"] = $post['paymentBPeriod'];
        $contract2["paymentB"] = $post['paymentB'];
        $contract2["fromDateB"] = $post['fromDateB'];
        $contract2["toDateB"] = $post['toDateB'];
        $contract2["paymentCPeriod"] = $post['paymentCPeriod'];
        $contract2["paymentC"] = $post['paymentC'];
        $contract2["fromDateC"] = $post['fromDateC'];
        $contract2["toDateC"]= $post['toDateC'];
        $contract2["sponsorName"]= $post['sponsorName'];
        $contract2["sponsorIdNum"]= $post['sponsorIdNum'];
        $contract2["sponsorMobile"]= $post['sponsorMobile'];
        $contract2["sponsorAddress"]= $post['sponsorAddress'];
        $contract2['r_companyName']=$post['r_companyName'];
        $contract2['r_companyNum']=$post['r_companyNum'];
        $contract2['r_companyFor']=$post['r_companyFor'];
        $contract2['checksNum']=$post['checksNum2'];
        $contract2['additions']=$post['additions'];
        $contract2['r_showContract3Dates']=$post['r_showContract3Dates'];
        $contract2->save();
    }

    public function getcontract2Template(){
        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully" . '<br/>';

        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contract2_content`";
        $result = $conn->query($query);



        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->_app->render('contract/contract2.twig', [
                "contractsections" => $row
            ]);

        } else {
            echo "0 results";
        }

    }

    public function updateContract2Content(){
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

        $query = "UPDATE `contract2_content` SET `" . $id . "`='" . $content . "'";
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

        $query = "SELECT * FROM `contract2_content`";
        $result = $conn->query($query);



        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;

        } else {
            echo "0 results";
        }
    }
}
