<?php


/**
 * UserFrosting initialization file.  Handles setup for database, site settings, JS/CSS includes, etc.
 *
 * @author Alex Weissman
 * @link http://www.userfrosting.com
 */

require_once 'vendor/autoload.php';
require_once 'models/auth/password.php';


// This if-block just checks that config-userfrosting.php exists
if (!file_exists(__DIR__ . "/config-userfrosting.php")){
	http_response_code(503);
    echo "<h2>We can't seem to find config-userfrosting.php!  You should rename the file config-userfrosting-example.php to config-userfrosting.php, and then fill in the configuration details for your database and server.  For more information, please see the <a href='http://www.userfrosting.com/installation/#install-userfrosting'>installation instructions</a>.</h2><br>";
    exit;
}

//require_once 'config-userfrosting.php';
require_once __DIR__.'/config-userfrosting.php';


use \Slim\Extras\Middleware\CsrfGuard;

// Start session
$app->startSession();

/*===== Middleware.  Middleware gets run when $app->run is called, i.e. AFTER the code in initialize.php ====*/

/**** CSRF Middleware ****/
$app->add(new CsrfGuard());

/**** Session and User Setup ****/
$app->add(new UserFrosting\UserSession());

/**** Database Setup ****/

// Eloquent Query Builder
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;



$dbx = $app->config('db');

$connection_array = [
    'driver'    => 'mysql',
    'host'      => $dbx['db_host'],
    'database'  => $dbx['db_name'],
    'username'  => $dbx['db_user'],
    'password'  => $dbx['db_pass'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => ''
];


// This is for backwards compatibility. Pre-0.3.1.19 configuration files won't have $dbx['db_port'] defined at all.
if (isset($dbx['db_port']))
{
    $connection_array['port'] = $dbx['db_port'];
}

$capsule->addConnection($connection_array);

// Register as global connection
$capsule->setAsGlobal();

// Start Eloquent
$capsule->bootEloquent();

// Set enumerative values
defined("GROUP_NOT_DEFAULT") or define("GROUP_NOT_DEFAULT", 0);
defined("GROUP_DEFAULT") or define("GROUP_DEFAULT", 1);
defined("GROUP_DEFAULT_PRIMARY") or define("GROUP_DEFAULT_PRIMARY", 2);

// Pass Slim app to database and core data model
\UserFrosting\Database::$app = $app;
\UserFrosting\UFModel::$app = $app;

// Initialize database properties
$table_user = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "user", [
    "user_name",
    "display_name",
    "email",
    "title",
    "locale",
    "primary_group_id",
    "secret_token",
    "flag_verified",
    "flag_enabled",
    "flag_password_reset",
    "created_at",
    "updated_at",
    "password"
]);

$table_user_event = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "user_event", [
    "user_id",
    "event_type",
    "occurred_at",
    "description"
]);

$table_group = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "group", [
    "name",
    "is_default",
    "can_delete",
    "theme",
    "landing_page",
    "new_user_title",
    "icon"
]);
/*added by Fadi*/
$table_unit = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "unit", [
    "building",
    "unit",
    "floor",
    "neighborhood",
    "size",
    "available",
    "contract_type",
    "Rawabi_code",
    "Building_type",
    "unitDescription",
    "price",
    "description",
    "tabo_area"
]);

$table_payments = new \UserFrosting\DatabaseTable('payments', [
    "id",
    "unit_id",
    "payment_number",
    "amount",
    "payment_date"
]);

$table_contracts = new \UserFrosting\DatabaseTable('contracts', [
    "id",
    "content",
    "user_id",
    "status",
    "template_id",
    "unit_id",
    "created_at"
]);
$table_contracts_templates = new \UserFrosting\DatabaseTable('contracts_templates', [
    "id",
    "content",
    "user_id",
    "status",
    "templateName",
    "header",
    "footer",
    "created_at"
]);

$table_units_cash_receipts = new \UserFrosting\DatabaseTable('units_cash_receipts', [
    "id",
    "unit_id",
    "receiptDate",
    "signature",
    "user_id",
    "note",
    "additional_note",
    "related_to",
    "user_id",
    "customer_name",
    "region",
    "phone_number",
    "email_address",
    "customer_id"
]);

$table_parking_storage_payments = new \UserFrosting\DatabaseTable('parking_storage_payments', [
    "id",
    "target",
    "target_id",
    "amount",
    "payment_date",
    "payment_number",
]);

$table_units_cash_receipts_prices = new \UserFrosting\DatabaseTable('units_cash_receipts_prices', [
    "id",
    "units_cash_receipts_id",
    "description",
    "payment_way",
    "total",
    "currency",
]);

$table_units_cash_receipts_files = new \UserFrosting\DatabaseTable('units_cash_receipts_files', [
    "id",
    "units_cash_receipts_id",
    "file_name",
    "upload_path",
]);


$table_permissions = new \UserFrosting\DatabaseTable('permissions', [
    "id",
    "code",
    "name",
    "status",
    "created_at"
]);


