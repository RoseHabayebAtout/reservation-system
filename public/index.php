<?php


// This is the path to initialize.php, your site's gateway to the rest of the UF codebase!  Make sure that it is correct!
$init_path = "../userfrosting/initialize.php";
///echo "dcdc";


// This if-block just checks that the path for initialize.php is correct.  Remove this once you know what you're doing.
if (!file_exists($init_path)) {
    echo "<h2>We can't seem to find our way to initialize.php!  Please check the require_once statement at the top of index.php, and make sure it contains the correct path to initialize.php.</h2><br>";
}

require_once($init_path);

use Illuminate\Support\Facades\DB;
use UserFrosting as UF;
use UserFrosting\CashReceiptFiles;
use UserFrosting\Contract;
use UserFrosting\ContractTemplate;
use UserFrosting\EmailTemplateController;
use UserFrosting\Payment;
use UserFrosting\Reservation;
use UserFrosting\ReservationUnit;
use UserFrosting\Unit;

if ($_SERVER['REQUEST_URI'] != '/reservation-system/public/account/loggedOut') {
    setcookie('timeout', time(), time() + (86400 * 30), "/");
    // $_COOKIE['timeout'] = time();

}

// Front page
$app->get('/', function () use ($app) {
    // This if-block detects if mod_rewrite is enabled.
    // This is just an anti-noob device, remove it if you know how to read the docs and/or breathe through your nose.
    if (isset($_SERVER['SERVER_TYPE']) && ($_SERVER['SERVER_TYPE'] == "Apache") && !isset($_SERVER['HTTP_MOD_REWRITE'])) {
        $app->render('errors/bad-config.twig');
        exit;
    }

    // Check that we can connect to the DB.  Again, you can remove this if you know what you're doing.
    if (!UF\Database::testConnection()) {
        // In case the error is because someone is trying to reinstall with new db info while still logged in, log them out
        session_destroy();
        // TODO: log out from remember me as well.
        $controller = new UF\AccountController($app);
        return $controller->pageDatabaseError();
    }

    // Forward to installation if not complete
    // TODO: Is there any way to detect that installation was complete, but the DB is malfunctioning?
    if (!isset($app->site->install_status) || $app->site->install_status == "pending") {
        $app->redirect($app->urlFor('uri_install'));
    }

    // Forward to the user's landing page (if logged in), otherwise take them to the home page
    // This is probably where you, the developer, would start making changes if you need to change the default behavior.
    if ($app->user->isGuest()) {
        $controller = new UF\AccountController($app);
        $controller->pageHome();
        // If this is the first the root user is logging in, take them to site settings
    } else if ($app->user->id == $app->config('user_id_master') && $app->site->install_status == "new") {
        $app->site->install_status = "complete";
        $app->site->store();
        $app->alerts->addMessage("success", "Congratulations, you've successfully logged in for the first time.  Please take a moment to customize your site settings.");
        session_start(); // ready to go!


        $app->redirect($app->urlFor('uri_settings'));
    } else {
        $app->redirect($app->user->landing_page);
    }
})->name('uri_home');

/********** FEATURE PAGES **********/

$app->get('/dashboard/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_dashboard')) {
        $app->notFound();
    }

    $controller = new UF\AccountController($app);

    $app->render('dashboard.twig', []);

});

//  $app->get('/account/loggedOut/?', function () use ($app) {

// $inActive = 120;//seconds
// //if(isset($_SESSION['timeout']) ) {
// $session_life = time() - $_SESSION['timeout'];
// if($session_life >= $inActive){

//     //unset($_SESSION['timeout']);
//    // echo "0".$inActive." ".$session_life."  ".$_SESSION['timeout'];
//    echo "0";

// }

// else{
//     //echo "1".$inActive." ".$session_life."  ".$_SESSION['timeout'];
//     echo "1";

// }
// //}


//     });

/*added by fadi*/
/*
 *
 *unit Routing
 *
 */
$app->post('/unit/available/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }


    // get post param
    $post = $app->request->post();
    $controller = new UF\UnitController($app);
    $emailController = new UF\EmailTemplateController($app);
    $reservationController = new UF\ReservationController($app);
    $configController = new UF\ConfigurationController($app);
    $unit = $controller->getUnitFromId($post['uid']);

    /*
        flag to check if sending email is needed

    */
    $sendEmail = false;
    $templateParams = array('unit' => $unit);
    //uri_unit_r($templateParams);

    if ($unit['available'] == 0 && $post['available'] == 2) {
        $sendEmail = "requestToCancel";
        $templateParams['requestToCancelReason'] = $post['requestToCancelReason'];
    } else if ($unit['available'] == 2 && $post['available'] == 0) {
        $sendEmail = "pendingRejected";
    } else if ($unit['available'] == 2 && $post['available'] == 1) {
        $sendEmail = "pendingAccepted";
    } else if ($unit['available'] == 6 && $post['available'] == 5) {
        $sendEmail = "pendingSignedRejected";
    }

    $recipients = array();
    $reservationUser = "";
    $controller->updateUnitFlag();
    $emailList = $configController->getCancellationEmailList();
    // uri_unit_r($emailList);
    if ($sendEmail != false) {
        // get reservation email
        $reservationUser = $reservationController->getReservationFromUnitId($post['uid']);
        if ($reservationUser === '') {
            $sendEmail = 'do not send email because we have data issue';
        }

        array_push($recipients, $reservationUser);
    }

    /*
         get all recipients emails
    */
    //$state ="";
    $admins = $emailController->getAllAdmins();

    $length = sizeof($admins);
    for ($x = 0; $x < $length; $x++) {
        if ($reservationUser !== $admins[$x]) {

            array_push($recipients, $admins[$x]);
        }
    }

    $emailTemplateParams = $emailController->getReservationEmailInfo($post['uid']);


    if ($sendEmail == "requestToCancel") {
        //$state=
        echo $emailController->sendTemplatedEmail("mail/request-to-cancel.twig", $templateParams, $recipients, $emailList);
    } else if ($sendEmail == "pendingRejected") {
        if ($emailTemplateParams) {
            $emailController->notifyingEmail($emailTemplateParams['reservedUnit'], $unit, $emailTemplateParams['user'], 'Unit Cancellation Request Rejected', $emailList);
        }
    } else if ($sendEmail == "pendingAccepted") {
        if ($emailTemplateParams) {
            $emailController->notifyingEmail($emailTemplateParams['reservedUnit'], $unit, $emailTemplateParams['user'], 'Unit Cancellation Request Approved', $emailList);
        }
    } else if ($sendEmail == "pendingSignedRejected") {
        if ($emailTemplateParams) {
            $emailController->notifyingEmail($emailTemplateParams['reservedUnit'], $unit, $emailTemplateParams['user'], 'Rejection of Changing Unit From Signed To Available', $emailList);
        }
    }


    return true;
});

$app->post('/unit/pdfuri_unitFlag/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\UnitController($app);
    return $controller->updatepdfuri_unitFlag();
});
$app->get('/unit/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    // either new or old, it should live at most for another hour


    $controller = new UF\UnitController($app);
    return $controller->getUnit();

});


$app->get('/getInfo/:id/?', function ($id) use ($app) {

    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    // either new or old, it should live at most for another hour

    $controller = new UF\UnitController($app);
    echo $controller->getUnitFromId($id);

});

$app->get('/unit/reserved/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit') && !$app->user->checkAccess('uri_dashboard')) {
        $app->notFound();
    }
    $controller = new UF\UnitController($app);
    return $controller->getReservedAppartmentsId();

});
/*chech primary group to see if admin or user
    if admin then return all data
    if user then return all available unit
    and return all previous regestration
*/
$app->get('/unit/data/?', function () use ($app) {
    // Access-controlled page

    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $unitController = new UF\UnitController($app);
    echo json_encode($unitController->getUnitDataAdmin());
});

//get the history for specified Unit
$app->get('/unit/unitHistory/:uid?', function ($uid) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $unitHistoryController = new UF\UnitHistoryController($app);
    echo $unitHistoryController->getUnitHistory($uid);

    //if sales

});

//route for editinUnit

//get the history for specified Unit
$app->post('/unit/editUnits/', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $unitController = new UF\UnitController($app);
    echo $unitController->editUnits();

    //if sales

});


/*
 *
 *reservation Routing
 *
//     */
//    $app->post('/reservation/?', function () use ($app) {
//        // Access-controlled page
//        if (!$app->user->checkAccess('uri_unit')){
//            $app->notFound();
//        }
//        //Tamer:
//        $post = $app->request->post();
//        $controller = new UF\ReservationController($app);
//        $emailController = new UF\EmailTemplateController($app);
//        $reservsation=$controller->createReservation();
//        $unitcontroller = new UF\UnitController($app);
//        //keef bde at2kd mn el id ele bde o5dha mn post
//        $unit=$unitcontroller->getUnitFromId($post['uid']);
//        $templateParams= array('unit' => $unit);
//         array_push($templateParams, $reservation);
//
//
//        $recipients=array();
//        $reservationUser="";
//
//        //which func shall i use getReservationFromUnitId
//        $reservationUser=$reservationController->getReservation($post['uid']);
//        array_push($recipients, $reservationUser);
//
//        $admins=$emailController->getAllAdmins();
//        $length=sizeof($admins);
//        for ($x = 0; $x < $length; $x++) {
//            if($reservationUser!==$admins[$x]){
//                array_push($recipients, $admins[$x]);
//            }
//        }
//  echo $emailController->sendTemplatedEmail("mail/DynamicReservation.twig",$templateParams,$recipients);
////is it needed
//   return true;
//
//// echo $emailController->sendEmail("reservation",$reservsation_id);
//       //Tamer
//       // echo $emailController->sendEmail("purchase",$reservsation_id);
//    });
//
// added by moath for reservation email content
$app->post('/reservation/emailContent/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    //$app->render("mail/email-template.twig",$templateParams);
    $reservationController = new UF\ReservationController($app);
    echo $reservationController->reviewReservationEmail();
});

