$(document).ready(function () {
    $("#tbl_subscription").on('click', '.btn_open_edit', function(){
        let row = $(this).closest('tr');
	    let id = row.data('id');

        // alert("id = " + id);

        $.ajax({
            type: "get",
            url: "/getOneSubscription",
            data: {
                subscription_id: id,
            },
            // dataType: "dataType",
            success: function (response) {
                // console.log(response);
                $("#subs_edit_modal").modal('toggle');

                var sub_details = "Customer : <b>" + response.customer_name + "</b><br>Username: <b>" + response.username + "</b><br>Package: <b>" + response.package_name + "</b><br>Duration: <b>" + response.package_duration + "</b><br>Price: <b>" + response.package_price + "</b>";
                var sub_dates = "Purchase Date: <b>" + response.purchase_date + "</b><br>Start Date & Time: <b>" + response.start_datetime + "</b><br>End Date & Time: <b>" + response.end_datetime + "</b><br>Current Expiry Date & Time: <b>" + response.expiry_datetime + "</b>";

                var expire_datetime = response.expiry_datetime;
                if(expire_datetime != 'N/A'){
                    // alert("Expire Date: " + expire_datetime);
                    var expire_date = expire_datetime.split(' ')[0];
                    var expire_time = expire_datetime.split(' ')[1];

                    $("#subscription_date").val(expire_date);
                    $("#subscription_time").val(expire_time);
                }

                $("#hide_customer_id").val(response.customer_id);
                $("#p_sub_details").html(sub_details);
                $("#p_sub_dates").html(sub_dates);
                $("#hide_subscription_id").val(response.subscription_id);
                $("#cmb_status").val(response.status);

                //reset
                $("#reset_customer_id").val(response.customer_id);
                $("#reset_subscription_id").val(response.subscription_id);
                $("#status_subscription_id").val(response.subscription_id);
                $("#mac_address").val(response.mac_address);
                $("#cmb_status").val(response.status);

                //cancel
                $("#cancel_subscriptionID").val(response.subscription_id);
                $("#cancel_macAddress").val(response.mac_address);

                //enable, disable cancel button => running subscription only
                response.status == 2 ? $("#btn_cancel_subscription").attr('disabled', false) : $("#btn_cancel_subscription").attr('disabled', true);
            
            }
        });
    });

    //close edit modal
    $("#btn_close_edit_modal").click(function(){
        $("#subs_edit_modal").modal('hide');
    });

    //open camp change modal
    $("#tbl_subscription").on('click', '.btn_open_change', function(){
        let row = $(this).closest('tr');
	    let id = row.data('id');

        $("#camp_change_modal").modal('toggle');

        $.ajax({
            type: "get",
            url: "/getOneSubscription",
            data: {
                subscription_id: id,
            },
            // dataType: "dataType",
            success: function (response) {
                // console.log(response);
                $("#hide_change_subscription_id").val(response.subscription_id);
                $("#cmb_camp").val(response.camp_id);

                var sub_details = "Camp: <b>"+ response.camp_name +"</b><br>Customer: <b>"+ response.customer_name +"</b><br>Username: <b>"+ response.username +"</b><br>Package: <b>"+ response.package_name +"</b><br>Price: <b>"+response.package_price+"</b><br>Date: <b>"+response.purchase_date+"</b><br>";


                $("#p_change_sub_details").html(sub_details);
            }
        });
    });

    $("#btn_close_camp_change").click(function(){
        $("#camp_change_modal").modal('hide');
    });

});//subscription jquery