$table_reservation = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "reservation", [
    "collected_fees",
    "currency",
    "customer_type_of_payment",
    "customer_type_of_id",
    "customer_id",
    "customer_name",
    "reservation_date",
    "customer_address",
    "phone_number",
    "mobile",
    "issued_by",
    "total_price",
    "origin_price",
    "leadID",
    "country",
    "city",
    "region",
    "street",
    "mailbox",
    "postalcode",
    "workphone",
    "email_address",
    "PaymentMethod_select",
    "directInstallmentAdded",
    "exchange_rate",
    "reservation_email_note",
    "user_did_action",
    "discount_details",
    "addition_details"

]);
$table_checkbook = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "checkbook", [
    "check_no",
    "check_amount",
    "check_bank",
    "check_currency",
    "check_date"
]);
$table_email_template = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "email_template", [
    "type",
    "template",
]);
$table_discount = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "discount", [
    "name",
    "value",
    "password",
    "date",
    "description",
    "type"
]);
$table_addition = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "addition", [
    "addition_name",
    "addition_value",
    "addition_type",
    "addition_date",
    "addition_description"

]);


$table_serial = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "serial_number", [
    "serial"

]);


$table_units_images = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "units_images", [
    "unit_id",
    "img_id",



]);


$tabel_configuration= new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "configuration", [
    "id",
    "plugin",
    "name",
    "value",
    "description"

]);

$table_cancel_reason = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "cancel_reason", [
    "user_id",
    "unit_id",
    "date",
    "flag",
    "reason"

]);

/*Added by Noora Unit_History table*/
$table_unit_history= new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "unit_history", [
    "id",
    "user_name",
    "uid",
    "action",
    "date",
    "customer_name"
]);

/*Added by Maysam mssql_config table*/
$table_mssql_config = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "mssql_config", [
    "server",
    "msdb",
    "username",
    "pass",
]);
$table_contract1 = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "contract1", [
    "contractDate",
    "companyNum",
    "systemUser",
    "purchaser1",
    "idType1",
    "idNum1",
    "idPlace1",
    "idProDate1",
    "idExpDate1",
    "regNo1",
    "registered1",
    "country1",
    "city1",
    "regionName1",
    "streetName1",
    "homePhone1",
    "workPhone1",
    "mobileNum1",
    "faxNum1",
    "mailBox1",
    "postalCode1",
    "eMail1",
    "purchaser2",
    "idType2",
    "idNum2",
    "idPlace2",
    "idProDate2",
    "idExpDate2",
    "regNo2",
    "registered2",
    "country2",
    "city2",
    "regionName2",
    "streetName2",
    "homePhone2",
    "workPhone2",
    "mobileNum2",
    "faxNum2",
    "mailBox2",
    "postalCode2",
    "eMail2",
    "unitNum",
    "unitArea",
    "haiName",
    "floorNum",
    "landNum",
    "hawdNum",
    "hawdName",
    "buildingNum",
    "buildingsNum",
    "unitDesc",
    "damageFine",
    "priceTotal",
    "pricePart1",
    "pricePart2",
    "pricePart3",
    "delayPeriod",
    "penaltyClause",
    "systemUserIDNo",
    "systemUserPassportNo",
    "companyName",
    "companyNum_reg",
    "companyFor",
    "haiArea",
    "checksNum",
    "arabon",
    "remainingAmountDelay",
    "penefitCompensation",
    "addPart6",
    "addPartB",
    "releaseDate",
    "ownersUnionNum",
    "ownersUnionProDate",
    "addSafqa",
    "annexes",
    "safqaDate",
    "PaidWithDelivery",
    "CostPaidWithDelivery"
]);


$table_contract1_unit = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "parking", [
    "id",
    "contract1_id",
    "unit_id",
]);

$table_parking = new \UserFrosting\DatabaseTable("contract1_unit", [
    "id",
    "rawabi_code",
    "neighporhood",
    "building",
    "floor",
    "parking_number",
    "description",
    "price",
    "available",
]);

$table_storage = new \UserFrosting\DatabaseTable("storages", [
    "id",
    "rawabi_code",
    "neighporhood",
    "tabu_code",
    "building",
    "floor",
    "storage_number",
    "tabu_description",
    "area",
    "price",
    "available",
]);
$table_parking_storage_reservation = new \UserFrosting\DatabaseTable("parking_storage_reservation", [
    "id",
    "uid",
    "parking_storage_id",
    "type",
    "reservation_date",
    "currency",
    "exchange_rate",
]);
$table_unit_payment_period = new \UserFrosting\DatabaseTable("unit_payment_period", [
    "id",
    "unit_id",
    "period",
]);

