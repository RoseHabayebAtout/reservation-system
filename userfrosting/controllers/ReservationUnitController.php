<?php
        
namespace UserFrosting;

class ReservationUnitController extends \UserFrosting\BaseController {

    protected static $_table_id = "reservation_unit";
        /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }
      
    
    
     public function getReservId($reserveid){
//         
          $reservationid = ReservationUnit::where('unit_id', '=', $reserveid)->get();
        //  $additions=Addition::where('is-deleted', '=', 0)->get();
      //echo $additions; 
          return $reservationid;
        }

    public function getReservationId($reserveid){
//
        $reservationid = ReservationUnit::where('unit_id', '=', $reserveid)->get();
        //  $additions=Addition::where('is-deleted', '=', 0)->get();
        //echo $additions;
        return $reservationid[0]['reservation_id'];
    }
}