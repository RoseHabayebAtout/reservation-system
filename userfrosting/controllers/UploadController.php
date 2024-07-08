<?php

namespace UserFrosting;


use Birke\Rememberme\Storage\DB;

class UploadController extends \UserFrosting\BaseController
{

    protected static $_table_id = "uploadedfiles";

    /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app)
    {
        $this->_app = $app;
    }

    public function delete_image()
    {
        $delete = $this->_app->request->delete();
        $image_id = $delete['imagid'];
        $name = $delete['name'];

//        $img = UploadedFiles::where('filename', '=', $name)->get();
//        $name = explode('.', $name)[0];
//        print_r($name);
//        die();
//        $img = UploadedFiles::where('filename', 'like', "%$name%")->delete();


        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
// Check connection
        if (!$conn) die("Connection failed: " . mysqli_connect_error());
        mysqli_set_charset($conn, "utf8");
//        $query = "DELETE FROM `uf_units_images`  WHERE `filename` LIKE '%" . $name . "%'";
        $query = "DELETE  FROM `uf_units_images` WHERE `unit_id` LIKE '%" . $image_id . "%' AND `filepath` LIKE '%" . $name . "%'";

        $result = $conn->query($query);
//        print_r(['result'=>$query]);
//        die();
        echo $result;

    }

    public function getView()
    {
        $this->_app->render('upload/upload.twig');
    }

    public function getUploadPlanView()
    {
        $this->_app->render('upload/uploadPlan.twig');
    }

    public function insertFile()
    {
        $post = $this->_app->request->post();

        if (!is_dir('uploads')) {
            mkdir('uploads');
        }
        $file = $_FILES['images'];
        $itemsArray = array();
        // Check the number of images
        $photoCount = count($file['name']);

        if ($photoCount > 0) {

            for ($i = 0; $i < $photoCount; $i++) {
                // Getting name of each file
                $name = $post['newname'];
                $nameArray = explode('.', $name);
                $fileName = $nameArray[0];
                $fileExt = $nameArray[1];
                // Getting temp loc which is what we used to upload images themselves.
                $tempName = $file['tmp_name'][$i];
                // Getting size of each file;
                $fileSize = $file['size'][$i];
                // Grab errors
                $error = $file['error'][$i];
                // Allowed data-types
                $allowed = array('JPEG', 'JPG', 'PNG', 'jpeg', 'jpg', 'png');
                $uploadPath = "uploads/" . $fileName . "." . $fileExt;
                if (!file_exists($fileName)) {
                    if (in_array($fileExt, $allowed)) {
//                        echo '<pre>';
//                        print_r(['$tempName' => $tempName, '$uploadPath' => $uploadPath, '$name' => $name, '$post' => $post, '$file' => $file, '$itemsArray' => $itemsArray, '$photoCount' => $photoCount]);
//                        echo '</pre>';

                        move_uploaded_file($tempName, $uploadPath);
                        $itemsArray[] = array($fileName, $fileSize, $uploadPath);
                    } else {
                        echo " You are not allowed to upload files from this type ";
                    }
                } else {
                    echo 'File exist in our directory';
                }
            }
        }
        $iterator = array_unique($itemsArray, SORT_REGULAR);

        for ($i = 0; $i < $photoCount; $i++) {
            $uploadController = new UploadedFiles([
                'filename' => $iterator[$i][0],
                'filesize' => $iterator[$i][1],
                'filepath' => $iterator[$i][2]
            ]);
            $uploadController->save();
        }
        $imgs = UploadedFiles::where('filename', '=', $iterator[0][0])->get();
        echo $imgs[0]['id'];
    }


    public function insertPlan()
    {

        $post = $this->_app->request->post();

        if (!is_dir('uploads')) {
            mkdir('uploads');
        }
        $file = $_FILES['images'];
        $itemsArray = array();
        // Check the number of images
        $photoCount = count($file['name']);
        $return_paths = [];
        if ($photoCount > 0) {
            for ($i = 0; $i < $photoCount; $i++) {
                // Getting name of each file
//                $name = $post['newname'];
//                $nameArray = explode('.', $name);
                $fileName = time() . '-' . $i;// $nameArray[0];
                $fileExt = substr($file['name'][$i], -4);
                $fileExt = trim($fileExt, '.');
                $fileExt = trim($fileExt, ' ');
                $tempName = $file['tmp_name'][$i];
                // Getting size of each file;
                $fileSize = $file['size'][$i];
                // Grab errors
                $error = $file['error'][$i];
                // Allowed data-types
                $allowed = array('JPEG', 'JPG', 'PNG', 'jpeg', 'jpg', 'png');
//                $uploadPath = "uploads/" . $fileName . "." . $fileExt;
                $uploadPath = "uploads/" . $fileName . "." . $fileExt;

                if (!file_exists($fileName)) {
                    if (in_array($fileExt, $allowed)) {
                        move_uploaded_file($tempName, $uploadPath);
                        $return_paths[] = [
                            'file_name' => $fileName,
                            'upload_path' => $uploadPath,
                            'file_size' => $fileSize,
                        ];
                        $itemsArray[] = array($fileName, $fileSize, $uploadPath);
                    } else {
                        echo " You are not allowed to upload files from this type ";
                    }
                } else {
                    echo 'File exist in our directory';
                }
            }
        }

        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        // Check connection
        if (!$conn) die("Connection failed: " . mysqli_connect_error());
        mysqli_set_charset($conn, "utf8");
        $ids = explode(',', $post['id']);
        for ($i = 0; $i < count($ids); $i++) {
            for ($itemsArray_index = 0; $itemsArray_index < count($itemsArray); $itemsArray_index++) {
//                echo '<pre>';
//                print_r(['count($itemsArray)'=>count($itemsArray),$itemsArray[$itemsArray_index],'$itemsArray' => $itemsArray,'$itemsArray_index' => $itemsArray_index]);
//                echo '</pre>';
//                die();
                if ($post['type'] == "Storages") {
                    $query = "INSERT INTO `storage_plans`( `storage_id`, `filename`, `filesize`, `filepath`) VALUES (" . $ids[$i] . ",'" . $itemsArray[$itemsArray_index][0] . "','" . $itemsArray[$itemsArray_index][1] . "','" . $itemsArray[$itemsArray_index][2] . "')";
                } elseif ($post['type'] == 'Parkings') {
                    $query = "INSERT INTO `parking_plans`( `parking_id`, `filename`, `filesize`, `filepath`) VALUES (" . $ids[$i] . ",'" . $itemsArray[$itemsArray_index][0] . "','" . $itemsArray[$itemsArray_index][1] . "','" . $itemsArray[$itemsArray_index][2] . "')";
                } else {
                    $query = "INSERT INTO `uf_units_images`( `unit_id`, `filename`, `filesize`, `filepath`) VALUES (" . $ids[$i] . ",'" . $itemsArray[$itemsArray_index][0] . "','" . $itemsArray[$itemsArray_index][1] . "','" . $itemsArray[$itemsArray_index][2] . "')";
                }
                $conn->query($query);
            }
//            echo '<pre>';
//            print_r(['$query' => $query, '$uploadPath' => $uploadPath, '$name' => $name, '$post' => $post, '$file' => $file, '$itemsArray' => $itemsArray, '$photoCount' => $photoCount]);
//            echo '</pre>';

        }

        echo json_encode($return_paths);
        return;
        echo '<pre>' . print_r(['$return_paths' => $return_paths, '$file' => $file, '$photoCount' => $photoCount]) . '</pre>';
        die();

    }


    public function getImages()
    {
        $file = UploadedFiles::get();
        echo json_encode($file);
    }

    public function getImgs($img_id)
    {
        $img = UploadedFiles::where('id', '=', $img_id)->get();
        echo $img;
    }
}