$app->get('/reservation/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $controller = new UF\ReservationController($app);
    $reservation_details = $controller->getReservation($id);
    if ($reservation_details != null) {
        echo $controller->getReservation($id);
    } else {
        $app->halt(401);
    }
});
// Delete user
$app->delete('/reservation/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $post = $app->request->post();
    $controller = new UF\ReservationController($app);
    $emailController = new UF\EmailTemplateController($app);
    $unitController = new UF\UnitController($app);
    $retUnit = $unitController->getCertainUnit();
    $cancelID = $post['cancelID'];
    //echo $cancelID;
    echo $emailController->sendEmail("cancell", $post['uid'], $post['uid'], $cancelID, " ");
    $controller->deleteReservation();

});

// change to availableUnit
$app->post('/unit/changeToAvailable/', function () use ($app) {
    // Access-controlled page

    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    //echo "post";
    $post = $app->request->post();
    $reservationController = new UF\ReservationController($app);
    $configController = new UF\ConfigurationController($app);
    $emailController = new UF\EmailTemplateController($app);
    $controller = new UF\UnitController($app);


    $unit_info = $controller->getUnitFromId($post['unitId']);

    $unit = Unit::find($post['unitId']);

    if (count($unit->reservations($post['unitId']))) {
        $reservation_id = $unit->reservations($post['unitId'])[0]['reservation_id'];

        $reservedUnit = Reservation::find($reservation_id);
        $user = $app->user;

        $emailContent = $emailController->getEmailsTemplates(0, 'Change Unit To Available');
        $emailContentText = $emailController->clearVARS($emailContent[0]['content'], $reservedUnit, $unit_info, $user);
        $emailSubjectText = $emailController->clearVARS($emailContent[0]['subject'], $reservedUnit, $unit_info, $user);

        $templateParams = array('content' => $emailContentText, 'subject' => $emailSubjectText);

        $recipients = array();
        $emailList = $configController->getCancellationEmailList();

        // get reservation email
        $reservationUser = $reservationController->getReservationFromUnitId($post['unitId']);
        array_push($recipients, $reservationUser);

        /*
             get all recipients emails
        */
        //$state ="";
        $admins = $emailController->getAllAdmins();
        $length = sizeof($admins);
        for ($x = 0; $x < $length; $x++) {
            if ($reservationUser !== $admins[$x]) {

                array_push($recipients, $admins[$x]);
            }
        }


        $emailController->sendTemplatedEmail("mail/email-send-template.twig", $templateParams, $recipients, $emailList);

    } else {
        echo 'no reservation exist';
    }

    echo $controller->changeToAvailable();
});

$app->post('/unit/changeSignedToAvailable/', function () use ($app) {
    // Access-controlled page

    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    //echo "post";
    $post = $app->request->post();
    $reservationController = new UF\ReservationController($app);
    $configController = new UF\ConfigurationController($app);
    $emailController = new UF\EmailTemplateController($app);
    $controller = new UF\UnitController($app);

    $unit_info = $controller->getUnitFromId($post['unitId']);

    $unit = Unit::find($post['unitId']);

    if (count($unit->reservations($post['unitId']))) {
        $reservation_id = $unit->reservations($post['unitId'])[0]['reservation_id'];

        $reservedUnit = Reservation::find($reservation_id);
        $user = $app->user;

        $emailContent = $emailController->getEmailsTemplates(0, 'Approval of Changing Unit From Signed To Available');
        $emailContentText = $emailController->clearVARS($emailContent[0]['content'], $reservedUnit, $unit_info, $user);
        $emailSubjectText = $emailController->clearVARS($emailContent[0]['subject'], $reservedUnit, $unit_info, $user);

        $templateParams = array('content' => $emailContentText, 'subject' => $emailSubjectText);

        $recipients = array();
        $emailList = $configController->getCancellationEmailList();

        // get reservation email
        $reservationUser = $reservationController->getReservationFromUnitId($post['unitId']);
        array_push($recipients, $reservationUser);

        /*
             get all recipients emails
        */
        //$state ="";
        $admins = $emailController->getAllAdmins();
        $length = sizeof($admins);
        for ($x = 0; $x < $length; $x++) {
            if ($reservationUser !== $admins[$x]) {

                array_push($recipients, $admins[$x]);
            }
        }


        $emailController->sendTemplatedEmail("mail/email-send-template.twig", $templateParams, $recipients, $emailList);

    } else {
        echo 'no reservation exist';
    }

    echo $controller->changeSignedToAvailable();
});


//added by maysam for testing mssql server database
$app->post('/reservation/price/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\ReservationController($app);
    echo $controller->getPrice();

});

$app->post('/reservation/Temp/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $controller = new UF\ReservationController($app);
    $reservsation_temp = $controller->SaveTempReservation();
    echo $reservsation_temp;

});

$app->get('/reservation/getTemp/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\ReservationController($app);
    echo $controller->GetTempReservation($id);

});

$app->get('/currency/unit/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\ReservationController($app);
    echo $controller->GetCurrencyOfUnit($id);
});

$app->get('/currency/UnitByReservation/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $unit = Unit::find($id);

    $reservation = $unit->reservations($id);

    if (count($reservation)) {
        $reservation_id = $reservation[0]['reservation_id'];

        $reservedUnit = Reservation::find($reservation_id);
        echo $reservedUnit['currency'];
    } else {
        echo ' ';
    }
});

$app->get('/currency/Unit_Reservation/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $unit = Unit::find($id);

    $unit_currency = $unit['price_currency'];

    $reservation = $unit->reservations($id);

    if (count($reservation)) {
        $reservation_id = $reservation[0]['reservation_id'];

        $reservedUnit = Reservation::find($reservation_id);

        if ($unit_currency == $reservedUnit['currency']) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
});


$app->post('/reservation/getDiscountCatigory/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $controller = new UF\DiscountController($app);
    echo $controller->getTotalPriceAfterMultipleDiscount();

});

$app->post('/reservation/getAdditionCatigory/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $controller = new UF\AdditionController($app);
    echo $controller->getTotalPriceAfterMultipleAddition();

});

$app->post('/reservation/getAdditionAndDiscountCatigory/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $controller = new UF\AdditionController($app);
    echo $controller->getTotalPriceAfterMultipleAdditionAndDiscount();

});


//ended by maysam
//Added by maysam to get discounted price after password is verified
$app->post('/reservation/getDiscountAmount/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\DiscountController($app);
    return $controller->getDiscountAmount();

});

$app->post('/reservation/getDiscountDescrption/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\DiscountController($app);
    return $controller->getDiscountDescrption();

});


$app->post('/reservation/getAdditionAmount/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\AdditionController($app);
    return $controller->getAdditionAmount();

});

$app->post('/reservation/getAddition/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\AdditionController($app);
    return $controller->getAddition();

});


$app->post('/reservation/getAdditionDescrption/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\AdditionController($app);
    return $controller->getAdditionDescrption();

});

$app->post('/reservation/checkUserPass/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\ReservationUserController($app);
    echo $controller->checkUserPass();

});

//end added by maysam
/*
*
*checkbook Routing
*
*/
$app->get('/checkbook/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_checkbook')) {
        $app->notFound();
    }
    $controller = new UF\CheckbookController($app);
    echo $controller->getCheckbook($id);

});
// delete checkbook
$app->delete('/checkbook/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_checkbook')) {
        $app->notFound();
    }
    $controller = new UF\CheckbookController($app);
    return $controller->deleteCheckbook();
});
$app->post('/checkbook/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_checkbook')) {
        $app->notFound();
    }
    $controller = new UF\CheckbookController($app);
    return $controller->createCheckbook();

});
/*
*
*Email Management Routing
*
*/
$app->get('/emailsManagement/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_email_management')) {
        $app->notFound();
    }
    $controller = new UF\EmailTemplateController($app);
    return $controller->getEmailTemplate();

});
$app->post('/emailsManagement/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_email_management')) {
        $app->notFound();
    }
    $controller = new UF\EmailTemplateController($app);
    return $controller->createEmailTemplate();

});
$app->put('/emailsManagement/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_email_management')) {
        $app->notFound();
    }
    $controller = new UF\EmailTemplateController($app);
    return $controller->updateEmailTemplate();

});


$app->get('/contract1/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_smtp_mail_config')) {
        $app->notFound();
    }

    $controller = new UF\Contract1Controller($app);
    return $controller->getcontract1Template();
});

$app->get('/Export-Contract1-Report/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_smtp_mail_config')) {
        $app->notFound();
    }
    return $app->render('unit/Editable_Contract/export-contract1-report.twig');

});

$app->get('/contract2/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_smtp_mail_config')) {
        $app->notFound();
    }

    $controller = new UF\Contract2Controller($app);
    return $controller->getcontract2Template();
});

$app->get('/contract3/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_smtp_mail_config')) {
        $app->notFound();
    }

    $controller = new UF\Contract3Controller($app);
    return $controller->getcontract3Template();
});

$app->get('/receipt/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_smtp_mail_config')) {
        $app->notFound();
    }

    $controller = new UF\ReservationController($app);
    return $controller->getReceiptTemplate();
});


/*
*
*SMTP Mail
*
*/
$app->get('/smtpMailConfig/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_settings')) {
        $app->notFound();
    }
    $controller = new UF\SmtpMailConfigController($app);
    return $controller->getSmtpConfigTemplate();
});

$app->post('/smtpMailConfig/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_settings')) {
        $app->notFound();
    }
    $controller = new UF\SmtpMailConfigController($app);
    return $controller->setSmtpConfigTemplate();

});


//Added to save the emailList
$app->post('/smtpMailConfig/save/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_settings')) {
        $app->notFound();
    }
    $controller = new UF\ConfigurationController($app);
    return $controller->saveEmailList();

});

