<?php

/**
 * en_US
 *
 * US English message token translations
 *
 * @package UserFrosting
 * @link http://www.userfrosting.com/components/#i18n
 * @author Alexander Weissman
 */

/*
{{name}} - Dynamic markers which are replaced at run time by the relevant index.
*/

$lang = array();

// Site Content
$lang = array_merge($lang, [
    "REGISTER_WELCOME" => "Registration is fast and simple.",
    "MENU_USERS" => "Users",
    "MENU_CONFIGURATION" => "Configuration",
    "MENU_SITE_SETTINGS" => "Site Settings",
    "MENU_GROUPS" => "Groups",
    "MENU_PERMISSIONS" => "Permissions",
    "EMAIL_MGMT" => "Email Management",
    "SMTP_MAIL_CONFIG" => "SMTP Mail Configuration",
    "MYSQL_CONFIG" => "MYSQL Configuration",
    "MSSQL_CONFIG" => "MSSQL Configuration",
    "NEIGHBORHOOD" => "Neighborhoods",
    "DISCOUNT" => "Discounts",
    "HEADER_MESSAGE_ROOT" => "YOU ARE SIGNED IN AS THE ROOT USER"
]);

// Installer
$lang = array_merge($lang, array(
    "INSTALLER_INCOMPLETE" => "You cannot register the root account until the installer has been successfully completed!",
    "MASTER_ACCOUNT_EXISTS" => "The master account already exists!",
    "MASTER_ACCOUNT_NOT_EXISTS" => "You cannot register an account until the master account has been created!",
    "CONFIG_TOKEN_MISMATCH" => "Sorry, that configuration token is not correct."
));

