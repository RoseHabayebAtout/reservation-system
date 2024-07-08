<?php
        
namespace UserFrosting;

class SerialNumberController extends \UserFrosting\BaseController {

    protected static $_table_id = "serial_number";
    
        /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }

   
    public function getserial(){
      $serial=Serial::where('id', '=', 1)->get();
      echo $serial; 
        
          }
    
    
   
    public function updateserial(){
      $post = $this->_app->request->post();
      // Load the request schema
      
     $discount=Serial::find('1');
     $discount['serial']=$post['serial'];
        //$discount['date']=$post['discount_date'];
      
      $discount->save();


    }


   
    }
     
    
    

