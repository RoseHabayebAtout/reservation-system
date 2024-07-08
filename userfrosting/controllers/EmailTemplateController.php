<?php

namespace UserFrosting;

class EmailTemplateController extends \UserFrosting\BaseController {

    protected static $_table_id = "emailTemplate";
        /**
     * Create a new EmailTemplate object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }
    public function getAllAdmins(){
        $admins=User::where('primary_group_id', 2)->get();
        return $admins;
    }
    public function sendTemplatedEmail($template,$templateParams,$recipients,$emailList){

      //  print_r($emailList);
        $user=$this->_app->user;
        // Create and send verification email
        $twig = $this->_app->view()->getEnvironment();
        $template = $twig->loadTemplate($template);
        $notification = new Notification($template);
        $notification->fromWebsite();      // Automatically sets sender and reply-to
        $templateParams['user']=$user;

        //echo  count($recipients);
//        foreach ($recipients as $recipient) {
//          $templateParams['recipient']=$recipient;
//          $notification->addEmailRecipient($recipient->email, $recipient->user_name, $templateParams);
//        }

        $emails = explode(';', $emailList);

        foreach ($emails as $recipient) {
         // $templateParams['recipient']=$recipient;
          $notification->addEmailRecipient($recipient);
        }
        // $notification->addEmailRecipient($emailList, "EmailList", $templateParams); //for emailList

        try {
            //print_r($templateParams);
           // echo 'send notification';
            $notification->send($templateParams);
            echo 'sent notification';

            //return true;
        } catch (\phpmailerException $e){
            error_log('Mailer Error: ' . $e->errorMessage());
            echo $e->errorMessage();
            //$this->_app->halt(500);
            //return false;
        }
    }

    public function createEmailTemplate(){
         $post = $this->_app->request->post();
        // Load the request schema
        $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/email-template-create.json");

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
        $new_email_template = new EmailTemplate([
          "type" => $post['type'],
          "template" => $post['template'],
      ]);
        $new_email_template->save();

        }
      public function updateEmailTemplate(){
         $post = $this->_app->request->post();
       //  // Load the request schema
       //  $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/email-template-create.json");

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

       // // Get the filtered data
       // $data = $rf->data();
         $email_templates=EmailTemplate::get();
            foreach ($email_templates as $email_template) {
                if($email_template['type']=="reservation"){
                  $email_template['title']=$post['reservationTemplate'];
                  $email_template['template']=$post['reservationTitle'];
                  $email_template->save();
                }
                if($email_template['type']=="cancellation"){
                  $email_template['title']=$post['cancellationTemplate'];
                  $email_template['template']=$post['cancellationTitle'];
                  $email_template->save();
                }

                if($email_template['type']=="purchase"){
                  $email_template['title']=$post['purchaseTemplate'];
                  $email_template['template']=$post['purchaseTitle'];
                  $email_template->save();
                }
            }
        // $new_email_template=EmailTemplate::get()->where('type', $post['type'])->first();
        // $new_email_template['template']=$post['template'];
        // $new_email_template->save();

        }
      public function getEmailTemplate(){
            $email_templates=EmailTemplate::get();
            foreach ($email_templates as $email_template) {
                if($email_template['type']=="reservation"){
                  $reservationTitle=$email_template['title'];
                  $reservationTemplate=$email_template['template'];
                }
                if($email_template['type']=="cancellation"){
                  $cancellationTitle=$email_template['title'];
                  $cancellationTemplate=$email_template['template'];
                }
                if($email_template['type']=="purchase"){
                  $purchaseTitle=$email_template['title'];
                  $purchaseTemplate=$email_template['template'];
                }
            }
            $this->_app->render('mail/email-configuration.twig', [

                "reservation_title" => $reservationTitle,
                "reservation_template" => $reservationTemplate,
                "cancellation_title" => $cancellationTitle,
                "cancellation_template" =>$cancellationTemplate,
                "purchase_title" => $purchaseTitle,
                "purchase_template" =>$purchaseTemplate,

            ]);
      }
      /*
          $reservation parameter is reservation id  in case of reservation
          and email in case of cancellation
      */
      public function sendEmail($type,$reservation,$unitId,$dicount_name,$addition_name, $email_note = ""){

        /*
        *
        * send email notification
        *
        */

           $user=$this->_app->user;



          // Get the alert message stream
          $ms = $this->_app->alerts;
          // Create and send verification email
          $twig = $this->_app->view()->getEnvironment();
          $unitParams=Unit::find($unitId);
          $emailList = array();
          if($type=="reserve"){
              $template = $twig->loadTemplate("mail/email-template.twig");
              $reservedUnit=Reservation::find($reservation);
              $reservedUnit['reservation_email_note'] = $email_note;
              $discountUnit=Discount::find($dicount_name);

              if($addition_name=='') {
                  $addition_unit = '0';
                  $additionHint = 0;
              }
             /* if($addition_name=='0'){
                  $addition_unit='0';
                  $additionHint=0;
              }
               */
              else {
                  $additionHint=1;
                  $addition_unit=Addition::find($addition_name);
              }


              $templateParams= array('user'=>$user,'unit' => $unitParams,'reservedUnit'=>$reservedUnit,'UnitType'=>$type,'discount'=>$dicount_name,'addition'=>$addition_name,'additionHint'=>$additionHint);
              //$templateParams= array('user'=>$user,'unit' => $unitParams,'reservedUnit'=>$reservedUnit,'UnitType'=>$type,'discount'=>$discountUnit,'addition'=>$addition_unit,'additionHint'=>$additionHint);
              $reservationEmailList = Configuration::where('name', '=', 'ReservationEmailList')->get()[0]->value;
              $emailList = explode(";",$reservationEmailList);
          }
          else if($type=="purchase"){
              $template = $twig->loadTemplate("mail/purchase-template.twig");
              $unit = Unit::find($unitId);
              $reservation_id=$unit->reservations($unitId)[0]['reservation_id'];
              $reservedUnit=Reservation::find($reservation_id);
              $templateParams= array('user'=>$user,'unit' => $unitParams,'reservedUnit'=>$reservedUnit,'UnitType'=>$type);
              $purchaseEmailList = Configuration::where('name', '=', 'PurchaseEmailList')->get()[0]->value;
              $emailList = explode(";",$purchaseEmailList);
          }
          else if($type=="cancell"){

              $template = $twig->loadTemplate("mail/cancel-template.twig");
              $unit = Unit::find($unitId);

              if (count($unit->reservations($unitId)) > 0) {
                  $reservation_id=$unit->reservations($unitId)[0]['reservation_id'];
                  $reservedUnit=Reservation::find($reservation_id);
                  if($dicount_name == -1){
                      $rows = CancelReason::where('unit_id', '=', $unitId)->get();;
                      $cancelReason=CancelReason::find($rows[count($rows)-1]->id);
                      //  $cancelReason=CancelReason::find($dicount_name);

                  }else{
                      $cancelReason=CancelReason::find($dicount_name);

                  }

                  $templateParams= array('user'=>$user,'unit' => $unitParams,'reservedUnit'=>$reservedUnit,'UnitType'=>$type,'cancelReason'=>$cancelReason);
                  $cancellationEmailList = Configuration::where('name', '=', 'CancellationEmailList')->get()[0]->value; // list of emails separated by ;
                  $emailList = explode(";",$cancellationEmailList);
              } else {
                  echo 'reservation not exist';
                  return;
              }

          }
          $notification = new Notification($template);
          $notification->fromWebsite();      // Automatically sets sender and reply-to

          /*get all sent to email
            1) all admins
            2)user of this reservation
            ***3)addition of  email list***
          */
          $admins=User::where('primary_group_id', 2)->get();


          $totalAdmin=sizeof($admins);
          $adminCounter=0;
          $adminExist=false;
          $adminsEmails = array();
          foreach ($admins as $admin) {
          $notification->addEmailRecipient($admin['email'], $admin['user_name'], $templateParams);
          array_push($adminsEmails, $admin['email']);
          }
          // For EmailList
          // add email list with excluding admins emails if they are repeated in email list because they were added above.
          $emailListWithoutAdmins = array_diff($emailList, $adminsEmails);
          foreach ($emailListWithoutAdmins as $email) {
              $notification->addEmailRecipient($email, $email, $templateParams);
          }
          /*
            in case of reservation is type of email this function reserves an reservation id
            if it is cancellation it receives an email of the person who cancelled it
          */

          if($type=="reserve"){
            $reservation_id=$reservation;
            $reservation=Reservation::find($reservation_id);
            $reservation_user=$reservation->users()->get();
            $reservation_user_email=$reservation_user[0]["email"];
          }
          else{
            $reservation_user_email=$reservation;
          }
          // check if admin made reservation then dont add email another time since he already added from before
          foreach ($admins as $admin) {
             if($reservation_user_email==$admin['email']){
             $adminExist=true;
            }
            $adminCounter++;
            if( $adminCounter==$totalAdmin&&!$adminExist){
              $notification->addEmailRecipient($reservation_user_email, $admin['user_name'], $templateParams);
            }
          }

          try {
              $notification->send();
          } catch (\phpmailerException $e){
              $ms->addMessageTranslated("danger", "MAIL_ERROR");
              error_log('Mailer Error: ' . $e->errorMessage());
              //$this->_app->halt(500);
          }
      }