// Account
$lang = array_merge($lang, array(
    "ACCOUNT_SPECIFY_USERNAME" => "Please enter your user name.",
    "ACCOUNT_SPECIFY_DISPLAY_NAME" => "Please enter your display name.",
    "ACCOUNT_SPECIFY_PASSWORD" => "Please enter your password.",
    "ACCOUNT_SPECIFY_EMAIL" => "Please enter your email address.",
    "ACCOUNT_SPECIFY_CAPTCHA" => "Please enter the captcha code.",
    "ACCOUNT_SPECIFY_LOCALE" => "Please specify a valid locale.",
    "ACCOUNT_INVALID_EMAIL" => "Invalid email address",
    "ACCOUNT_INVALID_USERNAME" => "Invalid username",
    "ACCOUNT_INVALID_USER_ID" => "The requested user id does not exist.",
    "ACCOUNT_USER_OR_EMAIL_INVALID" => "Username or email address is invalid.",
    "ACCOUNT_USER_OR_PASS_INVALID" => "Username or password is invalid.",
    "ACCOUNT_ALREADY_ACTIVE" => "Your account is already activated.",
    "ACCOUNT_REGISTRATION_DISABLED" => "We're sorry, account registration has been disabled.",
    "ACCOUNT_REGISTRATION_BROKEN" => "We're sorry, there is a problem with our account registration process.  Please contact us directly for assistance.",
    "ACCOUNT_REGISTRATION_LOGOUT" => "I'm sorry, you cannot register for an account while logged in. Please log out first.",
    "ACCOUNT_INACTIVE" => "Your account is in-active. Check your emails / spam folder for account activation instructions.",
    "ACCOUNT_INVALID" => "This account does not exist. It may have been deleted.  Please contact us for more information.",
    "ACCOUNT_DISABLED" => "This account has been disabled. Please contact us for more information.",
    "ACCOUNT_USER_CHAR_LIMIT" => "Your username must be between {{min}} and {{max}} characters in length.",
    "ACCOUNT_USER_INVALID_CHARACTERS" => "Username can only include alpha-numeric characters",
    "ACCOUNT_USER_NO_LEAD_WS" => "Username cannot begin with whitespace",
    "ACCOUNT_USER_NO_TRAIL_WS" => "Username cannot end with whitespace",
    "ACCOUNT_DISPLAY_CHAR_LIMIT" => "Your display name must be between {{min}} and {{max}} characters in length.",
    "ACCOUNT_PASS_CHAR_LIMIT" => "Your password must be between {{min}} and {{max}} characters in length.",
    "ACCOUNT_EMAIL_CHAR_LIMIT" => "Email must be between {{min}} and {{max}} characters in length.",
    "ACCOUNT_TITLE_CHAR_LIMIT" => "Titles must be between {{min}} and {{max}} characters in length.",
    "ACCOUNT_PASS_MISMATCH" => "Your password and confirmation password must match",
    "ACCOUNT_DISPLAY_INVALID_CHARACTERS" => "Display name can only include alpha-numeric characters",
    "ACCOUNT_USERNAME_IN_USE" => "Username '{{user_name}}' is already in use",
    "ACCOUNT_DISPLAYNAME_IN_USE" => "Display name '{{display_name}}' is already in use",
    "ACCOUNT_EMAIL_IN_USE" => "Email '{{email}}' is already in use",
    "ACCOUNT_LINK_ALREADY_SENT" => "An activation email has already been sent to this email address in the last {{resend_activation_threshold}} second(s). Please try again later.",
    "ACCOUNT_NEW_ACTIVATION_SENT" => "We have emailed you a new activation link, please check your email",
    "ACCOUNT_SPECIFY_NEW_PASSWORD" => "Please enter your new password",
    "ACCOUNT_SPECIFY_CONFIRM_PASSWORD" => "Please confirm your new password",
    "ACCOUNT_NEW_PASSWORD_LENGTH" => "New password must be between {{min}} and {{max}} characters in length",
    "ACCOUNT_PASSWORD_INVALID" => "Current password doesn't match the one we have on record",
    "ACCOUNT_DETAILS_UPDATED" => "Account details updated for user '{{user_name}}'",
    "ACCOUNT_CREATION_COMPLETE" => "Account for new user '{{user_name}}' has been created.",
    "ACCOUNT_ACTIVATION_COMPLETE" => "You have successfully activated your account. You can now login.",
    "ACCOUNT_REGISTRATION_COMPLETE_TYPE1" => "You have successfully registered. You can now login.",
    "ACCOUNT_REGISTRATION_COMPLETE_TYPE2" => "You have successfully registered. You will soon receive an activation email. You must activate your account before logging in.",
    "ACCOUNT_PASSWORD_NOTHING_TO_UPDATE" => "You cannot update with the same password",
    "ACCOUNT_PASSWORD_CONFIRM_CURRENT" => "Please confirm your current password",
    "ACCOUNT_SETTINGS_UPDATED" => "Account settings updated",
    "ACCOUNT_PASSWORD_UPDATED" => "Account password updated",
    "ACCOUNT_EMAIL_UPDATED" => "Account email updated",
    "ACCOUNT_TOKEN_NOT_FOUND" => "Token does not exist / Account is already activated",
    "ACCOUNT_DELETE_MASTER" => "You cannot delete the master account!",
    "ACCOUNT_DISABLE_MASTER" => "You cannot disable the master account!",
    "ACCOUNT_DISABLE_SUCCESSFUL" => "Account for user '{{user_name}}' has been successfully disabled.",
    "ACCOUNT_ENABLE_SUCCESSFUL" => "Account for user '{{user_name}}' has been successfully enabled.",
    "ACCOUNT_DELETION_SUCCESSFUL" => "User '{{user_name}}' has been successfully deleted.",
    "ACCOUNT_MANUALLY_ACTIVATED" => "{{user_name}}'s account has been manually activated",
    "ACCOUNT_DISPLAYNAME_UPDATED" => "{{user_name}}'s display name changed to '{{display_name}}'",
    "ACCOUNT_TITLE_UPDATED" => "{{user_name}}'s title changed to '{{title}}'",
    "ACCOUNT_GROUP_ADDED" => "Added user to group '{{name}}'.",
    "ACCOUNT_GROUP_REMOVED" => "Removed user from group '{{name}}'.",
    "ACCOUNT_GROUP_NOT_MEMBER" => "User is not a member of group '{{name}}'.",
    "ACCOUNT_GROUP_ALREADY_MEMBER" => "User is already a member of group '{{name}}'.",
    "ACCOUNT_PRIMARY_GROUP_SET" => "Successfully set primary group for '{{user_name}}'.",
    "ACCOUNT_WELCOME" => "Welcome back, {{display_name}}"
));

