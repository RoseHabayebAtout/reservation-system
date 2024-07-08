<?php

namespace UserFrosting;

use DateInterval;
use DateTime;
use DateTimeZone;
use Traversable;
use UserFrosting\Permission;
use UserFrosting\Unit;

class PermissionsController extends \UserFrosting\BaseController {

    protected static $_table_id = "permissions";

    /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app){
        $this->_app = $app;
    }

    public function index(){

        $permissions = Permission::all();

        $this->_app->render('permissions/permissions.twig', [
            "permissions" => $permissions
        ]);
    }


    public function formPermissionCreate(){

        // Access-controlled resource
        if (!$this->_app->user->checkAccess('create_group')){
            $this->_app->notFound();
        }

        $get = $this->_app->request->get();

        if (isset($get['render']))
            $render = $get['render'];
        else
            $render = "modal";

        // Get a list of all themes
        $theme_list = $this->_app->site->getThemes();

        // Set default values
        $data['code'] = "";
        $data['name'] = "";
        $data['status'] = "ACTIVE";
        $data['created_at'] = date("Y-m-d");

        // Create a dummy Group to prepopulate fields
        $permission = new Permission($data);

        if ($render == "modal")
            $template = "components/common/permission-info-modal.twig";
        else
            $template = "components/common/permission-info-panel.twig";

        // Determine authorized fields
        $fields = ['code', 'name', 'status', 'created_at'];
        $show_fields = [];
        $disabled_fields = [];
        foreach ($fields as $field){
            if ($this->_app->user->checkAccess("update_group_setting", ["property" => $field]))
                $show_fields[] = $field;
            else
                $disabled_fields[] = $field;
        }

        // Load validator rules
        $schema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/permission-create.json");
        $this->_app->jsValidator->setSchema($schema);

        $this->_app->render($template, [
            "box_id" => $get['box_id'],
            "box_title" => "New Permission",
            "submit_button" => "Create Permission",
            "form_action" => $this->_app->site->uri['public'] . "/permissions",
            "group" => $permission,
            "themes" => $theme_list,
            "fields" => [
                "disabled" => $disabled_fields,
                "hidden" => []
            ],
            "buttons" => [
                "hidden" => [
                    "edit", "delete"
                ]
            ],
            "validators" => $this->_app->jsValidator->rules()
        ]);
    }

    public function createPermission(){

        $post = $this->_app->request->post();

        // DEBUG: view posted data
        //error_log(print_r($post, true));

        // Load the request schema
        $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/permission-create.json");

        // Get the alert message stream
        $ms = $this->_app->alerts;

        // Access-controlled resource
        if (!$this->_app->user->checkAccess('create_group')){
            $ms->addMessageTranslated("danger", "ACCESS_DENIED");
            $this->_app->halt(403);
        }

        // Set up Fortress to process the request
        $rf = new \Fortress\HTTPRequestFortress($ms, $requestSchema, $post);

        // Sanitize data
        $rf->sanitize();

        // Validate, and halt on validation errors.
        $error = !$rf->validate(true);

        // Get the filtered data
        $data = $rf->data();

        // Remove csrf_token from object data
        $rf->removeFields(['csrf_token']);

        // Perform desired data transformations on required fields.
        $data['code'] = trim($data['code']);
        $data['name'] = trim($data['name']);
        $data['status'] = "ACTIVE";
        $data['created_at'] = date("Y-m-d");

        if (isset($data['theme'])) {
            $data['theme'] = trim($data['theme']);
        }

        // Check if group name already exists
        if (Permission::where('code', $data['code'])->first()){
            $ms->addMessageTranslated("danger", "GROUP_NAME_IN_USE", $post);
            $error = true;
        }

        // Halt on any validation errors
        if ($error) {
            $this->_app->halt(400);
        }

        // Create the group
        $permission = new Permission($data);

        // Store new group to database
        $permission->store();

        // Success message
        $ms->addMessageTranslated("success", "GROUP_CREATION_SUCCESSFUL", $data);
    }

    public function deletePermission($permissionID){

        // Get the target group
        $permission = Permission::find($permissionID);

        // Get the alert message stream
        $ms = $this->_app->alerts;

        $ms->addMessageTranslated("success", "GROUP_DELETION_SUCCESSFUL", ["name" => $permission->name]);
        $permission->delete();       // TODO: implement Group function
        unset($permission);
    }

    public function formPermissionEdit($permission_id){
        // Access-controlled resource
        if (!$this->_app->user->checkAccess('update_permission')){
            $this->_app->notFound();
        }

        $get = $this->_app->request->get();

        if (isset($get['render']))
            $render = $get['render'];
        else
            $render = "modal";

        // Get the group to edit
        $permission = Permission::find($permission_id);

        // Get a list of all themes
        $theme_list = $this->_app->site->getThemes();

        if ($render == "modal")
            $template = "components/common/permission-info-modal.twig";
        else
            $template = "components/common/permission-info-panel.twig";

        // Determine authorized fields
        $fields = ['code', 'name', 'status', 'created_at'];
        $show_fields = [];
        $disabled_fields = [];
        $hidden_fields = [];
        foreach ($fields as $field){
            if ($this->_app->user->checkAccess("update_group_setting", ["property" => $field]))
                $show_fields[] = $field;
            else if ($this->_app->user->checkAccess("view_group_setting", ["property" => $field]))
                $disabled_fields[] = $field;
            else
                $hidden_fields[] = $field;
        }

        // Load validator rules
        $schema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/permission-update.json");
        $this->_app->jsValidator->setSchema($schema);

        $this->_app->render($template, [
            "box_id" => $get['box_id'],
            "box_title" => "Edit Permission",
            "submit_button" => "Update Permission",
            "form_action" => $this->_app->site->uri['public'] . "/permissions/g/$permission_id",
            "permission" => $permission,
            "themes" => $theme_list,
            "fields" => [
                "disabled" => $disabled_fields,
                "hidden" => $hidden_fields
            ],
            "buttons" => [
                "hidden" => [
                    "edit", "delete"
                ]
            ],
            "validators" => $this->_app->jsValidator->rules()
        ]);
    }

    public function updatePermission($permission_id){
        $post = $this->_app->request->post();

        // DEBUG: view posted data
        //error_log(print_r($post, true));

        // Load the request schema
        $requestSchema = new \Fortress\RequestSchema($this->_app->config('schema.path') . "/forms/permission-update.json");

        // Get the alert message stream
        $ms = $this->_app->alerts;

        // Get the target group
        $permission = Permission::find($permission_id);

        // If desired, put route-level authorization check here

        // Remove csrf_token
        unset($post['csrf_token']);

        // TODO: validate landing page route, theme, icon?

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

        // Update the group and generate success messages
        foreach ($data as $name => $value){
            if ($value != $permission->$name){
                $permission->$name = $value;
                // Add any custom success messages here
            }
        }

        $ms->addMessageTranslated("success", "GROUP_UPDATE", ["name" => $permission->name]);
        $permission->store();

    }
}
