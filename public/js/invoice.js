$(document).ready(function () {
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

            var cust_data = "Fullname: " + customer_fullname + "<br>" + "Username: " + customer_username +"<br> Phone: " + customer_phone;

            $("#p_customer_details").html(cust_data);
        }
    });
});
