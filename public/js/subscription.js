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

                var sub_details = "Customer : " + response.customer_name + "<br>Username: " + response.username + "<br>Package: " + response.package_name + "<br>Duration: " + response.package_duration;

                $("#p_sub_details").html(sub_details);
                $("#hide_subscription_id").val(response.subscription_id);
                $("#cmb_status").val(response.status);
            }
        });
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