$table_contract2_unit = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "contract1_unit", [
    "id",
    "contract2_id",
    "unit_id",
]);
$table_payments1 = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "payments1", [
    "paymentNum",
    "paymentAmount",
    "paymentDate",
]);
$table_purchase = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "purchase", [
    "id",
    "user_id",
    "purchase_date",
    "neighborhood"
]);
$table_neighborhoods = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "neighborhoods", [
    "haiArabicName",
    "haiEnglishName",
    "haiArea",
    "HAO_num",
    "HAO_date",
    "haiBuildingsNum",
    "estContrDate",
    "estContrDate2",
    "land",
    "estContrNum",
    "estContrNum2"
]);
$table_contract2 = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "contract2", [
    "baytiCompanyNumber",
    "systemUser2",
    "renter1",
    "r_idType1",
    "r_idNum1",
    "r_idProDate1",
    "r_idPlace1",
    "r_idExpDate1",
    "r_country1",
    "r_city1",
    "r_streetName1",
    "r_regionName1",
    "r_workPhone1",
    "r_homePhone1",
    "r_mobileNum1",
    "r_faxNum1",
    "r_mailBox1",
    "r_eMail1",
    "r_postalCode1",
    "renter2",
    "r_idType2",
    "r_idNum2",
    "r_idProDate2",
    "r_idPlace2",
    "r_idExpDate2",
    "r_country2",
    "r_city2",
    "r_streetName2",
    "r_regionName2",
    "r_workPhone2",
    "r_homePhone2",
    "r_mobileNum2",
    "r_faxNum2",
    "r_mailBox2",
    "r_eMail2",
    "r_postalCode2",
    "r_unitArea",
    "r_haiName",
    "r_unitNum",
    "r_floorNum",
    "r_landNum",
    "r_buildingNum",
    "r_hawdNum",
    "r_hawdName",
    "r_buildingsNum",
    "r_unitDesc",
    "rentPeriod",
    "rentPrice",
    "releasePeriod",
    "startRentDate",
    "endRentDate",
    "r_totalPrice",
    "additions",
    "yy",
    "paymentAPeriod",
    "paymentA",
    "fromDateA",
    "toDateA",
    "paymentBPeriod",
    "paymentB",
    "fromDateB",
    "toDateB",
    "paymentCPeriod",
    "paymentC",
    "fromDateC",
    "toDateC",
    "checksNum",
    "contract2Day",
    "contract2Date",
    "r_companyFor",
    "r_companyName",
    "r_companyNum",
    "contract2_addPartB",
    "r_checksNum",
    "sponsorName",
    "sponsorAddress",
    "sponsorIdNum",
    "sponsorMobile",
    "r_HAO_num",
    "r_HAO_date",
    "r_haiArea",
    "r_showContract3Dates",
    "extraAdditions"
]);

$table_contract3 = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "contract3", [
    "contractDate","companyNum","systemUser","purchaser1","buildingNum","floorNum","homeSize","haiName","haiArea","unitDesc","buildingNum2","landNum","hawdName","hawdNum","buildingsNum","appendix","moreInfo","during","price","ownerPart","commonPrice","addPart","signDate","fullName","idNum","companyName","companyFor","HAO_num","extraAdditions"
]);
/*Added by majd Fouqhaa*/
$table_uploadedfiles = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "uploadedfiles", [
    'filename',
    'filesize',
    'filepath'
]);
/*Endded by Maysam*/
$table_reservation_user = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "reservation_user",[
    "user_id",
    "reservation_id"
]
                                                         );
$table_reservation_unit = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "reservation_unit");
$table_checkbook_unit = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "checkbook_unit");
$table_contract1_unit = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "contract1_unit");
$table_parking = new \UserFrosting\DatabaseTable("parking");
$table_parking_storage_reservation = new \UserFrosting\DatabaseTable("parking_storage_reservation");
$table_unit_payment_period = new \UserFrosting\DatabaseTable("unit_payment_period");
$table_storage = new \UserFrosting\DatabaseTable("storages");
$table_contract2_unit = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "contract2_unit");
$table_payments1_unit = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "payments1_unit");
$table_contract2_unit = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "contract2_unit");
$table_contract3_unit = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "contract3_unit");

\UserFrosting\Database::setSchemaTable("unit", $table_unit);
\UserFrosting\Database::setSchemaTable("payments", $table_payments);
\UserFrosting\Database::setSchemaTable("contracts", $table_contracts);
\UserFrosting\Database::setSchemaTable("contracts_templates", $table_contracts_templates);
\UserFrosting\Database::setSchemaTable("permissions", $table_permissions);
\UserFrosting\Database::setSchemaTable("units_cash_receipts", $table_units_cash_receipts);
\UserFrosting\Database::setSchemaTable("parking_storage_payments", $table_parking_storage_payments);
\UserFrosting\Database::setSchemaTable("units_cash_receipts_prices", $table_units_cash_receipts_prices);
\UserFrosting\Database::setSchemaTable("units_cash_receipts_files", $table_units_cash_receipts_files);

\UserFrosting\Database::setSchemaTable("reservation", $table_reservation);
\UserFrosting\Database::setSchemaTable("reservation_user", $table_reservation_user);
\UserFrosting\Database::setSchemaTable("reservation_unit", $table_reservation_unit);
\UserFrosting\Database::setSchemaTable("checkbook", $table_checkbook);
\UserFrosting\Database::setSchemaTable("checkbook_unit", $table_checkbook_unit);
\UserFrosting\Database::setSchemaTable("email_template", $table_email_template);
\UserFrosting\Database::setSchemaTable("discount", $table_discount);
\UserFrosting\Database::setSchemaTable("addition", $table_addition);
\UserFrosting\Database::setSchemaTable("serial_number", $table_serial);
\UserFrosting\Database::setSchemaTable("cancel_reason", $table_cancel_reason);
\UserFrosting\Database::setSchemaTable("units_images", $table_units_images);
\UserFrosting\Database::setSchemaTable("mssql_config", $table_mssql_config);
\UserFrosting\Database::setSchemaTable("contract1", $table_contract1);
\UserFrosting\Database::setSchemaTable("payments1", $table_payments1);
\UserFrosting\Database::setSchemaTable("purchase", $table_purchase);
\UserFrosting\Database::setSchemaTable("contract1_unit", $table_contract1_unit);
\UserFrosting\Database::setSchemaTable("parking", $table_parking);
\UserFrosting\Database::setSchemaTable("parking_storage_reservation", $table_parking_storage_reservation);
\UserFrosting\Database::setSchemaTable("unit_payment_period", $table_unit_payment_period);
\UserFrosting\Database::setSchemaTable("storages", $table_storage);
\UserFrosting\Database::setSchemaTable("contract2_unit", $table_contract2_unit);
\UserFrosting\Database::setSchemaTable("payments1_unit", $table_payments1_unit);
\UserFrosting\Database::setSchemaTable("contract2", $table_contract2);
\UserFrosting\Database::setSchemaTable("contract2_unit", $table_contract2_unit);

