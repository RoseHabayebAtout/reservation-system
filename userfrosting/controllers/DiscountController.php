<?php

namespace UserFrosting;

class DiscountController extends \UserFrosting\BaseController {

    protected static $_table_id = "discount";

        /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }

    public function renderDiscounts(){
          $this->_app->render('config/discount.twig', [
          ]);
    }
    public function getDiscounts(){
      $discounts=Discount::where('is-deleted', '=', 0)->get();
      echo $discounts;
    }
    public function setDiscounts(){
       // Fetch the POSTed data
       $post = $this->_app->request->post();

       // Load the request schema
      $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/discount-create.json");

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
      //create new Discount
      $new_discount = new Discount([
        "name" => $post['discount_name'],
        "value" => $post['discount_value'],
        "password" => $post['discount_password'],
          "date"=>$post['discount_date'],
          "type"=>$post['discount_type'],
          "description"=>$post['discount_description']
      ]);
      $new_discount->save();

    }
    public function updateDiscounts(){
      $post = $this->_app->request->post();
      // Load the request schema
      $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/discount-edit.json");

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
      $discount_id=$post['discount_id'];
      $discount=Discount::find($discount_id);
      $discount['name']=$post['discount_name'];
      $discount['value']=$post['discount_value'];
      $discount['password']=$post['discount_password'];
        //$discount['date']=$post['discount_date'];
      $discount['description']=$post['discount_description'];

      $discount->save();


    }
    public function deleteDiscount(){
      // Fetch the POSTed data
      $post = $this->_app->request->post();
      $discount_id=$post['discount_id'];
      $discount=Discount::find($discount_id);
      $discount['is-deleted']=1;
      $discount->save();

    }

    public function getDiscountAmount(){

      $post = $this->_app->request->post();
      $discount_id=$post['discount_id'];
     $price = $post['price_val'];
      $pass = $post['dis_pass'];
      $discount=Discount::find($discount_id);
      $discountPass=$discount['password'];

      if($pass==$discountPass){
          if($discount['type']==0){
              $discountVal = $discount['value'];
              //$priceafterdiscount = $price - $discountVal;
              $priceafterdiscount =  $discountVal;
              echo $priceafterdiscount;
          }
          else{
              $discountVal = $discount['value']/100;
              $priceafterdiscount = $price*$discountVal;
              echo $priceafterdiscount;
          }

      }
      else{
        echo "FALSE";
      }
    }

    public function  getDiscountDescrption(){
        $post = $this->_app->request->post();
        $discount_id=$post['discount_id'];
        $discount=Discount::find($discount_id);
        echo $discount['description'];
    }


    public function checkExistName(){
      $post = $this->_app->request->post();
      $discount_name = $post['discount_name'];
      $old_name = $post['old_name'];
      $flag="FALSE";
      $discounts=Discount::where('is-deleted', '=', 0)->get();
      foreach($discounts as $discount){
        if(($discount['name'] == $discount_name) && ($discount['name']  != $old_name)){
        $flag="TRUE";
        break;
      }
      }
      echo $flag;


    }

    public function getTotalPriceAfterMultipleDiscount(){
        $post = $this->_app->request->post();
        $price = $post['price'];

        $pass = $post['dis_pass'];
        $discount=Discount::find($post["discount_id_arr"][0]);
        $discountPass=$discount['password'];

        if($pass==$discountPass) {
            for ($i = 0; $i < count($post["discount_id_arr"]); $i++) {
                $discount = Discount::find($post["discount_id_arr"][$i]);
                if ($discount['type'] == 0) {
                    $price = $price - $discount['value'];
                } else {
                    $discountVal = $discount['value'] / 100;
                    $price = $price - ($price * $discountVal);
                }

            }

            return $price;
        }else{
            return "FALSE";
        }
    }


}