$app->get('/smtpMailConfig/getEmailList/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_settings')) {
        $app->notFound();
    }
    $controller = new UF\ConfigurationController($app);
    return $controller->getEmailList();
});

/*
* Added by Maysam for MySQL Configurations
*/
$app->get('/mysqlConfig/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_mysql_config')) {
        $app->notFound();
    }
    $controller = new UF\MysqlController($app);
    return $controller->getMysqlTemplate();

});
$app->post('/mysqlConfig/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_mysql_config')) {
        $app->notFound();
    }
    $controller = new UF\MysqlController($app);
    return $controller->setMysqlTemplate();

});

/*
*Added by Maysam MSSQL Configuration
*/
$app->get('/mssqlConfig/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_mssql_config')) {
        $app->notFound();
    }
    $controller = new UF\MssqlController($app);
    return $controller->getMssqlConfigTemplate();
});

$app->put('/mssqlConfig/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_mssql_config')) {
        $app->notFound();
    }
    $controller = new UF\MssqlController($app);
    return $controller->updateMssqlConfig();
});
// ended by maysam

//Added by Noora to get additional Price Data
$app->post('/mssqlConfig/getPrice/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }


    $controller = new UF\ReservationController($app);
    $MssqlController = new UF\MssqlController($app);
    $configs = $MssqlController->getMssqlConfigs();
    echo $controller->getPrice();

});


$app->get('/testword/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_upload')) {
        $app->notFound();
    }
    //$controller = new UF\Contract1Controller($app);
    // return $controller->createword();
    return $app->render('unit/contract1_word_doc.twig');
});


// Ahmad Tome , get collected fees
$app->get('/collectedfees/', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\ConfigurationController($app);
    echo $controller->getCollectedFees();

});

$app->get('/currencies/', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\ConfigurationController($app);
    echo $controller->getCurrencies();

});


/*
 *Added by Maysam Contract1
 */
$app->post('/contract1/', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract1Controller($app);
    return $controller->createContract1();

});
$app->post('/contract1get/', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract1Controller($app);
    return $controller->getAllContracts();

});
$app->get('/contract1/:id/?', function ($id) use ($app) {
    // Access-controlled page

    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract1Controller($app);
    $contract1 = $controller->getContract1($id);
    $payments1Controller = new UF\Payments1Controller($app);
    $contract1['payments'] = $payments1Controller->getPayment($id);
    echo $contract1;
});
//Edit By Ahmad Tome
$app->get('/checkneighborhood/:neighborhood/?', function ($neighborhood) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $contract1controller = new UF\Contract1Controller($app);
    $checkneighborhood = $contract1controller->checkneighborhood($neighborhood);
    echo $checkneighborhood;
});


// Add contract1-edit
$app->post('/contract1/edit/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract1Controller($app);
    return $controller->updateContract1();
});

$app->post('/contract1/editcontent/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract1Controller($app);
    return $controller->updateContract1Content();
});

$app->post('/contract2/editcontent/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract2Controller($app);
    return $controller->updateContract2Content();
});

$app->post('/contract3/editcontent/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract3Controller($app);
    return $controller->updateContract3Content();
});

$app->post('/receipt/editcontent/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\ReservationController($app);
    return $controller->updateReceiptContent();
});

// Add contract2-edit
$app->post('/contract2/edit/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract2Controller($app);
    return $controller->updateContract2();
});
// Add contract3-edit
$app->post('/contract3/edit/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract3Controller($app);
    return $controller->updateContract3();
});
$app->post('/payments', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Payments1Controller($app);
    return $controller->createPayment1();

});
$app->post('/parkingStorage/payments', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Payments1Controller($app);
    return $controller->createStorageParkingPayment();

});
// Add contract2-edit
$app->post('/contract2/edit/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract2Controller($app);
    return $controller->updateContract2();
});
// Add contract3-edit
$app->post('/contract3/edit/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract3Controller($app);
    return $controller->updateContract3();
});


$app->post('/payments1Edit/', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Payments1Controller($app);
    return $controller->editPayment1();

});


// official method to create reservation
$app->post('/reservation/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $post = $app->request->post();
    $controller = new UF\ReservationController($app);
    $emailController = new UF\EmailTemplateController($app);
    $configController = new  UF\ConfigurationController($app);
    $reservationController = new UF\ReservationController($app);
    $contract1Controller = new UF\Contract1Controller($app);
    $reservsation_arr = $controller->createReservation();
    $reservsation_id = $reservsation_arr['id'];
    // echo $reservsation_id;

    $unit = Unit::find($post['uid']);
    $reservedUnit = Reservation::find($reservsation_id);

    $user = $app->user;

    $emailContent = $emailController->getEmailsTemplates(0, 'Reservation Unit Email');
    $emailContentText = $emailController->clearVARS($emailContent[0]['content'], $reservedUnit, $unit, $user);
    $emailSubjectText = $emailController->clearVARS($emailContent[0]['subject'], $reservedUnit, $unit, $user);

    $templateParams = array('content' => $emailContentText, 'subject' => $emailSubjectText);

    $recipients = array();
    $emailList = $configController->getEmailListVal();


    // get reservation email
    $reservationUser = $reservationController->getReservationFromUnitId($post['uid']);
    array_push($recipients, $reservationUser);

    /*
         get all recipients emails
    */
    //$state ="";
    $admins = $emailController->getAllAdmins();
    $length = sizeof($admins);
    for ($x = 0; $x < $length; $x++) {
        if ($reservationUser !== $admins[$x]) {

            array_push($recipients, $admins[$x]);
        }
    }

    $contract1Controller->reservationContent($reservedUnit, $unit, $post['uid'], $reservsation_arr);
    $emailController->sendTemplatedEmail("mail/email-send-template.twig", $templateParams, $recipients, $emailList);


    //echo $emailController->sendEmail("reserve",$reservsation_id,$post['uid'], $post['discount_name'], $post['addition_name'], $post['reservation_email_note']);
    //Tamer
    //echo $emailController->sendEmail("purchase",$reservsation_id);
});
$app->post('/reservation/?', function () use ($app) {

    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $post = $app->request->post();
    $controller = new UF\ReservationController($app);
    $emailController = new UF\EmailTemplateController($app);
    $reservsation_id = $controller->createReservation();
    echo $reservsation_id;
    echo $emailController->sendEmail("reserve", $reservsation_id, $post['uid'], $post['discount_name'], $post['addition_name'], $post['reservation_email_note']);
    //Tamer
    //echo $emailController->sendEmail("purchase",$reservsation_id);
});

//  Route for the unit history

$app->post('/unit/setHistory/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    // get post param
    $post = $app->request->post();

    $historyController = new UF\UnitHistoryController($app);
    $userController = new UF\UserController($app);
    $current_user_id = $_SESSION["userfrosting"]["user_id"];
    $username = $userController->getUserName($current_user_id)[0]['user_name'];
    echo $historyController->setUnitHistory($username);


});

$app->put('/unit/ChangeToSigned/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    // get post param
    $post = $app->request->post();
    UF\Unit::where('id', '=', $post['unitID'])->update(array('available' => 5));
});

//$app->post('/reservation/?', function () use ($app) {
//        // Access-controlled page
//        if (!$app->user->checkAccess('uri_unit')){
//            $app->notFound();
//        }
//        //Tamer:
//        $post = $app->request->post();
//        $controller = new UF\ReservationController($app);
//        $emailController = new UF\EmailTemplateController($app);
//        $reservsation=$controller->createReservation();
//        $unitcontroller = new UF\UnitController($app);
//        //keef bde at2kd mn el id ele bde o5dha mn post
//        $unit=$unitcontroller->getUnitFromId($post['uid']);
//        $templateParams= array('unit' => $unit);
//         array_push($templateParams, $reservation);
//
//
//        $recipients=array();
//        $reservationUser="";
//
//        //which func shall i use getReservationFromUnitId
//        $reservationUser=$reservationController->getReservation($post['uid']);
//        array_push($recipients, $reservationUser);
//
//        $admins=$emailController->getAllAdmins();
//        $length=sizeof($admins);
//        for ($x = 0; $x < $length; $x++) {
//            if($reservationUser!==$admins[$x]){
//                array_push($recipients, $admins[$x]);
//            }
//        }
//  echo $emailController->sendTemplatedEmail("mail/DynamicReservation.twig",$templateParams,$recipients);
////is it needed
//   return true;
//
//// echo $emailController->sendEmail("reservation",$reservsation_id);
//       //Tamer
//       // echo $emailController->sendEmail("purchase",$reservsation_id);
//    });
//


//////////////////////////heeeeeeeeeeeereeeeeee////////
$app->post('/purchase/', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $post = $app->request->post();

    $controller = new UF\PurchaseController($app);
    $emailController = new UF\EmailTemplateController($app);

    $reservsation_id = $controller->createPurchase();

    echo $emailController->sendEmail("purchase", $reservsation_id, $post['unit_id'], " ", " ", '');

    //return $controller->createPurchase();

});

$app->post('/get-all-purchases/', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\PurchaseController($app);
    return $controller->getAllPurchases();
});

$app->get('/payments/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Payments1Controller($app);
    echo $controller->getPayment($id);
});

$app->get('/parkingStorage/payments/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Payments1Controller($app);
    echo $controller->getParkingStoragePayment($id);
});

$app->get('/payment/upcoming/?', function () use ($app) {

    // Access-controlled page
    if (!$app->user->checkAccess('uri_dashboard')) {
        $app->notFound();
    }

    $get = $app->request->get();
    $fromDate = $get['fromDate'];
    $toDate = $get['toDate'];

    $controller = new UF\Payments1Controller($app);

    return $controller->getPaymentsForContract($fromDate, $toDate);
});

$app->post('/contract2/', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract2Controller($app);
    return $controller->createContract2();
});
$app->post('/contract2/serial/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract2Controller($app);
    return $controller->updateserial();
});