// Generic validation
$lang = array_merge($lang, array(
    "VALIDATE_REQUIRED" => "The field '{{self}}' must be specified.",
    "VALIDATE_BOOLEAN" => "The value for '{{self}}' must be either '0' or '1'.",
    "VALIDATE_INTEGER" => "The value for '{{self}}' must be an integer.",
    "VALIDATE_ARRAY" => "The values for '{{self}}' must be in an array.",
    "VALIDATE_NO_LEAD_WS" => "The value for '{{self}}' cannot begin with spaces, tabs, or other whitespace",
    "VALIDATE_NO_TRAIL_WS" => "The value for '{{self}}' cannot end with spaces, tabs, or other whitespace"
));

// Configuration
$lang = array_merge($lang, array(
    "CONFIG_PLUGIN_INVALID" => "You are trying to update settings for plugin '{{plugin}}', but there is no plugin by that name.",
    "CONFIG_SETTING_INVALID" => "You are trying to update the setting '{{name}}' for plugin '{{plugin}}', but it does not exist.",
    "CONFIG_NAME_CHAR_LIMIT" => "Site name must be between {{min}} and {{max}} characters in length",
    "CONFIG_URL_CHAR_LIMIT" => "Site url must be between {{min}} and {{max}} characters in length",
    "CONFIG_EMAIL_CHAR_LIMIT" => "Site email must be between {{min}} and {{max}} characters in length",
    "CONFIG_TITLE_CHAR_LIMIT" => "New user title must be between {{min}} and {{max}} characters in length",
    "CONFIG_ACTIVATION_TRUE_FALSE" => "Email activation must be either `true` or `false`",
    "CONFIG_REGISTRATION_TRUE_FALSE" => "User registration must be either `true` or `false`",
    "CONFIG_ACTIVATION_RESEND_RANGE" => "Activation Threshold must be between {{min}} and {{max}} hours",
    "CONFIG_EMAIL_INVALID" => "The email you have entered is not valid",
    "CONFIG_UPDATE_SUCCESSFUL" => "Your site's configuration has been updated. You may need to load a new page for all the settings to take effect",
    "MINIFICATION_SUCCESS" => "Successfully minified and concatenated CSS and JS for all page groups."
));

// Forgot Password
$lang = array_merge($lang, array(
    "FORGOTPASS_INVALID_TOKEN" => "Your secret token is not valid",
    "FORGOTPASS_OLD_TOKEN" => "Token past expiration time",
    "FORGOTPASS_COULD_NOT_UPDATE" => "Couldn't update password",
    "FORGOTPASS_REQUEST_CANNED" => "Lost password request cancelled",
    "FORGOTPASS_REQUEST_EXISTS" => "There is already an outstanding lost password request on this account",
    "FORGOTPASS_REQUEST_SENT" => "A password reset link has been emailed to the address on file for user '{{user_name}}'",
    "FORGOTPASS_REQUEST_SUCCESS" => "We have emailed you instructions on how to regain access to your account"
));

// Mail
$lang = array_merge($lang, array(
    "MAIL_ERROR" => "Fatal error attempting mail, contact your server administrator",
));

