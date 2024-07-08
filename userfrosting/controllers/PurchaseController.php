<?php
        
namespace UserFrosting;

class PurchaseController extends \UserFrosting\BaseController { 

    protected static $_table_id = "purchase";
    
    /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }

    public function createPurchase(){


        $post = $this->_app->request->post();

        $neighborhood = Unit::where('id', $post['unit_id'])->get()[0]['neighborhood'];

        $purchase = new Purchase([
            'neighborhood' => $neighborhood,
            'purchase_date' => $post['dateOfPurchase']
        ]);
        $purchase -> save();
        echo $post['dateOfPurchase'];
    }
    
    public function getAllPurchases(){
        $response = ['message' => [], 'output' => []];
        $params = $this->_app->request->post();
        
        $from_date = $params['from_date'];
        $refined_starting_date = date('Y-m-15', strtotime($from_date));
        $neighborhood = $params['neighborhood'];
        
        for ($i = 0; $i < 3; $i++) {
            $first_day = date('Y-m-01', strtotime(
                '-'. $i . ' months', strtotime($refined_starting_date)
            ));
            $terminal_day = date('Y-m-t', strtotime(
                '-'. $i . ' months', strtotime($refined_starting_date)
            ));
            
            if ($neighborhood === 'all') {
                $nbPurchases = count(Purchase::whereBetween('purchase_date', [
                    $first_day,
                    $terminal_day
                ])->get());
            } else {
                $nbPurchases = count(Purchase::whereBetween('purchase_date', [
                    $first_day,
                    $terminal_day
                ])->get()->where('neighborhood', $neighborhood));
            }
            
            $month = date('M', strtotime(
                '-'. $i . ' months', strtotime($refined_starting_date)
            ));
            $response['output'][] = ['month' => $month, 'purchases' => $nbPurchases];
        }
        echo json_encode($response);
    }

}
