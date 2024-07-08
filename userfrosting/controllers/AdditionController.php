<?php

namespace UserFrosting;

class AdditionController extends \UserFrosting\BaseController {

    protected static $_table_id = "addition";

        /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){

        $this->_app = $app;
    }

    public function renderAdditions(){
         //echo  "ayat";
          $this->_app->render('config/addition.twig', [
          ]);
    }
    public function getAdditions(){
      $additions=Addition::where('is-deleted', '=', 0)->get();
      echo $additions;
    }
    public function getPercentage(){
      $additions=Addition::where('addition_type','=',1)->get();

    echo $additions;
    }
    public function getFixed(){
      $additions=Addition::where('is-deleted',0)->get();
//$additions = $addition->where('addition_type' ,'=', 0)->andWhere('is-deleted','=',0)->get();
      echo $additions;
    }

    public function setAdditions(){
       // console.log("hrrrr");
       // Fetch the POSTed data
       $post = $this->_app->request->post();

      /* // Load the request schema
      $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/addition-create.json");

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
      //create new Addition*/

      $new_addition = new Addition([
             "addition_type" => $post['addition_type'],
        "addition_name" => $post['addition_name'],
        "addition_value" => $post['addition_value'],
          "addition_date"=>$post['addition_date'],
          "addition_description"=>$post['addition_description']
      ]);
      $new_addition->save();
       // echo $post['addition_date']+"ayat";

    }
    public function updateAdditions(){
       // echo "ggggg";
      $post = $this->_app->request->post();
      // Load the request schema
//      $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/addition-edit.json");
//
//       // Get the alert message stream
//       $ms = $this->_app->alerts;
//
//       // Set up Fortress to process the request
//       $rf = new \Fortress\HTTPRequestFortress($ms, $requestSchema, $post);
//
//       // Sanitize
//       $rf->sanitize();
//
//       // Validate, and halt on validation errors.
//       if (!$rf->validate()) {
//           $this->_app->halt(400);
//       }
      $addition_id=$post['addition_id'];
      $addition=Addition::find($addition_id);
      $addition['addition_name']=$post['addition_name'];
      $addition['addition_value']=$post['addition_value'];
        $addition['addition_description']=$post['addition_description'];
    //  $addition['addition_date']=    $post['addition_date'];
      $addition->save();
    }
    public function deleteAddition(){
      // Fetch the POSTed data
      $post = $this->_app->request->post();
      $addition_id=$post['addition_id'];
      $addition=Addition::find($addition_id);
      $addition['is-deleted']=1;
      $addition->save();
    }

    public function getAdditionAmount(){
        $post = $this->_app->request->post();
        $addition_id=$post['addition_id'];
        $price = $post['price_val'];
        $addition=Addition::find($addition_id);

            if($addition['addition_type']==0){
                $additionVal =  $addition['addition_value'];
                $priceafterAddition =  $additionVal;
                echo $priceafterAddition;
            }
            else{
                $additionVal =  $addition['addition_value']/100;
                $priceafterAddition =  $price*$additionVal;
                echo $priceafterAddition;
            }

    }
    public function getAdditionDescrption(){

        $post = $this->_app->request->post();
        $addition_id=$post['addition_id'];
        $addition=Addition::find($addition_id);
        echo $addition['addition_description'];

    }

    public function getAddition(){
        $post = $this->_app->request->post();
        $addition_id=$post['addition_id'];
        $addition=Addition::find($addition_id);
        echo $addition['addition_value'];
    }

    public function checkExistName(){
       // echo "ayyyyyyyyt";
      $post = $this->_app->request->post();
      $addition_name = $post['addition_name'];
      $old_name = $post['old_name'];
      $flag="FALSE";
      $additions=Addition::where('is-deleted', '=', 0)->get();
      foreach($additions as $addition){
        if(($addition['addition_name'] == $addition_name) && ($addition['addition_name']  != $old_name)){
        $flag="TRUE";
        break;
      }
      }
      echo $flag;


    }

    public function getTotalPriceAfterMultipleAddition()
    {
        $post = $this->_app->request->post();
        $price = $post['price'];
        $AdditionStatics = array();
        for ($i = 0; $i < count($post["Addition_id_arr"]); $i++) {
            $addition=Addition::find($post["Addition_id_arr"][$i]);

            if ($addition['addition_type'] == 0) {
                $price = $price + $addition['addition_value'];
            } else {
                $additionVal =  $addition['addition_value']/100;
                $price = $price + ($price * $additionVal);
            }

        }

        return $price;
    }

    public function getTotalPriceAfterMultipleAdditionAndDiscount(){
        $post = $this->_app->request->post();
        $price = $post['price'];
        $percintage = 0 ;
        $staticval  = 0 ;

        $pass = $post['dis_pass'];
        $discount=Discount::find($post["discount_id_arr"][0]);
        $discountPass=$discount['password'];

        if($pass==$discountPass) {

            for ($i = 0; $i < count($post["Addition_id_arr"]); $i++) {
                $addition=Addition::find($post["Addition_id_arr"][$i]);

                if ($addition['addition_type'] == 0) {
                    $staticval = $staticval + $addition['addition_value'] ;
                } else {
                    $percintage = $percintage + $addition['addition_value'];

                }

            }

            for ($i = 0; $i < count($post["discount_id_arr"]); $i++) {
                $discount = Discount::find($post["discount_id_arr"][$i]);
                if ($discount['type'] == 0) {
                    $staticval = $staticval -  $discount['value'];

                } else {
                    $percintage = $percintage - $discount['value'];
                }

            }

            $percintage =  $percintage/100;
            $price = $price + ($price * $percintage);

            $price = $price + $staticval;

            return $price ;

         }else{
            return "FALSE";
        }

    }

}