// Miscellaneous
$lang = array_merge($lang, array(
    "PASSWORD_HASH_FAILED" => "Password hashing failed. Please contact a site administrator.",
    "NO_DATA" => "No data/bad data sent",
    "CAPTCHA_FAIL" => "Failed security question",
    "CONFIRM" => "Confirm",
    "DENY" => "Deny",
    "SUCCESS" => "Success",
    "ERROR" => "Error",
    "SERVER_ERROR" => "Oops, looks like our server might have goofed. If you're an admin, please check the PHP error logs.",
    "NOTHING_TO_UPDATE" => "Nothing to update",
    "SQL_ERROR" => "Fatal SQL error",
    "FEATURE_DISABLED" => "This feature is currently disabled",
    "ACCESS_DENIED" => "Hmm, looks like you don't have permission to do that.",
    "LOGIN_REQUIRED" => "Sorry, you must be logged in to access this resource.",
    "LOGIN_ALREADY_COMPLETE" => "You are already logged in!"
));

// Permissions
$lang = array_merge($lang, array(
    "GROUP_INVALID_ID" => "The requested group id does not exist",
    "GROUP_NAME_CHAR_LIMIT" => "Group names must be between {{min}} and {{max}} characters in length",
    "AUTH_HOOK_CHAR_LIMIT" => "Authorization hook names must be between {{min}} and {{max}} characters in length",
    "GROUP_NAME_IN_USE" => "Group name '{{name}}' is already in use",
    "GROUP_DELETION_SUCCESSFUL" => "Successfully deleted group '{{name}}'",
    "GROUP_CREATION_SUCCESSFUL" => "Successfully created group '{{name}}'",
    "GROUP_UPDATE" => "Details for group '{{name}}' successfully updated.",
    "CANNOT_DELETE_GROUP" => "The group '{{name}}' cannot be deleted",
    "GROUP_CANNOT_DELETE_DEFAULT_PRIMARY" => "The group '{{name}}' cannot be deleted because it is set as the default primary group for new users. Please first select a different default primary group.",
    "GROUP_AUTH_EXISTS" => "The group '{{name}}' already has a rule defined for hook '{{hook}}'.",
    "GROUP_AUTH_CREATION_SUCCESSFUL" => "A rule for '{{hook}}' has been successfully created for group '{{name}}'.",
    "GROUP_AUTH_UPDATE_SUCCESSFUL" => "The rule granting access to group '{{name}}' for '{{hook}}' has been successfully updated.",
    "GROUP_AUTH_DELETION_SUCCESSFUL" => "The rule granting access to group '{{name}}' for '{{hook}}' has been successfully deleted.",
    "GROUP_DEFAULT_PRIMARY_NOT_DEFINED" => "You cannot create a new user because there is no default primary group defined.  Please check your group settings."
));

// dashboard
$lang = array_merge($lang, array(
    "registered" => "Registered",
    "view_details" => "View Details",
    "units" => "Units",
    "cash_receipts" => "Cash receipts",
    "all" => "all",
    "neighborhood" => "Neighborhood",
    "view_more_details" => "View more Details",
    "recent_not_signed_reservations" => "Recent not signed reservations",
//    "company_code" => "Apartment Code",
    "company_code" => " Code",
    "building_type" => "Building Type",
    "last_modified_user" => "Last Modified User",
    "customer_name" => "Customer Name",
    "reservation_date" => "Reservation Date",
    "payment_date" => "Payment date",
    "payment_amount" => "Payment Amount",
    "payment_number" => "Payment Number",
    "payment_unit_id" => "Unit ID",
    "reservation_user" => "Reservation User",
    "from" => "From",
    "to" => "To",
    "upcomming_payments" => "Upcoming payments",
));

// index page
$lang = array_merge($lang, array(
    "delete_image" => "Delete image",
    "parking" => "parking",
    "storage" => "storage",
    "select_item" => "Select Item",
    "select_parking" => "Select Parking",
    "select_storage" => "Select Storage",
    "description" => "Description",
    "floor" => "Floor",
    "parking_number" => "Parking Number",
    "price" => "Price",
    "tabu_number" => "Tabu Number",
    "area" => "Area(size)",
    "storage_number" => "Storage Number",
    "reserve" => "Reserve",
    "tabu_code" => "Tabu Code",
));

