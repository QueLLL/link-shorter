$(document).ready(function() {
    $('#short').on('click',function() {
        var link = $('#link').val();
        $.post("/handle", {link: link}, function (data) {
            $('#response').text('');
            var response = $.parseJSON(data);
            if (response.result == 'ok') {
                $('#response').append(" <a href=\"\" id=\"result\"></a>");
                $('#result').text(response.link);
                $('#result').attr("href", response.link);
                $('#link').val('');
            } else if (response.result == 'error'){
                    if (response.errNo == '1') {
                        $('#response').append("<div class=\"alert alert-danger\" role=\"alert\"></div>");
                        $('.alert-danger').text('Некорректно указана ссылка');
                    }
            }

        });
    });
});