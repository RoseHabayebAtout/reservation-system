<?php

require_once "Classes/PHPExcel.php";
$pathInPieces = explode('/', $_SERVER['SCRIPT_NAME']);
$init_path = $_SERVER['DOCUMENT_ROOT'] . "/" . $pathInPieces[1] . "/userfrosting/initialize.php";
require_once($init_path);

$urlInPieces = explode('/', $_SERVER['REQUEST_URI']);
$back_url = $_SERVER['HTTP_REFERER'];
if ($back_url == "") {
    $back_url = "http://$_SERVER[HTTP_HOST]/$urlInPieces[1]/public/uploadParking/";
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
    $success_message = 'All parkings have been uploaded successfully!';
    //open the reader via PHPExecl
    $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpName);
    $excelObj = $excelReader->load($tmpName);
    $worksheet = $excelObj->getSheet(0);
    $lastRow = $worksheet->getHighestRow();


    // Edited by Ahmad Tome (convert photo description in excel sheet to description to be convenient with database)
    $titles = [$worksheet->getCell('A1')->getValue(),
        $worksheet->getCell('B1')->getValue(),
        $worksheet->getCell('C1')->getValue(),
        $worksheet->getCell('D1')->getValue(),
        $worksheet->getCell('E1')->getValue(),
        $worksheet->getCell('F1')->getValue(),
        $worksheet->getCell('G1')->getValue(),

    ];
    //$worksheet->getCell('I1')->getValue()



    //$right_title = ['Building', 'unit', 'floor', 'Neighborhood', 'Gross Area', 'Tabo Area', 'Apartment Code',
    //  'Building Code', 'Photo Description', 'price', 'tabo code', 'UnitDescription'];

    // Edited By AHmad Tome (convert column name from photo Description to description)

    $right_title = ['Parking Code', 'Neighborhood', 'Building', 'Floor',
        'Parking Number', 'Description', 'Price',
    ];


    $result = array_diff($titles, $right_title);


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
        $neighborhood = $worksheet->getCell('B' . $row)->getValue();
        array_push($notExistNeighborhoods, $neighborhood);
    }



    foreach(array_unique(array_diff($notExistNeighborhoods, $neighborhoodNames)) as $nonExistentNeighborhood){

        $error_message .="$$".$nonExistentNeighborhood;
    }

    //loop through the file contents to get the required fields
    for ($row = 2; $row <= $lastRow; $row++) {
        $neighborhood = $worksheet->getCell('B' . $row)->getValue();

        if(! in_array($neighborhood,$neighborhoodNames) ){

            if ($neighborhood == "") {
                continue ;
            }
            $success = 0;
            break;
        }





        $x0 = trim($worksheet->getCell('A' . $row)->getValue());
        $x1 = trim($worksheet->getCell('B' . $row)->getValue());
        $x2 = trim($worksheet->getCell('C' . $row)->getValue());
        $x3 = trim($worksheet->getCell('D' . $row)->getValue());
        $x4 = trim($worksheet->getCell('E' . $row)->getValue());
        $x5 = trim($worksheet->getCell('F' . $row)->getValue());
        $x6 = trim($worksheet->getCell('G' . $row)->getValue());



        /* $sql_query ="INSERT INTO `uf_unit`(
                       `building`,`unit`,`floor`,`neighborhood`,`size`,`rawabi_code`,`building_type`,`unitDescription`,
                       `price`,`available`,`tapu_code`,`description`,`tabo_area`)
                     VALUES ('$x0', '$x1','$x2','$neighborhood','$x4','$x6', '$x7','$x8','$x9','1','$x10','$x11','$x5')";
         */
        $sql_query = "INSERT INTO `parking`(`rawabi_code`, `neighporhood`, `building`, `floor`, `parking_number`, `description`, `price`) VALUES
                                            ('$x0', '$x1','$x2','$x3','$x4','$x5','$x6')";



        mysqli_set_charset($conn, "utf8");
        mysqli_query($conn, $sql_query) ? $success = 1 : $success = 0;




    }
    $conn->close();

    $success === 1
        ? header("Location: " . $back_url . "?success=1&message=".$success_message)
        : header("Location: " . $back_url . "?error=1&message=".str_replace('$$',"<br>", $error_message));
    exit();
}
exit();
