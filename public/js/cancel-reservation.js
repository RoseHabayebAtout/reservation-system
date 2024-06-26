
    function requestToCancel(self) {

        var available = $("#available").text();
        var unitID = $("#unitID").text();

        console.log(available);
        console.log(unitID);

        $('#cancelreas').modal('show');
        $('.cancelReason').val("");
        var csrf_token = $("meta[name=csrf_token]").attr("content");
        var row = $(self).closest('tr');
        var rowData = $('#unitTable').DataTable().row(row).data();
        var uid = rowData.id;
       // var user_id, reservation_id;
      //  var cancelID;
        var reqToCancel = $('#reqTocancel').text();

        $('#sendReason').on('click', function () {
            $('.loader-modal-lg').modal('show');
            var modal = $(this).closest('.modal');
            var reason = modal.find('.cancelReason').val();
            var date = new Date();
            date = formatDateToYYYYMMDD(date);


             if(reqToCancel.length > 0){
                 // request to cancel from the sale

                 var url = site['uri']['public'] + '/cancelreason/';
                 var params = {
                     date: date,
                     uid: uid,
                     reason: reason,
                     flag: 1,
                     csrf_token: encodeURIComponent(csrf_token)
                 };
                      $.ajax({
                         type: "POST",
                         url: url,
                         data: params,
                     }).done(function (data) {
                         //Ajax request to save the cancellation action in the DB
                         $('#unitTable').DataTable().ajax.reload(null, false);
                          saveHistory("", uid, date, "", "Request to Cancel for Reason: " + reason);

                          //the end of sending the reason

                        // var retdata = JSON.parse(data);
                       //  var cancelID = retdata.id;
                          $('.loader-modal-lg').modal('hide');
                          $('#cancelreas').modal('hide');

                     }).error(function (err) {
                          alert('error');
                          $('.loader-modal-lg').modal('hide');
                          $('#cancelreas').modal('hide');

                      });

             } else {
                 // cancellation from admin

                 var url = site['uri']['public'] + '/unit/'+ uid +'/reservation/delete/';
                 $.ajax({
                     type: "Delete",
                     url: url,
                     data: {csrf_token:csrf_token, uid:uid, reason:reason, user:'admin'}
                 }).done(function (data) {
                     console.log(data);
                     $('.loader-modal-lg').modal('hide');
                     $('#unitTable').DataTable().ajax.reload(null, false);
                     saveHistory("", uid, date, "", "Cancellation for Reason: " + reason);
                     $('.cancellation-modal-lg').modal('hide');
                     $('#cancelreas').modal('hide');
                 }).error(function (err) {
                     alert('error');
                     $('.loader-modal-lg').modal('hide');
                 });
             }



















            //
            // var req = $.ajax({
            //     url: site['uri']['public'] + '/reservationUnit/' + uid,
            //     type: "get"
            //
            // }).done(function (data) {
            //     data = JSON.parse(data);
            //     if (data.length > 0) {
            //         reservation_id = data[0].reservation_id;
            //
            //         var req = $.ajax({
            //             url: site['uri']['public'] + '/reservationUser/' + reservation_id,
            //             type: "get"
            //
            //         }).done(function (data) {
            //             data = JSON.parse(data);
            //             //user_id=data[0].user_id;
            //             user_id ={{ user.id }};
            //             var flag = 1;
            //
            //             //send the reason and storer it on the database
            //             var params = {
            //                 date: date,
            //                 user_id: user_id,
            //                 uid: uid,
            //                 reason: reason,
            //                 flag: flag,
            //                 csrf_token: encodeURIComponent(csrf_token)
            //             };
            //             var url = site['uri']['public'] + '/cancelreason/';
            //
            //             var req1 = $.ajax({
            //                 type: "POST",
            //                 url: url,
            //                 data: params,
            //
            //             }).done(function (data) {
            //
            //                 //Ajax request to save the cancellation action in the DB
            //                 $('#unitTable').DataTable().ajax.reload(null, false);
            //                 //the end of sending the reason
            //
            //                 retdata = JSON.parse(data);
            //                 cancelID = retdata.id;
            //
            //                 var req = $.ajax({
            //                     url: site['uri']['public'] + '/cancellationUsername/' + retdata.user_id,
            //                     type: "get"
            //
            //                 }).done(function (data) {
            //                     if (reqToCancel == '') {
            //                         saveHistory("", uid, date, "", "Cancellation for Reason: " + retdata.reason);
            //                     } else {
            //                         saveHistory("", uid, date, "", "Request to Cancel for Reason: " + retdata.reason);
            //                     }
            //
            //
            //                 });
            //                 //if admin then cancel resarvation
            //                 if (flagg == 1) {
            //                     cancelReservation(self, cancelID);
            //                 }
            //
            //                 if (flagg == 0) {
            //                     $('.loader-modal-lg').modal('show');
            //                     // set the  unit to pending status
            //                     var params = {
            //                         available: 2,
            //                         contract_type: 0,
            //                         uid: uid,
            //                         requestToCancelReason: reason,
            //                         csrf_token: encodeURIComponent(csrf_token)
            //                     };
            //                     var url = site['uri']['public'] + "/unit/available/";
            //
            //                     var req1 = $.ajax({
            //                         type: "POST",
            //                         url: url,
            //                         data: params
            //
            //                     }).done(function (data) {
            //                         $('.loader-modal-lg').modal('hide');
            //                         $('#unitTable').DataTable().ajax.reload(null, false);
            //                         $('#cancelreas').modal('hide');
            //                     })
            //                         .fail(failureCallback);
            //
            //                 }     //end of pending status
            //
            //             })
            //                 .fail(failureCallback);
            //
            //         })
            //     } else {
            //         //if admin then cancel resarvation
            //         if (flagg == 1) {
            //             if (!cancelID)
            //                 cancelID = -1;
            //
            //             cancelReservation(self, cancelID);
            //             $('#cancelreas').modal('hide');
            //         }
            //
            //         if (flagg == 0) {
            //             $('.loader-modal-lg').modal('show');
            //             // set the  unit to pending status
            //             var params = {
            //                 available: 2,
            //                 contract_type: 0,
            //                 uid: uid,
            //                 requestToCancelReason: reason,
            //                 csrf_token: encodeURIComponent(csrf_token)
            //             };
            //             var url = site['uri']['public'] + "/unit/available/";
            //
            //             var req1 = $.ajax({
            //                 type: "POST",
            //                 url: url,
            //                 data: params
            //
            //             }).done(function (data) {
            //                 $('.loader-modal-lg').modal('hide');
            //                 $('#unitTable').DataTable().ajax.reload(null, false);
            //                 $('#cancelreas').modal('hide');
            //             })
            //                 .fail(failureCallback);
            //
            //         }     //end of pending status
            //     }
            //
            // });
            // allow = 1;

        });
    }

    function requestToCancelSigned(self) {
        var available = $("#available").text();
        var unitID = $("#unitID").text();

        $('#cancelSignedreas').modal('show');
        $('.cancelSignedReason').val("");
        var csrf_token = $("meta[name=csrf_token]").attr("content");

        //  var cancelID;

        $('#sendSignedReason').unbind().one('click', function () {
            $('.loader-modal-lg').modal('show');
            var modal = $(this).closest('.modal');
            var reason = modal.find('.cancelSignedReason').val();
            var date = new Date();
            date = formatDateToYYYYMMDD(date);

            var url = site['uri']['public'] + '/cancelSignedreason/';
            var params = {
                date: date,
                uid: unitID,
                reason: reason,
                flag: 1,
                csrf_token: encodeURIComponent(csrf_token)
            };
            $.ajax({
                type: "POST",
                url: url,
                data: params,
            }).done(function (data) {
                //Ajax request to save the cancellation action in the DB
                $('#unitTable').DataTable().ajax.reload(null, false);

                //reload the history table with the new data
                var url = site['uri']['public'] + '/unit/unitHistory/' + unitID;
                $('#historyTable').DataTable().ajax.url(url).load();
                $('.show-history-modal-lg').modal("hide");


                // get current date
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();
                today = yyyy + '/' + mm + '/' + dd;

                // save history
                saveHistory("", unitID, today, "", "Request changed to Available");

                //the end of sending the reason

                // var retdata = JSON.parse(data);
                //  var cancelID = retdata.id;
                $('.loader-modal-lg').modal('hide');
                $('#cancelSignedreas').modal('hide');

            }).error(function (err) {
                alert('error');
                $('.loader-modal-lg').modal('hide');
                $('#cancelSignedreas').modal('hide');

            });

        });
    }