$app->post('/contract3/', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract3Controller($app);
    return $controller->createContract3();
});
$app->get('/contract3/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract3Controller($app);
    echo $controller->getContract3($id);
});


$app->get('/final/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\SerialNumberController($app);
    echo $controller->getserial();
});


$app->post('/finall/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\SerialNumberController($app);
    echo $controller->updateserial();
});

$app->get('/contract2/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract2Controller($app);
    echo $controller->getContract2($id);
});

///** Added by Ayat Salman **//
$app->get('/contract22/:previd/?', function ($previd) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract2Controller($app);
    echo $controller->getfinalserial($previd);
});


$app->get('/reservationUser/:uid/?', function ($uid) use ($app) {
    // Access-controlled page
    $controller = new UF\ReservationUserController($app);
    echo $controller->getUserId($uid);
    //
});

$app->get('/reservationUsername/:reservationID/?', function ($resid) use ($app) {
    // Access-controlled page
    $controller = new UF\ReservationUserController($app);
    $userConrtoller = new UF\UserController($app);
    $userID = $controller->getUserId($resid);
    $user = $userConrtoller->getUserName($userID[0]['user_id']);
    echo $user[0]['user_name'];

});

//route for function to get the username from userId
$app->get('/cancellationUsername/:userID/?', function ($userId) use ($app) {
    // Access-controlled page
    $userConrtoller = new UF\UserController($app);
    $user = $userConrtoller->getUserName($userId);
    echo $user[0]['user_name'];

});

//route for function to get the username who edit the contract
$app->get('/editionUser/:uid/?', function ($uid) use ($app) {
    // Access-controlled page
    $controller = new UF\ReservationUnitController($app);
    $resController = new UF\ReservationUserController($app);
    $userConrtoller = new UF\UserController($app);
    $resID = $controller->getReservationId($uid);
    //echo $resID;
    $userID = $resController->getUserId($resID);
    echo $userID;
    /*$user= $userConrtoller->getUserName($userID[0]['user_id']);
    echo $user[0]['user_name'];*/

});

$app->get('/reservationUnit/:reservation_id/?', function ($reservation_id) use ($app) {
    // Access-controlled page

    $controller = new UF\ReservationUnitController($app);
    echo $controller->getReservId($reservation_id);
//
});


// ended by maysam

// Get Neighborhood Data
$app->get('/neighborhoodData/:neighborhood/?', function ($neighborhood) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\NeighborhoodsController($app);
    echo $controller->getNeighborhood($neighborhood);

});

/*
*
*DISCOUNT
*
*/
$app->get('/discount/all/?', function () use ($app) {
    $controller = new UF\DiscountController($app);
    return $controller->getDiscounts();
});
$app->get('/discount/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_discount')) {
        $app->notFound();
    }
    $controller = new UF\DiscountController($app);
    return $controller->renderDiscounts();
});
$app->post('/discount/edit/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_discount')) {
        $app->notFound();
    }
    $controller = new UF\DiscountController($app);
    return $controller->updateDiscounts();
});
$app->post('/discount/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_discount')) {
        $app->notFound();
    }
    $controller = new UF\DiscountController($app);
    return $controller->setDiscounts();

});
$app->post('/discount/checkName/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_discount')) {
        $app->notFound();
    }
    $controller = new UF\DiscountController($app);
    return $controller->checkExistName();

});
$app->delete('/discount/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_discount')) {
        $app->notFound();
    }
    $controller = new UF\DiscountController($app);
    return $controller->deleteDiscount();

});
///*** Addition ***///
/*$app->get('/addition/?', function () use ($app) {
       // Access-controlled page
       if (!$app->user->checkAccess('uri_addition')){
           $app->notFound();
       }

         $controller = new UF\AdditionController($app);
     echo  "ayat";
         return $controller->renderAdditions();

    // $app->render('config/addition.twig', []);
   });

*/


///** Added by Ayat Salman **///
// cancel reason //
$app->post('/cancelreason/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\CancelReasonController($app);
    echo json_encode($controller->saveReasons());
});

$app->post('/cancelSignedreason/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\CancelReasonController($app);
    echo json_encode($controller->saveSignedCancellationReason());
});

$app->get('/cancelreason/:uid/?', function ($uid) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\CancelReasonController($app);
    echo $controller->getInfo($uid);
});

$app->get('/username/:uid/?', function ($user_id) use ($app) {
    // Access-controlled page

    $controller = new UF\UserController($app);
    echo $controller->getUserName($user_id);
});


$app->get('/cancelreaso/:uid/?', function ($uid) use ($app) {
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\CancelReasonController($app);
    echo $controller->updateFlag($uid);
});


// additions //
$app->get('/addition/all/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_addition') && !$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\AdditionController($app);
    return $controller->getAdditions();
});
$app->get('/addition/percentage/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_addition')) {
        $app->notFound();
    }
    $controller = new UF\AdditionController($app);
    return $controller->getPercentage();
});
$app->get('/addition/fixed/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_addition')) {
        $app->notFound();
    }
    $controller = new UF\AdditionController($app);
    return $controller->getFixed();
});
$app->get('/addition/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_addition')) {
        $app->notFound();
    }
    $controller = new UF\AdditionController($app);
    return $controller->renderAdditions();
});
$app->post('/addition/edit/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_addition')) {
        $app->notFound();
    }
    $controller = new UF\AdditionController($app);
    return $controller->updateAdditions();
});
$app->post('/addition/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_addition')) {
        $app->notFound();
    }
    $controller = new UF\AdditionController($app);
    return $controller->setAdditions();

});
$app->post('/addition/checkName/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_addition')) {
        $app->notFound();
    }
    $controller = new UF\AdditionController($app);

    return $controller->checkExistName();

});
$app->delete('/addition/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_addition')) {
        $app->notFound();
    }
    $controller = new UF\AdditionController($app);
    return $controller->deleteAddition();
});

// upload units from excel //
$app->get('/uploadunits/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_upload')) {
        $app->notFound();
    }
    $app->render('config/uploadunits.twig');
});

$app->get('/uploadStorage/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_upload')) {
        $app->notFound();
    }
    $app->render('config/uploadStorage.twig');
});

$app->get('/uploadParking/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_upload')) {
        $app->notFound();
    }
    $app->render('config/uploadParking.twig');
});

$app->get('/uploadExtraParking/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_upload')) {
        $app->notFound();
    }
    $app->render('config/uploadExtraParking.twig');
});

///** ended by Ayat Salman **//
//Added By Noora
/*******Route For RentedUnits*************/
$app->get('/rented/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_rented')) {
        $app->notFound();
    }
    $app->render('config/rented-units.twig');
});

$app->get('/unit/getRentedUnits/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_rented')) {
        $app->notFound();
    }
    //$app->render('rented/rented-units.twig', []);
    $controller = new UF\UnitController($app);
    return $controller->getRentedUnits();
});

$app->get('/getStorages/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    //$app->render('rented/rented-units.twig', []);
    $controller = new UF\UnitController($app);
    return $controller->getStorages();
});

$app->get('/getStorageInfo/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\UnitController($app);
    return $controller->getStorageInfo();
});

$app->get('/getParkingInfo/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\UnitController($app);
    return $controller->getParkingInfo();
});

$app->get('/getExtraParkingInfo/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\UnitController($app);
    return $controller->getExtraParkingInfo();
});

$app->get('/getParkings/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    //$app->render('rented/rented-units.twig', []);
    $controller = new UF\UnitController($app);
    return $controller->getParkings();
});

$app->get('/getExtraParkings/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    //$app->render('rented/rented-units.twig', []);
    $controller = new UF\UnitController($app);
    return $controller->getExtraParkings();
});

$app->get('/unit/getAvailableUnits/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_unit') && !$app->user->checkAccess('uri_rented')) {
        $app->notFound();
    }
    //$app->render('rented/rented-units.twig', []);
    $controller = new UF\UnitController($app);
    return $controller->getAvailableUnits();
});

$app->post('/unit/changeBuildingType/', function () use ($app) {

    if (!$app->user->checkAccess('uri_unit') && !$app->user->checkAccess('uri_rented')) {
        $app->notFound();
    }
    $controller = new UF\UnitController($app);
    return $controller->changeBuildingType();
});

//delete Unit
$app->delete('/unit/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\UnitController($app);
    return $controller->deleteUnit();

});


/*
 *
 * Adding Images Upload Page Functions route
 *
*/
$app->get('/upload/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_upload')) {
        $app->notFound();
    }
    $controller = new UF\UploadController($app);
    return $controller->getView();

});

$app->get('/uploadPlan/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_upload')) {
        $app->notFound();
    }
    $controller = new UF\UploadController($app);
    return $controller->getUploadPlanView();

});
$app->post('/upload/up/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_upload')) {
        $app->notFound();
    }
    $controller = new UF\UploadController($app);
    return $controller->insertFile();
});

$app->post('/uploadPlan/up/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_upload')) {
        $app->notFound();
    }
    $controller = new UF\UploadController($app);
    return $controller->insertPlan();
});

