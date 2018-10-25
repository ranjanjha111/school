$(function() {
    $('body').on('click', '.pagination a', function(e) {
        console.log("clicked...");
        e.preventDefault();

        $('.x_content a').css('color', '#dfecf6');
        $('.x_content').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="" />');

        var url = $(this).attr('href');
        getActivity(url);
        // window.history.pushState("", "", url);
    });
    function getActivity(url) {
        $.ajax({
            url : url
        }).done(function (data) {
            $('.x_panel').html(data);
        }).fail(function () {
            alert('Data could not be loaded.');
        });
    }

    /*
     * Set number of row list on a page.
     */
    $('body').on('change', '.number_of_records', function(e) {
        e.preventDefault();

        $('.x_content').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="" />');

        var pathname = $(location).attr('pathname'); // Returns path only
        var url      = $(location).attr('href');     // Returns full URL
        var host    = $(location).attr('origin');   // Return host

        var records     = $(".number_of_records").val();
        $.ajax({
            url : host + pathname,
            type: "GET",
            data: { 'recordPerPage': records},
            dataType: "html",
        }).done(function (data) {
            $('.x_panel').html(data);
        }).fail(function () {
            alert('Data could not be loaded.');
        });

        window.history.pushState("", "", url);
    });


    /*
     * Search activity by name.
     */
    $("#search").keyup(function(e) {
        e.preventDefault();
        var url      = $(location).attr('href');
        var search     = $("#search").val();

        $.ajax({
            url : url,
            type: "GET",
            data: { 'search': search},
            dataType: "html",
        }).done(function (data) {
            $('.x_panel').html(data);
        }).fail(function (error) {
            console.log(error);
            // alert('Data could not be loaded.');
        });

        window.history.pushState("", "", url);
    });


    /*
     * View item.
     */
    $('body').on('click', '.viewBtn', function(e) {
        e.preventDefault();

        var modalClass  = $(this).attr('view-modal-class');
        var id          = $(this).attr('view-id');
        var url         = $(location).attr('origin') + $(location).attr('pathname') + '/' + id;

        $.ajax({
            url : url,
            type: "GET",
            dataType: "html",
            data: { 'modalClass': modalClass}
        }).done(function (data) {
            if($('#viewModal').length) {
                $('#viewModal').remove();
            }
            $('.x_content').after(data);
            $('.' + modalClass).modal('toggle');
        }).fail(function (error) {
            console.log(error.responseText);
            alert('Data could not be loaded.');
        });
    });


    /*
     * Toggle Delete Modal.
     */
    $('body').on('click', '.deleteBtn', function(e) {
        var modalClass    = $(this).attr('delete-modal-class');
        $('.' + modalClass).modal('toggle');
    });


    /*
     * Get city list on state change.
     */
    $('body').on('change', '#state', function(e) {
        e.preventDefault();

/*
        console.log(baseUrl);
        console.log(adminBaseUrl);
        console.log(apiBaseUrl);
*/
        var stateId = $(this).val();

        $.ajax({
            url : apiBaseUrl + '/cities',
            type: "POST",
            dataType: "JSON",
            data: { 'state_id': stateId}
        }).done(function (json) {
            $("#city").find('option').remove().end().append('<option value="0">Please select a city</option>');
            $.each(json.data, function(i, value) {
                $('#city').append($('<option>').text(value).attr('value', i));
            });
        }).fail(function (error) {
            alert('Data could not be loaded.');
        });
    });






});