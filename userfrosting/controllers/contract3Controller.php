<?php
        
namespace UserFrosting;

class Contract3Controller extends \UserFrosting\BaseController { 

    protected static $_table_id = "contract3";
    
    /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }

    public function createContract3(){
        // Fetch the POSTed data

      $post = $this->_app->request->post();

      // Load the request schema
        $new_contract3 = new Contract3($post);
        $new_contract3->save();
        //create many to many table with contract2_unit
        $unit = Unit::find($post['uid']);
        $new_contract3->units()->attach($unit->id);
    }
    
    public function  getContract3($id){
      $unit = Unit::find($id);

      $contract3_id=$unit->contracts3($id)[0]['contract3_id'];

      $contract3=Contract3::find($contract3_id);

      $haiName =  $contract3['haiName'];
      $Neighborhood = Neighborhoods::where('haiArabicName',$haiName)->first();
      $contract3['estContrNum'] = $Neighborhood['estContrNum'];
      $contract3['estContrNum2'] = $Neighborhood['estContrNum2'];
      $contract3['estContrDate'] = $Neighborhood['estContrDate'];
      $contract3['estContrDate2'] = $Neighborhood['estContrDate2'];


      return $contract3;
  
    }
    
    public function updateContract3(){
        $post = $this->_app->request->post();

        $contract3_id=$post['uid'];
        $contract3=Contract3::find($contract3_id);
        unset($post['csrf_token']);
        unset($post['uid']);
        foreach ($post as $key => $value) {
          $contract3[$key] = $post[$key];
        }
        $contract3->save();
        
    }

    public function getcontract3Template(){
        // Create connection
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully" . '<br/>';

        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `contract3_content`";
        $result = $conn->query($query);



        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->_app->render('contract/contract3.twig', [
                "contractsections" => $row
            ]);

        } else {
            echo "0 results";
        }

    }

    public function updateContract3Content(){
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

        $query = "UPDATE `contract3_content` SET `" . $id . "`='" . $content . "'";
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

        $query = "SELECT * FROM `contract3_content`";
        $result = $conn->query($query);



        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;

        } else {
            echo "0 results";
        }
    }
}