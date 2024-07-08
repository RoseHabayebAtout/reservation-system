<?php

namespace UserFrosting;

class CancelReasonController extends \UserFrosting\BaseController {

    protected static $_table_id = "cancel_reason";

        /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){

        $this->_app = $app;
    }

    public function saveReasons(){
     $post = $this->_app->request->post();

      $new_reason = new CancelReason([
        "user_id" => $_SESSION['userfrosting']['user_id'],
        "unit_id" => $post['uid'],
        "flag" => $post['flag'],
        "date"=>$post['date'],
        "reason"=>$post['reason'],
          "id"=>"0"


      ]);
      $new_reason->save();

      $unit = Unit::find($post['uid']);
      $unit->available = 2;
      $unit->save();

        // send email
        $emailController = new EmailTemplateController($this->_app);
        $configController = new ConfigurationController($this->_app);
        $emailTemplateParams = $emailController->getReservationEmailInfo($post['uid']);
        $emailList = $configController->getCancellationEmailList();
        if ($emailTemplateParams) {
            $emailController->notifyingEmail($emailTemplateParams['reservedUnit'], $unit, $emailTemplateParams['user'], 'Request To Cancel Reservation Unit', $emailList);
        }

        return $new_reason;
    }

    public function saveSignedCancellationReason(){
        $post = $this->_app->request->post();

        $new_reason = new CancelReason([
            "user_id" => $_SESSION['userfrosting']['user_id'],
            "unit_id" => $post['uid'],
            "flag" => $post['flag'],
            "date"=>$post['date'],
            "reason"=>$post['reason'],
            "id"=>"0"


        ]);
        $new_reason->save();

        $unit = Unit::find($post['uid']);
        $unit->available = 6;
        $unit->save();

        // send email
        $emailController = new EmailTemplateController($this->_app);
        $configController = new ConfigurationController($this->_app);

        $emailTemplateParams = $emailController->getReservationEmailInfo($post['uid']);
        $emailList= $configController->getCancellationEmailList();

        if ($emailTemplateParams) {
            $emailController->notifyingEmail($emailTemplateParams['reservedUnit'], $unit, $emailTemplateParams['user'], 'Request To Change Unit From Signed To Available', $emailList);
        }

        return $new_reason;
    }

    public function getInfo($uid){
//
          $info = CancelReason::where('unit_id', '=', $uid)->get();
        //  $additions=Addition::where('is-deleted', '=', 0)->get();
      //echo $additions;
          return $info;
//
//          $unit = ::find($uid);
//          return $unit->user_id;


         //echo "ayat";
        }


    public function updateFlag($uid){
        $reasons = CancelReason::where('unit_id', '=', $uid)->get();
         foreach($reasons as $reason){
             if(($reason['flag'] == 1) ){
                 $reason['flag']='0';
             }
                 $reason->save();
             }
    }
}
