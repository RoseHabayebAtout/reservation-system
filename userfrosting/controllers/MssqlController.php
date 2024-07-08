<?php
        
namespace UserFrosting;

class MssqlController extends \UserFrosting\BaseController {

    protected static $_table_id = "mssql_config";
    
        /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }

    public function getMssqlConfigTemplate(){
      // read mssql configurations from database
      $mssqlConfigs=Mssql::get();
      foreach ($mssqlConfigs as $mssqlConfig) {
        $server = $mssqlConfig['server'];
        $msdb = $mssqlConfig['msdb'];
        $username = $mssqlConfig['username'];
        $pass = $mssqlConfig['pass'];
      }
      $this->_app->render('config/mssql-config.twig',[
          "server" => $server,
          "msdb" => $msdb,
          "username" => $username,
          "pass" => $pass
          ]);
    }

    public function getMssqlConfigs(){
      $mssqlConfigs=Mssql::get();
      foreach ($mssqlConfigs as $mssqlConfig) {
        $server = $mssqlConfig['server'];
        $msdb = $mssqlConfig['msdb'];
        $username = $mssqlConfig['username'];
        $pass = $mssqlConfig['pass'];
      }
      $configs = [
          "server" => $server,
          "msdb" => $msdb,
          "username" => $username,
          "pass" => $pass
          ];
      return $configs;        
    }

    public function updateMssqlConfig(){
       // Fetch the POSTed data
       $post = $this->_app->request->post();
       //validate data
       $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/mssql-config.json");
       // Get the alert message stream
       $ms = $this->_app->alerts; 
       // Set up Fortress to process the request
       $rf = new \Fortress\HTTPRequestFortress($ms, $requestSchema, $post);                    
       // Sanitize
       $rf->sanitize();
       // Validate, and halt on validation errors.
       if (!$rf->validate()){
           $this->_app->halt(400);
       } 
      // get configurations from database and update them from posted data
      $mssqlConfigs=Mssql::get();
      foreach ($mssqlConfigs as $mssqlConfig) {
        $mssqlConfig['server']=$post['server'];
        $mssqlConfig['msdb']=$post['msdb'];
        $mssqlConfig['username']= $post['username'];
        $mssqlConfig['pass']= $post['pass'];
        $mssqlConfig->save();
      }
      
    }
    
}