$app->post('/parkingStorageReservation/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $post = $app->request->post();

    $reservationController = new UF\ReservationController($app);
    $controller = new UF\UnitController($app);
    $emailController = new UF\EmailTemplateController($app);
    $configController = new UF\ConfigurationController($app);
    $contractController = new UF\Contract1Controller($app);

    $recipients = array();
    $emailList = $configController->getEmailListVal();
    $unit = Unit::find($post['uid']);

    $reservation = $unit->reservations($post['uid']);

    if (count($reservation)) {
        $reservation_id = $reservation[0]['reservation_id'];

        $reservedUnit = Reservation::find($reservation_id);

        // get reservation email
        $reservationUser = $reservationController->getReservationFromUnitId($post['uid']);
        array_push($recipients, $reservationUser);

        $admins = $emailController->getAllAdmins();

        $length = sizeof($admins);

        for ($x = 0; $x < $length; $x++) {
            if ($reservationUser !== $admins[$x]) {
                array_push($recipients, $admins[$x]);
            }
        }
        $user = $app->user;
        $controller->Reserve();
        echo 'Reserved Successfully';

        if ($post['type'] == "parking") {

            $info = $controller->getParkingInfo()[0];

            $info['reservation_date'] = $controller->getReservationDate($post['uid'], "parking", $info["id"]);

            $contractController->parkingContent($reservedUnit, $info, $unit, $post['uid']);
            // send email
            $emailController->notifyingEmail($reservedUnit, $unit, $reservationUser, 'Reservation Parking Email', $emailList, [], $info);

            // $templateParams = array('type' => 'Parking','rawabi_code' => $post['rawabi_code'] ,'user' => $user,'info' => $info[0] ,'reservedUnit' => $reservedUnit );
        } else  if ($post['type'] == "extra-parking") {
                //adawoud
                $info = $controller->getExtraParkingInfo()[0];
    
                $info['reservation_date'] = $controller->getReservationDate($post['uid'], "parking", $info["id"]);
    
                $contractController->parkingContent($reservedUnit, $info, $unit, $post['uid']);
                // send email
                $emailController->notifyingEmail($reservedUnit, $unit, $reservationUser, 'Reservation Parking Email', $emailList, [], $info);
    
                // $templateParams = array('type' => 'Parking','rawabi_code' => $post['rawabi_code'] ,'user' => $user,'info' => $info[0] ,'reservedUnit' => $reservedUnit );
            
        } else {

            $info = $controller->getStorageInfo()[0];
            $info['reservation_date'] = $controller->getReservationDate($post['uid'], "storage", $info["id"]);

            $contractController->storageContent($reservedUnit, $info, $unit, $post['uid']);
            // send email
            $emailController->notifyingEmail($reservedUnit, $unit, $reservationUser, 'Reservation Storage Email', $emailList, $info, []);

            //$templateParams = array('type' => 'Storage' ,'rawabi_code' => $post['rawabi_code'] ,'user' => $user, 'info' => $info[0] ,'reservedUnit' => $reservedUnit  );
        }

        // send email
        // $emailController->sendTemplatedEmail("mail/ParkingStorage.twig",$templateParams,$recipients,$emailList);


    } else {
        echo 'no reservation';
    }

});

$app->post('/DeleteparkingStorageReservation/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $post = $app->request->post();

    $reservationController = new UF\ReservationController($app);
    $controller = new UF\UnitController($app);
    $emailController = new UF\EmailTemplateController($app);
    $configController = new UF\ConfigurationController($app);
    $contractController = new UF\Contract1Controller($app);

    $recipients = array();
    $emailList = $configController->getCancellationEmailList();


    $unit = Unit::find($post['uid']);

    $reservation = $unit->reservations($post['uid']);

    if (count($reservation)) {
        $reservation_id = $reservation[0]['reservation_id'];

        $reservedUnit = Reservation::find($reservation_id);

        // get reservation email
        $reservationUser = $reservationController->getReservationFromUnitId($post['uid']);
        array_push($recipients, $reservationUser);

        $admins = $emailController->getAllAdmins();

        $length = sizeof($admins);

        for ($x = 0; $x < $length; $x++) {
            if ($reservationUser !== $admins[$x]) {
                array_push($recipients, $admins[$x]);
            }
        }
        $user = $app->user;
        if ($post['type'] == "parking") {
            $info = $controller->getParkingInfo()[0];

            $info['reservation_date'] = $controller->getReservationDate($post['uid'], "parking", $info["id"]);
            $contractController->archiveContract($post['uid'], 'Appendix/Parking');
            // send email
            $email = new EmailTemplateController($app);
            $email->notifyingEmail($reservedUnit, $unit, $reservationUser, 'Reservation Parking Cancellation Email', $emailList, [], $info);

            //$templateParams = array('type' => 'Parking', 'rawabi_code' => $post['rawabi_code'], 'user' => $user, 'info' => $info[0], 'reservedUnit' => $reservedUnit);
        } else {
            $info = $controller->getStorageInfo()[0];
            $info['reservation_date'] = $controller->getReservationDate($post['uid'], "storage", $info["id"]);

            $contractController->archiveContract($post['uid'], 'Appendix/Storage');

            // send email
            $email = new EmailTemplateController($app);
            $email->notifyingEmail($reservedUnit, $unit, $reservationUser, 'Reservation Storage Cancellation Email', $emailList, $info, []);


            // $templateParams = array('type' => 'Storage', 'rawabi_code' => $post['rawabi_code'], 'user' => $user, 'info' => $info[0], 'reservedUnit' => $reservedUnit);
        }

        // send email
        //  $emailController->sendTemplatedEmail("mail/cancel-ParkingStorage.twig", $templateParams, $recipients, $emailList);


        $controller->DeleteReservation();
        echo 'Reserved Deleted Successfully';
    } else {
        echo 'no reservation';
    }
});

$app->post('/deletePlan/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\UnitController($app);
    return $controller->deletePlan();
});
$app->get('/upload/up/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_upload')) {
        $app->notFound();
    }
    $controller = new UF\UploadController($app);
    return $controller->getImages();
});


// Added By Ahmad for test connection
$app->get('/test/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_upload')) {
        $app->notFound();
    }
    $controller = new UF\UserController($app);
    return $controller->test();
});


//Added byNoora to get unitsRawabiCode from Neighbrhood

$app->post('/upload/getFromNeighbrhood/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_upload')) {
        $app->notFound();
    }
    $controller = new UF\UnitController($app);
    return $controller->getUnitsFromNeighbrhood();
});


$app->post('/uploadPlan/getFromNeighbrhood/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_upload')) {
        $app->notFound();
    }
    $controller = new UF\UnitController($app);

    return $controller->getStoragesOrParkingsFromNeighbrhood();
});
//** Added by Ayat Salman **//
$app->post('/unitsimgs/?', function () use ($app) {

    $controller = new UF\UnitsImgsController($app);
    return $controller->setImages();
});
$app->get('/imgsid/:unit_id/?', function ($unit_id) use ($app) {

    $controller = new UF\UnitsImgsController($app);
    return $controller->getImagesID($unit_id);
});
$app->get('/imgs/:img_id/?', function ($img_id) use ($app) {

    $controller = new UF\UploadController($app);
    return $controller->getImgs($img_id);
});


$app->delete('/deleteImage', function () use ($app) {
    // Access-controlled page
        if (!$app->user->checkAccess('uri_upload')){
            $app->notFound();
        }
    $controller = new UF\UploadController($app);
    echo $controller->delete_image();
});

$app->post('/deleteimg/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\UnitsImgsController($app);
    return $controller->Images();
});


$app->post('/delimg/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\UnitsImgsController($app);
    return $controller->delImages();
});

// ended by Ayat Salman //
/*
 *
 * Neighborhoods
 *
 */
$app->get('/neighborhoods/all/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_neighborhood') && !$app->user->checkAccess('uri_upload')) {
        $app->notFound();
    }
    $controller = new UF\NeighborhoodsController($app);
    return $controller->getNeighborhoods();
});
$app->get('/neighborhoods/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_neighborhood')) {
        $app->notFound();
    }
    $controller = new UF\NeighborhoodsController($app);
    return $controller->renderNeighborhoods();
});
$app->post('/neighborhoods/edit/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_neighborhood')) {
        $app->notFound();
    }
    $controller = new UF\NeighborhoodsController($app);
    return $controller->updateNeighborhoods();
});
$app->post('/neighborhoods/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_neighborhood')) {
        $app->notFound();
    }
    $controller = new UF\NeighborhoodsController($app);
    return $controller->setNeighborhoods();
});
$app->post('/neighborhoods/checkNameEn/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_neighborhood')) {
        $app->notFound();
    }
    $controller = new UF\NeighborhoodsController($app);
    return $controller->checkExistNameEn();

});
$app->post('/neighborhoods/checkNameAr/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_neighborhood')) {
        $app->notFound();
    }
    $controller = new UF\NeighborhoodsController($app);
    return $controller->checkExistNameAr();
});
$app->delete('/neighborhoods/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_neighborhood')) {
        $app->notFound();
    }
    $controller = new UF\NeighborhoodsController($app);
    return $controller->deleteNeighborhood();
});


$app->get('/reservation_fees/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit_fees')) {
        $app->notFound();
    }
    $controller = new UF\ConfigurationController($app);
    return $controller->rendeReservationFees();
});


$app->post('/reservation_fees/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit_fees')) {
        $app->notFound();
    }

    $controller = new UF\ConfigurationController($app);
    return $controller->updateReservationFees();
});

/*
 *
 *charts Routing
 *
 */
$app->get('/charts/:action/?', function ($action) use ($app) {

    $controller = new UF\ChartsController($app);
    switch ($action) {
        case "total-appartments":
            return $controller->totalAppartments();
        case "appartments-per-neighborhood":
            return $controller->appartmentsPerNeighborhood();
        case "get-neighborhoods":
            return $controller->getNeighborhoods();
        case "get-buildingTypes":
            return $controller->getBuildingTypes();
        case "get-fees-last-three-month":
            return $controller->getFeesLastThreeMonth();
        case "get-fees-last-three-month-per-neighborhood":
            return $controller->getFeesLastThreeMonthPerNeighborhood();
        case "total-appartments-per-neighborhood":
            return $controller->totalAppartmentsPerNeighborhood();
        default:
            return $controller->page404();
    }
});
/*ended by fadi*/

$app->get('/groups/titles/?', function () use ($app) {

    $controller = new UF\GroupController($app);
    return $controller->pageGroupTitles();
});

$app->post('/uploadedfiles/', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_upload')) {
        $app->notFound();
    }
    $controller = new UF\UploadController($app);
    return $controller->uploadFiles();
});
/********** ACCOUNT MANAGEMENT INTERFACE **********/