    public function getEmailsTemplates($id = 0, $name = '')
    {
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        if ($name != '') {
            $query = "SELECT * FROM `emails_templates` WHERE STATUS = 'ACTIVE' and `name` = '" . $name . "'";
        } else if ($id == 0) {
            $query = "SELECT * FROM `emails_templates` WHERE STATUS = 'ACTIVE'";
        } else {
            $query = "SELECT * FROM `emails_templates` WHERE STATUS = 'ACTIVE' and id = " . $id;
        }

        $result = mysqli_query($conn, $query);

        if ($result->num_rows > 0) {

            $emailsTemplates = [];
            while ($row = $result->fetch_assoc()) {
                array_push($emailsTemplates,
                    [
                        "id" => $row["id"],
                        "subject" => $row["subject"],
                        "content" => $row["content"],
                        "user_id" => $row["user_id"],
                        "status" => $row["status"],
                        "created_at" => $row["created_at"],
                        "name" => $row["name"]
                    ]
                );
            }
            if ($id == 0 || $name != '') {
                return $emailsTemplates;
            } else {
                echo json_encode($emailsTemplates);
            }


        }
    }

    public function UpdateEmailsTemplates($id = 0)
    {
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $data = $this->_app->request->put();

        $query = "UPDATE `emails_templates` SET `status`='ARCHIVED' WHERE id = " . $id;
        $result = mysqli_query($conn, $query);

        if ($result) {
            $subject = $data['emailTemplateSubject'];
            $name = $data['name'];
            $content = $data['content'];
            $insertQuery = "INSERT INTO `emails_templates` (`subject`, `content`, `user_id`, `status`, `created_at`, `name`)
                             VALUES ('" . $subject . "', '" . $content . "', '" . $_SESSION['userfrosting']['user_id'] . "', '" . 'ACTIVE' . "', '" . date("Y/m/d h:i:s") . "','" . $name . "')";
            echo $insertQuery;
            $insertResult = mysqli_query($conn, $insertQuery);
            if ($insertResult) {
                echo 'Email Updated Successfully';
            } else {
                echo 'Something went wrong';
            }
        }else {
            echo 'Email unarchived';
        }
    }

