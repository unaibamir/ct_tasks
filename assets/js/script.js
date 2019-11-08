$( function() {
    var dateFormat = "mm/dd/yy",
        from = $( "#start_date" )
            .datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                minDate: new Date(),
                numberOfMonths: 1
            })
            .on( "change", function() {
                to.datepicker( "option", "minDate", getDate( this ) );
            }),
        to = $( "#end_date" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1
        })
        .on( "change", function() {
            from.datepicker( "option", "maxDate", getDate( this ) );
        });

    function getDate( element ) {
        var date;
        try {
            date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
            date = null;
        }

        return date;
    }


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
} );