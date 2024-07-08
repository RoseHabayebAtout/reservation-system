<?php
        
namespace UserFrosting;

class ReservationUserController extends \UserFrosting\BaseController {

    protected static $_table_id = "reservation_user";
        /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }
      
    
    
     public function getUserId($uid){
//         
          $reservationUser = ReservationUser::where('reservation_id', '=', $uid)->get();
        //  $additions=Addition::where('is-deleted', '=', 0)->get();
      //echo $additions; 
          echo $reservationUser;

        }
    public function getReservedUserId($resid){
//
        $reservationUser = ReservationUser::find($resid);
        //  $additions=Addition::where('is-deleted', '=', 0)->get();
        echo $reservationUser['user_id'];
       // echo $reservationUser[0]['user_id'];

    }

    public function checkUserPass(){
        $post = $this->_app->request->post();
        
        $user_id = $_SESSION['userfrosting']['user_id'];
        $user = User::where('id', $user_id)->first();
        return $user->verifyPassword($post['user_pass']);
    }


}