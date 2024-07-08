<?php
/**
 * Created by PhpStorm.
 * User: ndmedi
 * Date: 7/30/2017
 * Time: 2:38 PM
 */

namespace UserFrosting;


class UnitHistoryController extends \UserFrosting\BaseController{

    protected static $_table_id = "unit_history";
    /**
     * Create a new UnitHistoryController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */

    public function __construct($app){
        $this->_app = $app;
    }

    public function setUnitHistory($username){
        date_default_timezone_set('Asia/Amman');

        $post = $this->_app->request->post();

      $new_history = new UnitHistory([
            "user_name" => $username,
            "uid" => $post['uid'],
            "action"=> $post['action'],
            //"date"=>$post['reservation_date'],
          "date"=>date("Y-m-d h:i:s"),
          "customer_name"=>$post['customer_name']
        ]);
        $new_history->save();

        return $new_history;

    }
    public function getUnitHistory($uid){

        // Fetch  all histroy for specific unit
        $unitHistory =UnitHistory::where('uid', '=', $uid)->orderBy('date', 'asc')->get();
        return json_encode($unitHistory);

    }


}
