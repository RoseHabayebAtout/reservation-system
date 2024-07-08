<?php

namespace UserFrosting;

/**
 * AdminController Class
 *
 * Controller class for /config/* URLs.  Handles admin-related activities, including site settings, etc
 *
 * @package UserFrosting
 * @author Alex Weissman
 * @link http://www.userfrosting.com/navigating/#structure
 */
class AdminController extends \UserFrosting\BaseController {

    /**
     * Create a new AdminController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }

    /**
     * Renders the site settings page.
     *
     * This page provides an interface for modifying site settings, especially those handled by the SiteSettings class.
     * It also shows some basic configuration information for the site, along with a nicely formatted readout of the PHP error log.
     * This page requires authentication (and should generally be limited to the root user).
     * Request type: GET
     */
    public function pageSiteSettings(){


        // Hook for core and plugins to register their settings
        $this->_app->applyHook("settings.register");

        $this->_app->render('config/site-settings.twig', [
            'settings' => $this->_app->site->getRegisteredSettings(),
            'info'     => $this->_app->site->getSystemInfo(),
            'error_log'=> SiteSettings::getLog(50)
        ]);
    }

    /**
     * Processes a request to update the site settings.
     *
     * Processes the request from the site settings form, checking that:
     * 1. The setting name has been registered with the SiteSettings object.
     * This route requires authentication.
     * Request type: POST
     * @todo validate setting syntax
     */
    public function siteSettings(){

        // Get the alert message stream
        $ms = $this->_app->alerts;

        $post = $this->_app->request->post();


        // Remove CSRF token
        if (isset($post['csrf_token']))
            unset($post['csrf_token']);


        // Hook for core and plugins to register their settings
        $this->_app->applyHook("settings.register");

        // Get registered settings
        $registered_settings = $this->_app->site->getRegisteredSettings();

        // Ok, check that all posted settings are registered
        foreach ($post as $plugin => $settings){
            if (!isset($registered_settings[$plugin])){
                $ms->addMessageTranslated("danger", "CONFIG_PLUGIN_INVALID", ["plugin" => $plugin]);
                $this->_app->halt(400);
            }
            foreach ($settings as $name => $value){
                if (!isset($registered_settings[$plugin][$name])){
                    $ms->addMessageTranslated("danger", "CONFIG_SETTING_INVALID", ["plugin" => $plugin, "name" => $name]);
                    $this->_app->halt(400);
                }
            }
        }


        if(isset($_FILES["site_logo"]) )
        {

            $name = $_FILES["site_logo"]["name"];
            $location = 'uploads/' . $name;
            move_uploaded_file($_FILES["site_logo"]["tmp_name"], $location);
        }

        if(isset($_FILES["site_background_image"]))
        {
            $name = $_FILES["site_background_image"]["name"];
            $location = 'uploads/' . $name;
            move_uploaded_file($_FILES["site_background_image"]["tmp_name"], $location);
        }

        // TODO: check if exist


        // TODO: validate setting syntax

        // If validation passed, then update

        foreach ($post as $plugin => $settings){
            foreach ($settings as $name => $value){
                $this->_app->site->set($plugin, $name, $value);
            }
        }
        $this->_app->site->store();

    }

    public function insertFile($postRequest)
    {
        $post = $postRequest;

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

    public function uploadImage()
    {
        $db_connection_string = $this->_app->environment()["db_connection"];

        echo 'text';
        if($_FILES["file"]["name"] != '')
        {
            $test = explode('.', $_FILES["file"]["name"]);
            $ext = end($test);
            $name = rand(100, 999) . '.' . $ext;
            $location = '/'+ $db_connection_string +'/public/uploads/' . $name;
            move_uploaded_file($_FILES["file"]["tmp_name"], $location);
        }
    }


}
