<?php
require_once "Classes/PHPExcel.php";
$pathInPieces = explode('/', $_SERVER['SCRIPT_NAME']);
$init_path = $_SERVER['DOCUMENT_ROOT'] . "/" . $pathInPieces[1] . "/userfrosting/initialize.php";
require_once($init_path);
$urlInPieces = explode('/', $_SERVER['REQUEST_URI']);
$back_url = $_SERVER['HTTP_REFERER'];
if ($back_url == "") {
    $back_url = "http://$_SERVER[HTTP_HOST]/$urlInPieces[1]/public/uploadunits/";
}
$back_url = strtok($back_url, '?');
$success_message = "Updating units have been completed successfully!";
$error_message = "Error occurred during updating process, please check provided data";

if ($_FILES['userfile1']['size'] > 0) {

    //read the file contents
    $fileName = $_FILES['userfile1']['name'];
    $tmpName = $_FILES['userfile1']['tmp_name'];
    $fileSize = $_FILES['userfile1']['size'];
    $fileType = $_FILES['userfile1']['type'];

    //open the reader via PHPExecl
    $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpName);
    $excelObj = $excelReader->load($tmpName);
    $worksheet = $excelObj->getSheet(0);
    $lastRow = $worksheet->getHighestRow();

    $titles = [
        $worksheet->getCell('A1')->getValue(), // Neighborhood
        $worksheet->getCell('B1')->getValue(), // Gross Area
        $worksheet->getCell('C1')->getValue(), // Apartment code
        $worksheet->getCell('D1')->getValue(), // Building Code
        "description",
        // $worksheet->getCell('E1')->getValue(), // description
        $worksheet->getCell('F1')->getValue(), // price
        $worksheet->getCell('G1')->getValue(), // tabo code
        $worksheet->getCell('H1')->getValue(),  // UnitDescription
        $worksheet->getCell('I1')->getValue(),  // UnitDescription
        $worksheet->getCell('J1')->getValue(),
        $worksheet->getCell('K1')->getValue(),
    ];

    //$right_title = ['Neighborhood', 'Gross Area', 'Apartment code', 'Building Code', 'Photo Description', 'price',
      //  'tabo code', 'UnitDescription'];

    // Edited By AHmad Tome (convert column name from photo Description to description)
    $right_title = ['Neighborhood', 'Net Area', 'Apartment code', 'Building Code', 'description', 'price',
        'tabo code', 'UnitDescription','tabo_area', 'parking Number', 'storage Number'];
    $result = array_diff($titles, $right_title);

print_r($titles);
print_r($right_title);
print_r($result);

   // return ;
    if (!empty($result)) {
        header("Location: " . $back_url . "?error=1");
        exit();
    }

    //prepare server configuration
    $db = $app->config('db');
    $servername = $db['db_host'];
    $username = $db['db_user'];
    $password = $db['db_pass'];
    $dbname = $db['db_name'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");
    $success = 0;


    mysqli_set_charset($conn, "utf8");

    $parkingStorageFlag = 1;
    // validate parking Number and storage number
    for ($row = 2; $row <= $lastRow; $row++) {
        $parking_number = $worksheet->getCell('J' . $row)->getValue();
        $storage_number = $worksheet->getCell('K' . $row)->getValue();
        if ($parking_number != "") {
            $sql_query = "SELECT * FROM `parking` WHERE `parking_number` = ".$parking_number ;
            $result = mysqli_query($conn, $sql_query);
            if (!$result || $result->num_rows == 0) {
                $parkingStorageFlag = 0;
                break;
            }

        }

        if ($storage_number != "") {
            $sql_query = "SELECT * FROM `storages` WHERE `storage_number` ".$storage_number ;
            $result = mysqli_query($conn, $sql_query);
            if (!$result || $result->num_rows == 0) {
                $parkingStorageFlag = 0;
                break;
            }
        }
    }

    if ($parkingStorageFlag == 0) {
        header("Location: " . $back_url . "?error=1&message=".str_replace('$$',"<br>", "There is an issue with the parking Number and storage Number, Please review them "));
        exit();
    }






    //loop through the file contens to get the required fields
    for ($row = 2; $row <= $lastRow; $row++) {

        $neighborhood        = $worksheet->getCell('A' . $row)->getValue();
        $size                = $worksheet->getCell('B' . $row)->getValue();
        $rawabi_code         = $worksheet->getCell('C' . $row)->getValue();
        $buliding_type       = $worksheet->getCell('D' . $row)->getValue();
        $description         = $worksheet->getCell('E' . $row)->getValue();
        $price               = $worksheet->getCell('F' . $row)->getValue();
        $tapu_code           = $worksheet->getCell('G' . $row)->getValue();
        $unit_description    = $worksheet->getCell('H' . $row)->getValue();
        $tabo_area           = $worksheet->getCell('I' . $row)->getValue();
        $parking_number           = $worksheet->getCell('J' . $row)->getValue();
        $storage_number           = $worksheet->getCell('K' . $row)->getValue();

       // echo $neighborhood.' and rawabi cpde is '.$rawabi_code.'<br/>';

        $sql_query = "UPDATE `uf_unit` SET 
                      `size`='$size', `building_type`='$buliding_type', `description`='$description',
                      `price`='$price', `tapu_code`='$tapu_code', `unitDescription`='$unit_description' , `tabo_area`='$tabo_area',
                      `parking_number` = '$parking_number', `storage_number` = '$storage_number'
                      WHERE `rawabi_code`='$rawabi_code' 
                      AND `neighborhood`='$neighborhood'";

        mysqli_set_charset($conn,"utf8");
        mysqli_query($conn, $sql_query) ? $success = 1 : $success = 0 ;



    }

    $conn->close();

    $success === 1
        ? header("Location: " . $back_url . "?success=1&message=".$success_message)
        : header("Location: " . $back_url . "?error=1&message=".$error_message);

    exit();
}
exit();