\UserFrosting\Database::setSchemaTable("contract3", $table_contract3);
\UserFrosting\Database::setSchemaTable("contract3_unit", $table_contract3_unit);

\UserFrosting\Database::setSchemaTable("neighborhoods", $table_neighborhoods);
\UserFrosting\Database::setSchemaTable("uploadedfiles", $table_uploadedfiles);
\UserFrosting\Database::setSchemaTable("unit_history", $table_unit_history);

/*ended by Fadi*/
$table_group_user = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "group_user");
$tabel_configuration = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "configuration");
$table_authorize_user = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "authorize_user");
$table_authorize_group = new \UserFrosting\DatabaseTable($app->config('db')['db_prefix'] . "authorize_group");

\UserFrosting\Database::setSchemaTable("user", $table_user);
\UserFrosting\Database::setSchemaTable("user_event", $table_user_event);
\UserFrosting\Database::setSchemaTable("group", $table_group);
\UserFrosting\Database::setSchemaTable("group_user", $table_group_user);
\UserFrosting\Database::setSchemaTable("configuration", $tabel_configuration);
\UserFrosting\Database::setSchemaTable("authorize_user", $table_authorize_user);
\UserFrosting\Database::setSchemaTable("authorize_group", $table_authorize_group);

// Info for RememberMe table
$app->remember_me_table = [
    'tableName' => $app->config('db')['db_prefix'] . "user_rememberme",
    'credentialColumn' => 'user_id',
    'tokenColumn' => 'token',
    'persistentTokenColumn' => 'persistent_token',
    'expiresColumn' => 'expires'
];

/* Event Types
    "sign_up",
    "sign_in",
    "verification_request",
    "password_reset_request",
*/

/* Load UserFrosting site settings */

// Default settings
$setting_values = [
    'userfrosting' => [
        'site_title' => 'UserFrosting',
        'admin_email' => 'admin@userfrosting.com',
        'email_login' => '1',
        'can_register' => '1',
        'enable_captcha' => '1',
        'require_activation' => '1',
        'resend_activation_threshold' => '0',
        'reset_password_timeout' => '10800',
        'create_password_expiration' => '86400',
        'default_locale' => 'en_US',
        'guest_theme' => 'default',
        'minify_css' => '0',
        'minify_js' => '0',
        'version' => '0.3.1.19',
        'author' => 'Alex Weissman',
        'show_terms_on_register' => '1',
        'site_location' => 'The State of Indiana',
        'site_logo' => 'logo-default.png',
        'site_background_image' => 'photo-1507149833265-60c372daea22.jpg',
        'site_contact_info' => 'example@company.com',
        'site_company_name' => 'Company Name',
    ]
];
$setting_descriptions = [
    'userfrosting' => [
        "site_title" => "The title of the site.  By default, displayed in the title tag, as well as the upper left corner of every user page.",
        "admin_email" => "The administrative email for the site.  Automated emails, such as verification emails and password reset links, will come from this address.",
        "email_login" => "Specify whether users can login via email address or username instead of just username.",
        "can_register" => "Specify whether public registration of new accounts is enabled.  Enable if you have a service that users can sign up for, disable if you only want accounts to be created by you or an admin.",
        "enable_captcha" => "Specify whether new users must complete a captcha code when registering for an account.",
        "require_activation" => "Specify whether email verification is required for newly registered accounts.  Accounts created by another user never need to be verified.",
        "resend_activation_threshold" => "The time, in seconds, that a user must wait before requesting that the account verification email be resent.",
        "reset_password_timeout" => "The time, in seconds, before a user's password reset token expires.",
        "create_password_expiration" => "The time, in seconds, before a new user's password creation token expires.",
        "default_locale" => "The default language for newly registered users.",
        "guest_theme" => "The template theme to use for unauthenticated (guest) users.",
        "minify_css" => "Specify whether to use concatenated, minified CSS (production) or raw CSS includes (dev).",
        "minify_js" => "Specify whether to use concatenated, minified JS (production) or raw JS includes (dev).",
        "version" => "The current version of UserFrosting.",
        "author" => "The author of the site.  Will be used in the site's author meta tag.",
        "show_terms_on_register" => "Specify whether or not to show terms and conditions when registering.",
        "site_location" => "The nation or state in which legal jurisdiction for this site falls.",
        "site_logo" => "The logo of the reservation system",
        'site_background_image' => 'The background of the reservation system',
        'site_contact_info' => 'The contact info for the company',
        'site_company_name' => 'The Name of the Company',
    ]
];

// Create the site settings object.  If the database cannot be accessed or has not yet been set up, use the default settings.
$app->site = new \UserFrosting\SiteSettings($setting_values, $setting_descriptions);

// Create the page schema object
$app->schema = new \UserFrosting\PageSchema($app->site->uri['css'], $app->config('css.path') , $app->site->uri['js'], $app->config('js.path') );

// Create a guest user, which lets us proceed until we can try to authenticate the user
$app->setupGuestEnvironment();

