$(document).ready(function () {
    //For multi select type and options
    function check_selected_type() {
        if ($('#type').children("option:selected").val() === "5") {
            $('#options_label').removeAttr('hidden');
            $('#options_div').removeAttr('hidden');
        } else {
            $('#options_label').attr('hidden', 'true');
            $('#options_div').attr('hidden', 'true');
        }
    }

    check_selected_type();

    //For default value
    function check_selected_type_for_default_value() {
        if ($('#type').children("option:selected").val() === "2") // Number
        {
            $('#normal_default').attr('hidden', 'true');
            $('#number_default').removeAttr('hidden');
            $('#decimal_default').attr('hidden', 'true');
            $('#date_default').attr('hidden', 'true');

            $('#normal_default_input').attr('name', '');
            $('#number_default_input').attr('name', 'default_value');
            $('#decimal_default_input').attr('name', '');
            $('#date_default_input').attr('name', '');

            $('#normal_default_input').val("");
            $('#decimal_default_input').val("");
            $('#date_default_input').val("");
        } else if ($('#type').children("option:selected").val() === "3") // Decimal
        {
            $('#normal_default').attr('hidden', 'true');
            $('#number_default').attr('hidden', 'true');
            $('#decimal_default').removeAttr('hidden');
            $('#date_default').attr('hidden', 'true');

            $('#normal_default_input').attr('name', '');
            $('#number_default_input').attr('name', '');
            $('#decimal_default_input').attr('name', 'default_value');
            $('#date_default_input').attr('name', '');

            $('#normal_default_input').val("");
            $('#number_default_input').val("");
            $('#date_default_input').val("");
        } else if ($('#type').children("option:selected").val() === "4")  //Date
        {
            $('#normal_default').attr('hidden', 'true');
            $('#number_default').attr('hidden', 'true');
            $('#decimal_default').attr('hidden', 'true');
            $('#date_default').removeAttr('hidden');

            $('#normal_default_input').attr('name', '');
            $('#number_default_input').attr('name', '');
            $('#decimal_default_input').attr('name', '');
            $('#date_default_input').attr('name', 'default_value');

            $('#normal_default_input').val("");
            $('#number_default_input').val("");
            $('#decimal_default_input').val("");
        } else // Others
        {
            $('#normal_default').removeAttr('hidden');
            $('#number_default').attr('hidden', 'true');
            $('#decimal_default').attr('hidden', 'true');
            $('#date_default').attr('hidden', 'true');

            $('#normal_default_input').attr('name', 'default_value');
            $('#number_default_input').attr('name', '');
            $('#decimal_default_input').attr('name', '');
            $('#date_default_input').attr('name', '');

            $('#number_default_input').val("");
            $('#decimal_default_input').val("");
            $('#date_default_input').val("");
        }
    }

    check_selected_type_for_default_value();

    //Check type when change
    $("#type").change(function () {
        check_selected_type();
        check_selected_type_for_default_value();
    });

    // Prevent enter key from submitting the form
    if ($('#tags').focus()) {
        $(window).keydown(function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                return false;
            }
        });
    }

});