$app->get('/account/:action/?', function ($action) use ($app) {
    // Forward to installation if not complete
    if (!isset($app->site->install_status) || $app->site->install_status == "pending") {
        $app->redirect($app->urlFor('uri_install'));
    }

    $get = $app->request->get();

    $controller = new UF\AccountController($app);


    $twig = $app->view()->getEnvironment();
    $loader = $twig->getLoader();

    switch ($action) {
        case "login":
        {
            return $controller->pageLogin();
        }
        case "logout":
            return $controller->logout(true);
        case "register":
            return $controller->pageRegister();
//            case "resend-activation":   return $controller->pageResendActivation();
        case "forgot-password":
            return $controller->pageForgotPassword();
        case "activate":
            return $controller->activate();
        case "set-password":
            return $controller->pageSetPassword(true);
        case "reset-password":
            if (isset($get['confirm']) && $get['confirm'] == "true")
                return $controller->pageSetPassword(false);
            else
                return $controller->denyResetPassword();
        case "captcha":
            return $controller->captcha();
        case "settings":
            return $controller->pageAccountSettings();
        default:
            return $controller->page404();
    }
});

$app->post('/account/:action/?', function ($action) use ($app) {
    $controller = new UF\AccountController($app);

    switch ($action) {
        case "login":
            return $controller->login();
        case "register":
            return $controller->register();
        case "resend-activation":
            return $controller->resendActivation();
        case "forgot-password":
            return $controller->forgotPassword();
        case "set-password":
            return $controller->setPassword(true);
        case "reset-password":
            return $controller->setPassword(false);
        case "settings":
            return $controller->accountSettings();
        default:
            $app->notFound();
    }
});

/********** USER MANAGEMENT INTERFACE **********/

// List users
$app->get('/users/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_users')) {
        $app->notFound();
    }

    $controller = new UF\UserController($app);
    return $controller->pageUsers();
})->name('uri_users');

// List users in a particular primary group
$app->get('/users/:primary_group/?', function ($primary_group) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_users')) {
        $app->notFound();
    }

    $controller = new UF\UserController($app);
    return $controller->pageUsers($primary_group);
});

// User info form (update)
$app->get('/forms/users/u/:user_id/?', function ($user_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_users')) {
        $app->notFound();
    }

    $controller = new UF\UserController($app);
    return $controller->formUserEdit($user_id);
});

// User edit password form
$app->get('/forms/users/u/:user_id/password/?', function ($user_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_users')) {
        $app->notFound();
    }

    $controller = new UF\UserController($app);
    $get = $app->request->get();
    return $controller->formUserEditPassword($user_id);
});

// User creation form
$app->get('/forms/users/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_users')) {
        $app->notFound();
    }

    $controller = new UF\UserController($app);
    return $controller->formUserCreate();
});

// User info page
$app->get('/users/u/:user_id/?', function ($user_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_users')) {
        $app->notFound();
    }

    $controller = new UF\UserController($app);
    return $controller->pageUser($user_id);
});

// Create user
$app->post('/users/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_users')) {
        $app->notFound();
    }

    $controller = new UF\UserController($app);
    return $controller->createUser();
});

// Update user info
$app->post('/users/u/:user_id/?', function ($user_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_users')) {
        $app->notFound();
    }

    $controller = new UF\UserController($app);
    return $controller->updateUser($user_id);
});

// Delete user
$app->post('/users/u/:user_id/delete/?', function ($user_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_users')) {
        $app->notFound();
    }

    $controller = new UF\UserController($app);
    return $controller->deleteUser($user_id);
});
// getTotalUsers
$app->get('/getTotalUsers/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_users') && !$app->user->checkAccess('uri_dashboard')) {
        $app->notFound();
    }

    $controller = new UF\UserController($app);
    return $controller->getTotalUsers();
});


/********** GROUP MANAGEMENT INTERFACE **********/

// List groups
$app->get('/groups/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_groups')) {
        $app->notFound();
    }
    $controller = new UF\GroupController($app);
    return $controller->pageGroups();
});

// List auth rules for a group
$app->get('/groups/g/:group_id/auth?', function ($group_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('authorization_create')) {
        $app->notFound();
    }
    $controller = new UF\GroupController($app);
    return $controller->pageGroupAuthorization($group_id);
});

// Group info form (update)
$app->get('/forms/groups/g/:group_id/?', function ($group_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('groups_update')) {
        $app->notFound();
    }
    $controller = new UF\GroupController($app);
    return $controller->formGroupEdit($group_id);
});

// Group creation form
$app->get('/forms/groups/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('groups_create')) {
        $app->notFound();
    }
    $controller = new UF\GroupController($app);
    return $controller->formGroupCreate();
});

// Create group
$app->post('/groups/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('groups_create')) {
        $app->notFound();
    }
    $controller = new UF\GroupController($app);
    return $controller->createGroup();
});

// Update group info
$app->post('/groups/g/:group_id/?', function ($group_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('groups_update')) {
        $app->notFound();
    }
    $controller = new UF\GroupController($app);
    return $controller->updateGroup($group_id);
});

// Delete group
$app->post('/groups/g/:group_id/delete/?', function ($group_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('groups_delete')) {
        $app->notFound();
    }
    $controller = new UF\GroupController($app);
    return $controller->deleteGroup($group_id);
});

/********** GROUP AUTH RULES INTERFACE **********/

// Group auth creation form
$app->get('/forms/groups/g/:group_id/auth/?', function ($group_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('authorization_create')) {
        $app->notFound();
    }
    $controller = new UF\AuthController($app);
    return $controller->formAuthCreate($group_id, "group");
});

// Group auth update form
$app->get('/forms/groups/auth/a/:rule_id/?', function ($rule_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('authorization_update')) {
        $app->notFound();
    }
    $controller = new UF\AuthController($app);
    $get = $app->request->get();
    return $controller->formAuthEdit($rule_id);
});

// Group auth create
$app->post('/groups/g/:group_id/auth/?', function ($group_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('authorization_create')) {
        $app->notFound();
    }
    $controller = new UF\AuthController($app);
    return $controller->createAuthRule($group_id, "group");
});

// Group auth update
$app->post('/groups/auth/a/:rule_id?', function ($rule_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('authorization_update')) {
        $app->notFound();
    }
    $controller = new UF\AuthController($app);
    return $controller->updateAuthRule($rule_id, "group");
});

// Group auth delete
$app->post('/auth/a/:rule_id/delete/?', function ($rule_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('authorization_delete')) {
        $app->notFound();
    }
    $controller = new UF\AuthController($app);
    $get = $app->request->get();
    return $controller->deleteAuthRule($rule_id);
});

/************ ADMIN TOOLS *************/

$app->get('/config/settings/?', function () use ($app) {

    // Access-controlled page
    if (!$app->user->checkAccess('uri_settings')) {
        $app->notFound();
    }
    $controller = new UF\AdminController($app);
    return $controller->pageSiteSettings();
});

$app->post('/config/settings/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_settings')) {
        $app->notFound();
    }
    $controller = new UF\AdminController($app);

    return $controller->siteSettings();
});

$app->post('/config/settings/upload/img/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_settings')) {
        $app->notFound();
    }
    $controller = new UF\AdminController($app);

    return $controller->uploadImage();
});

// Build the minified, concatenated CSS and JS
$app->get('/config/build', function () use ($app) {

    // Access-controlled page
    if (!$app->user->checkAccess('uri_minify')) {
        $app->notFound();
    }

    $app->schema->build(true);
    $app->alerts->addMessageTranslated("success", "MINIFICATION_SUCCESS");
    $app->redirect($app->urlFor('uri_settings'));
});

// Slim info page
$app->get('/sliminfo/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_slim_info')) {
        $app->notFound();
    }
    echo "<pre>";
    uri_unit_r($app->environment());
    echo "</pre>";
});

// PHP info page
$app->get('/phpinfo/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_php_info')) {
        $app->notFound();
    }
    echo "<pre>";
    uri_unit_r(phpinfo());
    echo "</pre>";
});

// Error log page
$app->get('/errorlog/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_error_log')) {
        $app->notFound();
    }
    $log = UF\SiteSettings::getLog();
    echo "<pre>";
    echo implode("<br>", $log['messages']);
    echo "</pre>";
});

/************ INSTALLER *************/

$app->get('/install/?', function () use ($app) {
    $controller = new UF\InstallController($app);
    if (isset($app->site->install_status)) {
        // If tables have been created, move on to master account setup
        if ($app->site->install_status == "pending") {
            $app->redirect($app->site->uri['public'] . "/install/master");
        } else {
            // Everything is set up, so go to the home page!
            $app->redirect($app->urlFor('uri_home'));
        }
    } else {
        return $controller->pageSetupDB();
    }
})->name('uri_install');

$app->get('/install/master/?', function () use ($app) {
    $controller = new UF\InstallController($app);
    if (isset($app->site->install_status) && ($app->site->install_status == "pending")) {
        return $controller->pageSetupMasterAccount();
    } else {
        $app->redirect($app->urlFor('uri_install'));
    }
});

$app->post('/install/:action/?', function ($action) use ($app) {
    $controller = new UF\InstallController($app);
    switch ($action) {
        case "master":
            return $controller->setupMasterAccount();
        default:
            $app->notFound();
    }
});

/************ API *************/

$app->get('/api/users/?', function () use ($app) {
    $controller = new UF\ApiController($app);
    $controller->listUsers();
});


/************ MISCELLANEOUS UTILITY ROUTES *************/

