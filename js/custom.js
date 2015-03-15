/**
 * Created by elyaet on 16/03/15.
 */
$('#datepicker').datepicker({
    format: "dd/mm/yyyy",
    todayHighlight: true,
    beforeShowDay: function (date){
        if (date.getMonth() == (new Date()).getMonth())
            switch (date.getDate()){
                case 4:
                    return {
                        tooltip: 'Example tooltip',
                        classes: 'active'
                    };
                case 8:
                    return false;
                case 12:
                    return "green";
            }
    }
});