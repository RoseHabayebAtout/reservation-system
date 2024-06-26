/**
 * @file This file contains functions and bindings for the UserFrosting group management pages.
 *
 * @author Alex Weissman
 * @license MIT
 */

$(document).ready(function() {
    // Link buttons
    bindPermissionTableButtons($("body"));
});

function bindPermissionTableButtons(table) {
    $(table).find('.js-permission-create').click(function() {
        permissionForm('dialog-permission-create');
    });

    $(table).find('.js-permission-edit').click(function() {
        var btn = $(this);
        var group_id = btn.data('id');
        permissionForm('dialog-permission-edit', group_id);
    });

    $(table).find('.js-permission-delete').click(function() {
        var btn = $(this);
        var group_id = btn.data('id');
        var name = btn.data('name');
        deletePermissionDialog('dialog-permission-delete', group_id, name);
    });
}

/**
 * Display a modal form for updating/creating a permission.
 *
 * @todo This function is highly redundant with userForm.  Can we refactor?
 */
function permissionForm(box_id, group_id) {
    group_id = typeof group_id !== 'undefined' ? group_id : "";

    // Delete any existing instance of the form with the same name
    if($('#' + box_id).length ) {
        $('#' + box_id).remove();
    }

    var data = {
        box_id: box_id,
        render: 'modal'
    };

    var url = site['uri']['public'] + "/forms/permissions";

    // If we are updating an existing group
    if (group_id) {
        data = {
            box_id: box_id,
            render: 'modal'
        };

        url = site['uri']['public'] + "/forms/permissions/g/" + group_id;
    }

    // Fetch and render the form
    $.ajax({
        type: "GET",
        url: url,
        data: data,
        cache: false
    })
        .fail(function(result) {
            // Display errors on failure
            $('#userfrosting-alerts').flashAlerts().done(function() {
            });
        })
        .done(function(result) {
            // Append the form as a modal dialog to the body
            $( "body" ).append(result);
            $('#' + box_id).modal('show');

            // Initialize select2's
            $('#' + box_id + ' .select2').select2();

            // Initialize is_default
            $('#' + box_id + ' input[name=is_default]:checked').addClass('active');

            // Set icon when changed
            $('#' + box_id + ' input[name=icon]').on('change', function(){
                $(this).prev(".icon-preview").find("i").removeClass().addClass($(this).val());
            });

            // Link submission buttons
            ufFormSubmit(
                $('#' + box_id).find("form"),
                validators,
                $("#form-alerts"),
                function(data, statusText, jqXHR) {
                    // Reload the page on success
                    window.location.reload(true);
                }
            );
        });
}

function deletePermissionDialog(box_id, group_id, name){
    // Delete any existing instance of the form with the same name
    if($('#' + box_id).length ) {
        $('#' + box_id).remove();
    }

    var url = site['uri']['public'] + "/forms/confirm";

    var data = {
        box_id: box_id,
        box_title: "Delete Permission",
        confirm_message: "Are you sure you want to delete the Permission " + name + "?",
        confirm_button: "Yes, delete Permission"
    };

    // Generate the form
    $.ajax({
        type: "GET",
        url: url,
        data: data
    })
        .fail(function(result) {
            // Display errors on failure
            $('#userfrosting-alerts').flashAlerts().done(function() {
            });
        })
        .done(function(result) {
            // Append the form as a modal dialog to the body
            $( "body" ).append(result);
            $('#' + box_id).modal('show');
            $('#' + box_id + ' .js-confirm').click(function(){
                var url = site['uri']['public'] + "/permissions/" + group_id + "/delete";

                csrf_token = $("meta[name=csrf_token]").attr("content");
                var data = {
                    group_id: group_id,
                    csrf_token: csrf_token
                };

                $.ajax({
                    type: "POST",
                    url: url,
                    data: data
                }).done(function(result) {
                    // Reload the page
                    window.location.reload();
                }).fail(function(jqXHR) {
                    if (site['debug'] == true) {
                        document.body.innerHTML = jqXHR.responseText;
                    } else {
                        console.log("Error (" + jqXHR.status + "): " + jqXHR.responseText );
                    }
                    $('#userfrosting-alerts').flashAlerts().done(function() {
                        // Close the dialog
                        $('#' + box_id).modal('hide');
                    });
                });
            });
        });
}

