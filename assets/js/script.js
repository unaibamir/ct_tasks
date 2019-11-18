$( function() {

    $('#table-list').DataTable();

    var dateformat = "dd/mm/yy";
    
    var from = $( "#start_date" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        dateFormat: dateformat,
        minDate: new Date(),
        numberOfMonths: 1
    })
    .on( "change", function() {
        to.datepicker( "option", "minDate", getDate( this ) );
    });

    var to = $( "#end_date" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        dateFormat: dateformat,
        numberOfMonths: 1
    })
    .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
    });

    function getDate( element ) {
        var date;
        try {
            date = $.datepicker.parseDate( dateformat, element.value );
        } catch( error ) {
            date = null;
        }

        return date;
    }


    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd-mm-yy",
        maxDate: new Date()
    });


    $("#department").on("change", function(event){
        var dept_id = $(this).val();

        if( dept_id != "" && dept_id != "Select Department" ) {
            var url = base_url + "user/getdepartmentusers/" + dept_id;
            var assignee = $("#assignee");
            $.ajax({url: url, success: function(result){
                result  = JSON.parse(result);

                if( result.status ) {
                    assignee.find('option').remove();
                    $.each(result.data, function( index, value ){
                        assignee.append( new Option( value.name, value.id ) );
                    });
                }
            }});
        }
    });

    $("#report-file").change(function(e){
        var uploaded_file = e.target.files[0];
        if( typeof uploaded_file != "undefined" ) {
            var fileName = e.target.files[0].name;
            $("#report-file-label").html( fileName );
        }
    });


    $(".task-report-status input:radio[name='status']").on("change", function(event){
    if ($(this).is(':checked')) {
        var status = $(this).val();

        /*if ( status != "Y" ) {
            $(".task-report-reason").show();
            $(".task-report-reason textarea").prop("required", true);
        } else {
            $(".task-report-reason").hide();
            $(".task-report-reason textarea").prop("required", false);
        }*/


        if( status == "Y" ) {
            $(".task-report-reason textarea").prop("required", false);
            $(".task-report-reason").hide();

            $("#before textarea, #after textarea").prop("required", true);
            $("#before, #after").show();
        }
        else if( status == "N" || status == "H" || status == "C" ) {

            $("#before textarea, #after textarea").prop("required", false);
            $("#before, #after").hide();

            $(".task-report-reason textarea").prop("required", true);
            $(".task-report-reason").show();

        } else if( status == "F" ) {
            $(".task-report-reason textarea").prop("required", true);
            $(".task-report-reason").show();

            $("#before textarea, #after textarea").prop("required", true);
            $("#before, #after").show();
        }
    }
});

});