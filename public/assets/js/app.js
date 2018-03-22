// Sweet alert messages
function successAlert(message) {
    swal({
        title: "Success!",
        text: message,
        icon: "success",
        button: "Thanks"
    });
}

function warningAlert(message) {
    swal({
        title: "Oops!",
        text: message,
        icon: "warning",
        button: "Thanks"
    });
}

$(function() {
    $("#contactUs").submit(function(e) {
        e.preventDefault();
        var data = $(this).serializeFormJSON();
        if(data.name && data.email && data.subject && data.purpose && data.message) {
            $.ajax({
                url: '/contact-us',
                type: 'post',
                dataType: 'json',
                data: data,
                success: function(response) {
                    if(response.success) {
                        successAlert(response.message)
                    } else {
                        warningAlert(response.message)
                    }
                },
                error: function (err) {
                    warningAlert('Something went wrong! Please try later')
                }
            });
        } else {
            warningAlert('All field is required')
        }
    });
    $.fn.serializeFormJSON = function () {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
});