// Setup Twig custom functions
$app->setupTwig();

/** Register site settings with site settings config page */
$app->hook('settings.register', function () use ($app){
    // Register core site settings
    $app->site->register('userfrosting', 'site_company_name', "Company Name","text");
    $app->site->register('userfrosting', 'site_title', "Site Title");
    $app->site->register('userfrosting', 'site_location', "Site Location");
    $app->site->register('userfrosting', 'author', "Site Author");
    $app->site->register('userfrosting', 'admin_email', "Account Management Email");
    $app->site->register('userfrosting', 'default_locale', "Locale for New Users", "select", $app->site->getLocales());
    $app->site->register('userfrosting', 'guest_theme', "Guest Theme", "select", $app->site->getThemes());
    $app->site->register('userfrosting', 'can_register', "Public Registration", "toggle", [0 => "Off", 1 => "On"]);
    $app->site->register('userfrosting', 'enable_captcha', "Registration Captcha", "toggle", [0 => "Off", 1 => "On"]);
    $app->site->register('userfrosting', 'show_terms_on_register', "Show TOS", "toggle", [0 => "Off", 1 => "On"]);
    $app->site->register('userfrosting', 'require_activation', "Require Account Activation", "toggle", [0 => "Off", 1 => "On"]);
    $app->site->register('userfrosting', 'email_login', "Email Login", "toggle", [0 => "Off", 1 => "On"]);
    $app->site->register('userfrosting', 'resend_activation_threshold', "Resend Activation Email Cooloff (s)");
    $app->site->register('userfrosting', 'reset_password_timeout', "Password Recovery Timeout (s)");
    $app->site->register('userfrosting', 'create_password_expiration', "Create Password for New Users Timeout (s)");
    $app->site->register('userfrosting', 'minify_css', "Minify CSS", "toggle", [0 => "Off", 1 => "On"]);
    $app->site->register('userfrosting', 'minify_js', "Minify JS", "toggle", [0 => "Off", 1 => "On"]);
    $app->site->register('userfrosting', 'site_logo', "Site Logo","file");
    $app->site->register('userfrosting', 'site_background_image', "Site Background Image","file");
    $app->site->register('userfrosting', 'site_contact_info', "Contact Email","email");
}, 1);

