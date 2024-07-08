<?php

namespace UserFrosting;


use function MongoDB\BSON\toJSON;

class ConfigurationController extends \UserFrosting\BaseController
{

    protected static $_table_id = "configuration";

    /**
     * Create a new EmailTemplate object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app)
    {
        $this->_app = $app;
    }

    public function saveEmailList()
    {
        $this->saveReservationEmailList();
        $this->savePurchaseEmailList();
        $this->saveCancellationEmailList();
        $this->saveCashReceiptEmailList();
    }

    public function saveReservationEmailList()
    {
        $post = $this->_app->request->post();
        $config = Configuration::where('name', '=', 'ReservationEmailList')->get()[0];
        $config->value = $post['input_reservation_email'];
        $config->save();

    }

    public function savePurchaseEmailList()
    {
        $post = $this->_app->request->post();
        $config = Configuration::where('name', '=', 'PurchaseEmailList')->get()[0];
        $config->value = $post['input_purchase_email'];
        $config->save();
    }

    public function saveCancellationEmailList()
    {
        $post = $this->_app->request->post();
        $config = Configuration::where('name', '=', 'CancellationEmailList')->get()[0];
        $config->value = $post['input_cancellation_email'];
        $config->save();
    }

    public function saveCashReceiptEmailList()
    {
        $post = $this->_app->request->post();
        $config = Configuration::where('name', '=', 'CashReceiptEmailList')->get()[0];
        $config->value = $post['input_cash_receipt_email'];
        $config->save();
    }

    public function getEmailList()
    {
        //$emailList=Configuration::find("20");
        //$emailList=Configuration::where('name', '=', 'EmailList')->get();
        //$emailList=Configuration::where('name', '=', 'ReservationEmailList')->get();
        //$emailList= [];
        $reservationEmailList = Configuration::where('name', '=', 'ReservationEmailList')->get()[0]->value;
        $purchaseEmailList = Configuration::where('name', '=', 'PurchaseEmailList')->get()[0]->value;
        $cancellationEmailList = Configuration::where('name', '=', 'CancellationEmailList')->get()[0]->value;
        $cashReceiptEmailList = Configuration::where('name', '=', 'CashReceiptEmailList')->get()[0]->value;
        $emailList = array("reservationEmailList" => $reservationEmailList, "purchaseEmailList" => $purchaseEmailList, "cancellationEmailList" => $cancellationEmailList, "cashReceiptEmailList" => $cashReceiptEmailList);
        //echo $emailList[0]->value;
        echo json_encode($emailList);
    }

    public function getEmailListVal()
    {
        $user = User::find($_SESSION['userfrosting']['user_id']);
        $email = '';
        if ($user) {
            $email = $user->email;
        }

        $emailList = Configuration::where('name', '=', 'ReservationEmailList')->get();
        $value = $emailList[0]->value;

        // Check if $email is not empty and the existing value is not empty
        if (!empty($email) && !empty($value)) {
            // Append $email to the existing value with a semicolon
            $newValue = $value . ';' . $email;
        } elseif (!empty($email)) {
            // If the existing value is empty, use just $email
            $newValue = $email;
        } else {
            // If $email is empty, use the existing value
            $newValue = $value;
        }

        return $newValue;
    }

    public function getCancellationEmailList()
    {
        $user = User::find($_SESSION['userfrosting']['user_id']);
        $email = '';
        if ($user) {
            $email = $user->email;
        }
        $emailList = Configuration::where('name', '=', 'CancellationEmailList')->get();
        $value = $emailList[0]->value;

        // Check if $email is not empty and the existing value is not empty
        if (!empty($email) && !empty($value)) {
            // Append $email to the existing value with a semicolon
            $newValue = $value . ';' . $email;
        } elseif (!empty($email)) {
            // If the existing value is empty, use just $email
            $newValue = $email;
        } else {
            // If $email is empty, use the existing value
            $newValue = $value;
        }

        return $newValue;
    }

    public function getCashReceiptEmailList()
    {
        $emailList = Configuration::where('name', '=', 'CashReceiptEmailList')->get();
        return $emailList[0]->value;
    }

    public function rendeReservationFees()
    {
        $this->_app->render('config/reservation-fees.twig', [
        ]);
    }


    public function updateReservationFees()
    {
        // Fetch the POSTed data
        $post = $this->_app->request->post();
        // Remove CSRF token
        if (isset($post['csrf_token']))
            unset($post['csrf_token']);

        $userfrosting = array('userfrosting' => $post);

        // If validation passed, then update
        foreach ($userfrosting as $plugin => $settings) {
            foreach ($settings as $name => $value) {
                $this->_app->site->set($plugin, $name, $value);
            }
        }
        $this->_app->site->store();

    }

    public function getCollectedFees()
    {
        $config = Configuration::where('name', '=', 'collected_fees')->get()[0];
        return $config;
    }

    public function getCurrencies()
    {
        $db_connection_string = $this->_app->environment()["db_connection"];
        $conn = mysqli_connect("localhost", "root", "", $db_connection_string, "3306");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT * FROM `currencies`";
        $result = $conn->query($query);
        $data = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($data,
                    [
                        "id" => $row["id"],
                        "name" => $row["name"],
                        "symbol" => $row["symbol"],
                    ]
                );
            }

        }

        $data = json_decode(json_encode($data), true);
        echo json_encode($data);
    }


}
