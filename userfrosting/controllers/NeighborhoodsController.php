<?php
        
namespace UserFrosting;

class NeighborhoodsController extends \UserFrosting\BaseController {

    protected static $_table_id = "neighborhoods";
    
        /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }

    public function renderNeighborhoods(){
      $this->_app->render('config/neighborhoods.twig', [
      ]);
    }
    public function getNeighborhoods(){
      $neighborhoods=Neighborhoods::get();
      echo $neighborhoods;    
    }
    public function setNeighborhoods(){
       // Fetch the POSTed data
       $post = $this->_app->request->post();
       // Load the request schema
       // $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/discount-create.json");
       // // Get the alert message stream
       // $ms = $this->_app->alerts; 
       // // Set up Fortress to process the request
       // $rf = new \Fortress\HTTPRequestFortress($ms, $requestSchema, $post);                    
       // // Sanitize
       // $rf->sanitize();
       // // Validate, and halt on validation errors.
       // if (!$rf->validate()) {
       //     $this->_app->halt(400);
       // }        
       // Get the filtered data
       // $data = $rf->data();
       //create new Discount
      $new_neighborhood = new Neighborhoods([
        "haiEnglishName" => $post['haiEnglishName'],
        "haiArabicName" => $post['haiArabicName'],
        "haiBuildingsNum" => $post['haiBuildingsNum'],
        "haiArea" => $post['haiArea'],
        "HAO_num" => $post['HAO_num'],
        "HAO_date" => $post['HAO_date'],
// Tamer
        "estContrDate" => $post['estContrDate'],
        "estContrDate2" => $post['estContrDate2'],
        "land" => $post['land'],
        "estContrNum" => $post['estContrNum'],
        "estContrNum2" => $post['estContrNum2'],
      ]);
      $new_neighborhood ->save();
    }

    public function updateNeighborhoods(){
      $post = $this->_app->request->post();
      // Load the request schema
      // $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/discount-edit.json");
       
      //  // Get the alert message stream
      //  $ms = $this->_app->alerts; 
    
      //  // Set up Fortress to process the request
      //  $rf = new \Fortress\HTTPRequestFortress($ms, $requestSchema, $post);                    
        
      //  // Sanitize
      //  $rf->sanitize();
        
      //  // Validate, and halt on validation errors.
      //  if (!$rf->validate()) {
      //      $this->_app->halt(400);
      //  }
      $neighborhood_id=$post['neighborhood_id'];
      $neighborhood=Neighborhoods::find($neighborhood_id);
      $neighborhood['haiArabicName']=$post['haiArabicName'];
      $neighborhood['haiEnglishName']=$post['haiEnglishName'];
      $neighborhood['haiArea']=$post['haiArea'];
      $neighborhood['HAO_num']=$post['HAO_num'];
      $neighborhood['HAO_date']=$post['HAO_date'];
      $neighborhood['haiBuildingsNum']=$post['haiBuildingsNum'];
      $neighborhood['estContrDate']=$post['estContrDate'];
      $neighborhood['estContrDate2']=$post['estContrDate2'];
      $neighborhood['land']=$post['land'];
      $neighborhood['estContrNum']=$post['estContrNum'];
      $neighborhood['estContrNum2']=$post['estContrNum2'];
      $neighborhood->save();
    }

    public function deleteNeighborhood(){
      // Fetch the POSTed data
      $post = $this->_app->request->post();
      $neighborhood_id=$post['neighborhood_id'];
      $neighborhood=Neighborhoods::find($neighborhood_id);
      $neighborhood->delete();
    }

    public function checkExistNameEn(){
      $post = $this->_app->request->post();
      $neighborhood_name_en = $post['neighborhood_name_en'];
      $old_name_en = $post['old_name_en'];
      $flag="FALSE";
      $neighborhoods=Neighborhoods::get();
      foreach($neighborhoods as $neighborhood){
          if(($neighborhood['haiEnglishName'] == $neighborhood_name_en) && ($neighborhood['haiEnglishName']  != $old_name_en)){
            $flag="TRUE";
            break;
          }
        }
      echo $flag;  
    }
    public function checkExistNameAr(){
      $post = $this->_app->request->post();
      $neighborhood_name_ar = $post['neighborhood_name_ar'];
      $old_name_ar = $post['old_name_ar'];
      $flag="FALSE";
      $neighborhoods=Neighborhoods::get();
      foreach($neighborhoods as $neighborhood){
          if(($neighborhood['haiArabicName'] == $neighborhood_name_ar) && ($neighborhood['haiArabicName']  != $old_name_ar)){
            $flag="TRUE";
            break;
          }
      }
      echo $flag;  
    }

    public function getNeighborhood($neighborhood){

      $neighborhoodd=Neighborhoods::where('haiEnglishName',$neighborhood)->first();
      return $neighborhoodd;
    }
}