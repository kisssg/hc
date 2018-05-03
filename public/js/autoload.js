$(document)
    .ready(
        function () {
            $.datetimepicker.setLocale('ch');
            $(".datepicker").datetimepicker({
                format: 'Y-m-d',
                timepicker:false
            });
            
            $(".datetimepicker").datetimepicker({
                format: 'Y-m-d H:i:s'
            });

        });