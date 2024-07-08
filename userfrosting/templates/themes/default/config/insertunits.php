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
if (isset($_FILES['userfile']) && $_FILES['userfile']['size'] > 0) {
    //read the file contents
    $fileName = $_FILES['userfile']['name'];
    $tmpName = $_FILES['userfile']['tmp_name'];
    $fileSize = $_FILES['userfile']['size'];
    $fileType = $_FILES['userfile']['type'];
    // Read Neighborhood Names
    $neighborhoodNames = explode(',', $_POST['neighborhoodNames']);



    $notExistNeighborhoods = [];
    $error_message = 'One or more neighborhoods does not exist in the Database, please add them before proceeding';
    $success_message = 'All units have been uploaded successfully!';
    //open the reader via PHPExecl
    $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpName);
    $excelObj = $excelReader->load($tmpName);
    $worksheet = $excelObj->getSheet(0);
    $lastRow = $worksheet->getHighestRow();


    // Edited by Ahmad Tome (convert photo description in excel sheet to description to be convenient with database)
    $titles = [
        $worksheet->getCell('A1')->getValue(),
        $worksheet->getCell('B1')->getValue(),
        $worksheet->getCell('C1')->getValue(),
        $worksheet->getCell('D1')->getValue(),
        $worksheet->getCell('E1')->getValue(),
        $worksheet->getCell('F1')->getValue(),
        $worksheet->getCell('G1')->getValue(),
        $worksheet->getCell('H1')->getValue(),
        "description",
        $worksheet->getCell('J1')->getValue(),
        $worksheet->getCell('K1')->getValue(),
        $worksheet->getCell('L1')->getValue(),
        $worksheet->getCell('M1')->getValue(),
        $worksheet->getCell('N1')->getValue()
    ];
    //$worksheet->getCell('I1')->getValue()


    //$right_title = ['Building', 'unit', 'floor', 'Neighborhood', 'Gross Area', 'Tabo Area', 'Apartment code',
      //  'Building Code', 'Photo Description', 'price', 'tabo code', 'UnitDescription'];

    // Edited By AHmad Tome (convert column name from photo Description to description)

    $right_title = ['Building', 'unit', 'floor', 'Neighborhood', 'Net Area', 'Tabo Area', 'Apartment code',
        'Building Code', 'description', 'price', 'tabo code', 'UnitDescription', 'parking Number', 'storage Number'];

    $result = array_diff($titles, $right_title);
//print_r($titles);
  //  echo "<br>";
//print_r($right_title);
  //  echo "<br>";
//print_r($result);
  //  echo "<br>";
