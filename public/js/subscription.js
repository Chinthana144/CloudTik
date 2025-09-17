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
            }
        });
    });

    //close edit modal
    $("#btn_close_edit_modal").click(function(){
        $("#subs_edit_modal").modal('hide');
    });

    $("#frm_update_stat").submit(function(e){
        e.preventDefault();

        var subscription_id = $("#hide_subscription_id").val();
        var status_id = $("#cmb_status").val();

        $.ajax({
            type: "post",
            url: "/updateSubsStatus",
            data: $(this).serialize(),
            // dataType: "dataType",
            success: function (response) {
                // console.log(response);
                // alert('working');
                location.reload();
            }
        });
    });
});//subscription jquery
