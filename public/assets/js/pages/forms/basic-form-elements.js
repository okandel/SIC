$(function () {
    //Textare auto growth
    autosize($('textarea.auto-growth'));

    var dateFormat='YYYY-MM-DD';
    var timeFormat='HH:mm:ss';

    //Datetimepicker plugin
    $('.datetimepicker').bootstrapMaterialDatePicker({
        format: dateFormat + ' ' + timeFormat,
        clearButton: true,
        weekStart: 1
    });

    $('.datepicker').bootstrapMaterialDatePicker({
        format: dateFormat,
        clearButton: true,
        weekStart: 1,
        time: false
    });

    $('.timepicker').bootstrapMaterialDatePicker({
        format: timeFormat,
        clearButton: true,
        date: false
    });
});