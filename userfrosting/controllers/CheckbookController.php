<?php
        
namespace UserFrosting;

class CheckbookController extends \UserFrosting\BaseController {

    protected static $_table_id = "checkbook";
    
        /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }

    public function createCheckbook(){
       // Fetch the POSTed data
       $post = $this->_app->request->post();
       
       // Load the request schema
 	    $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/checkbook-create.json");
       
       // Get the alert message stream
       $ms = $this->_app->alerts; 
    
       // Set up Fortress to process the request
       $rf = new \Fortress\HTTPRequestFortress($ms, $requestSchema, $post);                    
        
       // Sanitize
       $rf->sanitize();
        
       // Validate, and halt on validation errors.
       if (!$rf->validate()) {
           $this->_app->halt(400);
       }   
              
       // Get the filtered data
       $data = $rf->data();
       	//create new reservation
    	$new_checkbook = new Checkbook([
		    "check_no" => $post['check_no'],
		    "check_amount" => $post['check_amount'],
		    "check_bank" =>$post['check_bank'],
		    "check_currency" => $post['check_currency'],
		    "check_date" => $post['check_date']
		  ]);
    	$new_checkbook->save();
    	// create many to many table with reservation_unit
    	$unit = Unit::find($post['uid']);
    	$new_checkbook->units()->attach($unit->id);

    }
    public function  deleteCheckbook(){
        $post = $this->_app->request->post();

        $unit = Unit::find($post['uid']);
        $checkArr=$unit->checkbooks($post['uid']);
        /*loop on foreach check then delete it*/
          foreach ($checkArr as $checkbookObj){
            $checkbook_id= $checkbookObj['checkbook_id'];
             $checkbook=Checkbook::find($checkbook_id);
            // delete many to many relationship
            $checkbook->units()->detach($unit);
            // delete checkbook
            $checkbook->delete();
          }

        }
    public function  getCheckbook($id){
        $checkbookArr = array();
        $unit = Unit::find($id);
        $checkbooks_units=$unit->checkbooks($id);
        foreach ($checkbooks_units as $checkbooks_unit){
          $checkbook_id=$checkbooks_unit['checkbook_id'];
          $checkbook=Checkbook::find($checkbook_id);
          array_push($checkbookArr,$checkbook);
        }
        return json_encode($checkbookArr);

    }
    
    
}