    public function getEmailsAttributes()
    {
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT COLUMN_NAME,COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . $db_connection_string . "' AND TABLE_NAME in ('uf_unit','uf_reservation', '')";

        $result = mysqli_query($conn, $query);

        if ($result->num_rows > 0) {

            $columns = [];
            while ($row = $result->fetch_assoc()) {
                array_push($columns,
                    [
                        "columnName" => $row["COLUMN_NAME"],
                        "columnComment" => $row["COLUMN_COMMENT"]
                    ]
                );
            }

            array_push($columns,
                [ "columnName" => 'reason', "columnComment" => 'Cancellation Reason' ],
                [ "columnName" => 'canceled_by', "columnComment" => 'Cancellation By' ]
            );

            return $columns;
        }
    }

    public function clearVARS($contents, $reservation, $unit, $user, $storage = '', $parking = '')
    {
        $cancellation = CancelReason::where('unit_id', $unit['id'])->orderBy('id', 'desc')->first();
//        $parking_storage_reservation = parking_storage_reservation::where('uid', $unit['id'])->orderBy('id', 'desc')->first();
//        $parking = [];
//        if ($parking_storage_reservation) {
//            $parking = Parking::find($parking_storage_reservation->parking_storage_id);
//        }
//
//        $parking = collect($parking_storage_reservation)->merge(collect($parking));




        if ($contents != null) {
          //  $pattern = "/!sys_var[^\s]+/i";
            $pattern = "/!sys_var(.*?)!+/i";

            $found_matches = [];
            if (preg_match_all($pattern, $contents, $matches)) {
                $found_matches = $matches[0];
            }


            for ($x = 0; $x < sizeof($found_matches); $x++) {
                $found_matches[$x] = str_replace(array('&nbsp;', "<p>", "</p>", ""), '', $found_matches[$x]);
                $resStr = str_replace(array('.', "\n", "\t", "\r", ""), '', $found_matches[$x]);
                $strpos = stripos($resStr, ' ');
                if ($strpos > 0)
                    $resStr = substr($resStr, 0, $strpos);

                $attribute_name = str_replace("!sys_var_", "", $resStr);
                $attribute_name = explode('!', $attribute_name)[0];



                $To = '';

                if (str_contains($attribute_name,"user_did_action"))  {

                    $user_id = $_SESSION['userfrosting']['user_id'] ?? 0;
                    $userName = $this->getUserNameBuId($user_id);
                    $To = $userName;
                }
                else if (isset($reservation[$attribute_name]))  {
                    $To = $reservation[$attribute_name];
                } else if (isset($unit[$attribute_name]))  {
                    $To = $unit[$attribute_name];
                }
//                else if (isset($user[$attribute_name]))  {
//                $To = $user[$attribute_name];
//                }
                else if (isset($cancellation[$attribute_name]))  {
                $To = $cancellation[$attribute_name];
                } else if (isset($neighborhood[$attribute_name])) {
                    $To = $neighborhood[$attribute_name];
                } else if ($attribute_name == "canceled_by")  {
                    $user_id = $cancellation['user_id'] ?? 0;
                    $userName = $this->getUserNameBuId($user_id);
                    $To = $userName;
                } else {
                    if (str_contains($attribute_name, 'storage_')) {
                        $attribute_name = $this->str_replace_first("storage_", "", $attribute_name);
                        if (isset($storage[$attribute_name])) {
                            $To = $storage[$attribute_name];
                        }

                    } else if (str_contains($attribute_name, 'parking_')) {
                        $attribute_name = $this->str_replace_first("parking_", "", $attribute_name);
                        if (isset($parking[$attribute_name])) {
                            $To = $parking[$attribute_name];
                        }
                    }
                }
//                else if (isset($parking[$attribute_name]))  {
//                $To = $parking[$attribute_name];
//                }



                $contents = str_replace($found_matches[$x], $To, $contents);
            }
            $controller = new Contract1Controller($this->_app);
            $contents = $controller->ApplyFunctions($contents);

            return htmlspecialchars_decode($contents);
        } else {
            return null;
        }
    }