// create reservation
$lang = array_merge($lang, array(
    "customer_info" => "Customer Info",
    "leadID" => "Lead ID",
    "customer_name" => "Customer Name",
    "place_of_issue" => "Place of issue",
    "address" => "Address",
    "id_number" => "Identification Number",
    "city" => "City",
    "region" => "Region",
    "street" => "Street",
    "mail_box" => "Mail Box",
    "postal_code" => "Postal Code",
    "email" => "Email",
    "work_phone" => "Work Phone",
    "telephone_number" => "Telephone Number",
    "phone_number" => "Mobile Number",
    "collected_fees" => "Collected Fees",
    "select_collected_fees" => "Select Collected Fees",
    "reservation_date" => "Reservation Date",
    "payment_method" => "Payment Method",
    "select_payment_method" => "Select Payment Method",
    "rent_to_buy" => "Rent To Buy",
    "cash" => "Cash",
    "finance" => "Finance",
    "direct_installment" => "Direct Installment",
    "added_value" => "Added Value",
    "price_details" => "Price Details",
    "select" => "Select",
    "addition" => "Addition",
    "discount" => "Discount",
    "no_addition" => "No Addition",
    "no_discount" => "No Discount",
    "clarification" => "Clarification",
    "discount_password" => "Discount Password",
    "user_password" => "User Password",
    "unit_total_price" => "Unit Total Price",
    "price_without_discount" => "Price Without Discount",
    "notes" => "Notes",
    "next" => "Next",
    "cancel" => "Cancel",
    "previous" => "Previous",
    "save_temporary" => "Save Temporary",
    "identification_type" => "Identification Type",
));

// cancel reservation
$lang = array_merge($lang, array(
    "are_you_sure" => "Are You Sure",
    "go_back" => "Go Back",
    "continue" => "Continue",
    "cancellation_modal_message" => [
        "unit" => "This will cancel the reservation for unit",
        "building" => "in building",
        "company_code" => "with Apartment Code",
        "tabu_code" => "and  tabu code",
        "at" => "at",
    ]
));

// unit delete
$lang = array_merge($lang, array(
    "confirmation" => "Confirmation",
    "delete_unit_message" => "Are you sure that you want completly delete this unit from units Table?",
    "confirm" => "Confirm",

));

// contract delete
$lang = array_merge($lang, array(
    "delete_contract_message" => "Are you sure that you want completly delete this unit with it's reservation and contract information?",
));

// contract signed delete
$lang = array_merge($lang, array(
    "delete_signed_contract_message" => "Are you sure that you want delete the assigned unit with it's reservation, payment and contract information?",
));

// check reservation
$lang = array_merge($lang, array(
    "check_reservation_title" => "Unit is being reserved",
    "check_reservation_message" => "Sorry this Unit is being reserved by another employee",
));

// unit history
$lang = array_merge($lang, array(
    "unit_history" => "Unit History",
    "action" => "Action",
    "done_by" => "Done By",
    "date" => "Date",
    "asking_to_delete_unit" => "Do you want to delete this unit ?",
    "delete_unit" => "Delete Unit",
    "asking_to_change_unit_to_available" => "Do you want to change the status of this unit to available ?",
    "change_to_available" => "Change to Available",
    "change_to_signed" => "Change to Signed",
    "asking_to_change_unit_to_signed" => "Do you want to change the status of this unit to Signed ?",
    "" => "Change to Signed",
));

