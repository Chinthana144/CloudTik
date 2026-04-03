$(document).ready(function () {
    $("#btn_fetch_any").click(function (e) {
        e.preventDefault();
        let query = $("#fetch_any_query").val();

        $.ajax({
            type: "get",
            url: "/fetchAnyQuery",
            data: {
                query: query
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);

            }
        });
    });

    $("#btn_get_identity").click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "/getIdentity",
            // data: "data",
            // dataType: "dataType",
            success: function (response) {
                console.log(response);

            }
        });
    });

    $("#btn_get_connection").click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "/getConnection",
            // data: "data",
            // dataType: "dataType",
            success: function (response) {
                console.log(response);

            }
        });
    });

    $("#btn_dhcp_lease").click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "/getDhcpLease",
            // data: "data",
            // dataType: "dataType",
            success: function (response) {
                console.log(response);

            }
        });
    });

    $("#btn_hotspot_active").click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "/getHotspotActive",
            // data: "data",
            // dataType: "dataType",
            success: function (response) {
                console.log(response);
            }
        });
    });

    $("#btn_hotspot_user").click(function (e) {
        e.preventDefault();
        let username = $("#txt_username").val();

        $.ajax({
            type: "get",
            url: "/getHotspotUser",
            data: {
                username: username
            },
            // dataType: "dataType",
            success: function (response) {
                console.log(response);

            }
        });
    });

});//mikrotik status jQuery