// Generic confirmation dialog
$app->get('/forms/confirm/?', function () use ($app) {
    $get = $app->request->get();

    // Load the request schema
    $requestSchema = new \Fortress\RequestSchema($app->config('schema.path') . "/forms/confirm-modal.json");

    // Get the alert message stream
    $ms = $app->alerts;

    // Remove csrf_token
    unset($get['csrf_token']);

    // Set up Fortress to process the request
    $rf = new \Fortress\HTTPRequestFortress($ms, $requestSchema, $get);

    // Sanitize
    $rf->sanitize();

    // Validate, and halt on validation errors.
    if (!$rf->validate()) {
        $app->halt(400);
    }

    $data = $rf->data();

    $app->render('components/common/confirm-modal.twig', $data);
});

// Alert stream
$app->get('/alerts/?', function () use ($app) {
    $controller = new UF\BaseController($app);
    $controller->alerts();
});

// JS Config
$app->get($app->config('uri')['js-relative'] . '/config.js', function () use ($app) {
    $controller = new UF\BaseController($app);
    $controller->configJS();
});

// Theme CSS
$app->get($app->config('uri')['css-relative'] . '/theme.css', function () use ($app) {
    $controller = new UF\BaseController($app);
    $controller->themeCSS();
});

// Not found page (404)
$app->notFound(function () use ($app) {
    if ($app->request->isGet()) {
        $controller = new UF\BaseController($app);
        $controller->page404();
    } else {
        $app->alerts->addMessageTranslated("danger", "SERVER_ERROR");
    }
});


// Editable Contract requests
$app->get('/ShowContact1/:id/?', function ($id) use ($app) {
    // Access-controlled page

    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract1Controller($app);
    $contract = Contract::Where('unit_id', $id)->where('type', 'purchase_contract')->where('status', 'ACTIVE')->first();
    if ($contract != null) {
        $header = '';
        $footer = '';
        $cover = '';
        $contractTemplate = $controller->getTemplateAPI($contract->template_id);

        $templateId = 0;
        if (count($contractTemplate)) {
            $header = $contractTemplate['header'];
            $footer = $contractTemplate['footer'];
            $cover = $contractTemplate['cover'];
            $templateId = 1;
        }
        $content = $contract->content;

        $app->render('unit/Editable_Contract/contract.twig', [
            "data" => preg_replace("/\r|\n/", "", $content),
            "header" => preg_replace("/\r|\n/", "", $header),
            "footer" => preg_replace("/\r|\n/", "", $footer),
            "cover" => preg_replace("/\r|\n/", "", $cover),
            "template_id" => $templateId
        ]);
    } else {

        echo '<script type="text/javascript">alert("No Active Contract for this unit"); history.back()</script>
';
    }
});

$app->get('/ShowEditableReceipt/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract1Controller($app);
    $contract = $controller->getReservationContent($id);

    if (!$contract) {
        echo '<script type="text/javascript">alert("No Active Reservation for this unit"); history.back()</script>';

        $app->render('unit/Editable_Contract/receipt-editable.twig', [
            "data" => 0
        ]);
    } else {
        $content = $contract['content'];

        $header = '';
        $footer = '';
        $contractTemplate = $controller->getTemplateAPI($contract['template_id']);

        if (count($contractTemplate)) {
            $header = $contractTemplate['header'];
            $footer = $contractTemplate['footer'];
        }

        $app->render('unit/Editable_Contract/receipt-editable.twig', [
            "data" => preg_replace("/\r|\n/", "", $content),
            "header" => preg_replace("/\r|\n/", "", $header),
            "footer" => preg_replace("/\r|\n/", "", $footer)
        ]);
    }

});

$app->get('/ShowEditableStorage/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $controller = new UF\Contract1Controller($app);
    $contracts = $controller->getStorageContent($id);
    if (!count($contracts)) {
        echo '<script type="text/javascript">alert("No Active Storage Content for this unit"); history.back()</script>';

        $app->render('unit/Editable_Contract/storage-editable.twig', [
            "data" => 0
        ]);
    } else {
        $allContracts ='';
        foreach ($contracts as $contract) {
            $content = $contract['content'];

            $header = '';
            $footer = '';
            $contractTemplate = $controller->getTemplateAPI($contract['template_id']);

            if (count($contractTemplate)) {
                $header = $contractTemplate['header'];
                $footer = $contractTemplate['footer'];
            }

            $allContracts = $allContracts.$header.$content.$footer.'<div class="pagebreak"></div>';
        }


        $app->render('unit/Editable_Contract/storage-editable.twig', [
            'data' => preg_replace("/\r|\n/", "", $allContracts)
        ]);

    }
});

$app->get('/ShowEditableParking/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $controller = new UF\Contract1Controller($app);
    $contracts = $controller->getParkingContent($id);
    if (!count($contracts)) {
        echo '<script type="text/javascript">alert("No Active Parking Content for this unit"); history.back()</script>';

        $app->render('unit/Editable_Contract/parking-editable.twig', [
            "data" => 0
        ]);
    } else {

        $allContracts ='';
        foreach ($contracts as $contract) {
            $content = $contract['content'];

            $header = '';
            $footer = '';
            $contractTemplate = $controller->getTemplateAPI($contract['template_id']);

            if (count($contractTemplate)) {
                $header = $contractTemplate['header'];
                $footer = $contractTemplate['footer'];
            }

            $allContracts = $allContracts.$header.$content.$footer.'<div class="pagebreak"></div>';
        }


        $app->render('unit/Editable_Contract/parking-editable.twig', [
            'data' => preg_replace("/\r|\n/", "", $allContracts)
        ]);
    }
});


// Editable Contract requests
$app->get('/ShowContact2/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $controller = new UF\Contract2Controller($app);
    $contract2 = $controller->getContract2($id);
    $content = $controller->getcontenthtml();
    $app->render('unit/Editable_Contract/contract2.twig', [
        "contract2Val" => $contract2,
        "content" => $content
    ]);


    //$controller = new UF\UnitController($app);
    //return $controller->getUnit();

});

// Editable Contract requests
$app->get('/ShowContact3/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract3Controller($app);
    $contract3 = $controller->getContract3($id);
    $content = $controller->getcontenthtml();

    $app->render('unit/Editable_Contract/contract3.twig', [
        "contract2Val" => $contract3,
        "content" => $content
    ]);


    //$controller = new UF\UnitController($app);
    //return $controller->getUnit();

});


// Editable Contract requests
$app->get('/ShowReceipt/:id/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\ReservationController($app);
    $content = $controller->getcontenthtml();

    $app->render('unit/Editable_Contract/receipt.twig', [
        "content" => $content
    ]);
});

$app->get('/ShowContractReceipt/:id', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $app->render('unit/unit_contract.twig', [
        "id" => $id
    ]);
});

$app->post('/getContractDetails', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('contracts')) {
        $app->notFound();
    }
    $controller = new UF\Contract1Controller($app);
    $data = $controller->getContractDetails();

    echo json_encode($data);
});


$app->get('/ShowParking/unitId/:uid/parkingId/:parkingid/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $app->render('unit/Editable_Contract/parking.twig');
});


$app->get('/ShowStorage/unitId/:uid/storageId/:storageId/?', function ($id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $app->render('unit/Editable_Contract/storage.twig');
});


$app->get('/getReservation/unit/:uid/parking/:parkingid/?', function ($id) use ($app) {

    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\UnitController($app);
    echo $controller->getReservationInfo();
});

$app->get('/getReservations/unit/:uid/?', function ($id) use ($app) {

    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\UnitController($app);
    echo $controller->getReservationInfoByUnitId();
});

//$app->get('/getPaymentsForContract1/?', function () use ($app) {
//
//    // Access-controlled page
//    if (!$app->user->checkAccess('uri_unit')) {
//        $app->notFound();
//    }
//    $controller = new UF\Contract1Controller($app);
//    echo $controller->getPaymentsForContract1();
//});

$app->get('/getPaymentsReport/?', function () use ($app) {

    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    $controller = new UF\Contract1Controller($app);
    echo $controller->getPaymentsReport();
});

// Editable Contract requests
$app->get('/uri_unitcontract1/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    include('../vendor/autoload.php');
    $mpdf = new \Mpdf\Mpdf();

// Write some HTML code:
    $mpdf->WriteHTML('Hello World');

// Output a PDF file directly to the browser
    $mpdf->Output();


});

$app->get('/template/create/?', function () use ($app) {
    if (!$app->user->checkAccess('contracts')) {
        $app->notFound();
    }

    $controller = new UF\Contract1Controller($app);
    $columns = $controller->getContract1Attributes();

    return $app->render('unit/contractTemplate/createTemplate.twig', [
        "columns" => $columns,
    ]);
});

$app->get('/contract/templates/attributes/?', function () use ($app) {
    if (!$app->user->checkAccess('contracts')) {
        $app->notFound();
    }

    $controller = new UF\Contract1Controller($app);
    $columns = $controller->getAttributes();
    return $columns;
});

$app->post('/contract/create/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('contracts')) {
        $app->notFound();
    }
    $controller = new UF\Contract1Controller($app);
    return $controller->createContractTemplate();
});