// unit table
$lang = array_merge($lang, array(
    "search" => "Search",
    "add_storage_or_parking" => "add Storage or Parking",
    "status" => "Status",
    "client_name" => "Client Name",
    "reservation_price" => "Reservation Price",
    "reservation_date" => "Reservation Date",
    "sales_guide_name" => "sales guide name",
    "contract_price" => "Contract Price",
    "finishing_price" => "Finishing Price",
    "contract_date" => "Contract Date",
));

// contract sign
$lang = array_merge($lang, array(
    "current_date" => "Current Date",
    "sign_modal_title" => "Sign Unit confirmation",
    "sign_modal_text" => "I have confirmed that the contract has been signed between the two parts",
));

// cancel reason
$lang = array_merge($lang, array(
    "cancel_reason_modal_title" => "The reason of cancellation",
    "cancel_reason_modal_text" => "Why do you want to cancel this Reservation?",
));

// cancel signed reason
$lang = array_merge($lang, array(
    "cancel_signed_reason_modal_title" => "The reason of cancellation",
    "cancel_signed_reason_modal_text" => "Why do you want to cancel this Signed Unit?",
));

// cancel INFO
$lang = array_merge($lang, array(
    "approve" => "Approve",
    "reject" => "Reject",
    "cancellation_info" => "Cancellation Info",
    "cancellation_reason" => "The cancellation reason",
));

// Rent Page
$lang = array_merge($lang, array(
    "hint" => "Hint",
    "select_one" => "Please Select at least one unit.",
    "info_about_changed_unit" => "Info about the changed units",
));

// NEIGHBORHOOD Page
$lang = array_merge($lang, array(
    "add_new_neighborhood" => "Add New Neighborhood",
    "neighborhood_english_name" => "Neighborhood English Name",
    "neighborhood_arabic_name" => "Neighborhood Arabic Name",
    "neighborhood_area" => "Neighborhood Area",
    "number_of_buildings" => "Number of Buildings",
    "land_number" => "Land Number",
    "hao_internal_number" => "HAO Internal Number",
    "hao_internal_date" => "HAO Internal Date",
    "hao_established_number" => "HAO Established Number",
    "hao_established_date" => "HAO Established Date",
    "actions" => "Actions",
    "HAO_Number" => "HAO Number",
    "HAO_Date" => "HAO Date",
    "save" => "Save",
    "edit_neighborhood" => "Edit Neighborhood Info",
    "delete_neighborhood" => "Delete Neighborhood",
    "delete_neighborhood_msg" => "Are you sure you want to delete this neighborhood, you will not be able to undo this operation!",
    "update" => "Update",
    "yes" => "Yes",
));

// Discount Page
$lang = array_merge($lang, array(
    "add_new_discount" => "Add New Discount",
    "fixed_discounts" => "Fixed Discounts",
    "discount_name" => "Discount Name",
    "discount_type" => "Discount Type",
    "discount_value" => "Discount Value",
    "discount_date" => "Discount Date",
    "password" => "Password",
    "view_password" => "View Password",
    "discount_description" => "Discount Description",
    "discount_percentage" => "Discount Percentage",
    "percentage_discounts" => "Percentage Discounts",
    "create_new_discount" => "Create New Discount",
    "create" => "Create",
    "edit_discount" => "Edit Discount",
    "discount_delete_title" => "Delete a Discount",
    "discount_delete_msg" => "Are you sure you want to delete this Record?",
));

// Addition Page
$lang = array_merge($lang, array(
    "additions" => "Additions",
    "add_new_addition" => "Add New Addition",
    "fixed_additions" => "Fixed Additions",
    "addition_name" => "Addition Name",
    "addition_value" => "Addition Value",
    "addition_date" => "Addition Date",
    "addition_description" => "Addition Description",
    "addition_percentage" => "Addition Percentage",
    "percentage_additions" => "Percentage Additions",
    "create_new_addition" => "Create New Addition",
    "addition_type" => "Addition Type",
    "delete_addition" => "Delete an Addition",
    "delete_addition_text" => "Are you sure you want to delete this Record?",
    "edit_addition" => "Edit Addition",
));

