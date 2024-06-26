<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Signed and Closed Units</title>
</head>

<body>
    <?php
        ini_set('max_execution_time', 300);
        require_once "Classes/PHPExcel.php";
        $tmpfname = "Closed deals- Asal System.xlsx";  // Unit excel sheets -> these unit will be converted to closed whenever this scipt got fired.
        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
        $excelObj = $excelReader->load($tmpfname);
        $worksheetCount = $excelObj->getSheetCount();
        
        $conn = new mysqli('localhost', 'root', '', 'userfrosting');
        if(!$conn) {
            echo 'something worng happened';
            die();
        }
        $counter = 0;
        // Iterate over all sheets in the file
        $start = microtime(true);
        for($sheetNumber = 0; $sheetNumber < $worksheetCount; $sheetNumber++ ){
            $worksheet = $excelObj->getSheet($sheetNumber);
            $lastRow = $worksheet->getHighestRow();
            
            for ($row = 2; $row <= $lastRow; $row++) {
                $primary_key = $worksheet->getCell('A'.$row)->getValue();
                if($primary_key){
                    $neighborhood = explode(' ', $primary_key)[0];
                    $rawabi_code = explode(' ', $primary_key)[1];
    
                    $query = "UPDATE `uf_unit` SET available='5', contract_type='3' WHERE rawabi_code='$rawabi_code'";
                    
                    $result = mysqli_query($conn, $query);
                }
                $new_tabo = $worksheet->getCell('B'.$row)->getValue();
                $counter++;
            }
        }
        $time_elapsed_secs = microtime(true) - $start;
    ?>
    <div class='container' style="margin-top: 1em;">
        <div class='row'>
            <div class='col-sm-12'>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span href="" class='alert-link'>
                        <?php 
                            echo "DONE in " . $time_elapsed_secs . "  seconds." 
                        ?>
                    </span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>