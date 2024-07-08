<?php

namespace UserFrosting;

class RentedController extends \UserFrosting\BaseController
{

    protected static $_table_id = "unit";

    public function __construct($app){

        $this->_app = $app;
    }
    public function renderRentView(){
            $this->_app->render('config/rented-units.twig');

    }

}