// upload unit Page
$lang = array_merge($lang, array(
    "upload_issue_msg" => "There is an issue in sheet file please fix it and upload again",
    "upload" => "Upload",
    "download_unit_template" => "Download the template file for inserting the new units",
    "download_edited_unit_template" => "Upload the edited version of the upload_units.xlsx file",
    "download_unit_template_for_price" => "Download the template file for editing the price",
    "upload_edieted_unit_template" => "Upload the edited version of the edit_units.xlsx file",
    "extension_error_msg" => "Please select suitable file with extension",
));

// upload Parking and Storage Pages
$lang = array_merge($lang, array(
    "upload_edited_parking_template" => "Upload the edited version of the upload_parking.xlsx file",
    "upload_edited_storage_template" => "Upload the edited version of the upload_storages.xlsx file",
    "download_storage_template_edit" => "Download the template file for inserting the storage you need to updates",
    "download_parking_template_edit" => "Download the template file for inserting the parking you need to updates",
    "update_parking" => "Update Parking",
    "update_storage" => "Update Storage",
    "upload_storage_template" => "Upload the edited version of the upload_storage.xlsx file",
    "upload_parking_template" => "Upload the edited version of the upload_parking.xlsx file",
    "download_parking_template" => "Download the template file for inserting the new parking",
    "download_storage_template" => "Download the template file for inserting the new storage",
    "upload_storage" => "Upload Storage",
    "upload_parking" => "Upload Parking",
));

// upload Images and Plans Pages
$lang = array_merge($lang, array(
    "upload_images" => "Upload unit images/plans",
    "upload_plans" => "Upload storage/parking images/plans",
    "filter_by" => "Filter By",
    "choose_neighborhood" => "Please choose a neighborhood",
    "storage_or_parking" => "Storage Or Parking",
    "please_choose" => "Please choose",
//    "selected_units" => "Selected Units",
    "selected_units" => "Selected ",
    "select_images_to_upload" => "Select Images to upload",
    "select_file_error" => "Please select image file.",
));

// Reservation Fees Page
$lang = array_merge($lang, array(
    "reservation_fees" => "Reservation Fees",
    "for_example" => "for example",
));

// Contract Template
$lang = array_merge($lang, array(
    "prepare_the_template" => "Prepare The Template",
    "template_name" => "Template Name",
    "template_type" => "Template Type",
    "select_attribute" => "Select Attribute",
    "select_type" => "Select Type",
    "copied" => "copied",
    "copy" => "Copy",
    "created_at" => "Created at",
));

// Email Template
$lang = array_merge($lang, array(
    "select_email_template" => "Select Email Template",
    "prepare_the_email_template" => "Prepare The Email Template",
));

// Users
$lang = array_merge($lang, array(
    "create_new_user" => "Create New User",
    "download_csv" => "Download CSV",
    "user_name" => "User name",
    "display_name" => "Display name",
    "title" => "Title",
    "email" => "Email",
    "group" => "Group",
    "last_sign_in" => "Last Sign-in",
    "status_actions" => "Status/Actions",
    "disabled" => "Disabled",
    "unactivated" => "Unactivated",
    "active" => "Active",
    "activate_user" => "Activate user",
    "edit_user" => "Edit user",
    "change_password" => "Change password",
    "disable_user" => "Disable user",
    "enable_user" => "Enable user",
    "delete_user" => "Delete user",
    "brand_new" => "Brand new",
    "registered_since" => "Registered Since",
    "groups" => "Groups",
    "edit" => "Edit",
    "activate" => "Activate",
    "disable" => "Disable",
    "enable" => "Enable",
    "delete" => "Delete",
    "send_password_link_msg" => "Send the user a link that will allow them to choose their own password",
    "set_password_msg" => "Set the user's password as",
    "confirm_password" => "Confirm password",
    "submit" => "Submit",
    "email_required" => "Email Is required",
));