// Register CSS and JS includes for the pages
$app->hook('includes.css.register', function () use ($app){
    // Register common CSS files

   // $app->schema->registerCSS("common", "normalize.css");
  //  $app->schema->registerCSS("common", "font-awesome-4.3.0.css");
    $app->schema->registerCSS("common", "font-starcraft.css");
   // $app->schema->registerCSS("common", "bootstrap-3.3.2.css");
    $app->schema->registerCSS("common", "bootstrap-modal-bs3patch.css");   // Must be included BEFORE bootstrap-modal.css
   // $app->schema->registerCSS("common", "bootstrap-modal.css");
    $app->schema->registerCSS("common", "lib/metisMenu.css");
    $app->schema->registerCSS("common", "bootstrap-custom.css");
    $app->schema->registerCSS("common", "bootstrap-switch.css");
    $app->schema->registerCSS("common", "tablesorter/theme.bootstrap.css");
    $app->schema->registerCSS("common", "tablesorter/jquery.tablesorter.pager.css");
    $app->schema->registerCSS("common", "select2/select2.css");
    $app->schema->registerCSS("common", "select2/select2-bootstrap.css");
    $app->schema->registerCSS("common", "bootstrapradio.css");
    $app->schema->registerCSS("common", "custom-font.css");


    // Dashboard CSS
    //$app->schema->registerCSS("dashboard", "invoiceReceipt.css");
    $app->schema->registerCSS("dashboard", "timeline.css");
    $app->schema->registerCSS("dashboard", "lib/morris.css");
    $app->schema->registerCSS("dashboard", "jquery-ui.css");
    $app->schema->registerCSS("dashboard", "invoice.css");
    $app->schema->registerCSS("dashboard", "bootstrap-datepicker.min.css");
    $app->schema->registerCSS("dashboard", "bootstrap-multiselect.css");
    $app->schema->registerCSS("dashboard", "dashboard.css");
    $app->schema->registerCSS("dashboard", "custom-font.css");

    // Users CSS
    $app->schema->registerCSS("user", "users.css");
    // Groups CSS
    $app->schema->registerCSS("group", "groups.css");
    $app->schema->registerCSS("group", "custom-font.css");

    // Homepage CSS
   // $app->schema->registerCSS("home", "homepage.css");
    $app->schema->registerCSS("home", "custom-font.css");

    // Logged-out CSS
    $app->schema->registerCSS("loggedout", "jumbotron-narrow.css");
    $app->schema->registerCSS("loggedout", "homepage.css");
    /*added by fadi*/
    //$app->schema->registerCSS("unit", "invoiceReceipt.css");
     //$app->schema->registerCSS("unit", "img.css");
    $app->schema->registerCSS("unit", "datepicker.css");
    $app->schema->registerCSS("unit", "bootstrap-datepicker.min.css");
    $app->schema->registerCSS("unit", "bootstrap-select.min.css");
    //$app->schema->registerCSS("unit", "dataTables.bootstrap.min.css");
    $app->schema->registerCSS("unit", "responsive.dataTables.min.css");
   // $app->schema->registerCSS("unit", "invoice.css");
    $app->schema->registerCSS("unit", "custom-font.css");
    //$app->schema->registerCSS("unit", "invoiceReceipt.css");

    $app->schema->registerCSS("discount", "dataTables.bootstrap.min.css");
    $app->schema->registerCSS("discount", "responsive.dataTables.min.css");
    $app->schema->registerCSS("discount", "discount.css");
    //$app->schema->registerCSS("discount", "invoiceReceipt.css");
    $app->schema->registerCSS("discount", "invoice.css");
    $app->schema->registerCSS("discount", "custom-font.css");

    $app->schema->registerCSS("addition", "dataTables.bootstrap.min.css");
    $app->schema->registerCSS("addition", "responsive.dataTables.min.css");
    $app->schema->registerCSS("addition", "addition.css");
    $app->schema->registerCSS("addition", "invoice.css");
    $app->schema->registerCSS("addition", "custom-font.css");
    //$app->schema->registerCSS("addition", "invoiceReceipt.css");

    $app->schema->registerCSS("rented-units", "bootstrap-datepicker.min.css");
    $app->schema->registerCSS("rented-units", "bootstrap-select.min.css");
    $app->schema->registerCSS("rented-units", "dataTables.bootstrap.min.css");
    $app->schema->registerCSS("rented-units", "responsive.dataTables.min.css");
    // $app->schema->registerCSS("rented-units", "invoiceReceipt.css");
  //  $app->schema->registerCSS("rented-units", "invoice.css");
    $app->schema->registerCSS("rented-units", "datepicker.css");
    $app->schema->registerCSS("rented-units", "custom-font.css");

    $app->schema->registerCSS("neighborhoods", "dataTables.bootstrap.min.css");
    $app->schema->registerCSS("neighborhoods", "responsive.dataTables.min.css");
    $app->schema->registerCSS("neighborhoods", "datepicker.css");
    $app->schema->registerCSS("neighborhoods", "bootstrap-datepicker.min.css");
    $app->schema->registerCSS("neighborhoods", "neighborhood.css");
    $app->schema->registerCSS("neighborhoods", "custom-font.css");

    $app->schema->registerCSS("uploadunits", "bootstrap-datepicker.min.css");
    $app->schema->registerCSS("uploadunits", "bootstrap-select.min.css");
    $app->schema->registerCSS("uploadunits", "dataTables.bootstrap.min.css");
    $app->schema->registerCSS("uploadunits", "responsive.dataTables.min.css");
    // $app->schema->registerCSS("uploadunits", "invoiceReceipt.css");
    $app->schema->registerCSS("uploadunits", "invoice.css");
    $app->schema->registerCSS("uploadunits", "datepicker.css");
    $app->schema->registerCSS("uploadunits", "custom-font.css");

    $app->schema->registerCSS("upload", "bootstrap-datepicker.min.css");
    $app->schema->registerCSS("upload", "bootstrap-select.min.css");
    $app->schema->registerCSS("upload", "dataTables.bootstrap.min.css");
    $app->schema->registerCSS("upload", "responsive.dataTables.min.css");
    // $app->schema->registerCSS("upload", "invoiceReceipt.css");
    $app->schema->registerCSS("upload", "invoice.css");
    $app->schema->registerCSS("upload", "datepicker.css");
    $app->schema->registerCSS("upload", "upload.css");
    $app->schema->registerCSS("upload", "custom-font.css");



    $app->schema->registerJS("discount", "moment.min.js");
    $app->schema->registerJS("discount", "bootstrap-datepicker.js");
    $app->schema->registerJS("discount", "bootstrap-datetimepicker.min.js");
    $app->schema->registerJS("discount", "bootstrap-select.min.js");
    $app->schema->registerJS("discount", "jquery.dataTables.min.js");
    $app->schema->registerJS("discount", "dataTables.responsive.min.js");
    $app->schema->registerJS("discount", "dataTables.bootstrap.min.js");
    $app->schema->registerJS("discount", "dataTables.buttons.min.js");
    $app->schema->registerJS("discount", "buttons.bootstrap.min.js");
    $app->schema->registerJS("discount", "jszip.js");
    $app->schema->registerJS("discount", "async.js");
    $app->schema->registerJS("discount", "pdfmake.min.js");
    $app->schema->registerJS("discount", "vfs_fonts.js");
    $app->schema->registerJS("discount", "buttons.html5.min.js");
    $app->schema->registerJS("discount", "buttons.print.min.js");
    $app->schema->registerJS("discount", "rasterizeHTML.allinone.js");
    $app->schema->registerJS("discount", "jquery.watermark.min.js");
    $app->schema->registerJS("discount", "jspdf.debug.js");
    $app->schema->registerJS("discount", "underscore-min.js");
    $app->schema->registerCSS('uploadunits', 'upload.css');
    $app->schema->registerCSS("discount", "bootstrap-datepicker.min.css");
    $app->schema->registerCSS("discount", "bootstrap-select.min.css");
    $app->schema->registerCSS("discount", "dataTables.bootstrap.min.css");
    $app->schema->registerCSS("discount", "responsive.dataTables.min.css");
    // $app->schema->registerCSS("discount", "invoiceReceipt.css");

    $app->schema->registerCSS("discount", "invoice.css");
    $app->schema->registerCSS("discount", "datepicker.css");
    $app->schema->registerCSS('upload', 'upload.css');
    $app->schema->registerCSS("common", "common.css");

}, 1);