//echo print_r($worksheet->getCell('I1')->getValue());



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

    $success = 0;

    // Get non exist neighborhoods;
    for ($row = 2; $row <= $lastRow; $row++) {
        $neighborhood = $worksheet->getCell('D' . $row)->getValue();
        array_push($notExistNeighborhoods, $neighborhood);
    }


    foreach(array_unique(array_diff($notExistNeighborhoods, $neighborhoodNames)) as $nonExistentNeighborhood){
        $error_message .="$$".$nonExistentNeighborhood;
    }

    mysqli_set_charset($conn, "utf8");

            $parkingStorageFlag = 1;
    // validate parking Number and storage number
        for ($row = 2; $row <= $lastRow; $row++) {
            $parking_number = $worksheet->getCell('M' . $row)->getValue();
            $storage_number = $worksheet->getCell('N' . $row)->getValue();
            if ($parking_number != "") {
                $sql_query = "SELECT * FROM `parking` WHERE `parking_number` = ".$parking_number ;
                $result = mysqli_query($conn, $sql_query);
                if (!$result || $result->num_rows == 0) {
                    $parkingStorageFlag = 0;
                    break;
                }

                $sql_query = "SELECT * FROM `unit` WHERE `parking_number` = ".$parking_number ;
                $result = mysqli_query($conn, $sql_query);
                if ($result && $result->num_rows > 0) {
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

                $sql_query = "SELECT * FROM `unit` WHERE `storage_number` ".$storage_number ;
                $result = mysqli_query($conn, $sql_query);
                if ($result && $result->num_rows > 0) {
                    $parkingStorageFlag = 0;
                    break;
                }
            }
        }

        if ($parkingStorageFlag == 0) {
            header("Location: " . $back_url . "?error=1&message=".str_replace('$$',"<br>", "There is an issue with the parking Number and storage Number, Please review them "));
            exit();
        }




            //echo $lastRow ;
    //echo "<br>";
    //print_r($notExistNeighborhoods) ;
    //echo "<br>";
    //echo "<br>";
    //echo "<br>";
   // print_r($neighborhoodNames) ;
   // echo "<br>";
   // print_r(array_diff($notExistNeighborhoods, $neighborhoodNames)) ;
    //return ;

    //loop through the file contents to get the required fields
    for ($row = 2; $row <= $lastRow; $row++) {
        $neighborhood = $worksheet->getCell('D' . $row)->getValue();
       // if (count(array_unique(array_diff($notExistNeighborhoods, $neighborhoodNames))) > 0) {
        //    $success = 0;
         //   break;
       // }


       // print_r($neighborhoodNames);
       // return ;

/*
        if(!($neighborhood =="Dulaim" || $neighborhood =="Makmata" || $neighborhood =="Warwar" || $neighborhood =="Suwan" || $neighborhood =="Ekshaf")  ){

           if ($neighborhood == "") {
               continue ;
           }
            $success = 0;
             break;
        }
        */

        $parkingIds = array() ;
        $storageIds = [] ;
        if(! in_array($neighborhood,$neighborhoodNames) ){
           if ($neighborhood == "") {
               continue ;
           }
            $success = 0;
             break;
        }



            $x0 = $worksheet->getCell('A' . $row)->getValue();
            $x1 = $worksheet->getCell('B' . $row)->getValue();
            $x2 = $worksheet->getCell('C' . $row)->getValue();
            $x4 = $worksheet->getCell('E' . $row)->getValue();
            $x5 = $worksheet->getCell('F' . $row)->getValue();
            $x6 = $worksheet->getCell('G' . $row)->getValue();
            $x7 = $worksheet->getCell('H' . $row)->getValue();
            $x8 = $worksheet->getCell('I' . $row)->getValue();
            $x9 = $worksheet->getCell('J' . $row)->getValue();
            $x10 = $worksheet->getCell('K' . $row)->getValue();
            $x11 = $worksheet->getCell('L' . $row)->getValue();
            $x12 = $worksheet->getCell('M' . $row)->getValue();
            $x13 = $worksheet->getCell('N' . $row)->getValue();


            array_push($parkingIds, $x12);
            array_push($storageIds, $x13);
            /* $sql_query ="INSERT INTO `uf_unit`(
                           `building`,`unit`,`floor`,`neighborhood`,`size`,`rawabi_code`,`building_type`,`unitDescription`,
                           `price`,`available`,`tapu_code`,`description`,`tabo_area`)
                         VALUES ('$x0', '$x1','$x2','$neighborhood','$x4','$x6', '$x7','$x8','$x9','1','$x10','$x11','$x5')";
             */
            $sql_query = "INSERT INTO `uf_unit`(
                      `building`,`unit`,`floor`,`neighborhood`,`size`,`rawabi_code`,`building_type`,`unitDescription`,
                      `price`,`available`,`tapu_code`,`description`,`tabo_area`,`parking_number`,`storage_number`)
                    VALUES ('$x0', '$x1','$x2','$neighborhood','$x4','$x6', '$x7','$x8','$x9','1','$x10','$x11','$x5','$x12','$x13')";


//            echo $sql_query;
//            return;
            mysqli_set_charset($conn, "utf8");
            mysqli_query($conn, $sql_query) ? $success = 1 : $success = 0;




    }

    $str = "";
    for ($i=0 ; $i < count($parkingIds) - 1; $i++) {
        $str = $str."$parkingIds[$i],";
    }
    $str = $str.$parkingIds[count($parkingIds) - 1];
    $sql_query = "UPDATE `parking` SET `available`= 1 WHERE `parking_number` in (". $str.")";
    mysqli_query($conn, $sql_query);


    $str = "";
    for ($i=0 ; $i < count($storageIds) - 1; $i++) {
        $str = $str."$storageIds[$i],";
    }
    $str = $str.$storageIds[count($storageIds) - 1];
    $sql_query = "UPDATE `storages` SET `available`= 1 WHERE `storage_number` in ". $str;

    mysqli_query($conn, $sql_query);


    $conn->close();

    $success === 1
        ? header("Location: " . $back_url . "?success=1&message=".$success_message)
        : header("Location: " . $back_url . "?error=1&message=".str_replace('$$',"<br>", $error_message));
    exit();
}
exit();
