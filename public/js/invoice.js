$(document).ready(function () {
    //initialize
    $("#btn_customer_history").css('display', 'none');
    $("#btn_add_subscription").attr('disabled', 'true');

    $("#cmb_customer").select2({
        placeholder: 'Search Customers',
        ajax:{
            // type: "method",
            url: "/getCustomers",
            dataType: "json",
            delay:250,
            data: function(params){
                return{
                    q: params.term
                };
            },
            processResults: function(data){
                return {
                    results: data.map(customer => ({
                        id: customer.id,
                        text: customer.username + ' - ' + customer.phone
                    }))
                };
            },
        },
        cache: true,
        minimumInputLength: 1,
    });
});//invoice jQuery

$("#cmb_customer").change(function () {
    var customer_id = $(this).val();

    $.ajax({
        type: "get",
        url: "/getOneCustomer",
        data: {
            id: customer_id
        },
        // dataType: "dataType",
        success: function (response) {
            // alert(response['name']);
            // console.log(response);
            var customer_fullname = response['fullname'];
            var customer_username = response['username'];
            var customer_phone = response['phone'];

            var cust_data = "Fullname: <b>" + customer_fullname + "</b><br>" + "Username: <b>" + customer_username +"</b><br> Phone: <b>" + customer_phone + "</b>";

            $("#p_customer_details").html(cust_data);

            $("#btn_customer_history").css('display', 'block');
        }

    });

    var package_data = "<option value='0'>Select Package</option>";
    $.ajax({
        type: "get",
        url: "/getCustomerPackages",
        data: {
            id: customer_id,
        },
        success: function (response) {
            $.each(response, function (key, value) {
                package_data += "<option value='"+value['id']+"'>Name: "+value['name']+" | "+value['duration']+"(days) | Price: "+value['price']+" AED</option>";
            });

            $("#cmb_packages").empty();
            $("#cmb_packages").append(package_data);
        }
    });
});

$("#cmb_packages").change(function () {
    //check values
    var package_id = $("#cmb_packages").val();

    if(package_id > 0)
    {
        var customer_id = $("#cmb_customer").val();
        var package_id = $("#cmb_packages").val();

        $("#hide_customer_id").val(customer_id);
        $("#hide_package_id").val(package_id);
        $("#btn_add_subscription").attr('disabled', false);
    }
    else
    {
        $("#btn_add_subscription").attr('disabled', true);
    }
});

$("#frm_subscription").submit(function (e) {
    e.preventDefault();
    var customer_id = $("#hide_customer_id").val();
    var package_id = $("#hide_package_id").val();

    var counter_id = $("#hide_counter_id").val();

    $.ajax({
        type: "post",
        url: "/store-subscription",
        data: $(this).serialize(),
        // dataType: "dataType",
        success: function (response) {
            console.log(response);
        }
    });
});