$app->hook('includes.js.register', function () use ($app){
    // Register common JS files
    $app->schema->registerJS("common", "jquery-1.11.2.js");
    $app->schema->registerJS("common", "bootstrap-3.3.2.js");
    $app->schema->registerJS("common", "bootstrap-modal.js");
    $app->schema->registerJS("common", "bootstrap-modalmanager.js");
    $app->schema->registerJS("common", "sb-admin-2.js");
    $app->schema->registerJS("common", "lib/metisMenu.js");
    $app->schema->registerJS("common", "jqueryValidation/jquery.validate.js");
    $app->schema->registerJS("common", "jqueryValidation/additional-methods.js");
    $app->schema->registerJS("common", "jqueryValidation/jqueryvalidation-methods-fortress.js");
    $app->schema->registerJS("common", "moment.js");
    $app->schema->registerJS("common", "tablesorter/jquery.tablesorter.js");
    $app->schema->registerJS("common", "tablesorter/tables.js");
    $app->schema->registerJS("common", "tablesorter/jquery.tablesorter.pager.js");
    $app->schema->registerJS("common", "tablesorter/jquery.tablesorter.widgets.js");
    $app->schema->registerJS("common", "tablesorter/widgets/widget-sort2Hash.js");
    $app->schema->registerJS("common", "select2/select2.min.js");
    $app->schema->registerJS("common", "bootstrapradio.js");
    $app->schema->registerJS("common", "bootstrap-switch.js");
    $app->schema->registerJS("common", "handlebars-v1.2.0.js");
    $app->schema->registerJS("common", "userfrosting.js");
    $app->schema->registerJS("common", "html2canvas.js");
    $app->schema->registerJS("common", "dom-to-image.min.js");
    $app->schema->registerJS("common", "languages.js");
    // Dashboard JS
    $app->schema->registerJS("dashboard", "lib/raphael.js");
    $app->schema->registerJS("dashboard", "lib/morris.js");
    $app->schema->registerJS("dashboard", "bootstrap-datetimepicker.min.js");
    $app->schema->registerJS("dashboard", "bootstrap-multiselect.js");


    // Users JS
    $app->schema->registerJS("user", "widget-users.js");

    // Groups JS
    $app->schema->registerJS("group", "widget-groups.js");

    // Auth JS
    $app->schema->registerJS("auth", "widget-auth.js");

    // Permissions JS
    $app->schema->registerJS("permission", "widget-permissions.js");

    /*added by fadi*/
        // $app->schema->registerJS("unit", "jquery-1.11.2.js");
    $app->schema->registerJS("unit", "moment.min.js");
    //$app->schema->registerJS("unit", "bootstrap-datepicker.js");
    $app->schema->registerJS("unit", "bootstrap-datetimepicker.min.js");
    $app->schema->registerJS("unit", "bootstrap-select.min.js");
    $app->schema->registerJS("unit", "jquery.dataTables.min.js");
    $app->schema->registerJS("unit", "dataTables.responsive.min.js");
    $app->schema->registerJS("unit", "dataTables.bootstrap.min.js");
    $app->schema->registerJS("unit", "dataTables.buttons.min.js");
    $app->schema->registerJS("unit", "buttons.bootstrap.min.js");
    $app->schema->registerJS("unit", "jszip.js");
    $app->schema->registerJS("unit", "async.js");
    $app->schema->registerJS("unit", "pdfmake.min.js");
    $app->schema->registerJS("unit", "vfs_fonts.js");
    $app->schema->registerJS("unit", "buttons.html5.min.js");
    $app->schema->registerJS("unit", "buttons.print.min.js");
    $app->schema->registerJS("unit", "rasterizeHTML.allinone.js");
    $app->schema->registerJS("unit", "jquery.watermark.min.js");
    $app->schema->registerJS("unit", "jspdf.debug.js");
    $app->schema->registerJS("unit", "underscore-min.js");


    $app->schema->registerJS("addition", "moment.min.js");
    $app->schema->registerJS("addition", "bootstrap-datepicker.js");
    $app->schema->registerJS("addition", "bootstrap-datetimepicker.min.js");
    $app->schema->registerJS("addition", "bootstrap-select.min.js");
    $app->schema->registerJS("addition", "jquery.dataTables.min.js");
    $app->schema->registerJS("addition", "dataTables.responsive.min.js");
    $app->schema->registerJS("addition", "dataTables.bootstrap.min.js");
    $app->schema->registerJS("addition", "dataTables.buttons.min.js");
    $app->schema->registerJS("addition", "buttons.bootstrap.min.js");
    $app->schema->registerJS("addition", "jszip.js");
    $app->schema->registerJS("addition", "async.js");
    $app->schema->registerJS("addition", "pdfmake.min.js");
    $app->schema->registerJS("addition", "vfs_fonts.js");
    $app->schema->registerJS("addition", "buttons.html5.min.js");
    $app->schema->registerJS("addition", "buttons.print.min.js");
    $app->schema->registerJS("addition", "rasterizeHTML.allinone.js");
    $app->schema->registerJS("addition", "jquery.watermark.min.js");
    $app->schema->registerJS("addition", "jspdf.debug.js");
    $app->schema->registerJS("addition", "underscore-min.js");

    $app->schema->registerJS("addition", "moment.min.js");
    $app->schema->registerJS("addition", "bootstrap-datepicker.js");
    $app->schema->registerJS("addition", "bootstrap-datetimepicker.min.js");
    $app->schema->registerJS("addition", "bootstrap-select.min.js");
    $app->schema->registerJS("addition", "jquery.dataTables.min.js");
    $app->schema->registerJS("addition", "dataTables.responsive.min.js");

    //discount
    $app->schema->registerJS("discount", "jquery.dataTables.min.js");
    $app->schema->registerJS("discount", "dataTables.responsive.min.js");
    $app->schema->registerJS("neighborhoods", "jquery.dataTables.min.js");
    $app->schema->registerJS("addition", "dataTables.buttons.min.js");
    $app->schema->registerJS("addition", "buttons.bootstrap.min.js");
     $app->schema->registerJS("addition", "jquery.dataTables.min.js");
    $app->schema->registerJS("addition", "dataTables.responsive.min.js");
    $app->schema->registerJS("addition", "dataTables.bootstrap.min.js");
    $app->schema->registerJS("addition", "dataTables.buttons.min.js");
    $app->schema->registerJS("addition", "buttons.bootstrap.min.js");
    $app->schema->registerJS("addition", "buttons.html5.min.js");
    $app->schema->registerJS("addition", "buttons.print.min.js");


    $app->schema->registerJS("addition", "jquery.dataTables.min.js");
    $app->schema->registerJS("addition", "dataTables.responsive.min.js");
   $app->schema->registerJS("addition", "bootstrap-datepicker.js");
    $app->schema->registerJS("addition", "bootstrap-datetimepicker.min.js");


    $app->schema->registerJS("neighborhoods", "dataTables.responsive.min.js");
    $app->schema->registerJS("neighborhoods", "bootstrap-datepicker.js");
    $app->schema->registerJS("neighborhoods", "bootstrap-datetimepicker.min.js");


    /*ended by fadi*/

    $app->schema->registerJS("rented-units", "moment.min.js");
    $app->schema->registerJS("rented-units", "bootstrap-datepicker.js");
    $app->schema->registerJS("rented-units", "bootstrap-datetimepicker.min.js");
    $app->schema->registerJS("rented-units", "bootstrap-select.min.js");
    $app->schema->registerJS("rented-units", "jquery.dataTables.min.js");
    $app->schema->registerJS("rented-units", "dataTables.responsive.min.js");
    $app->schema->registerJS("rented-units", "dataTables.bootstrap.min.js");
    $app->schema->registerJS("rented-units", "dataTables.buttons.min.js");
    $app->schema->registerJS("rented-units", "buttons.bootstrap.min.js");
    $app->schema->registerJS("rented-units", "jszip.js");
    $app->schema->registerJS("rented-units", "async.js");
    $app->schema->registerJS("rented-units", "pdfmake.min.js");
    $app->schema->registerJS("rented-units", "vfs_fonts.js");
    $app->schema->registerJS("rented-units", "buttons.html5.min.js");
    $app->schema->registerJS("rented-units", "buttons.print.min.js");
    $app->schema->registerJS("rented-units", "rasterizeHTML.allinone.js");
    $app->schema->registerJS("rented-units", "jquery.watermark.min.js");
    $app->schema->registerJS("rented-units", "jspdf.debug.js");
    $app->schema->registerJS("rented-units", "underscore-min.js");

    $app->schema->registerJS("rented-units", "bootstrap-datepicker.js");
    $app->schema->registerJS("rented-units", "bootstrap-datetimepicker.min.js");
    $app->schema->registerJS("rented-units", "bootstrap-select.min.js");

$app->schema->registerJS("discount", "moment.min.js");
    $app->schema->registerJS("discount", "bootstrap-datepicker.js");
    $app->schema->registerJS("discount", "bootstrap-datetimepicker.min.js");
    $app->schema->registerJS("discount", "bootstrap-select.min.js");
    $app->schema->registerJS("discount", "jquery.dataTables.min.js");
    $app->schema->registerJS("discount", "dataTables.responsive.min.js");
    $app->schema->registerJS("discount", "dataTables.bootstrap.min.js");
    $app->schema->registerJS("discount", "dataTables.buttons.min.js");
    $app->schema->registerJS("discount", "buttons.bootstrap.min.js");
    $app->schema->registerJS("discount", "jszip.js");
    $app->schema->registerJS("discount", "async.js");
    $app->schema->registerJS("discount", "pdfmake.min.js");
    $app->schema->registerJS("discount", "vfs_fonts.js");
    $app->schema->registerJS("discount", "buttons.html5.min.js");
    $app->schema->registerJS("discount", "buttons.print.min.js");
    $app->schema->registerJS("discount", "rasterizeHTML.allinone.js");
    $app->schema->registerJS("discount", "jquery.watermark.min.js");
    $app->schema->registerJS("discount", "jspdf.debug.js");
    $app->schema->registerJS("discount", "underscore-min.js");

    $app->schema->registerJS("discount", "bootstrap-datepicker.js");
    $app->schema->registerJS("discount", "bootstrap-datetimepicker.min.js");
    $app->schema->registerJS("discount", "bootstrap-select.min.js");


}, 1);

/** Plugins */
// Run initialization scripts for plugins
$var_plugins = $app->site->getPlugins();
foreach($var_plugins as $var_plugin) {
    require_once($app->config('plugins.path')."/".$var_plugin."/config-plugin.php");
}

// Hook for core and plugins to register includes
$app->applyHook("includes.css.register");
$app->applyHook("includes.js.register");