$app->get('/template/list/?', function () use ($app) {
    if (!$app->user->checkAccess('contracts') && !$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    return $app->render('unit/contractTemplate/templateList.twig', []);
});

$app->get('/contract/templates/list/?', function () use ($app) {
    if (!$app->user->checkAccess('contracts') && !$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $controller = new UF\Contract1Controller($app);
    return $controller->getcontractTemplates();

});

$app->get('/contract/template/:id/change/status/?', function ($id) use ($app) {

    if (!$app->user->checkAccess('contracts') && !$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $controller = new UF\Contract1Controller($app);
    return $controller->ChangeStatusTemplate($id);

});

$app->get('/contract/get/:id/?', function ($id) use ($app) {
    if (!$app->user->checkAccess('contracts') && !$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $controller = new UF\Contract1Controller($app);
    return $controller->getTemplate($id);

});

// Emails Template

$app->get('/emails/templates/create/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_email_management')) {
        $app->notFound();
    }

    $controller = new UF\EmailTemplateController($app);
    $emailsTemplates = $controller->getEmailsTemplates(0);
    $columns = $controller->getEmailsAttributes();

    return $app->render('mail/emails-templates.twig', [
        "emailsTemplates" => $emailsTemplates,
        "columns" => $columns,
    ]);
});

$app->get('/emails/templates/:id/?', function ($id) use ($app) {
    if (!$app->user->checkAccess('uri_email_management')) {
        $app->notFound();
    }

    $controller = new UF\EmailTemplateController($app);
    return $controller->getEmailsTemplates($id);
});

$app->put('/emails/templates/:id/?', function ($id) use ($app) {
    if (!$app->user->checkAccess('uri_email_management')) {
        $app->notFound();
    }

    $controller = new UF\EmailTemplateController($app);
    return $controller->UpdateEmailsTemplates($id);
});


$app->get('/ahmadTest/?', function () use ($app) {

    $controller = new UF\EmailTemplateController($app);
    return $controller->clearVARS();
});

$app->delete('/unit/:id/reservation/delete/?', function ($id) use ($app) {
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }


    $controller = new UF\ReservationController($app);
    $contractController = new UF\Contract1Controller($app);
    $contractController->archiveContract($id, 'reservation_receipt');

    return $controller->deleteReservation();
});

$app->get('/getContractTemplate/:uid/?', function ($id) use ($app) {

    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    // get post param
    $post = $app->request->get();

    $controller = new UF\Contract1Controller($app);
    $rerenderedContents = $controller->renderContractTemplate($id, $post['unitID'], $post['include_payment']);

    echo $rerenderedContents;
});


$app->post('/parseAndSaveContractTemplate/?', function () use ($app) {
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }

    $controller = new UF\Contract1Controller($app);
    $result = $controller->parseAndSaveContractTemplate();

    echo $result;
});

$app->get('/testForRawabiContract1/?', function () use ($app) {

    $controller = new UF\Contract1Controller($app);
    $result = $controller->testForRawabiContract1();

    echo $result;
});

$app->get('/testForRawabiContract2/?', function () use ($app) {

    $controller = new UF\Contract1Controller($app);
    $result = $controller->testForRawabiContract2();

    echo $result;
});

$app->get('/testForRawabiReceipt/?', function () use ($app) {

    $controller = new UF\Contract1Controller($app);
    $result = $controller->testForRawabiReceipt();

    echo $result;
});

$app->post('/purchaseUnit/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }
    // either new or old, it should live at most for another hour

    $controller = new UF\UnitController($app);
    echo $controller->purchaseUnit();
});

$app->get('/unit/checkToPurchase/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_unit')) {
        $app->notFound();
    }


    // get post param
    $post = $app->request->get();
    $controller = new UF\UnitController($app);
    echo $controller->checkUnitToPurchaseEnable($post['unitId']);

});

$app->get('/permissions/?', function () use ($app) {
    //Access-controlled page
    if (!$app->user->checkAccess('uri_permission')) {
        $app->notFound();
    }
    $controller = new UF\PermissionsController($app);
    echo $controller->index();


});


// Group creation form
$app->get('/forms/permissions/?', function () use ($app) {

    // Access-controlled page
//    if (!$app->user->checkAccess('uri_permission')) {
//        $app->notFound();
//    }

    $controller = new UF\PermissionsController($app);
    return $controller->formPermissionCreate();
});


// Create permission
$app->post('/permissions/?', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('create_permission')) {
        $app->notFound();
    }
    $controller = new UF\PermissionsController($app);
    return $controller->createPermission();
});

// Delete group
$app->post('/permissions/:permission_id/delete/?', function ($permission_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('delete_permission')) {
        $app->notFound();
    }
    $controller = new UF\PermissionsController($app);
    return $controller->deletePermission($permission_id);
});


// Group info form (update)
$app->get('/forms/permissions/g/:permission_id/?', function ($permission_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_permission')) {
        $app->notFound();
    }
    $controller = new UF\PermissionsController($app);
    return $controller->formPermissionEdit($permission_id);
});

// Update group info
$app->post('/permissions/g/:permission_id/?', function ($permission_id) use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('update_permission')) {
        $app->notFound();
    }
    $controller = new UF\PermissionsController($app);
    return $controller->updatePermission($permission_id);
});

// switch language
$app->get('/language/switch/?', function () use ($app) {

    $controller = new UF\UserController($app);
    $controller->switchLanguage();
    return $app->redirect($_REQUEST['redirect']);

});

$app->get('/language/?', function () use ($app) {

    $controller = new UF\UserController($app);
    return $controller->getLanguage();
});


$app->get('/cashReceipts/?', function () use ($app) {

    if (!$app->user->checkAccess('uri_cash_receipts')) {
        $app->notFound();
    }

    $units = Unit::where('available', 0)->get();
    $unitsCashReceipt = UF\CashReceipt::with('unit', 'cashReceiptPricing')->get();


    return $app->render('unit/cashReceipts.twig',
        [
            "units" => $units,
            "unitsCashReceipt" => $unitsCashReceipt
        ]
    );

});
$app->get('/units/cashReceipt/search/?', function () use ($app) {
    $get = $app->request->get();

    $limit = $get['length'];
    $offset = isset($get['start']) ? $get['start'] : 0;

    $searchText = $get['search']['value'];

    $unitsCashReceipt = UF\CashReceipt::with('unit', 'cashReceiptPricing', 'user')
        ->where(function ($q) use ($searchText) {
            $q->whereHas('unit', function ($query) use ($searchText) {
                $query->where('rawabi_code', 'like', '%' . $searchText . '%')
                    ->orWhere('building_type', 'like', '%' . $searchText . '%');
            });
        })
        ->orWhere(function ($q) use ($searchText) {
            $q->whereHas('unit.reservationsRel', function ($query) use ($searchText) {
                $query->where('customer_name', 'like', '%' . $searchText . '%')
                    ->orWhere('user_did_action', 'like', '%' . $searchText . '%');
            });
        })
        ->orWhere('receiptDate', 'like', '%' . $searchText . '%');


    $total = $unitsCashReceipt->count();

//    $result = [
//        'units' => $unitsCashReceipt->skip($offset)->take($limit)->get(),
//        'pager' => [
//            'offset' => $offset,
//            'limit' => $limit,
//            'total' => $total,
//        ],
//    ];

    $itemItem = [
        "iTotalRecords" => UF\CashReceipt::all()->count(),
        "iTotalDisplayRecords" => $total,
        "data" => $unitsCashReceipt->skip($offset)->take($limit)->get(),
    ];

    echo json_encode($itemItem);


});

$app->get('/units/cashReceipt/:id/?', function ($id) use ($app) {

    $unitsCashReceipt = UF\CashReceipt::with('unit', 'cashReceiptPricing', 'cashReceiptFiles', 'relatedTo')
        ->where('id', $id)
        ->first();

    echo json_encode($unitsCashReceipt);

});

$app->post('/units/cashReceipt/:id/updateNote/?', function ($id) use ($app) {
    $post = $app->request->post();

    $unitsCashReceipt = UF\CashReceipt::where('id', $id)->first();
    if ($unitsCashReceipt) {
        $unitsCashReceipt->additional_note = $post['additional_note'];
        $unitsCashReceipt->save();
    }

    echo json_encode($unitsCashReceipt);

});

$app->get('/unit/:id?', function ($id) use ($app) {

    $unit = Unit::find($id);
    $result = $unit;

    $reservation = $unit->reservations($id);
    if (count($reservation)) {
        $reservation_id = $reservation[0]['reservation_id'];
        $reservedUnit = Reservation::find($reservation_id);
        $result = collect($unit)->merge(collect($reservedUnit));
    }

    echo json_encode($result);
});

$app->post('/unit/:id/cashReceipt/?', function ($id) use ($app) {

    $controller = new UF\UnitController($app);
    echo $controller->addCashReceipt();

});

$app->post('/send_email', function () use ($app) {
    // Access-controlled page
    if (!$app->user->checkAccess('uri_settings')) {
        $app->notFound();
    }
    $controller = new UF\SmtpMailConfigController($app);
    return $controller->send_email();

});

$app->get('/moveCashReceiptInfo', function () use ($app) {

    $controller = new UF\UnitController($app);
    return $controller->move();

});

$app->patch('/unit/:unit_id/finishing/?', function ($unit_id) use ($app){

    $payload = $app->request->patch();

    $reservation_unit = ReservationUnit::where('unit_id', $unit_id)->first();
   if($reservation_unit) {
       $reservation = Reservation::where('id', $reservation_unit->reservation_id)->first();
       if($reservation) {
           $finishingValue = $reservation->finishing_Price;
           $totalPrice = $reservation->total_price;

           if ($finishingValue) {
               $totalPrice = $totalPrice - $finishingValue;
           }

           $reservation->finishing_Price = $payload['finishing_Price'];
           $reservation->total_price = $totalPrice + (double)$payload['finishing_Price'];
           $reservation->save();

           echo 1;
           return ;
       }
   }

    return 0;

});


$app->get('/unit/:unit_id/finishing/?', function ($unit_id) use ($app) {

    $reservation_unit = ReservationUnit::where('unit_id', $unit_id)->first();
    if($reservation_unit) {
        $reservation = Reservation::where('id', $reservation_unit->reservation_id)->first();
        if($reservation) {
            $finishingValue = $reservation->finishing_Price;

            echo $finishingValue;
            return;
        }
    }
    echo -1;
});


$app->get('/unit/:unit_id/price/total/?', function ($unit_id) use ($app) {

    $reservation_unit = ReservationUnit::where('unit_id', $unit_id)->first();
    if($reservation_unit) {
        $reservation = Reservation::where('id', $reservation_unit->reservation_id)->first();
        if($reservation) {
            $total_price = $reservation->total_price;

            echo $total_price;
            return;
        }
    }
    echo "";
});

$app->run();