// Mail Configurations
$lang = array_merge($lang, array(
    "mail_configurations" => "Mail Configurations",
    "host" => "Host",
    "port" => "Port",
    "auth" => "Auth",
    "secure" => "Secure",
    "user" => "Sender email",
    "reservation_emails" => "Reservation Emails",
    "purchase_emails" => "Purchase Emails",
    "cancellation_emails" => "Cancellation Emails",
));

// MSSQL Configuration
$lang = array_merge($lang, array(
    "mssql_configuration" => "MSSQL Configuration",
    "server" => "Server",
    "database" => "Database",
));

// Modal Purchase
$lang = array_merge($lang, array(
    "loading_template" => "Loading template!",
    "contract_saved" => "Contract Saved Successfully",
    "contract_unsaved" => "Contract Does Not Saved",
    "select_contract" => "Select Contract",
    "payments" => "Payments",
    "contracts" => "Contracts",
    "complete_purchase" => "Complete Purchase",
    "preview" => "Preview",
    "save_contract" => "Save Contract",
    "save_payment" => "Save Payment",
    "save_all" => "Save All",
    "number_of_payment" => "Number of Payment",
    "total_amount" => "Total amount",
    "first_payment" => "First payment",
    "period" => "The Period",
    "start_date" => "Start Date",
    "payment" => "Payment",
    "payment_amount" => "Payment Amount",
    "payment_date" => "Payment Date",
    "payment_unit_id" => "Unit ID",
    "reservation_user" => "Reservation User",
    "options" => "Options",
    "add_payment" => "Add Payment",
    "payment_saved" => "Payment Saved Successfully",
    "payment_unsaved" => "Payment Does Not Saved",
    "exit" => "Exit",
    "generate" => "Generate",
));


// top bar
$lang = array_merge($lang, array(
    "settings" => "Settings",
    "logout" => "Logout",
    "switch_language" => "تغيير إلى اللغة العربية",
));

// side bar
$lang = array_merge($lang, array(
    "dashboard" => "Dashboard",
    "units" => "Units",
    "Rented_Units" => "Rented Units",
    "Upload_Units" => "Upload Units",
    "Upload_images" => "Upload unit images/plans",
//    "Upload_Plans" => "Upload storage/parking images/plans",
    "Upload_Plans" => "Images",
    "Upload_Storage" => "Upload Storage",
    "Upload_Parking" => "Upload Parking",
    "Site_Settings" => "Site Settings",
    "Templates" => "Templates",
    "Contract_Template" => "Contract Template",
    "Create_Template" => "Create Template",
    "Templates_Transaction" => "Templates Transaction",
    "Email_Template" => "Email Template",
    "Create_Email_Template" => "Create Email Template",
    "Mail_Configurations" => "Mail Configurations",
    "Reservation_Fees" => "Reservation Fees",
));

$lang = array_merge($lang, array(
    "purchase_contract" => "Purchase Contract",
    "appendix_storage" => "Appendix/Storage",
    "appendix_parking" => "Appendix/Parking",
    "reservation_receipt" => "Reservation Receipt",
    "functions" => "Functions",
    "select_function" => "Functions",
    "number_to_alpha" => "Number To Alphabet",
    "current_date" => "Current Date",
    "clear_payments" => "Clear All Payments",
    "selected_currency" => "Selected Currency",
    "selected_currency_symbol" => "Selected Currency Symbol",
    "input_username" => "Username",
    "cal" => "Calculation",
    "exchange_rate" => "Exchange Rate",
    "final_price" => "Total Price"
));

$lang = array_merge($lang, array(
    "add_new_cash_receipts" => "Add New Cash Receipt",
    "subtotal" => "SubTotal",
    "receipt_date" => "Receipt Date",
    "created_by" => "created by ",
    "view_cash_receipts" => "View Cash Receipt",

    "save_receipt" => "Save Receipt",
));


return $lang;
