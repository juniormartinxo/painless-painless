$(document).ready(function () {
    $('#btnLogar').click(function (e) {
        let user = $('#iptLogin').val();
        let pass = $('#iptPassword').val();
        let url  = JS_PATH_WEB + '/auth/login';

        icoSpinner('#message');

        $.post(
            url,
            {
                user: user,
                pass: pass
            },
            function (data) {
                let msg, obj, sts;

                if (isJson(data)) {
                    obj = JSON.parse(data);

                    msg = obj.message;
                    sts = obj.status;
                } else {
                    msg = data;
                    sts = 'error';
                }

                if (sts === 'success') {
                    window.location.href = JS_PATH_WEB + '/index';
                } else {
                    alertMessage('#message', msg, 'danger', '', 5000);
                }
            }
        );

        e.preventDefault();
    });

    $('#btnEnviar').click(function (e) {
        let email = $('#iptEmail').val();
        let url   = JS_PATH_WEB + '/password/recover/send';

        icoSpinner('#message');

        $.post(
            url,
            {
                email: email
            },
            function (data) {
                alertMessage('#message', data, 'danger', '', 5000);
            }
        );

        e.preventDefault();
    });
});