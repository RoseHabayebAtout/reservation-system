<?php
        
namespace UserFrosting;

class ChartsController extends \UserFrosting\BaseController {

    protected static $_table_id = "charts";
        /**
     * Create a new EmailTemplate object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }
    public function totalAppartments(){
    	$unitByAvail=Unit::get()->groupBy('available');
        if (isset($unitByAvail[0])){
            $totalReserved = sizeof($unitByAvail[0]);
        } else{
            $totalReserved = 0;
        }
        if (isset($unitByAvail[1])){
            $totalAvailable = sizeof($unitByAvail[1]);
        } else {
            $totalAvailable = 0;
        }
        if(isset($unitByAvail[2])){
            $totalPending = sizeof($unitByAvail[2]);
        } else {
            $totalPending = 0;
        }
        if(isset($unitByAvail[3])){
            $totalPurchased = sizeof($unitByAvail[3]);
        } else {
            $totalPurchased = 0;
        }
        if(isset($unitByAvail[4])){
            $totalRented = sizeof($unitByAvail[4]);
        } else {
            $totalRented = 0;
        }
        if(isset($unitByAvail[5])){
            $totalSigned = sizeof($unitByAvail[5]);
        } else {
            $totalSigned = 0;
        }

        echo json_encode(array('reserved' => $totalReserved,'available' =>$totalAvailable,
            'pending'=>$totalPending, 'purchased'=>$totalPurchased, 'rented'=>$totalRented , 'signed'=>$totalSigned));
    }
    public function appartmentsPerNeighborhood($neighborhoodParam=""){
    	$get = $this->_app->request->get();
    	$neighborhood = $neighborhoodParam ?: $get['neighborhood'];
        $neighborhoodByAvail = collect(Unit::get()->groupBy('neighborhood')[$neighborhood] )->groupBy('available');
        
        if (isset($neighborhoodByAvail[0])) {
            $totalReserved = sizeof($neighborhoodByAvail[0]);
        } else {
            $totalReserved = 0;
        }
        if (isset($neighborhoodByAvail[1])) {
            $totalAvailable = sizeof($neighborhoodByAvail[1]);
        } else {
            $totalAvailable = 0;
        }
        if (isset($neighborhoodByAvail[2])) {
            $totalPending=sizeof($neighborhoodByAvail[2]);
        } else {
            $totalPending = 0;
        }
        if (isset($neighborhoodByAvail[3])) {
            $totalPurchased = sizeof($neighborhoodByAvail[3]);
        } else {
            $totalPurchased = 0;
        }

        if (isset($neighborhoodByAvail[4])) {
            $totalRented = sizeof($neighborhoodByAvail[4]);
        } else {
            $totalRented = 0;
        }
        if (isset($neighborhoodByAvail[5])) {
            $totalSigned = sizeof($neighborhoodByAvail[5]);
        } else {
            $totalSigned = 0;
        }

        if($neighborhoodParam) {
            return array('reserved' =>$totalReserved, 'available' =>$totalAvailable,
                'pending'=>$totalPending, 'purchased'=>$totalPurchased,'rented'=>$totalRented, 'signed'=>$totalSigned);
        }
        else{
            echo json_encode(array('reserved' =>$totalReserved,'available' =>$totalAvailable,
                'pending'=>$totalPending, 'purchased'=>$totalPurchased, 'rented'=>$totalRented, 'signed'=>$totalSigned));
        }
    }
    public function getNeighborhoods(){

		$collection=Unit::get();
		$sorted_groupedBy = $collection->sortBy('neighborhood', SORT_NATURAL, false)->groupBy('neighborhood');

		echo json_encode($sorted_groupedBy);
      
    }
    
    
  //  public function getBuildingTypes(){
    public function getBuildingTypes(){

		$collection=Unit::get();
		$sorted_groupedBy = $collection->sortBy('building_type', SORT_NATURAL, false)->groupBy('building_type');

		echo json_encode($sorted_groupedBy);
      
    }
    
    
    
    public function totalAppartmentsPerNeighborhood(){
    	$units=Unit::get()->groupBy('neighborhood');
    	$dataArray=array();
    	foreach ($units as $key => $unit) {
            $ret=$this->appartmentsPerNeighborhood($unit[0]['neighborhood']);
            $obj['name']=$unit[0]['neighborhood'];
            $obj['appartments']=array('reserved' => $ret['reserved'],'available' =>$ret['available'],
                'pending'=>$ret['pending'], 'purchased'=>$ret['purchased'],'rented'=>$ret['rented'], 'signed'=>$ret['signed'] );
            array_push($dataArray,$obj);
    	}
    	echo json_encode($dataArray);
    }
    public function getFeesLastThreeMonth(){
        $get = $this->_app->request->get();
    	// current date
    	if(!isset($get['from_date'])){
       		$startDate = date("Y-m-d");   
                $startMonthDate=date("Y-m-1");		
    	}
    	else{
    		$startDate=$get['from_date'];
	    	$startMonthDate = date('Y-m-1', strtotime($startDate));
    	}
    	// previous 3 month
    	$previousThirdMonth = date('Y-m-1', strtotime($startMonthDate .' -3 months'));

    	// returned array data
    	$dataArray=array();

		// for ($startMonthDate; $startMonthDate > $previousThirdMonth ; $startMonthDate=date('Y-m-1', strtotime($startMonthDate .' -30 day'))) {
        for ($startMonthDate; $startMonthDate > $previousThirdMonth ; $startMonthDate=date('Y-m-1', strtotime($startMonthDate .'-1 months'))) {
                $sum=0;
                $reservations = Reservation::whereBetween('reservation_date', [
                            $startMonthDate,//start
                            $startDate//end
                ])
                ->get();
                foreach ($reservations as $key => $reservation) {
                        $sum+=$reservation['collected_fees'];
                }
                // get name of month
                $monthName=$this->dateToMonthName($startMonthDate);
                $arrne['month'] = $monthName;
                $arrne['collected_fees'] = $sum;
                // make stard of month end of previos month
                // $startDate=$startMonthDate;
                $startDate=date('Y-m-t', strtotime($startMonthDate . '-1 months'));
                array_push($dataArray,$arrne);
        } 	
        echo json_encode($dataArray);

    }
	public function getFeesLastThreeMonthPerNeighborhood(){
	  	$get = $this->_app->request->get();
		$neighborhood=$get['neighborhood'];

		// current date
    	if(!isset($get['from_date'])){
       		$startDate = date("Y-m-d");   
 			$startMonthDate=date("Y-m-1");		
    	}
    	else{
    		$startDate=$get['from_date'];
	    	$startMonthDate = date('Y-m-1', strtotime($startDate));
    	}

    	// previous 3 month
    	// $previousThirdMonth = date('Y-m-1', strtotime($startMonthDate .' -90 day'));
    	$previousThirdMonth = date('Y-m-1', strtotime($startMonthDate .' -3 months'));

    	// returned array data
    	$dataArray=array();

  		$unitsPerNeighborhood=Unit::where('neighborhood',$neighborhood)->get();


		// for ($startMonthDate; $startMonthDate > $previousThirdMonth ; $startMonthDate=date('Y-m-1', strtotime($startMonthDate .' -30 day'))) {
		for ($startMonthDate; $startMonthDate > $previousThirdMonth ; $startMonthDate=date('Y-m-1', strtotime($startMonthDate .'-1 months'))) {
	    	$arrObj['collected_fees']=0;
			foreach ($unitsPerNeighborhood as $key => $unitPerNeighborhood) {
			    	$sum=0;
					$reservations=$unitPerNeighborhood->reservationsRel()->whereBetween('reservation_date', [
							$startMonthDate,
						    $startDate
						])->get();
					foreach ($reservations as $key => $reservation) {
						$sum+=$reservation['collected_fees'];
					}
					// get name of month
					$monthName=$this->dateToMonthName($startMonthDate);
					$arrObj['month'] = $monthName;
					$arrObj['collected_fees'] = $arrObj['collected_fees']+$sum;


			}
		 	$startDate=date('Y-m-t', strtotime($startMonthDate .'-1 months'));
		 	// $startDate=$startMonthDate;
			array_push($dataArray,$arrObj);
		}
		echo json_encode($dataArray);
  	}
    public function dateToMonthName($startDate){
    	$timestamp = strtotime($startDate);
	  	$monthNum = date("m", $timestamp); 
		$monthName = date('F', mktime(0, 0, 0, $monthNum, 10)); // March
		return $monthName;
    }

}