    function str_replace_first($from, $to, $content)
    {
        $from = '/'.preg_quote($from, '/').'/';

        return preg_replace($from, $to, $content, 1);
    }


    function notifyingEmail($reservationData, $unit, $reservation_user_data, $emailName, $emailList = '', $storage = '', $parking = '')
    {
        // send email
        $emailController = new EmailTemplateController($this->_app);
        $emailContent = $emailController->getEmailsTemplates(0, $emailName);
        $emailContentText = $emailController->clearVARS($emailContent[0]['content'], $reservationData, $unit, $reservation_user_data[0], $storage, $parking);
        $emailSubjectText = $emailController->clearVARS($emailContent[0]['subject'], $reservationData, $unit, $reservation_user_data[0] );


        $templateParams = array('content' => $emailContentText, 'subject' => $emailSubjectText);

        $recipients = array();
        $configController = new ConfigurationController($this->_app);

        // get reservation email
        $reservationController = new ReservationController($this->_app);
        $reservationUser = $reservationController->getReservationFromUnitId($unit['id']);
        array_push($recipients, $reservationUser);

        //  get all recipients emails
        $admins = $emailController->getAllAdmins();
        $length = sizeof($admins);
        for ($x = 0; $x < $length; $x++) {
            if ($reservationUser !== $admins[$x]) {

                array_push($recipients, $admins[$x]);
            }
        }

        $emailController->sendTemplatedEmail("mail/email-send-template.twig", $templateParams, $recipients, $emailList);

    }

    function getReservationEmailInfo($unitId) {

        $recipients=array();

        $unit = Unit::find($unitId);

        $reservation = $unit->reservations($unitId);

        if (count($reservation)) {
            $reservation_id = $reservation[0]['reservation_id'];

            $reservedUnit = Reservation::find($reservation_id);

            // get reservation email
            $reservationController = new ReservationController($this->_app);
            $reservationUser = $reservationController->getReservationFromUnitId($unitId);

            array_push($recipients, $reservationUser);

            $emailController = new EmailTemplateController($this->_app);
            $admins = $emailController->getAllAdmins();

            $length = sizeof($admins);

            for ($x = 0; $x < $length; $x++) {
                if ($reservationUser !== $admins[$x]) {
                    array_push($recipients, $admins[$x]);
                }
            }
            $user = $this->_app->user;

            $data = ["reservedUnit" => $reservedUnit, "user" => $user];
            return $data;
        }
        return 0;
    }

    public function getUserNameBuId($user_id)
    {
        if (!$user_id) {
            return ' ';
        }

        $user = User::find($user_id);

        return $user->display_name ?? ' ';
    }

}
